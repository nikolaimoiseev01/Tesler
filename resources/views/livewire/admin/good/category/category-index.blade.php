<div>
    <div style="max-width: 1000px;" class="card">
        <a wire:click="$emit('openModal', 'admin.good.category.category-create')" class="m-3 btn btn-outline-secondary">
            <i class="mr-2 fa fa-plus"></i>
            Добавить категорию товара
        </a>
        <div class="card-body p-0">
            <ul wire:sortable="updateOrder" class="products-list product-list-in-card pl-2 pr-2">
                @foreach($goodcategories as $goodcategory)
                    <li wire:sortable.item="{{$goodcategory['id']}}" x-data="{ open_{{$goodcategory['id']}}: false }"
                        wire:key="promo-{{$goodcategory['id']}}" class="item">
                        <div class="d-flex align-items-center">
                            <div wire:sortable.handle style="white-space: nowrap"
                                 class="d-flex mr-3 ml-3 align-items-center">
                                 <span class="grabbable handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                 </span>
                            </div>

                            <div class="mr-3 product-img">
                                <img style="width: 90px !important; height: 65px; max-width: inherit; object-fit: cover;"
                                     @if(is_null($goodcategory->getFirstMediaUrl('pic_goodcategory')) ||$goodcategory->getFirstMediaUrl('pic_goodcategory') == '')
                                     src="/media/media_fixed/logo_holder.png"
                                     @else src="{{$goodcategory->getFirstMediaUrl('pic_goodcategory')}}" @endif
                                     alt="">
                            </div>

                            <div class="ml-0 mr-3 product-info">
                                <a onclick='Livewire.emit("openModal", "admin.good.category.category-edit", {{ json_encode(["goodcategory_id" => $goodcategory['id']]) }})'
                                   class="product-title">{{$goodcategory['title']}}</a>
                                <span style="white-space: inherit;"
                                      class="product-description">{{$goodcategory['desc']}}</span>
                            </div>
                            <div class="ml-auto mr-3">
                                <a
{{--                                    href="{{route('goodcategory.edit', $goodcategory['id'])}}"--}}
                                    onclick='Livewire.emit("openModal", "admin.good.category.category-edit", {{ json_encode(["goodcategory_id" => $goodcategory['id']]) }})'
                                    class="mr-3">
                                    <i style="font-size: 18px;" class="fa-solid grey_icon fa-pen-to-square"></i>
                                </a>
                                {{--                                <a href="">--}}
                                {{--                                    <i style="font-size: 18px;" wire:click.prevent="delete_confirm({{$goodcategory['id']}})"--}}
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
