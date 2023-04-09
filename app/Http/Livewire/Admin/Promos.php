<?php

namespace App\Http\Livewire\Admin;

use App\Models\Promo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Image\Image;

class Promos extends Component
{
    protected $listeners = ['delete_promo'];

    public $title = [];
    public $link = [];
    public $link_text = [];
    public $desc = [];
    public $pic_old = [];
    public $pic = [];
    public $test;
    public $promos;

    use WithFileUploads;

    public function render()
    {
        $this->promos = Promo::orderBy('position')->get();
        return view('livewire.admin.promos', [
            'promos' => $this->promos
        ]);
    }

    public function mount()
    {
        $this->test = 'test.png';
        $this->promos = Promo::orderBy('position')->get()->toArray();
        foreach (Promo::get() as $promo) {

            $this->title[$promo['id']] = $promo['title'];
            $this->desc[$promo['id']] = $promo['desc'];
            $this->link[$promo['id']] = $promo['link'];
            $this->link_text[$promo['id']] = $promo['link_text'];
            $this->pic_old[$promo['id']] = $promo->getFirstMediaUrl('promo_pics');
        }

    }


    public function updateOrder($list)
    {
        foreach ($list as $item) {
            Promo::find($item['value'])->update(['position' => $item['order']]);
        }
        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Порядок успешно изменен!',
        ]);
    }


    public function createPromo($formData)
    {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($formData['title'] == '') {
            array_push($errors_array, 'Название не заполнено.');
        }
        if ($formData['desc'] == '') {
            array_push($errors_array, 'Описание не заполнено.');
        }
        if ($formData['link'] == '') {
            array_push($errors_array, 'Ссылка не заполнена.');
        }
        if (!$formData['link_text']) {
            array_push($errors_array, 'Текст ссылки не заполнен!');
        }
        if (!$formData['type']) {
            array_push($errors_array, 'Тип акции не заполнен!');
        }
        if (!$formData['promo_pics']) {
            array_push($errors_array, 'Нельзя без изображения создать акцию!');
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
            $max_position = Promo::max('position') ?? 1;
            $temp_file_path = public_path('media/filepond_temp/' . $formData['promo_pics']);
            $promo = Promo::create([
                'title' => $formData['title'],
                'desc' => $formData['desc'],
                'link' => $formData['link'],
                'link_text' => $formData['link_text'],
                'type' => $formData['type'],
                'position' => $max_position + 1
            ]);
            // Оптимизируем катинку
            Image::load($temp_file_path)
                ->optimize()
                ->save($temp_file_path);
            $promo->addMedia($temp_file_path)->toMediaCollection('promo_pics');
            File::deleteDirectory($temp_file_path);
            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Акция успешно добавлена!',
            ]);
        }
        $this->dispatchBrowserEvent('update_filepond');
    }


    public function editPromo($formData)
    {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($formData['title'] == '') {
            array_push($errors_array, 'Название не заполнено.');
        }
        if ($formData['desc'] == '') {
            array_push($errors_array, 'Описание не заполнено.');
        }
        if ($formData['link'] == '') {
            array_push($errors_array, 'Ссылка не заполнена.');
        }
        if ($formData['link_text'] == '') {
            array_push($errors_array, 'Текст ссыки не заполнен.');
        }
        if ($formData['type'] == '') {
            array_push($errors_array, 'Тип акции не заполнен!');
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
            $max_position = Promo::max('position') ?? 1;

            Promo::where('id', $formData['promo_id'])->update([
                'title' => $formData['title'],
                'desc' => $formData['desc'],
                'link' => $formData['link'],
                'link_text' => $formData['link_text'],
                'type' => $formData['type']
            ]);

            if (!empty($formData['promo_pics'])) {
                $temp_file_path = public_path('media/filepond_temp/' . $formData['promo_pics']);
                // Оптимизируем катинку
                Image::load($temp_file_path)
                    ->optimize()
                    ->save($temp_file_path);
                $promo = Promo::where('id', $formData['promo_id'])->first();
                $promo->getFirstMedia('promo_pics')->delete();
                $promo->addMedia($temp_file_path)->toMediaCollection('promo_pics');
                File::deleteDirectory($temp_file_path);
            }


            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Акция успешно изменена!',
            ]);

            $this->dispatchBrowserEvent('close_form_edit');
        }

        $this->dispatchBrowserEvent('update_filepond');


    }


    public function delete_confirm($promo_id)
    {
        $promo = Promo::where('id', $promo_id)->first();
        $this->dispatchBrowserEvent('swal_fire', [
            'type' => 'warning',
            'title' => 'Предупреждение!',
            'text' => 'Вы уверены, что хотите удалить акцию "' . $promo['title'] . '" ?',
            'swal_detail_id' => $promo_id,
            'showConfirmButton' => true,
            'showDenyButton' => true,
            'swal_function_to_confirm' => 'delete_promo'
        ]);
    }

    public function delete_promo($promo_id)
    {
        $promo = Promo::where('id', $promo_id)->first();
        $promo->getFirstMedia('promo_pics')->delete();
        $promo->delete();
//        $promo->getMedia()->delete();
        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Акция успешно удалена!',
        ]);
    }
}
