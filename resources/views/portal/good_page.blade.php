@extends('layouts.portal')

@section('title'){{$good['name']}}@endsection

@section('content')

    <div class="g_page_wrap">

        <x-ui.menu color="#111010"></x-ui.menu>

        <div class="content g_bread_wrap">
            <a href="{{route('market_page')}}" class="link coal">Магазин</a> / <p>{{$good['name']}}</p>
        </div>


        <div class="g_welcome_wrap">

            <div class="examples_wrap">
                <img id="main_example"
                     @if(is_null($good->getFirstMediaUrl('good_examples')) || $good->getFirstMediaUrl('good_examples') == '')
                     src="/media/media_fixed/logo_holder.png"
                     @else src="{{$good->getFirstMediaUrl('good_examples')}}"
                     @endif
                     alt="">
                <div class="others_wrap">
                    @foreach($good->getMedia('good_examples') as $key=>$good_example)
                        @if($key != 0)
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
                <p>{{\App\Models\GoodCategory::where('id', $good['good_category_id'][0])->first(['title'])->title}}</p>
                <h2>{{$good['name']}}</h2>
                <p>{{$good['desc_small']}}</p>
                <div>
                    <span class="yellow_info">
                         @if($good['brand'])
                            <a href="{{route('market_page')}}?brand[0]={{$good['brand']}}#market_wrap">
                            <p>Бренд: {{$good['brand']}}</p>
                            </a>
                        @endif
                    </span>
                    @if($good['capacity'] > 0)
                        <span class="yellow_info"><p>{{$good['capacity']}} {{$good['capacity_type']}}</p></span>
                    @endif
                    <h2 class="price">{{$good['yc_price']}} Р</h2>
                </div>
                @if(($good['flg_active'] && $good['yc_actual_amount'] > 0) || $good['good_category_id'][0] === 6 || $good['good_category_id'][0] === 7)
                    <a onclick="Livewire.emit('good_cart_add', {{$good['id']}})"
                       id="good_add_{{$good['id']}}"
                       class="link-bg coal">В корзину</a>
                @else
                    <p>Этот товар недоступен для покупки</p>
                @endif
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
                <a href="" class="link-bg fern">Подобрать уход</a>
            </div>

            <div class="right">
                <div class="header_links_wrap">
                    <a href="#description" class="cont_nav_item current link coal">ОПИСАНИЕ</a>
                    <a href="#usage" class="cont_nav_item link coal">ПРИМЕНЕНИЕ</a>
                    <a href="#consist" class="cont_nav_item link coal">СОСТАВ</a>
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
                    <div id="usage" class="hide">
                        <p style="margin-top:20px;" class="desc">{{$good['usage']}}</p>
                    </div>
                    <div id="consist" class="hide">3</div>
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
