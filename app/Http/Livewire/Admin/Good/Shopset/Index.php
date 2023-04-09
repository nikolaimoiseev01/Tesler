<?php

namespace App\Http\Livewire\Admin\Good\Shopset;

use App\Models\ShopSet;
use Livewire\Component;

class Index extends Component
{
    public $shopsets;

    protected $listeners = ['refreshShopsetIndex' => '$refresh'];

    public function render()
    {
        $this->shopsets = ShopSet::orderBy('title')->get();
        return view('livewire.admin.good.shopset.index');
    }

    public function mount() {
        $this->shopsets = ShopSet::orderBy('title')->get();
    }

}
