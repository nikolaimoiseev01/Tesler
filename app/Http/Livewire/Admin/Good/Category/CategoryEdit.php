<?php

namespace App\Http\Livewire\Admin\Good\Category;

use App\Models\Good;
use App\Models\GoodCategory;
use App\Models\Staff;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Spatie\Image\Image;

class CategoryEdit extends ModalComponent
{
    protected $listeners = ['refreshCategoryEdit' => '$refresh'];

    public function render()
    {
        return view('livewire.admin.good.category.category-edit');
    }

    public function mount($GoodCategory_id)
    {
        $this->GoodCategory = GoodCategory::where('id', $GoodCategory_id)->first();
        $this->title = $this->GoodCategory['title'];
    }

    public function editGoodCategory($formData)
    {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($formData['title'] == '' || $formData['title'] === null) {
            array_push($errors_array, 'Название не заполнено.');
        }


        if ($this->GoodCategory->getMedia('pic_GoodCategory')->count() == 0 && !$formData['pic_GoodCategory']) {
            array_push($errors_array, 'Основное изображение не загружено!');
        }

        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

            $this->emit('refreshGoodCategoryCreate');
            $this->emit('refreshGoodCategoryIndex');
        }

        if (empty($errors_array)) {

            $this->GoodCategory->update([
                'title' => $formData['title']
            ]);

            if ($formData['pic_GoodCategory']) {
                $pic_main_path = public_path('media/filepond_temp/' . $formData['pic_GoodCategory']);
                Image::load($pic_main_path)
                    ->optimize()
                    ->save($pic_main_path);
                if ($this->GoodCategory->getMedia('pic_GoodCategory')->count() != 0) {
                    $this->GoodCategory->getFirstMedia('pic_GoodCategory')->delete();
                }
                $this->GoodCategory->addMedia($pic_main_path)->toMediaCollection('pic_GoodCategory');
                File::deleteDirectory($pic_main_path);
            }

            if ($formData['pic_GoodCategory_small']) {
                $pic_main_path = public_path('media/filepond_temp/' . $formData['pic_GoodCategory_small']);
                Image::load($pic_main_path)
                    ->optimize()
                    ->save($pic_main_path);
                if ($this->GoodCategory->getMedia('pic_GoodCategory_small')->count() != 0) {
                    $this->GoodCategory->getFirstMedia('pic_GoodCategory_small')->delete();
                }
                $this->GoodCategory->addMedia($pic_main_path)->toMediaCollection('pic_GoodCategory_small');
                File::deleteDirectory($pic_main_path);
            }


            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Категория товара уcпешно изменена!',
            ]);


            $this->emit('refreshCategoryIndex');

            $this->forceClose()->closeModal();
        }
    }
}
