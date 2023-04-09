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

{{--<x-ui.modal/>--}}
<x-header/>
<div class="content-wrapper">
    @yield('content')
</div>
<x-footer/>

@livewire('portal.service-cart')
@livewire('portal.good-cart')

<!-- include jQuery library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

@livewireScripts

<script defer src="/js/portal.js"></script>

<!-- ---------- FILEPOND ---------- -->
<!-- include FilePond library -->
<script src="/plugins/filepond/filepond.js"></script>
<!-- include FilePond jQuery adapter -->
<script src="/plugins/filepond/filepond.jquery.js"></script>
<!-- include FilePond plugins -->
<script src="/plugins/filepond/filepond-plugin-image-preview.js"></script>

<script src="/plugins/alpinejs/alpinejs.js" defer></script>

{{--<script defer>--}}
{{--        (function ($) {console.log('test')})(jQuery);--}}
{{--</script>--}}


<script>
    $('.gallery').on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
        //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
        // id = $(this).parent('.gallery_wrap').attr('id').slice(6,99);
        // slider = $(this).children('.gallery');
        var $status_gallery = $(this).parent('.gallery_wrap').children('.desc').children('.navigation').children('.pagingInfo_gallery');
        var i = (currentSlide ? currentSlide : 0) + 1;
        $status_gallery.text(i + '/' + slick.slideCount);
    });
</script>
<script src="/plugins/slick/slick.js"></script>


@stack('scripts')

<script>
    // First register any plugins
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        // FilePondPluginImageExifOrientation,
        // FilePondPluginFileValidateSize,
        // FilePondPluginImageEdit
    );
    FilePond.setOptions({
        server: {
            url: '/upload',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }

    });
</script>
<!-- ---------- ////////  FILEPOND ---------- -->


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
