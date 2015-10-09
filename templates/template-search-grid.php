<?php
global $panda;
$teacher_status = get_post_meta($post->ID,'az_teacher_status',true);
$experience = get_post_meta($post->ID,'az_experience',true);
$az_cost_of_classes = get_post_meta($post->ID,'az_cost_of_classes',true);
$az_extra_charge_for_check_out = get_post_meta($post->ID,'az_extra_charge_for_check_out',true);
$az_proven_teacher = get_post_meta($post->ID,'az_proven_teacher',true);
$az_lesson_time = get_post_meta($post->ID,'az_lesson_time',true);
$az_use_skype_teacher = get_post_meta($post->ID,'az_use_skype_teacher',true);
$title = get_the_title();
$comments = get_comments(
    array(
        'post_id'=>$post->ID,
        'status'=>'approve'

    )
);
$count = !empty($comments) ? count($comments) : 0;
?>

<div class="serch-item2" data-id="<?php echo $post->ID; ?>">
    <a href="<?php the_permalink(); ?>" class="sb-name"><?php echo $title ?></a>
    <div class="te-id">[id-<?php echo $post->ID; ?>]</div>
    <div class="sb-img-block">
        <?php if (!empty($az_use_skype_teacher) ) { ?>
            <div class="skype-serch"></div>
        <?php } ?>
        <div class="sb-img">
            <?php
            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
            $url = bfi_thumb($thumb[0],array('width'=>149,'height'=>150,'crop'=>true));
            if( empty ( $url ) ) $url =  get_re_img_src('no-avatar.jpg');
            echo '<img src="'.  $url .'">';
            ?>
        </div>
        <div class="sb-chek">
            <?php if(!empty($az_proven_teacher) && $az_proven_teacher == 1 ) { ?>
                Собеседование пройдено <img src="<?php re_img_src('gallochka.png') ?>" alt="">
            <?php } ?>
        </div>
    </div>
    <div class="sd-info1">
        <span class="sd-info1-work"><?php echo $panda['teacher_status'][$teacher_status] ?></span>
        <ul class="sb-predmets">
            <?php
            $n = 1;
            foreach((get_the_category()) as $category) {
                if ($n>2) break;
                echo '<li><span>' .  $category->cat_name . '</span></li>';
                $n ++;
            }
            ?>
        </ul>
        <?php if(count(get_the_category()) > 2 ) { ?>
            <a href="<?php the_permalink(); ?>" class="all-predmets">Все предметы</a>
        <?php } ?>
        <div class="serch-item2-otsenka"><span><?php echo $count ?></span><a href="<?php echo get_the_permalink(); ?>/#otzuv-upper"><?php echo declOfNum_title( $count, array('отзыва','отзывов','отзывов') ); ?></a></div>
    </div>
    <div class="clearfix"></div>
    <div class="serch-item2-end">
        <span><?php echo $az_cost_of_classes; ?> руб. / <?php echo $az_lesson_time ?> мин.</span>
        <a href="#" class="create-anketa go-terach">Связаться</a>
    </div>
    <?php
    if( empty( get_post_meta($post->ID,'prise_60',true) ) ) {
        $prise_60 = (int)$az_cost_of_classes * 60 / (int)$az_lesson_time;
        update_post_meta($post->ID, 'prise_60', $prise_60);
    } ?>
</div>