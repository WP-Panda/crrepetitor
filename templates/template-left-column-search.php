<?php
global $panda;
$map_url = $panda['map_url'] ? esc_url($panda['map_url']) : 'javascript:void(0);';
$city_district = $panda['city_district'] ? $panda['city_district'] : array();
?>
<div class="left-colum-filtr">
    <div class="search-filtr">
        <div class="filtr-map">
            <div class="filtr-title"><?php _e('Репетиторы на карте','wp_panda'); ?></div>
            <img src="<?php re_img_src('serch-map.png'); ?>" alt="">
            <a href="<?php echo $map_url ?>" class="create-anketa"><?php _e('Посмотреть','wp_panda'); ?></a>
        </div>

        <form id="lefter-search">
            <div class="filtr-select">
                <div class="filtr-title"><?php _e('Предмет','wp_panda'); ?></div>
                <select name="subject" data-placeholder="Выберите предмет">
                    <?php
                    echo '<option></option>';
                    $args = array(
                        'hide_empty'               => 0,
                        'exclude'                  => 1,
                        'order'                    => 'DESC'
                    );
                    $categories = get_categories( $args );
                    if( $categories ){
                        foreach( $categories as $cat ){
                            if( $cat->category_parent !== 0 )
                                $selected = ( !empty($_POST['lesson']) && $cat->name == $_POST['lesson'] ) ? ' selected="selected"' : '';
                                echo '<option value="' . $cat->cat_ID . '"'. $selected .'>' . upFirstLetter($cat->name) .'</option>';
                        }
                    }
                    ?>
                </select>

            </div>
            <div class="filtr-select">
                <div class="filtr-title"><?php _e('Район','wp_panda'); ?></div>
                <select name="district" data-placeholder="Выберите район">
                    <?php
                    echo '<option></option>';
                    if ( !empty($city_district) ) {
                        $n=1;
                        foreach ($city_district as $one=>$key) {
                            echo '<option value="' . $n . '">' . upFirstLetter($key) . '</option>';
                            $n++;
                        }
                    } else {
                        echo '<option>' .  __('Районы не введены','wp_panda') .'</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="filtr-radio">
                <div class="filtr-title"><?php _e('Место занятий','wp_panda'); ?></div>
                <div class="radio"><input id="r1" type="radio" name="location" value="all"><label for="r1"><?php _e('Не важно','wp_panda'); ?></label></div>
                <div class="radio"><input id="r2" type="radio" name="location" value="road"><label for="r2"><?php _e('У меня','wp_panda'); ?></label></div>
                <div class="radio"><input id="r3" type="radio" name="location" value="home"><label for="r3"><?php _e('У репетитора','wp_panda'); ?></label></div>
                <div class="radio"><input id="r4" type="radio" name="location" value="skipe"><label for="r4"><?php _e('Online (Skype)','wp_panda'); ?></label></div>
            </div>
            <div class="filtr-radio">
                <div class="filtr-title"><?php _e('Экзамены','wp_panda'); ?></div>
                <div class="radio"><input id="r5" type="radio" name="ek" value="oge"><label for="r5"><?php _e('Подготовка к ОГЭ','wp_panda'); ?></label></div>
                <div class="radio"><input id="r6" type="radio" name="ek" value="ega"><label for="r6"><?php _e('Подготовка к ЕГЭ','wp_panda'); ?></label></div>
                <?php /* a href="#" class="minigroup-link">Подготовка в мини группах</a */ ?>
            </div>
            <div class="filtr-radio">
                <div class="filtr-title"><?php _e('Пол репетитора','wp_panda'); ?></div>
                <div class="radio"><input id="r7" type="radio" name="pol" value="all"><label for="r7"><?php _e('Не важно','wp_panda'); ?></label></div>
                <div class="radio"><input id="r8" type="radio" name="pol" value="man"><label for="r8"><?php _e('Мужчина','wp_panda'); ?></label></div>
                <div class="radio"><input id="r9" type="radio" name="pol" value="woman"><label for="r9"><?php _e('Женщина','wp_panda'); ?></label></div>
            </div>

        </form>

    </div>
    <div id="fixed" class="hidden-nodesktop">
        <form id="fast-fast-search">
            <div class="filtr-form">
                <div class="ff-title"><?php _e('Бесплатная помощь  в подборе','wp_panda'); ?></div>
                <div class="ff-text"><?php _e('Оставьте ваш телефон, в течение 20 минут мы перезвоним','wp_panda'); ?></div>
                <div class="main-form">
                    <input type="text" placeholder="Ваш телефон" class="tel" id="phone" >
                    <input type="submit" class="green-button" value="<?php _e('Подобрать','wp_panda'); ?>" />
                    <div class="clearfix"></div>
                </div>
            </div>
        </form>
    </div>
</div>