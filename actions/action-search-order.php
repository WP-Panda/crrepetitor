<?php
add_action( 'wp_ajax_left_search_order', 'left_search_order_callback' );
add_action( 'wp_ajax_nopriv_left_search_order', 'left_search_order_callback' );

function left_search_order_callback()
{

    check_ajax_referer('cr-special-string', 'security');
    $val = $_POST['val'];
    parse_str($val, $vals);

    $subject = $vals['subject'] && $vals['subject'] !== 'Выберите предмет' ? (int)$vals['subject'] : '';
    $district = $vals['district'] && $vals['district'] !== 'Выберите район' ? esc_sql($vals['district']) : '';
    $location = $vals['location_lesson'] && $vals['location_lesson'] !== 'all' ? esc_sql($vals['location_lesson']) : '';
    $tag = !empty($vals['tag']) ? esc_sql($vals['tag']) : '';
    $sex = !empty($vals['sex']) && $vals['sex'] !== 'all' ? esc_sql($vals['sex']) : '';

    //az_teacher_sex  - пол ученика
    //az_teacher_lesson_location - где пройдут занятия
    //az_place_of_employment_district - место занятий район


    $querys = array(
        'post_type' => 'order'
    );
    if (!empty($subject)) {
        $querys['tax_query'] = array(
            array(
                'taxonomy' => 'orders_list',
                'field' => 'id',
                'terms' => $subject
            )
        );
    }

    if (!empty($tag)) {
        $querys['tag'] = $tag;
    }

    $querys ['meta_query'] = array(
        'relation' => 'AND',
    );

    if (!empty($sex)) {
        $querys ['meta_query'][] = array(
            'key' => 'az_teacher_sex',
            'value' => $sex
        );
    }

    $query = new WP_Query($querys);
    
    if ($query->have_posts()) : $n = 0;
        while ($query->have_posts()) : $query->the_post();
            $n++;
            global $post;


            if (!empty($district)) {
                $az_areas_of_the_county5 = get_post_meta($post->ID, 'az_place_of_employment_district', true);
                if ($az_areas_of_the_county5 !== $district)
                    continue;
            }

            if (!empty($location)) {

                // if ( $location !== 'skipe') {
                $az_teacher_lesson_location = get_post_meta($post->ID, 'az_teacher_lesson_location', true);

                if ($location == 'home') {
                    if ($az_teacher_lesson_location == 'road') {
                        continue;
                    }
                } else {
                    if ($az_teacher_lesson_location == 'home') {
                        continue;
                    }
                }
                // } else {
                //     $az_use_skype_teacher = get_post_meta($post->ID, 'az_use_skype_teacher', true);
                //     if( empty($az_use_skype_teacher))
                //         continue;
                //     if ($az_use_skype_teacher[0] != 1 )
                //         continue;
                // }
            }

           // print_r(get_post_meta($post->ID));
        ?>
        <?php get_template_part( 'templates/template','right-column-order' ); ?>
    <?php endwhile; else: ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif;

    wp_die();
}

