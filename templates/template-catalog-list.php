<?php
$count_posts = wp_count_posts();
global $panda;
$map_url = $panda['podbor_url'] ? esc_url($panda['podbor_url']) : 'javascript:void(0);';
?>
<div class="plashka-katalog">
    <div class="wr">


        <?php $args1 = array(
            'hide_empty' => false,
            'orderby' => 'id',
            'order'=> 'DESC',
            'exclude' => 1,
        );

        $myterms1 = get_terms( array( 'category' ), $args1 );
        $count  = 1;
        foreach( $myterms1 as $term ){
            if( 0 == $term->parent) {
                $args1['parent'] = $term->term_id;
                $myterms3 = get_terms( array( 'category' ), $args1 );
                foreach( $myterms3 as $term2 ){
                    $count ++;
                }
            }
        } ?>


        <div class="catalog-title">Выбирайте среди <span><?php echo $count_posts->publish ?></span>
            <?php echo declOfNum_title($count_posts->publish, array(__('преподователя','wp_panda'), __('преподавателей','wp_panda'), __('преподавателей','wp_panda'))) ?> и <span><?php echo $count ?></span>
            <?php echo declOfNum_title($count, array(__('направления','wp_panda'), __('направлений','wp_panda'), __('направлений','wp_panda'))) ?></div>

        <?php

        $args = array(
            'hide_empty' => false,
            'orderby' => 'id',
            'order'=> 'DESC',
            'exclude' => 1,
            'pad_counts'=>true
        );

        $myterms = get_terms( array( 'category' ), $args );
        foreach( $myterms as $term ){
            if( 0 == $term->parent) {
                echo '<div class="catalog-block">';
                echo '<div class="cat-title"><a href="#">' . $term->name .'</a><span>' .  $term->count . '</span></div>';
                echo '<ul>';
                $args['parent'] = $term->term_id;
                $args['pad_counts'] = false;
                $myterms2 = get_terms( array( 'category' ), $args );
                foreach( $myterms2 as $term2 ){
                    $category_link = get_category_link( $term2->term_id );
                    printf('<li><a href="%s?subject=%s">%s</a><span>(%s)</span></li>',esc_url( $panda['podbor_url'] ),$term2->term_id,$term2->name, $term2->count);
                }
                echo '</ul>';
                echo '</div>';
            }
        } ?>
        <div class="clearfix"></div>
        <a href="<?php echo  esc_url( $panda['podbor_url'] ) ?>" class="wihite-button"><?php _e('Посмотреть всех','wp_panda'); ?></a>
    </div>
</div>