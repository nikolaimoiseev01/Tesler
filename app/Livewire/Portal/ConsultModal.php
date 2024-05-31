<?php

namespace App\Livewire\Portal;

use App\Models\Consultation;
use App\Models\User;
use App\Notifications\MailNotification;
use App\Notifications\TelegramNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class ConsultModal extends Component
{
    public $consult_answered_check;

    public function render()
    {
        return view('livewire.portal.consult-modal');
    }

    public function mount(Request $request) {
        $this->consult_answered_check = $request->session()->get('consult_answered_check') ?? null;
    }

    public function createConsultation($formData)
    {

        Consultation::create([
           'user_name' => $formData['name'],
            'user_mobile' => $formData['mobile'],
            'user_comment' => $formData['comment'],
            'consult_status_id' => 1
        ]);

        $title = 'Новая заявка на консультацию!';
        $text = '';

        // Посылаем Telegram уведомление нам
        Notification::route('telegram', env('TELEGRAM_CHAT_ID'))
            ->notify(new TelegramNotification($title, $text, null, null));

        session()->put('consult_answered_check', true);
        $this->consult_answered_check = true;
    }
}
