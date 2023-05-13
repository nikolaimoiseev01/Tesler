<?php

namespace App\Http\Livewire\Admin;

use App\Models\Service;
use Livewire\Component;

class CalcHair extends Component
{
    public $options;

    public $services;
    public $steps_1;
    public $steps_2;
    public $steps_3;

    public $service_id_chosen;
    public $step_1;
    public $step_2;
    public $step_3;
    public $result_price;
    public $result_price_pre;


    public function render()
    {
        $this->services = Service::orderBy('name')->get();
        $this->steps_1 = \App\Models\CalcHair::select('step_1')->distinct()->pluck('step_1');
        $this->steps_2 = \App\Models\CalcHair::select('step_2')->distinct()->pluck('step_2');
        $this->steps_3 = \App\Models\CalcHair::select('step_3')->distinct()->pluck('step_3');

        $this->options = \App\Models\CalcHair::orderBy('service_id')->get();
        return view('livewire.admin.calc-hair');
    }

    public function dehydrate()
    {
        if ($this->service_id_chosen && $this->step_2 && $this->step_3) { // Если все выбрали
            $option = \App\Models\CalcHair::where('service_id', $this->service_id_chosen)
                ->where('step_1', $this->step_1)
                ->where('step_2', $this->step_2)
                ->where('step_3', $this->step_3)
                ->first();
            if ($option) {
                $this->result_price_pre = $option['result_price'];
            }
        }
    }

    public function new_option_to_add()
    {
        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];
        if ($this->result_price === null) {
            array_push($errors_array, 'Нет цены!');
        }

        if ($this->service_id_chosen === null) {
            array_push($errors_array, 'Выберите услугу!');
        }

        if ($this->step_1 === null) {
            array_push($errors_array, 'Выберите шаг 1!');
        }

        if ($this->step_2 === null) {
            array_push($errors_array, 'Выберите шаг 2!');
        }

        if ($this->step_3 === null) {
            array_push($errors_array, 'Выберите шаг 3!');
        }

        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

            $this->emit('refreshCalcCosmetic');
        }

        if (empty($errors_array)) {
            $option = \App\Models\CalcHair::where('service_id', $this->service_id_chosen)
                ->where('step_1', $this->step_1)
                ->where('step_2', $this->step_2)
                ->where('step_3', $this->step_3)
                ->first();
            if ($option) {
                $option->update([
                    'step_1' => $this->step_1,
                    'step_2' => $this->step_2,
                    'step_3' => $this->step_3,
                    'result_price' => $this->result_price
                ]);

                $this->dispatchBrowserEvent('toast_fire', [
                    'type' => 'success',
                    'title' => 'Опция успешно обновлена!',
                ]);
            } else {
                \App\Models\CalcHair::create([
                    'service_id' => $this->service_id_chosen,
                    'step_1' => $this->step_1,
                    'step_2' => $this->step_2,
                    'step_3' => $this->step_3,
                    'result_price' => $this->result_price
                ]);

                $this->dispatchBrowserEvent('toast_fire', [
                    'type' => 'success',
                    'title' => 'Опция успешно создана!',
                ]);
            }
        }
    }
}
