<?php

namespace App\Livewire\Admin;

use App\Models\ConsultStatus;
use App\Models\Course\CourseApp;
use Livewire\Component;

class CourseAppIndex extends Component
{
    public $CourseApps;
    public $consult_status = [];
    public $consult_statuses;

    protected $listeners = [
        'update_CourseApp'
    ];

    public function render()
    {
        $this->CourseApps = CourseApp::orderBy('consult_status_id')->get();
        return view('livewire.admin.course-app-index');
    }

    public function mount()
    {

        $this->consult_statuses = ConsultStatus::orderBy('id')->get();
    }

    public function update_CourseApp($c_id, $s_id)
    {
        $CourseApp = CourseApp::where('id', intval($c_id))->first();
        $CourseApp->update([
            'consult_status_id' => $s_id
        ]);

        $this->dispatch('toast_fire',
                type: 'success',
                title: 'Статус успешно изменен!',
            );
    }
}
