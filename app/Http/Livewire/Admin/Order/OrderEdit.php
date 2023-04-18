<?php

namespace App\Http\Livewire\Admin\Order;

use App\Models\Consultation;
use App\Models\Good_deli_status;
use App\Models\Order;
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

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Статус успешно изменен!',
        ]);
    }
}
