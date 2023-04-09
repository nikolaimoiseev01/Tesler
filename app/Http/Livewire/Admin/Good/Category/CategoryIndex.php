<?php

namespace App\Http\Livewire\Admin\Good\Category;

use App\Models\Goodcategory;
use Livewire\Component;

class CategoryIndex extends Component
{
    public $goodcategories;

    protected $listeners = ['refreshCategoryIndex' => '$refresh'];

    public function render()
    {
        return view('livewire.admin.good.category.category-index');
    }


    public function mount() {
        $this->goodcategories = GoodCategory::orderBy('title')->get();
    }
}
