<?php

namespace App\Services;

use App\Models\Calculators\CalcHair;
use App\Models\RefreshLog;
use App\Models\Service\Service;
use App\Models\User;
use App\Notifications\MailNotification;
use App\Notifications\TelegramNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;

class ServiceYcOperations
{
    public $deleted_services;
    public $description;
    public $created_services;
    public $yc_services;

    public function update($services)
    {

        ini_set('max_execution_time', 3600);

        $service_api_data = (new YcApiRequest)->make_request('company', 'services');
        $ycIds = array_map(function ($item) { /* Какие ID есть в YClients? */
            return $item['id'];
        }, $service_api_data);
        // Фильтруем коллекцию. Оставляем в присланных только те, что есть в YClients
        $filteredServices = $services->filter(function ($service) use ($ycIds) {
            return in_array($service->yc_id, $ycIds);
        });

        if (count($filteredServices) > 0) {

            foreach ($services as $service) { /* Идем по каждой присланной услуге */
                $service_api_data = (new YcApiRequest)->make_request(
                    'company',
                    "services/{$service['yc_id']}
                    ");

                if ($service_api_data) { /* Если находим такую в YC Api */
                    /* Находим, какая категория у услуги в YC */
                    $category_api_data = (new YcApiRequest)->make_request(
                        'service_category',
                        "{$service['yc_id']}
                    ");
                    $yc_service_category = $category_api_data['title'] ?? null;

                    /* Обновляем всю услугу */

                    $service->update([
                        'yc_title' => $service_api_data['title'],
                        'yc_comment' => $service_api_data['comment'],
                        'yc_price_min' => $service_api_data['price_min'],
                        'yc_price_max' => $service_api_data['price_max'],
                        'yc_duration' => $service_api_data['duration'],
                        'yc_category_name' => $yc_service_category,
                        'name' => $service_api_data['title'],
                    ]);

                }
            };
            Notification::make()
                ->success()
                ->title(__('Данные из YClients успешно обновились'))
                ->send();
        } else {
            Notification::make()
                ->danger()
                ->title(__('Не нашли таких ID в Yclients'))
                ->send();
        }


    }

    public function CreateYcServices()
    {
        // Отдельно сохраняем услуги каждого филиала
        $yc_shops = config('cons.yc_shops');
        $yc_services_comp_1 = (new YcApiRequest)->make_request('company', 'services', $yc_shops[0]);
        $yc_services_comp_2 = (new YcApiRequest)->make_request('company', 'services', $yc_shops[1]);

        $mergedArray = [];
        $idMap = [];

        // Проставляем флаги для 1 филиала
        foreach ($yc_services_comp_1 as $item) {
            $id = $item['id'];
            $item['flg_1'] = true;
            $item['flg_2'] = false;
            $mergedArray[$id] = $item;
            $idMap[$id] = 1;
        }

        // Проставлем остальные флаги.
        foreach ($yc_services_comp_2 as $item) {
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
        $this->yc_services = array_values($mergedArray);

    }

    public function deleteUnused()
    {

        $our_services = Service::all();
        $this->deleted_services = 0;
        foreach ($our_services as $our_service) { // Идем по всем услугам НАШИМ

            // Получение столбца 'id' из массива
            $idColumn = array_column($this->yc_services, 'id');

            // Поиск ID в столбце 'id'
            $idExists = array_search($our_service['yc_id'], $idColumn) !== false;

            if (!$idExists) {  // ЕСЛИ В YC нет такой услуги
                $this->description['Удалили, потому что не нашли таких в YC'][] = [
                    'yc_id' => $our_service['yc_id'],
                    'title' => $our_service['title'],
                ];
                CalcHair::where('service_id', $our_service['id'])->delete();
                $our_service->delete();
                $this->deleted_services += 1;
            }

        }
    }


    public function CreateUpdate()
    {
        DB::transaction(function () { // Чтобы не записать ненужного

            $this->created_services = [];

            foreach ($this->yc_services as $yc_service) { // Идем по всем услугам YCLIENTS

                $service_found = Service::where('yc_id', $yc_service['id'])->first(); // Ищем такую у нас

                $yc_service_category = (new YcApiRequest)->make_request('service_category', $yc_service['category_id']);

                if ($yc_service_category['title'] ?? null) {
                    $yc_service_category = $yc_service_category['title'];
                } else {
                    $yc_service_category = null;
                }

                if ($service_found ?? null) { // Если есть такая услуга, то обновляем ее

                    $service_found->update([
                        'yc_title' => $yc_service['title'],
                        'yc_comment' => $yc_service['comment'],
                        'yc_price_min' => $yc_service['price_min'],
                        'yc_price_max' => $yc_service['price_max'],
                        'yc_duration' => $yc_service['duration'],
                        'yc_category_name' => $yc_service_category,
                        'name' => $yc_service['title'],
                        'flg_comp_1' => $yc_service['flg_1'],
                        'flg_comp_2' => $yc_service['flg_2']
                    ]);

                    if($service_found['flg_active'] ?? null) {
                        $service_found->update([
                            'flg_active' => $yc_service['active'],
                        ]);
                    }

                    $this->description['Обновили инфо из YClients'][] = [
                        'yc_id' => $yc_service['id'],
                        'title' => $yc_service['title'],
                    ];


                } else { // Если нет такой услуги, то создаем её
                    array_push($this->created_services, $yc_service['title']);
                    Service::create([
                        'yc_id' => $yc_service['id'],
                        'yc_title' => $yc_service['title'],
                        'yc_comment' => $yc_service['comment'],
                        'yc_price_min' => $yc_service['price_min'],
                        'yc_price_max' => $yc_service['price_max'],
                        'yc_duration' => $yc_service['duration'],
                        'yc_category_name' => $yc_service_category,
                        'flg_active' => 0,
                        'name' => $yc_service['title'],
                        'desc' => $yc_service['comment'],
                        'flg_comp_1' => $yc_service['flg_1'],
                        'flg_comp_2' => $yc_service['flg_2']
                    ]);

                    $this->description['Добавили новых из YClients'][] = [
                        'yc_id' => $yc_service['id'],
                        'title' => $yc_service['title'],
                    ];


                }
            }
        });
    }

    public function refreshAll()
    {

        $this->CreateYcServices();
        $this->CreateUpdate();
        $this->deleteUnused();

        $this->created_services = count($this->created_services);
        $title = '📡 Успешно обновили все услуги! 📡';
        $text = "Все услуги на сайте были синхронизированы с YClients. Добавлено новых: *{$this->created_services}* \nУдалено с сайта: *{$this->deleted_services}* \nОб остальных обновлена информация.";


        RefreshLog::create([
            'model' => 'Услуги',
            'type' => 'Синхронизация с YClients',
            'summary' => $text,
            'description' => json_encode($this->description) ?? 'Не нашли, что можно сделать'
        ]);


        // Посылаем Telegram уведомление нам
        \Illuminate\Support\Facades\Notification::route('telegram', env('TELEGRAM_CHAT_ID'))
            ->notify(new TelegramNotification($title, $text, null, null));

    }
}
