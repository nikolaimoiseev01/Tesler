<?php

namespace App\Livewire\Admin;

use App\Models\Service\Service;
use Livewire\Component;

class CalcCosmetic extends Component
{
    public $options;
    public $cur_option;
    public $cur_option_id = 1;
    public $services_all;
    public $service_to_add;
    public $cur_option_services;

    protected $listeners = ['refreshCalcCosmetic' => '$refresh', 'page_js_trigger'];

    public function render()
    {
        $this->cur_option = \App\Models\Calculators\CalcCosmetic::where('id', $this->cur_option_id)->first();
        $this->options = \App\Models\Calculators\CalcCosmetic::orderBy('id')->get();
        $this->services_all = Service::orderBy('name')->get();
        return view('livewire.admin.calc-cosmetic', [
            'cur_option' => $this->cur_option
        ]);
    }

    public function mount()
    {

    }

    public function new_option_to_add()
    {


        $services_in_option = $this->cur_option['services'];

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($services_in_option !== null) {
            $service_add_check = array_filter($services_in_option, function ($v) {
                return $v['id'] == intval($this->service_to_add);
            });
            $service_add_check = count($service_add_check);
        } else {
            $service_add_check = 0;
        }

        if ($this->service_to_add === null) {
            array_push($errors_array, 'Выберите услугу!');
        }

        if ($service_add_check ?? 0 > 0) {
            array_push($errors_array, 'Эта услуга уже есть в опции!');
        }


        if (!empty($errors_array)) {
            $this->dispatch('swal_fire',
                type: 'error',
                showDenyButton: false,
                showConfirmButton: false,
                title: 'Что-то пошло не так!',
                text: implode("<br>", $errors_array),
            );

            $this->dispatch('refreshCalcCosmetic');
        }

        if (empty($errors_array)) {


            if ($services_in_option !== null) { // Если уже есть что-то в поле services
                $services_in_option[] = [
                    'id' => intval($this->service_to_add),
                    'name' => Service::where('id', intval($this->service_to_add))->value('name')
                ];
                $this->cur_option->update([
                    'services' => $services_in_option,
                ]);
            } else {
                $services_in_option_new[] = [
                    'id' => intval($this->service_to_add),
                    'name' => Service::where('id', intval($this->service_to_add))->value('name')
                ];
                $this->cur_option->update([
                    'services' => $services_in_option_new,
                ]);
            }

            $this->cur_option = \App\Models\Calculators\CalcCosmetic::where('id', $this->cur_option_id)->first();
            $this->dispatch('refreshCalcCosmetic');

            $this->dispatch('toast_fire',
                type: 'success',
                title: 'Услуга успешно добавлена в опцию!',
            );
        }
    }


    public function delete_service($service_id)
    {
        $services_in_option = $this->cur_option['services'];

        unset($services_in_option[array_search($service_id, $services_in_option)]);

        $this->cur_option->update([
            'services' => array_values($services_in_option),
        ]);

        $this->dispatch('toast_fire',
                type: 'success',
                title: 'Услуга удалена из опции!',
            );

        $this->dispatch('refreshCalcCosmetic');


    }
}
