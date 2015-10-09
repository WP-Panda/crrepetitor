<?php

add_action( 'wp_ajax_step_two_register_form', 'step_two_register_form_callback' );
add_action( 'wp_ajax_nopriv_step_two_register_form', 'step_two_register_form_callback' );

function step_two_register_form_callback() {
    header('Content-Type: application/json');
    check_ajax_referer( 'cr-special-string', 'security' );
    $form = $_POST['content'];
    $prise = $_POST['prise'];
   // print_r($form);

    /**
     * В массиве передаются
     * about_us - о себе #
     * education - название образования         (array)
     *
     * company - название организации           (array)
     * role - должность в организации           (array)
     * work-start - начало работы               (array)
     * work-stop - окончание работы             (array)
     * experience - опыт работы
     * oge - подготовка к ОГА
     * ega - подготовка к ЕГЭ
     * status - текущий статус #
     * specialization - специализация           (array)
     * category_student - категории студентов   (array)
     * skype  - работа по скайп
     * location_lesson - место занятий

     * city
     * address - улица
     * district - район проживания
     * house - дом
     * geo - координата
     * location_district - районы выезда array   (array)
     * ran_addon - дополнительно за выезд
     * lesson_time - время занятия
     *
     * namer - флаг проверки ( если поле заполнено то форму не принимаем)
     */

    parse_str($form, $values);


    $error = array();
    $data = array();

    if( ! empty($values['about_us'] ) ) {
        $data['about_us'] = $values['about_us'];
    } else {
        $error[] = 'about_us';
    }

    $values['education'] = array_filter( $values['education'] );
    if( !empty( $values['education'] ) ) {
        $maxe = count($values['education']);
        $n = 0;
        while ($n<$maxe) {
            $data['education'][] = $values['education'][$n];
            $n++;
        }
    } else {
        $error[] = 'education';
    }


    $values['company'] = array_filter( $values['company'] );
    $values['role'] = array_filter( $values['role'] );
    $values['work_start'] = array_filter( $values['work_start'] );
    $values['work_stop'] = array_filter( $values['work_stop'] );
    if( ! empty($values['company']) &&
        count( $values['company'] ) == count( $values['role'] ) &&
        count( $values['company'] ) == count( $values['work_start'] ) &&
        count( $values['company'] ) == count( $values['work_stop'] )
    ) {
        $max = count($values['company']);
        $i = 0;
        while ($i<$max) {
            $data['worker'][] = $values['work_start'][$i] . ' - ' . $values['work_stop'][$i] . ' ' . $values['company'][$i] . ' ' . $values['role'][$i];
            $i++;
        }
    }else {
        $error[] = 'companys';
    }

    if( ! empty($values['experience'] ) ) {
        $data['experience'] = $values['experience'];
    } else {
        $error[] = 'experience';
    }

    if(
        empty($values['oge'] )  &&
        empty($values['ega'] )
    ) {
        //$error[] = 'oge';
        //$error[] = 'ega';
    } else {
        if( ! empty($values['oge'] ) ) {
            $data['oge'] = $values['oge'];
        }
        if( ! empty($values['ega'] ) ) {
            $data['ega'] = $values['ega'];
        }
    }
    global $panda;

    /* $site_status = $panda['teacher_status'];
     $data['status'] = array();
     if( !empty( $values['status'] ) ) {
         foreach ($site_status as $keyf  ) {
             if (isset( $values['status'][$key] ) ) {
                 $data['status'][$keyf] = 1;
             } else {
                 $data['status'][$keyf] = 0;
             }
         }
     } else {
         $error[] = 'category_student';
     }*/
    if(
        ! empty($values['status'] ) &&
        $values['status'] !== 'Ваш текущий статус *'
    ) {
        $data['status'] = $values['status'];
    } else {
        $error[] = 'status';
    }


    if( !empty( $values['specialization'] ) ) {
        $data['specialization'] = $values['specialization'];
    } else {
        $error[] = 'specialization';
    }


    $site_student = $panda['site_student'];
    $data['category_student'] = array();
    if( !empty( $values['category_student'] ) ) {
        foreach ($site_student as $key  ) {
            if (isset( $values['category_student'][$key] ) ) {
                $data['category_student'][$key] = 1;
            } else {
                $data['category_student'][$key] = '';
            }
        }
    } else {
        $error[] = 'category_student';
    }



    if( !empty( $values['skype'] ) ) {
        $data['skype'] = $values['skype'];
    } else {
        $error[] = 'skype';
    }


    if( !empty( $values['location_lesson'] ) ) {
        $data['location_lesson'] = $values['location_lesson'];
    } else {
        $error[] = 'location_lesson';
    }

    if( !empty( $values['city'] ) ) {
        $data['city'] = $values['city'];
    } else {
        $error[] = 'location_lesson';
    }

    if( !empty( $values['address'] ) ) {
        $data['address'] = $values['address'];
    } else {
        $error[] = 'address';
    }

    if(
        !empty( $values['district'] ) &&
        $values['district'] !== 'Выберите район *'
    ) {
        $data['district'] = $values['district'];
    } else {
        $error[] = 'district';
    }

    if(
    !empty( $values['house'] ) ) {
        $data['house'] = $values['house'];
    } else {
        $error[] = 'house';
    }

    if(!empty( $values['geo'] ) ) {
        $data['geo'] = $values['geo'];
    } else {
        $error[] = 'geo';
    }

    if( !empty( $prise ) ) {
        $data['prise'] = (int)$prise;
    } else {
        $error[] = 'prise';
    }


    if( ! empty( $data['location_lesson'] ) &&
        (
            $data['location_lesson'] == 'road' ||
            $data['location_lesson'] == 'all'
        )
    ){

        $city_district = $panda['city_district'];
        $data['location_district'] = array();
        if( !empty( $values['location_district'] ) ) {
            foreach ($city_district as $key  ) {
                if (isset( $values['location_district'][$key] ) ) {
                    $data['location_district'][$key] = 1;
                } else {
                    $data['location_district'][$key] = '';
                }
            }
        } else {
            $error[] = 'location_district';
        }

        if( !empty( $values['ran_addon'] ) ) {
            $data['ran_addont'] = (int)$values['ran_addon'];
        } else {
            $error[] = 'ran_addon';
        }

    }

    if( !empty( $values['lesson_time'] ) &&
        $values['lesson_time'] !== 'Выберите время'
    ) {
        $data['lesson_time'] = $values['lesson_time'];
    } else {
        $error[] = 'lesson_time';
    }

    if( ! empty($error)) {
        wp_send_json_error( $error );
        die();
    }



    if( ! empty($_SESSION['reg'])){
        $session_val = json_decode($_SESSION['reg']);
    }

   // print_r($session_val);
    $tagg = !empty($data['ega']) ? 'ega' : '';
    $tagg2 = !empty($data['oge']) ? 'oge' : '';


    $title = wp_strip_all_tags( $session_val->name . ' ' . $session_val->father_name);
    $post_data = array(
        'post_title'    => $title,
        'post_content'  => $data['about_us'],
        'post_status'   => 'pending',
        'post_author'   => 1,
        'post_category' => $data['specialization'],
        'tags_input' => $tagg .',' . $tagg2
    );

// Вставляем запись в базу данных
    $post_id = wp_insert_post( $post_data );

    if(!$post_id) wp_die();

    $prefix = 'az_';

    update_post_meta($post_id,$prefix . 'teacher_sex',$session_val->sex);
    update_post_meta($post_id,$prefix . 'family_name_teacher',$session_val->last_name);
    update_post_meta($post_id,$prefix . 'teacher_both', $session_val->both_year);
    update_post_meta($post_id,$prefix . 'teacher_status', $data['status']);
    if($data['skype'] == 'yes')
        update_post_meta($post_id, $prefix . 'use_skype_teacher', '1');
    update_post_meta($post_id,$prefix . 'teacher_lesson_location', $data['location_lesson']);
    update_post_meta($post_id,$prefix . 'experience', $data['experience']);
    update_post_meta($post_id,$prefix . 'cost_of_classes', $data['prise']);
    update_post_meta($post_id,$prefix . 'lesson_time', $data['lesson_time']);
    if(isset($data['ran_addont']))
        update_post_meta($post_id,$prefix . 'extra_charge_for_check_out', $data['ran_addont']);
    update_post_meta($post_id,$prefix . 'education_of_the_teacher', $data['education']);
    update_post_meta($post_id,$prefix . 'place_of_work', $data['worker']);
    update_post_meta($post_id,$prefix . 'category_students55', $data['category_student']);
    update_post_meta($post_id,$prefix . 'place_of_employment_city', $data['city']);
    update_post_meta($post_id,$prefix . 'place_of_employment_district', $data['district']);
    update_post_meta($post_id,$prefix . 'place_of_employment_street', $data['address']);
    update_post_meta($post_id,$prefix . 'place_of_employment_house', $data['house']);

    $geor = explode(',',$data['geo']);
    update_post_meta($post_id,$prefix . 'place_of_employment_shir', $geor[0]);
    update_post_meta($post_id,$prefix . 'place_of_employment_dol', $geor[1]);
    update_post_meta($post_id,$prefix . 'areas_of_the_county5', $data['location_district']);
    update_post_meta($post_id,$prefix . 'phone', $session_val->phone);
    update_post_meta($post_id,$prefix . 'email', $session_val->e_mail);

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');


    $file_array = array();
    $tmp = download_url( $session_val->ava );
    preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $session_val->ava, $matches );
    if($matches) {
        $file_array['name'] = basename($matches[0]);
        $file_array['tmp_name'] = $tmp;

        $id = media_handle_sideload($file_array, $post_id, $session_val->name . ' ' . $session_val->father_name);

        if (is_wp_error($id)) {
            @unlink($file_array['tmp_name']);
            return $id->get_error_messages();
        }

        set_post_thumbnail($post_id, $id);
        @unlink($file_array['tmp_name']);
    }

    /*приводим цену к однообразной*/
   $data['for_60'] = (int)$data['prise'] * 60 / (int)$data['lesson_time'];
    update_post_meta($post_id,'prise_60',$data['for_60']);


    $texte = "Садись, 5!: Ваша анкета получена. Мы свяжемся с Вами. Наш тел: +79170939394";
    //sendSMS($session_val->phone,$texte);
    sendSMS($session_val->phone,$texte);


