<?php

namespace App\Http\Livewire\Admin\Service\Scope;

use App\Models\Scope;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Spatie\Image\Image;

class ScopeEdit extends ModalComponent
{
    public $scope;
    public $scope_id;
    public function render()
    {

        return view('livewire.admin.service.scope.scope-edit', [
            'scope' => $this->scope,
        ]);
    }

    public function mount($scope_id)
    {

        $this->scope = Scope::where('id', $scope_id)->first();
    }


    public function editScope($formData) {
// --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

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

            if (!$formData['pic_scope_main_page'] == null || !empty($formData['pic_scope_main_page'])) {
                // pic_scope_main_page
                $file_format = substr($formData['pic_scope_main_page'], strpos($formData['pic_scope_main_page'], "."));
                $temp_path = public_path('media/filepond_temp/' . $formData['pic_scope_main_page']);
                $new_path_main_page = 'media/media_files/pics_scope/pic_scope_' . $formData['scope_id'] . '_main_page' . $file_format;
                $new_path_main_page_full = public_path('media/media_files/pics_scope/pic_scope_' . $formData['scope_id'] . '_main_page' . $file_format);
                // Оптимизируем катинку
                Image::load($temp_path)
                    ->optimize()
                    ->save($temp_path);
                File::move($temp_path, $new_path_main_page_full);
                Scope::where('id', $formData['scope_id'])->update([
                    'pic_main_page' => $new_path_main_page,
                ]);
                File::deleteDirectory($temp_path);
            }

            if (!$formData['pic_scope_page'] == null || !empty($formData['pic_scope_page'])) {
                // pic_scope_page
                $file_format = substr($formData['pic_scope_page'], strpos($formData['pic_scope_page'], "."));
                $temp_path = public_path('media/filepond_temp/' . $formData['pic_scope_page']);
                $new_path_scope_page = 'media/media_files/pics_scope/pic_scope_' . $formData['scope_id'] . '_page' . $file_format;
                $new_path_scope_page_full = public_path('media/media_files/pics_scope/pic_scope_' . $formData['scope_id'] . '_page' . $file_format);
                // Оптимизируем катинку
                Image::load($temp_path)
                    ->optimize()
                    ->save($temp_path);
                File::move($temp_path, $new_path_scope_page_full);
                Scope::where('id', $formData['scope_id'])->update([
                    'pic_scope_page' => $new_path_scope_page,
                ]);
                File::deleteDirectory($temp_path);
            }


            Scope::where('id', $formData['scope_id'])->update([
                'name' => $formData['name'],
                'desc' => $formData['desc']
            ]);



            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Сфера успешно изменена!',
            ]);

            $this->dispatchBrowserEvent('filepond_trigger');
            $this->forceClose()->closeModal();
            $this->emit('refreshScopeIndex');

        }
    }

}
