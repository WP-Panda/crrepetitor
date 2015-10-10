<?php get_header(); ?>

    <div class="inside-content">
        <div class="wr">

            <?php get_template_part( 'templates/template','search-seo' ); ?>
            <?php get_template_part( 'templates/template','breadcrumbs' ); ?>

            <div class="search-page">

                <?php get_template_part( 'templates/template','left-column-search-archive' ); ?>

                <div class="serch-right-colum" id="filtr-result">
                    <?php get_template_part( 'templates/template','search-sort-block' ); ?>
                    <?php
                   // $part = ! empty( $_GET['arch_visible'] ) && $_GET['arch_visible'] == 'grid' ? 'grid' : 'list';
                    //$num =  ! empty( $_GET['arch_visible'] ) && $_GET['arch_visible'] == 'grid' ? '2' : '1';
                    ?>
                    <div class="serch-view<?php echo $num; ?>">
                        <div id="appener">
                            <?php
                            $subj = get_queried_object();
                            $query = new WP_Query(array('posts_per_page'=>-1,'cat'=>$subj->cat_ID)); ?>
                            <?php if ( $query->have_posts() ) : $n = 0; while ( $query->have_posts() ) : $query->the_post(); $n++; ?>
                                <?php get_template_part( 'templates/template','search-list' );
                                if( $n%2 == 0){ echo '<div class="clearfix"></div>'; }
                            endwhile; else: ?>
                                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                            <?php endif;
                            wp_reset_query();
                            ?>
                        </div>
                    </div>

                </div>
            </div>



            <div class="clearfix"></div>

        </div>
    </div>

<?php get_footer();