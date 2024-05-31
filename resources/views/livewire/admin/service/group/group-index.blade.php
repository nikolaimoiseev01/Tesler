<div>
    <div style="max-width: 1000px;" class="card">
        <a wire:click="$dispatch('openModal', 'admin.service.group.group-create')" class="m-3 btn btn-outline-secondary">
            <i class="mr-2 fa fa-plus"></i>
            Добавить группу услуг
        </a>
        <div class="card-body p-0">
            <ul wire:sortable="updateOrder" class="products-list product-list-in-card pl-2 pr-2">
                @foreach($groups as $group)
                    <li x-data="{ open_{{$group['id']}}: false }" wire:sortable.item="{{$group['id']}}"
                        wire:key="promo-{{$group['id']}}" class="item">
                        <div class="d-flex align-items-center">
                            <div wire:sortable.handle style="white-space: nowrap"
                                 class="d-flex mr-3 ml-3 align-items-center">
                                 <span class="grabbable handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                 </span>
                            </div>

                            <div class="ml-0 mr-3 product-info">
                                <a wire:click="$dispatch('openModal', {component: 'admin.service.group.group-edit', arguments: {group_id: {{$group['id']}}}})"
                                    href="javascript:void(0)" class="product-title">
{{$group->scope['name']}} / {{ $group->category['name'] }} / {{$group['name']}}
                                </a>
                            </div>
                            <div class="ml-auto mr-3">
                                <a wire:click="$dispatch('openModal', {component: 'admin.service.group.group-edit', arguments: {group_id: {{$group['id']}}}})" class="mr-3">
                                    <i style="font-size: 18px;" class="fa-solid grey_icon fa-pen-to-square"></i>
                                </a>
                                {{--                                <a href="">--}}
                                {{--                                    <i style="font-size: 18px;" wire:click.prevent="delete_confirm({{$group['id']}})"--}}
                                {{--                                       class="fas grey_icon fa-trash-alt"></i>--}}
                                {{--                                </a>--}}
                            </div>
                        </div>


                    </li>
                @endforeach
            </ul>
        </div>
    </div>
