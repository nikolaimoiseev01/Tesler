<?php

namespace App\Http\Livewire\Admin\Service\Group;

use App\Models\Category;
use App\Models\Group;
use App\Models\Scope;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class GroupCreate extends ModalComponent
{
    public $name;
    public $scopes;
    public $categories;
    public $scope;
    public $category;

    public function render()
    {

        return view('livewire.admin.service.group.group-create', [
            'scopes' => $this->scopes,
            'categories' => $this->categories
        ]);
    }

    public function mount()
    {
        $this->scopes = Scope::orderBy('name')->get();
        $this->categories = Category::orderBy('name')->get();
    }

    public function updatedScope() {
        $this->categories = Category::where('scope_id', $this->scope)->orderBy('name')->get();
//        $this->category = Category::where('scope_id', $this->scope)->orderBy('name')->first()['id'];
    }

    public function updatedCategory() {
        $this->scope = Category::where('id', $this->category)->first()['scope_id'];
    }

    public function createGroup($formData) {
        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($this->name == null) {
            array_push($errors_array, 'Название не заполнено!');
        }
        if ($this->scope == null) {
            array_push($errors_array, 'Сфера не выбрана!');
        }
        if ($this->category == null) {
            array_push($errors_array, 'Категория не выбрана!');
        }

        if (!empty($errors_array)) {
            $this->dispatchBrowserEvent('swal_fire', [
                'type' => 'error',
                'showDenyButton' => false,
                'showConfirmButton' => false,
                'title' => 'Что-то пошло не так!',
                'text' => implode("<br>", $errors_array),
            ]);

            $this->dispatchBrowserEvent('filepond_trigger');
        }

        if (empty($errors_array)) {
            $max_position = Group::max('position') ?? 1;

            $group = Group::create([
                'scope_id' => $this->scope,
                'category_id' => $this->category,
                'name' => $this->name,
                'position' => $max_position + 1
            ]);

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Группа успешно создана!',
            ]);


            $this->emit('refreshGroupIndex');
            $this->forceClose()->closeModal();

        }
    }
}
