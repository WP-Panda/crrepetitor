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
                    <?php
                    $part  = ! empty( $_GET['show'] ) && $_GET['show'] == 'grid' ? 'grid' : 'list';
                    $num =  ! empty( $_GET['arch_visible'] ) && $_GET['arch_visible'] == 'grid' ? '2' : '1';


                    ?>
                    <div class="serch-view<?php echo $num; ?>">
                        <div id="appener">

                            <?php $array = array('post_type=>post');

                            // $array = array('post_type=>post','orderby' => 'meta_value', 'meta_key' => 'prise_60','order' => 'ASC');

                            if(!empty($_POST['lesson'])) {
                               //$category = get_term_by('name', $_GET['lesson'], 'category');
                               $category = get_term_by('name', trim($_POST['lesson']), 'category');
                                $array['category_name']=$category->slug;
                            }
                            $query = new WP_Query( $array );
                            if ( $query->have_posts() ) : $n = 0; while ( $query->have_posts() ) : $query->the_post(); $n++;

                                if( ! empty($_POST['district']) && $_POST['district'] !=='Выберите район' ) {
                                    $az_areas_of_the_county5 = get_post_meta($post->ID,'az_areas_of_the_county5',true);
                                    if( $az_areas_of_the_county5[$_GET['district']] != 1 )
                                        continue;
                                }

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