<?php

namespace App\Livewire\Portal;

use App\Models\Good\Good;
use App\Models\Good\Order;
use App\Models\Good\Promocode;
use App\Services\YcApiRequest;
use App\TinkoffMerchantAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

//use Kenvel\Tinkoff;

// import using namespace

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

    public $delivery_price_treshhold = 6000;
    public $delivery_price_treshhold_home = 3500;
    public $delivery_price = 600;

    public $cart_goods_count;
    public $cart_services_count;

    public $cart_total;

    public $errors_array;

    public $promocode;
    public $discount = 0;

    public $chosen_yc_shop;

    protected $listeners = ['good_cart_add', 'update_good_buttons', 'show_red_cart_g'];

    public function render()
    {
        $this->chosen_yc_shop = app('chosen_shop');
        return view('livewire.portal.good-cart');
    }


    public function mount(Request $request)
    {

        $this->cart_items = $request->session()->get('cart_items');
        $this->cart_total = $request->session()->get('cart_total');
        $this->cart_goods_count = $request->session()->get('cart_goods_count');
        $this->cart_services_count = $request->session()->get('cart_services_count');
        $this->cart_goods = $request->session()->get('cart_goods');


        if ($this->cart_goods) {

            $this->total_price = array_reduce($this->cart_goods, function ($carry, $item) {
                return $carry + (($item['yc_price'] * ((100 - $item['discount']) / 100)) * ($item['sell_amount'] ?? 1));
            });

        }


    }


    public function update_counter(Request $request, $counter_good_id, $dir)
    {


        foreach ($this->cart_goods as $cart_good) { // Идем по всем товарам в корзине
            if ($cart_good['id'] === $counter_good_id) { // Чтобы понять, какой товар изменять
                $index = array_search($cart_good, $this->cart_goods); // Чтобы понять, какой товар изменять
                $sell_amount = $cart_good['sell_amount'] ?? 1;
                if (($sell_amount == 1 && $dir == 1) || $sell_amount > 1) { // Чтобы не уходить в минус
                    if ($dir == -1 || ($cart_good['sell_amount'] < $cart_good['yc_actual_amount'])) // Чтобы не брать больше, чем в наличии
                        $this->cart_goods[$index]['sell_amount'] = $sell_amount + $dir;
                }
            }
        }

        $this->total_price = array_reduce($this->cart_goods, function ($carry, $item) {
            return $carry + (($item['yc_price'] * ((100 - $item['discount']) / 100)) * ($item['sell_amount'] ?? 1));
        });

        $request->session()->put('cart_goods', $this->cart_goods);


    }

    public function applyPromo()
    {
        $this->errors_array = [];

        $dis = Promocode::where('title', $this->promocode)->first() ?? null;
        if ($dis) {
            $this->discount = $dis['discount'];

        } else {
            array_push($this->errors_array, 'promo');
            $this->discount = 0;
        }

    }

    public function good_cart_add(Request $request, $good_id)
    {

        $good_to_add = Good::where('id', $good_id)->first();
        $good_first_media = $good_to_add->getFirstMediaUrl('good_examples');
        $good_img_url = $good_first_media != null ? $good_first_media : config('cons.default_pic');
        $good_to_add = $good_to_add->toArray();
        $good_to_add['image_url'] = $good_img_url;
        $good_to_add['sell_amount'] = 1;

        $yc_good = (new YcApiRequest)->make_request(
            'goods',
            $good_to_add['yc_id']
        );

        if ($yc_good['loyalty_certificate_type_id'] !== 0) { // Если это сертификат
            $url = 'https://o3194.yclients.com/loyalty/certificate/' . $yc_good['loyalty_certificate_type_id'];
            return redirect($url);
        }

        if ($yc_good['loyalty_abonement_type_id'] !== 0) { // Если это абонемент
            $url = 'https://o3194.yclients.com/loyalty/subscription/' . $yc_good['loyalty_abonement_type_id'];
            return redirect($url);
        }

        if ($yc_good['loyalty_abonement_type_id'] === 0 && $yc_good['loyalty_certificate_type_id'] == 0) {

            $request->session()->push('cart_goods', $good_to_add);
            $this->cart_goods = $request->session()->get('cart_goods');

            $request->session()->put('cart_items', $this->cart_items + 1);

            $this->total_price = array_reduce($this->cart_goods, function ($carry, $item) {
                return $carry + (($item['yc_price'] * ((100 - $item['discount']) / 100)) * ($item['sell_amount'] ?? 1));
            });
            if ($this->need_delivery && $this->total_price < 3500) {
                $this->total_price = $this->total_price + 600;
            }


            $this->dispatch('trigger_good_add_button',
                type: 'add',
                id: $good_id,
            );

            $this->dispatch('trigger_good_cart_open');

            $this->dispatch('refresh_cart_items',
                items: $this->cart_items + 1,
            );

            $this->cart_total += 1;
            $this->cart_goods_count += 1;
            $request->session()->put('cart_total', $this->cart_total);
            $request->session()->put('cart_goods_count', $this->cart_goods_count);

            $this->dispatch('update_red_cart',
                cart_total: $this->cart_total,
                cart_services_count: $this->cart_services_count,
                cart_goods_count: $this->cart_goods_count,
            );
        }

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
            return $carry + (($item['yc_price'] * ((100 - $item['discount']) / 100)) * ($item['sell_amount'] ?? 1));
        });
        if ($this->need_delivery && $this->total_price < 3500) {
            $this->total_price = $this->total_price + 600;
        }

        $this->cart_total -= 1;
        $this->cart_goods_count -= 1;
        $request->session()->put('cart_total', $this->cart_total);
        $request->session()->put('cart_goods_count', $this->cart_goods_count);

        $this->dispatch('update_red_cart',
            cart_total: $this->cart_total,
            cart_services_count: $this->cart_services_count,
            cart_goods_count: $this->cart_goods_count,
        );

