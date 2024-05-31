<?php

namespace App\Livewire\Admin;

use App\Models\Consultation;
use App\Models\ConsultStatus;
use App\Models\User;
use App\Notifications\EmailNotification;
use App\Notifications\MailNotification;
use App\Notifications\new_participation;
use App\Notifications\WhatsAppNotify;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;

class ConsultationIndex extends Component
{
    public $consultations;
    public $consult_status = [];
    public $consult_statuses;

    protected $listeners = [
        'update_consultation'
    ];

    public function render()
    {
        $this->consultations = Consultation::orderBy('created_at', 'desc')->get();
        return view('livewire.admin.consultation-index');
    }

    public function mount()
    {

        $this->consult_statuses = ConsultStatus::orderBy('created_at', 'desc')->get();
    }

    public function update_consultation($c_id, $s_id)
    {
        $consultation = Consultation::where('id', intval($c_id))->first();
        $consultation->update([
            'consult_status_id' => $s_id
        ]);

        $this->dispatch('toast_fire',
                type: 'success',
                title: 'Статус успешно изменен!',
            );
    }

}
