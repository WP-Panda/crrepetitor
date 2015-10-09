<?php
/*
 Template Name: Список заявок
 */
get_header(); ?>
    <div class="inside-content">
        <div class="wr">

            <?php get_template_part('templates/template','wot-working-order-list') ?>
            <div class="order-doska-title"><?php the_title(); ?></div>
            <?php get_template_part('templates/template','breadcrumbs') ?>

            <div class="search-page">
                <?php get_template_part( 'templates/template','left-column-order' ); ?>

                <div class="order-right" id="filtr-result">
                    <?php $array = array('post_type'=>'order');
                    $new_query = new WP_Query($array);
                    if ( $new_query->have_posts() ) : while ( $new_query->have_posts() ) : $new_query->the_post();
                        get_template_part( 'templates/template','right-column-order' );
                    endwhile; else: ?>
                        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php
                    endif;
                    wp_reset_query();
                    ?>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
<?php get_footer();