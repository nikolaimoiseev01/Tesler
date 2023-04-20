<?php

namespace App\Http\Livewire\Admin\Good\Category;

use App\Models\GoodCategory;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Spatie\Image\Image;

class CategoryCreate extends ModalComponent
{
    protected $listeners = ['refreshCategoryCreate' => '$refresh'];

    public function render()
    {
        return view('livewire.admin.good.category.category-create');
    }

    public function createGoodCategory($formData) {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($formData['title'] == '' || $formData['title'] === null) {
            array_push($errors_array, 'Название не заполнено.');
        }

        if ($formData['pic_GoodCategory'] == '' || $formData['pic_GoodCategory'] === null) {
            array_push($errors_array, 'Загрузите основное изображение!');
        }

        if ($formData['pic_GoodCategory_small'] == '' || $formData['pic_GoodCategory_small'] === null) {
            array_push($errors_array, 'Загрузите маленькое изображение!');
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

            $GoodCategory = GoodCategory::create([
                'title' => $formData['title']
            ]);

            // БОЛЬШАЯ КАРТИНКА
            $temp_file_path = public_path('media/filepond_temp/' . $formData['pic_GoodCategory']);
            // Оптимизируем катинку
            Image::load($temp_file_path)
                ->optimize()
                ->save($temp_file_path);
            $GoodCategory->addMedia($temp_file_path)->toMediaCollection('pic_GoodCategory');
            File::deleteDirectory($temp_file_path);

            // МАЛЕНЬКАЯ КАРТИНКА
            $temp_file_path = public_path('media/filepond_temp/' . $formData['pic_GoodCategory_small']);
            // Оптимизируем катинку
            Image::load($temp_file_path)
                ->optimize()
                ->save($temp_file_path);
            $GoodCategory->addMedia($temp_file_path)->toMediaCollection('pic_GoodCategory_small');
            File::deleteDirectory($temp_file_path);

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Категория товара уcпешно добавлена!',
            ]);



            $this->emit('refreshCategoryIndex');

            $this->forceClose()->closeModal();

        }
    }
}
