<?php

namespace App\Http\Livewire\Admin\Service\Group;

use App\Models\Category;
use App\Models\Group;
use App\Models\Scope;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class GroupEdit extends ModalComponent
{
    public $group;
    public $name;
    public $scopes;
    public $categories;
    public $scope;
    public $category;

    public function render()
    {
        return view('livewire.admin.service.group.group-edit', [
            'scopes' => $this->scopes,
            'categories' => $this->categories
        ]);
    }


    public function mount($group_id)
    {
        $this->group = Group::where('id', $group_id)->first();
        $this->name = Group::where('id', $group_id)->first()['name'];
        $this->scope = Group::where('id', $group_id)->first()['scope_id'];
        $this->category = Group::where('id', $group_id)->first()['category_id'];
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

    public function editGroup($formData) {
        // --------- Ищем ошибки в заполнении  --------- //
        $errors_array = [];

        if ($this->name == null) {
            array_push($errors_array, 'Название не заполнено!');
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

            $this->dispatchBrowserEvent('filepond_trigger');

        }

        if (empty($errors_array)) {

            $this->group->update([
                'scope_id' => $this->scope,
                'category_id' => $this->category,
                'name' => $this->name
            ]);

            $this->dispatchBrowserEvent('toast_fire', [
                'type' => 'success',
                'title' => 'Группа успешно изменена!',
            ]);


            $this->emit('refreshGroupIndex');
            $this->forceClose()->closeModal();

        }
    }
}
