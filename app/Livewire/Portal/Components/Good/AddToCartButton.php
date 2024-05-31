<?php

namespace App\Livewire\Portal\Components\Good;

use Livewire\Component;

class AddToCartButton extends Component
{
    public $good;
    public function render()
    {
        return view('livewire.portal.components.good.add-to-cart-button');
    }
}
