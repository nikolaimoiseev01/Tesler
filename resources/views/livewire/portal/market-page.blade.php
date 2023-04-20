<div>
    <div id="market_wrap" class="market_wrap content">
        <div class="search-bar-wrap">
            <div>
                <input required placeholder="Поиск..."
                       wire:model="search_input" id="own_book_input_search" name="own_book_input_search"
                       type="text">

                <a id="own_book_input_search_link" href="">
                    <svg width="15px" viewBox="0 0 612 612.01">
                        <g id="_4" data-name="4">
                            <path
                                d="M606.21,578.71l-158-155.48c41.38-45,66.8-104.41,66.8-169.84C515,113.44,399.7,0,257.49,0S0,113.44,0,253.39s115.27,253.4,257.48,253.4A259,259,0,0,0,419.56,450.2L578.18,606.3a20,20,0,0,0,28,0A19.29,19.29,0,0,0,606.21,578.71ZM257.49,467.8c-120.32,0-217.87-96-217.87-214.41S137.17,39,257.49,39s217.87,96,217.87,214.4S377.82,467.8,257.49,467.8Z"
                                transform="translate(-0.01 0)"/>
                        </g>
                    </svg>
                </a>
            </div>
        </div>
        <div class="filters_wrap">
            <div x-data="{ opened_category: false }" class="yc_category_filter_wrap">
                <a @click="opened_category = !opened_category" class="link coal">Сотрировать</a>
                <div x-transition x-show="opened_category" class="filter_wrap select_filter_wrap">
                    <div>
                        <p wire:click.prevent="make_sorting('price_desc')">Сначала дороже</p>
                        <p wire:click.prevent="make_sorting('price_asc')">Сначала дешевле</p>
                    </div>
                </div>
            </div>

            <div x-data="{ opened_price: false }" class="price_filter_wrap">
                <a @click="opened_price = !opened_price" class="link coal">Цена</a>
                <div x-transition x-show="opened_price" class="filter_wrap">
                    <p>От</p>
                    <input type="number" id="price_min" name="price_min" wire:model="price_min">
                    <p>До</p>
                    <input type="number" wire:model="price_max">
                </div>
            </div>

            <div x-data="{ opened_category: false }" class="yc_category_filter_wrap">
                <a @click="opened_category = !opened_category" class="link coal">Категория</a>
                <div x-transition x-show="opened_category" class="filter_wrap check_box_filter_wrap">
                    @foreach($categories as $category)
                        @if(!$abon_page_check)
                            <a href="{{route('good_category_page', $category['id'])}}"
                               class="link fern">{{$category['title']}}</a>
                        @else
                            <div>
                                <input type="checkbox" id="{{$category['id']}}" wire:model="yc_category"
                                       value="{{$category['id']}}">
                                <label for="{{$category['id']}}"><p>{{$category['title']}}</p></label>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @if(!$abon_page_check)
                @if(count($hair_types) > 0)
                    <div x-data="{ opened_category: false }" class="yc_category_filter_wrap">
                        <a @click="opened_category = !opened_category" class="link coal">Тип волос</a>
                        <div x-transition x-show="opened_category" class="filter_wrap check_box_filter_wrap">
                            @foreach($hair_types as $hair_type)
                                <div>
                                    <input type="checkbox" id="hair_type_{{$hair_type['id']}}" wire:model="hair_type"
                                           value="{{$hair_type['id']}}">
                                    <label for="hair_type_{{$hair_type['id']}}"><p>{{$hair_type['title']}}</p></label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(count($skin_types) > 0)
                    <div x-data="{ opened_category: false }" class="yc_category_filter_wrap">
                        <a @click="opened_category = !opened_category" class="link coal">Тип кожи</a>
                        <div x-transition x-show="opened_category" class="filter_wrap check_box_filter_wrap">
                            @foreach($skin_types as $skin_type)
                                <div>
                                    <input type="checkbox" id="skin_type{{$skin_type['id']}}" wire:model="skin_type"
                                           value="{{$skin_type['id']}}">
                                    <label for="skin_type{{$skin_type['id']}}"><p>{{$skin_type['title']}}</p></label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(count($brands) > 0)
                    <div x-data="{ opened_category: false }" class="yc_category_filter_wrap">
                        <a @click="opened_category = !opened_category" class="link coal">Бренд</a>
                        <div x-transition x-show="opened_category" class="filter_wrap check_box_filter_wrap">
                            @foreach($brands as $brand)
                                <div>
                                    <input type="checkbox" id="{{$brand}}" wire:model="brand"
                                           value="{{$brand}}">
                                    <label for="{{$brand}}"><p>{{$brand}}</p></label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif


                <div x-data="{ opened_category: false }" class="yc_category_filter_wrap">
                    <a @click="opened_category = !opened_category" class="link coal">Шопсеты</a>
                    <div x-transition x-show="opened_category" class="filter_wrap check_box_filter_wrap">
                        @foreach($shopsets as $shopset)
                            <div>
                                <input type="checkbox" id="shop_set_{{$shopset['id']}}" wire:model="shopset"
                                       value="{{$shopset['id']}}">
                                <label for="shop_set_{{$shopset['id']}}"><p>{{$shopset['title']}}</p></label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <div class="goods_card_wrap">
            @if(count($goods) === 0)
                <h2>Товаров по таким критериям не найдено.</h2>
            @else
                @foreach($goods as $good)
                    <div class="good_card_wrap">
                        <div>
                            <a class="name" href="{{route('good_page', $good['id'])}}">
                                <img
                                    @if(is_null($good->getFirstMediaUrl('good_examples')) || $good->getFirstMediaUrl('good_examples') == '')
                                    src="/media/media_fixed/logo_holder.png"
                                    @else src="{{$good->getFirstMediaUrl('good_examples')}}" @endif
                                    alt="">
                            </a>
                            <div class="info">
                                <p class="category">
                                    {{\App\Models\GoodCategory::where('id', $good['good_category_id'][0])->first(['title'])->title}}
                                </p>
                                <a class="name" target="_blank" href="{{route('good_page', $good['id'])}}">
                                    <p>
                                        {{Str::limit(Str::ucfirst(Str::lower($good['name'])), 30, '...')}}
                                    </p>
                                </a>
                            </div>
                        </div>
                        <div class="buttons_wrap">
                            @if($good['flg_active'] && $good['yc_actual_amount'] > 0 || $good['good_category_id'][0] === 6 || $good['good_category_id'][0] === 7)
                                <a onclick="Livewire.emit('good_cart_add', {{$good['id']}})"
                                   id="good_add_{{$good['id']}}"
                                   class="link fern">В корзину</a>
                            @else
                                <p>Товар закончился</p>
                            @endif
                            <p class="price">{{$good['yc_price']}} ₽</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @if ($load_more_check)
            <div class="load_more">
                <a wire:click.prevent="load_more" class="link fern">Загрузить еще</a>
            </div>
        @else
            @if(count($goods) > 0)
                <div class="load_more">
                    <p>Загружены все товары ({{count($goods)}})</p>
                </div>
            @endif
        @endif

    </div>
</div>
