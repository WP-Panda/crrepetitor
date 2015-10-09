<?php get_header() ?>
<div class="inside-content">
    <div class="wr">
        <?php @get_template_part( 'templates/template','breadcrumbs' ); ?>
        <div class="page-content">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <div class="teacher-left teacher">
                    <?php get_template_part( 'templates/template','teacher-short-info' ); ?>
                    <?php get_template_part( 'templates/template','teacher-revews' ); ?>
                    <?php get_template_part( 'templates/template','teacher-feedback-button' ); ?>

                    <div class="clearfix"></div>
                </div>
                <div class="teacher-right">
                    <?php get_template_part( 'templates/template','teacher-full-info' ); ?>
                    <div class="clearfix"></div>
                </div>
            <?php endwhile; else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
            <?php endif; ?>

        </div>
        <div class="clearfix"></div>
        <div class="teacher"> <!-- копия отзывов для тачскринов -->
            <?php get_template_part( 'templates/template','tachscreen-revews' ); ?>
            <?php get_template_part( 'templates/template','teacher-more-info' ); ?>
        </div>

        <div class="clearfix"></div>
    </div>
</div>
<div id="boxes">
<?php get_template_part( 'templates/template','form-feedback' ); ?>
</div>
<?php get_footer() ?>
