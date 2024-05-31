<?php

namespace App\Livewire\Portal;

use App\Models\Course\Course;
use App\Models\Course\CourseApp;
use App\Models\User;
use App\Notifications\MailNotification;
use App\Notifications\TelegramNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class CourseAppModal extends Component
{
    public $course_app_answered_check;
    public $course;

    public function render()
    {
        return view('livewire.portal.course-app-modal');
    }

    public function mount(Request $request, $course_id) {
        $this->course = Course::where('id', $course_id)->first();
        $this->course_app_answered_check = false;
    }

    public function createCourseApp($formData)
    {
        CourseApp::create([
            'user_name' => $formData['name'],
            'user_mobile' => $formData['mobile'],
            'user_comment' => $formData['comment'],
            'course_id' => $this->course['id'],
            'consult_status_id' => 1
        ]);
        $user = User::where('id', 1)->first();

        $title = 'Новая заявка на курс!';
        $text = '';

        // Посылаем Telegram уведомление нам
        Notification::route('telegram', env('TELEGRAM_CHAT_ID'))
            ->notify(new TelegramNotification($title, $text, null, null));

        session()->put('course' . $this->course['id'] .'_app_answered_check', true);
        $this->course_app_answered_check = true;
    }
}
