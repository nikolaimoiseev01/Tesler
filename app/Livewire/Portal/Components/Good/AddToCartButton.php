<?php

namespace App\Livewire\Portal\Components\Good;

use Livewire\Component;

class AddToCartButton extends Component
{
    public $good;
    public $type;
    public $good_in_salon_check;
    public function render()
    {
        $this->chosen_yc_shop = app('chosen_shop');
        $this->good_in_salon_check = collect(json_decode($this->good['yc_ids']))->firstWhere('salon_id',  $this->chosen_yc_shop['id'])->good_id ?? null;
        return view('livewire.portal.components.good.add-to-cart-button');
    }
}
