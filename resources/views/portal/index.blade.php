@extends('layouts.portal')

@section('title')Главная@endsection

@section('content')
    <x-ui.modal id="calc_cosmetic">
        @livewire('portal.calc-cosmetic')
    </x-ui.modal>

    <x-ui.modal id="calc_hair">
        @livewire('portal.calc-hair')
    </x-ui.modal>


    <x-home-page.welcome-block/>

    {{--    <div class="content">--}}

    <div class="promo_slider">
        <x-ui.slider
            title="Акции, новости и события TESLER"
            :cards="$promos">
        </x-ui.slider>
    </div>

    <div class="content index_page about_wrap">
        <div class="text">
            <p>О НАС</p>
            <h2> Tesler – салон, <br> с заботой о вас </h2>
            <div>
                <p>Слияние комфорта, уюта и профессионализма — вот что вы почувствуете, впервые посетив наш салон.
                    В его создание вошла частичка мировоззрения каждой из нас:  "что может быть важнее красоты?"
                </p>
                <p>
                    Благодаря курсам Tesler мы вырастили команду профессионалов, где каждый мастер влюблён в свою
                    работу, постоянно самосовершенствуется, обладает невероятной эмпатией
                    и всегда в курсе тенденций в сфере красоты.
                    Добро пожаловать в Tesler!
                </p>
            </div>
        </div>
        <img src="/media/media_fixed/about_pic.png" alt="">
    </div>

    <div class="interior_pics">
        <x-ui.gallery
            title="НАШ ИНТЕРЬЕР"
            :photos="$interior_pics">
        </x-ui.gallery>
    </div>

    <div class="content two_parts_block_wrap">
        <div class="left"></div>
        <div class="right">
            <h2>Можем всё, о чем <br> вы мечтаете</h2>
            <p>
                Для нас важно, чтобы каждый гость почувствовал себя желанным. Мы позаботились о парковке, температуре
                воздуха
                в салоне, массажёре для ног во время долгих парикмахерских процедур, комфортных удобных креслах и,
                конечно, всегда рады угостить вас чашечкой идеального кофе, вкус и качество которого мы выбирали
                трепетно и с любовью.
                </br></br>
                Tesler – уникальное место, где вы сможете исполнить ваши желания и закрыть любые потребности. У нас есть
                всё: от ногтевого сервиса и brow-бара до сложных окрашиваний, косметологии и SPA-процедур.
            </p>
            <div class="workers_wrap">
                @foreach($admins as $admin)
                    <div class="worker">
                        <a href="{{route('staff_page', $admin['id'])}}">
                            <img src="{{$admin['avatar']}}" alt="">
                            <p-400>{{$admin['name']}}</p-400>
                            <p>{{$admin['specialization']}}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="content calcs_wrap">
        <div class="calc_card_wrap">
            <div class="text">
                <h2>Калькулятор окрашивания</h2>
                <p>Узнайте стоимость окрашивания онлайн в зависимости от сложности процедуры и ваших волос за 2
                    минуты</p>
            </div>
            <div class="image">
                <img src="/media/media_fixed/calc_coloring.png" alt="">
                <x-ui.link modal-id="calc_hair" class="link-bg coal modal-link">Рассчитать окрашивание</x-ui.link>
            </div>

        </div>

        <div class="calc_card_wrap">
            <div class="text">
                <h2>онлаЙн –
                    косметолог</h2>
                <p>Ответьте на несколько вопросов и узнайте, в чем нуждается ваша кожа, а врач-косметолог предложит
                    подходящие процедуры и уход.</p>
            </div>
            <div class="image">
                <img src="/media/media_fixed/calc_cosmetic.png" alt="">
                <x-ui.link modal-id="calc_cosmetic" class="link-bg coal modal-link">Подобрать процедуру</x-ui.link>
            </div>

        </div>
    </div>

    <x-home-page.scopes :scopes="$scopes"></x-home-page.scopes>

