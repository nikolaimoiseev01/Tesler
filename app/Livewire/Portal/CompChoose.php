<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class CompChoose extends Component
{
    public $chosen_yc_shop;

    public function render()
    {
        return view('livewire.portal.comp-choose');
    }

    public function mount()
    {
        $this->chosen_yc_shop = app('chosen_shop');
    }

    public function select_comp($id)
    {
        $this->chosen_yc_shop = getShopById($id);
        $minutes = 60 * 24 * 7; // 7 дней
        Cookie::queue('chosen_shop', json_encode($this->chosen_yc_shop), $minutes);
        return redirect(request()->header('Referer'));
    }
}
