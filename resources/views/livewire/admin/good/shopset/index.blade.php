<div>
    <div style="max-width: 1000px;" class="card">
        <a wire:click="$emit('openModal', 'admin.good.shopset.create')" class="m-3 btn btn-outline-secondary">
            <i class="mr-2 fa fa-plus"></i>
            Добавить шопсет
        </a>
        <div class="card-body p-0">
            <ul class="products-list product-list-in-card pl-2 pr-2">
                @foreach($shopsets as $shopset)
                    <li x-data="{ open_{{$shopset['id']}}: false }" wire:sortable.item="{{$shopset['id']}}"
                        class="item">
                        <div class="d-flex align-items-center">
                            <div class="mr-3 product-img">
                                <img style="width: auto;" src="{{$shopset->getFirstMediaUrl('pic_shopset')}}" alt="">
                            </div>

                            <div class="ml-0 mr-3 product-info">
                                <a href="{{route('shopset.edit', $shopset['id'])}}" class="product-title">{{$shopset['title']}}</a>
                                <span style="white-space: inherit;"
                                      class="product-description">{{$shopset['desc']}}</span>
                            </div>
                            <div class="ml-auto mr-3">
                                <a
                                    href="{{route('shopset.edit', $shopset['id'])}}"
{{--                                    onclick='Livewire.emit("openModal", "admin.good.shopset.edit", {{ json_encode(["shopset_id" => $shopset['id']]) }})'--}}
                                    class="mr-3">
                                    <i style="font-size: 18px;" class="fa-solid grey_icon fa-pen-to-square"></i>
                                </a>
                                {{--                                <a href="">--}}
                                {{--                                    <i style="font-size: 18px;" wire:click.prevent="delete_confirm({{$shopset['id']}})"--}}
                                {{--                                       class="fas grey_icon fa-trash-alt"></i>--}}
                                {{--                                </a>--}}
                            </div>
                        </div>


                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
