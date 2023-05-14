<?php

namespace App\Http\Livewire\Portal;

use Livewire\Component;

class CalcHair extends Component
{
    public $options;
    public $option;

    public $step_0;
    public $step_1;
    public $step_2;
    public $step_3;

    public $step = 0;

    public $result_price;
    public $result_link;

    protected $listeners = ['refreshCalchair' => '$refresh'];

    public function render()
    {
        return view('livewire.portal.calc-hair');
    }

    public function mount()
    {
        $this->options = \App\Models\CalcHair::orderBy('id')->get();
    }

    public function change_slide($dir) {
        if(($this->step == 0 && $dir == -1) || ($this->step == 4 && $dir == 1)) {
        } else {
            $this->step = $this->step + $dir;
        }

    }

    public function dehydrate() {
        if ($this->step_0 && $this->step_1 && $this->step_2 && $this->step_3) { // Если все выбрали
            $option = \App\Models\CalcHair::where('service_id', $this->step_0)
                ->where('service_id', $this->step_0)
                ->where('step_1', $this->step_1)
                ->where('step_2', $this->step_2)
                ->where('step_3', $this->step_3)
                ->first();
            if ($option) {
                $this->result_price = $option['result_price'];
                $this->result_link = 'https://b253254.yclients.com/company/247576/menu?o=s' . $option->service['yc_id'];
            }
        }
    }

}
