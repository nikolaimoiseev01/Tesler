<?php

namespace App\Http\Livewire\Admin;

use App\Models\interior_photo;
use App\Models\Promo;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Spatie\Image\Image;

class IteriorPhoto extends Component
{
    public $interior_pics;
    protected $listeners = ['refreshIteriorPhoto' => '$refresh', 'delete_pic'];

    public function render()
    {
        $interior_photos = interior_photo::orderBy('position')->get();

        return view('livewire.admin.iterior-photo', [
            'interior_photos' => $interior_photos
        ]);
    }

    public function createInteriorPhoto()
    {
//        dd($this->interior_pics);
        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($this->interior_pics == null || empty($this->interior_pics)) {
            array_push($errors_array, 'Изображения не найдены!');
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
            foreach ($this->interior_pics as $key=>$interior_pic) {
                $interior_photo = interior_photo::create();
                $file_format = substr($interior_pic, strpos($interior_pic, "."));
                $temp_path = public_path('media/filepond_temp/' . $interior_pic);
                $new_path = 'media/media_files/interior_pics/interior_pic_id_' . $interior_photo['id'] . $file_format;
                $new_path_full = public_path('media/media_files/interior_pics/interior_pic_id_' . $interior_photo['id'] . $file_format);
                File::move($temp_path, $new_path_full);

                $interior_photo->update([
                    'pic' => $new_path,
                    'position' => $interior_photo['id']
                ]);

                File::deleteDirectory($temp_path);
                $this->dispatchBrowserEvent('update_filepond');

                $this->interior_pics = [];

                $this->emit('refreshIteriorPhoto');
                $interior_photos = interior_photo::orderBy('position')->get();

                $this->dispatchBrowserEvent('toast_fire', [
                    'type' => 'success',
                    'title' => 'Фотографии успешно добавлены!',
                ]);

            }
        }

    }

    public function updateOrder($list)
    {
        foreach ($list as $item) {
            interior_photo::find($item['value'])->update(['position' => $item['order']]);
        }

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Порядок успешно изменен!',
        ]);
    }

    public function delete_confirm($pic_id)
    {
        $interior_pic = interior_photo::where('id', $pic_id)->first();
        $this->dispatchBrowserEvent('swal_fire', [
            'type' => 'warning',
            'title' => 'Предупреждение!',
            'text' => 'Вы уверены, что хотите удалить фото?',
            'swal_detail_id' => $pic_id,
            'showConfirmButton' => true,
            'showDenyButton' => true,
            'swal_function_to_confirm' => 'delete_pic'
        ]);
    }

    public function delete_pic($pic_id)
    {
        $interior_pic = interior_photo::where('id', $pic_id)->first();
        File::delete(public_path($interior_pic['pic']));
        $interior_pic->delete();
        $this->emit('refreshIteriorPhoto');
        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Фото успешно удалено!',
        ]);
    }
}
