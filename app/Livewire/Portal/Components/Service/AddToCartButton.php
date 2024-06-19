<?php

namespace App\Livewire\Portal\Components\Service;

use Livewire\Component;

class AddToCartButton extends Component
{

    public $service;
    public $type;
    public function render()
    {
        return view('livewire.portal.components.service.add-to-cart-button');
    }
}
