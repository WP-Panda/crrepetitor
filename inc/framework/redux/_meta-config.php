<?php 
$redux_opt_name = "panda";



if ( !function_exists( "redux_add_metaboxes" ) ):
    function redux_add_metaboxes($metaboxes) {

        // Global panda
        global $options_panda;
        //$panda;

        // года
        $year = array();
        $x=0;
        while ($x++<50) $year[$x] = declOfNum($x, array(' год', ' года', ' лет'));

        //районы
        $district_array = array();
        $city_district = $options_panda['city_district'] ? $options_panda['city_district'] : array('Введите районы в панели');
          /*  foreach ($city_district as $one)
                $district_array[$one] = $one;*/

        $prefix = 'az_';

        // Define arrays
        $metaboxes = array();

        // Revolution Slider
        include_once(ABSPATH.'wp-admin/includes/plugin.php');


        /*-----------------------------------------------------------------------------------*/
        /*  - Logo & Menu
        /*-----------------------------------------------------------------------------------*/
        $main_settings[] = array(
            'title'     => __( 'Данные преподавателя', 'wp_panda' ),
            'icon'      => 'el-icon-adult',
            'fields'    => array(

                array(
                    'id'       => $prefix . 'experience',
                    'type'     => 'select',
                    'title'    => __( 'Опыт работы', 'redux-framework-demo' ),
                    'subtitle' => __( 'Выберите опыт работы в годах', 'redux-framework-demo' ),
                    'options'  => $year,
                    'default'  => '2'
                ),

                array(
                    'id'       => $prefix . 'cost_of_classes',
                    'type'     => 'text',
                    'title'    => __( 'Стоимость занятия', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите стоимость за час занятия', 'redux-framework-demo' )
                ),

                array(
                    'id'       => $prefix . 'extra_charge_for_check_out',
                    'type'     => 'text',
                    'title'    => __( 'Наценка за выезд', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите наценку за выездные занятия', 'redux-framework-demo' )
                ),

                array(
                    'id'        =>  $prefix . 'education_of_the_teacher',
                    'type'      =>  'textarea',
                    'title'     =>  __( 'Образование', 'wp_panda' ),
                    'subtitle'  =>  __( 'Введите данные об образовании.', 'wp_panda' ),
                    'default'   =>  '',
                ),

                array(
                    'id'       => $prefix . 'place_of_work',
                    'type'     => 'multi_text',
                    'title'    => __( 'Место работы', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите места работы', 'redux-framework-demo' ),
                ),

                array(
                    'id'            => $prefix . 'category_students5',
                    'type'          => 'slider',
                    'title'         => __( 'Категория учеников', 'redux-framework-demo' ),
                    'subtitle'      => __( 'Выберите классы с которыми работает преподаватель', 'redux-framework-demo' ),
                    'default'       => array(
                        1 => 1,
                        2 => 11,
                    ),
                    'min'           => 1,
                    'step'          => 1,
                    'max'           => 11,
                    'display_value' => 'select',
                    'handles'       => 2,
                ),

                array(
                    'id'       => $prefix . 'exams',
                    'type'     => 'select',
                    'data'     => 'tags',
                    'multi'    => true,
                    'title'    => __( 'Готовлю к экзаменам', 'redux-framework-demo' ),
                    'subtitle' => __( 'К каким экзаменам готовит преподаватель', 'redux-framework-demo' )
                ),


                array(
                    'id'       => $prefix . 'place_of_employment',
                    'type'     => 'text',
                    'title'    => __( 'Место занятий', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите место занятий', 'redux-framework-demo' )
                ),

                /*array(
                    'id'       => $prefix . 'areas_of_the_county5',
                    'type'     => 'text',
                    'title'    => __( 'Районы выезда', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите Районы выезда через запятую', 'redux-framework-demo' )
                ),*/

                array(
                    'id'      => $prefix . 'areas_of_the_county5',
                    'type'    => 'checkbox',
                    'title'   => __( 'Районы выезда', 'redux-framework-demo' ),
                    'desc'    => __( 'You can literally translate the values via key.', 'redux-framework-demo' ),
                    //Must provide key => value pairs for multi checkbox options
                    'options' => $options_panda['city_district'],
                ),

            ),
        );

        /*-----------------------------------------------------------------------------------*/
        /*  - Dots Menu
        /*-----------------------------------------------------------------------------------*/
        $main_settings[] = array(
            'title'     => __( 'Заметки администрации', 'wp_panda' ),
            'icon'      => 'el-icon-pencil',
            'fields'    => array(

                array(
                    'id'       => $prefix . 'proven_teacher',
                    'type'     => 'switch',
                    'title'    => __( 'Проверен', 'redux-framework-demo' ),
                    'subtitle' => __( 'Включите, если даннве о преподавателе проверены', 'redux-framework-demo' ),
                    'default'  => 0,
                    'on'       => 'Проверен',
                    'off'      => 'Не проверен',
                ),

            ),
        );

        // Set Main settings array for all post types
        $post_settings  = $main_settings;


        /*-----------------------------------------------------------------------------------*/
        /*  - Define Metaboxes
        /*-----------------------------------------------------------------------------------*/

        // Posts
        $metaboxes[] = array(
            'id'            => 'az-post-metaboxes',
            'title'         => __( 'Данные преподавателя', 'wp_panda' ),
            'post_types'    => array( 'post' ),
            'position'      => 'normal',
            'priority'      => 'high',
            'sidebar'       => true,
            'sections'      => $post_settings
        );
    return $metaboxes;
  }
  add_action('redux/metaboxes/panda/boxes', 'redux_add_metaboxes');
endif;

// The loader will load all of the extensions automatically based on your $redux_opt_name
require_once(dirname(__FILE__).'/loader.php');