<?php

namespace App\Http\Livewire\Portal;

use App\Models\Good;
use Illuminate\Http\Request;
use Livewire\Component;

class GoodCart extends Component
{
    public $cart_goods = array();
    public $yc_link;
    public $link_goods;
    public $total_price;

    protected $listeners = ['good_cart_add', 'update_good_buttons'];

    public function render()
    {

        return view('livewire.portal.good-cart');
    }


    public function mount(Request $request)
    {
//        dd('test');
//        dd($request->session()->get('cart_goods'));
        $this->cart_goods = $request->session()->get('cart_goods');


        if ($this->cart_goods) {

            $this->total_price = array_reduce($this->cart_goods, function ($carry, $item) {
                return $carry + $item['yc_price'];
            });

        }


    }

    public function good_cart_add(Request $request, $good_id)
    {

        $good_to_add = Good::where('id', $good_id)->get()->toArray();
        $good_img_url = Good::where('id', $good_id)->first()->getFirstMediaUrl('good_examples');
        $good_to_add[0]['image_url'] = $good_img_url;
        $request->session()->push('cart_goods', $good_to_add[0]);
        $this->cart_goods = $request->session()->get('cart_goods');


//        if ($this->cart_goods) {
//            $this->link_goods = '';
//            foreach ($this->cart_goods as $cart_good) {
//                $this->link_goods  = $this->link_goods . $cart_good['yc_id'] . ',';
//            }
//        }
//        $this->link_goods  = rtrim($this->link_goods , ",");
//
//        $this->yc_link = 'https://b253254.yclients.com/company/247576/menu?o=s' . $this->link_goods;


        $this->total_price = array_reduce($this->cart_goods, function ($carry, $item) {
            return $carry + $item['yc_price'];
        });


        $this->dispatchBrowserEvent('trigger_good_add_button', [
            'type' => 'add',
            'id' => $good_id,
        ]);

//        dd($request->session());

    }

    public function good_cart_remove(Request $request, $good_id)
    {

        $this->cart_goods = $request->session()->get('cart_goods');
        foreach ($this->cart_goods as $key => $object) {
            if ($object['id'] == $good_id) {
                unset($this->cart_goods[$key]);
            }
        }

        session()->put('cart_goods', $this->cart_goods);

        $this->total_price = array_reduce($this->cart_goods, function ($carry, $item) {
            return $carry + $item['yc_price'];
        });

//

        $this->dispatchBrowserEvent('trigger_good_add_button', [
            'type' => 'remove',
            'id' => $good_id,
        ]);


    }

    public function good_cart_remove_all() {
        foreach ($this->cart_goods as $cart_good) {
            $this->dispatchBrowserEvent('trigger_good_add_button', [
                'type' => 'remove',
                'id' => $cart_good['id'],
            ]);
        }
        $this->cart_goods = [];
        session()->put('cart_goods', $this->cart_goods);
    }



    public function update_good_buttons()
    {
        if ($this->cart_goods) {
            foreach ($this->cart_goods as $cart_good) {
                $this->dispatchBrowserEvent('trigger_good_add_button', [
                    'type' => 'add',
                    'id' => $cart_good['id'],
                ]);
            }
        }
    }
}
