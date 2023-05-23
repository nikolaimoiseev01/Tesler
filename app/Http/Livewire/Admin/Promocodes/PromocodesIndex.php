<?php

namespace App\Http\Livewire\Admin\Promocodes;

use App\Models\Promocode;
use Livewire\Component;

class PromocodesIndex extends Component
{
    public function render()
    {
        $promos = Promocode::orderBy()
        return view('livewire.admin.promocodes.promocodes-index');
    }
}
