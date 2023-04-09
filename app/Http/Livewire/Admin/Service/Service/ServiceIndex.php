<?php

namespace App\Http\Livewire\Admin\Service\Service;

use App\Models\Service;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ServiceIndex extends Component
{
    public $found_yc_services;

    protected $listeners = ['refreshServiceIndex' => '$refresh'];

    public function render()
    {
        $services = Service::orderBy('id')->get();

        return view('livewire.admin.service.service.service-index', [
            'services' => $services,
            'found_yc_services' => collect($this->found_yc_services)
        ]);
    }

    public function search_for_services()
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

        foreach ($yc_services['data'] as $yc_service) { // Идем по всем услугам YCLIENTS
            if (Service::where('yc_id', $yc_service['id'])->exists()) {
            } else {
                $this->found_yc_services[] = [
                    'yc_id' => $yc_service['id'],
                    'yc_price_min' => $yc_service['price_min'],
                    'yc_price_max' => $yc_service['price_max'],
                    'yc_duration' => $yc_service['duration'],
                    'yc_comment' => $yc_service['comment'],
                    'yc_title' => $yc_service['title'],
                    'yc_category_id' => $yc_service['category_id'],
                    'yc_active' => $yc_service['active'],
                    'yc_image' => 'test'
                ];
            }
            if (empty($this->found_yc_services)) {
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
                    'title' => 'Надены новые услуги!',
                    'text' => 'Их можно добавить в систему, если все в порядке.',
                ]);
            }
        }
//        dd($this->found_yc_services);
        $this->found_yc_services = Arr::where($this->found_yc_services, function ($value, $key) {
            return $value['yc_active'] == 1;
        });
//        dd($filteredArray);


    }


    public function add_found_services()
    {
        foreach($this->found_yc_services as $found_yc_services) {
            Service::create([
                'yc_id' => $found_yc_services['yc_id'],
                'yc_title' => $found_yc_services['yc_title'],
                'yc_comment' => $found_yc_services['yc_comment'],
                'yc_price_min' => $found_yc_services['yc_price_min'],
                'yc_price_max' => $found_yc_services['yc_price_max'],
                'yc_duration' => $found_yc_services['yc_duration'],
                'flg_active' => 0,
                'name' => $found_yc_services['yc_title'],
                'desc' => $found_yc_services['yc_comment'],
            ]);
        }
        $this->found_yc_services = null;
        $this->emit('pg:eventRefresh-default');
        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Новые услуги добавлены!',
        ]);

    }

    public function export_all()
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

        foreach ($yc_services['data'] as $yc_service) { // Идем по всем услугам YCLIENTS
            $this->found_yc_services[] = [
                'yc_id' => $yc_service['id'],
                'yc_category_id' => $yc_service['price_min'],
                'yc_price_min' => $yc_service['price_min'],
                'yc_price_max' => $yc_service['price_max'],
                'yc_duration' => $yc_service['duration'],
                'yc_comment' => $yc_service['comment'],
                'yc_title' => $yc_service['title'],
                'yc_image' => 'test'
            ];


        }
        dd($this->found_yc_services);
    }

}
