<?php

namespace App\Http\Livewire\Admin\Service\Category;

use App\Models\Category;
use App\Models\Scope;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Spatie\Image\Image;

class CategoryCreate extends ModalComponent
{
    public $name;
    public $desc;
    protected $listeners = ['delete_pic'];

    public function render()
    {
        $scopes = Scope::all();
        return view('livewire.admin.service.category.category-create', [
            'scopes' => $scopes
        ]);
    }

    public function createCategory($formData)
    {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($formData['pic_category'] == null || empty($formData['pic_category'])) {
            array_push($errors_array, 'Изображения не найдены!');
        }

        if ($formData['scope_id'] == '') {
            array_push($errors_array, 'Сфера не выбрана.');
        }

        if ($formData['name'] == '') {
            array_push($errors_array, 'Название не заполнено.');
        }
        if ($formData['desc'] == '') {
            array_push($errors_array, 'Опиcание не заполнено.');
        }

        if ($formData['block_title'] == '') {
            array_push($errors_array, 'Заголовок не заполнено.');
        }



        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

            $this->dispatchBrowserEvent('filepond_trigger');
        }

        if (empty($errors_array)) {

            $max_position = Category::max('position') ?? 1;

            // pic_category
            $file_format = substr($formData['pic_category'], strpos($formData['pic_category'], "."));
            $temp_path = public_path('media/filepond_temp/' . $formData['pic_category']);
            $new_path = 'media/media_files/pics_category/pic_category_' . $max_position . $file_format;
            $new_path_full = public_path('media/media_files/pics_category/pic_category_' . $max_position . $file_format);
            // Оптимизируем катинку
            Image::load($temp_path)
                ->optimize()
                ->save($temp_path);
            File::move($temp_path, $new_path_full);


            $category = Category::create([
                'scope_id' => intval($formData['scope_id']),
                'name' => $formData['name'],
                'desc' => $formData['desc'],
                'block_title' => $formData['block_title'],
                'pic' => $new_path,
                'position' => $max_position + 1
            ]);

            File::deleteDirectory($temp_path);
            $this->dispatchBrowserEvent('update_filepond');

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Категория уcпешно добавлена!',
            ]);

            $this->dispatchBrowserEvent('filepond_trigger');
            return $this->redirect(route('category.index'));

        }
    }
}
