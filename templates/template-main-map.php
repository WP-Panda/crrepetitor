<?php
global $panda;
$map_url = $panda['map_url'] ? esc_url($panda['map_url']) : 'javascript:void(0);';
?>
<div class="map-block">
    <div id="text-mapper"> <h3>ВСЕ РЕПЕТИТОРЫ ГОРОДА<br>НА ОДНОЙ КАРТЕ</h3></div>
    <div id="map" style="width:100%; height:500px"></div>

    <div id="mapper">
        <div id="new_map"></div>
    </div>

    <div id="upper">
        <ul class="map-list">
            <?php
            $args = array(
                'meta_query' => array(
                    'posts_per_page' => 3,
                    array(
                        'key' => 'az_in_home',
                        'value' => 1
                    )
                )
            );

            $query = new WP_Query($args);
            if ( $query->have_posts() ) : $n =0; while ( $query->have_posts() ) : $query->the_post(); $n++;
                $title = get_the_title();

                $class = $n == 1 ? ' active' : '';
                if ($n == 1) {
                    $coeff = 'one';
                } elseif ($n == 2) {
                    $coeff = 'two';
                } else {
                    $coeff = 'three';
                }

                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
                $thumb_url = bfi_thumb($thumb[0],array( 'width' => 35, 'height' => 41, 'crop' => true ));
                $catert = get_the_category($post->ID);

                ?>
                <li class="goto too-map<?php echo $class; ?>" data-goto="<?php echo $coeff ?>" data-img="<?php echo $thumb_url; ?>"><img src="<?php re_img_src('m1.png') ?>" alt=""><?php echo $title; ?><span><?php echo $catert[0]->cat_name ?></span></li>
            <?php endwhile; else: endif; wp_reset_query(); ?>
        </ul>
        <a href="<?php echo $map_url ?>" class="green-button">Посмотреть всех</a>
    </div>

</div>


<script>
    ymaps.ready(initk);
    function initk() {
        var destinations = {};
        <?php
            if ( $query->have_posts() ) : $n =0; while ( $query->have_posts() ) : $query->the_post(); $n++;
            if ($n == 1) {
                $coeff = 'one';
                 $thumb1 = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
                $thumb_url1 = bfi_thumb($thumb1[0],array( 'width' => 35, 'height' => 41, 'crop' => true ));
            } elseif ($n == 2) {
                $coeff = 'two';
            } else {
                $coeff = 'three';
            }
            ?>
        destinations['<?php echo $coeff ?>'] = [<?php echo get_post_meta($post->ID,'az_place_of_employment_shir',true) ?>,<?php echo get_post_meta($post->ID,'az_place_of_employment_dol',true) ?>];
        <?php endwhile; else: endif; wp_reset_query(); ?>


        newMap = new ymaps.Map('new_map', {
            center:  destinations['one'], //one
            zoom: 15,
            controls: [
            ]
        });
        myGeoObjects = new ymaps.GeoObject();
        newMap.geoObjects.add(myGeoObjects).add(new ymaps.Placemark( destinations['one'], {
        }, {
            iconLayout: 'default#image',
            iconImageHref: '<?php echo $thumb_url1 ?>',
            iconImageSize: [35, 41],
            iconImageOffset: [-18, -62]
        }));

        newMap.geoObjects.add(new ymaps.Placemark(destinations['one'], {
        }, {
            iconLayout: 'default#image',
            iconImageHref: '<?php re_img_src('map-pointer.png') ?>',
            iconImageSize: [58, 75],
            iconImageOffset: [-30, -70],
            hideIconOnBalloonOpen: false,
            balloonOffset: [0, -67]
        }));


        myMap = new ymaps.Map('map', {
            center: destinations['one'],
            zoom: 13,
            controls: [
            ]
        });
        myGeoObject = new ymaps.GeoObject();
        myMap.geoObjects.add(myGeoObject)

            <?php
              if ( $query->have_posts() ) : $n =0; while ( $query->have_posts() ) : $query->the_post(); $n++;
              if ($n == 1) {
                  $coeff = 'one';
              } elseif ($n == 2) {
                  $coeff = 'two';
              } else {
                  $coeff = 'three';
              }

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
            $thumb_url = bfi_thumb($thumb[0],array( 'width' => 35, 'height' => 41, 'crop' => true ));
               ?>
            .add(new ymaps.Placemark(destinations['<?php echo $coeff; ?>'], {
            }, {
                iconLayout: 'default#image',
                iconImageHref: '<?php echo $thumb_url ?>',
                iconImageSize: [35, 41],
                iconImageOffset: [-18, -62]
            }))

            .add(new ymaps.Placemark(destinations['<?php echo $coeff; ?>'], {
            }, {
                iconLayout: 'default#image',
                iconImageHref: '<?php re_img_src('map-pointer.png') ?>',
                iconImageSize: [58, 75],
                iconImageOffset: [-30, -70],
                hideIconOnBalloonOpen: false,
                balloonOffset: [0, -67]
            }))

        <?php endwhile; else: endif; wp_reset_query(); ?>


        function clickGoto() {
            var pos = this.getAttribute('data-goto');
            myMap.panTo(destinations[pos], {
                flying: 1
            });
            return false;
        }
        var col = document.getElementsByClassName('goto');
        for (var i = 0, n = col.length; i < n; ++i) {
            col[i].onclick = clickGoto;
        }
        $('.too-map').bind({
            click: function () {
                $(this).addClass('active').siblings().removeClass('active');;
                var pos = this.getAttribute('data-goto');
                $('#new_map').empty();
                mytMap = new ymaps.Map('new_map', {
                    center: destinations[pos],
                    zoom: 15,
                    controls: []
                });
                myGeoObjects = new ymaps.GeoObject();
                mytMap.geoObjects.add(myGeoObjects).add(new ymaps.Placemark(destinations[pos], {
                },{
                    iconLayout: 'default#image',
                    iconImageHref: this.getAttribute('data-img'),
                    iconImageSize: [35, 41],
                    iconImageOffset: [-18, -62]
                }));

                mytMap.geoObjects.add(new ymaps.Placemark(destinations[pos], {
                }, {
                    iconLayout: 'default#image',
                    iconImageHref: '<?php re_img_src('map-pointer.png') ?>',
                    iconImageSize: [58, 75],
                    iconImageOffset: [-30, -70],
                    hideIconOnBalloonOpen: false,
                    balloonOffset: [0, -67]
                }));

            }
        });
    }

</script>