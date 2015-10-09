<?php
global $panda;
$city_district = $panda['city_district'] ? $panda['city_district'] : array();
?>
<form id="lefter-search-order">
    <div class="left-colum-filtr">
        <div class="order-filtr">

            <div class="filtr-select">
                <div class="filtr-title">Предмет</div>
                <select name="subject">
                    <?php
                    $args = array(
                        'hide_empty'               => false,
                        'order'                    => 'DESC'
                    );
                    $categories = get_terms( array('orders_list'),$args );
                    if( $categories ){
                        foreach( $categories as $cat ){
                            if( $cat->parent !=0 )
                                echo '<option value="' . $cat->term_id . '">' . upFirstLetter($cat->name) .'</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="filtr-select">
                <div class="filtr-title">Район</div>
                <select name="district">
                    <?php
                    if ( !empty($city_district) ) {
                        foreach ($city_district as $one)
                            echo '<option value="' . $one . '">' . upFirstLetter($one) . '</option>';
                    } else {
                        echo '<option>' . __('Районы не введены','wp_panda') . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="filtr-radio">
                <div class="filtr-title">Место занятий</div>
                <div class="radio"><input id="r1" type="radio" name="location_lesson" value="all"><label for="r1">Не важно</label></div>
                <div class="radio"><input id="r2" type="radio" name="location_lesson" value="road"><label for="r2">У ученика</label></div>
                <div class="radio"><input id="r3" type="radio" name="location_lesson" value="home"><label for="r3">У репетитора</label></div>
                <!--div class="radio"><input id="r4" type="radio" name="mesto" ><label for="r4">Online (Skype)</label></div-->
            </div>
            <div class="filtr-radio">
                <div class="filtr-title">Экзамены</div>
                <div class="radio"><input id="r5" type="radio" name="tag" value="oge"><label for="r5">Подготовка к ОГЭ</label></div>
                <div class="radio"><input id="r6" type="radio" name="tag" value="ega"><label for="r6">Подготовка к ЕГЭ</label></div>
                <?php /* a href="#" class="minigroup-link">Подготовка в мини группах</a */ ?>
            </div>
            <div class="filtr-radio">
                <div class="filtr-title">Пол Ученика</div>
                <div class="radio"><input id="r7" type="radio" name="sex" value="all"><label for="r7">Не важно</label></div>
                <div class="radio"><input id="r8" type="radio" name="sex" value="man"><label for="r8">Мужской</label></div>
                <div class="radio"><input id="r9" type="radio" name="sex" value="woman"><label for="r9">Женский</label></div>
            </div>
            <?php /* div class="filtr-to-results">
            <a href="#filtr-result" class="green-button2 filtr-to-results-btn">Показать результат</a>
        </div */ ?>
        </div>
    </div>
</form>