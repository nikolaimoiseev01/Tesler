<?php

namespace App\Livewire\Admin\Good\Shopset;

use App\Models\Good\Good;
use App\Models\Good\ShopSet;
use App\Models\Staff;
use Illuminate\Support\Facades\File;
use LivewireUI\Modal\ModalComponent;
use Spatie\Image\Image;

class Edit extends ModalComponent
{
    public $shopset;
    public $title;
    public $all_goods;
    public $good_to_add;
    public $goods_in_shopset;
    public $staff_id;
    public $staffs;

    protected $listeners = ['refreshShopsetEdit' => '$refresh', 'new_service_to_add'];

    public function render()
    {
        $this->goods_in_shopset = Good::whereJsonContains('in_shopsets', $this->shopset['id'])
            ->get();
        return view('livewire.admin.good.shopset.edit');
    }

    public function mount($shopset_id)
    {
        $this->shopset = ShopSet::where('id', $shopset_id)->first();
        $this->title = $this->shopset['title'];
        $this->staff_id = $this->shopset['staff_id'];
        $this->all_goods = Good::where('yc_category', '<>', 'Абонементы Сеть Tesler')
            ->where('yc_category', '<>', 'Сертификаты Сеть Tesler')
            ->orderBy('name')->get();
        $this->staffs = Staff::orderBy('yc_name')->get();
    }

    public function editShopset($formData)
    {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($formData['title'] == '' || $formData['title'] === null) {
            array_push($errors_array, 'Название не заполнено.');
        }

        if ($formData['staff_id'] == '' || $formData['staff_id'] === null) {
            array_push($errors_array, 'Не выбран сотрудник.');
        }

        if ($this->shopset->getMedia('pic_shopset')->count() == 0 && !$formData['pic_shopset']) {
            array_push($errors_array, 'Основное изображение не загружено!');
        }


//        dd(implode("<br>", $errors_array));
        if (!empty($errors_array)) {
            $this->dispatch('swal_fire',
                type: 'error',
                showDenyButton: false,
                title: 'Что-то пошло не так!',
                text: implode("<br>", $errors_array),
            );

            $this->dispatch('refreshShopsetCreate');
            $this->dispatch('refreshShopsetIndex');
        }

        if (empty($errors_array)) {

            $this->shopset->update([
                'title' => $formData['title'],
                'staff_id' => $formData['staff_id'],
            ]);

            if ($formData['pic_shopset'] ?? null) {
                $pic_main_path = public_path('media/filepond_temp/' . $formData['pic_shopset']);
                Image::load($pic_main_path)
                    ->optimize()
                    ->save($pic_main_path);
                if ($this->shopset->getMedia('pic_shopset')->count() != 0) {
                    $this->shopset->getFirstMedia('pic_shopset')->delete();
                }
                $this->shopset->addMedia($pic_main_path)->toMediaCollection('pic_shopset');
                File::deleteDirectory($pic_main_path);
            }


            $this->dispatch('toast_fire', [
                'type' => 'success',
                'title' => 'ШопСет уcпешно Изменен!',
            ]);


            $this->dispatch('refreshShopsetIndex');

            $this->forceClose()->closeModal();
        }
    }

    public function new_good_to_add()
    {
        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        $good = Good::where('id', $this->good_to_add)->first();
        if ($good) {
            $in_shopsets = $good['in_shopsets'];

            if ($in_shopsets !== null) {
                $good_add_check = array_filter($in_shopsets, function ($v) {
                    return $v == $this->shopset['id'];
                });
                $good_add_check = count($good_add_check);
            } else {
                $good_add_check = 0;
            }
        }

        if ($this->good_to_add === null) {
            array_push($errors_array, 'Выберите товар!');
        }

        if ($good_add_check ?? 0 > 0) {
            array_push($errors_array, 'Этот товар уже есть в шопсете!');
        }


        if (!empty($errors_array)) {
            $this->dispatch('swal_fire',
                type: 'error',
                showDenyButton: false,
                title: 'Что-то пошло не так!',
                text: implode("<br>", $errors_array),
            );

            $this->dispatch('refreshShopsetCreate');
            $this->dispatch('refreshShopsetIndex');
        }

        if (empty($errors_array)) {


            if ($in_shopsets !== null) {
                array_push($in_shopsets, $this->shopset['id']);
                $good->update([
                    'in_shopsets' => $in_shopsets,
                ]);
            } else {
                $in_shopsets_new = [$this->shopset['id']];
                $good->update([
                    'in_shopsets' => $in_shopsets_new,
                ]);
            }

            $this->dispatch('toast_fire', [
                'type' => 'success',
                'title' => 'Товар уcпешно добавлен в ШопСет!',
            ]);
            $this->dispatch('refreshShopsetEdit');

        }
    }

    public function delete_good_in_shopset($good_id)
    {
        $good = Good::where('id', $good_id)->first();

        $in_shopsets = $good['in_shopsets'];
        unset($in_shopsets[array_search($this->shopset['id'], $in_shopsets)]);

        $good->update([
            'in_shopsets' => $in_shopsets,
        ]);

        $this->dispatch('toast_fire', [
            'type' => 'success',
            'title' => 'Товар уcпешно удален из ШопСета!',
        ]);

        $this->dispatch('refreshShopsetEdit');


    }
}
