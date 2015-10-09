<?php
$category = get_the_category();
$array = array(
    'category__in' => $category[0]->cat_ID,
    'posts_per_page' => 2,
    'post__not_in' => array($post->ID)
);

$new_query = new WP_Query($array);

if( $new_query->have_posts() ) : $n = 0; while ( $new_query->have_posts() ) : $new_query->the_post(); $n++;
    $class = $n==1 ? 'left' : 'right';
    $az_cost_of_classes = get_post_meta($post->ID,'az_cost_of_classes',true);
    $az_proven_teacher = get_post_meta($post->ID,'az_proven_teacher',true);
    ?>
    <div class="more-item more-item-block<?php echo $class; ?>">
        <div class="sb-img-block">
            <div class="sb-img">
                <?php the_post_thumbnail( array( 149, 150, 'bfi_thumb' => true ) ); ?>
            </div>
            <div class="sb-chek">
                <?php if(!empty($az_proven_teacher) && $az_proven_teacher == 1 ) { ?>
                    Собеседование пройдено <img src="<?php re_img_src('gallochka.png') ?>" alt="">
                <?php } ?>
            </div>
        </div>
        <div class="more-item-right">
            <a href="<?php the_permalink(); ?>" class="more-item-name"><?php the_title();?></a>
            Преподаватель вуза
            <div class="more-item-raiting">
                <div class="more-raiting"><span class="green-big">8.7</span>рейтинг</div>
                <div class="t-line2"></div>
                <div class="more-otzuv"><span class="green-big">2</span><a href="#">отзыва</a></div>
                <div class="clearfix"></div>
            </div>
            <?php if(!empty($az_cost_of_classes)) { ?>
                <div class="more-teacher-prise"><?php echo $az_cost_of_classes; ?> руб. / 60 мин.</div>
            <?php } ?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php endwhile; else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif;
wp_reset_query();
?>