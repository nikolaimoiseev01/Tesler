<div>
    <div style="max-width: 1000px;" class="card">
        <a wire:click="$emit('openModal', 'admin.service.scope.scope-create')" class="m-3 btn btn-outline-secondary">
            <i class="mr-2 fa fa-plus"></i>
            Добавить сферу
        </a>
        <div class="card-body p-0">
            <ul wire:sortable="updateOrder" class="products-list product-list-in-card pl-2 pr-2">
                @foreach($scopes as $scope)
                    <li x-data="{ open_{{$scope['id']}}: false }" wire:sortable.item="{{$scope['id']}}"
                        wire:key="promo-{{$scope['id']}}" class="item">
                        <div class="d-flex align-items-center">
                            <div wire:sortable.handle style="white-space: nowrap"
                                 class="d-flex mr-3 ml-3 align-items-center">
                                 <span class="grabbable handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                 </span>
                            </div>
                            <div class="mr-3 product-img">
                                <img style="width: auto;" src="/{{$scope['pic_scope_page']}}" alt="">
                            </div>

                            <div class="ml-0 mr-3 product-info">
                                <a href="javascript:void(0)" class="product-title">{{$scope['name']}}</a>
                                <span style="white-space: inherit;"
                                      class="product-description">{{$scope['desc']}}</span>
                            </div>
                            <div class="ml-auto mr-3">
                                <a  onclick='Livewire.emit("openModal", "admin.service.scope.scope-edit", {{ json_encode(["scope_id" => $scope['id']]) }})' class="mr-3">
                                    <i style="font-size: 18px;" class="fa-solid grey_icon fa-pen-to-square"></i>
                                </a>
{{--                                <a href="">--}}
{{--                                    <i style="font-size: 18px;" wire:click.prevent="delete_confirm({{$scope['id']}})"--}}
{{--                                       class="fas grey_icon fa-trash-alt"></i>--}}
{{--                                </a>--}}
                            </div>
                        </div>


                    </li>
                @endforeach
            </ul>
        </div>
</div>
