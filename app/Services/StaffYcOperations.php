<?php /** @noinspection ALL */

namespace App\Services;

use Illuminate\Support\Facades\Notification;
use App\Models\RefreshLog;
use App\Models\Staff;
use App\Models\User;
use App\Notifications\MailNotification;
use App\Notifications\TelegramNotification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class StaffYcOperations
{

    public function makeStaff() {
        // Отдельно сохраняем услуги каждого филиала
        $yc_shops = config('cons.yc_shops');
        $yc_staffs_comp_1 = (new YcApiRequest)->make_request('company', 'staff', $yc_shops[0]);
        $yc_staffs_comp_2 = (new YcApiRequest)->make_request('company', 'staff', $yc_shops[1]);

        $mergedArray = [];
        $idMap = [];

        // Проставляем флаги для 1 филиала
        foreach ($yc_staffs_comp_1 as $item) {
            $id = $item['id'];
            $item['flg_1'] = true;
            $item['flg_2'] = false;
            $mergedArray[$id] = $item;
            $idMap[$id] = 1;
        }

        // Проставлем остальные флаги.
        foreach ($yc_staffs_comp_2 as $item) {
            $id = $item['id'];
            if (isset($mergedArray[$id])) {
                $mergedArray[$id]['flg_2'] = true;
            } else {
                $item['flg_1'] = false;
                $item['flg_2'] = true;
                $mergedArray[$id] = $item;
            }
            $idMap[$id] = 1;
        }

        // Берем уникальные ID
        $this->yc_staffs = array_values($mergedArray);

    }
    public function refreshAll()
    {



        DB::transaction(function () { // Чтобы не записать ненужного

            $this->makeStaff();

//            foreach ($this->yc_staffs as $item) {
//                if($item['id'] == 3456895) {
//                    dd($item);
//                }
//            }


           $this->yc_staffs = array_values(Arr::where($this->yc_staffs, function ($value, $key) {
                return $value['fired'] == 0;
            })); // Только неуволенных сотрудников


            $this->found_yc_staffs = null;
            $deleted_staff = [];
            $created_staff = [];

            // Понимаем, кто есть в нашей системе, но уже удален из YClients
            $our_staffs = Staff::all()->toArray();

            $this->yc_staffs_ids = array_column($this->yc_staffs, 'id');
            $our_staffs_ids = array_column($our_staffs, 'yc_id');

            $missingIds = array_diff($our_staffs_ids, $this->yc_staffs_ids);

            if ($missingIds) { // Удаляем из нашей системы тех, кого нет в YClients

                foreach ($missingIds as $yc_id) { // Записываем в историю уволенных
                    $staff = Staff::where('yc_id', $yc_id)->first();
                    $description['Были в нашей системе, но на момент обновления не были в YClients. Удалили их'][] = [
                        'id' => $staff['id'],
                        'yc_id' => $staff['yc_id'],
                        'name' => $staff['yc_name'],
                        'specialization' => $staff['yc_specialization']
                    ];
                }

                // Преобразовываем массив id в строку для использования в SQL запросе
                $idsString = implode(',', $missingIds);

                $sql = "DELETE FROM staff WHERE yc_id IN ($idsString)";

                // Выполняем запрос на удаление строк из базы данных
                DB::delete($sql);
            }

            foreach ($this->yc_staffs as $yc_staff) { // Идем по всем сотрудникам YCLIENTS

                $staff_found = Staff::where('yc_id', $yc_staff['id'])->first();

                if (isset($staff_found) ? $staff_found : null) { // Если есть в системе
                    if ($yc_staff['fired'] == 1) { // Если сотрудник уволен удаляем его

                        $description['2. Были в нашей системе, но на момент обновления были в статусе уволенных в YClients. Удалили их'][] = [
                            'id' => $staff_found['id'],
                            'yc_id' => $staff_found['yc_id'],
                            'name' => $staff_found['yc_name'],
                            'specialization' => $staff_found['yc_specialization']
                        ];

                        array_push($deleted_staff, $yc_staff['name']);
                        $staff_found->delete();

                    } else { // Если не уволен, обновляем информацию

                        $staff_found->update([
                            'yc_id' => $yc_staff['id'],
                            'yc_name' => $yc_staff['name'],
                            'yc_avatar' => $yc_staff['avatar_big'],
                            'yc_position' => $yc_staff['position']['title'] ?? 'Другое',
                            'yc_specialization' => $yc_staff['specialization'],
                        ]);

                        $description['3. Обновили информацию по ним'][] = [
                            'id' => $staff_found['id'],
                            'yc_id' => $staff_found['yc_id'],
                            'name' => $staff_found['yc_name'],
                            'specialization' => $staff_found['yc_specialization']
                        ];

                    }
                } else { // Если сотрудника нет в системе

                    $staff_created = staff::firstOrCreate(
                        ['yc_name' => $yc_staff['name']], // Условие для поиска существующей записи
                        [
                            'yc_id' => $yc_staff['id'],
                            'yc_avatar' => $yc_staff['avatar_big'],
                            'yc_position' => $yc_staff['position']['title'] ?? '',
                            'yc_specialization' => $yc_staff['specialization'],
                        ]
                    );

                    // Проверяем, была ли запись создана
                    if ($staff_created->wasRecentlyCreated) {
                        array_push($created_staff, $yc_staff['name']);
                        $description['1. Добавили новых из YClients'][] = [
                            'yc_id' => $yc_staff['id'],
                            'name' => $yc_staff['name'],
                            'specialization' => $yc_staff['specialization']
                        ];
                    };
                }
            }

            $deleted_staff = count($deleted_staff) + count($missingIds);
            $created_staff = count($created_staff);
            $title = '📡 Успешно обновили всех мастеров! 📡';
            $text = "Все мастера на сайте были синхронизированы с YClients. \n Удалено уволенных: *{$deleted_staff}* \n Добавлено новых: *{$created_staff}* \n Об остальных обновлена информация.";

            RefreshLog::create([
                'model' => 'Сотрудники',
                'type' => 'Синхронизация с YClients',
                'summary' => $text,
                'description' => json_encode($description) ?? 'Не нашли, что можно сделать'
            ]);

            // Посылаем Telegram уведомление нам
            Notification::route('telegram', config('app.telegram_chat_id'))
                ->notify(new TelegramNotification($title, $text, null, null));

        });
    }
}
