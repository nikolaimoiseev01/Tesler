<?php

namespace App\Http\Livewire\Admin\Good;

use App\Models\Good;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class GoodIndex extends Component
{
    public $found_yc_goods;

    protected $listeners = ['refreshGoodIndex' => '$refresh'];

    public function render()
    {
        return view('livewire.admin.good.good-index');
    }

    public function refresh_from_loyalty()
    {
        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];

        $goods = Good::where('yc_price', '>', 0)
            ->where('flg_active', 1)
            ->where(function ($query) {
                $query->where('yc_category', 'Абонементы Сеть Tesler')
                    ->orWhere('yc_category', 'Сертификаты Сеть Tesler');
            })
            ->get();

        foreach ($goods as $good) {
            $yc_good = Http::withHeaders($YCLIENTS_HEADERS)
                ->get('https://api.yclients.com/api/v1/goods/' . $YCLIENTS_SHOP_ID . '/' . $good['yc_id'])
                ->collect()['data'];

            if ($yc_good['loyalty_certificate_type_id'] !== 0) { // Если это сертификат
                $url = 'https://api.yclients.com/api/v1/company/' . $YCLIENTS_SHOP_ID . '/loyalty/certificate_types/fetch?&ids[]={' . $yc_good['loyalty_certificate_type_id'] . '}';
                $request = Http::withHeaders($YCLIENTS_HEADERS)
                    ->get($url)
                    ->collect();
                dd($request);
                if (!empty($request['data'])) {
                    dd('test');
                }
//                dd($request);
            }

//            if ($yc_good['loyalty_abonement_type_id'] !== 0) { // Если это абонемент
//                $url = 'https://api.yclients.com/api/v1/company/' . $YCLIENTS_SHOP_ID . '/loyalty/abonement_types/fetch?' . $yc_good['loyalty_abonement_type_id']);
//            }
        }


    }

    public function search_for_goods()
    {

        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];

//        // Подгружаем товары на продажу
//        $link = 'https://api.yclients.com/api/v1/goods/' . $YCLIENTS_SHOP_ID . '/25562546';
//        $request = Http::withHeaders($YCLIENTS_HEADERS)
//            ->get($link)
//            ->collect();
//        dd($request);

        $yc_goods = [];
        $changed_after = '2022-01-05T12:00:00';
        for ($page = 0; $page <= 20; $page++) {

            // Подгружаем товары на продажу
            $link = 'https://api.yclients.com/api/v1/goods/' . $YCLIENTS_SHOP_ID . '?count=100&changed_after=' . $changed_after . '&page=' . $page;
            $request = Http::withHeaders($YCLIENTS_HEADERS)
                ->get($link)
                ->collect();
//            dd($request);
            $request = array_values(Arr::where($request['data'], function ($value, $key) {
                return str_contains(mb_strtolower($value['category']), 'продажа');
            })); // ТОЛЬКО ТАМ, ГДЕ В КАТЕГОРИИ ЕСТЬ СЛОВА "НА ПРОДАЖУ"

            if ($request ?? null) {
                $yc_goods = array_merge($yc_goods, $request);
            } else {
                break;
            }

//            // Подгружаем сертификаты
//            $link = 'https://api.yclients.com/api/v1/goods/' . $YCLIENTS_SHOP_ID . '?count=100&changed_after=' . $changed_after . '&page=' . $page . '&category_id=445497';
//            $request = Http::withHeaders($YCLIENTS_HEADERS)
//                ->get($link)
//                ->collect();
////            dd($request);
//            if ($request['data'] ?? null) {
//                $yc_goods = array_merge($yc_goods, $request['data']);
//            } else {
//                break;
//            }
//
//            // Подгружаем абонементы
//            $link = 'https://api.yclients.com/api/v1/goods/' . $YCLIENTS_SHOP_ID . '?count=100&changed_after=' . $changed_after . '&page=' . $page . '&category_id=479138';
//            $request = Http::withHeaders($YCLIENTS_HEADERS)
//                ->get($link)
//                ->collect();
////            dd($request);
//            if ($request['data'] ?? null) {
//                $yc_goods = array_merge($yc_goods, $request['data']);
//            } else {
//                break;
//            }
        }
