<?php

namespace App\Livewire\Portal\Components\Service;

use App\Models\Service\Group;
use App\Models\Service\Service;
use Livewire\Component;

class CategoryServices extends Component
{

    public $scope;
    public $category;
    public $groups;
    public $services;

    public function render()
    {
//        dd($this->category);
        $services_in_group = Service::where('scope_id', $this->category['scope_id'])
            ->where('flg_active', 1)->where('category_id', $this->category['id'])
            ->where(function ($query) {
                $query->where('service_type_id', '=', 1)
                    ->orWhere('service_type_id', '=', 2);
            })
            ->pluck('group_id')
            ->toArray();
//        dd($services_in_group);

        $this->groups = Group::whereIn('id', $services_in_group)
            ->orderBy('position')
            ->with(['service' => function ($query) {
                // Добавьте нужные вам фильтры здесь
                $query->where(function ($query) {
                    $query->where('service_type_id', '=', 1)
                        ->orWhere('service_type_id', '=', 2);
                })
                    ->where('scope_id', $this->category['scope_id'])
                    ->where('category_id', $this->category['id'])
                    ->where('flg_active', 1);
            }])
            ->get();

//        dd($this->groups);


        return view('livewire.portal.components.service.category-services');
    }
}
