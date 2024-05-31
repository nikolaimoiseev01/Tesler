<?php

namespace App\Livewire\Admin\Order;

use App\Models\Good\Order;
use App\Models\Good_deli_status;
use Livewire\Component;

class OrderEdit extends Component
{
    public $order;
    public $deli_statuses_all;
    public $deli_status;

    public function render()
    {

        return view('livewire.admin.order.order-edit');
    }

    public function mount($order_id) {
        $this->order = Order::where('id', $order_id)->first();
        $this->deli_statuses_all = Good_deli_status::orderBy('title')->get();
        $this->deli_status = $this->order['good_deli_status_id'];
    }

    public function make_deli_status()
    {

        $this->order->update([
            'good_deli_status_id' => $this->deli_status
        ]);

        $this->dispatch('toast_fire',
                type: 'success',
                title: 'Статус успешно изменен!',
            );
    }

    public function make_selling(\Illuminate\Http\Request $request) {
        $request->session()->put('cart_goods', null);
        $request->session()->put('cart_total', null);
        $request->session()->put('cart_goods_count', null);
    }
}
