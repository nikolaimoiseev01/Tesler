function main_js_trigger() {

// ------  PRELOADER  ------ //
    $(window).on('load', function () {
        $('.page-preloader-wrap').addClass('preloaded_hiding');
        window.setTimeout(function () {
            $('.page-preloader-wrap').addClass('preloaded_loaded');
            $('.page-preloader-wrap').removeClass('preloaded_hiding');
        }, 500);
    });

// ------  //// PRELOADER  ------ //

    // ------  BUTTONS PRELOADER  ------ //
    $('.show_preloader_on_click').click(function () {
        height = $(this).innerHeight();
        width = $(this).innerWidth();
        console.log(height);
        $(this).css('width', width)
        $(this).css('height', height)
        $(this).css('background', 'none');
        $(this).css('color', 'white');
        $(this).css('disabled', true);
        $(this).css('cursor', 'wait');
        $(this).html('<span class="button--loading"></span>')
    })

    // ------  ACTIVE MENU ELEMENT  ------ //
    $(".nav-treeview .nav-link, .nav-link").each(function () {
        var location2 = window.location.protocol + '//' + window.location.host + window.location.pathname;
        var link = this.href;

        // console.log("link: " + link + " AND current: " + location2)
        if (location2.startsWith(link)) {
            $(this).addClass('active');
            $(this).parent().parent().parent().addClass('menu-is-opening menu-open');
            $(this).parent().parent().show();
        }
    });


    // ------ CUSTOM FILE INPUT ------ //

    $('.custom-file-input').each(function () {
        $(this).on('change', function () {
            var fileName = $(this)[0].files[0].name;
            $("#label_" + $(this).attr('name')).html(fileName);
        })
    })

    // ------  LiveWire_MODAL  ------ //
    $(document).on("click", function (event) {

        if (!$(event.target).closest(".lw_modal_content").length) {
            $('.lw_modal_wrap').hide();
            modal_on = 0
        }
    });

// ------  / MODALS  ------ //

    $('.image_edit_button').on('click', function () {
        src = $(this).parent().children('img').attr('src')
        comp_for_refresh = $(this).parent().children('img').attr('data-crop-component')
        min_width = $(this).parent().children('img').attr('data-crop-width')
        min_height = $(this).parent().children('img').attr('data-crop-height')
        data_crop_media = $(this).parent().children('img').attr('data-crop-media')
        passing = {}
        passing ["src"] = src;
        passing ["comp_for_refresh"] = comp_for_refresh;
        passing ["min_width"] = min_width;
        passing ["min_height"] = min_height;
        passing ["data_crop_media"] = data_crop_media;
        Livewire.emit("openModal", "admin.crop-image", passing)
    })

}

main_js_trigger()



