<?php

namespace App\Http\Livewire\Admin\Promo;

use App\Models\Promo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Image\Image;

class PromoEdit extends Component
{
    public $promo;

    protected $listeners = ['refreshPromoEdit' => '$refresh', 'update_img_pre'];

    public function render()
    {
        return view('livewire.admin.promo.promo-edit');
    }

    public function mount($promo_id) {
        $this->promo = Promo::where('id', $promo_id)->first();
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
        $this->emit('refreshPromoEdit');


    }

    public function update_img_pre($media) {
        $files = $this->service->getMedia($media);
        $files->each(function ($file) use ($media) {
            $file_name  = Str::random(5) . '.' . $file->file_name;
            $this->promo->addMedia($file->getPath())->usingName($file_name)->usingFileName($file_name)->toMediaCollection($media);
            $file->delete();
        });
        $this->src_main = $this->service->getMedia($media);
    }
}
