(function( $ ) {
    'use strict';

    /**
     * From here, you're able to define handlers for when the DOM is
     * ready:
     **/
     $(function() {

         var $loading = $('#blope-loading');
         var $message = $('#blope-message');
         var $tips = $('.tips');
         $loading.hide();
         $message.hide();

         function showError(message) {
             showMessage('error', 'updated', message);
         }

         function showUpdate(message) {
             showMessage('updated', 'error', message);
         }

         function showMessage(addClass, removeClass, message) {
             $message.removeClass(removeClass);
             $message.addClass(addClass);
             $message.html("<p><strong>" + message + "</strong></p>");
             $message.show(0).delay(5000).hide(0);
             document.body.scrollTop = document.documentElement.scrollTop = 0;
         }

         function clearUpdateAndError() {
             $message.html("");
             $message.removeClass('error');
             $message.removeClass('update');
             $message.hide();
         }

         function validField(field, fieldName) {
             var valid = true;
             if (field.val() === "") {
                 showError(fieldName + " must contain a value");
                 valid = false;
             }
             return valid;
         }

         //for uploading images using WordPress media library
         var frame;

         function uploadImage(inputID) {
             // If the media frame already exists, reopen it.
             if ( frame ) {
                 frame.open();
                 return;
             }

             // Create a new media frame
             frame = wp.media({
                 title: 'Choose Image',
                 button: {
                     text: 'Use this media'
                 },
                 multiple: false  // Set to true to allow multiple files to be selected
             });


             // When an image is selected in the media frame...
             frame.on( 'select', function() {

                 // Get media attachment details from the frame state
                 var attachment = frame.state().get('selection').first().toJSON();

                 // Check image dimensions
                 var img = new Image();
                 img.onload = function () {
                     if(this.width != this.height) {
                         alert('Please provide a square image, current image size is ' + this.width + 'x' + this.height + 'px.');
                         // frame.open();
                     }

                 };
                 img.src = attachment.url;

                 // Check image mime type
                 var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
                 if ($.inArray(attachment.mime, ValidImageTypes) > 0) {
                     $(inputID).val(attachment.url);
                     $(inputID).trigger('change');
                 } else {
                     alert('Please provide image types are: .gif, .jpeg, and .png');
                     frame.open();
                 }

             });

             // Finally, open the modal on click
             frame.open();
         }

         $('.insert-image-url').bind('click', function (e) {
             e.preventDefault();
             uploadImage('#image_url');
         });

         // bind event
         $('#image_url').on({
             change: function (e) {
                 $('img.img-display').attr('src', this.value);
             },
             paste: function (e) {
                 var val = this.value;
                 setTimeout(function () {
                     $('img.img-display').attr('src', val);
                 }, 100);
             },
             keyup: function (e) {
                 var val = this.value;
                 setTimeout(function () {
                     $('img.img-display').attr('src', val);
                 }, 50);

             }
         });

         function do_ajax_post(ajaxUrl, form) {
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
                     $loading.hide();
                     document.body.scrollTop = document.documentElement.scrollTop = 0;

                     if (data.success) {
                         showUpdate(data.message);
                         form.find('button').prop('disabled', false);
                         // resetForm(form);

                         if (data.doRedirect) {
                             setTimeout(function () {
                                 window.location = data.redirectURL;
                             }, 1000);
                         }
                     } else {
                         // re-enable the submit button
                         form.find('button').prop('disabled', false);
                         // show the errors on the form
                         if (data.msg) {
                             showError(data.msg);
                         }
                         if (data.validation_result) {
                             var elementWithError = null;
                             for (var f in data.validation_result) {
                                 if (data.validation_result.hasOwnProperty(f)) {
                                     $('input[name=' + f + ']').after('<div class="error"><p>' + data.validation_result[f] + '</p></div>');
                                     elementWithError = f;
                                 }
                             }
                             if (elementWithError) {
                                 var $el = $('input[name=' + elementWithError + ']');
                                 if ($el && $el.offset() && $el.offset().top);
                                 $('html, body').animate({
                                     scrollTop: $el.offset().top
                                 }, 2000);
                             }
                         }
                     }
                 }
             });
         }

         // Begin settings form submit
         $('#blope-settings-submit').bind('click', function () {
             $('#settings-form').submit();
         });
         $('#settings-form').submit(function () {
             $loading.show();
             $tips.removeClass('alert alert-error');
             $tips.html("");

             var $form = $(this);

             // Disable the submit button
             $form.find('button').prop('disabled', true);

             var valid = true;

             if (valid) {
                 $.ajax({
                     type: "POST",
                     url: admin_ajaxurl,
                     data: $form.serialize(),
                     cache: false,
                     dataType: "json",
                     success: function (data) {
                         $loading.hide();
                         document.body.scrollTop = document.documentElement.scrollTop = 0;

                         if (data.success) {
                             $message.find('strong').text("Settings updated");
                             $message.addClass('updated').show(0).delay(5000).hide(0);
                             $form.find('button').prop('disabled', false);
                         }
                         else {
                             // re-enable the submit button
                             $form.find('button').prop('disabled', false);
                             // show the errors on the form
                             $tips.addClass('alert alert-error');
                             $tips.html(data.msg);
                             $tips.fadeIn(500).fadeOut(500).fadeIn(500);
                         }
                     }
                 });

                 return false;
             }

         });
         // End settings form submit
         $('#blope-btn-submit').bind('click', function () {
             $('#blope-button-form').submit();
         });
         $('#blope-button-form').submit(function (e) {
             clearUpdateAndError();

             var customAmount = $('input[name=button_custom_amount]:checked', '#blope-button-form').val();

             var valid = validField($('#blope_btn_title'), 'Button label', $message);
             if (customAmount == '0') {
                 valid = valid && validField($('#blope_btn_amount'), 'Amount', $message);
             }
             if (valid) {
                 var $form = $(this);
                 //post form via ajax
                 do_ajax_post(admin_ajaxurl, $form);
             }

             return false;
         });

         // delete button
         $('button.delete').click(function () {
             var id = $(this).attr('data-id');

             var confirm_message = 'Are you sure you want to delete the button?';
             var update_message = 'Button deleted.';
             var action = 'blope_delete_donation_button';


             var row = $(this).parents('tr:first');

             $loading.show();

             var confirmed = confirm(confirm_message);
             if (confirmed == true) {
                 $.ajax({
                     type: "POST",
                     url: admin_ajaxurl,
                     data: {id: id, action: action},
                     cache: false,
                     dataType: "json",
                     success: function (data) {
                         $loading.hide();

                         if (data.success) {
                             $(row).remove();
                             showUpdate(update_message);
                         }
                     }
                 });
             }

             return false;
         });

         // accordion
         $('#blope-accordion').accordion({
             header: "h3"
         });

         $( ".tooltip-star" ).tooltipster({
             animation: 'fade',
             delay: 200,
             maxWidth: 228,
             side: ['right'],
             theme: 'tooltipster-punk',
             trigger: 'hover'
         });

	 });


     /**
     * When the window is loaded:
     *
     **/
    $( window ).load(function() {

    });

})( jQuery );
