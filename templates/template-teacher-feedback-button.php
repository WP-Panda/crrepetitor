<?php $comments = get_comments(
    array(
        'post_id'=>$post->ID,
        'status'=>'approve'

    )
); ?>
<div class="teacher-left-links upper">
    <a href="#dialog2" class="send-otzuv modal-absolute" name="modal">Оставить отзыв</a>
    <?php if(count($comments)>3) { ?>
        <a href="javascript:void(0);" class="all-otzuv">Все отзывы</a>
    <?php } ?>
    <div class="clearfix"></div>
</div>