<?php

namespace App\Http\Livewire\Admin\Staff;

use App\Models\Category;
use App\Models\staff;
use Livewire\Component;
use Spatie\Image\Image;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class StaffEdit extends Component
{
    public $staff;
    public $desc_small;
    public $desc;
    public $staff_examples;

    protected $listeners = ['refreshGoodEdit' => '$refresh', 'delete_good_example_media'];

    public function render()
    {
        return view('livewire.admin.staff.staff-edit');
    }

    public function mount($staff_id)
    {
        $this->staff = Staff::where('id', $staff_id)->first();
        $this->desc_small = $this->staff['desc_small'];
        $this->desc = $this->staff['desc'];
    }

    public function editstaff($formData)
    {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];


        if ($this->desc_small == null) {
            array_push($errors_array, 'Маленькое описание не заполнено!');
        }

        if ($this->desc == null) {
            array_push($errors_array, 'Описание не заполнено!');
        }


        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

            $this->flg_active = 0;
        }

        if (empty($errors_array)) {

            $this->staff->update([
                'desc_small' => $this->desc_small,
                'desc' => $this->desc,
            ]);

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Сотрудник успешно обновлен!',
            ]);
        }

    }


    public function new_staff_examples()
    {
        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($this->staff_examples == null || empty($this->staff_examples)) {
            array_push($errors_array, 'Выберите изображения!');
        }


        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

        }

        if (empty($errors_array)) {
            // Если есть картинки примеров
            if (!$this->staff_examples == null || !empty($this->staff_examples)) {
                foreach ($this->staff_examples as $key => $staff_example) {
                    $file_path = public_path('media/filepond_temp/' . $staff_example);
                    Image::load($file_path)
                        ->optimize()
                        ->save($file_path);
                    $this->staff->addMedia($file_path)->toMediaCollection('staff_examples');
                }
            }

            $this->dispatchBrowserEvent('update_filepond');
            $this->dispatchBrowserEvent('filepond_trigger');
            $this->emit('refreshGoodEdit');

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Пример успешно добавлены!',
            ]);
        }
    }

    public function updateExamplesOrder($list)
    {
        foreach ($list as $item) {
            Media::find($item['value'])->update(['order_column' => $item['order']]);
        }

        $this->emit('refreshstaffEdit');

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Порядок примеров успешно изменен!',
        ]);
    }



    public function delete_example_confirm($media_id)
    {
        $this->dispatchBrowserEvent('swal_fire', [
            'type' => 'warning',
            'title' => 'Предупреждение!',
            'text' => 'Вы уверены, что хотите это фото примера?',
            'swal_detail_id' => $media_id,
            'showConfirmButton' => true,
            'showDenyButton' => true,
            'swal_function_to_confirm' => 'delete_staff_example_media'
        ]);
    }

    public function delete_staff_example_media($media_id)
    {
        $media = Media::where('id', $media_id)->first();
        $media->delete();
        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Фото примера успешно удалено!',
        ]);
        $this->emit('refreshstaffEdit');
    }
}
