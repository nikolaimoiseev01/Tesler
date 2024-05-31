@extends('layouts.portal')

@section('title')
    {{$good['name']}}
@endsection

@section('content')

    <div class="g_page_wrap">

        <x-ui.menu color="#111010"></x-ui.menu>

        <div class="content g_bread_wrap">
            <a href="{{route('market_page')}}" class="link coal">Магазин</a> / <a
                    href="{{route('good_category_page', $good['good_category_id'][0])}}"
                    class="link coal">{{\App\Models\Good\GoodCategory::where('id', $good['good_category_id'][0])->first(['title'])->title}}</a>
            / <p>{{$good['name']}}</p>
        </div>


        <div class="g_welcome_wrap">

            <div class="examples_wrap">
                <img class="show_full_img" id="main_example"
                     @if(is_null($good->getFirstMediaUrl('good_examples')) || $good->getFirstMediaUrl('good_examples') == '')
                         src="/media/media_fixed/logo_holder.png"
                     @else src="{{$good->getFirstMediaUrl('good_examples')}}"
                     @endif
                     alt="">
                <div class="others_wrap">
                    @foreach($good->getMedia('good_examples') as $key=>$good_example)
                        @if($key != 0 and $key < 4)
                            {{$good_example}}
                        @endif
                    @endforeach
                </div>
            </div>
            @push('scripts')
                <script>
                    $('.others_wrap img').on('click', function () {
                        main_example = $('#main_example')
                        main_src = main_example.attr('src')
                        this_src = $(this).attr('src')

                        main_example.attr('src', this_src)
                        $(this).attr('src', main_src)
                    })
                </script>
            @endpush

            <div class="info">
                <p>{{$good['product_type']}}</p>
                <h2>{{$good['name']}}</h2>
                @if(Auth::check())
                    <a href="/admin/good/goods/{{$good['id']}}/edit"  target="_blank" class="link coal">Страница в Админке</a>

                @endif
                @if($good['desc_small'])
                    <p>{{$good['desc_small']}}</p>
                @endif

                <div class="details">
                    <div>
                        @if($good['brand'])
                            <span class="yellow_info">

                            <a href="{{route('market_page')}}?brand[0]={{$good['brand']}}#market_wrap">
                            <p>Бренд: {{$good['brand']}}</p>
                            </a>

                    </span>
                        @endif
                        @if($good['capacity'] > 0)
                            <span class="yellow_info"><p>{{$good['capacity']}} {{$good['capacity_type']}}</p></span>
                        @endif
                    </div>
                    <div class="price_wrap">
                        @if($good['discount'] > 0)
                            <h2 class="price discount">{{$good['yc_price']}} Р</h2>
                        @endif
                        <h2 class="price">
                            {{$good['yc_price'] * ((100 - $good['discount'])/100)}} Р
                        </h2>
                    </div>

                </div>
                <livewire:portal.components.good.add-to-cart-button :good="$good"></livewire:portal.components.good.add-to-cart-button>
            </div>
        </div>

        <div class="content g_info_wrap">
            <div class="left">
                <p>КОНСУЛЬТАЦИЯ</p>
                <h2> Не знаете, что выбрать? </h2>
                <div>
                    <p>Получите бесплатную онлайн-консультацию
                        от специалистов Tesler и подберите продукт,
                        подходящий именно вам
                    </p>
                </div>
                <a modal-id="consult_modal" class="modal-link link-bg fern">
                    Получить консультацию
                </a>
            </div>

            <div class="right">
                <div class="header_links_wrap">
                    <a href="#description" class="cont_nav_item current link coal">ОПИСАНИЕ</a>

                    @if(!$abon_check)
                        <a href="#usage" class="cont_nav_item link coal">ПРИМЕНЕНИЕ</a>
                        <a href="#compound" class="cont_nav_item link coal">СОСТАВ</a>
                    @endif
                </div>
                <div style="transition: .3s ease-in-out" class="list-wrap">
                    <div id="description">
                        <p class="desc">{{$good['desc']}}</p>
                        @if(json_decode($good['specs_detailed']) != null)
                            <p class="title">Подробныые характеристики</p>
                            <div class="specs_detailed_wrap">
                                @foreach(json_decode($good['specs_detailed']) as $spec)
                                    <div class="spec_detailed_wrap">
                                        <p>{{$spec->title}}</p>
                                        <hr>
                                        <p>{{$spec->value}}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @if(!$abon_check)
                        <div id="usage" class="hide">
                            <p style="margin-top:20px;" class="desc">{{$good['usage']}}</p>
                        </div>
                        <div id="compound" class="hide">
                            <p style="margin-top:20px;" class="desc">{{$good['compound']}}</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <div class="two_parts_block_wrap delivery_wrap">
            <div class="img image_blackout">
                <img src="/media/media_fixed/delivery_image.png" alt="">
            </div>

            <div class="content info">
                <h2>ДОСТАВКА</h2>

                <p>Доставка по Красноярску день в день! Бесплатная доставка
                    при сумме заказа от 3 500 рублей. При сумме заказа меньше 3 500 рублей – за ваш счет по актуальному
                    прайсу Яндекс-доставки.

                    <br><br>Доставка по всей России курьерской службой СДЭК, от 6000 рублей – бесплатно.</p>
            </div>
        </div>
    </div>
@endsection
