<?php

namespace App\Services;


use Illuminate\Support\Facades\Notification;
use App\Models\Good\Good;
use App\Models\RefreshLog;
use App\Models\User;
use App\Notifications\MailNotification;
use App\Notifications\TelegramNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GoodYcOperations
{

    public $yc_goods;
    public $yc_shops;
    public $log_description;

    public $created_goods = 0;
    public $deleted_goods = 0;
    public $updated_goods = 0;

    public function tempMakeNewYcIDS() // Метод запускается один раз при обновлении системы
    {
        $goods = Good::all();
        foreach ($goods as $good) {
            $new_yc_ids = json_encode([
                [
                    'branch_id' => 247576,
                    'good_id' => $good['yc_id']
                ]
            ]);
            $good->update([
                'yc_ids' => $new_yc_ids
            ]);
        }
        dd('Все товары обновлены!');
    }

    public function helpGetSameGoods($goods) // Вспомогательный метод
    {
        // Считаем количество каждого title
        $titleCounts = array_count_values(array_column($goods, 'title'));

        // Фильтруем только те элементы, где title повторяется
        $filteredData = array_filter($goods, function ($item) use ($titleCounts) {
            return $titleCounts[$item['title']] > 1;
        });

        // Сброс индексов
        $filteredData = array_values($filteredData);

        // Сортируем массив по ключу 'title'
        usort($filteredData, function ($a, $b) {
            return strcmp($a['title'], $b['title']);
        });

        dd($filteredData);
    }

    public function helpGetParticularGood($goods, $filter_by_column, $filter_by_value)
    {
        $filteredGoods = array_filter($goods, function ($item) use ($filter_by_column, $filter_by_value) {
            return str_contains($item[$filter_by_column], $filter_by_value);
        });
        echo("Найденный товар:");
        dd($filteredGoods);
    } // Вспомогательный метод

    public function createBranchGoods($branch) // Понимаем список товаров в конкретном филиале
    {
        $goods = [];
        // Получаем дочернии категории от папки "Товары на продажу" конкретного филиала
        $url_type = 'goods/category_node';
        $url_end = "{$branch['good_for_sell_parent_category']}?page=1&count=10";
        $categories = (new YcApiRequest)->make_request($url_type, $url_end, $branch);

        // Добавляем категории сертификатов и абонементов
        $new_categiries = [
            ['category_id' => $branch['abonement_category'], 'title' => 'Абонементы'],
            ['category_id' => $branch['sert_category'], 'title' => 'Сертификаты']
        ];
        $categories['children'] = array_merge($categories['children'], $new_categiries);

        foreach ($categories['children'] as $category) { // Идем по каждой категории и собираем товары
            if ($category['category_id'] <> 0) { // Костыль, чтобы не подтягивать левые категории
                $url_type = 'goods';
                $url_end = "?category_id={$category['category_id']}&page=1&count=100";
                $category_goods = (new YcApiRequest)->make_request($url_type, $url_end, $branch);
                $goods = array_merge($goods, $category_goods);
            }
        }
        return $goods;
    }

    public function filterActualAmountsInGood($yc_good) // Ставим поле actual_amounts на товарах из YClients, чтобы остались нужные storage и остатки
    {

        // Создаем карту yc_shops для быстрого доступа по storage_id
        $yc_shops_map = [];
        foreach ($this->yc_shops as $shop) {
            $yc_shops_map[$shop['storage_id']] = [
                'name' => $shop['name'],
                'branch_id' => $shop['id'],
                'order' => $shop['order']
            ];
        }

        // Фильтруем и обогащаем данные в первом массиве
        $result = array_values(array_filter(array_map(function ($storage) use ($yc_shops_map) {
            $storage_id = (string)$storage['storage_id']; // Приводим storage_id к строке для корректного сравнения
            if (isset($yc_shops_map[$storage_id])) {
                // Добавляем информацию из yc_shops
                return array_merge($storage, $yc_shops_map[$storage_id], ['good_enabled_in_branch' => true]);
            }
            return null;
        }, $yc_good['actual_amounts'])));

        // Проверяем отсутствующие storage_id и добавляем их
        foreach ($yc_shops_map as $storage_id => $info) {
            // Если storage_id отсутствует в результирующем массиве, добавляем его
            $exists = array_filter($result, function ($item) use ($storage_id) {
                return $item['storage_id'] === $storage_id;
            });
            if (empty($exists)) {
                $result[] = [
                    'storage_id' => $storage_id,
                    'branch_id' => $info['branch_id'],
                    'amount' => 0,
                    'good_enabled_in_branch' => false,
                    'name' => $info['name'],
                    'order' => $info['order']
                ];
            }
        }

        $yc_good['actual_amounts'] = $result;

        return $yc_good;
    }

    public function YcGoodsToUnique($yc_goods) // Схлопываем неуникальные товары, полученные из YC
    {
        // Массив для хранения уникальных товаров
        $uniqueProducts = [];

        // Обработка товаров
        foreach ($yc_goods as $yc_good) {
            $yc_goodId = $yc_good['title'];

            if (isset($uniqueProducts[$yc_goodId])) {
                // Объединяем actual_amounts
                $uniqueProducts[$yc_goodId]['actual_amounts'] = array_merge(
                    $uniqueProducts[$yc_goodId]['actual_amounts'],
                    $yc_good['actual_amounts']
                );
                $uniqueProducts[$yc_goodId]['yc_ids'][] = [
                    'salon_id' => $yc_good['salon_id'],
                    'good_id' => $yc_good['good_id']
                ];
            } else {
                // Добавляем новый товар
                $uniqueProducts[$yc_goodId] = $yc_good;
                $uniqueProducts[$yc_goodId]['yc_ids'][] = [
                    'salon_id' => $yc_good['salon_id'],
                    'good_id' => $yc_good['good_id']
                ];
            }
        }

        echo("Шаг уникализации yc_goods успешно заверешен\n");

        return $uniqueProducts;
    }

    public function makeYcGoods() // Общий метод создания нужного $this->yc_goods
    {

        $this->yc_shops = config('cons.yc_shops');

        // Собираем товары каждого филиала
        $yc_goods_comp_1 = $this->createBranchGoods($this->yc_shops[0]);
        $yc_goods_comp_2 = $this->createBranchGoods($this->yc_shops[1]);
        $merged_yc_goods = array_merge($yc_goods_comp_1, $yc_goods_comp_2);
        $unique_yc_goods = $this->YcGoodsToUnique($merged_yc_goods); // Делаем уникальные товары (ПО НАЗВАНИЮ)

        foreach ($unique_yc_goods as &$yc_good) { // Идем по всем YC товарам

            $yc_good = $this->filterActualAmountsInGood($yc_good); // Оставляем только нужные склады в каждом товаре

        }
        unset($yc_good); // После завершения работы со ссылками обязательно сбросить ссылку

        $this->yc_goods = array_values($unique_yc_goods);

        echo("Шаг создания yc_goods успешно заверешен\n");

//        $this->getSameGoods($unique_yc_goods); // Получить одинаковые товары по названию

//        $this->helpGetParticularGood($unique_yc_goods, 'MUSK MOCHEQI Шёлковая SPA-маска с маслом семян жожоба 500 мл'); // Получить конкретное название из массива

    }

    public function createUpdateGoods() // Идем по всем товарам YC и обновляем нашу базу
    {
        DB::transaction(function () { // Чтобы не записать ненужного
            foreach ($this->yc_goods as $yc_good) { // Идем по всем товарам из YC
                $ids_to_search = array_column($yc_good['yc_ids'], 'good_id');
                $good_found = Good::where(function ($query) use ($ids_to_search) { // Ищем товар в нашей системе по любым ID из YC
                    foreach ($ids_to_search as $id) {
                        $query->orWhereJsonContains('yc_ids', ['good_id' => $id]);
                    }
                })->first();

                if ($good_found ?? null) { // Если находим такой товар у нас, обновляем его

                    $good_found->update([
                        'yc_ids' => json_encode($yc_good['yc_ids']),
                        'name' => $yc_good['title'],
                        'yc_title' => $yc_good['title'],
                        'yc_price' => $yc_good['cost'],
                        'yc_category' => $yc_good['category'],
                        'yc_actual_amount' => $yc_good['actual_amounts'],
                        'yc_actual_amount_total' => array_sum(array_column($yc_good['actual_amounts'], 'amount'))
                    ]);
                    $this->updated_goods += 1;
                    $this->log_description['1. Обновили инфо из YClients'][] = [
                        'yc_ids' => json_encode($yc_good['yc_ids']),
                        'title' => $yc_good['title'],
                    ];

                } else { // Если не находим такой товар, создаем
                    Good::create([
                        'yc_ids' => json_encode($yc_good['yc_ids']),
                        'yc_title' => $yc_good['title'],
                        'yc_price' => $yc_good['cost'],
                        'yc_category' => $yc_good['category'],
                        'yc_actual_amount' => json_encode($yc_good['actual_amounts']),
                        'yc_actual_amount_total' => array_sum(array_column($yc_good['actual_amounts'], 'amount')),
                        'name' => $yc_good['title'],
                        'flg_active' => 0
                    ]);
                    $this->created_goods += 1;
                    $this->log_description['2. Добавили новые из YClients'][] = [
                        'yc_ids' => json_encode($yc_good['yc_ids']),
                        'title' => $yc_good['title'],
                    ];
                }
            }
        });
        echo("Шаг обновления успешно заверешен\n");
    }

    public function deleteUnused() // Идем по всем товарам нашей базы и удаляем тех, что уже нет в YC
    {

        DB::transaction(function () { // Чтобы не записать ненужного
            $our_goods = Good::all();

            // Находим все ID из YClients
            $yc_ids_to_look_into = array_reduce($this->yc_goods, function ($carry, $item) {
                if (isset($item['yc_ids'])) {
                    $carry = array_merge($carry, array_column($item['yc_ids'], 'good_id'));
                }
                return $carry;
            }, []);
            foreach ($our_goods as $our_good) { // Идем по всем товарам НАШИМ
                $ids_to_search = array_column(json_decode($our_good['yc_ids'], true), 'good_id');
                $matches = array_intersect($ids_to_search, $yc_ids_to_look_into); // Находим пересечения

                if (!$matches) { // Если такого товара нет в YClients
                    $this->log_description['3. Удалили, потому что не нашли таких товаров в YC'][] = [
                        'yc_ids' => $our_good['yc_ids'],
                        'title' => $our_good['name'],
                    ];
                    $our_good->delete();
                    $this->deleted_goods += 1;
                }
            }
        });
        echo("Шаг удаления успешно заверешен\n");

    }

    public function fullGoodsUpdate()
    {

//                $this->tempMakeNewYcIDS();
        $this->makeYcGoods(); // Создаем уникальные товары из YClients

//        $this->yc_shops = config('cons.yc_shops');
//        $yc_goods_comp_1 = $this->createBranchGoods($this->yc_shops[0]);
//        $this->helpGetParticularGood(goods: $this->yc_goods, filter_by_column: 'category_id', filter_by_value:  '445497');

        $this->createUpdateGoods(); // Обновляем товары в нашей системе из YClients
        $this->deleteUnused(); // Удаляем товары в нашей системе, которых нет в YClients

        $title = '📡 Успешно обновили все товары! 📡';
        $text = "Все товары на сайте были синхронизированы с YClients. Добавлено новых: *{$this->created_goods}* \nУдалено с сайта: *{$this->deleted_goods}* \nОбновили информацию: *$this->updated_goods*.";

        RefreshLog::create([
            'model' => 'Товары',
            'type' => 'Синхронизация с YClients',
            'summary' => $text,
            'description' => json_encode($this->log_description) ?? 'Не нашли, что можно сделать'
        ]);

        // Посылаем Telegram уведомление нам
        Notification::route('telegram', config('app.telegram_chat_id'))
            ->notify(new TelegramNotification($title, $text, null, null));
    }
}
