<?php global $post,$panda;
$teacher_status = get_post_meta($post->ID,'az_teacher_status',true);

$args = array(
    'submit_button'  => '<input name="%1$s" type="submit" id="%2$s" class="%3$s green-button" value="Отправить" />',
    'must_log_in'          => '',
    'logged_in_as'         => '',
    'comment_notes_before' => '',
    'comment_notes_after'

);

?>
<div id="dialog2" class="window pupup-window">
    <a href="#" class="close"></a>
    <div class="litebox-top">Ваш отзыв о работе репетитора</div>
    <div class="popup-content">
        <div class="popup-otzuv-info">
            Каждый письменный отзыв перед публикацией проходит обязательную проверку на неподдельность. Анонимные сообщения не рассматриваются. Тексты не редактируются и не фильтруются — все прошедшие проверку публикуются «как есть».
        </div>
        <div class="popup-teacher">
            <div class="popup-teacher-foto"><img src="img/avatar1.jpg" alt=""></div>
            <div class="popup-teacher-right">
                <span class="sb-name"><?php echo get_the_title($post->ID); ?></span>
                <span class="sd-info1-work"><?php echo $panda['teacher_status'][$teacher_status] ?></span>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php comment_form( $args, $post->ID ); ?>
    </div>
</div>