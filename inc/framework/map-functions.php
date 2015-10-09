<?php

/**
 * Получение точек для карты
 * @return mixed|object|string|void
 */
function return_points($param = null)
{

    //if ( false === ( $points = get_transient( 'teacher_array' ) ) ) {

    global $panda;

    /* $map = new Cr_Filter_Class();

     $array = array(
         'table' => 'teachers',
         'field' => array(
             'street',
             'house',
             'latitude',
             'longitude',
             'last_name',
             'name_teache',
             'teache_id',
             'status',
             'student_cat',
             'prise',
             'time_lesson'
         ),
         'debug' => false
     );

     if(!empty($param)){
         $array['param'] = $param;
     }

     $result = $map->get_sphinx_result($array);*/

    $array = array(
        'post_type' => 'post',
        'nopaging' => true,
        'meta_query' => array(
            array(
                'key'     => 'az_place_of_employment_shir',
                'compare' => 'EXISTS'
            )
        )
    );

    if(!empty($param)){
        //$terma = get_term_by('name',$param,'category');
        $array['cat'] = $param;
    }

    $my_posts  = new WP_Query();

    $result = $my_posts->query($array);

    //print_r($result);

    $points = (object)array(
        "type" => "FeatureCollection",
        "features" => array()
    );

    foreach ($result as $key) {
        if( empty( get_post_meta( $key->ID, 'az_place_of_employment_shir', true) ) ) continue;
        $teacher_status = get_post_meta($key->ID, 'az_teacher_status', true);
        $cc = '';

        $az_category_students5 = get_post_meta($key->ID,'az_category_students5',true);;
        if(!empty($az_category_students5 ) && is_array($az_category_students5)) {
            foreach ($az_category_students5  as $keys => $vals) {
                if ($vals == 1)
                    $cc .= $panda['site_student'][(int)$keys] . ', ';
            }
        }


        $az_use_skype_teacher = get_post_meta($key->ID, 'az_use_skype_teacher', true);

        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($key->ID), 'thumbnail_size');
        $thumb_url = bfi_thumb($thumb[0], array('width' => 35, 'height' => 41, 'crop' => true));

        $ball = '<div class="point-hover" data-id="' . $key->ID . '"><div style="position: relative;">' .
            get_the_post_thumbnail($key->ID, array(60, 80, 'bfi_thumb' => true)) .
            '<div class="point-img-right">';
        if (!empty($az_use_skype_teacher)) {
            $ball .= '<div class="skype-serch"></div>';
        }
        $ball .= '<a href="' . get_the_permalink($key->ID) . '" class="point-name">' . $key->post_title  . '</a>' .
            '<span class="prof">' . $panda['teacher_status'][$teacher_status] . '</span>';
        $category = get_the_category($key->ID);
        $ball .= '<br><span class="point-predmet">' . $category[0]->cat_name . '</span>
        </div></div>';
        if( ! empty($az_category_students5 )&& is_array($az_category_students5)) {
            $ball .='<div class="point-category"><span>Категория учеников:</span>' .
                trim($cc, ', ') .
                '</div>';
        } else {
            $ball .='<div class="point-category"><span>Категория учеников:</span>' .
                'Отсутствуют' .
                '</div>';
        }
        $ball .= '<div class="point-prise-block">
            <div class="point-prise">
                <span>' . get_post_meta($key->ID, 'az_cost_of_classes', true) . ' руб.</span>
            </div>' .
            get_post_meta($key->ID, 'az_lesson_time', true) . ' мин.
            </div>
            <a href="#dialog" class="green-button send-ticher" name="modal">Связаться</a>
        </div>';

        $points->features[] = (object)array(
            'type' => 'Feature',
            'geometry' => (object)array(
                'type' => 'Point',
                'coordinates' => array(
                    '0' => get_post_meta($key->ID, 'az_place_of_employment_shir', true),
                    '1' => get_post_meta($key->ID, 'az_place_of_employment_dol', true)
                )
            ),
            'options' => (object)array(
//'preset' => 'islands#violetDotIcon'
                'iconLayout' => 'default#image',
                'iconImageHref' => $thumb_url,
                'iconImageSize' => [35, 41],
                'iconImageOffset' => [-18, -62]
            )
        );

        $points->features[] = (object)array(
            'type' => 'Feature',
            'geometry' => (object)array(
                'type' => 'Point',
                'coordinates' => array(
                    '0' => get_post_meta($key->ID, 'az_place_of_employment_shir', true),
                    '1' => get_post_meta($key->ID, 'az_place_of_employment_dol', true)
                )
            ),
            'properties' => (object)array(
                'balloonContent' => $ball,
                'hintContent' => $key->title
            ),
            'options' => (object)array(
//'preset' => 'islands#violetDotIcon'
                'iconLayout' => 'default#image',
                'iconImageHref' => get_re_img_src("map-pointer.png"),
                'iconImageSize' => [58, 75],
                'iconImageOffset' => [-30, -70],
                'hideIconOnBalloonOpen' => false,
                'balloonOffset' => [0, -67]
            )
        );
    }

    $points = json_encode($points);

    //    set_transient( 'teacher_array', $points , 150 * HOUR_IN_SECONDS );
    //}

    return $points;

}