<?php

namespace App\Livewire\Portal\Components\Service;

use Livewire\Component;

class ModalPromo extends Component
{
    public $promo;

    public function render()
    {
        return view('livewire.portal.components.service.modal-promo');
    }
}
