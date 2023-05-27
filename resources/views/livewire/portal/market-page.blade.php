<div>
    <div id="market_wrap" class="market_wrap content">
        <div class="search-bar-wrap">
            <div>
                <input required placeholder="Поиск..."
                       wire:model="search_input" id="own_book_input_search" name="own_book_input_search"
                       type="text">

                <a id="own_book_input_search_link">
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
        <div @click.outside="opend_filter = 'none'" x-data="{ opend_filter: 'none' }" class="filters_wrap">
            <div class="filter_block_wrap yc_category_filter_wrap">
                <a @click="opend_filter = 'sort'" class="link coal">Сотрировать</a>
                <div x-transition x-show="opend_filter === 'sort'" class="filter_wrap select_filter_wrap">
                    <div>
                        <p wire:click.prevent="make_sorting('price_desc')">Сначала дороже</p>
                        <p wire:click.prevent="make_sorting('price_asc')">Сначала дешевле</p>
                    </div>
                </div>
            </div>

            @if(count($categories) > 1)
                <div class="filter_block_wrap @if($yc_category) has_filter @endif yc_category_filter_wrap">
                    <a @click="opend_filter = 'category'" class="link coal">Категория</a>
                    <div x-transition x-show="opend_filter === 'category'" class="filter_wrap check_box_filter_wrap">
                        @foreach($categories as $category_item)
                            @if(!$abon_page_check)
                                <a href="{{route('good_category_page', $category_item['id'])}}"
                                   class="link fern">{{$category_item['title']}}</a>
                            @else
                                <div>
                                    <input type="checkbox" id="{{$category_item['id']}}" wire:model="yc_category"
                                           value="{{$category_item['id']}}">
                                    <label for="{{$category_item['id']}}"><p>{{$category_item['title']}}</p></label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="filter_block_wrap @if($price_min || $price_max) has_filter @endif price_filter_wrap">
                <a @click="opend_filter = 'price'" class="link coal">Цена</a>
                <div x-transition x-show="opend_filter === 'price'" class="filter_wrap">
                    <p>От</p>
                    <input type="number" id="price_min" name="price_min" wire:model="price_min">
                    <p>До</p>
                    <input type="number" wire:model="price_max">
                </div>
            </div>

            @if(!$abon_page_check)
                @if(count($hair_types) > 0)
                    <div class="filter_block_wrap @if($hair_type) has_filter @endif yc_category_filter_wrap">
                        <a @click="opend_filter = 'hair_type'" class="link coal">Тип волос</a>
                        <div x-transition x-show="opend_filter === 'hair_type'"
                             class="filter_wrap check_box_filter_wrap">
                            @foreach($hair_types as $hair_type_item)
                                <div>
                                    <input type="checkbox" id="hair_type_{{$hair_type_item['id']}}"
                                           wire:model="hair_type"
                                           value="{{$hair_type_item['id']}}">
                                    <label for="hair_type_{{$hair_type_item['id']}}"><p>{{$hair_type_item['title']}}</p>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif


                @if(count($skin_types) > 0)
                    <div class="filter_block_wrap @if($skin_type) has_filter @endif yc_category_filter_wrap">
                        <a @click="opend_filter = 'skin_type'" class="link coal">Тип кожи</a>
                        <div x-transition x-show="opend_filter === 'skin_type'"
                             class="filter_wrap check_box_filter_wrap">
                            @foreach($skin_types as $skin_type_item)
                                <div>
                                    <input type="checkbox" id="skin_type_{{$skin_type_item['id']}}"
                                           wire:model="skin_type"
                                           value="{{$skin_type_item['id']}}">
                                    <label for="skin_type_{{$skin_type_item['id']}}"><p>{{$skin_type_item['title']}}</p>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif


                @if(count($good_types) > 0)
                    <div class="filter_block_wrap @if($good_type) has_filter @endif yc_category_filter_wrap">
                        <a @click="opend_filter = 'good_type'" class="link coal">Тип продукта</a>
                        <div x-transition x-show="opend_filter === 'good_type'"
                             class="filter_wrap check_box_filter_wrap">
                            @foreach($good_types as $good_type_item)
                                <div>
                                    <input type="checkbox" id="product_type_{{$good_type_item['id']}}"
                                           wire:model="good_type"
                                           value="{{$good_type_item['title']}}">
                                    <label for="product_type_{{$good_type_item['id']}}">
                                        <p>{{$good_type_item['title']}}</p>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif



                @if(count($brands) > 0)
                    <div class="filter_block_wrap @if($brand) has_filter @endif yc_category_filter_wrap">
                        <a @click="opend_filter = 'brand'" class="link coal">Бренд</a>
                        <div x-transition x-show="opend_filter === 'brand'" class="filter_wrap check_box_filter_wrap">
                            @foreach($brands as $brand_item)
                                <div>
                                    <input type="checkbox" id="{{$brand_item}}" wire:model="brand"
                                           value="{{$brand_item}}">
                                    <label for="{{$brand_item}}"><p>{{$brand_item}}</p></label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif


                <div class="filter_block_wrap @if($shopset) has_filter @endif yc_category_filter_wrap">
                    <a @click="opend_filter = 'shopsets'" class="link coal">Шопсеты</a>
                    <div x-transition x-show="opend_filter === 'shopsets'" class="filter_wrap check_box_filter_wrap">
                        @foreach($shopsets as $shopset_item)
                            <div>
                                <input type="checkbox" id="shop_set_{{$shopset_item['id']}}" wire:model="shopset"
                                       value="{{$shopset_item['id']}}">
                                <label for="shop_set_{{$shopset_item['id']}}"><p>{{$shopset_item['title']}}</p></label>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($shopset || $brand || $skin_type || $good_type || $hair_type || $yc_category || $price_min || $price_max)
                    <a wire:click.prevent="clear_filters" class="clear_filters coal link">Сбросить фильтры</a>
                @endif
            @endif


        </div>

        <div class="goods_card_wrap">
            @if(count($goods) === 0)
                <h2>Товаров по таким критериям не найдено.</h2>
            @else
                @foreach($goods as $key=>$good)
                    {{--                    @if($key == 4)--}}
                    {{--                        <div class="sert_big_blog_wrap">--}}
                    {{--                            <a class="good_cover">--}}
                    {{--                                <img src="/media/media_fixed/sert_big_block.png" alt="">--}}
                    {{--                            </a>--}}
                    {{--                            <div class="info">--}}
                    {{--                                <p class="category">--}}
                    {{--                                    СЕРТИФИКАТ--}}
                    {{--                                </p>--}}
                    {{--                                <h2>--}}
                    {{--                                    Подарочныи сертификат--}}
                    {{--                                </h2>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="buttons_wrap">--}}
                    {{--                                <div class="to_cart_wrap">--}}
                    {{--                                    <a onclick="Livewire.emit('good_cart_add', {{$good['id']}})"--}}
                    {{--                                       id="good_add_{{$good['id']}}"--}}
                    {{--                                       class="link fern">--}}
                    {{--                                        Купить--}}
                    {{--                                    </a>--}}
                    {{--                                </div>--}}
                    {{--                                <p class="price">{{$good['yc_price']}} ₽</p>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    @endif--}}
                    <div class="good_card_wrap">
                        <div>
                            <a class="good_cover" href="{{route('good_page', $good['id'])}}">
                                <img
                                    @if(is_null($good->getFirstMediaUrl('good_examples')) || $good->getFirstMediaUrl('good_examples') == '')
                                    src="/media/media_fixed/logo_holder.png"
                                    @else src="{{$good->getFirstMediaUrl('good_examples')}}" @endif
                                    alt="">
                                @if($good['promo_text'])
                                    <p>{{$good['promo_text']}}</p>
                                @endif
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
                            <div class="to_cart_wrap">
                                @if($good['flg_active'] && $good['yc_actual_amount'] > 0 || $good['good_category_id'][0] === 6 || $good['good_category_id'][0] === 7)
                                    <a onclick="Livewire.emit('good_cart_add', {{$good['id']}})"
                                       id="good_add_{{$good['id']}}"
                                       class="link fern">
                                        @if($good['good_category_id'][0] === 6 || $good['good_category_id'][0] === 7)
                                            Купить
                                        @else
                                            В корзину
                                        @endif
                                    </a>
                                @else
                                    <p>Товар закончился</p>
                                @endif
                            </div>
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
