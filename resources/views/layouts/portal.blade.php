<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="/plugins/filepond/filepond.css">
    <link rel="stylesheet" href="/fonts/fonts.css">
    <link href="/plugins/filepond/filepond-plugin-image-preview.min.css"
          rel="stylesheet">
    <link rel="stylesheet" href="/plugins/slick/slick.css">

    <link rel="apple-touch-icon" sizes="180x180" href="/media/media_fixed/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/media/media_fixed/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/media/media_fixed/favicon/favicon-16x16.png">
    <link rel="manifest" href="/media/media_fixed/favicon/site.webmanifest">
    <link rel="mask-icon" href="/media/media_fixed/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Scripts -->
    @vite([
    'resources/sass/portal.scss',
    'resources/js/app.js'
    ])

    {{--    @vite(['resources/sass/portal.scss','public/build'])--}}

    @livewireStyles

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(96375595, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/96375595" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    @yield('styles')
    <title>Tesler | @yield('title')</title>
</head>
<body>
<div class="page-preloader-wrap">
    <div class="spinner">
        <span class="spinner-inner-1"></span>
        <span class="spinner-inner-2"></span>
        <span class="spinner-inner-3"></span>
    </div>
</div>


<x-ui.modal id="consult_modal">
    @livewire('portal.consult-modal')
</x-ui.modal>

<x-ui.modal id="img_full_modal">
    <img id="img_full">
</x-ui.modal>

<a class="go_to_head_wrap">
    <svg width="19" height="11" viewBox="0 0 19 11" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M16.7546 10.8414L9.5068 3.59357L2.25894 10.8414L0.844727 9.42715L9.5068 0.765137L18.1688 9.42715L16.7546 10.8414Z"
            fill="black"/>
    </svg>
</a>

@push('scripts')
    <script>
        $('.go_to_head_wrap').on('click', function() {
            $("html, body").animate({ scrollTop: 0 }, "slow");
        })
    </script>
@endpush

<div class="menu_mobile_content_back"></div>

{{--<x-ui.modal/>--}}
<x-header/>
<div class="content-wrapper">
    @yield('content')
</div>
<x-footer/>

<div style="display: none;" id="good_cart_bottom_button">
    <svg width="21" height="22" viewBox="0 0 21 22" fill="none"
         xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M5.76953 5.00391C5.76953 2.24249 8.00811 0.00390625 10.7695 0.00390625C13.5309 0.00390625 15.7695 2.24249 15.7695 5.00391H19.7695L20.7695 21.0039H0.769531L1.76953 5.00391H5.76953ZM10.7695 2.00391C12.4264 2.00391 13.7695 3.34706 13.7695 5.00391H7.76953C7.76953 3.34706 9.11263 2.00391 10.7695 2.00391ZM7.76953 7.00391H5.76953V11.0039H7.76953V7.00391ZM13.7695 11.0039H15.7695V7.00391H13.7695V11.0039Z"
              fill="white"/>
    </svg>
    <div class="red_cart"><p>0</p></div>
</div>

<a style="display: none;"
   href="{{ENV('YCLIENTS_ONLINE_LINK')}}"
   target="_blank"
   id="go_to_sign">
    <p>
        Онлайн <br> запись
    </p>
</a>

@push('scripts')
    <script>
        $(document).ready(function () {
            if (window.location.href.indexOf("market") > -1) {
                $('#good_cart_bottom_button').show();
            } else {
                $('#go_to_sign').show();
            }
        });
    </script>
@endpush


<div class="cart_block_wrap">
    <div class="cart_wrap">
        <a class="close_cross">
            <svg width="19" height="3" viewBox="0 0 19 3" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.5 0.679688H0.5V2.67969H18.5V0.679688Z" fill="black"/>
            </svg>
        </a>
        <h2>Корзина</h2>
        <div class="buttons_wrap">
            <a href="" id="cart_service_button" class="link coal">Услуги (<span>0</span>)</a>
            <a href="" id="cart_good_button" class="link coal">Товары (<span>0</span>)</a>
        </div>
        @livewire('portal.good-cart')
        @livewire('portal.service-cart')
    </div>
</div>


<!-- include jQuery library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

@livewireScripts

<script src="/js/portal.js"></script>

{{--<script src="/plugins/alpinejs/alpinejs.js" defer></script>--}}

<script src="/plugins/slick/slick.js"></script>

<script src="/plugins/jquery-mask/jquery.mask.min.js"></script>


{{--<script>--}}
{{--    $('.gallery').on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {--}}
{{--        //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)--}}
{{--        // id = $(this).parent('.gallery_wrap').attr('id').slice(6,99);--}}
{{--        // slider = $(this).children('.gallery');--}}
{{--        var $status_gallery = $(this).parent('.gallery_wrap').children('.desc').children('.navigation').children('.pagingInfo_gallery');--}}
{{--        var i = (currentSlide ? currentSlide : 0) + 1;--}}
{{--        $status_gallery.text(i + '/' + slick.slideCount);--}}
{{--    });--}}
{{--</script>--}}



@stack('scripts')

<script>
    // ------  GOOD INFO DETAILED CHANGE ------ //
    (function ($) {
        $.organicTabs = function (el, options) {
            var base = this;
            base.$el = $(el);
            base.$nav = base.$el.find(".header_links_wrap");

            base.init = function () {
                base.options = $.extend({}, $.organicTabs.defaultOptions, options);

                // Accessible hiding fix
                $(".hide").css({
                    position: "relative",
                    top: 0,
                    left: 0,
                    display: "none"
                });

                base.$nav.on("click", ".cont_nav_item", function () {
                    // Figure out current list via CSS class
                    var curList = base.$el
                            .find("a.current")
                            .attr("href")
                            .substring(1),
                        // List moving to
                        $newList = $(this),
                        // Figure out ID of new list
                        listID = $newList.attr("href").substring(1),
                        // Set outer wrapper height to (static) height of current inner list
                        $allListWrap = base.$el.find(".list-wrap"),
                        curListHeight = $allListWrap.height();
                    $allListWrap.height(curListHeight);

                    if (listID != curList && base.$el.find(":animated").length == 0) {
                        // Fade out current list
                        base.$el.find("#" + curList).fadeOut(base.options.speed, function () {
                            // Fade in new list on callback
                            base.$el.find("#" + listID).fadeIn(base.options.speed);

                            // Adjust outer wrapper to fit new list snuggly
                            var newHeight = base.$el.find("#" + listID).height();
                            $allListWrap.animate({
                                height: newHeight
                            });

                            // Remove highlighting - Add to just-clicked tab
                            base.$el.find(".header_links_wrap .cont_nav_item").removeClass("current");
                            $newList.addClass("current");
                        });
                    }

                    // Don't behave like a regular link
                    // Stop propegation and bubbling
                    return false;
                });
            };
            base.init();
        };

        $.fn.organicTabs = function (options) {
            return this.each(function () {
                new $.organicTabs(this, options);
            });
        };
    })(jQuery);

    $(".g_info_wrap .right").organicTabs({speed: 200});
    // ------  // GOOD INFO DETAILED CHANGE ------ //
</script>


</body>
</html>
