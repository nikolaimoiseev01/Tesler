<?php

namespace App\Livewire\Portal;

use Livewire\Component;

class CalcCosmetic extends Component
{
    public $options;
    public $option;
    public $step_1;
    public $step_2;
    public $options_step_2;
    public $step_3;
    public $options_step_3;

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
        $option = \App\Models\Calculators\CalcCosmetic::where('step_1', 'Пигментация')
            ->where('step_2', 'Жирная, комбинированная')
            ->where('step_3', 'Курсовое лечение')
            ->first();
        $this->options_step_2 = \App\Models\Calculators\CalcCosmetic::pluck('step_2')->unique();
        $this->options_step_3 = \App\Models\Calculators\CalcCosmetic::pluck('step_3')->unique();
        $this->options = \App\Models\Calculators\CalcCosmetic::orderBy('id')->get();
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
        // Расчет нужных опций при выборе
        if($this->step_1) {
            $this->options_step_2 = \App\Models\Calculators\CalcCosmetic::where('step_1', $this->step_1)->pluck('step_2')->unique();
        } else {
            $this->options_step_2 = \App\Models\Calculators\CalcCosmetic::pluck('step_2')->unique();
        }

        if($this->step_1 && $this->step_2) {
            $this->options_step_3 = \App\Models\Calculators\CalcCosmetic::where('step_1', $this->step_1)->where('step_2', $this->step_2)->pluck('step_3')->unique();
        } else {
            $this->options_step_3 = \App\Models\Calculators\CalcCosmetic::pluck('step_3')->unique();
        }

        // Расчет результата
        if ($this->step_1 && $this->step_2 && $this->step_3) { // Если все выбрали
            $option = \App\Models\Calculators\CalcCosmetic::where('step_1', $this->step_1)
                ->where('step_2', $this->step_2)
                ->where('step_3', $this->step_3)
                ->first();
            if ($option['services']) {
                $this->has_services = 1;
                $this->services = $option;
            } else {
                $this->has_services = 2;

            }
        } else {
            $this->has_services = 3;
        }
    }



}
