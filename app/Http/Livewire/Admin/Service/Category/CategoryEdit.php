<?php

namespace App\Http\Livewire\Admin\Service\Category;

use App\Models\Category;
use App\Models\Promo;
use App\Models\Scope;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Spatie\Image\Image;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CategoryEdit extends ModalComponent
{
    public $category;
    public $category_examples;

    protected $listeners = ['refreshCategoryEdit' => '$refresh', 'delete_cat_example_media'];

    public function render()
    {

        $scopes = Scope::orderBy('id')->get();
        return view('livewire.admin.service.category.category-edit', [
            'category' => $this->category,
            'scopes' => $scopes
        ]);
    }

    public function mount($category_id)
    {
        $this->category = Category::where('id', $category_id)->first();
    }

    public function updateExamplesOrder($list)
    {
        foreach ($list as $item) {
            Media::find($item['value'])->update(['order_column' => $item['order']]);
        }

        $this->emit('refreshCategoryEdit');

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Порядок примеров успешно изменен!',
        ]);
    }

    public function editCategory($formData)
    {


// --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($formData['name'] == '') {
            array_push($errors_array, 'Название не заполнено.');
        }
        if ($formData['desc'] == '') {
            array_push($errors_array, 'Описание не заполнено.');
        }
        if ($formData['block_title'] == '') {
            array_push($errors_array, 'Заголовок не заполнен.');
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

            $max_position = category::max('position') ?? 1;

            // Если есть смена категории
            if (isset($formData['pic_category'])) {
                if (!$formData['pic_category'] == null || !empty($formData['pic_category'])) {
                    // pic_category
                    $file_format = substr($formData['pic_category'], strpos($formData['pic_category'], "."));
                    $temp_path = public_path('media/filepond_temp/' . $formData['pic_category']);
                    $new_path_main_page = 'media/media_files/pics_category/pic_category_' . $max_position . '_main_page' . $file_format;
                    $new_path_main_page_full = public_path('media/media_files/pics_category/pic_category_' . $max_position . '_main_page' . $file_format);
                    // Оптимизируем катинку
                    Image::load($temp_path)
                        ->optimize()
                        ->save($temp_path);
                    File::move($temp_path, $new_path_main_page_full);
                    category::where('id', $formData['category_id'])->update([
                        'pic' => $new_path_main_page,
                    ]);
                    File::deleteDirectory($temp_path);

                }
            }


            // Если есть картинки примеров
            if (!$this->category_examples == null || !empty($this->category_examples)) {
                foreach ($this->category_examples as $key => $category_example) {
                    $file_path = public_path('media/filepond_temp/' . $category_example);
                    Image::load($file_path)
                        ->optimize()
                        ->save($file_path);
                    $this->category->addMedia($file_path)->toMediaCollection('category_examples');
                }
            }

            category::where('id', $formData['category_id'])->update([
                'scope_id' => intval($formData['scope_id']),
                'name' => $formData['name'],
                'desc' => $formData['desc'],
                'block_title' => $formData['block_title'],
            ]);


            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Категория успешно изменена!',
            ]);

            $this->dispatchBrowserEvent('update_filepond');
            $this->dispatchBrowserEvent('filepond_trigger');

            $this->emit('refreshCategoryEdit');

        }
    }


    public function delete_confirm($media_id)
    {
        $this->dispatchBrowserEvent('swal_fire', [
            'type' => 'warning',
            'title' => 'Предупреждение!',
            'text' => 'Вы уверены, что хотите это фото примера?',
            'swal_detail_id' => $media_id,
            'showConfirmButton' => true,
            'showDenyButton' => true,
            'swal_function_to_confirm' => 'delete_cat_example_media'
        ]);
    }

    public function delete_cat_example_media($media_id)
    {
        $media = Media::where('id', $media_id)->first();
        $media->delete();
        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Фото примера успешно удалено!',
        ]);
        $this->emit('refreshCategoryEdit');
    }
}
