<?php
/**
 * Template Name: Карта
 */
get_header();
//echo return_points();
get_template_part('templates/template','big-map');
get_template_part('templates/template','map-search');

function map_ini(){
    ?>
    <script>
        ymaps.ready().done(function (ym) {
            var myMape = new ym.Map('YMapsID', {
                center: [47.980359, 46.359042],
                zoom: 10,
                controls: ['zoomControl', 'fullscreenControl']
            }, {
                searchControlProvider: 'yandex#search'
            });

            var geoObjects = ym.geoQuery(<?php echo return_points(); ?>)
                .addToMap(myMape)
                .applyBoundsToMap(myMape, {
                    checkZoomRange: true
                });
        });
    </script>
<?php
}
add_action('wp_footer','map_ini',600);
add_action('wp_footer','bottom_complite',600);
get_footer();