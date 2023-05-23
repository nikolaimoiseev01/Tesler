<?php

namespace App\Http\Livewire\Admin\Promocodes;

use App\Models\Promocode;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class PromocodesEdit extends ModalComponent
{
    public $title;
    public $discount;
    public $promo;

    public function render()
    {
        return view('livewire.admin.promocodes.promocodes-edit');
    }

    public function mount($promo_id)
    {
        $this->promo = Promocode::where('id', $promo_id)->first();
        $this->title = $this->promo['title'];
        $this->discount = $this->promo['discount'];
    }


    public function editPromo($formData) {
        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($formData['title'] == '') {
            array_push($errors_array, 'Название не заполнено.');
        }
        if ($formData['discount'] == '') {
            array_push($errors_array, 'Процент не заполнен.');
        }


        if (!empty($errors_array)) {
            $this->emit('refreshGroupIndex');
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);


        }

        if (empty($errors_array)) {

            $this->promo->update([
                'title' => $this->title,
                'discount' => $this->discount,
            ]);

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Промокод успешно изменен!',
            ]);


            $this->emit('refreshPromocodesIndex');
            $this->forceClose()->closeModal();

        }
    }
}
