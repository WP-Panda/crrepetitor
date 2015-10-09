<?php
/**
 * Template Name: Отзвывы
 */
get_header(); ?>

    <div class="inside-content">
        <div class="wr">

            <div class="breadcrumbs">
                <ul>
                    <li><a href="#">Главная</a></li>
                    <li>Отзывы</li>
                </ul>
            </div>

            <div class="review-page">

                <div class="review-select rf-select">
                    <select id="resal">
                        <?php
                        $args = array(
                            'hide_empty'               => false,
                            'order'                    => 'DESC'
                        );
                        $categories = get_terms( array('category'),$args );
                        if( $categories ){
                            foreach( $categories as $cat ){
                                print_r($cat);
                                if( $cat->parent == 0 ) continue;
                                    if( ! empty( $_GET['id']) &&  $_GET['id'] ==  $cat->term_id )  {
                                        $cge = ' selected="selected"';
                                    } else {
                                        $cge='';
                                    }
                                    echo '<option value="' . $cat->term_id . '"' . $cge .'>' . upFirstLetter($cat->name) .'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <?php  if( ! empty( $_GET['id']) ) echo '<div id="flag" data-flag="' . $_GET['id'] . '"></div>'; ?>

                <div class="review-title">Отзывы о репетиторах "Садись, 5!"</div>
                <div class="clearfix"></div>

                <div class="rev-container">

                    <?php
                    global $post;
                    $comments = get_comments(
                        array(
                            'status'=>'approve',
                            'number' => 1
                        )
                    );
                    $count = count($comments);
                    $n = 1;

                    foreach($comments as $comment){
                        $post_id = $comment->comment_post_ID;
                        if( ! empty( $_GET['id']) && ! in_category(array($_GET['id']),$comment->comment_post_ID ) ) {
                            continue;
                        }
                        ?>
                        <div class="review-item">
                            <div class="rew-item-teacher">
                                <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
                                $url = $thumb['0'];
                                $params = array(
                                    'width' => 71,
                                    'height' => 84,
                                    'crop'=>true
                                );
                                $url = bfi_thumb( $url, $params );
                                ?>
                                <img class="radius-10" src="<?php echo $url; ?>" alt="">
                                <div class="rev-t-info">
                                    <a href="<?php echo get_the_permalink($post_id); ?>" class="rev-t-name"><?php echo get_the_title($post_id); ?></a>
                                    <?php foreach((get_the_category($post_id)) as $category) {
                                        echo '<div class="rev-predmet met"><a class="cater" href="' . get_category_link($category->cat_ID). '">' .  $category->cat_name . '</a></div>';
                                    } ?>
                                </div>
                            </div>
                            <div class="review-text">
                                <?php echo $comment->comment_content; ?>
                            </div>
                            <div class="reviwe-autor">
                                <div class="rev-avtor-name">— <?php echo $comment->comment_author; ?></div>
                                <?php $date =  date( 'd/m/Y ', strtotime( $comment->comment_date ) );
                                $str = explode('/',$date);
                                switch ($str[1]) {
                                    case '01':
                                        $m = 'Января';
                                        break;
                                    case '02':
                                        $m = 'Февраля';
                                        break;
                                    case '03':
                                        $m = 'Марта';
                                        break;
                                    case '04':
                                        $m = 'Апреля';
                                        break;
                                    case '05':
                                        $m = 'Мая';
                                        break;
                                    case '06':
                                        $m = 'Июня';
                                        break;
                                    case '07':
                                        $m = 'Июля';
                                        break;
                                    case '08':
                                        $m = 'Августа';
                                        break;
                                    case '09':
                                        $m = 'Сентября';
                                        break;
                                    case '10':
                                        $m = 'Октября';
                                        break;
                                    case '11':
                                        $m = 'Ноября';
                                        break;
                                    case '12':
                                        $m = 'Декабря';
                                        break;
                                }

                                echo $str[0] . ' ' . $m . ' ' . $str[2];
                                ?>
                            </div>
                        </div>

                    <?php } ?>

                </div>

            </div>

        </div>
    </div>

<?php get_footer();