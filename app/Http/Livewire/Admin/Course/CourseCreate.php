<?php

namespace App\Http\Livewire\Admin\Course;

use App\Models\course;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class CourseCreate extends ModalComponent
{
    public $title;

    public function render()
    {
        return view('livewire.admin.course.course-create');
    }

    public function createCourse($formData) {
        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($this->title == null) {
            array_push($errors_array, 'Название не заполнено!');
        }

        if (!empty($errors_array)) {

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'error',
                'title' => implode("<br>", $errors_array),
            ]);
        }

        if (empty($errors_array)) {

            $course = course::create([
                'title' => $this->title,
            ]);

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Курс успешно создан!',
            ]);


            $this->redirect(route('course.index'));

        }
    }
}
