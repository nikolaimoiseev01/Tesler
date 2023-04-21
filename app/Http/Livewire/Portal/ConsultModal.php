<?php

namespace App\Http\Livewire\Portal;

use App\Models\Consultation;
use App\Models\User;
use App\Notifications\MailNotification;
use Illuminate\Http\Request;
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
        $user = User::where('id', 1)->first();
        $user->notify(new MailNotification(
            'Новая заявка наконсультацию!',
            "Поступила новая заявка на консультацию с сайта.\n",
            "Подробнее",
            route('consultationy.index')
        ));
        session()->put('consult_answered_check', true);
        $this->consult_answered_check = true;
    }
}
