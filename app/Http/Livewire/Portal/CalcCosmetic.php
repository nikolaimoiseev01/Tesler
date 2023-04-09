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

    protected $listeners = ['refreshCalcCosmetic' => '$refresh', 'make_option'];

    public function render()
    {
        return view('livewire.portal.calc-cosmetic');
    }

    public function mount()
    {
        $this->options = \App\Models\CalcCosmetic::orderBy('id')->get();
    }

    public function make_option()
    {

        $this->option = \App\Models\CalcCosmetic::where('step_1', $this->step_1)
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
