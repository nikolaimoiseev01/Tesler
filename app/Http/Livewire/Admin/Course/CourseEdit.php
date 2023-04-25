<?php

namespace App\Http\Livewire\Admin\Course;

use App\Models\Course;
use App\Models\Staff;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Spatie\Image\Image;

class CourseEdit extends Component
{
    public $course;
    public $desc;
    public $desc_small;
    public $proccess;
    public $program;
    public $dates;
    public $learning;
    public $type;
    public $price;

    public $course_examples;


    protected $listeners = ['refreshCourseEdit' => '$refresh', 'delete_course_example_media'];

    public function render()
    {
        return view('livewire.admin.course.course-edit');
    }

    public function mount($course_id)
    {
        $this->course = Course::where('id', $course_id)->first();
    }

    public function editcourse($formData)
    {


// --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($formData['title'] == '') {
            array_push($errors_array, 'Название не заполнено.');
        }
        if ($formData['desc'] == '') {
            array_push($errors_array, 'Описание не заполнено.');
        }
        if ($formData['desc_small'] == '') {
            array_push($errors_array, 'Описание маленькое не заполнен.');
        }
        if ($formData['proccess'] == '') {
            array_push($errors_array, 'Процесс не заполнен.');
        }
        if ($formData['program'] == '') {
            array_push($errors_array, 'Программа не заполнена.');
        }
        if ($formData['dates'] == '') {
            array_push($errors_array, 'Даты не заполнены.');
        }
        if ($formData['learning'] == '') {
            array_push($errors_array, 'Обучение не заполнено.');
        }
        if ($formData['type'] == '') {
            array_push($errors_array, 'Тип не заполнен.');
        }
        if ($formData['price'] == '') {
            array_push($errors_array, 'Цена не заполнена.');
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
            if (isset($formData['pic_course'])) {
                if (!$formData['pic_course'] == null || !empty($formData['pic_course'])) {
                    // pic_course
                    $file_format = substr($formData['pic_course'], strpos($formData['pic_course'], "."));
                    $temp_path = public_path('media/filepond_temp/' . $formData['pic_course']);
                    $new_path_main_page = 'media/media_files/pics_course/pic_course_' . $this->course['id'] . '_main_page' . $file_format;
                    $new_path_main_page_full = public_path('media/media_files/pics_course/pic_course_' . $this->course['id'] . '_main_page' . $file_format);
                    // Оптимизируем катинку
                    Image::load($temp_path)
                        ->optimize()
                        ->save($temp_path);
                    File::move($temp_path, $new_path_main_page_full);
                    Course::where('id', $formData['course_id'])->update([
                        'pic' => $new_path_main_page,
                    ]);
                    File::deleteDirectory($temp_path);
                }
            }


            // Если есть картинки примеров
            if (!$this->course_examples == null || !empty($this->course_examples)) {
                foreach ($this->course_examples as $key => $course_example) {
                    $file_path = public_path('media/filepond_temp/' . $course_example);
                    Image::load($file_path)
                        ->optimize()
                        ->save($file_path);
                    $this->course->addMedia($file_path)->toMediaCollection('course_examples');
                }
            }

            Course::where('id', $formData['course_id'])->update([
                'title' => $formData['title'],
                'price' => $formData['price'],
                'desc_small' => $formData['desc_small'],
                'desc' => $formData['desc'],
                'proccess' => $formData['proccess'],
                'program' => $formData['program'],
                'dates' => $formData['dates'],
                'learning' => $formData['learning'],
                'type' => $formData['type']
            ]);


            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Курс успешно изменен!',
            ]);

            $this->dispatchBrowserEvent('update_filepond');
            $this->dispatchBrowserEvent('filepond_trigger');

            $this->emit('refreshCourseEdit');

        }
    }

}
