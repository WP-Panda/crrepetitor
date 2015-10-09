<?php
$experience = get_post_meta($post->ID,'az_experience',true);
$az_cost_of_classes = get_post_meta($post->ID,'az_cost_of_classes',true);
$az_extra_charge_for_check_out = get_post_meta($post->ID,'az_extra_charge_for_check_out',true);
$az_proven_teacher = get_post_meta($post->ID,'az_proven_teacher',true);
$az_lesson_time = get_post_meta($post->ID,'az_lesson_time',true);
$az_use_skype_teacher = get_post_meta($post->ID,'az_use_skype_teacher',true);

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

    <a href="javascript:void(0);"><span class="teacher-name" name="modal"><?php the_title() ?></span></a>
    <span class="tec-id-a">[id-<?php echo $post->ID; ?>]</span>
    <div class="t-avatar-block">
        <?php if (!empty($az_use_skype_teacher) ) { ?>
            <div class="skype-serch"></div>
        <?php } ?>
        <?php the_post_thumbnail(array( 149, 150, 'bfi_thumb' => true )); ?>
        <div class="t-chek">
            <?php if(!empty($az_proven_teacher) && $az_proven_teacher == 1 ) { ?>
                Собеседование пройдено <img src="<?php re_img_src('gallochka.png') ?>" alt="">
            <?php } ?>
        </div>
    </div>
    <div class="teacher-raiting">
        <?php $echo =  ! empty( $comments ) ?  $num/$count : 0 ?>
            <?php _e('оценка учеников','wp_panda'); ?>
            <span class="green-big"><?php echo $echo; ?></span>
            <div class="t-line"></div>
            <?php _e('на основе','wp_panda'); ?>
        <?php $count = ! empty ( $count ) ? $count : 0; ?>
        <span class="green-big"><?php echo $count; ?></span>
        <a href="#otzuv-upper" class="upper"><?php echo declOfNum_title( $count, array('отзыва','отзывов','отзывов') ); ?></a>
    </div>
<?php if(!empty($experience)) { ?>
    <div class="teachr-oput"><span>Опыт работы</span><?php echo declOfNum($experience, array(' год', ' года', ' лет'));?></div>
<?php } ?>
<?php if(!empty($az_cost_of_classes)) { ?>
    <div class="teacher-prise">
        <span><?php echo $az_cost_of_classes; ?> руб. / <?php echo $az_lesson_time ?> мин.</span>
        <?php if(!empty($az_extra_charge_for_check_out)) { ?>
            + <?php echo $az_extra_charge_for_check_out; ?> руб. выезд
        <?php } ?>
    </div>
<?php } ?>