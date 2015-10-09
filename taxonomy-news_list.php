<?php
get_header(); ?>
    <div class="inside-content">
        <div class="wr">
            <h1>Новости</h1>
            <?php if ( have_posts() ) : $n=0; while ( have_posts() ) : the_post(); $n++; ?>

                <div class="news-page-item">
                    <div class="news-img"><a href="<?php echo get_the_permalink(); ?>"><?php echo the_post_thumbnail( array( 390, 206, 'bfi_thumb' => true ) ); ?></a></div>
                    <span class="news-date">Добавлено <?php echo get_the_date('n.j.Y'); ?></span>
                    <a href="<?php echo get_the_permalink(); ?>" class="news-link"><?php the_title(); ?></a>
                    <?php the_excerpt(); ?>
                </div>
                <?php if( $n%2 == 0 ) { ?>
                    <div class="clearfix"></div>
                <?php
                }
            endwhile; else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
            <?php endif; ?>

            <div class="clearfix"></div>

        </div>
    </div>
<?php get_footer();