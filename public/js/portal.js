// ------  MODALS  ------ //
var modal_on = 0
$('.modal-link').on('click', function(event) {
    event.preventDefault()
    modal = $(this).attr('modal-id');
    $('#' + modal).fadeToggle(200);
    setTimeout(function () {
        modal_on = 1
    }, 1000)
})

$(document).on("click", function (event) {
    if (!$(event.target).closest(".modal_content").length) {
        if (modal_on === 1) {
            $('.modal').fadeOut(200);
            modal_on = 0
        }

    }
});

// ------  / MODALS  ------ //


// ------  PRELOADER  ------ //
$(window).on('load', function() {
    $('.page-preloader-wrap').addClass('preloaded_hiding');
    window.setTimeout(function () {
        $('.page-preloader-wrap').addClass('preloaded_loaded');
        $('.page-preloader-wrap').removeClass('preloaded_hiding');
    }, 500);
});

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
// ------ // SMOOTH SCROLLING  ------ //

// ------  TRIGGER SEVERVICE ADD BUTTON  ------ //
$(document).ready(function() {
    Livewire.emit('update_service_buttons')
})


document.addEventListener('trigger_service_add_button', event => {
    found_button =  $('#service_add_bg_' + event.detail.id)
    if(event.detail.type === 'add') {
        found_button.addClass('service_added')
        found_button.attr('data-old-text', found_button.text())
        found_button.text('в корзине')
        found_button.removeAttr('onclick')
    }
    else if(event.detail.type === 'remove') {
        found_button.removeClass('service_added')
        found_button.text(found_button.attr('data-old-text'))
        found_button.removeAttr('onclick')
        found_button.attr('onclick', "Livewire.emit('service_cart_add', " + event.detail.id + ')')
    }

})
// ------ // TRIGGER SEVERVICE ADD BUTTON  ------ //


// ------  TRIGGER GOOD ADD BUTTON  ------ //
$(document).ready(function() {
    Livewire.emit('update_good_buttons')
})


document.addEventListener('trigger_good_add_button', event => {
    found_button =  $('#good_add_' + event.detail.id)
    if(event.detail.type === 'add') {
        found_button.addClass('good_added')
        found_button.attr('data-old-text', found_button.text())
        found_button.text('в корзине')
        found_button.removeAttr('onclick')
    }
    else if(event.detail.type === 'remove') {
        found_button.removeClass('good_added')
        found_button.text(found_button.attr('data-old-text'))
        found_button.removeAttr('onclick')
        found_button.attr('onclick', "Livewire.emit('good_cart_add', " + event.detail.id + ')')
    }

})
// ------ // TRIGGER GOOD ADD BUTTON  ------ //

// ------ TRIGGER GOOD CART  ------ //
$('.good_cart_wrap').hide();
$('#good_cart_header_button, .good_cart_wrap .close_cross').on('click', function() {
    $('.good_cart_wrap').toggle("slide", { direction: "right" });
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