/*
    $array = array(
        'time'              => current_time( 'mysql' ),
        'teache_id'         => $post_id,
        'phone'             => $session_val->phone,
        'email'             => $session_val->e_mail,
        'last_name'        => $session_val->last_name,
        'father_name'      => $session_val->father_name,
        'name_teache'      => $session_val->name,
        //'specialization'   => $data['specialization'],
        'teache_content'   => $data['about_us'],
        'sex'              => $session_val->sex,
        'both_teache'      => $session_val->both_year,
        'status'           => $data['status'],
        'skype'            => $data['skype'],
        'lesson_point'     => $data['location_lesson'],
        'experience_year'  => $data['experience'],
        'prise'            => $data['prise'],
        'time_lesson'      => $data['lesson_time'],
        'education'        => serialize($data['education']),
        'experience'       => serialize($data['worker']),
        'student_cat'      => serialize($data['category_student']),
        'sity'             => $data['city'],
        'district'         => $data['district'],
        'street'           => $data['address'],
        'house'            => $data['house'],
        'latitude'         => $geor[0],
        'longitude'        => $geor[1],
        'for_60'           => $data['for_60']
    );

    if(!empty($data['location_district']))
        $array['emigration_district'] = serialize($data['location_district']);
    if(!empty($data['ran_addont']))
        $array['prise_addon']=$data['ran_addont'];

    global $wpdb;
    $table_name = $wpdb->prefix . "teachers";
    $wpdb->insert(
        $table_name,
        $array
    );
*/



    wp_send_json_success( array($post_id) );
    wp_die();

}