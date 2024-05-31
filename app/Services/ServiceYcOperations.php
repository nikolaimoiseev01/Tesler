<?php

namespace App\Services;

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
    public function refreshAll()
    {

        DB::transaction(function () { // Чтобы не записать ненужного

            $yc_services = (new YcApiRequest)->make_request('company', 'services');

            $this->found_yc_services = null;

            $yc_services = array_values(Arr::where($yc_services, function ($value, $key) {
                return $value['active'] == 1; // Берем только активный в YClients услуги
            }));

            $created_services = [];

            foreach ($yc_services as $yc_service) { // Идем по всем услугам YCLIENTS
                $service_found = Service::where('yc_id', $yc_service['id'])->first();

                $yc_service_category = (new YcApiRequest)->make_request('service_category', $yc_service['category_id']);

                if ($yc_service_category['title'] ?? null) {
                    $yc_service_category = $yc_service_category['title'];
                } else {
                    $yc_service_category = null;
                }

                if ($service_found ?? null) { // Если есть такая услуга

                    $service_found->update([
                        'yc_title' => $yc_service['title'],
                        'yc_comment' => $yc_service['comment'],
                        'yc_price_min' => $yc_service['price_min'],
                        'yc_price_max' => $yc_service['price_max'],
                        'yc_duration' => $yc_service['duration'],
                        'yc_category_name' => $yc_service_category,
                        'name' => $yc_service['title'],
                    ]);

                    $description['Обновили инфо из YClients'][] = [
                        'yc_id' => $yc_service['id'],
                        'title' => $yc_service['title'],
                    ];


                } else { // Если нет такой услуги
                    array_push($created_services, $yc_service['title']);
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
                    ]);

                    $description['Добавили новых из YClients'][] = [
                        'yc_id' => $yc_service['id'],
                        'title' => $yc_service['title'],
                    ];


                }
            }

            $created_services = count($created_services);
            $title = '📡 Успешно обновили все услуги! 📡';
            $text = "Все услуги на сайте были синхронизированы с YClients. Добавлено новых: *{$created_services}* \nОб остальных обновлена информация.";


            RefreshLog::create([
                'model' => 'Услуги',
                'type' => 'Синхронизация с YClients',
                'summary' => $text,
                'description' => json_encode($description) ?? 'Не нашли, что можно сделать'
            ]);


            // Посылаем Telegram уведомление нам
            \Illuminate\Support\Facades\Notification::route('telegram', env('TELEGRAM_CHAT_ID'))
                ->notify(new TelegramNotification($title, $text, null, null));

        });
    }
}
