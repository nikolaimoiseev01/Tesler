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

    public function search_for_goods()
    {

        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];


        $yc_goods = [];
        $changed_after = '2023-01-05T12:00:00';
        for ($page = 0; $page <= 20; $page++) {
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
            if (Good::where('yc_id', $yc_good['good_id'])->exists()) {
            } else {
                $this->found_yc_goods[] = [
                    'yc_id' => $yc_good['good_id'],
                    'yc_title' => $yc_good['title'],
                    'yc_price' => $yc_good['cost'],
                    'yc_category' => $yc_good['category'],
                    'last_change_date' => substr($yc_good['last_change_date'], 0, 10),
                    'yc_active' => 0
                ];
                $this->found_yc_goods = Arr::where($this->found_yc_goods, function ($value, $key) {
                    return ($value['category'] !== 'Расходники одноразовые' || $value['category'] !== 'Расходники одноразовые');
                }); // Только активные товары оставляем
                $this->found_yc_goods = collect($this->found_yc_goods)->sortBy('last_change_date')->reverse()->toArray();
            }

            if (empty($this->found_yc_goods)) {
                $this->dispatchBrowserEvent('swal_fire', [
                    'type' => 'success',
                    'showDenyButton' => false,
                    'showConfirmButton' => false,
                    'title' => 'Все услуги актуальны!',
                    'text' => 'Новых услуг на YClients не найдено.',
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


    }


    public function add_found_goods()
    {
        foreach($this->found_yc_goods as $found_yc_good) {
            Good::create([
                'yc_id' => $found_yc_good['yc_id'],
                'yc_title' => $found_yc_good['yc_title'],
                'yc_price' => $found_yc_good['yc_price'],
                'yc_category' => $found_yc_good['yc_category'],
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
}
