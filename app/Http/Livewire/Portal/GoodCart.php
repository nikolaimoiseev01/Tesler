<?php

namespace App\Http\Livewire\Portal;

use App\Models\Good;
use App\Models\Order;
use Illuminate\Http\Request;
//use Kenvel\Tinkoff;
use Livewire\Component;
use App\TinkoffMerchantAPI; // import using namespace

class GoodCart extends Component
{
    public $cart_goods = array();
    public $yc_link;
    public $link_goods;
    public $total_price;
    public $cart_items;
    public $show_take_option = false;
    public $need_delivery = false;

    public $name;
    public $surname;
    public $mobile;
    public $city;
    public $address;
    public $index;

    public $errors_array;

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

        $this->cart_items = $request->session()->get('cart_items');



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


        $request->session()->put('cart_items', $this->cart_items + 1);

        $this->total_price = array_reduce($this->cart_goods, function ($carry, $item) {
            return $carry + $item['yc_price'];
        });


        $this->dispatchBrowserEvent('trigger_good_add_button', [
            'type' => 'add',
            'id' => $good_id,
        ]);

        $this->dispatchBrowserEvent('trigger_good_cart_open');

        $this->dispatchBrowserEvent('refresh_cart_items', [
            'items' => $this->cart_items + 1
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
        $this->dispatchBrowserEvent('trigger_good_cart_close');

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

    public function show_take_option() {
        $this->show_take_option = true;

        $this->dispatchBrowserEvent('trigger_mobile_input');
    }

    public function to_checkout() {

        // --------- Ищем ошибки в заполнении  --------- //
        $this->errors_array = [];

        if ($this->name == null) {
            array_push($this->errors_array, 'name');
        }

        if ($this->surname == null) {
            array_push($this->errors_array, 'surname');
        }

        if ($this->mobile == null) {
            array_push($this->errors_array, 'mobile');
        }
        if ($this->need_delivery == 1 && $this->city == null) {
            array_push($this->errors_array, 'city');
        }

        if ($this->need_delivery == 1 && $this->address == null) {
            array_push($this->errors_array, 'address');
        }

        if ($this->need_delivery == 1 && $this->index == null) {
            array_push($this->errors_array, 'index');
        }


        if (!empty($this->errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $this->errors_array),
            ]);
        }

        if (empty($this->errors_array)) {


            $api = new TinkoffMerchantAPI(
                ENV('TINKOFF_TERMINAL_ID'),  //Ваш Terminal_Key
                ENV('TINKOFF_TERMINAL_SECRET')   //Ваш Secret_Key
            );



            $tink_order_id = 'SITE_SELE_' . substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,16);

            $params = [
                'OrderId' => $tink_order_id,
                'Amount' => $this->total_price * 100,
                'SuccessURL' => route('order_success_page', $tink_order_id),
                'FailURL' => route('home'),
                'DATA'    => [
                    'goods' => collect($this->cart_goods)->pluck('id')->toJson(),
                    'name' => $this->name,
                    'surname' => $this->surname,
                    'mobile' => $this->mobile,
                    'need_delivery' => $this->need_delivery,
                    'city' => $this->city,
                    'address' => $this->address,
                    'index' => $this->index
                ],
            ];
            $api->init($params);
dd($api);

            if ($api->error == '') {
                Order::create([
                    'tinkoff_order_id' => $tink_order_id,
                    'tinkoff_status' => 'Платежная форма открыта',
                    'price' => $this->total_price * 100,
                    'goods' => collect($this->cart_goods)->pluck('id')->toArray(),
                    'name' => $this->name,
                    'surname' => $this->surname,
                    'mobile' => $this->mobile,
                    'need_delivery' => $this->need_delivery,
                    'city' => $this->city,
                    'address' => $this->address,
                    'index' => $this->index,
                    'good_deli_status_id' => ($this->need_delivery) ? 1 : null
                ]);

                return redirect($api->paymentUrl);
            }


        }

    }
}
