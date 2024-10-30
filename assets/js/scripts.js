var handler;
(function( $ ) {
    'use strict';

    /**
     *
     * Define handlers for when the DOM is ready:
     **/
    $(function() {

        if(!$('form#blope_donation_form').length) {
            var $form = $('<form />', { action: ajax_url, method: 'POST', id: 'blope_donation_form' });
            $form.append(
                '<input type="hidden" name="action" value="blope_donation_charge" />',
                '<input type="hidden" id="stripeToken" name="stripeToken" value="" />',
                '<input type="hidden" id="stripeEmail" name="stripeEmail" value="" />',
                '<input type="hidden" id="stripeAmount" name="stripeAmount" value="" />',
                '<input type="hidden" id="stripeButtonId" name="stripeButtonId" value="" />',
                '<input type="hidden" id="stripeRedirect" name="stripeRedirect" value="0" />',
                '<input type="hidden" id="stripeSecurity" name="stripeSecurity" value="' + blope_nonce + '" />'
            ).appendTo($('body'));

            var $modal = $('<div />', {class: 'blope-modal-wrapper', id: 'blope-modal-wrapper', style: 'display: none;'});
            $modal.append(
                '<div class="blope-modal-container">' +
                    '<div class="blope-modal-content">' +
                        '<div class="blope-modal-header">' +
                            '<span class="blope-nav-close blope-modal-btn" aria-label="Close" style="display: none;"></span>' +
                            '<div class="blope-modal-header-logo"><div class="blope-modal-header-logo-bg" style="background-image: url('+ blope_image_url +');"></div></div>' +
                            '<div class="blope-modal-header-company">'+ blope_site_name +'</div>' +
                            '<div class="blope-modal-header-desc">'+ blope_site_desc +'</div>' +
                        '</div>' +
                        '<div class="blope-modal-devider"></div>' +
                        '<div class="blope-modal-body">' +
                            '<div class="blope-modal-message"><div class="blope-modal-overlay"></div></div>' +
                            '<div class="blope-modal-btn-ok blope-modal-btn" style="display: none;">Done</div>' +
                        '</div>' +
                    '</div>' +
                '</div>'
            );
            $modal.appendTo($('body'));

        }

        // Bind event for buttons
        $('.blope-donation-btn').off('click'); // off event before bind
        $('.blope-donation-btn').bind('click', function (e) {
            var data = $(this).data();
            if (parseInt(data.custom) == 1) {
                //show form custom amount
                var customAmountContainer = $(this).prev('.blope-donation-custom-amount-container');
                var customAmountBtn = customAmountContainer.find('.blope-donation-custom-btn');
                var w = $(this).outerWidth(), h = $(this).outerHeight();
                var pad = (h - 38)/2 + 'px ' + (w-136)/2 + 'px';
                $(this).hide();
                customAmountContainer.css({
                    'padding': pad,
                    'min-width': '136px',
                    'min-height': '38px'
                }).fadeIn();

                customAmountBtn.click(function (e) {
                    var custom_amount = $(this).prev('.blope-donation-custom-amount').find('.blope-donation-custom-amount-input').val();
                     data.custom_amount = custom_amount;
                    getStripeForm(data);
                    e.preventDefault();
                });
            } else {
                getStripeForm(data);
            }

            e.preventDefault();
        });

        //init animation
        $('.blope-donation-btn').each(function (e) {
            var data = $(this).data();
            addButtonAnimation(this, data.animate);
        });


        $('.blope-donation-custom-amount-container').each(function () {
            var spinner = jQuery(this),
                input = spinner.find('input[type="text"]');
            // allow only enter number
            input.keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        });

    });

    /**
     When the window is loaded:
     **/
    $( window ).load(function() {

        function do_ajax_post(ajaxUrl, form) {
            var $loading = $('#blope-modal-wrapper'), _timer_load;
            $loading.show();
            // Disable the submit button
            form.find('button').prop('disabled', true);

            $.ajax({
                type: "POST",
                url: ajaxUrl,
                data: form.serialize(),
                cache: false,
                dataType: "json",
                success: function (data) {
                    document.body.scrollTop = document.documentElement.scrollTop = 0;
                    if (data.success) {
                        $loading.find('.blope-modal-message').html(data.html_msg).css('min-height', 'auto');
                    } else {
                        $loading.find('.blope-modal-message').html(data.msg).css('min-height', 'auto');
                    }
                    $loading.find('.blope-modal-btn').show();
                    $loading.find('.blope-modal-btn').bind('click', function () {
                        $loading.find('.blope-modal-btn').hide();
                        $loading.find('.blope-modal-message').html('<div class="blope-modal-overlay"></div>').css('min-height', '188px');
                        $(this).hide();
                        $loading.hide();
                    });
                }
            });
        }

        handler = StripeCheckout.configure({
            key: blope_stripe_key,
            image: blope_image_url,
            locale: blope_locale,
            token: function(token, args) {
                // Get the token ID to your server-side code for use.
                if($('form#blope_donation_form').length) {
                    $("#stripeToken").val(token.id);
                    $("#stripeEmail").val(token.email);
                    if($('#stripeRedirect').length && $('#stripeRedirect').val() == 1) {
                        $('form#blope_donation_form').submit();
                    } else {
                        var $form = $('form#blope_donation_form');
                        do_ajax_post(ajax_url, $form);
                    }

                }
            }
        });

    });

    //Close Checkout on page navigation:
    $(window).bind('popstate', function (e) {
        handler.close();
    });

})( jQuery );

