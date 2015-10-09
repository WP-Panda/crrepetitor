<?php global $post,$panda; ?>
<div class="order-item">
    <?php
    $posttags = get_the_tags();
    if ($posttags) {
        foreach($posttags as $tag) {
            echo '<div class="tag-' . $tag->slug  . '">' . $tag->name . '</div>';
        }
    }
    ?>
    <div class="order-status">
        <p>Статус: <span class="green-text">Открыт</span></p>
        <p>Добавлено: <span class="red-text"><?php echo get_the_date('d F Y, H:i'); ?></span></p>
    </div>
    <div class="order-nomer">Номер заявки:<span>№<?php echo $post->ID; ?></span></div>
    <div class="order-name"><?php the_title(); ?></div>

    <div class="order-item-line">
        <div class="order-item-left">
            <div class="order-info oi1">
                <div class="order-info-title">Пол ученика</div>
                <?php
                $sex = get_post_meta($post->ID,'az_teacher_sex',true);
                $sex = $sex =='man' ? 'Мужской' : 'Женский';
                echo $sex;
                ?>
            </div>
        </div>
        <div class="order-item-right">
            <div class="order-info oi2">
                <div class="order-info-title">Возраст (класс)</div>
                <?php
                $az_category_students5= get_post_meta($post->ID,'az_category_students5',true);
                    echo $panda['site_student'][$az_category_students5];

                ?>
            </div>
        </div>
    </div>

    <div class="order-item-line">
        <div class="order-item-left">
            <div class="order-info oi3">
                <div class="order-info-title">Предамет</div>
                <ul class="sb-predmets">
                    <?php
                    $term_list = wp_get_post_terms($post->ID, 'orders_list', array("fields" => "names"));
                    foreach ($term_list as $term ) {
                        echo "<li><span>{$term}</span></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="order-item-right">
            <div class="order-info oi4">
                <div class="order-info-title">Цена занятия</div>
                <div class="order-prise"><?php $xu =  get_post_meta($post->ID,'prise_lesson',0); echo (int)$xu[0]; ?>  руб.</div>
            </div>
        </div>
    </div>

    <div class="order-item-line">
        <div class="order-item-left">
            <div class="order-info oi5">
                <div class="order-info-title">Место занятий</div>
                <?php
                $location = get_post_meta($post->ID,'az_teacher_lesson_location',true);
                if ($location == 'road') {
                    echo 'У ученика';
                } elseif ($location == 'home') {
                    echo 'У Преподавателя';
                } else {
                    echo 'Не Важно';
                }
                $street = get_post_meta($post->ID, 'az_place_of_employment_street',true);
                if( ! empty ($street)){
                    echo ' - ' . $street;
                }
                ?>
            </div>
        </div>
        <div class="order-item-right">
            <div class="order-info oi6">
                <div class="order-info-title">Начало занятий</div>
                <?php
                $date  = get_post_meta($post->ID, 'opt_datepicker_st', true);
                $str = explode('/',$date);
                switch ($str[0]) {
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

                echo $str[1] . ' ' . $m . ' ' . $str[2];

                ?>
            </div>
        </div>
    </div>

    <div class="order-info oi7">
        <div class="order-info-title"><?php _e('Дополнительная информация','wp_panda'); ?></div>
        <?php the_content(); ?>
    </div>

    <div class="order-name cr-icon-map"><?php _e('Ученик на карте','wp_panda'); ?></div>
    <div id="map-order-<?php echo $post->ID; ?>" class="order-map"></div>

    <div class="sb-tel">
        <?php _e('Узнать контакты ученика можно по телефону:','wp_panda'); ?><span><?php echo $panda['phone_2']; ?></span>
    </div>
</div>

<script>
    ymaps.ready(init);

    function init () {
        var myMap = new ymaps.Map("map-order-<?php echo $post->ID; ?>", {
                center: [<?php echo get_post_meta( $post->ID, '_cr_ya_maps_longitude', true); ?>,<?php echo get_post_meta( $post->ID, '_cr_ya_maps_latitude', true); ?>],
                zoom: 14,
                controls:['zoomControl']
            }, {
                searchControlProvider: 'yandex#search'
            }),

        // Создаем геообъект с типом геометрии "Точка".
            myGeoObject = new ymaps.GeoObject({
                // Описание геометрии.
                geometry: {
                    type: "Point",
                    coordinates: [ <?php echo get_post_meta( $post->ID, '_cr_ya_maps_longitude', true); ?>,<?php echo get_post_meta( $post->ID, '_cr_ya_maps_latitude', true); ?>]
                },
                // Свойства.
                properties: {
                    hintContent: '<?php echo get_post_meta( $post->ID, '_cr_ya_maps_street', true); ?>, <?php echo get_post_meta( $post->ID, '_cr_ya_maps_house', true); ?>'
                }
            }, {
                // Опции.
                // Иконка метки будет растягиваться под размер ее содержимого.
                preset: 'islands#dotIcon',
                iconColor: '#3b5998'
            });

        myMap.geoObjects
            .add(myGeoObject)
    }
</script>