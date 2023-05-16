<?php

namespace App\Http\Livewire\Portal;

use Livewire\Component;

class CalcCosmetic extends Component
{
    public $options;
    public $option;
    public $step_1;
    public $step_2;
    public $step_3;

    public $step = 1;

    public $services;
    public $has_services;

    protected $listeners = ['refreshCalcCosmetic' => '$refresh', 'next_step_cosmetic'];

    public function render()
    {
        return view('livewire.portal.calc-cosmetic');
    }


    public function mount()
    {
        $this->options = \App\Models\CalcCosmetic::orderBy('id')->get();
    }


    public function change_slide($dir)
    {
        if (($this->step == 1 && $dir == -1) || ($this->step == 4 && $dir == 1)) {
        } else {
            $this->step = $this->step + $dir;
        }
    }

    public function next_step_cosmetic() {
        $this->step = $this->step + 1;
    }

    public function dehydrate()
    {
        if ($this->step_1 && $this->step_2 && $this->step_3) { // Если все выбрали
            $option = \App\Models\CalcCosmetic::where('step_1', $this->step_1)
                ->where('step_2', $this->step_2)
                ->where('step_3', $this->step_3)
                ->first();
            if ($option['services']) {
                $this->has_services = 1;
                $this->services = $option['services'];
            } else {
                $this->has_services = 2;

            }
        } else {
            $this->has_services = 3;
        }
    }



}
