(function($){

    // получение гет параметров из урл
    function newUrl(c,d){for(var a={},e=location.search.substring(1),f=/([^&=]+)=([^&]*)/g,b;b=f.exec(e);)a[decodeURIComponent(b[1])]=decodeURIComponent(b[2]);a[c]=d;history.pushState(null,null,location.pathname+"?"+$.param(a))};
   /**
    function newUrl( param, value ) {
        var queryParameters = {}, queryString = location.search.substring(1), re = /([^&=]+)=([^&]*)/g, m;
        while (m = re.exec(queryString)) {
            queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
        }
        queryParameters[ param ] = value;
        //location.search = $.param(queryParameters);
        history.pushState(null, null, location.pathname + '?' + $.param(queryParameters));
    }
    */
    //расстановкеа классов
    function OddEven(){$(".serch-item2").removeClass("even");$(".serch-item2").removeClass("odd");$(".serch-item2:even").addClass("even");$(".serch-item2:odd").addClass("odd")};

    $(document).on('change','select',function(){
        $(this).next().find('.jq-selectbox__select-text').removeClass('eror');
    });

    $('[name*=specialization]').change(function(){
        $('.rl-spetsializ ul').removeClass('eror');
    });

    $('.reg4-line .rl-col1 input').change(function() {
        $('.reg4-line .rl-col1').removeClass('eror');
    });

    $('[name=location_lesson]').change(function() {
        $(this).parents('.r-plase').removeClass('eror');
    });

    $(document).ready(function(){
        OddEven();
    });

    function mapSize(){
        if(!$('#YMapsID').length)
            return false;

        $('#YMapsID').css({
            'height' : $(window).height() - $('.map-header').height(),
            'width' :'100%'
        })
    }

    mapSize();
    $(document).resize(function(){
        mapSize();
    });


    var $offset = 2, $start = true,$end=false;



    /**
     * Удаление класса ошибка
     */
    $(document).on('focus','.eror',function(){
        $(this).removeClass('eror');
    });

    function shake(div){
        var interval = 100;
        var distance = 10;
        var times = 4;
        $(div).css('position','relative');

        for(var iter=0;iter<(times+1);iter++){
            $(div).animate({
                left:((iter%2==0 ? distance : distance*-1))
            },interval);
        }
        $(div).animate({ left: 0},interval);
    }

    /**
     * Форма регистрации шаг первый
     */
    $(document).ready(function(){
        $(document).on('click','#send-step-1',function(e){
            e.preventDefault();

            if( ! $('input#i_accsept').parent().hasClass('checked') ){
                $('.jq-checkbox').css('background-color','red');
                shake('.rf-chekbox');
                setTimeout(function(){
                    $('.jq-checkbox').css('background-color','transparent');
                },500);
                return false;
            }

            $('#main-loader').fadeIn();

            var $data = {
                action: 'step_one_register_form',
                security : CrAjAX.security,
                content: $('form#info-step-1').serialize(),
                img : $('#container_image').find('img').attr('src')
            };

            $.post(CrAjAX.ajaxurl, $data, function($response) {
                if( $response.success )
                {
                    window.location = $response.data.url;
                }
                else
                {
                    $.each($response.data, function(index, value){
                        $('#' + value).addClass('eror');
                        $('#' + value).after('<div class="input-eror">Это поле обязательно для заполнения</div>');
                    });

                    setTimeout(function(){
                        $('.input-eror').remove();
                    },2000);
                }
                $('#main-loader').fadeOut();
            });

        });


    });

    /**
     * Добавить опыт работы
     */
    $(document).on('click','#work-location-list',function(e){
        e.preventDefault();
        $appender = $("#work-clonner").clone().appendTo("#work-appender");
    });

    /**
     * Добавить образование
     */
    $(document).on('click','#add-experirnse',function(e){
        e.preventDefault();
        $("#text-clonner").clone().appendTo(".rl-obrazovanue");
    });


    /**
     * Отправка формы
     */
    $('#register-step-2').submit(function(e){
        e.preventDefault();

        $('#main-loader').fadeIn();
        var $data = {
            action: 'step_two_register_form',
            security : CrAjAX.security,
            content: $(this).serialize(),
            prise : $('#contentSlider2').html()
        };

        $.post(CrAjAX.ajaxurl, $data, function($response) {
            //console.log($response);
            if( $response.success )
            {
                $('#dialoga,.mack').fadeIn();
            }
            else
            {
                console.log('Ошибка' + $response.data);

                $.each($response.data, function(index, value) {
                    $('[name*=' + value + ']').addClass('eror');

                    if (value == 'companys') {
                        $('#work-clonner').find('input').each(function () {
                            if ($(this).val() == '') $(this).addClass('eror');
                        });

                    }
                    if (value == 'status') {
                        $('select[name="status"]').next().find('.jq-selectbox__select-text').addClass('eror');
                    }

                    if (value == 'specialization') {
                        $('.rl-spetsializ').find('ul').addClass('eror');
                    }

                    if (value == 'category_student') {
                        $('.reg4-line').find('.rl-col1').addClass('eror');
                    }

                    if (value == 'location_lesson') {
                        $('[name=location_lesson]').parents('.r-plase').addClass('eror');
                    }

                    if ($('[name=' + value + ']').length) {

                        $('[name*=' + value + ']').after('<div class="input-eror">Это поле обязательно для заполнения</div>');
                    }
                });

                setTimeout(function(){
                    $('.input-eror').remove();
                },2000);
            }

            $('#main-loader').fadeOut();
        });

    });



    /**
     * Поиск по карте
     */
    $(document).on('click','#search-mapper',function(e){
        e.preventDefault();
        $('#main-loader').fadeIn();
        var $val = $('#compliter').val();
        if($val=='')
            return false;

        var $data = {
            action: 'map_searcher',
            security : CrAjAX.security,
            val: $val
        };
        $.post(CrAjAX.ajaxurl, $data, function($response) {
            $('#YMapsID').empty();
            setTimeout(function(){
                ymaps.ready().done(function (ym) {
                    var myMape = new ym.Map('YMapsID', {
                        center: [55.751574, 37.573856],
                        zoom: 10,
                        controls: ['zoomControl', 'fullscreenControl']
                    }, {
                        searchControlProvider: 'yandex#search'
                    });

                    var geoObjects = ym.geoQuery($response)
                        .addToMap(myMape)
                        .applyBoundsToMap(myMape, {
                            checkZoomRange: true
                        });
                });
                $('#main-loader').fadeOut();
            },250);
        });
    });


    /**
     * Подбор репертитора
     */
    $(document).on('change','#lefter-search> *',function(){
        $el = $(this).attr('class');
        if($el == 'filtr-select' ){
            $name = $(this).find('select').attr('name');
            $val = $(this).find('select').val();
        } else {
            $name = $(this).find('input:checked').attr('name');
            $val = $(this).find('input:checked').val();
        }
        newUrl( $name, $val );
        $('#main-loader').fadeIn();
        var $data = {
            action: 'left_search',
            security : CrAjAX.security,
            get: decodeURIComponent(window.location.search.substring(1))
        };
        $.post(CrAjAX.ajaxurl, $data, function($response) {
            $('#appener').html($response);
            OddEven();
            $('.odd').after('<div class="clearfix"></div>');
            $('#main-loader').fadeOut();
            $offset = 2;
        });
    });




    /**
     * Подбор заявки
     */
    $(document).on('change','#lefter-search-order  > *',function(){

        $el = $(this).attr('class');
        if($el == 'filtr-select' ){
            $name = $(this).find('select').attr('name');
            $val = $(this).find('select').val();
        } else {
            $name = $(this).find('input:checked').attr('name');
            $val = $(this).find('input:checked').val();
        }
        newUrl( $name, $val );
        $('#main-loader').fadeIn();
        var $data = {
            action: 'left_search_order',
            security : CrAjAX.security,
            val: $('#lefter-search-order').serialize()
        };

        $.post(CrAjAX.ajaxurl, $data, function($response) {
            $('.order-right').html($response);
            $('#main-loader').fadeOut();
        });
    });

    /**
     * Отправка быстрой быстрой формы звонка
     */
    $('form#fast-fast-search').submit(function(e){
        e.preventDefault();
        var $phone = $('form#fast-fast-search #phone').val();
        if($phone =='' ) return false;
        $('#main-loader').fadeIn();

        var $data = {
            action: 'fast_fast_send',
            security : CrAjAX.security,
            val: $phone
        };

        $.post(CrAjAX.ajaxurl, $data, function($response) {
            $('form input[type="text"], form input[type="password"], form textarea').val('');
            $('#dialog1').html($response).fadeIn();
            $('.mack').fadeIn();
            $('#main-loader').fadeOut();
        });

    });

    /**
     * Отправка быстрой формы
     */
    $('#fast-form-submit').click(function(e){
        e.preventDefault();
        var $phone = $(this).parent('#fast-form').find('#fast-phone').val(),
            $name = $(this).parent('#fast-form').find('#fast-name').val();

        if( $phone === '' )  {
            $('#fast-phone').addClass('eror');
            return false;
        }

        if( $name === '')  {
            $('#fast-name').addClass('eror');
            return false;
        }

        if( $name === 'undefined')  {
            $('#fast-name').addClass('eror');
            return false;
        }

        $('#main-loader').fadeIn();

        var $data = {
            action: 'fast_send',
            security : CrAjAX.security,
            phone: $phone,
            name: $name
        };

        $.post(CrAjAX.ajaxurl, $data, function($response) {
            $('form input[type="text"], form input[type="password"], form textarea').val('');
            $('#dialog1').html($response).fadeIn();
            $('.mack').fadeIn();
            $('#main-loader').fadeOut();
        });


    });

    /**
     * Отправка нормальной формы
     */
    $('.normal-submit').click(function(e) {
        e.preventDefault();

        var $phone = $(this).parents('#normal-form').find('#normal-form-phone').val(),
            $name = $(this).parents('#normal-form').find('#normal-form-name').val(),
            $text = $(this).parents('#normal-form').find('#normal-form-text').val();

        if ($phone === '') {
            $('#normal-form-phone').addClass('eror');
            return false;
        }

        if ($name === '') {
            $('#normal-form-name').addClass('eror');
            return false;
        }

        if ($name === 'undefined') {
            $('#normal-form-name').addClass('eror');
            return false;
        }


        $('#main-loader').fadeIn();

        var $data = {
            action: 'normal_send',
            security: CrAjAX.security,
            phone: $phone,
            name: $name,
            text : $text
        };

        $.post(CrAjAX.ajaxurl, $data, function ($response) {
            $('form input[type="text"], form input[type="password"], form textarea').val('');
            $('#dialog1').html($response).fadeIn();
            $('.mack').fadeIn();
            $('#main-loader').fadeOut();
            $('form input[type="text"], form input[type="password"], form textarea').val('');
        });
    });


    /**
     * Закервтие 1
     */
    $(document).on('click','#dialog1 .close',function(e){
        e.preventDefault();
        $('#dialog1').fadeOut().html('');
        $('.mack').fadeOut();
    });


    /**
     * Учителя
     */
    $(document).on('click','.send-ticher',function(e){
        e.preventDefault();
        if($('body.archive').length || $('body.page-template-page-archive').length ){
            $name =  $(this).parents('.search-item').find('.sb-name').html();
            $prof =  $(this).parents('.search-item').find('.sd-info1-work').html();
            $url = $(this).parents('.search-item').find('.sb-img img').attr('src');
            $id = $(this).parents('.search-item').data('id');
        } else{
            $name = $('.teacher-name').html();
            $prof =  $('.sd-info1-work').html();
            $url = $('.t-avatar-block').find('img').attr('src');
            $id = $('.fogr').data('id');
        }

        if( $('body.page-template-map-page').length ) {
            $name = $(this).parents('.point-hover').find('.point-name').html();
            $prof = $(this).parents('.point-hover').find('.prof').html();
            $url = $(this).parents('.point-hover').find('img.wp-post-image').attr('src');
            $id = $(this).parents('.point-hover').data('id');
        }

        $('#dialog3').find('.myamazingperfectform-title').html($name);
        $('#dialog3').find('.sd-info1-work').html($prof);
        $('#dialog3').find('.popup-teacher-foto').find('img').attr('src',$url);
        $('#dialog3').find('.idd').val($id)



        $('#dialog3').fadeIn();
        $('.mack').fadeIn();
    });

    /**
     * Учителя
     */
    $(document).on('click','.go-terach',function(e){
        e.preventDefault();

        $name =  $(this).parents('.serch-item2').find('.sb-name').html();
        $prof =  $(this).parents('.serch-item2').find('.sd-info1-work').html();
        $url = $(this).parents('.serch-item2').find('.sb-img img').attr('src');
        $id = $(this).parents('.serch-item2').data('id');


        $('#dialog3').find('.myamazingperfectform-title').html($name);
        $('#dialog3').find('.sd-info1-work').html($prof);
        $('#dialog3').find('.popup-teacher-foto').find('img').attr('src',$url);
        $('#dialog3').find('.idd').val($id)



        $('#dialog3').fadeIn();
        $('.mack').fadeIn();
    });

    /**
     * Закервтие 3
     */

    $(document).on('click','.closer',function(e){
        e.preventDefault();
        $('#dialog3').fadeOut();
        $('.mack').fadeOut();
    });

    /**
     * Отправка связаться с учителем
     */

    $('#dialog3 .green-button').click(function(e) {
        e.preventDefault();

        var $phone = $(this).parents('#send-teacher').find('#send-teacher-phone').val(),
            $name = $(this).parents('#send-teacher').find('#send-teacher-name').val(),
            $text = $(this).parents('#send-teacher').find('.idd').val();

        if ($phone === '') {
            $('#send-form-phone').addClass('eror');
            return false;
        }

        if ($name === '') {
            $('#send-form-name').addClass('eror');
            return false;
        }

        if ($name === 'undefined') {
            $('#send-form-name').addClass('eror');
            return false;
        }


        $('#main-loader').fadeIn();

        var $data = {
            action: 'tach_send',
            security: CrAjAX.security,
            phone: $phone,
            name: $name,
            text : $text
        };

        $.post(CrAjAX.ajaxurl, $data, function ($response) {
            $('form input[type="text"], form input[type="password"], form textarea').val('');
            $('#dialog1').html($response).fadeIn();
            $('#dialog3').fadeOut();
            $('.mack').fadeIn();
            $('#main-loader').fadeOut();
        });
    });

    /**
     * Bpvtybnm fyrtne
     */

    $('.change-info').click(function(e){
        e.preventDefault();
        $('#dialog').fadeIn();
        $('.mack').fadeIn();
    });


    $('#ggg-ggg').click(function(e) {
        e.preventDefault();

        var $phone = $(this).parents('#form-change').find('#phone-ch').val(),
            $name = $(this).parents('#form-change').find('#name-ch').val(),
            $text = $(this).parents('#form-change').find('#text-ch').val();
        //$img = $(this).parents('#dialog').find('.picture-element-image').attr('src');

        if ($phone === '') {
            $('#phone-ch').addClass('eror');
            return false;
        }

        if ($name === '') {
            $('#name-ch').addClass('eror');
            return false;
        }

        if ($name === 'undefined') {
            $('#name-ch').addClass('eror');
            return false;
        }

        if ($text === '') {
            $('#text-ch').addClass('eror');
            return false;
        }


        $('#main-loader').fadeIn();
        var form = document.getElementById('form-change');
        formData = new FormData(form);
        formData.append('action', 'tach_chan');
        formData.append('phone', $phone);
        formData.append('name', $name);
        formData.append(' text',  $text);
        $.ajax({
            url: CrAjAX.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('form input[type="text"], form input[type="password"], form textarea').val('');
                $('#dialog1').html(response).fadeIn();
                $('#dialog').fadeOut();
                $('.mack').fadeIn();
                $('#main-loader').fadeOut();
            }
        });

    });


    /**
     * Прокруитька отзывов
     */




    $(window).scroll(function() {

        if( $('#flag').length ) {
            $flag = $('#flag').data('flag');
        }  else {
            $flag = '';
        }

        if( ! $('body.page-template-page-revews').length ) return false;
        // Проверяем пользователя, находится ли он в нижней части страницы
        if(( $(window).scrollTop() == $(document).height() - $(window).height() )  && $start == true && $end == false ) {

            // Идет процесс
            $start = false;

            // Сообщить пользователю что идет загрузка данных
            $('.rev-container').append('<div id="post-load"></div>');

            // Запустить функцию для выборки данных с установленной задержкой
            // Это полезно, если у вас есть контент в футере



            setTimeout(function() {
                getData($offset,$flag,'.rev-container','scroll_comments');
                $offset ++;
                $start = true;
            }, 1000);




        }
    });


// Функция AJAX запроса
    function getData($offset,$contayner,$action,$val,$cat) {

        $val = $val || 0;
        $cat = $cat || '';
        var $data = {
            security: CrAjAX.security,
            action   : $action,
            offset   : $offset,
            flag     : $flag,
            get : $val,
            cat : $cat
        };
        $.post(CrAjAX.ajaxurl, $data, function ($response) {

            if(!$response.length) {
                //$end = true;
            } else {
                $($contayner).append($response);
                OddEven();
                setTimeout(function() {
                    $('.resp'). fadeIn();
                }, 250);
            }

        });

    }

//фильтр отзывов
    $('#resal').change(function(){
        var loc = window.location;
        window.location = loc.protocol + '//' + loc.host + loc.pathname + '?id=' + $(this).val();
    });


    /**
     * Прокрутка архива репетиторов
     */
    var $offset = 2, $start = true,$end=false;
    $(window).scroll(function() {
        //if(!$('.serch-item2').length || !$('.serch-item2').length) return false;

        if( $('#flag').length ) {
            $flag = $('#flag').data('flag');
        }  else {
            $flag = '';
        }

        if( ! $('body.category').length && ! $('body.archive').length ) return false;
        if(( $(window).scrollTop() == $(document).height() - $(window).height() )  && $start == true && $end == false  ) {

            $start = false;
            $('#appener').append('<div id="post-load"></div>')
            $('#post-load').fadeIn();

            setTimeout(function() {
                $get = window.location.search;
                $cat = $('.sort-block').data('catter');
                $('#post-load').remove();
                getData($offset,'#appener','scroll_techers',$get,$cat);
                $offset ++;
                OddEven();
            }, 1000);

            setTimeout(function() {
                $start = true;
            }, 3000);

        }
    });



    /**
     * Пpокрутка страниы подбор репетиторов
     */
    $(window).scroll(function() {

        if( $('#flag').length ) {
            $flag = $('#flag').data('flag');
        }  else {
            $flag = '';
        }

        if( ! $('body.page-template-page-archive').length ) return false;
        if(( $(window).scrollTop() == $(document).height() - $(window).height() )  && $start == true && $end == false  ) {
            $start = false;
            $('#appener').append('<div id="post-load"></div>');
            $('#post-load').fadeIn();
            setTimeout(function() {
                $get = decodeURIComponent(window.location.search.substring(1));
                $('#post-load').remove();
                getData($offset,'#appener','scroll_techers',$get);
                $offset ++;
            }, 1000);

            setTimeout(function() {
                $start = true;
            }, 3000);

        }
    });


    /**
     * Сортировка записей ро цене
     */

    $(document).on('click','.sort-left a', function(){

        $('#main-loader').fadeIn();
        newUrl( 'orders', $(this).data('sort') );
        var $data = {
            security: CrAjAX.security,
            action   : 'order_by_prise',
            'get' : decodeURIComponent(window.location.search.substring(1))

        };

        $.post(CrAjAX.ajaxurl, $data, function ($response) {
            $('#appener').html($response);
            OddEven();
            $('#main-loader').fadeOut();
            setTimeout(function() {
                $('.resp'). fadeIn();
                OddEven()
            }, 250);
        });

    });

    /**
     * Переключение вида
     */
    $(document).on('click','.sort-right a',function () {
        $('#main-loader').fadeIn();
        newUrl( 'show', $(this).data('show') );

        var $data = {
            security: CrAjAX.security,
            action   : 'order_by_show',
            'get' : decodeURIComponent(window.location.search.substring(1))

        };

        $.post(CrAjAX.ajaxurl, $data, function ($response) {

            setTimeout(function() {
                $('#appener').html($response);
                OddEven();
               // $('.resp'). fadeIn();
                $('#main-loader').fadeOut();
            }, 250);
        });
    });

    /**
     * Переход из архива на поиск
     */
    $(document).on('change','#lefter-search-archive> *',function(){
        var $get = $('#lefter-search-archive').serialize();
        var loc = window.location;
        window.location.href = loc.protocol + '//' + loc.host + '/podbor-repetitora?' + $get;
    });

    /**
     * Боковой сайдбар
     */

    var menuHeight = $("#fixer").height();
    var tops = $("#fixer").offset();
    var width = $(".search-filtr").width();
    var topss = tops.top

    function fixerStop(){
        var top  = $(document).scrollTop();

        if ( top > topss) {
            $('#fixer').css({'position':'fixed','top':50,'width':width+51,'opacity':1});
            return false;
        }else {
            $('#fixer').css({'position':'relative','top':0});
            //$('.fase').animate({ 'height' : logoHeight , 'margin-top': '20px' },{queue:false, duragon : 150});
            return false;
        }
    }

    $(document).scroll( function(){
        fixerStop();
    } );

    fixerStop();

})(jQuery);
