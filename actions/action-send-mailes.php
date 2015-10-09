<?php
/**
 * Быстрая бвстрая форма
 */
add_action( 'wp_ajax_fast_fast_send', 'fast_fast_send_callback' );
add_action( 'wp_ajax_nopriv_fast_fast_send', 'fast_fast_send_callback' );

function fast_fast_send_callback() {
    global $panda;
    $ok = !empty($panda['ok_ok']) ? esc_url($panda['ok_ok']) : 'javascript:void(0);';
    $vk = !empty($panda['vk_vk']) ? esc_url($panda['vk_vk']) : 'javascript:void(0);';
    check_ajax_referer( 'cr-special-string', 'security' );
    $phone = $_POST['val'];
    $email = !empty($panda['e_mail']) ? $panda['e_mail'] : '';

    $defaults = array(
        'post_title'    => 'Заявка на подбор репетитора',
        'post_content'  => $phone,
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type' => 'send'
    );

    $post_id = wp_insert_post( $defaults );

    wp_mail( $email,'Заявка на подбор репетитора ' . get_home_url(), 'Вы получили новую заявку на подбор репетитора № ' . $post_id . ' Телефон клиента ' . $phone );
    $texte = "Садись, 5!: Ваша заявка №" . $post_id . " получена. Мы свяжемся с Вами. Наш тел: 412-413";
    sendSMS($phone,$texte);

    $date = date('G');
    if( $date > 21 && $date < 8 ) {
        $mess = '<br>Мы свяжемся с вами после 8:00 утра';
    } else{
        $mess ='';
    }
    echo '<a href="#" class="close"></a>
        <div class="litebox-top">Отлично!</div>
        <div class="popup-content">
            <div class="litebox-blod litebox-blod2">
                Ваша заявка № ' . $post_id . ' получена. Мы перезвоним,<br>
                уточним детали и бесплатно подберем <br>
                подходящего специалиста.
            </div>
            <div class="litebox-text">
                А пока подпишитесь на наши группы в социальных сетях,<br>
                чтобы узнавать новости из сферы образования и оставаться <br>
                в хорошем настроении!'.$mess . '
            </div>
            <div class="popup-sots">
                <a href="' . $vk . '" class="vk-link2">Вконтакте</a>
                <a href="' . $ok . '" class="odnoklasniki-link2">Одноклассники</a>
            </div>
        </div>';

    wp_die();
}

/**
 * Быстрая  форма
 */
add_action( 'wp_ajax_fast_send', 'fast_send_callback' );
add_action( 'wp_ajax_nopriv_fast_send', 'fast_send_callback' );

function fast_send_callback() {
    global $panda;
    $ok = !empty($panda['ok_ok']) ? esc_url($panda['ok_ok']) : 'javascript:void(0);';
    $vk = !empty($panda['vk_vk']) ? esc_url($panda['vk_vk']) : 'javascript:void(0);';
    check_ajax_referer( 'cr-special-string', 'security' );
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $email = !empty($panda['e_mail']) ? $panda['e_mail'] : '';

    $defaults = array(
        'post_title'    => 'Заявка на подбор репетитора',
        'post_content'  => $phone .'<br>'. $name,
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type' => 'send'
    );

    $post_id = wp_insert_post( $defaults );

    wp_mail( $email,'Заявка на подбор репетитора ' . get_home_url(), 'Вы получили новую заявку на подбор репетитора № ' . $post_id . ' Телефон клиента ' . $phone . ', Имя клиента, ' . $name );
    $texte = "Садись, 5!: Ваша заявка №" . $post_id . " получена. Мы свяжемся с Вами. Наш тел: 412-413";
    sendSMS($phone,$texte);

    $date = date('G');
    if( $date > 21 && $date < 8 ) {
        $mess = '<br>Мы свяжемся с вами после 8:00 утра';
    } else{
        $mess ='';
    }
    echo '<a href="#" class="close"></a>
        <div class="litebox-top">Отлично!</div>
        <div class="popup-content">
            <div class="litebox-blod litebox-blod2">
                ' . $name . ', ваша заявка № ' . $post_id . ' получена. Мы перезвоним,<br>
                уточним детали и бесплатно подберем <br>
                подходящего специалиста.'.$mess . '
            </div>
            <div class="litebox-text">
                А пока подпишитесь на наши группы в социальных сетях,<br>
                чтобы узнавать новости из сферы образования и оставаться <br>
                в хорошем настроении!
            </div>
            <div class="popup-sots">
                <a href="' . $vk . '" class="vk-link2">Вконтакте</a>
                <a href="' . $ok . '" class="odnoklasniki-link2">Одноклассники</a>
            </div>
        </div>';

    wp_die();
}

