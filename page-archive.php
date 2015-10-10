<?php
/**
Template Name: Подбор преподавателя
 */

get_header(); ?>
    <!--script>history.pushState(null, null, location.pathname);</script-->

    <div class="inside-content">
        <div class="wr">

            <?php get_template_part( 'templates/template','search-seo' ); ?>
            <?php get_template_part( 'templates/template','breadcrumbs' ); ?>

            <div class="search-page">

                <?php get_template_part( 'templates/template','left-column-search' ); ?>

                <div class="serch-right-colum" id="filtr-result">
                    <?php get_template_part( 'templates/template','search-sort-block' ); ?>

                    <div class="serch-view<?php echo $num; ?>">
                        <div id="appener">

                            <?php
                            //$_GETter = $_POST['get'];

                            $part = ! empty( $_GET['show'] )  ? $_GET['show'] : 'list';
                            $subject = !empty($_GET['subject']) && $_GET['subject'] !=='Выберите предмет' ? $_GET['subject'] : '';
                            $district = !empty($_GET['district']) && $_GET['district'] !=='Выберите район' ? esc_sql($_GET['district']) : '';
                            $location = !empty($_GET['location']) && $_GET['location'] !=='all' ? esc_sql($_GET['location']) : '';
                            $ek = !empty($_GET['ek']) ? esc_sql($_GET['ek']) : '';
                            $sex = !empty($_GET['pol']) && $_GET['pol'] !=='all' ? esc_sql($_GET['pol']) : '';
                            $sort = ! empty( $_GET['orders'] ) ? $_GET['orders'] : '';

                            $querys = array();

                            if( ! empty($sort) ) {
                                $querys['orderby'] = 'meta_value';
                                $querys['meta_key'] = 'prise_60';
                                $querys['order'] = $sort;
                            }

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


                            $query = new WP_Query( $querys );
                            if ( $query->have_posts() ) : $n = 0; while ( $query->have_posts() ) : $query->the_post(); $n++;

                                /*if( ! empty($_POST['district']) && $_POST['district'] !=='Выберите район' ) {
                                    $az_areas_of_the_county5 = get_post_meta($post->ID,'az_areas_of_the_county5',true);
                                    if( $az_areas_of_the_county5[$_GET['district']] != 1 )
                                        continue;
                                }*/

                                if( $n%2 == 1){ echo '<div class="clearfix"></div>'; }
                                ?>
                                <?php get_template_part( 'templates/template','search-' . $part );

                                ?>
                            <?php endwhile; else: ?>
                                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>



            <div class="clearfix"></div>

        </div>
    </div>

<?php get_footer();