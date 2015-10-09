<?php
add_action( 'wp_ajax_left_search', 'left_search_callback' );
add_action( 'wp_ajax_nopriv_left_search', 'left_search_callback' );

function left_search_callback(){

    check_ajax_referer( 'cr-special-string', 'security' );
    $val = $_POST['val'];
    parse_str($val , $vals );
    $part = ! empty( $_COOKIE['arch_visible'] ) && $_COOKIE['arch_visible'] == 'grid' ? 'grid' : 'list';
    $subject = $vals['subject'] && $vals['subject'] !=='Выберите предмет' ? $vals['subject'] : '';


    $district = $vals['district'] && $vals['district'] !=='Выберите район' ? esc_sql($vals['district']) : '';
    $location = $vals['location'] && $vals['location'] !=='all' ? esc_sql($vals['location']) : '';
    $ek = !empty($vals['ek']) ? esc_sql($vals['ek']) : '';
    $sex = !empty($vals['pol']) && $vals['pol'] !=='all' ? esc_sql($vals['pol']) : '';


    $querys = array();
    //предмет
    if( ! empty($subject) ) {
        $querys['category__in'] = array($subject);
    }

    if( empty($subject) && ! empty($_POST['cat'])) {
        $querys['category__in'] = array($_POST['cat']);
    }

    //егэ
    if( ! empty($ek) ) {
        $querys['tag'] = $ek;
    }

    $querys ['meta_query'] = array(
        'relation' => 'AND',
    );

    //пол
    if( ! empty($sex) && $sex !=='all' ) {
        $querys ['meta_query'][] = array(
            'key' => 'az_teacher_sex',
            'value' => $sex
        );
    }


    // место занятий
    if( ! empty($location) ) {

        if ( $location !== 'skipe') {
            $querys ['meta_query'][] = array(
                'key' => 'az_teacher_lesson_location',
                'value' => $location
            );

        } else {
            $querys ['meta_query'][] = array(
                'key' => 'az_use_skype_teacher',
                'value' => 1
            );

        }
    }


    // район
    if(! empty($district) && $district == 1 ) {
        $array1 = array(
            serialize([1 => "1", 2 => "1", 3 => "1", 4 => "1"]),
            serialize([1 => "1", 2 => '', 3 => '', 4 => '']),
            serialize([1 => "1", 2 => "1", 3 => '', 4 => "1"]),
            serialize([1 => "1", 2 => '', 3 => "1", 4 => '']),
            serialize([1 => "1", 2 => "1", 3 => "1", 4 => '']),
            serialize([1 => "1", 2 => '', 3 => '', 4 => "1"]),
            serialize([1 => "1", 2 => '', 3 => "1", 4 => "1"]),
            serialize([1 => "1", 2 => "1", 3 => '', 4 => ''])
        );

        $querys ['meta_query']['qu'] = array(
            'relation' => 'OR'
        );

        foreach ($array1 as $arr1) {
            $querys ['meta_query']['qu'][] = array(
                'key' => 'az_areas_of_the_county5',
                'value' => $arr1,
            );
        }
    }

    if(! empty($district) && $district == 2 ) {
        $array2 = array(
            serialize([1=>"1",2=>"1",3=>"1",4=>"1"]),
            serialize([1=>'',2=>"1",3=>'',4=>'']),
            serialize([1=>"1",2=>"1",3=>'',4=>"1"]),
            serialize([1=>'',2=>"1",3=>"1",4=>'']),
            serialize([1=>"1",2=>"1",3=>"1",4=>'']),
            serialize([1=>'',2=>"1",3=>'',4=>"1"]),
            serialize([1=>'',2=>"1",3=>"1",4=>"1"]),
            serialize([1=>"1",2=>"1",3=>'',4=>'']),
            serialize([1=>'',2=>"1",3=>'',4=>"1"])
        );
        $querys ['meta_query']['qu'] = array(
            'relation' => 'OR'
        );

        foreach ($array2 as $arr1) {
            $querys ['meta_query']['qu'][] = array(
                'key' => 'az_areas_of_the_county5',
                'value' => $arr1,
            );
        }
    }

    if(! empty($district) && $district == 3 ) {
        $array3 = array(
            serialize([1=>"1",2=>"1",3=>"1",4=>"1"]),
            serialize([1=>'',2=>'',3=>"1",4=>'']),
            serialize([1=>"1",2=>'',3=>"1",4=>"1"]),
            serialize([1=>'',2=>"1",3=>"1",4=>'']),
            serialize([1=>"1",2=>"1",3=>"1",4=>'']),
            serialize([1=>'',2=>'',3=>"1",4=>"1"]),
            serialize([1=>'',2=>"1",3=>"1",4=>"1"]),
            serialize([1=>"1",2=>'',3=>"1",4=>'']),
            serialize([1=>'',2=>'',3=>"1",4=>"1"])
        );
        $querys ['meta_query']['qu'] = array(
            'relation' => 'OR'
        );

        foreach ($array3 as $arr1) {
            $querys ['meta_query']['qu'][] = array(
                'key' => 'az_areas_of_the_county5',
                'value' => $arr1,
            );
        }
    }

    if(! empty($district) && $district == 4 ) {
        $array4 = array(
            serialize([1=>"1",2=>"1",3=>"1",4=>"1"]),
            serialize([1=>'',2=>'',3=>'',4=>"1"]),
            serialize([1=>"1",2=>'',3=>"1",4=>"1"]),
            serialize([1=>'',2=>"1",3=>'',4=>"1"]),
            serialize([1=>"1",2=>"1",3=>'',4=>"1"]),
            serialize([1=>'',2=>'',3=>"1",4=>"1"]),
            serialize([1=>'',2=>"1",3=>"1",4=>"1"]),
            serialize([1=>"1",2=>'',3=>'',4=>"1"]),
            serialize([1=>'',2=>'',3=>"1",4=>"1"])
        );
        $querys ['meta_query']['qu'] = array(
            'relation' => 'OR'
        );

        foreach ($array4 as $arr1) {
            $querys ['meta_query']['qu'][] = array(
                'key' => 'az_areas_of_the_county5',
                'value' => $arr1,
            );
        }
    }

    $query = new WP_Query($querys);

    if ( $query->have_posts() ) : $n = 0; while ( $query->have_posts() ) : $query->the_post();?>
        <?php get_template_part( 'templates/template','search-'.$part ); $n++;  ?>
    <?php endwhile; else: ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif;

    wp_die();
}