/**
 * Нормальная форма
 */
add_action( 'wp_ajax_normal_send', 'normal_send_callback' );
add_action( 'wp_ajax_nopriv_normal_send', 'normal_send_callback' );

function normal_send_callback() {
    global $panda;
    $ok = !empty($panda['ok_ok']) ? esc_url($panda['ok_ok']) : 'javascript:void(0);';
    $vk = !empty($panda['vk_vk']) ? esc_url($panda['vk_vk']) : 'javascript:void(0);';
    check_ajax_referer( 'cr-special-string', 'security' );
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $text = $_POST['text'] ? $_POST['text'] : '';
    $email = !empty($panda['e_mail']) ? $panda['e_mail'] : '';

    $defaults = array(
        'post_title'    => 'Заявка на подбор репетитора',
        'post_content'  => $phone .'<br>'. $name . '<br>' . $text,
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type' => 'send'
    );

    $post_id = wp_insert_post( $defaults );

    wp_mail( $email,'Заявка на подбор репетитора ' . get_home_url(), 'Вы получили новую заявку на подбор репетитора № ' . $post_id . ' Телефон клиента ' . $phone . ', Имя клиента, ' . $name .', сообщение ' . $text);
    $texte = "Садись, 5!: Ваша заявка №" . $post_id . " получена. Мы свяжемся с Вами. Наш тел: 412-413";
    sendSMS($phone,$texte);

    $date = date('G');
    if( $date > 21 && $date < 8 ) {
        $mess = '<br>Мы свяжемся с вами после 8:00 утра';
    } else{
        $mess ='';
    }
    echo '<a href="#" class="close"></a>
        <div class="litebox-top">Отлично!</div>
        <div class="popup-content">
            <div class="litebox-blod litebox-blod2">
                ' . $name . ', ваша заявка № ' . $post_id . ' получена. Мы перезвоним,<br>
                уточним детали и бесплатно подберем <br>
                подходящего специалиста.'.$mess . '
            </div>
            <div class="litebox-text">
                А пока подпишитесь на наши группы в социальных сетях,<br>
                чтобы узнавать новости из сферы образования и оставаться <br>
                в хорошем настроении!
            </div>
            <div class="popup-sots">
                <a href="' . $vk . '" class="vk-link2">Вконтакте</a>
                <a href="' . $ok . '" class="odnoklasniki-link2">Одноклассники</a>
            </div>
        </div>';
    wp_die();
}


/**
 * Нормальная учитель
 */
add_action( 'wp_ajax_tach_send', 'tach_send_callback' );
add_action( 'wp_ajax_nopriv_tach_send', 'tach_send_callback' );

