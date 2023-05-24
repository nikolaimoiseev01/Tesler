@extends('layouts.portal')

@section('title')Магазин@endsection

@section('content')
    <div class="market_page_wrap">
        <x-ui.menu color="#111010"></x-ui.menu>
        <div class="content categories_filter_wrap">
            @foreach($categories as $category)
                <div onclick="location.href='{{route('good_category_page', $category['id'])}}';" class="category_filter_wrap">
                    <img src="{{$category->getFirstMediaUrl('pic_goodcategory_small')}}" alt="">
                    <p>{{$category['title']}}</p>
                </div>
            @endforeach
        </div>
{{--        <div class="page_cover image_blackout">--}}
{{--            <img src="/media/media_fixed/abonement_cover.png" alt="">--}}
{{--        </div>--}}
        @livewire('portal.market-page', ['goods' => $goods, 'categories' => $categories, 'abon_page_check' => $abon_page_check])

        <div class="partners_block">
            <div class="parnters_wrap">
                <h1 class="content">Выбираем работать с лучшими</h1>
                <div class="content">
                    <img src="/media/media_fixed/logo_academie.png" alt="">
                    <img src="/media/media_fixed/logo_tokio.jpg" alt="">
                    <img src="/media/media_fixed/logo_lebel.jpg" alt="">
                    <img src="/media/media_fixed/logo_luxio.jpg" alt="">
                    <img src="/media/media_fixed/logo_hydra.jpg" alt="">
                    <img src="/media/media_fixed/logo_zeilinski.jpg" alt="">
                </div>
            </div>
        </div>

        <div class="content about_wrap">
            <div class="image_blackout">
                <img src="/media/media_fixed/need_consultation_косметология.jpg" alt="">
            </div>
            <div class="text">
                <p>КОНСУЛЬТАЦИЯ</p>
                <h2> не знаете что выбрать? </h2>
                <div>
                    <p>Получите бесплатную онлайн-консультацию от специалистов Tesler и подберите услугу, подходящую именно
                        вам
                    </p>
                </div>
                <a modal-id="consult_modal" class="modal-link link-bg fern">подобрать уход</a>
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
