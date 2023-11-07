<?php

namespace App\Console\Commands;

use App\Models\Staff;
use App\Models\User;
use App\Notifications\MailNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class StuffUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateStaff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];


        $yc_staffs = Http::withHeaders($YCLIENTS_HEADERS)
            ->get('https://api.yclients.com/api/v1/company/' . $YCLIENTS_SHOP_ID . '/staff/')
            ->collect()['data'];
        $yc_staffs = array_values(Arr::where($yc_staffs, function ($value, $key) {
            return $value['fired'] == 0;
        })); // Только неуволенных сотрудников


        $this->found_yc_staffs = null;
        $deleted_staff = [];
        $created_staff = [];

        foreach ($yc_staffs as $yc_staff) { // Идем по всем сотрудникам YCLIENTS
            $staff_found = Staff::where('yc_id', $yc_staff['id'])->first();

            if (isset($staff_found) ? $staff_found : null) { // Если есть в системе
                if ($yc_staff['fired'] == 1) { // Если сотрудник уволен удаляем его
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
                }
            } else { // Если сотрудника нет в системе
                array_push($created_staff, $yc_staff['name']);
                staff::create([
                    'yc_id' => $yc_staff['id'],
                    'yc_name' => $yc_staff['name'],
                    'yc_avatar' => $yc_staff['avatar_big'],
                    'yc_position' => $yc_staff['position']['title'] ?? '',
                    'yc_specialization' => $yc_staff['specialization'],
                ]);
            }
        }

        $users = User::all();
        $deleted_staff = count($deleted_staff);
        $created_staff = count($created_staff);
        foreach ($users as $user) {
            $user->notify(new MailNotification(
                'Успешно обновили всех мастеров!',
                "Все мастера на сайте были синхронизированы с YClients. Удалено уволенных: {$deleted_staff}; Добавлено новых: {$created_staff}; Об остальных обновлена информация.",
                "Подробнее",
                route('staff.index')
            ));
        }

    }
}
