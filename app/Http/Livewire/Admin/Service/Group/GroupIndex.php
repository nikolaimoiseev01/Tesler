<?php

namespace App\Http\Livewire\Admin\Service\Group;

use App\Models\Group;
use Livewire\Component;

class GroupIndex extends Component
{

    protected $listeners = ['refreshGroupIndex' => '$refresh'];


    public function render()
    {
        $groups = Group::orderBy('position')->get();
        return view('livewire.admin.service.group.group-index', [
            'groups' => $groups
        ]);
    }
}
