@extends('layouts.portal')

@section('title')Программа лояльности@endsection

@section('content')
    <div class="loyalty_page_wrap market_page_wrap">
        <x-ui.menu color="white"></x-ui.menu>
        <div class="page_cover image_blackout">
            <img src="/media/media_fixed/abonement_cover.png" alt="">
        </div>
        <div class="content loaylty_info_wrap">
            <div class="info">
                <h2>Программа лояльности</h2>
                <p-400>
                    Спланируйте свой первый визит с максимальной выгодой, а далее накапливайте бонусы за каждое
                    посещение и используйте их, оплачивая до 30% от стоимости услуг.
                </p-400>
            </div>
            <div class="right_wrap">
                <span class="yellow_info"><p>получайте БОНУСЫ С КАЖДОГО ПОСЕЩЕНИЯ – 3% от чека </p></span>
                <span class="yellow_info"><p>1  бонус = 1 рубль</p></span>
                <span class="yellow_info"><p>оплачивайте до 30% СТОИМОСТИ УСЛУГ</p></span>
                <a href="{{route('home')}}#scopes_main_page" class="link-bg coal">Записаться</a>
            </div>
        </div>
        <div class="content g_info_wrap">
            <div class="left">
            </div>

            <div class="right">
                <div class="header_links_wrap">
                    <a href="#description" class="cont_nav_item current link coal">ОПИСАНИЕ</a>
                    <a href="#rules" class="cont_nav_item link coal">ПРАВИЛА</a>
                    <a href="#profit" class="cont_nav_item link coal">ВЫГОДЫ</a>
                </div>
                <div style="transition: .3s ease-in-out" class="list-wrap">
                    <div id="description">
                        <h2>Карта лояльности</h2>
                        <p class="desc">
                            Познакомьтесь с салоном со скидкой 10% на все услуги, кроме окрашивания и ухода для волос,
                            на них – 5%. Накапливайте бонусы при каждом посещении: 3% от суммы чека. Оплачивайте
                            бонусами до 30% от стоимости услуг.
                            <br><br>
                            1 бонус = 1 рубль. Никакого пластика, всё – в вашем телефоне.
                            <br><br>
                            Первый визит – прекрасная возможность посетить несколько процедур с максимальной скидкой.
                        </p>
                    </div>
                    <div id="rules" class="hide">
                        <p style="margin-top:20px;" class="desc">
                            <p>Правила</p>
                        </p>
                    </div>
                    <div id="profit" class="hide">
                        <p>Выгоды</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="interior_pics">
            <x-ui.gallery
                title="НАШ ИНТЕРЬЕР"
                :photos="$interior_pics">
            </x-ui.gallery>
        </div>


        <x-ui.preview-cta
            title="абонементы"
            link="{{route('abonements_page')}}?yc_category[0]=7"
            :cards="$abonements">
        </x-ui.preview-cta>

        <x-ui.need-consultation/>
    </div>
    </div>
@endsection