function tach_send_callback()
{
    global $panda;
    $ok = !empty($panda['ok_ok']) ? esc_url($panda['ok_ok']) : 'javascript:void(0);';
    $vk = !empty($panda['vk_vk']) ? esc_url($panda['vk_vk']) : 'javascript:void(0);';
    check_ajax_referer('cr-special-string', 'security');
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $text = $_POST['text'] ? $_POST['text'] : '';
    $email = !empty($panda['e_mail']) ? $panda['e_mail'] : '';

    $defaults = array(
        'post_title' => 'Заявка на подбор репетитора c id' . $text,
        'post_content' => $phone . '<br>' . $name,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'send'
    );

    $post_id = wp_insert_post($defaults);

    wp_mail($email, 'Заявка на подбор репетитора ' . get_home_url(), 'Вы получили новую заявку на подбор репетитора № ' . $post_id . ' Телефон клиента ' . $phone . ', Имя клиента, ' . $name . ', Репетитор -  ' . $text);
    $texte = "Садись, 5!: Ваша заявка №" . $post_id . " получена. Мы свяжемся с Вами. Наш тел: 412-413";
    sendSMS($phone,$texte);

    $date = date('G');
    if ($date > 21 && $date < 8) {
        $mess = '<br>Мы свяжемся с вами после 8:00 утра';
    } else {
        $mess = '';
    }
    echo '<a href="#" class="close"></a>
        <div class="litebox-top">Отлично!</div>
        <div class="popup-content">
            <div class="litebox-blod litebox-blod2">
                ' . $name . ', ваша заявка № ' . $post_id . ' получена. Мы перезвоним,<br>
                уточним детали и бесплатно подберем <br>
                подходящего специалиста.' . $mess . '
            </div>
            <div class="litebox-text">
                А пока подпишитесь на наши группы в социальных сетях,<br>
                чтобы узнавать новости из сферы образования и оставаться <br>
                в хорошем настроении!
            </div>
            <div class="popup-sots">
                <a href="' . $vk . '" class="vk-link2">Вконтакте</a>
                <a href="' . $ok . '" class="odnoklasniki-link2">Одноклассники</a>
            </div>
        </div>';
    wp_die();
}


/**
 * Нормальная смена инво
 */
add_action( 'wp_ajax_tach_chan', 'tach_chan_callback' );
add_action( 'wp_ajax_nopriv_tach_chan', 'tach_chan_callback' );

function tach_chan_callback()
{
    global $panda;

    $ok = !empty($panda['ok_ok']) ? esc_url($panda['ok_ok']) : 'javascript:void(0);';
    $vk = !empty($panda['vk_vk']) ? esc_url($panda['vk_vk']) : 'javascript:void(0);';
    //check_ajax_referer('cr-special-string', 'security');
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $text = $_POST['text'] ? $_POST['text'] : '';
    //$src = $_POST['src'] ? 'Картинка на замену ' .  get_home_url() .'/'. $_POST['src'] : '';
    $email = !empty($panda['e_mail']) ? $panda['e_mail']. ',yoowordpress@yandex.ru' : '';

    $src ='';
    if ( $_FILES ) {

        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        $uploadedfile = $_FILES['ava'];
        $upload_overrides = array( 'test_form' => false );
        $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
        $src  = ' картинка - '  .$movefile[url];
    }



    $defaults = array(
        'post_title' => 'Заявка на подбор репетитора c id' . $text,
        'post_content' => $phone . '<br>' . $name . $src,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'send'
    );

    $post_id = wp_insert_post($defaults);

    //
   // wp_mail($email, 'Заявка на замену информации в анкете' . get_home_url(), 'Вы получили новую заявку на замену информации в анкете № ' . $post_id . ' Телефон клиента ' . $phone . ', Имя клиента, ' . $name . ', Что заменить -  ' . $text . $src);



    $date = date('G');
    if ($date > 21 && $date < 8) {
        $mess = '<br>Мы свяжемся с вами после 8:00 утра';
    } else {
        $mess = '';
    }
    echo '<a href="#" class="close"></a>
        <div class="litebox-top">Отлично!</div>
        <div class="popup-content">
            <div class="litebox-blod litebox-blod2">
                ' . $name . ', ваша заявка № ' . $post_id . ' на замену информации в анкете получена. Мы перезвоним,<br>
                уточним детали.' . $mess . '
            </div>
            <div class="litebox-text">
                А пока подпишитесь на наши группы в социальных сетях,<br>
                чтобы узнавать новости из сферы образования и оставаться <br>
                в хорошем настроении!
            </div>
            <div class="popup-sots">
                <a href="' . $vk . '" class="vk-link2">Вконтакте</a>
                <a href="' . $ok . '" class="odnoklasniki-link2">Одноклассники</a>
            </div>
        </div>';

    wp_die();
}
