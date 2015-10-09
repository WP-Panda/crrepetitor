<?php get_header();
global $panda;
//$news = !empty($panda['news_url']) ? $panda['news_url'] : 'javascript:void(0);';
?>
    <div class="inside-content">
        <div class="wr">
            <?php @get_template_part( 'templates/template','breadcrumbs' ); ?>

            <div class="page-content">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <h1><?php the_title(); ?></h1>
                    <div class="news-one-img">
                        <?php the_post_thumbnail( array( 390, 206, 'bfi_thumb' => true ) ); ?>
                    </div>
                    <?php the_content() ?>

                <?php endwhile; else: ?>
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                <?php endif; ?>

            </div>

            <div class="sotsial-icons">
                <?php //get_template_part('templates/template','pluso') ?>
            </div>

            <div class="news-bot-link">
                <a href="<?php echo  get_home_url(); ?>"><?php _e('Перейти на главную','wp_panda') ?></a>
            </div>

        </div>
    </div>
<?php get_footer() ?>