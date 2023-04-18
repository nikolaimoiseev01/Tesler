<?php

namespace App\Http\Livewire\Portal;

use App\Models\Good;
use App\Models\Service;
use Illuminate\Http\Request;
use Livewire\Component;

class ServiceCart extends Component
{
    public $cart_services = array();
    public $yc_link;
    public $link_services;
    public $total_price;

    protected $listeners = ['service_cart_add', 'update_service_buttons'];

    public function render()
    {
        return view('livewire.portal.service-cart');
    }

    public function mount(Request $request)
    {
        $this->cart_services = $request->session()->get('cart_services');

        if ($this->cart_services) {
            $this->link_services = '';
            foreach ($this->cart_services as $cart_service) {
                $this->link_services = $this->link_services . $cart_service['yc_id'] . ',';
            }

            $this->link_services = rtrim($this->link_services, ",");
            $this->yc_link = 'https://b253254.yclients.com/company/247576/menu?o=s' . $this->link_services;

            $this->total_price = array_reduce($this->cart_services, function ($carry, $item) {
                return $carry + $item['yc_price_min'];
            });

//            var_dump($this->total_price);
        }


    }

    public function update_service_buttons()
    {
        if ($this->cart_services) {
            foreach ($this->cart_services as $cart_service) {
                $this->dispatchBrowserEvent('trigger_service_add_button', [
                    'type' => 'add',
                    'id' => $cart_service['id'],
                ]);
            }
        }
    }

    public function service_cart_add(Request $request, $service_id)
    {
        $service_to_add = Service::where('id', $service_id)->get()->toArray();
        $service_img_url = Service::where('id', $service_id)->first()->getFirstMediaUrl('pic_main');
        $service_to_add[0]['image_url'] = $service_img_url;
        $request->session()->push('cart_services', $service_to_add[0]);
        $this->cart_services = $request->session()->get('cart_services');

        if ($this->cart_services) {
            $this->link_services = '';
            foreach ($this->cart_services as $cart_service) {
                $this->link_services  = $this->link_services . $cart_service['yc_id'] . ',';
            }
        }
        $this->link_services  = rtrim($this->link_services , ",");
        $this->yc_link = 'https://b253254.yclients.com/company/247576/menu?o=s' . $this->link_services;

        $this->total_price = array_reduce($this->cart_services, function ($carry, $item) {
            return $carry + $item['yc_price_min'];
        });

        $this->dispatchBrowserEvent('trigger_service_cart_open');


        $this->dispatchBrowserEvent('trigger_service_add_button', [
            'type' => 'add',
            'id' => $service_id,
        ]);

    }

    public function service_cart_remove_all() {
        foreach ($this->cart_services as $cart_service) {
            $this->dispatchBrowserEvent('trigger_service_add_button', [
                'type' => 'remove',
                'id' => $cart_service['id'],
            ]);
        }
        $this->cart_services = [];

        $this->dispatchBrowserEvent('trigger_service_cart_close');


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

        if ($this->cart_services) {
            $this->link_services = '';
            foreach ($this->cart_services as $cart_service) {
                $this->link_services  = $this->link_services . $cart_service['yc_id'] . ',';
            }
        }
        $this->link_services  = rtrim($this->link_services , ",");
        $this->yc_link = 'https://b253254.yclients.com/company/247576/menu?o=s' . $this->link_services;

        $this->total_price = array_reduce($this->cart_services, function ($carry, $item) {
            return $carry + $item['yc_price_min'];
        });

//

        $this->dispatchBrowserEvent('trigger_service_add_button', [
            'type' => 'remove',
            'id' => $service_id,
        ]);


    }
}
