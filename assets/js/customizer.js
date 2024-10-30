// ########### BUTTON PAGE ##########

(function ($) {
    'use strict';

    var CustomizeButton = {
        options: {
            container: '#blope-attributes', // container ID
            preiew: '#blope-preview', // iframe ID
            loading: '#blope-preview-loading', // iframe ID
            title: 'Donate',
            style: 'basic',
            animate: 'fade',
            params: {},
            callback: function(params) {

            }
        },

        init: function () {
            if(this.options.container == '' || $(this.options.container).length <= 0)
                return;

            this.bindEvent();
            this.customBind();

            //button style select box modifier
            var _this = this;
            var inputname = $('#blope_btn_style').attr('name');
            var styleDefault = $('#blope_btn_style').val();

            $('#blope_btn_style').ddslick({
                width: 202,
                background: '#ffffff',
                showSelectedHTML: false,
                onSelected: function(data){
                    $('#blope_style_input').val(data.selectedData.value);
                    var opt = {
                        id: $('input[name=button_id]').val(),
                        title: $(_this.options.container).find('#blope_btn_title').val(),
                        desc: $(_this.options.container).find('#blope_btn_desc').val(),
                        style: data.selectedData.value,
                        animate: $(_this.options.container).find('#blope_btn_animate').val(),
                        amount: $(_this.options.container).find('#blope_btn_amount').val() * 100,
                        flexible: $(_this.options.container).find('input[name=button_custom_amount]:checked').val(),
                    };
                    _this.loadPreview(opt);
                }
            });

            $('#blope_btn_style').append('<input id="blope_style_input" type="hidden" name="'+inputname+'" value="'+styleDefault+'" >');
        },

        bindEvent: function() {
            var _this = this;
            // first load
            $(_this.options.container).find('#blope_btn_title, #blope_btn_style, #blope_btn_animate, #blope_btn_amount, #blope_btn_desc, #blope_style_input').each(function (e) {
                _this.updatePreview(this);
            });

            // bind event
            $(_this.options.container).find('#blope_btn_title, #blope_btn_style, #blope_btn_animate, #blope_btn_amount, #blope_btn_desc, #blope_style_input').on({
                change: function (e) {
                    _this.updatePreview(this);
                },
                paste: function (e) {
                    setTimeout(function () {
                        _this.updatePreview(this);
                    }, 50);
                },
                keyup: function (e) {
                    if(_this.isHtml(this.value)){
                        this.value = this.value.replace(/<(?:.|\n)*?>/gm, '');
                    }
                    _this.updatePreview(this);
                    // _this.limitchars(e, this);
                },
                focus: function (e) {

                },
                blur: function (e) {
                    //_this.updatePreview(this);
                }
            });

        },
        customBind: function () {
            var _this = this;
            if($('#specific_amount').is(":checked")) {
                $('#blope_btn_amount').prop('disabled', false);
                $(_this.options.preiew).find('.blope-donation-btn').removeClass('blope-donation-flexible');
            }
            $('#specific_amount').bind('click', function () {
                $('#blope_btn_amount').prop('disabled', false);
                $(_this.options.preiew).find('.blope-donation-btn').removeClass('blope-donation-flexible');
            });
            if($('#custom_amount').is(":checked")) {
                $('#blope_btn_amount').prop('disabled', true);
                $(_this.options.preiew).find('.blope-donation-btn').addClass('blope-donation-flexible');
            }
            $('#custom_amount').bind('click', function () {
                $('#blope_btn_amount').prop('disabled', true);
                $(_this.options.preiew).find('.blope-donation-btn').addClass('blope-donation-flexible');
            });
        },
        updatePreview: function (obj) {
            var _this = this;
            var previewContent =  $(_this.options.preiew);
            var id = $(obj).attr('id');
            var classObj = id.replace(new RegExp('_', 'g'), '-');

            switch(id) {
                case 'blope_btn_title':
                    var text = $(obj).val();
                    previewContent.find('.' + classObj).text(text);
                    break;
                case 'blope_btn_desc':
                    var text = $(obj).val();
                    var str = '';
                    if (text.indexOf('\n') > 0) {
                        var sbj = text.split("\n");
                        for (var key in sbj)
                        {
                            str += sbj[key] + '<br />';
                        }
                    } else {
                        str = text;
                    }
                    previewContent.find('.' + classObj).html(str);
                    break;
                case 'blope_btn_amount':
                    previewContent.find('.' + classObj).text($(obj).val());
                    break;
                case 'blope_btn_style':
                    var opt = {
                        id: $('input[name=button_id]').val(),
                        title: $(_this.options.container).find('#blope_btn_title').val(),
                        desc: $(_this.options.container).find('#blope_btn_desc').val(),
                        style: $(obj).val(),
                        animate: $(_this.options.container).find('#blope_btn_animate').val(),
                        amount: ($(_this.options.container).find('#blope_btn_amount').val() * 100),
                        flexible: $(_this.options.container).find('input[name=button_custom_amount]:checked').val(),
                    };
                    _this.loadPreview(opt);
                    break;
                case 'blope_btn_animate':
                    var elm = '.' + classObj;
                    var animateName = $(obj).val();
                    _this.addAnimate(elm, animateName);
                    break;
                default:
                    break;
            }

        },
        loadPreview: function(opt) {
            var _this = this;
            var opt = opt || {};
            var _data = {
                action: 'blope_load_style_button',
                id: '0',
                title: 'Donate',
                desc: 'Make A Difference',
                style: 'basic',
                animate: 'flash',
                amount: 10,
                flexible: 0,
                security: xblope_security
            };

            // merge data
            $.extend(_data, opt);

            $.ajax({
                type: "POST",
                url: admin_ajaxurl,
                data: _data,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $(_this.options.loading).show();
                },
                success: function (data) {
                    $(_this.options.loading).hide();
                    if(data.success) {
                        $(_this.options.preiew).find('#blope-preview-button').html(data.html);
                        var animationName = $('#blope_btn_animate').val();
                        _this.addAnimate('.blope-btn-animate', animationName);
                    }

                }
            });

        },
        // Make animate.css work with plugin
        addAnimate: function (elm, animationName) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            $(elm).addClass('animated ' + animationName).one(animationEnd, function() {
                $(this).removeClass('animated ' + animationName);
            });
        },

        limitchars: function(e, obj) {
            if (e) {
                var keycode = (e.keyCode ? e.keyCode : e.which);
                if(keycode == 9) return false; // tab key
            }
            var limit = $(obj).data('maxlength'),
                countdown = $(obj).prev().find('.countdown');

            var classObj = $(obj).attr('class');
            // check characters left
            if (limit && countdown.length) {
                var start   = obj.selectionStart;
                var end     = obj.selectionEnd;
                var chars_left = limit - this.getObjectLength(obj);
                if (chars_left < 0) {
                    $(obj).val($(obj).val().substring(0, limit));
                    chars_left = 0;
                    if (start == end) {
                        obj.setSelectionRange(start, end);
                    }
                }

                this.updateElement(obj);
                $(obj).prev().find('.countdown').text(chars_left);
            }
        },

        getObjectLength: function(obj) {
            // check on Chrome browser
            if (navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {
                var line = $(obj).val().replace(/(\r\n|\n|\r)/g, "\n").split('\n');
                var len = $(obj).val().length + line.length - 1;
                return len;
            }

            // other browsers: ie, firefox, safari...
            return $(obj).val().length;
        },
        isHtml: function (str) {
            var a = document.createElement('div');
            a.innerHTML = str;
            for (var c = a.childNodes, i = c.length; i--; ) {
                if (c[i].nodeType == 1) return true;
            }
            return false;
        },
        validateURL: function (obj) {
            var url = $(obj).val(), type = $(obj).data('type');

            if(type !== 'href' || !url)
                return true;

            if(url.toString().indexOf('http://') < 0 && url.toString().indexOf('https://') < 0) {
                url = 'http://' + url;
                $(obj).val(url);
            }

            //regular expression for URL
            var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;

            if(pattern.test(url)){
                $(obj).removeClass('invalid');
                return true;
            } else {
                $(obj).addClass('invalid');
                return false;
            }
        },
        validate: function() {
            var _this = this, valid = false;

            $(_this.options.container).find('input, textarea').each(function(){
                var val = $(this).val(),
                    type = $(this).data('type'),
                    limit = $(this).data('maxlength'),
                    len = _this.getObjectLength(this);
                switch(type) {
                    case 'text':
                        if(len > 0 && len <= parseInt(limit,10)) {
                            $(this).removeClass('invalid');
                            return valid = true;
                        } else {
                            $(this).addClass('invalid');
                            $(this).closest('.accordion-content').prev().trigger('click');
                            $(this).focus();
                            return valid = false;
                        }
                        break;
                    case 'href':
                        valid = _this.validateURL(this);
                        if(!valid) {
                            $(this).closest('.accordion-content').prev().trigger('click');
                            $(this).focus();
                        }
                        return valid;
                        break;
                    default:
                        break;
                }

            });

            return valid;
        },

    }
    $(function () {

        CustomizeButton.init();

    });
})(jQuery);