/**
 * Make animate.css work with jQuery
 * use : jQuery('selector').animate(animation_name);
 */
jQuery.fn.extend({
    animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        this.addClass('animated ' + animationName).one(animationEnd, function() {
            jQuery(this).removeClass('animated ' + animationName);
        });
        return this;
    }
});

/**
 * Set animation on hover and when user scroll to button
 * @param selector  selector
 * @param animation animate.css animation name
 */
function addButtonAnimation(selector, animation) {
    var element = jQuery(selector);
    // on window scroll event
    jQuery(window).scroll(function() {
        var hT = element.offset().top,
            hH = element.outerHeight(),
            wH = jQuery(window).height(),
            wS = jQuery(this).scrollTop();
        if (wS > (hT+hH-wH) && (hT > wS) && (wS+wH > hT+hH) && animation != 'none'){
            element.animateCss(animation);
        }
    });
    // on load event
    if(!element.hasClass('blope-animate-off') && animation != 'none') {
        element.animateCss(animation);
        element.addClass('blope-animate-off');
    }
    // hover event
    element.hover(function () {});
}

function getStripeForm(data) {
    var amount = data.amount;
    if(data.custom == 1) {
        amount = data.custom_amount * blope_unit;
    }

    if(parseInt(amount) <= 0) {
        alert('Please enter donation amount!');
        return;
    }
    var desc = (data.store_desc == '') ? blope_site_desc : data.store_desc;
    var zipCode = data.zip_code == 1 ? true : false;
    var billingAddress = data.billing == 1 ? true : false;
    var allowRememberMe = data.remember == 1 ? true : false;
    var bitcoin = data.bitcoin == 1 ? true : false;
    var panel_label = (data.panel_label == '')? 'Donate' : data.panel_label;

    if(jQuery('#stripeAmount').length) {
        jQuery('#stripeAmount').val(amount);
        jQuery('#stripeButtonId').val(data.id);

        // Open Checkout with further options:
        handler.open({
            name: blope_site_name,
            description: desc,
            amount: amount,
            zipCode: zipCode,
            billingAddress: billingAddress,
            currency: blope_currency,
            panelLabel: panel_label,
            allowRememberMe: allowRememberMe,
            bitcoin: bitcoin,
            opened: function () {
                // before show form
                jQuery('#blope-modal-wrapper').find('.blope-modal-header-desc').html(desc);
            },
            closed: function () {
                // after show form
            }
        });
    }
}
