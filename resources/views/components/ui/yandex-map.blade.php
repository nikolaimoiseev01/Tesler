
<div class="map_wrap">
    <div class="ya_map_to_black"></div>
    <div id="map">

        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Adff850920a319d0f65c7e8954ea5aa7ef045f8c40017915c0fab82d0a34d1815&amp;width=100%&amp;height=100%&amp;lang=ru_RU&amp;scroll=true"></script>

    </div>
</div>

{{--@push('scripts')--}}
{{--    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=<66f728ea-edc8-4f2b-8138-e07555c473aa>"--}}
{{--            type="text/javascript"></script>--}}
{{--    <script>--}}
{{--        var myMap;--}}

{{--        // Дождёмся загрузки API и готовности DOM.--}}
{{--        ymaps.ready(init);--}}

{{--        function init() {--}}
{{--            // Создание экземпляра карты и его привязка к контейнеру с--}}
{{--            // заданным id ("map").--}}
{{--            myMap = new ymaps.Map('map', {--}}
{{--                // При инициализации карты обязательно нужно указать--}}
{{--                // её центр и коэффициент масштабирования.--}}
{{--                center: [56.042701, 92.921606],--}}
{{--                zoom: 13,--}}
{{--                controls: []--}}
{{--            }, {--}}
{{--                searchControlProvider: 'yandex#search'--}}
{{--            });--}}

{{--            myPlacemark = new ymaps.Placemark(myMap.getCenter(), {}, {--}}
{{--                // Опции.--}}
{{--                // Необходимо указать данный тип макета.--}}
{{--                iconLayout: 'default#image',--}}
{{--                // Своё изображение иконки метки.--}}
{{--                iconImageHref: '/media/media_fixed/ya_map_icon.svg',--}}
{{--                // Размеры метки.--}}
{{--                iconImageSize: [30, 42],--}}
{{--                // Смещение левого верхнего угла иконки относительно--}}
{{--                // её "ножки" (точки привязки).--}}
{{--                iconImageOffset: [-5, -38]--}}
{{--            }),--}}

{{--                myMap.geoObjects--}}
{{--                    .add(myPlacemark)--}}

{{--            myMap.copyrights.removeProvider();--}}


{{--        }--}}
{{--    </script>--}}
{{--@endpush--}}
<style>

    .map_wrap {
        position: relative;
    }

    .ymaps-2-1-79-gototech {
        display: none !important;
    }

    .ya_map_to_black {
        mix-blend-mode: difference;
        pointer-events: none;
        background: white;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        position: absolute;
        z-index: 1;
    }

    .ymaps-2-1-79-map, .ya_map_to_black, #map {
        width: 593px !important;
        height: 328px !important;
    }

    @media (max-width: 1000px) {
        .ymaps-2-1-79-map, .ya_map_to_black, #map {
            width: 393px !important;
            height: 228px !important;
        }
    }

    @media (max-width: 800px) {
        .ymaps-2-1-79-map, .ya_map_to_black, #map {
            width: 293px !important;
            height: 180px !important;
        }
    }

    /*@media (max-width: 600px) {*/
    /*    .map_wrap {*/
    /*        display: none;*/
    /*    }*/
    /*}*/

    /*окрашивание карты*/
    .yandex_map_grey_scale {
        filter: grayscale(1);
    / / -ms-filter: grayscale(1);
        -webkit-filter: grayscale(1);
        -moz-filter: grayscale(1);
        -o-filter: grayscale(1);
    }

    /*режим наложения на шейп и отключение реакции курсора*/

    .ya_map_to_black {

    }
</style>

{{--<script>--}}
{{--    $(document).ready(function() {--}}
{{--        $('.ymaps3x0--main-engine-container').each(function() {$(this).css('-webkit-filter', 'grayscale(1)')})--}}
{{--    })--}}
{{--</script>--}}