//dd($yc_goods);

        $this->found_yc_goods = null;

        foreach ($yc_goods as $yc_good) { // Идем по всем услугам YCLIENTS
            if (Good::where('yc_id', $yc_good['good_id'])->exists()) {
            } else {
                $storage_id_key = array_search(ENV('YCLIENTS_SHOP_STORAGE'), array_column($yc_good['actual_amounts'], 'storage_id'));
                $yc_actual_amounts = $yc_good['actual_amounts'][$storage_id_key]['amount'] ?? null;
//                dd('test');
                $this->found_yc_goods[] = [
                    'yc_id' => $yc_good['good_id'],
                    'yc_title' => $yc_good['title'],
                    'yc_price' => $yc_good['cost'],
                    'yc_category' => $yc_good['category'],
                    'yc_actual_amount' => $yc_actual_amounts,
                    'last_change_date' => substr($yc_good['last_change_date'], 0, 10),
                    'yc_active' => 0
                ];

//                $this->found_yc_goods = Arr::where($this->found_yc_goods, function ($value, $key) {
//                    if ($value['category'] ?? null) {
//                        return $value['category'];
//                    }
//                }); // Только активные товары оставляем


                $this->found_yc_goods = collect($this->found_yc_goods)->sortBy('last_change_date')->reverse()->toArray();
            }

            // Берем только уникальные
            $unique_array = [];
            if ($this->found_yc_goods ?? null) {
                foreach ($this->found_yc_goods as $element) {
                    $hash = $element['yc_id'];
                    $unique_array[$hash] = $element;
                }
                $this->found_yc_goods = array_values($unique_array);
            }


            if (empty($this->found_yc_goods)) {
                $this->dispatchBrowserEvent('swal_fire', [
                    'type' => 'success',
                    'showDenyButton' => false,
                    'showConfirmButton' => false,
                    'title' => 'Все товары актуальны!',
                    'text' => 'Новых товаров на YClients не найдено.',
                ]);
            } else {
                $this->dispatchBrowserEvent('swal_fire', [
                    'type' => 'info',
                    'showDenyButton' => false,
                    'showConfirmButton' => false,
                    'title' => 'Надены новые товары!',
                    'text' => 'Их можно добавить в систему, если все в порядке.',
                ]);
            }
        }


        if (empty($this->found_yc_goods)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'success',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Все товары актуальны!',
                'text' => 'Новых товаров на YClients не найдено.',
            ]);
        }
    }

    public function add_found_goods()
    {
        foreach ($this->found_yc_goods as $found_yc_good) {
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
        $this->found_yc_goods = null;
        $this->emit('pg:eventRefresh-default');
        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Новые товары добавлены!',
        ]);
    }

    public function refresh_goods_yc_info()
    {
        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];


        $yc_goods = [];
        $changed_after = '2023-01-05T12:00:00';
        for ($page = 0; $page <= 20; $page++) {

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

//            // Подгружаем сертификаты
//            $link = 'https://api.yclients.com/api/v1/goods/' . $YCLIENTS_SHOP_ID . '?count=100&changed_after=' . $changed_after . '&page=' . $page . '&category_id=445497';
//            $request = Http::withHeaders($YCLIENTS_HEADERS)
//                ->get($link)
//                ->collect();
////            dd($request);
//            if ($request['data'] ?? null) {
//                $yc_goods = array_merge($yc_goods, $request['data']);
//            } else {
//                break;
//            }
//
//            // Подгружаем абонементы
//            $link = 'https://api.yclients.com/api/v1/goods/' . $YCLIENTS_SHOP_ID . '?count=100&changed_after=' . $changed_after . '&page=' . $page . '&category_id=479138';
//            $request = Http::withHeaders($YCLIENTS_HEADERS)
//                ->get($link)
//                ->collect();
////            dd($request);
//            if ($request['data'] ?? null) {
//                $yc_goods = array_merge($yc_goods, $request['data']);
//            } else {
//                break;
//            }
        }


        $this->found_yc_goods = null;

        foreach ($yc_goods as $yc_good) { // Идем по всем услугам YCLIENTS
            $good_found = Good::where('yc_id', $yc_good['good_id'])->first();
            if ($good_found ?? null) { // Если есть такой товар
                $storage_id_key = array_search(ENV('YCLIENTS_SHOP_STORAGE'), array_column($yc_good['actual_amounts'], 'storage_id'));
                $yc_actual_amounts = $yc_good['actual_amounts'][$storage_id_key]['amount'] ?? null;


                if ($good_found['yc_title'] <> $yc_good['title'] || $good_found['yc_price'] <> $yc_good['cost'] || $good_found['yc_category'] <> $yc_good['category'] || $good_found['yc_actual_amount'] <> $yc_actual_amounts) {

                    $good_found->update([
                        'yc_title' => $yc_good['title'],
                        'yc_price' => $yc_good['cost'],
                        'yc_category' => $yc_good['category'],
                        'yc_actual_amount' => $yc_actual_amounts,
                        'name' => $yc_good['title'],
                    ]);
                }
            }

            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'success',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Успешно!',
                'text' => 'Информация о всех товарах успешно обновлена',
            ]);

            $this->emit('pg:eventRefresh-default');

        }
    }
}
