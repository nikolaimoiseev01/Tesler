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
        @livewire('portal.market-page', ['goods' => $goods, 'categories' => $categories, 'abon_page_check' => $abon_page_check])
    </div>
@endsection
