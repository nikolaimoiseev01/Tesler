<?php

namespace App\Services;


use App\Models\Good\Good;
use App\Models\RefreshLog;
use App\Models\User;
use App\Notifications\MailNotification;
use App\Notifications\TelegramNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GoodYcOperations
{
    public function refreshAll()
    {
        ini_set('max_execution_time', 3600);

        DB::transaction(function () { // Чтобы не записать ненужного

            $yc_goods = [];
            $changed_after = '2023-01-05T12:00:00';
            for ($page = 0; $page <= 10; $page++) {
                // Подгружаем товары на продажу
                $request = (new YcApiRequest)->make_request('goods', '?count=100&changed_after=' . $changed_after . '&page=' . $page);
                if ($request) {
                    $yc_goods = array_merge($yc_goods, $request);
                } else {
                    break;
                }
            }

            $desiredGoodId = 28701480;

            $filteredItems = array_filter($yc_goods, function($item) use ($desiredGoodId) {
                return $item['good_id'] == $desiredGoodId;
            });

            dd($filteredItems);


            dd($yc_goods[0]['actual_amounts']);

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

                        $description['Обновили инфо из YClients'][] = [
                            'yc_id' => $yc_good['good_id'],
                            'Название' => $yc_good['title'],
                            'Остаток на складе' => $yc_actual_amounts
                        ];

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

            if ($this->found_yc_goods ?? null) {
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

                    $description['Добавили новые товары из YClients'][] = [
                        'yc_id' => $found_yc_good['yc_id'],
                        'Название' => $found_yc_good['yc_title'],
                        'Остаток на складе' => $found_yc_good['yc_actual_amount']
                    ];


                }
            }


            $created_goods = count($created_goods);
            $updated_goods = count($updated_goods);
            $title = '📡 Успешно обновили все товары! 📡';
            $text = "Все товары на сайте были синхронизированы с YClients. Добавлено товаров: *{$created_goods}*\n Обновлено товаров: *{$updated_goods}*.";


            RefreshLog::create([
                'model' => 'Товары',
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
