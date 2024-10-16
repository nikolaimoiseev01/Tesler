<?php

namespace App\Http\Livewire\Admin\Service\Scope;

use App\Models\Scope;
use Livewire\Component;

class ScopeIndex extends Component
{

    protected $listeners = ['refreshScopeIndex' => '$refresh'];

    public function render()
    {
        $scopes = Scope::orderBy('position')->get();
        return view('livewire.admin.service.scope.scope-index', [
            'scopes' => $scopes,
        ]);
    }


    public function updateOrder($list)
    {
        foreach ($list as $item) {
            Scope::find($item['value'])->update(['position' => $item['order']]);
        }

        $this->dispatchBrowserEvent('toast_fire', [
            'type' => 'success',
            'title' => 'Порядок сфер успешно изменен!',
        ]);
    }
}
