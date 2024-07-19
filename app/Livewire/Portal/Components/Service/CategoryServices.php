<?php

namespace App\Livewire\Portal\Components\Service;

use App\Models\Service\Group;
use App\Models\Service\Service;
use Illuminate\Support\Facades\Cookie;
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

        $this->groups = Group::whereIn('id', $services_in_group)
            ->orderBy('position')
            ->with(['service' => function ($query) {
                // Добавьте нужные вам фильтры здесь
                $chosen_yc_shop = app('chosen_shop');
                $query->where(function ($query) {
                    $query->where('service_type_id', '=', 1)
                        ->orWhere('service_type_id', '=', 2);
                })
                    ->where('scope_id', $this->category['scope_id'])
                    ->where('category_id', $this->category['id'])
                    ->where('flg_active', 1)
                    ->where('flg_comp_' . $chosen_yc_shop['order'], true);
            }])
            ->get();

//        dd($this->groups);


        return view('livewire.portal.components.service.category-services');
    }
}
