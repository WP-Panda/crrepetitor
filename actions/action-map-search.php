<?php
add_action( 'wp_ajax_map_searcher', 'map_searcher_callback' );
add_action( 'wp_ajax_nopriv_map_searcher', 'map_searcher_callback' );
function map_searcher_callback() {
    check_ajax_referer( 'cr-special-string', 'security' );
    $name = $_POST['val'];
    $term = get_term_by('name', $name, 'category');
    echo return_points($term->term_id);
    wp_die();
}