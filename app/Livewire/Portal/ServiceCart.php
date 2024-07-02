<?php

namespace App\Livewire\Portal;

use App\Models\Service\Scope;
use App\Models\Service\Service;
use Illuminate\Http\Request;
use Livewire\Component;

class ServiceCart extends Component
{
    public $cart_services = array();
    public $yc_link;
    public $link_services;

    public $out_services;
    public $total_price;
    public $cart_total;
    public $cart_services_count;
    public $cart_goods_count;

    public $chosen_yc_shop;

    protected $listeners = ['service_cart_add', 'test_test', 'update_service_buttons', 'show_red_cart_s'];

    public function render()
    {
        return view('livewire.portal.service-cart');
    }

    public function show_red_cart_s()
    {

        $this->dispatch('update_red_cart',
            cart_total: $this->cart_total,
            cart_services_count: $this->cart_services_count,
            cart_goods_count: $this->cart_goods_count,
        );
    }

    public function make_services()
    {

        $grouped = collect($this->cart_services)->groupBy('scope_id');

        $result = $grouped->map(function ($group, $scope_id) {
            // Получаем название из модели Scope
            $scope = Scope::find($scope_id);
            $title = $scope ? $scope->name : 'Unknown';

            // Формируем строку из всех id экземпляров
            $idsString = "https://b253254.yclients.com/company/{$this->chosen_yc_shop['id']}/menu?o=s" . $group->pluck('yc_id')->implode(',');

            // Формируем результат для каждой группы
            return [
                'title' => $title,
                'services' => $group,
                'link' => $idsString,
            ];
        });

        // Преобразуем в массив для дальнейшей обработки
        $this->out_services = $result->values()->toArray();


        $this->total_price = array_reduce($this->cart_services, function ($carry, $item) {
            return $carry + $item['yc_price_min'];
        });


    }

    public function mount(Request $request)
    {
        $this->chosen_yc_shop = app('chosen_shop');
        $this->cart_services = $request->session()->get('cart_services');
        $this->cart_total = $request->session()->get('cart_total');
        $this->cart_services_count = $request->session()->get('cart_services_count');
        $this->cart_goods_count = $request->session()->get('cart_goods_count');


        if ($this->cart_services) {
            $this->total_price = array_reduce($this->cart_services, function ($carry, $item) {
                return $carry + $item['yc_price_min'];
            });

            $this->make_services();
        }


    }

    public function update_service_buttons()
    {
        if ($this->cart_services) {
            foreach ($this->cart_services as $cart_service) {
                $this->dispatch('trigger_service_add_button',
                    type: 'add',
                    id: $cart_service['id'],
                );
            }
        }
    }

    public function service_cart_add(Request $request, $service_id)
    {
        $service_to_add = Service::where('id', $service_id)->get()->toArray();
        $service_img_url = Service::where('id', $service_id)->first()->getFirstMediaUrl('pic_main') ?? config('cons.default_pic');
        $service_to_add[0]['image_url'] = $service_img_url;
        $request->session()->push('cart_services', $service_to_add[0]);
        $this->cart_services = $request->session()->get('cart_services');

        $this->make_services();


        $this->dispatch('trigger_service_cart_open');

        $this->cart_total += 1;
        $this->cart_services_count += 1;

        $request->session()->put('cart_total', $this->cart_total);
        $request->session()->put('cart_services_count', $this->cart_services_count);

        $this->dispatch('update_red_cart',
            cart_total: $this->cart_total,
            cart_services_count: $this->cart_services_count,
            cart_goods_count: $this->cart_goods_count
        );


        $this->dispatch('trigger_service_add_button',
            type: 'add',
            id: $service_id,
        );

        $this->dispatch('show_red_cart');

    }

    public function service_cart_remove_all(Request $request)
    {
        $services_before_remove = count($this->cart_services);

        foreach ($this->cart_services as $cart_service) {
            $this->dispatch('trigger_service_add_button',
                type: 'remove',
                id: $cart_service['id'],
            );
        }
        $this->cart_services = [];

        $this->dispatch('trigger_service_cart_close');

        $this->cart_total -= $services_before_remove;
        $this->cart_services_count = max(0, $this->cart_services_count - $services_before_remove);

        $request->session()->put('cart_total', $this->cart_total);
        $request->session()->put('cart_services_count', $this->cart_services_count);

        $this->dispatch('update_red_cart',
            cart_total: $this->cart_total,
            cart_services_count: $this->cart_services_count,
            cart_goods_count: $this->cart_goods_count,
        );

        $this->make_services();


        session()->put('cart_services', $this->cart_services);
    }


    public function service_cart_remove(Request $request, $service_id)
    {

        $this->cart_services = $request->session()->get('cart_services');
        foreach ($this->cart_services as $key => $object) {
            if ($object['id'] == $service_id) {
                unset($this->cart_services[$key]);
            }
        }

        session()->put('cart_services', $this->cart_services);

        $this->make_services();

        $this->cart_total = max(0, $this->cart_total - 1);
        $this->cart_services_count = max(0, $this->cart_services_count - 1);

        $request->session()->put('cart_total', $this->cart_total);
        $request->session()->put('cart_services_count', $this->cart_services_count);

        $this->dispatch('update_red_cart',
            cart_total: $this->cart_total,
            cart_services_count: $this->cart_services_count,
            cart_goods_count: $this->cart_goods_count,
        );

        $this->dispatch('trigger_service_add_button',
            type: 'remove',
            id: $service_id,
        );


    }
}
