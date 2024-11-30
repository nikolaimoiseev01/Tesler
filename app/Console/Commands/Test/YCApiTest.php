<?php

namespace App\Console\Commands\Test;

use App\Models\Good\Good;
use App\Models\Service\Service;
use App\Services\ServiceYcOperations;
use App\Services\YcApiRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class YCApiTest extends Command
{
    public $yc_goods;
    public $yc_shops;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yc_api_test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function helpGetSameGoods($goods)
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

    public function helpGetParticularGood($goods, $title)
    {
        $filteredGoods = array_filter($goods, function ($item) use ($title) {
            return $item['title'] === $title;
        });
        echo("Найденный товар:");
        dd($filteredGoods);
    }

    public function CreateBranchGoods($branch)
    {
        $goods = [];
        // Получаем дочернии категории от папки "Товары на продажу" конкретного филиала
        $url_type = 'goods/category_node';
        $url_end = "{$branch['good_for_sell_parent_category']}?page=1&count=10";
        $categories = (new YcApiRequest)->make_request($url_type, $url_end, $branch);
        foreach ($categories['children'] as $category) {
            if ($category['category_id'] <> 0) { // Костыль, чтобы не подтягивать левые категории
//                echo("Смотрим категорию: {$category['title']}, {$category['category_id']}\n");
                $url_type = 'goods';
                $url_end = "?category_id={$category['category_id']}";
                $category_goods = (new YcApiRequest)->make_request($url_type, $url_end, $branch);
                $goods = array_merge($goods, $category_goods);
            }
        }
        return $goods;
    }

    public function FilterActualAmountsInGood($yc_good)
    {

        // Создаем карту yc_shops для быстрого доступа по storage_id
        $yc_shops_map = [];
        foreach ($this->yc_shops as $shop) {
            $yc_shops_map[$shop['storage_id']] = [
                'name' => $shop['name'],
                'order' => $shop['order']
            ];
        }

        // Фильтруем и обогащаем данные в первом массиве
        $result = array_values(array_filter(array_map(function ($storage) use ($yc_shops_map) {
            $storage_id = (string)$storage['storage_id']; // Приводим storage_id к строке для корректного сравнения
            if (isset($yc_shops_map[$storage_id])) {
                // Добавляем информацию из yc_shops
                return array_merge($storage, $yc_shops_map[$storage_id], ['good_enabled_in_storage' => true]);
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
                    'amount' => 0,
                    'good_enabled_in_storage' => false,
                    'name' => $info['name'],
                    'order' => $info['order']
                ];
            }
        }

        $yc_good['actual_amounts'] = $result;

        return $yc_good;
    }

    public function makeUniqueYcGoods($yc_goods)
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
                $uniqueProducts[$yc_goodId]['same_yc_ids'][] = [
                    'salon_id' => $yc_good['salon_id'],
                    'good_id' => $yc_good['good_id']
                ];
            } else {
                // Добавляем новый товар
                $uniqueProducts[$yc_goodId] = $yc_good;
                $uniqueProducts[$yc_goodId]['same_yc_ids'][] = [
                    'salon_id' => $yc_good['salon_id'],
                    'good_id' => $yc_good['good_id']
                ];
            }
        }

        return $uniqueProducts;
    }

    public function CreateYcGoods()
    {

        $this->yc_shops = config('cons.yc_shops');

        // Собираем товары каждого филиала
        $yc_goods_comp_1 = $this->CreateBranchGoods($this->yc_shops[0]);
        $yc_goods_comp_2 = $this->CreateBranchGoods($this->yc_shops[1]);
        $merged_yc_goods = array_merge($yc_goods_comp_1, $yc_goods_comp_2);
        $unique_yc_goods = $this->makeUniqueYcGoods($merged_yc_goods); // Делаем уникальные товары (ПО НАЗВАНИЮ)

        foreach ($unique_yc_goods as &$yc_good) { // Идем по всем YC товарам

            $yc_good = $this->FilterActualAmountsInGood($yc_good); // Оставляем только нужные склады в каждом товаре

        }
        unset($yc_good); // После завершения работы со ссылками обязательно сбросить ссылку

        $this->yc_goods = array_values($unique_yc_goods);

//        $this->getSameGoods($unique_yc_goods); // Получить одинаковые товары по названию

//        $this->helpGetParticularGood($unique_yc_goods, 'MUSK MOCHEQI Шёлковая SPA-маска с маслом семян жожоба 500 мл'); // Получить конкретное название из массива

    }

    public function createUpdateGoods()
    {
        DB::transaction(function () { // Чтобы не записать ненужного
            foreach ($this->yc_goods as $yc_good) { // Идем по всем товарам из YC
//                $good_found =


            }
        });
    }

    public function handle()
    {
        // Подсчитываем количество моделей, у которых есть медиафайлы в коллекции 'good_examples'
        $count = Good::whereHas('media', function ($query) {
            $query->where('collection_name', 'good_examples');
        })->get();
        dd($count);
//        $this->CreateYcGoods(); // Создаем уникальные товары из YClients
//        dd(count($this->yc_goods));

    }
}