//

        $this->dispatch('trigger_good_add_button',
            type: 'remove',
            id: $good_id,
        );


    }

    public function good_cart_remove_all(Request $request)
    {

        $goods_before_remove = count($this->cart_goods);
        foreach ($this->cart_goods as $cart_good) {
            $this->dispatch('trigger_good_add_button',
                type: 'remove',
                id: $cart_good['id'],
            );
        }
        $this->cart_goods = [];
        $this->dispatch('trigger_good_cart_close');

        $this->cart_total -= $goods_before_remove;
        $this->cart_goods_count -= $goods_before_remove;
        $request->session()->put('cart_total', $this->cart_total);
        $request->session()->put('cart_goods_count', $this->cart_goods_count);

        $this->dispatch('update_red_cart',
            cart_total: $this->cart_total,
            cart_services_count: $this->cart_services_count,
            cart_goods_count: $this->cart_goods_count,
        );

        session()->put('cart_goods', $this->cart_goods);
    }

    public function update_good_buttons()
    {
        if ($this->cart_goods) {
            foreach ($this->cart_goods as $cart_good) {
                $this->dispatch('trigger_good_add_button',
                    type: 'add',
                    id: $cart_good['id'],
                );
            }
        }
    }

    public function show_take_option_true()
    {

        $this->errors_array = [];

        foreach ($this->cart_goods as $key => $cart_good) { // Обновляем кол-во оставшегося товара
            $original_good = Good::where('id', $cart_good['id'])->first();

            if ($original_good['yc_actual_amount'] == 0 || $original_good['yc_actual_amount'] < $cart_good['yc_actual_amount']) { // Если остаток не такой, уведомляем!
                $this->cart_goods[$key]['yc_actual_amount'] = $original_good['yc_actual_amount'];
                array_push($this->errors_array, 'update_goods_amounts');
            }

        }

        if (empty($this->errors_array)) {
            $this->show_take_option = !$this->show_take_option;
            $this->dispatch('trigger_mobile_input');
        }
    }

    public function dehydrateNeedDelivery()
    {

//        $this->errors_array = [];
////        dd('test');
//        if ($this->city) {
//            $this->need_delivery = true;
//        } else {
////            dd('test');
//            array_push($this->errors_array, 'city');
//            $this->need_delivery = false;
//        }
    }

    public function to_checkout(Request $request)
    {

        dd($this->chosen_yc_shop);

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


        foreach ($this->cart_goods as $key => $cart_good) { // Обновляем кол-во оставшегося товара
            $original_good = Good::where('id', $cart_good['id'])->first();

            if ($original_good['yc_actual_amount'] <> $cart_good['yc_actual_amount']) { // Если остаток не такой, уведомляем!
                $this->cart_goods[$key]['yc_actual_amount'] = $original_good['yc_actual_amount'];
                array_push($this->errors_array, 'update_goods_amounts');
            }

        }

        if (empty($this->errors_array)) {


            $api = new TinkoffMerchantAPI(
                ENV('TINKOFF_TERMINAL_ID'),  //Ваш Terminal_Key
                ENV('TINKOFF_TERMINAL_SECRET')   //Ваш Secret_Key
            );


            $tink_order_id = 'SITE_SELE_' . substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 16);

            foreach ($this->cart_goods as $cart_good) {
                $tinkoff_good[] = [
                    'good_id' => $cart_good['id'],
                    'good_yc_id' => $cart_good['yc_id'],
                    'good_price' => ($cart_good['yc_price'] * ((100 - $cart_good['discount']) / 100)) * ((100 - $this->discount) / 100),
                    'amount' => $cart_good['sell_amount']
                ];
            }


            if ($this->need_delivery
                && (($this->city <> 'Красноярск' && $this->total_price < $this->delivery_price_treshhold)
                    || ($this->city == 'Красноярск' && $this->total_price < $this->delivery_price_treshhold_home))
            ) {
                $this->total_price = $this->total_price + $this->delivery_price;
            }

            $params = [
                'OrderId' => $tink_order_id,
                'Amount' => ($this->total_price * ((100 - $this->discount) / 100)) * 100,
                'SuccessURL' => route('order_success_page', $tink_order_id),
                'FailURL' => route('home'),
                'DATA' => [
                    'goods' => json_encode($tinkoff_good),
                    'name' => $this->name,
                    'surname' => $this->surname,
                    'mobile' => $this->mobile,
                    'need_delivery' => $this->need_delivery,
                    'city' => $this->city,
                    'address' => $this->address
                ],
            ];
            $api->init($params);


            if ($api->error == '') {
                Order::create([
                    'tinkoff_order_id' => $tink_order_id,
                    'tinkoff_status' => 'Платежная форма открыта',
                    'price' => ($this->total_price * ((100 - $this->discount) / 100)) * 100,
                    'goods' => json_encode($tinkoff_good),
                    'name' => $this->name,
                    'surname' => $this->surname,
                    'promocode' => $this->promocode,
                    'mobile' => $this->mobile,
                    'need_delivery' => $this->need_delivery,
                    'city' => $this->city,
                    'address' => $this->address,
                    'good_deli_status_id' => ($this->need_delivery) ? 1 : null
                ]);

                return redirect($api->paymentUrl);
            }


        }

    }
}
