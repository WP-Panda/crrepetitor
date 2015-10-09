<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <meta name="viewport" content="width=device-width, user-scalable=no">


    <?php wp_head(); ?>

    <!--[if lte IE 6 ]><script type="text/javascript">window.location.href="ie6_close/index_ru.html";</script><![endif]-->
    <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="css/all-ie.css"><![endif]-->
    <!--[if lt IE 10]><script type="text/javascript" src="js/pie.js"></script><![endif]-->
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&coordorder=longlat" type="text/javascript"></script>
</head>
<body <?php body_class();?>>
<?php get_template_part( 'templates/template','scroll-top' ); ?>
<div class="wrapper">
    <?php global $panda;
    $logo = $panda['custom_logo'] ? ' style="background-image:url(' . $panda['custom_logo']['url'] .')"' : '';
    ?>
    <header <?php re_head_class() ?> role="banner">
        <div class="wr">
            <a href="<?php echo get_home_url('/');?>" class="site-logo"<?php echo $logo; ?>></a>
            <?php get_template_part( 'templates/template','city-select-top' ); ?>
            <?php get_template_part( 'templates/template','contacts-top' ); ?>
            <?php get_template_part( 'templates/template','buttons-top' ); ?>
            <div class="clearfix"></div>
            <?php
            if(is_front_page())
                get_template_part( 'templates/template','tiches-select-top' );
            ?>
            <?php
            if((is_singular() && !is_page_template(array('map-page.php','register-step-1.php'))) || is_archive())
                get_template_part( 'templates/template','top-form' );
            ?>
            <?php if( is_page_template('register-step-1.php'))
                get_template_part( 'templates/template','register-title' );
            ?>

        </div>
    </header><!--.header-->