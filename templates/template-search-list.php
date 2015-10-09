<?php
global $panda;
$az_education_of_the_teacher = get_post_meta($post->ID,'az_education_of_the_teacher',true);
$teacher_status = get_post_meta($post->ID,'az_teacher_status',true);
$experience = get_post_meta($post->ID,'az_experience',true);
$az_cost_of_classes = get_post_meta($post->ID,'az_cost_of_classes',true);
$az_extra_charge_for_check_out = get_post_meta($post->ID,'az_extra_charge_for_check_out',true);
$az_proven_teacher = get_post_meta($post->ID,'az_proven_teacher',true);
$az_lesson_time = get_post_meta($post->ID,'az_lesson_time',true);
$az_use_skype_teacher = get_post_meta($post->ID,'az_use_skype_teacher',true);
$az_areas_of_the_county5 = get_post_meta($post->ID,'az_areas_of_the_county5',true);
$az_teacher_lesson_location = get_post_meta($post->ID,'az_teacher_lesson_location',true);
$title = get_the_title();
if( $az_teacher_lesson_location  == 'all' ) {
    $lesson = __('У меня или у ученика','wp_panda');
    $hreffer = ' - <a href="' . get_the_permalink() .'/#map">Посмотреть на карте</a>';
} elseif( $az_teacher_lesson_location  == 'home' ) {
    $lesson = __('У меня','wp_panda');
    $hreffer = ' - <a href="' . get_the_permalink() .'/#map">Посмотреть на карте</a>';
} else {
    $lesson = __('У ученика','wp_panda');
    $hreffer = '';
}

$comments = get_comments(
    array(
        'post_id'=>$post->ID,
        'status'=>'approve'

    )
);

if ( ! empty( $comments ) ) {
    $count = count($comments);
    $num = 0;
    foreach ($comments as $comment) {
        $num = (int)get_comment_meta($comment->comment_ID, 'rating', true) + (int)$num;
    }
}

?>
<div class="search-item rep-<?php echo $post->ID ?>" data-id="<?php echo $post->ID ?>">
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
    <a href="<?php the_permalink(); ?>" class="sb-name"><?php echo $title ?></a>
    <span class="tec-id"><?php echo '  [id-' . $post->ID. ']' ?></span>

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
    </div>

    <div class="sb-right">
        <a href="javascript:void(0);" class="green-button2 send-ticher">Связаться с репетитором</a>
        <div class="sb-prise"><?php echo $az_cost_of_classes; ?> руб. / <?php echo $az_lesson_time ?> мин.</div>
        <div class="sb-right-info">
            <div class="sb-right-taiting">
                <?php if( ! empty( $count ) )  { ?>
                    Оценка учеников
                    <span class="green-big"><?php echo $num/$count ?></span>
                <?php } ?>
            </div>
            <?php if( ! empty( $count ) )  { ?>
                на основе
            <?php }
            $count = !empty($count) ? $count : 0;
            ?>
            <span class="green-big"><?php echo $count ?></span>
            <a href="<?php echo get_the_permalink(); ?>/#otzuv-upper"><?php echo declOfNum_title( $count, array('отзыва','отзывов','отзывов') ); ?></a>
        </div>
    </div>

    <div class="clearfix"></div>
    <?php if(!empty($az_education_of_the_teacher)) { ?>
        <div class="sb-moreinfo sb-moreinfo-1">
            <span>Образование</span>
            <?php foreach( $az_education_of_the_teacher as $one)
                echo "<p>" . $one ."</p>"
            ?>
        </div>
    <?php } ?>

    <?php if ( ! empty( $experience ) ) { ?>
        <div class="sb-moreinfo sb-moreinfo-2">
            <span>Опыт работ</span>
            <?php echo declOfNum( $experience , array('год','года','лет') ) ?>
        </div>
    <?php } ?>
    <div class="sb-moreinfo sb-moreinfo-3">
        <span>Место занятий</span>
        <?php echo $lesson  . $hreffer; ?>
    </div>
    <?php if(!empty($az_areas_of_the_county5) && in_array(1,$az_areas_of_the_county5)) {
        $az_areas_of_the_county5 = array_filter($az_areas_of_the_county5); ?>
        <div class="sb-moreinfo sb-moreinfo-4">
            <span>Районы выезда:</span>
            <?php
            $count = count($az_areas_of_the_county5);
            $n = 1;
            foreach ( $az_areas_of_the_county5 as $key=>$val) {
                $coma = $n !== $count ? ', ' : '';
                echo $panda['city_district'][(int)$key - 1].$coma;
                $n++;
            }?>
        </div>
    <?php }  ?>

    <div class="clearfix"></div>
    <div class="sb-tel">
        Записаться на занятия по телефону:<span><?php echo $panda['phone_2'] ?></span>
    </div>
</div>