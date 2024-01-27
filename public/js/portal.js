// ------  MODALS  ------ //

var modal_on = 0
$('.modal-link').on('click', function (event) {
    event.preventDefault()
    // Закрываем предыдущее
    // $('.modal').fadeOut(200);
    // modal_on = 0

    modal = $(this).attr('modal-id');

    $('#' + modal).fadeToggle(200);
    $('body').css('overflow-y', 'hidden')
    setTimeout(function () {
        modal_on = 1
    }, 1000)
})

$(document).on("click", function (event) {
    if (!$(event.target).closest(".modal_content").length) {
        if (modal_on === 1) {
            $('.modal').fadeOut(200);
            $('body').css('overflow-y', 'auto')
            modal_on = 0
        }
    }
});

// ------  / MODALS  ------ //


// ------ SHOW DIF ELEMENTS BY WIDTH ------ //
    if ($(window).innerWidth() < 768) {
        $('.mobile_only').show()
        $('.desktop_only').hide()
    } else {
        $('.mobile_only').hide()
        $('.desktop_only').show()
    }


// ------  PRELOADER  ------ //
function hide_preloader() {
    $('.page-preloader-wrap').addClass('preloaded_hiding');
    window.setTimeout(function () {
        $('.page-preloader-wrap').addClass('preloaded_loaded');
        $('.page-preloader-wrap').removeClass('preloaded_hiding');
    }, 500);
}
$(window).on('load', function () {
    hide_preloader()
});
setTimeout(function() {
    hide_preloader()
}, 1000)

// ------  //// PRELOADER  ------ //

// ------  SMOOTH SCROLLING  ------ //
// Select all links with hashes
$('a[href*="#"]')
    // Remove links that don't actually link to anything
    .not('[href="#"]')
    .not('[href="#0"]')
    .click(function (event) {
        check_paren_class = $($(this).parent()[0]).attr('class')
        // On-page links
        if (check_paren_class !== 'header_links_wrap' &&
            location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '')
            &&
            location.hostname === this.hostname
        ) {
            // Figure out element to scroll to
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            // Does a scroll target exist?
            if (target.length) {
                // Only prevent default if animation is actually gonna happen
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000, function () {
                    // Callback after animation
                    // Must change focus!
                    var $target = $(target);
                    $target.focus();
                    if ($target.is(":focus")) { // Checking if the target was focused
                        return false;
                    } else {
                        $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                        $target.focus(); // Set focus again
                    }
                    ;
                });
            }
        }
    });

function show_hide_scroll() {
    if (window.pageYOffset < 500) {
        $('.go_to_head_wrap').hide()
    } else {
        $('.go_to_head_wrap').show()
    }
}

window.addEventListener("scroll", show_hide_scroll, false);
window.addEventListener("load", show_hide_scroll, false);
// ------ // SMOOTH SCROLLING  ------ //

// ------  TRIGGER SEVERVICE ADD BUTTON  ------ //
$(document).ready(function () {
    Livewire.emit('update_service_buttons')
})


document.addEventListener('trigger_service_add_button', event => {
    found_button = $('#service_add_bg_' + event.detail.id)
    if (event.detail.type === 'add') {
        found_button.addClass('service_added')
        found_button.attr('data-old-text', found_button.text())
        found_button.text('в корзине')
        found_button.removeAttr('onclick')
    } else if (event.detail.type === 'remove') {
        found_button.removeClass('service_added')
        found_button.text(found_button.attr('data-old-text'))
        found_button.removeAttr('onclick')
        found_button.attr('onclick', "Livewire.emit('service_cart_add', " + event.detail.id + ')')
    }

})
// ------ // TRIGGER SEVERVICE ADD BUTTON  ------ //


// ------  TRIGGER GOOD ADD BUTTON  ------ //
$(document).ready(function () {
    Livewire.emit('update_good_buttons')
    Livewire.emit('show_red_cart_s')
})

