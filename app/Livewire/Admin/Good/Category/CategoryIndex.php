<?php

namespace App\Livewire\Admin\Good\Category;

use App\Models\Good\GoodCategory;
use Livewire\Component;

class CategoryIndex extends Component
{
    public $goodcategories;

    protected $listeners = ['refreshCategoryIndex' => '$refresh'];

    public function render()
    {
        $this->goodcategories = GoodCategory::orderBy('position')->get();
        return view('livewire.admin.good.category.category-index');
    }


    public function mount() {
        $this->goodcategories = GoodCategory::orderBy('position')->get();
    }

    public function updateOrder($list)
    {
        foreach ($list as $item) {
            GoodCategory::find($item['value'])->update(['position' => $item['order']]);
        }
        $this->dispatch('toast_fire',
                type: 'success',
                title: 'Порядок успешно изменен!',
            );

        $this->goodcategories = GoodCategory::orderBy('position')->get();

        $this->dispatch('refreshCategoryIndex');
    }

}
