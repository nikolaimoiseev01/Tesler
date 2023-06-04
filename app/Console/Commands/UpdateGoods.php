<?php

namespace App\Console\Commands;

use App\Models\Good;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateGoods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-goods';

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

        foreach ($yc_goods as $yc_good) { // Идем по всем услугам YCLIENTS
            $good_found = Good::where('yc_id', $yc_good['good_id'])->first();
            if ($good_found ?? null) { // Если есть такой товар
                $storage_id_key = array_search(ENV('YCLIENTS_SHOP_STORAGE'), array_column($yc_good['actual_amounts'], 'storage_id'));
                $yc_actual_amounts = $yc_good['actual_amounts'][$storage_id_key]['amount'] ?? null;


                if ($good_found['name'] <> $yc_good['title'] || $good_found['yc_price'] <> $yc_good['cost'] || $good_found['yc_category'] <> $yc_good['category'] || $good_found['yc_actual_amount'] <> $yc_actual_amounts) {

                    $good_found->update([
                        'yc_title' => $yc_good['title'],
                        'yc_price' => $yc_good['cost'],
                        'yc_category' => $yc_good['category'],
                        'yc_actual_amount' => $yc_actual_amounts,
                        'name' => $yc_good['title'],
                    ]);
                }
            }




        }
        dd('Goods Updated Success!');
    }
}