document.addEventListener('update_red_cart', event => {
    cart_total = event.detail.cart_total
    cart_services_count = event.detail.cart_services_count
    cart_goods_count = event.detail.cart_goods_count

    if ((cart_services_count == null && cart_goods_count == null) || (cart_services_count + cart_goods_count) === 0) {
        $('.red_cart').hide()
    } else {
        $('.red_cart').show()
        $('.red_cart p').text((cart_services_count + cart_goods_count))
    }
    if (cart_services_count == null || cart_services_count === 0) {
        $('#cart_service_button span').hide()
        $('#cart_service_button').html('Услуги (<span>0</span>)')
    } else {
        $('#cart_service_button span').show()
        $('#cart_service_button span').text(cart_services_count)
    }

    if (cart_goods_count == null || cart_goods_count === 0) {
        $('#cart_good_button span').hide()
        $('#cart_good_button').html('Товары (<span>0</span>)')
    } else {
        $('#cart_good_button span').show()
        $('#cart_good_button span').text(cart_goods_count)
    }

})

document.addEventListener('trigger_good_add_button', event => {
    found_button = $('#good_add_' + event.detail.id)
    if (event.detail.type === 'add') {
        found_button.addClass('good_added')
        found_button.attr('data-old-text', found_button.text())
        found_button.text('в корзине')
        found_button.removeAttr('onclick')
    } else if (event.detail.type === 'remove') {
        found_button.removeClass('good_added')
        found_button.text(found_button.attr('data-old-text'))
        found_button.removeAttr('onclick')
        found_button.attr('onclick', "Livewire.emit('good_cart_add', " + event.detail.id + ')')
    }
})
// ------ // TRIGGER GOOD ADD BUTTON  ------ //

// ------ TRIGGER CARTS  ------ //
function show_good_cart() {
    $('.good_cart_wrap').show()
    $('#cart_good_button').addClass('active')

    $('.service_cart_block_wrap').hide()
    $('#cart_service_button').removeClass('active')
}

function show_service_cart() {
    $('.good_cart_wrap').hide()
    $('#cart_good_button').removeClass('active')
    $('.service_cart_block_wrap').show()
    $('#cart_service_button').addClass('active')
}

$('#cart_service_button').on('click', function (event) {
    event.preventDefault();
    show_service_cart()
})

$('#cart_good_button').on('click', function (event) {
    event.preventDefault();
    show_good_cart()
})


document.addEventListener('trigger_good_cart_open', function () {
    $('.cart_block_wrap').show("slide", {direction: "right"});
    show_good_cart()

})

document.addEventListener('trigger_good_cart_close', function () {
    $('.cart_block_wrap').hide("slide", {direction: "right"});
})

document.addEventListener('trigger_service_cart_open', function () {
    $('.cart_block_wrap').show("slide", {direction: "right"});
    show_service_cart()

})

document.addEventListener('trigger_service_cart_close', function () {
    $('.cart_block_wrap').hide("slide", {direction: "right"});
})

$('.cart_block_wrap').hide();
show_good_cart()

$('#good_cart_bottom_button').on('click', function (event) {
    event.preventDefault();
    $('.cart_block_wrap').show("slide", {direction: "right"});
})

$(document).mouseup(function(e)
{
    var container = $(".cart_block_wrap");

    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        $('.cart_block_wrap').hide("slide", {direction: "right"});
    }
});

$('#good_cart_header_button, .cart_wrap .close_cross').on('click', function () {
    $('.cart_block_wrap').toggle("slide", {direction: "right"});
})

// ------ // TRIGGER GOOD CART  ------ //


// ------  ACTIVE MENU ELEMENT  ------ //
$(".welcome_menu a").each(function () {

    var location2 = window.location.protocol + '//' + window.location.host + window.location.pathname;
    var link = this.href;

    // console.log("link: " + link + " AND current: " + location2)
    if (location2.startsWith(link)) {
        if (window.location.pathname !== '/') {
            $(this).addClass('active');
        }

    }
});
// ------  // ACTIVE MENU ELEMENT  ------ //

$(document).ready(function () {
    $('.mobile_input').mask('0 (000) 000-00-00');
})


// ------ SHOW FULL IMG ------ //

$('.show_full_img').on('click', function(e) {
    url = $(this).attr('src')

    $('#img_full').attr('src', url)
    $('#img_full_modal').fadeToggle(200);
    $('body').css('overflow-y', 'hidden')
    setTimeout(function () {
        modal_on = 1
    }, 500)
})






