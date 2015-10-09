<div class="serch-seo">
    <?php
    if(is_page()) {
        printf(__('<h1>Подбор репетиторов</h1>', 'wp_panda'));
    } else {
        printf(__('<h1>%s - репетиторы</h1>', 'wp_panda'), single_cat_title('', false));
        $num = wp_get_cat_postcount();
        printf(__('<span class="n-repetitor"> %1s - %2s </span>', 'wp_panda'), $num, declOfNum_title($num, array('репетитор', 'репетитора', 'репетиторов')));
    }
    ?>
    <p>
        <?php
        $text =  category_description();
        if($text) {
            //echo $text;
            $desc = $text . " ";
            $l = intval(strlen($desc) / 2 + strlen($desc) * 0.02);
            $desc = preg_replace("[\r\n]", " ", $desc);
            preg_match_all("/(.{1,$l})[ \n\r\t]+/", $desc, $descArray);
            echo $descArray[1][0];
            ?>
            <a href="javascript:void(0);" class="serch-read-more">далее</a> <span class="search-rmblock" style="display:none;"><?php echo $descArray[1][1]; ?></span>

        <?php } ?>
    </p>
</div>
