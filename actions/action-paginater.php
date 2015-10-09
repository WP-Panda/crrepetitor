<?php

add_action( 'wp_ajax_scroll_comments', 'scroll_comments_callback' );
add_action( 'wp_ajax_nopriv_scroll_comments', 'scroll_comments_callback' );

function scroll_comments_callback() {

    check_ajax_referer( 'cr-special-string', 'security' );
    $offset = $_POST['offset'];
    $id = $_POST['flag'] ? (int)$_POST['flag'] :'';

    global $post;
    $comments = get_comments(
        array(
            'status'=>'approve',
            //'number' => 1,
            // 'offset' => $offset
        )
    );
    // $count = count($comments);
    $n = 1;

    foreach($comments as $comment){
        $post_id = $comment->comment_post_ID;
        if( !empty( $id) && ! in_category(array($id),$comment->comment_post_ID ) ) {
            //  print_r($id);
            continue;
        }
        if( $n < $offset ) {

            $n++; continue;
        }
        if($n > $offset)
            break;
        ?>
        <div class="review-item">
            <div class="rew-item-teacher">
                <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
                $url = $thumb['0'];
                $params = array(
                    'width' => 71,
                    'height' => 84,
                    'crop'=>true
                );
                $url = bfi_thumb( $url, $params );
                ?>
                <img class="radius-10" src="<?php echo $url; ?>" alt="">
                <div class="rev-t-info">
                    <a href="<?php echo get_the_permalink($post_id); ?>" class="rev-t-name"><?php echo get_the_title($post_id); ?></a>
                    <?php foreach((get_the_category($post_id)) as $category) {
                        echo '<div class="rev-predmet met"><a class="cater" href="' . get_category_link($category->cat_ID). '">' .  $category->cat_name . '</a></div>';
                    } ?>
                </div>
            </div>
            <div class="review-text">
                <?php echo $comment->comment_content; ?>
            </div>
            <div class="reviwe-autor">
                <div class="rev-avtor-name">— <?php echo $comment->comment_author; ?></div>
                <?php $date =  date( 'd/m/Y ', strtotime( $comment->comment_date ) );
                $str = explode('/',$date);
                switch ($str[1]) {
                    case '01':
                        $m = 'Января';
                        break;
                    case '02':
                        $m = 'Февраля';
                        break;
                    case '03':
                        $m = 'Марта';
                        break;
                    case '04':
                        $m = 'Апреля';
                        break;
                    case '05':
                        $m = 'Мая';
                        break;
                    case '06':
                        $m = 'Июня';
                        break;
                    case '07':
                        $m = 'Июля';
                        break;
                    case '08':
                        $m = 'Августа';
                        break;
                    case '09':
                        $m = 'Сентября';
                        break;
                    case '10':
                        $m = 'Октября';
                        break;
                    case '11':
                        $m = 'Ноября';
                        break;
                    case '12':
                        $m = 'Декабря';
                        break;
                }

                echo $str[0] . ' ' . $m . ' ' . $str[2];
                ?>
            </div>
        </div>

        <?php
        $n++;
    }




    wp_die();
}

/**
 * Прокрутка учителей
 */
add_action( 'wp_ajax_scroll_techers', 'scroll_techers_callback' );
add_action( 'wp_ajax_nopriv_scroll_techers', 'scroll_techers_callback' );

