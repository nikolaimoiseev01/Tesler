<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Models\User;
use App\Notifications\MailNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ServiceUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateService';

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

        $yc_services = Http::withHeaders($YCLIENTS_HEADERS)
            ->get('https://api.yclients.com/api/v1/company/' . $YCLIENTS_SHOP_ID . '/services/')
            ->collect();

        $this->found_yc_services = null;

        $yc_services['data'] = array_values(Arr::where($yc_services['data'], function ($value, $key) {
            return $value['active'] == 1; // Берем только активный в YClients услуги
        }));

        $created_services = [];

        foreach ($yc_services['data'] as $yc_service) { // Идем по всем услугам YCLIENTS
            $service_found = Service::where('yc_id', $yc_service['id'])->first();
            $yc_service_category = Http::withHeaders($YCLIENTS_HEADERS)
                ->get('https://api.yclients.com/api/v1/service_category/' . $YCLIENTS_SHOP_ID . '/' . $yc_service['category_id'])
                ->collect();
            if ($yc_service_category['data']['title'] ?? null) {
                $yc_service_category = $yc_service_category['data']['title'];
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
            }
        }

        $user = User::where('id', 1)->first();
        $created_services = count($created_services);
        $user->notify(new MailNotification(
            'Успешно обновили все услуги!',
            "Все услуги на сайте были синхронизированы с YClients. Добавлено новых: {$created_services}; Об остальных обновлена информация.",
            "Подробнее",
            route('staff.index')
        ));
    }
}
