@extends('layouts.portal')

@section('title')Абонементы и сертификаты@endsection

@section('content')
    <div class="abon_page_wrap market_page_wrap">
        <x-ui.menu color="white"></x-ui.menu>
        <div class="page_cover image_blackout">
            <img src="/media/media_fixed/abonement_cover.png" alt="">
        </div>
        <div class="content abonements_info_wrap">
            <h2>Абонементы и сертификаты</h2>
            <div class="info_wrap">
                <div class="left_wrap">
                    <span class="yellow_info"><p>Абонемент</p></span>
                    <p-400>
                        Прекрасная возможность оплатить любимую услугу один раз, а потом просто приходить и наслаждаться
                        процессом. Кроме того, это еще и выгодно. Поверьте, этим абонементом вы точно будете
                        пользоваться!
                        <br><br>
                        А еще абонемент можно подарить.
                    </p-400>
                </div>
                <div class="right_wrap">
                    <span class="yellow_info"><p>Сертификаты</p></span>
                    <p-400>
                        Отличный способ порадовать близкого человека, даже если вы не знаете его конкретных желаний. А
                        также шанс познакомить с салоном подругу и показать, как у нас тут всё устроено.
                        <br><br>
                        А мы в свою очередь сделаем всё, чтобы важным для вас людям понравилось в Tesler.
                    </p-400>
                </div>
            </div>
        </div>

        <div class="content categories_filter_wrap">
            @foreach($categories as $category)
                @if(!($category['title'] == 'Абонементы'))
                    <div onclick="location.href='{{route('good_category_page', $category['id'])}}';"
                         class="category_filter_wrap">
                        <img src="{{$category->getFirstMediaUrl('pic_goodcategory_small')}}" alt="">
                        <p>{{$category['title']}}</p>
                    </div>
                @endif
            @endforeach
        </div>
        @livewire('portal.market-page', ['goods' => $goods, 'categories' => $categories, 'abon_page_check' =>
        $abon_page_check])
        <div class="content about_wrap">
            <div class="image_blackout">
                <img src="/media/media_fixed/need_consultation_косметология.jpg" alt="">
            </div>
            <div class="text">
                <p>КОНСУЛЬТАЦИЯ</p>
                <h2> не знаете что выбрать? </h2>
                <div>
                    <p>Получите бесплатную онлайн-консультацию от специалистов Tesler и подберите услугу, подходящую
                        именно
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