function scroll_techers_callback()
{

    check_ajax_referer('cr-special-string', 'security');
    $part = ! empty( $_COOKIE['arch_visible'] ) && $_COOKIE['arch_visible'] == 'grid' ? 'grid' : 'list';
    $sort = ! empty( $_COOKIE['arch_sort'] ) ? $_COOKIE["arch_sort"] : '';


    parse_str(trim($_POST['geter'],'?'),$get);

    print_r($get);

    $district = $get['district'] && $get['district'] !=='Выберите район' ? esc_sql($get['district']) : '';
    $location = $get['location'] && $get['location'] !=='all' ? esc_sql($get['location']) : '';

    $offset = $_POST['offset'];

    print_r($offset);



    if( ! empty($sort) ) {
        $querys = array('post_type=>post','orderby' => 'meta_value', 'meta_key' => 'prise_60','order' => $sort);
    } else {
        $querys = array('post_type=>post');
    }

    $querys['paged'] = $offset;

    if(!empty($get['subject'])) {
        $querys['category__in'] = array($get['subject']);
    }

    if( empty($subject) && ! empty($_POST['cat'])) {
        $querys['category__in'] = array($_POST['cat']);
    }

    if( ! empty($get['ek']) ) {
        $querys['tag'] = $get['ek'];
    }

    $querys ['meta_query'] = array(
        'relation' => 'AND',
    );

    //пол
    if( ! empty($get['pol']) && $get['pol'] !=='all' ) {
        $querys ['meta_query'][] = array(
            'key' => 'az_teacher_sex',
            'value' => $_GET['pol']
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



print_r($querys);
    $query = new WP_Query( $querys );
    if ( $query->have_posts() ) : $n = 0; while ( $query->have_posts() ) : $query->the_post(); $n++; ?>
        <?php get_template_part( 'templates/template','search-' . $part );
        if( $n%2 == 0){ echo '<div class="clearfix"></div>'; }
        ?>
    <?php endwhile; else: ?>
    <?php endif;

    wp_die();
}



add_action( 'wp_ajax_order_by_prise', 'order_by_prise_callback' );
add_action( 'wp_ajax_nopriv_order_by_prise', 'order_by_prise_callback' );

function order_by_prise_callback()
{

    check_ajax_referer('cr-special-string', 'security');
    $part = ! empty( $_COOKIE['arch_visible'] ) && $_COOKIE['arch_visible'] == 'grid' ? 'grid' : 'list';
    $sort = $_COOKIE['arch_sort'];

    $array = array('post_type=>post','orderby' => 'meta_value', 'meta_key' => 'prise_60','order' => $sort);
   // print_r($array);

    if(!empty($_GET['lesson'])) {
        $category = get_term_by('name', $_GET['lesson'], 'category');
        $array['category_name']=$category->slug;
    }

    $query = new WP_Query( $array );
    if ( $query->have_posts() ) : $n = 0; while ( $query->have_posts() ) : $query->the_post(); $n++;

        if( ! empty($_GET['district']) && $_GET['district'] !=='Выберите район' ) {
            $az_areas_of_the_county5 = get_post_meta($post->ID,'az_areas_of_the_county5',true);
            if( $az_areas_of_the_county5[$_GET['district']] != 1 )
                continue;
        }

        ?>
        <?php get_template_part( 'templates/template','search-' . $part );
        if( $n%2 == 0){ echo '<div class="clearfix"></div>'; }
        ?>
    <?php endwhile; else: ?>
    <?php endif;

    wp_die();
}


/**
 * kbcn uhbl
 */

add_action( 'wp_ajax_order_by_show', 'order_by_show_callback' );
add_action( 'wp_ajax_nopriv_order_by_show', 'order_by_show_callback' );

function order_by_show_callback()
{

    check_ajax_referer('cr-special-string', 'security');
    $part = ! empty( $_COOKIE['arch_visible'] ) && $_COOKIE['arch_visible'] == 'grid' ? 'grid' : 'list';
    $sort = ! empty( $_COOKIE['arch_sort'] ) ? $_COOKIE["arch_sort"] : '';

    if( ! empty($sort) ) {
        $array = array('post_type=>post','orderby' => 'meta_value', 'meta_key' => 'prise_60','order' => $sort);
    } else {
        $array = array('post_type=>post');
    }


    // print_r($array);

    if(!empty($_GET['lesson'])) {
        $category = get_term_by('name', $_GET['lesson'], 'category');
        $array['category_name']=$category->slug;
    }

    $query = new WP_Query( $array );
    if ( $query->have_posts() ) : $n = 0; while ( $query->have_posts() ) : $query->the_post(); $n++;

        if( ! empty($_GET['district']) && $_GET['district'] !=='Выберите район' ) {
            $az_areas_of_the_county5 = get_post_meta($post->ID,'az_areas_of_the_county5',true);
            if( $az_areas_of_the_county5[$_GET['district']] != 1 )
                continue;
        }

        ?>
        <?php get_template_part( 'templates/template','search-' . $part );
        if( $n%2 == 0){ echo '<div class="clearfix"></div>'; }
        ?>
    <?php endwhile; else: ?>
    <?php endif;

    wp_die();
}