<div class="otzuv-block upper" id="otzuv-upper">
    <div class="otzuv-title">Отзывы о репетиторе:</div>
    <?php
    global $post;
    $comments = get_comments(
        array(
            'post_id'=>$post->ID,
            'status'=>'approve'

        )
    );
    $count = count($comments);
    $n = 1;

    foreach($comments as $comment){

    if($n == 4) { ?> <div class="odzuv-hide" style="display:none;"> <?php } ?>
        <div class="otzuv-item">
            <div class="otzuv-text">
                <p><?php echo $comment->comment_content; ?></p>
                <span><?php echo date( 'd.m.Y ', strtotime( $comment->comment_date ) ); ?></span>
            </div>
            <div class="otzuv-autor"><?php echo $comment->comment_author; ?></div>
            <div class="otzuv-raiting"><?php _e('Оценка:','wp_panda') ?><span><?php echo get_comment_meta( $comment->comment_ID, 'rating', true ); ?></span></div>
            <div class="clearfix"></div>
        </div>

        <?php
        if( $n == $count &&  $n >4) { echo '</div>'; }
        $n++;
        }
        ?>

    </div>