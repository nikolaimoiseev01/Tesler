<?php

namespace App\Livewire\Admin\Promocodes;

use App\Models\Good\Promocode;
use Livewire\Component;

class PromocodesIndex extends Component
{
    protected $listeners = ['refreshPromocodesIndex' => '$refresh', 'delete_promo', 'delete_confirm'];

    public function render()
    {
        $promos = Promocode::orderBy('title')->get();
        return view('livewire.admin.promocodes.promocodes-index', [
            'promos' => $promos
        ]);
    }

    public function createPromo($formData)
    {

        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($formData['title'] == '') {
            array_push($errors_array, 'Название не заполнено.');
        }
        if ($formData['discount'] == '') {
            array_push($errors_array, 'Процент не заполнен.');
        }

        if (!empty($errors_array)) {
            $this->dispatch('swal_fire',
                type: 'error',
                showDenyButton: false,
                showConfirmButton: false,
                title: 'Что-то пошло не так!',
                text: implode("<br>", $errors_array),
            );
        }

        if (empty($errors_array)) {

            $promo = Promocode::create([
                'title' => $formData['title'],
                'discount' => $formData['discount'],

            ]);

            $this->dispatch('toast_fire',
                type: 'success',
                title: 'Промокод успешно добавлен!',
            );
        }
        $this->dispatch('refreshPromocodesIndex');
    }

    public function delete_confirm($promo_id)
    {
        $promo = Promocode::where('id', $promo_id)->first();
        $this->dispatch('swal_fire',
                type: 'warning',
                title: 'Предупреждение!',
                text: 'Вы уверены?',
                swal_detail_id: $promo_id,
                showConfirmButton: true,
                showDenyButton: true,
                swal_function_to_confirm: 'delete_promo',
            );
    }

    public function delete_promo($promo_id)
    {
        $promo = Promocode::where('id', $promo_id)->first();
        $promo->delete();
        $this->dispatch('toast_fire',
                type: 'success',
                title: 'Промокод успешно удален!',
            );
    }
}
