<?php

namespace App\Livewire\Admin\Good\Category;

use App\Models\Good\GoodCategory;
use Illuminate\Support\Facades\File;
use LivewireUI\Modal\ModalComponent;
use Spatie\Image\Image;

class CategoryEdit extends ModalComponent
{
    public $goodcategory;
    public $title;

    protected $listeners = ['refreshCategoryEdit' => '$refresh'];

    public function render()
    {
        return view('livewire.admin.good.category.category-edit');
    }

    public function mount($goodcategory_id)
    {

        $this->goodcategory = GoodCategory::where('id', $goodcategory_id)->first();
        $this->title = $this->goodcategory['title'];
    }

    public function editgoodcategory($formData)
    {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($formData['title'] == '' || $formData['title'] === null) {
            array_push($errors_array, 'Название не заполнено.');
        }


        if ($this->goodcategory->getMedia('pic_goodcategory')->count() == 0 && !$formData['pic_goodcategory']) {
            array_push($errors_array, 'Основное изображение не загружено!');
        }

        if (!empty($errors_array)) {
            $this->dispatch('swal_fire',
                type: 'error',
                showDenyButton: false,
                showConfirmButton: false,
                title: 'Что-то пошло не так!',
                text: implode("<br>", $errors_array),
            );

            $this->dispatch('refreshgoodcategoryCreate');
            $this->dispatch('refreshgoodcategoryIndex');
        }

        if (empty($errors_array)) {

            $this->goodcategory->update([
                'title' => $formData['title']
            ]);

            if ($formData['pic_goodcategory']) {
                $pic_main_path = public_path('media/filepond_temp/' . $formData['pic_goodcategory']);
                Image::load($pic_main_path)
                    ->optimize()
                    ->save($pic_main_path);
                if ($this->goodcategory->getMedia('pic_goodcategory')->count() != 0) {
                    $this->goodcategory->getFirstMedia('pic_goodcategory')->delete();
                }
                $this->goodcategory->addMedia($pic_main_path)->toMediaCollection('pic_goodcategory');
                File::deleteDirectory($pic_main_path);
            }

            if ($formData['pic_goodcategory_small']) {
                $pic_main_path = public_path('media/filepond_temp/' . $formData['pic_goodcategory_small']);
                Image::load($pic_main_path)
                    ->optimize()
                    ->save($pic_main_path);
                if ($this->goodcategory->getMedia('pic_goodcategory_small')->count() != 0) {
                    $this->goodcategory->getFirstMedia('pic_goodcategory_small')->delete();
                }
                $this->goodcategory->addMedia($pic_main_path)->toMediaCollection('pic_goodcategory_small');
                File::deleteDirectory($pic_main_path);
            }


            $this->dispatch('toast_fire',
                type: 'success',
                title: 'Категория товара уcпешно изменена!',
            );


            $this->dispatch('refreshCategoryIndex');

            $this->forceClose()->closeModal();
        }
    }
}
