(function($) {
    $(document).ready(function () {

        //Меню
        $('a[href^=#]').click(function (ev) {
            var target = $(this).attr('href');

            if ($(target).length) {
                ev.preventDefault();
                $('html, body').animate({scrollTop: $(target).offset().top - 5}, 1000, function () {
                    window.history.pushState({}, '', target);
                });
            }
        });

        //Для кроссбраузернго placeholder
        $(function () {
            $('input[placeholder], textarea[placeholder]').placeholder();
        });

        /* PIE для IE7-8 */
        if (window.PIE) {
            $('nav').each(function () {
                PIE.attach(this);
            });
        }

        $('.prise-up').click(function () {
            $(this).parent().addClass('priceup');
        });
        $('.prise-dowbn').click(function () {
            $(this).parent().removeClass('priceup');
        });


    });//end ready

    if (parseInt($(window).width()) > 500) {
        new WOW().init();
    }
    ;


//Plugin placeholder
    (function (b) {
        function d(a) {
            this.input = a;
            a.attr("type") == "password" && this.handlePassword();
            b(a[0].form).submit(function () {
                if (a.hasClass("placeholder") && a[0].value == a.attr("placeholder"))a[0].value = ""
            })
        }

        d.prototype = {
            show: function (a) {
                if (this.input[0].value === "" || a && this.valueIsPlaceholder()) {
                    if (this.isPassword)try {
                        this.input[0].setAttribute("type", "text")
                    } catch (b) {
                        this.input.before(this.fakePassword.show()).hide()
                    }
                    this.input.addClass("placeholder");
                    this.input[0].value = this.input.attr("placeholder")
                }
            },
            hide: function () {
                if (this.valueIsPlaceholder() && this.input.hasClass("placeholder") && (this.input.removeClass("placeholder"), this.input[0].value = "", this.isPassword)) {
                    try {
                        this.input[0].setAttribute("type", "password")
                    } catch (a) {
                    }
                    this.input.show();
                    this.input[0].focus()
                }
            }, valueIsPlaceholder: function () {
                return this.input[0].value == this.input.attr("placeholder")
            }, handlePassword: function () {
                var a = this.input;
                a.attr("realType", "password");
                this.isPassword = !0;
                if (b.browser.msie && a[0].outerHTML) {
                    var c = b(a[0].outerHTML.replace(/type=(['"])?password\1/gi,
                        "type=$1text$1"));
                    this.fakePassword = c.val(a.attr("placeholder")).addClass("placeholder").focus(function () {
                        a.trigger("focus");
                        b(this).hide()
                    });
                    b(a[0].form).submit(function () {
                        c.remove();
                        a.show()
                    })
                }
            }
        };
        var e = !!("placeholder"in document.createElement("input"));
        b.fn.placeholder = function () {
            return e ? this : this.each(function () {
                var a = b(this), c = new d(a);
                c.show(!0);
                a.focus(function () {
                    c.hide()
                });
                a.blur(function () {
                    c.show(!1)
                });
                b.browser.msie && (b(window).load(function () {
                    a.val() && a.removeClass("placeholder");
                    c.show(!0)
                }),
                    a.focus(function () {
                        if (this.value == "") {
                            var a = this.createTextRange();
                            a.collapse(!0);
                            a.moveStart("character", 0);
                            a.select()
                        }
                    }))
            })
        }
    })(jQuery);


    $(document).ready(function () {
        $(function () {

            function wscroll() {
                var scrollDiv = $("#toTop");
                if ($(window).scrollTop() < 1000) {
                    $(scrollDiv).fadeOut("slow")
                } else {
                    $(scrollDiv).fadeIn("slow")
                }
            }

            $(window).scroll(wscroll);
            wscroll();

            $("#toTop").click(function () {
                $("html, body").animate({scrollTop: 0}, "slow")
                return false;
            })
        });
    });//end ready


    $(document).ready(function () {

        //select all the a tag with name equal to modal
        $('a[name=modal]').click(function (e) {
            //Cancel the link behavior
            e.preventDefault();

            //Get the A tag
            var id = $(this).attr('href');

            //Get the screen height and width
            var maskHeight = $(document).height();
            var maskWidth = $(window).width();

            //Set heigth and width to mask to fill up the whole screen
            $('#mask').css({'width': maskWidth, 'height': maskHeight});

            //transition effect
            $('#mask').fadeTo("slow", 0.7);

            //Get the window height and width
            var winH = $(window).height();
            var winW = $(window).width();


            if ($(this).hasClass('modal-absolute')) {
                $(id).css('top', $(window).scrollTop() + 20);
                $(id).css('position', 'absolute');
            } else {

                //Set the popup window to center
                $(id).css('top', winH / 2 - $(id).outerHeight() / 2);
                $(id).css('position', 'fixed');
            }

            $(id).css('left', winW / 2 - $(id).outerWidth() / 2);


            //transition effect
            $(id).fadeIn(500);

        });

        //if close button is clicked
        $('.window .close').click(function (e) {
            //Cancel the link behavior
            e.preventDefault();

            $('#mask').hide();
            $('.window').hide();
        });

        //if mask is clicked
        $('#mask').click(function () {
            $(this).hide();
            $('.window').hide();
        });

        $(window).resize(function () {

            var box = $('#boxes .window');

            //Get the screen height and width
            var maskHeight = $(document).height();
            var maskWidth = $(window).width();

            //Set height and width to mask to fill up the whole screen
            $('#mask').css({'width': maskWidth, 'height': maskHeight});

            //Get the window height and width
            var winH = $(window).height();
            var winW = $(window).width();

            //Set the popup window to center
            box.css('top', winH / 2 - box.height() / 2);
            box.css('left', winW / 2 - box.width() / 2);

        });

    });

    $(document).ready(function () {

        if ($("#slider").is("#slider")) {
            $("#slider").slider({
                value: 0,
                min: 0,
                max: 10,
                step: 0.1,
                create: function (event, ui) {
                    val = $("#slider").slider("value");
                    $("#contentSlider").html(val);
                },
                slide: function (event, ui) {
                    $("#contentSlider").html(ui.value);
                    $('input#rating').val(ui.value);
                }
            });
        }
        ;

    });
    $(document).ready(function () {
        if ($("#slider2").is("#slider2")) {
            $("#slider2").slider({
                value: 0,
                min: 0,
                max: 1000,
                step: 10,
                create: function (event, ui) {
                    val = $("#slider").slider("value");
                    $("#contentSlider2").html("0");
                },
                slide: function (event, ui) {
                    $("#contentSlider2").html(ui.value);

                }
            });
        }
        ;
    });





    $(document).ready(function () {
        $('.serch-read-more').click(function () {
            $('.search-rmblock').css('display', 'block');
            $('.serch-read-more').css('display', 'none');
        });
    })


    $(document).ready(function () {
        $('.all-otzuv').click(function () {
            if ($('.odzuv-hide').css('display') == 'block') {
                $(this).text("Все отзывы");
                $('.odzuv-hide').hide("slow");
                $('html, body').animate({scrollTop: $('.teacher .teacher-name').offset().top}, 1000);
            } else {
                $(this).text("Свернуть");
                $('.odzuv-hide').show("slow");

            }
        });


    });

    $(document).ready(function () {
        $('.about-more').click(function(){
            if($('.about-hidden').css('display') == 'block'){
                $(this).text("Читать далее");
                $(this).css('background-image','url(img/arrow-down.png)');
                $('.about-hidden').hide("slow");

            }else{
                $(this).text("Свернуть");
                $(this).css('background-image','url(img/arrow-up.png)');
                $('.about-hidden').show("slow");
            }
        });

    });

    /**
     * Активация аватарки
     */

    /* $(function() {
     $('#thebox').picEdit({maxWidth: 110,maxHeight:128});
     });*/

    $("#container_image").PictureCut({
        InputOfImageDirectory       : "image",
        DefaultImageButton          : 'http://sadis5.ru/resources/themes/crrepetitor/assets/img/no-avatar.jpg',
        PluginFolderOnServer        : "/jquery.picture.cut/",
        FolderOnServer              : "/uploads/",
        EnableCrop                  : true,
        CropOrientation             : true,
        CropModes                   : {
            widescreen: false,
            letterbox: true,
            free   : false
        },
        ImageButtonCSS              :{
            border:"1px #CCC solid",
            'border-radius':"5px",
            width :110,
            height:128
        }
    });


    $("#SelectOrientacao [value='Vertical']").attr("selected", "selected");
})(jQuery);