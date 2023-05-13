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

    protected $listeners = ['refreshCalchair' => '$refresh', 'make_option'];

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
            }
        }
    }

    public function make_option()
    {

        $this->option = \App\Models\CalcHair::where('step_1', $this->step_1)
            ->where('step_2', $this->step_2)
            ->where('step_3', $this->step_3)
            ->first();

//        dd(array_column($this->option['services'], 'name'));
        if ($this->option['services'] ?? null) {
            $option_steps = $this->step_1 . ' -> ' . $this->step_2 . ' -> ' . $this->step_3;
            $services = $this->option['services'];
        } elseif ($this->step_1 === null || $this->step_2 === null || $this->step_3 === null) {
            $option_steps = 'Сначала сделайте выбор на всех шагах!';
            $services[] = ['id' => 999999, 'name' => ''];
        } else {
            $option_steps = $this->step_1 . ' -> ' . $this->step_2 . ' -> ' . $this->step_3;
            $services[] = ['id' => 999999, 'name' => 'Вам подходят все наши услуги!'];
        }


        $this->dispatchBrowserEvent('update_option', [
            'services' => $services,
            'option_steps' => $option_steps
        ]);

//        dd($step_1, $step_2, $step_3);
    }
}
