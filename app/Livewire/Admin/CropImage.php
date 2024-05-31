<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Spatie\Image\Image;

class CropImage extends ModalComponent
{
    public $src;
    public $comp_for_refresh;
    public $min_width;
    public $min_height;
    public $cropped_img;
    public $data_crop_media;
    protected $listeners = ['save_crop'];

    public function render()
    {

        return view('livewire.admin.crop-image');
    }

    public function mount($src, $comp_for_refresh, $min_width, $min_height, $data_crop_media)
    {
        $this->src = $src;
        $this->comp_for_refresh = $comp_for_refresh;
        $this->min_width = $min_width;
        $this->min_height = $min_height;
        $this->data_crop_media = $data_crop_media;
    }

    public function save_crop()
    {


        if ($this->cropped_img ?? 0 != null) {

            // Определяем путь и название файла
            $this->src = str_replace(" ", "", $this->src);
            $this->src = str_replace("\n", "", $this->src);

            $filepathArray = pathinfo($this->src);
            $file_name = $filepathArray['basename'];
            $file_path = parse_url($this->src, PHP_URL_PATH);
            $file_path = public_path(substr($file_path, 0, strrpos($file_path, '/') + 1));

//
//
//            dd($file_path, $file_name);

            // Обрезанная картинка
            $image_parts_cropped = explode(";base64,", $this->cropped_img);
            $image_type_aux_cropped = explode("image/", $image_parts_cropped[0]);
            $image_type_cropped = $image_type_aux_cropped[1];
            $image_base64 = base64_decode($image_parts_cropped[1]);
            $filename_cropped = $filepathArray['basename'];
            $file_cropped = $file_path . $file_name;
            file_put_contents($file_cropped, $image_base64);

//            $cur_width = Image::load($file_cropped)->getWidth();
//            if ($cur_width > 600) {
//                Image::load($file_cropped)
//                    ->width(600)
//                    ->optimize()
//                    ->save($file_cropped);
//            }

            $this->dispatch('toast_fire',
                type: 'success',
                title: 'Обрезание прошло успешно',
            );

            if($this->data_crop_media <> 0) {
                $this->dispatch('update_img_pre', $this->data_crop_media);
            }

            $this->forceClose()->closeModal();

//            return redirect(request()->header('Referer'));
        }
    }

}
