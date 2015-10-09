<?php
$redux_opt_name = "panda";



if ( !function_exists( "redux_add_metaboxes" ) ):
    function redux_add_metaboxes($metaboxes) {

        // Global panda
        $options_panda = get_option('panda');
        //$panda;

        // года
        $year = array();
        $x=0;
        while ($x++<50) $year[$x] = declOfNum($x, array(' год', ' года', ' лет'));

        $year_both = array();
        $x=1940;
        while ($x++<(date('Y')-20)) $year_both[$x] = $x . ' год' ;

        //районы
        $city_district = array();
        if(!empty($options_panda['city_district'])){
            $n = 1;
            foreach($options_panda['city_district'] as $key ) {
                $city_district[$n] = $key;
                $n++;
            }
        } else {
            $city_district[] = 'Введите районы в панели';
        }

        //город
        $site_city = $options_panda['site_city'] ? $options_panda['site_city'] : array('Введите город сайта');

        //категории учеников
        $site_student = array();
        if(!empty($options_panda['site_student'])){
            $n = 1;
            foreach($options_panda['site_student'] as $key ) {
                $site_student[$n] = $key;
                $n++;
            }
        } else {
            $site_student[] = 'Введите категории учеников';
        }

        //статус преподавателя
        $teacher_status = $options_panda['teacher_status'] ? $options_panda['teacher_status'] : array('Введите статусы преподавателя');
        //длительность занятия
        $lesson_time = array();
        if(!empty($options_panda['lesson_time'])){
            foreach($options_panda['lesson_time'] as $key )
                $lesson_time[$key] = $key;
        } else {
            $lesson_time[] = 'Введите длительность занятий';
        }

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
                    'id'       => $prefix . 'phone',
                    'type'     => 'text',
                    'title'    => __( 'Телефон', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите телефон преподавателя', 'redux-framework-demo' )
                ),

                array(
                    'id'       => $prefix . 'email',
                    'type'     => 'text',
                    'title'    => __( 'Электронная почта', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите Электронную почту преподавателя', 'redux-framework-demo' )
                ),

                array(
                    'id'       => $prefix . 'teacher_sex',
                    'type'     => 'radio',
                    'title'    => __( 'Пол', 'redux-framework-demo' ),
                    'subtitle' => __( 'Отметьте пол преподаватель', 'redux-framework-demo' ),
                    'options' => array(
                        'man' => 'Мужской',
                        'woman' => 'Женский',
                    ),
                ),


                array(
                    'id'       => $prefix . 'family_name_teacher',
                    'type'     => 'text',
                    'title'    => __( 'Фамилия', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите фамилию преподавателя', 'redux-framework-demo' )
                ),

                array(
                    'id'       => $prefix . 'teacher_both',
                    'type'     => 'select',
                    'title'    => __( 'Год рождения', 'redux-framework-demo' ),
                    'subtitle' => __( 'Выберите год рождения преподавателя', 'redux-framework-demo' ),
                    'options'  => $year_both,
                    'default'  => '2'
                ),

                array(
                    'id'      => $prefix . 'teacher_status',
                    'type'    => 'radio',
                    'title'   => __( 'Статус', 'redux-framework-demo' ),
                    'desc'    => __( 'Введите статус Преподавателя', 'redux-framework-demo' ),
                    'options' => $teacher_status,
                ),

                array(
                    'id'       => $prefix . 'use_skype_teacher',
                    'type'     => 'checkbox',
                    'title'    => __( 'Занятия по Skype', 'redux-framework-demo' ),
                    'subtitle' => __( 'Отметьте если преподаватель работает по Skype', 'redux-framework-demo' )
                ),

                array(
                    'id'       => $prefix . 'teacher_lesson_location',
                    'type'     => 'radio',
                    'title'    => __( 'Место занятий', 'redux-framework-demo' ),
                    'subtitle' => __( 'Отметьте где работает преподаватель', 'redux-framework-demo' ),
                    'options' => array(
                        'home' => 'У преподавателя',
                        'road' => 'У ученика',
                        'all'  => 'Не важно'
                    ),
                ),

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
                    'subtitle' => __( 'Введите стоимость занятия', 'redux-framework-demo' )
                ),

                array(
                    'id'       => $prefix . 'lesson_time',
                    'type'     => 'radio',
                    'title'    => __( 'Длительность занятия', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите длительность занятия', 'redux-framework-demo' ),
                    'options'  => $lesson_time
                ),

                array(
                    'id'       => $prefix . 'extra_charge_for_check_out',
                    'type'     => 'text',
                    'title'    => __( 'Наценка за выезд', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите наценку за выездные занятия', 'redux-framework-demo' )
                ),

                array(
                    'id'        =>  $prefix . 'education_of_the_teacher',
                    'type'      =>  'multi_text',
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
                    'id'      => $prefix . 'category_students5',
                    'type'    => 'checkbox',
                    'title'   => __( 'Категория учеников', 'redux-framework-demo' ),
                    'desc'    => __( 'Выберите категории учеников с которыми работает преподаватель', 'redux-framework-demo' ),
                    //Must provide key => value pairs for multi checkbox options
                    'options' => $site_student,
                ),


                array(
                    'id'       => 'opt-multi-check',
                    'type'     => 'checkbox',
                    'title'    => __( 'Multi Checkbox Option', 'redux-framework-demo' ),
                    'subtitle' => __( 'No validation can be done on this field type', 'redux-framework-demo' ),
                    'desc'     => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
                    //Must provide key => value pairs for multi checkbox options
                    'options'  => array(
                        '1' => 'Opt 1',
                        '2' => 'Opt 2',
                        '3' => 'Opt 3'
                    ),
                    //See how std has changed? you also don't need to specify opts that are 0.
                    'default'  => array(
                        '1' => '1',
                        '2' => '0',
                        '3' => '0'
                    )
                ),

                array(
                    'id'       => $prefix . 'place_of_employment_city',
                    'type'     => 'text',
                    'title'    => __( 'Место занятий Город', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите место занятий Город', 'redux-framework-demo' ),
                    'default'      => $site_city
                ),

                array(
                    'id'      => $prefix . 'place_of_employment_district',
                    'type'    => 'radio',
                    'title'   => __( 'Адрес преподавателя Район', 'redux-framework-demo' ),
                    'desc'    => __( 'Адрес преподавателя Район', 'redux-framework-demo' ),
                    //Must provide key => value pairs for multi checkbox options
                    'options' => $city_district,
                ),

                array(
                    'id'       => $prefix . 'place_of_employment_street',
                    'type'     => 'text',
                    'title'    => __( 'Адрес преподавателя Улица', 'redux-framework-demo' ),
                    'subtitle' => __( 'Адрес преподавателя Улица', 'redux-framework-demo' ),
                ),

                array(
                    'id'       => $prefix . 'place_of_employment_house',
                    'type'     => 'text',
                    'title'    => __( 'Адрес преподавателя Дом', 'redux-framework-demo' ),
                    'subtitle' => __( 'Адрес преподавателя Дом', 'redux-framework-demo' ),
                ),

                array(
                    'id'       => $prefix . 'place_of_employment_shir',
                    'type'     => 'text',
                    'title'    => __( 'Адрес преподавателя Широта', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите Адрес преподавателя Координату Широты', 'redux-framework-demo' ),
                ),

                array(
                    'id'       => $prefix . 'place_of_employment_dol',
                    'type'     => 'text',
                    'title'    => __( 'Адрес преподавателя Координата Долгота', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите Адрес преподавателя Координату Долготы', 'redux-framework-demo' ),
                ),

                array(
                    'id'      => $prefix . 'areas_of_the_county5',
                    'type'    => 'checkbox',
                    'title'   => __( 'Районы выезда', 'redux-framework-demo' ),
                    'desc'    => __( 'Выберите районы выезда.', 'redux-framework-demo' ),
                    //Must provide key => value pairs for multi checkbox options
                    'options' => $city_district,
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
                    'type'     => 'radio',
                    'title'    => __( 'Проверен', 'redux-framework-demo' ),
                    'subtitle' => __( 'Включите, если даннве о преподавателе проверены', 'redux-framework-demo' ),
                    'default'  => 0,
                    'options' => array(
                        1       => 'Проверен',
                        0     => 'Не проверен',
                    )
                ),

                array(
                    'id'       => $prefix . 'in_home',
                    'type'     => 'radio',
                    'title'    => __( 'Показывать на главной', 'redux-framework-demo' ),
                    'subtitle' => __( 'Включите, если преподавателя надо показывать на главной в карте', 'redux-framework-demo' ),
                    'default'  => 0,
                    'options' => array(
                    1 => 'Показывать',
                    0 => 'Не показывать',
                    )
                )

            )
        );

        // Set Main settings array for all post types
        $post_settings  = $main_settings;


        /*-----------------------------------------------------------------------------------*/
        /*  - Logo & Menu
        /*-----------------------------------------------------------------------------------*/
        $order_settings[] = array(
            'title'     => __( 'Данные заявки', 'wp_panda' ),
            'icon'      => 'el-icon-adult',
            'fields'    => array(


                array(
                    'id'       => $prefix . 'teacher_sex',
                    'type'     => 'radio',
                    'title'    => __( 'Пол', 'redux-framework-demo' ),
                    'subtitle' => __( 'Отметьте пол ученика', 'redux-framework-demo' ),
                    'options' => array(
                        'man' => 'Мужской',
                        'woman' => 'Женский',
                    ),
                ),

                array(
                    'id'       => $prefix . 'teacher_lesson_location',
                    'type'     => 'radio',
                    'title'    => __( 'Место занятий', 'redux-framework-demo' ),
                    'subtitle' => __( 'Отметьте где будут проходить занятия', 'redux-framework-demo' ),
                    'options' => array(
                        'home' => 'У преподавателя',
                        'road' => 'У ученика',
                        'all'  => 'Не важно'
                    ),
                ),

                array(
                    'id'       => 'prise_lesson',
                    'type'     => 'text',
                    'title'    => __( 'Стоимость занятия', 'redux-framework-demo' ),
                    'subtitle' => __( 'Введите стоимость занятия', 'redux-framework-demo' )
                ),

                array(
                    'id'      => $prefix . 'category_students5',
                    'type'    => 'radio',
                    'title'   => __( 'Категория учеников', 'redux-framework-demo' ),
                    'desc'    => __( 'Выберите категории учеников с которыми работает преподаватель', 'redux-framework-demo' ),
                    //Must provide key => value pairs for multi checkbox options
                    'options' => $site_student,
                ),

                array(
                    'id'      => $prefix . 'place_of_employment_district',
                    'type'    => 'radio',
                    'title'   => __( 'Место занятий Район', 'redux-framework-demo' ),
                    'desc'    => __( 'Место занятий Район', 'redux-framework-demo' ),
                    'options' => $city_district,
                ),

                array(
                    'id'       => $prefix . 'place_of_employment_street',
                    'type'     => 'text',
                    'title'    => __( 'Адрес занятий', 'redux-framework-demo' ),
                    'subtitle' => __( 'Адрес занятий', 'redux-framework-demo' ),
                ),

                array(
                    'id'       => 'opt_datepicker_st',
                    'type'     => 'date',
                    'title'    => __( 'Дата Начала занятий', 'redux-framework-demo' ),
                    'subtitle' => __( 'Выберите дату начала занятий', 'redux-framework-demo' )
                ),

                array(
                    'id'       => 'opt-datepicker',
                    'type'     => 'date',
                    'title'    => __( 'Служебное поле, заполнять не надо!!!!', 'redux-framework-demo' ),
                ),

            ),
        );

        // Set Main settings array for all post types
        $post_settings  = $main_settings;
        //$post_settings  = $order_settings;

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

        // Posts
        $metaboxes[] = array(
            'id'            => 'az-post-metaboxes-s',
            'title'         => __( 'Данные ученика', 'wp_panda' ),
            'post_types'    => array( 'order' ),
            'position'      => 'normal',
            'priority'      => 'high',
            'sidebar'       => true,
            'sections'      => $order_settings
        );

        return $metaboxes;
    }
    add_action('redux/metaboxes/panda/boxes', 'redux_add_metaboxes');
endif;

// The loader will load all of the extensions automatically based on your $redux_opt_name
require_once(dirname(__FILE__).'/loader.php');