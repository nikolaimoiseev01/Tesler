<?php

namespace App\Http\Livewire\Admin\Staff;

use App\Models\Category;
use App\Models\collegue;
use App\Models\Good;
use App\Models\ShopSet;
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
    public $flg_active;
    public $collegues_all;
    public $collegue_to_add;
    public $selected_shopset;
    public $shopsets_all;
    public $selected_sert;
    public $serts_all;
    public $selected_abon;
    public $abon_all;


    protected $listeners = ['refreshStaffEdit' => '$refresh', 'delete_good_example_media'];

    public function render()
    {
        return view('livewire.admin.staff.staff-edit');
    }

    public function mount($staff_id)
    {
        $this->staff = Staff::where('id', $staff_id)->first();
        $this->desc_small = $this->staff['desc_small'];
        $this->desc = $this->staff['desc'];
        $this->selected_shopset = $this->staff['selected_shopset'];
        $this->selected_sert = $this->staff['selected_sert'];
        $this->selected_abon = $this->staff['selected_abon'];
        $this->flg_active = $this->staff['flg_active'];

        $this->collegues_all = Staff::orderBy('yc_name')->get();
        $this->shopsets_all = ShopSet::orderBy('title')->get();
        $this->serts_all = Good::whereJsonContains('good_category_id', 6)->orderBy('name')->get();
        $this->abon_all = Good::whereJsonContains('good_category_id', 7)->orderBy('name')->get();

    }

    public function toggleActivity()
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

            $this->flg_active = $this->staff['flg_active'];
        }

        if (empty($errors_array)) {
            $this->staff->update([
                'flg_active' => $this->flg_active,
            ]);

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => $this->flg_active ? 'Сотрудник появился на сайте' : 'Сотрудник скрыт с сайта',
            ]);
        }

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
                'selected_shopset' => $this->selected_shopset,
                'selected_abon' => $this->selected_abon,
                'selected_sert' => $this->selected_sert,
            ]);

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Сотрудник успешно обновлен!',
            ]);
        }

    }


    public function new_collegue_to_add()
    {


        $has_collegues = $this->staff['collegues'];

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($has_collegues !== null) {
            $collegue_add_check = array_filter($has_collegues, function ($v) {
                return $v['id'] == intval($this->collegue_to_add);
            });
            $collegue_add_check = count($collegue_add_check);
        } else {
            $collegue_add_check = 0;
        }

        if ($this->collegue_to_add === null) {
            array_push($errors_array, 'Выберите коллегу!');
        }

        if ($collegue_add_check ?? 0 > 0) {
            array_push($errors_array, 'Этот коллега уже есть!');
        }


        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

            $this->emit('refreshCalcCosmetic');
        }

        if (empty($errors_array)) {

            if ($has_collegues !== null) { // Если уже есть что-то в поле collegues
                $has_collegues[] = [
                    'id' => intval($this->collegue_to_add),
                    'yc_id' => Staff::where('id', intval($this->collegue_to_add))->value('yc_id'),
                    'name' => Staff::where('id', intval($this->collegue_to_add))->value('yc_name'),
                    'avatar' => Staff::where('id', intval($this->collegue_to_add))->value('yc_avatar'),
                    'specialization' => Staff::where('id', intval($this->collegue_to_add))->value('yc_specialization')
                ];
                $this->staff->update([
                    'collegues' => $has_collegues,
                ]);
            } else {
                $has_collegues_new[] = [
                    'id' => intval($this->collegue_to_add),
                    'yc_id' => Staff::where('id', intval($this->collegue_to_add))->value('yc_id'),
                    'name' => Staff::where('id', intval($this->collegue_to_add))->value('yc_name'),
                    'avatar' => Staff::where('id', intval($this->collegue_to_add))->value('yc_avatar'),
                    'specialization' => Staff::where('id', intval($this->collegue_to_add))->value('yc_specialization')

                ];
                $this->staff->update([
                    'collegues' => $has_collegues_new,
                ]);
            }

            $this->emit('refreshStaffEdit');

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Коллега успешно добавлен!',
            ]);
        }
    }

    public function delete_collegue($collegue_id)
    {
        $has_collegues = $this->staff['collegues'];

        unset($has_collegues[array_search($collegue_id, $has_collegues)]);

        $this->staff->update([
            'collegues' => array_values($has_collegues),
        ]);

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Коллега удален!',
        ]);

        $this->emit('refreshStaffEdit');


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

            $this->emit('refreshStaffEdit');

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
