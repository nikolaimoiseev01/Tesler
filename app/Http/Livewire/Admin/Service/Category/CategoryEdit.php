<?php

namespace App\Http\Livewire\Admin\Service\Category;

use App\Models\Category;
use App\Models\Promo;
use App\Models\Scope;
use App\Models\Staff;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Spatie\Image\Image;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CategoryEdit extends ModalComponent
{
    public $category;
    public $category_examples;
    public $staff_all;
    public $staff_to_add;

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
        $this->staff_all = Staff::orderBy('yc_name')->get();
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

            // Если есть смена категории
            if (isset($formData['pic_category'])) {
                if (!$formData['pic_category'] == null || !empty($formData['pic_category'])) {
                    // pic_category
                    $file_format = substr($formData['pic_category'], strpos($formData['pic_category'], "."));
                    $temp_path = public_path('media/filepond_temp/' . $formData['pic_category']);
                    $new_path_main_page = 'media/media_files/pics_category/pic_category_' . $this->category['id'] . '_main_page' . $file_format;
                    $new_path_main_page_full = public_path('media/media_files/pics_category/pic_category_' . $this->category['id'] . '_main_page' . $file_format);
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


    public function new_staff_to_add()
    {


        $has_staff = $this->category['staff'];

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($has_staff !== null) {
            $staff_add_check = array_filter($has_staff, function ($v) {
                return $v['id'] == intval($this->staff_to_add);
            });
            $staff_add_check = count($staff_add_check);
        } else {
            $staff_add_check = 0;
        }

        if ($this->staff_to_add === null) {
            array_push($errors_array, 'Выберите матера!');
        }

        if ($staff_add_check ?? 0 > 0) {
            array_push($errors_array, 'Этот матер уже есть в категории!');
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

            if ($has_staff !== null) { // Если уже есть что-то в поле staff
                $has_staff[] = [
                    'id' => intval($this->staff_to_add),
                    'yc_id' => Staff::where('id', intval($this->staff_to_add))->value('yc_id'),
                    'name' => Staff::where('id', intval($this->staff_to_add))->value('yc_name'),
                    'avatar' => Staff::where('id', intval($this->staff_to_add))->value('yc_avatar'),
                    'specialization' => Staff::where('id', intval($this->staff_to_add))->value('yc_specialization')
                ];
                $this->category->update([
                    'staff' => $has_staff,
                ]);
            } else {
                $has_staff_new[] = [
                    'id' => intval($this->staff_to_add),
                    'yc_id' => Staff::where('id', intval($this->staff_to_add))->value('yc_id'),
                    'name' => Staff::where('id', intval($this->staff_to_add))->value('yc_name'),
                    'avatar' => Staff::where('id', intval($this->staff_to_add))->value('yc_avatar'),
                    'specialization' => Staff::where('id', intval($this->staff_to_add))->value('yc_specialization')

                ];
                $this->category->update([
                    'staff' => $has_staff_new,
                ]);
            }

            $this->emit('refreshStaffEdit');

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Мастер успешно добавлен!',
            ]);
        }
    }


    public function delete_staff($staff_id)
    {
        $has_staff = $this->category['staff'];

        unset($has_staff[array_search($staff_id, $has_staff)]);

        $this->category->update([
            'staff' => array_values($has_staff),
        ]);

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Мастер удален!',
        ]);

        $this->emit('refreshStaffEdit');


    }


    public function delete_confirm($media_id)
    {
        $this->dispatchBrowserEvent('swal_fire', [
            'type' => 'warning',
            'title' => 'Предупреждение!',
            'text' => 'Вы уверены, что хотите удалить это фото примера?',
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
