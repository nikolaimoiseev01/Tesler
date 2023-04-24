<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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


{{--<x-ui.modal/>--}}
<x-header/>
<div class="content-wrapper">
    @yield('content')
</div>
<x-footer/>

<div id="good_cart_bottom_button">
    <svg  width="21" height="22" viewBox="0 0 21 22" fill="none"
          xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M5.76953 5.00391C5.76953 2.24249 8.00811 0.00390625 10.7695 0.00390625C13.5309 0.00390625 15.7695 2.24249 15.7695 5.00391H19.7695L20.7695 21.0039H0.769531L1.76953 5.00391H5.76953ZM10.7695 2.00391C12.4264 2.00391 13.7695 3.34706 13.7695 5.00391H7.76953C7.76953 3.34706 9.11263 2.00391 10.7695 2.00391ZM7.76953 7.00391H5.76953V11.0039H7.76953V7.00391ZM13.7695 11.0039H15.7695V7.00391H13.7695V11.0039Z"
              fill="white"/>
    </svg>
    <div class="red_cart"><p>0</p></div>
</div>


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
