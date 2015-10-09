<?php
/**
 * Template Name: Регивстрация Шаг 3
 */
global $panda;
if( empty($_SESSION['reg'])){
    wp_redirect($panda['two_step_url']);
}
get_header(); ?>

    <div class="inside-content">
        <div class="wr">

            <?php get_template_part( 'templates/template','breadcrumbs' ); ?>
            <?php
            if( isset($_SESSION['reg'] ) )
               // echo $_SESSION['reg'];
            ?>
            <div class="registr-page">
                <?php get_template_part( 'templates/template','register-form-step-2' ); ?>
            </div>
        </div>
    </div>
<?php get_footer();