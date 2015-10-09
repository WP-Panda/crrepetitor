<?php

add_action( 'wp_ajax_step_one_register_form', 'step_one_register_form_callback' );
add_action( 'wp_ajax_nopriv_step_one_register_form', 'step_one_register_form_callback' );

function step_one_register_form_callback() {
    header('Content-Type: application/json');
    check_ajax_referer( 'cr-special-string', 'security' );
    $form = $_POST['content'];
    $img = $_POST['img'] ? esc_url(home_url($_POST['img'])) : '';

    /**
     * В массиве передаются
     * sex - пол (обязятельное)
     * last_name - фамилия (обязятельное)
     * name - имя (обязятельное)
     * father_name - отчество (обязятельное)
     * both_year - год рождения (обязятельное)
     * phone- телефон (обязятельное)
     * e_mail - электропочта (не обязятельное)
     * i_accsept - принимаю условия (обязятельное)
     *
     * namer - флаг проверки ( если поле заполнено то форму не принимаем)
     */

    parse_str($form, $values);

    # массив под ошибки
    $error = array();

    # массив под данные
    $data = array();

    $data['ava'] = $img;

    # если не согласны с офертой
    if(empty($values['i_accsept'])) {
        echo 'Вы должны согласиться с публичной офертой';
        die();
    }

    # если заполнено поле флага сайлоны придут за тобой
    if(!empty($values['namer'])){
        echo 'И у них есть план.';
        die();
    }

    $data['sex'] = $values['sex'] ? trim($values['sex']) : 1;
    $data['last_name'] = $values['last_name'] ? trim($values['last_name']) : 1;
    $data['name'] = $values['name'] ? trim($values['name']) : $error['name'] = 1;
    $data['father_name'] = $values['father_name'] ? trim($values['father_name']) : 1;
    $data['both_year'] = $values['both_year'] ? trim((int)$values['both_year']) : 1;
    $data['phone'] = $values['phone'] ? trim($values['phone']) :  1;
    $data['e_mail']  = $values['e_mail'] ? trim($values['e_mail']) :  1;

    if( 1 == $data['sex'] )
        $error[] = 'sex';

    if( 1 == $data['last_name'] )
        $error[] = 'last_name';

    if( 1 == $data['name'] )
        $error[] = 'name';

    if( 1 == $data['father_name']  )
        $error[] = 'father_name';

    if( 1 == $data['both_year']  )
        $error[] = 'both_year';

    if( 1 == $data['phone']  )
        $error[] = 'phone';

   /* if( 1 == $data['e_mail']  )
        $error[] = 'e_mail';*/

    if( ! empty($error)) {
        wp_send_json_error( $error );
        die();
    }

    global $panda;
    $return = array(
        'url' => $panda['three_step_url'],
    );

    $_SESSION['reg'] = json_encode($data);
    wp_send_json_success( $return );
    wp_die();
}