@extends('layouts.new_landing')

@section('title')
    Tesler
@endsection

@section('content')
    <div class="welcome_wrap">
        <div class="background_image">
            <video preload autoplay muted loop playsinline poster="" id="video3" class="video">
                <source src="/media/media_fixed/new_landing_welcome_video.mov" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <div class="content">
            <div class="header_text_wrap">
                <h2>«PRIVATE CHANNEL»</h2>
                <h3>Valentine's Day Edition</h3>
                <p>Tesler Beaitu & Intenso & Damer</p>
            </div>

            <h3 class="background_text">Tesler Beauty</h3>

            <div class="main_text_wrap">
                <div class="top_wrap">
                    <h1 class="top">Privat</h1>
                    <span>^ 14</span>
                </div>

                <h1 class="bottom">Channel</h1>
            </div>

        </div>
    </div>

    <div class="desc_wrap content">
        <p>
            Лучший подарок своему мужчине – это Вы сами. Без будоражащей фантазию упаковки из кружева само собой не
            обойтись. Cамые нескромные комплекты обязаны сыграть роль афродизиака в желанном десерте.
            <br/><br/>
            Начинка? Предлагаем лишить его дара речи… Как? Как гласит истина из к/ф «Грязные танцы» – «Сначала танцуй…».
            Приватный танец в приглушенном свете вечера, манящие линии вокруг талии и желанная Вы – его сон наяву.
            <br/><br/>
            Для полного боевого комплекта не забываем про чувственные локоны, изящные стрелы и влажный блеск…
            хайлайтера. Включите себя!

        </p>
    </div>

    <div class="cards_wrap content">
        <div class="card_wrap">
            <img src="/media/media_fixed/new_landing_card_1.JPG" alt="">
            <h3>TESLER</h3>
            <p class="desc">
                «Аккуратно превосходим других» – дерзко и вкусно о масштабном бьюти-проекте предпринимателя Юлии Теслер,
                зародившемся в 2019.
                <br><br>
                TESLER BEAUTY – один из самых сильных игроков на сибирском рынке. Салоны красоты lux-сегмента. Полный
                спектр услуг, премиальное качество и высококлассный сервис.

            </p>
        </div>

        <div class="card_wrap">
            <img src="/media/media_fixed/new_landing_card_3.JPG" alt="">
            <h3>DAMER</h3>
            <p class="desc">
                Педагог и хореограф самых женственных направлений strip, high heels. Прокачала более 500 учениц.
                <br><br>
                Создатель танцевальных проектов для начинающих и профессиональных танцоров. Участница проекта «Танцы на
                ТНТ».
            </p>
        </div>

        <div class="card_wrap">
            <img src="/media/media_fixed/new_landing_card_2.JPG" alt="">
            <h3>INTENSO</h3>
            <p class="desc">
                Лучшее украшение на твоем теле. Красноярский бренд нижнего белья ручной работы от легендарного
                сибирского креатора Натальи Калининой.
                <br><br>
                Все коллекции лимитированы, чтобы каждая обладательница красивого комплекта белья чувствовала себя
                особенной и неповторимой.

            </p>
        </div>
    </div>

    <div class="desc_2_wrap">
        <div class="content">
            <div class="top_wrap ">
                <div class="left_wrap">
                    <h3 class="title">
                        ПОДАРОК, КОТОРЫЙ ВЫ ПОЛУЧАЕТЕ
                    </h3>
                    <ul>
                        <li>полный романтический образ от визажиста TESLER BEAUTY;</li>
                        <li>чувственный комплекс от INTENSO Lingerie из новой коллекции;</li>
                        <li>1 индивидуальный мастер-класс по sexy-танцу от DAMER.</li>
                    </ul>
                </div>
                <img src="/media/media_fixed/angel.png" alt="">
            </div>
        </div>

    </div>


    <div class="desc_3_wrap">
        <div class="content">
            <h3>УСЛОВИЯ ДЛЯ ПОЛУЧЕНИЯ ПОДАРКА</h3>
            <p>
                Посетите салон TESLER BEAUTY с 10 по 16 февраля, записавшись на любую процедуру. Чем большее количество
                процедур Вы выбираете, тем больше именных жетонов вам присваивается. Дополнительные услуги также
                учитываются. Количество визитов в течение указанного периода не ограничено. 16 февраля мы раскручиваем
                виртуальный барабан с жетонами всех участников и рандомно выбираем победителя!
            </p>
        </div>

    </div>

    <div class="button_wrap">
        <a href="" class="button">ЗАПИСАТЬСЯ</a>
    </div>

@endsection
