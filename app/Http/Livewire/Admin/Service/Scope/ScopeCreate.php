<?php

namespace App\Http\Livewire\Admin\Service\Scope;

use App\Models\interior_photo;
use App\Models\Scope;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Spatie\Image\Image;

class ScopeCreate extends ModalComponent
{
    public $pic_scope_main_page;
    public $pic_scope_page;
    public $name;
    public $desc;
    protected $listeners = ['delete_pic'];

    public function render()
    {
        return view('livewire.admin.service.scope.scope-create');
    }

    public function createScope($formData)
    {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($formData['pic_scope_main_page'] == null || empty($formData['pic_scope_main_page'])) {
            array_push($errors_array, 'Изображения не найдены!');
        }

        if ($formData['pic_scope_page'] == null || empty($formData['pic_scope_page'])) {
            array_push($errors_array, 'Изображения не найдены!');
        }

        if ($formData['name'] == '') {
            array_push($errors_array, 'Название не заполнено.');
        }
        if ($formData['desc'] == '') {
            array_push($errors_array, 'Описание не заполнено.');
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

            $max_position = Scope::max('position') ?? 1;

            // pic_scope_main_page
            $file_format = substr($formData['pic_scope_main_page'], strpos($formData['pic_scope_main_page'], "."));
            $temp_path = public_path('media/filepond_temp/' . $formData['pic_scope_main_page']);
            $new_path_main_page = 'media/media_files/pics_scope/pic_scope_' . $max_position . '_main_page' . $file_format;
            $new_path_main_page_full = public_path('media/media_files/pics_scope/pic_scope_' . $max_position . '_main_page' . $file_format);
            Image::load($temp_path)
                ->optimize()
                ->save($temp_path);
            File::move($temp_path, $new_path_main_page_full);

            // pic_scope_page
            $file_format = substr($formData['pic_scope_page'], strpos($formData['pic_scope_page'], "."));
            $temp_path = public_path('media/filepond_temp/' . $formData['pic_scope_page']);
            $new_path_scope_page = 'media/media_files/pics_scope/pic_scope_' . $max_position . '_page' . $file_format;
            $new_path_scope_page_full = public_path('media/media_files/pics_scope/pic_scope_' . $max_position . '_page' . $file_format);
            Image::load($temp_path)
                ->optimize()
                ->save($temp_path);
            File::move($temp_path, $new_path_scope_page_full);


            $scope = Scope::create([
                'name' => $formData['name'],
                'desc' => $formData['desc'],
                'pic_main_page' => $new_path_main_page,
                'pic_scope_page' => $new_path_scope_page,
                'position' => $max_position + 1
            ]);

            File::deleteDirectory($temp_path);
            $this->dispatchBrowserEvent('update_filepond');

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Сфера успешно добавлена!',
            ]);

            $this->dispatchBrowserEvent('filepond_trigger');
            $this->emit('refreshScopeIndex');
            $this->forceClose()->closeModal();

        }
    }


}
