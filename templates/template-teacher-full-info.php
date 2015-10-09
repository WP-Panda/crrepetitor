<?php
global $panda;
$az_education_of_the_teacher = get_post_meta($post->ID,'az_education_of_the_teacher',true);
$az_place_of_work = get_post_meta($post->ID,'az_place_of_work',true);
$az_category_students5 = get_post_meta($post->ID,'az_category_students5',true);
$az_areas_of_the_county5 = get_post_meta($post->ID,'az_areas_of_the_county5',true);
$az_place_of_employment = get_post_meta($post->ID,'az_place_of_employment',true);
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
$thumb_url = bfi_thumb($thumb[0],array( 'width' => 35, 'height' => 41, 'crop' => true ));
$teacher_status = get_post_meta($post->ID,'az_teacher_status',true);
$dol =  get_post_meta($post->ID,'az_place_of_employment_dol',true);
$shir =  get_post_meta($post->ID,'az_place_of_employment_shir',true);
$city = get_post_meta($post->ID,'az_place_of_employment_city',true);
$street = get_post_meta($post->ID,'az_place_of_employment_street',true);
$house = get_post_meta($post->ID,'az_place_of_employment_house',true);
$az_teacher_lesson_location = get_post_meta($post->ID,'az_teacher_lesson_location',true);
if( $az_teacher_lesson_location  == 'all' ) {
    $lesson = __('У меня или у ученика','wp_panda');
} elseif( $az_teacher_lesson_location  == 'home' ) {
    $lesson = __('У меня','wp_panda');
} else {
    $lesson = __('У ученика','wp_panda');
}

$posttags = get_the_tags();
?>
    <div class="t-right-info fogr" data-id="<?php echo $post->ID; ?>">
        <div class="t-right-button">
            <a href="javascript:void(0);" class="green-button2 send-ticher">Связаться с репетитором</a>
        </div>
        <span class="sd-info1-work"><?php echo $panda['teacher_status'][$teacher_status] ?></span>
        <ul class="sb-predmets">
            <?php foreach((get_the_category()) as $category) {
                echo '<li><span>' .  $category->cat_name . '</span></li>';
            } ?>
        </ul>

        <?php if(!empty($az_education_of_the_teacher)) { ?>
            <div class="sb-moreinfo sb-moreinfo-1">
                <span>Образование</span>
                <?php foreach( $az_education_of_the_teacher as $one)
                    echo "<p>{$one}</p>"
                ?>
            </div>
        <?php } ?>

        <?php if(!empty($az_place_of_work)) { ?>
            <div class="sb-moreinfo sb-moreinfo-5">
                <span>Место работы</span>
                <?php foreach($az_place_of_work as $work){
                    echo $work .'<br>';
                } ?>
            </div>
        <?php } ?>

        <?php if(!empty($az_category_students5)) { ?>
            <div class="sb-moreinfo sb-moreinfo-6">
                <span>Категория учеников</span>
                <?php foreach( $az_category_students5 as $one=>$key)
                    if($key == 1)
                        echo "<p>" . $panda['site_student'][(int)$one - 1] ."</p>"
                ?>
            </div>
        <?php } ?>

        <?php if(!empty($posttags)) {
            $count = count($posttags);
            ?>
            <div class="sb-moreinfo sb-moreinfo-7">
                <span>Готовлю к экзаменам</span>
                <?php
                $n = 1;
                foreach($posttags as $tag) {
                    echo $tag->name;
                    if($n !== $count)
                        echo ', ';
                    $n++;
                }
                ?>
            </div>
        <?php } ?>
    </div>
    <div class="teech-plase">Место занятий</div>
    <span class="sb-moreinfo-99"><?php echo $lesson; ?></span>
<?php if($az_teacher_lesson_location  !== 'road') {
    ?>
    <div class="teacher-map">
        <div id="map" class="teache-map-2" style="height:350px;"></div>
    </div>
    <?php
    $cener = !empty($shir) && !empty($dol) ? $shir . ',' . $dol : '55.753994,37.622093';
    $obj = !empty($shir) && !empty($dol) ? $shir . ',' . $dol : $city . ', ' . $street . ', ' . $house;
    ?>
    <script>

        ymaps.ready(init);

        function init() {
            var myMap = new ymaps.Map('map', {
                center: [<?php echo $cener; ?>],
                zoom: 15,
                controls:[]
            });

            ymaps.geocode('<?php echo $obj; ?>', {
                results: 1
            }).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0),
                    coords = firstGeoObject.geometry.getCoordinates(),
                    bounds = firstGeoObject.properties.get('boundedBy');
                myMap.geoObjects.add(firstGeoObject);
                myMap.setBounds(bounds, {
                    checkZoomRange: true
                });

                var myPlacemark = new ymaps.Placemark(coords, {
                }, {
                    iconLayout: 'default#image',
                    iconImageHref: '<?php echo $thumb_url ?>',
                    iconImageSize: [35, 41],
                    iconImageOffset: [-18, -62]
                });

                myMap.geoObjects.add(myPlacemark);

                var myPlacemark = new ymaps.Placemark(coords, {
                    //balloonContent: '<?php echo  $street . ', ' . $house; ?>'

                }, {
                    iconLayout: 'default#image',
                    iconImageHref: '<?php re_img_src('map-pointer.png') ?>',
                    iconImageSize: [58, 75],
                    iconImageOffset: [-30, -70],
                    //hideIconOnBalloonOpen: false,
                    //balloonOffset: [0, -67]
                });

                myMap.geoObjects.add(myPlacemark);

            });
        }

    </script>
<?php } ?>
    <div class="t-right-info">


        <?php if(!empty($az_areas_of_the_county5)) {
            $az_areas_of_the_county5 = array_filter($az_areas_of_the_county5);
            $count = count($az_areas_of_the_county5);
            if ($count > 0) { ?>
                <div class="sb-moreinfo sb-moreinfo-4">
                    <span>Районы выезда:</span>
                    <?php

                    $n = 1;
                    foreach ($az_areas_of_the_county5 as $key => $val) {
                        $coma = $n !== $count ? ', ' : '';
                        echo $panda['city_district'][(int)$key - 1] . $coma;
                        $n++;
                    } ?>
                </div>
            <?php }
        } ?>
        <div class="sb-moreinfo sb-moreinfo-8">
            <span>О себе</span>
            <?php the_content() ?>
        </div>
    </div>
    <div class="clearfix"></div>
<?php if($panda['phone_2']) { ?>
    <div class="sb-tel">
        Записаться на занятия по телефону:<span><?php echo $panda['phone_2'] ?></span>
    </div>
<?php } ?>