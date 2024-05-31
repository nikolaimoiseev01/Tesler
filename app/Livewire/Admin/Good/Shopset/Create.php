<?php

namespace App\Livewire\Admin\Good\Shopset;

use App\Models\Good\ShopSet;
use App\Models\Staff;
use Illuminate\Support\Facades\File;
use LivewireUI\Modal\ModalComponent;
use Spatie\Image\Image;

class Create extends ModalComponent
{
    public $pic_shopset;
    public $title;
    public $staff_id;
    public $staffs;

    protected $listeners = ['refreshShopsetCreate' => '$refresh'];

    public function render()
    {
        $this->staffs = Staff::orderBy('yc_name')->get();
        return view('livewire.admin.good.shopset.create', [
            'staffs' => $this->staffs
        ]);
    }

    public function createShopset($formData) {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($formData['title'] == '' || $formData['title'] === null) {
            array_push($errors_array, 'Название не заполнено.');
        }
        if ($formData['pic_shopset'] == '' || $formData['pic_shopset'] === null) {
            array_push($errors_array, 'Загрузите изображение!');
        }

        if ($formData['staff_id'] == '' || $formData['staff_id'] === null) {
            array_push($errors_array, 'Выберите сотрудника!');
        }

        if (!empty($errors_array)) {
            $this->dispatch('swal_fire',
                type: 'error',
                showDenyButton: false,
                showConfirmButton: false,
                title: 'Что-то пошло не так!',
                text: implode("<br>", $errors_array),
            );

            $this->dispatch('refreshShopsetCreate');
            $this->dispatch('refreshShopsetIndex');
        }

        if (empty($errors_array)) {
            $temp_file_path = public_path('media/filepond_temp/' . $formData['pic_shopset']);
            $shopset = ShopSet::create([
                'title' => $formData['title'],
                'staff_id' => $formData['staff_id'],
            ]);
            // Оптимизируем катинку
            Image::load($temp_file_path)
                ->optimize()
                ->save($temp_file_path);
            $shopset->addMedia($temp_file_path)->toMediaCollection('pic_shopset');
            File::deleteDirectory($temp_file_path);

            $this->dispatch('toast_fire',
                type: 'success',
                title: 'ШопСет уcпешно добавлен!',
            );




            $this->forceClose()->closeModal();

            $this->dispatch('refreshShopsetIndex');
        }
    }
}
