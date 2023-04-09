<?php

namespace App\Http\Livewire\Admin\Service\Category;

use App\Models\Category;
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

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Порядок категорий успешно сохранен!',
        ]);
    }


}
