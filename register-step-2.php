<?php
/**
 * Template Name: Регивстрация Шаг 2
 */
get_header(); ?>

    <div class="inside-content">
        <div class="wr">

            <?php get_template_part( 'templates/template','breadcrumbs' ); ?>

            <div class="registr-page">
                <?php get_template_part( 'templates/template','register-info-block' ); ?>
                <?php get_template_part( 'templates/template','register-form-step-1' ); ?>
            </div>

        </div>
    </div>

<?php get_footer();