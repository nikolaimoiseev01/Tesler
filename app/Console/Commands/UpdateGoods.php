<?php

namespace App\Console\Commands;

use App\Models\Good;
use App\Models\User;
use App\Notifications\MailNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateGoods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateGoods';

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


        $yc_goods = [];
        $changed_after = '2020-01-05T12:00:00';
        for ($page = 0; $page <= 200; $page++) {

            // Подгружаем товары на продажу
//            $link = 'https://api.yclients.com/api/v1/goods/' . $YCLIENTS_SHOP_ID . '?count=100&changed_after=' . $changed_after . '&page=' . $page . '&category_id=481179';
            $link = 'https://api.yclients.com/api/v1/goods/' . $YCLIENTS_SHOP_ID . '?count=100&changed_after=' . $changed_after . '&page=' . $page;
            $request = Http::withHeaders($YCLIENTS_HEADERS)
                ->get($link)
                ->collect();

            if ($request['data'] ?? null) {
                $yc_goods = array_merge($yc_goods, $request['data']);
            } else {
                break;
            }
        }


        $this->found_yc_goods = null;
        $updated_goods = [];
        $created_goods = [];

        foreach ($yc_goods as $yc_good) { // Идем по всем товарам YCLIENTS
            $good_found = Good::where('yc_id', $yc_good['good_id'])->first();
            $storage_id_key = array_search(ENV('YCLIENTS_SHOP_STORAGE'), array_column($yc_good['actual_amounts'], 'storage_id'));
            $yc_actual_amounts = $yc_good['actual_amounts'][$storage_id_key]['amount'] ?? null;

            if ($good_found ?? null) { // Если есть такой товар
                if ($good_found['name'] <> $yc_good['title'] || $good_found['yc_price'] <> $yc_good['cost'] || $good_found['yc_category'] <> $yc_good['category'] || $good_found['yc_actual_amount'] <> $yc_actual_amounts) {

                    array_push($updated_goods, $yc_good['title']);
                    $good_found->update([
                        'yc_title' => $yc_good['title'],
                        'yc_price' => $yc_good['cost'],
                        'yc_category' => $yc_good['category'],
                        'yc_actual_amount' => $yc_actual_amounts,
                        'name' => $yc_good['title'],
                    ]);
                }
            } else { // Если нет такого товара
                $this->found_yc_goods[] = [
                    'yc_id' => $yc_good['good_id'],
                    'yc_title' => $yc_good['title'],
                    'yc_price' => $yc_good['cost'],
                    'yc_category' => $yc_good['category'],
                    'yc_actual_amount' => $yc_actual_amounts,
                    'last_change_date' => substr($yc_good['last_change_date'], 0, 10),
                    'yc_active' => 0
                ];
            }
        }

        // Берем только уникальные из новых
        $unique_array = [];
        if ($this->found_yc_goods ?? null) {
            foreach ($this->found_yc_goods as $element) {
                $hash = $element['yc_id'];
                $unique_array[$hash] = $element;
            }
            $this->found_yc_goods = array_values($unique_array);
        }

        if($this->found_yc_goods ?? null) {
            foreach ($this->found_yc_goods as $found_yc_good) {

                array_push($created_goods, $found_yc_good['yc_title']);

                Good::create([
                    'yc_id' => $found_yc_good['yc_id'],
                    'yc_title' => $found_yc_good['yc_title'],
                    'yc_price' => $found_yc_good['yc_price'],
                    'yc_category' => $found_yc_good['yc_category'],
                    'yc_actual_amount' => $found_yc_good['yc_actual_amount'],
                    'flg_active' => 0,
                    'name' => $found_yc_good['yc_title'],
                ]);
            }
        }


        $user = User::where('id', 1)->first();
        $user->notify(new MailNotification(
            'Успешно обновили все товары!',
            "Все товары на сайте были синхронизированы с YClients. Добавлено товаров: " . count($created_goods) . "; Обновлено товаров: " . count($updated_goods) . ".",
            "Подробнее",
            route('good.index')
        ));
    }
}
