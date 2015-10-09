<?php
// Register Custom Taxonomy
function cr_custom_tax() {

    /**
     * Заявки
     */
    $labels = array(
        'name'                       => _x( 'Категории заявок', 'Taxonomy General Name', 'wp_panda' ),
        'singular_name'              => _x( 'Категория заявок', 'Taxonomy Singular Name', 'wp_panda' ),
        'menu_name'                  => __( 'Категории заявок', 'wp_panda' ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'orders_list', array( 'order' ), $args );

    $labels = array(
        'name'                => _x( 'Заявки', 'Post Type General Name', 'wp_panda' ),
        'singular_name'       => _x( 'Заявка', 'Post Type Singular Name', 'wp_panda' ),
    );
    $args = array(
        'label'               => __( 'Заявка', 'wp_panda' ),
        'description'         => __( 'Заявки на обучение', 'wp_panda' ),
        'labels'              => $labels,
        'supports'            => array( ),
        'taxonomies'          => array( 'orders_list,post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'order', $args );


    /**
     * Новости
     */
    $labels = array(
        'name'                       => _x( 'Категории Новостей', 'Taxonomy General Name', 'wp_panda' ),
        'singular_name'              => _x( 'Категория Новости', 'Taxonomy Singular Name', 'wp_panda' ),
        'menu_name'                  => __( 'Категории Новостей', 'wp_panda' ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'news_list', array( 'news' ), $args );

    $labels = array(
        'name'                => _x( 'Новости', 'Post Type General Name', 'wp_panda' ),
        'singular_name'       => _x( 'Новость', 'Post Type Singular Name', 'wp_panda' ),
    );
    $args = array(
        'label'               => __( 'Новости', 'wp_panda' ),
        'description'         => __( 'Новости', 'wp_panda' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'thumbnail', ),
        'taxonomies'          => array( 'news_list' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'news', $args );




    $labels = array(
        'name'                => _x( 'Письма', 'Post Type General Name', 'wp_panda' ),
        'singular_name'       => _x( 'Письмо', 'Post Type Singular Name', 'wp_panda' ),
    );
    $args = array(
        'label'               => __( 'Письмо', 'wp_panda' ),
        'description'         => __( 'Письма на обучение', 'wp_panda' ),
        'labels'              => $labels,
        'supports'            => array(),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'send', $args );


}
add_action( 'init', 'cr_custom_tax', 0 );

add_action('init', 'add_taxonomy_objects');

function add_taxonomy_objects() {
    register_taxonomy_for_object_type('post_tag', 'order');
}

