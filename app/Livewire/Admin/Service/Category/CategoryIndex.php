<?php

namespace App\Livewire\Admin\Service\Category;

use App\Models\Service\Category;
use Livewire\Component;

class CategoryIndex extends Component
{
    protected $listeners = ['refreshCategoryIndex' => '$refresh'];

    public function render()
    {
        $categories = Category::orderBy('position')->get();
        return view('livewire.admin.service.category.category-index', [
            'categories' => $categories,
        ]);
    }


    public function updateOrder($list)
    {
        foreach ($list as $item) {
            Category::find($item['value'])->update(['position' => $item['order']]);
        }

        $this->dispatch('toast_fire',
                type: 'success',
                title: 'Порядок категорий успешно сохранен!',
            );
    }


}
