<?php global $panda;
$news = !empty($panda['news_url']) ? $panda['news_url'] : 'javascript:void(0);';
?>
<div class="news-block">
    <div class="wr">
        <h3><?php _e('НОВОСТИ СЛУЖБЫ','wp_panda') ?></h3>

        <?php
        $array = array('post_type'=>'news','posts_per_page'=>2);
        $query = new WP_Query($array);
        if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

            <div class="news-item">
                <?php the_post_thumbnail( array( 100, 100, 'bfi_thumb' => true ) ); ?>
                <div class="news-text">
                    <a href="<?php echo get_the_permalink() ?>"><?php the_title(); ?></a>
                    <?php the_excerpt(); ?>
                </div>
            </div>

        <?php endwhile; else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif; wp_reset_query(); ?>



        <div class="clearfix"></div>

        <div class="all-news">
            <a href="<?php echo $news ?>" class="all-news-link"><?php _e('Читать все новости','wp_panda') ?></a>
        </div>
    </div>
</div>