{{--    <div class="promo_slider">--}}
{{--        <x-ui.video-slider></x-ui.video-slider>--}}
{{--    </div>--}}

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

    <x-ui.preview-cta
        title="SHOP-сеты <br> из  любимых <br> продуктов TESLER"
        link="{{route('market_page')}}"
        :cards="$shopsets"></x-ui.preview-cta>

    <div id="courses_main_page" class="index_page content courses_wrap about_wrap">
        <div class="text">
            <p>бьюти-обучение</p>
            <h2> Получи новые <br> знания в салоне <br> Tesler </h2>
            <div>
                <p><br>
                    Мы регулярно проводим курсы как для тех, кто хочет освоить профессию с нуля, так и для уже
                    работающих мастеров, желающих обновить знания.
                </p>
                <p>
                    Выдаем сертификат и даем рассрочку на 4 месяца без %.
                </p>
            </div>

            <div class="buttons_wrap">
                @foreach($courses as $course)
                    <div onclick="location.href='{{route('course_page', $course['id'])}}';" class="button">
                        <svg width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.1077 2.25602L17.3556 8.50389H0.769775V10.5039H17.3556L11.1077 16.7517L12.5219 18.1659L21.184 9.50389L12.5219 0.841797L11.1077 2.25602Z"
                                fill="#DDDDD5"/>
                        </svg>

                        <h2>{{$course['title']}}</h2>
                        <p>{{$course['type']}}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <img src="/media/media_fixed/courses_main.png" alt="">
    </div>

    <div class="reviews_block">

        <img src="/media/media_fixed/review_back.png" alt="">
        <div class="content">
            <h1>уже 100+ гостей </br> оценили свои визиты </br> и оставили отзыв</h1>
            <div class="reviews_wrap">
                <div class="review_wrap">
                    <div class="insta img_wrap">
                        <img src="/media/media_fixed/logo_insta.png" alt="">
                    </div>
                    <div style="text-align: center;">
                        <p>Instagram</p>
                        <p>4,8
                            <svg width="17" height="22" viewBox="0 0 17 22" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.75 12.7539C16.75 17.3103 13.0563 21.0039 8.5 21.0039C3.94365 21.0039 0.25 17.3103 0.25 12.7539C0.25 5.00391 8.5 0.00390625 8.5 0.00390625V6.75391C8.5 7.72041 9.2835 8.50391 10.25 8.50391C11.2165 8.50391 12 7.72041 12 6.75391V5.28097C14.8065 6.59768 16.75 9.44883 16.75 12.7539Z"
                                    fill="black"/>
                            </svg>
                        </p>
                    </div>
                </div>
                <div class="review_wrap">
                    <div class="2gis img_wrap">
                        <img src="/media/media_fixed/logo_2gis.png" alt="">
                    </div>
                    <div style="text-align: center;">
                        <p>КАРТЫ 2 GIS</p>
                        <p>4,8
                            <svg width="17" height="22" viewBox="0 0 17 22" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.75 12.7539C16.75 17.3103 13.0563 21.0039 8.5 21.0039C3.94365 21.0039 0.25 17.3103 0.25 12.7539C0.25 5.00391 8.5 0.00390625 8.5 0.00390625V6.75391C8.5 7.72041 9.2835 8.50391 10.25 8.50391C11.2165 8.50391 12 7.72041 12 6.75391V5.28097C14.8065 6.59768 16.75 9.44883 16.75 12.7539Z"
                                    fill="black"/>
                            </svg>
                        </p>
                    </div>
                </div>
                <div class="review_wrap">
                    <div class="ya img_wrap">
                        <img src="/media/media_fixed/logo_yandex.png" alt="">
                    </div>
                    <div style="text-align: center;">
                        <p>Yandex Maps</p>
                        <p>4,8
                            <svg width="17" height="22" viewBox="0 0 17 22" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.75 12.7539C16.75 17.3103 13.0563 21.0039 8.5 21.0039C3.94365 21.0039 0.25 17.3103 0.25 12.7539C0.25 5.00391 8.5 0.00390625 8.5 0.00390625V6.75391C8.5 7.72041 9.2835 8.50391 10.25 8.50391C11.2165 8.50391 12 7.72041 12 6.75391V5.28097C14.8065 6.59768 16.75 9.44883 16.75 12.7539Z"
                                    fill="black"/>
                            </svg>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{--    </div>--}}
@endsection
