<?php

/*
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);

            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**
         * This is a test function that will let you see when the compiler hook occurs.
         * It only runs if a field    set with compiler=>true is changed.
         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**
         * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
         * Simply include this function in the child themes functions.php file.
         * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
         * so you must use get_template_directory_uri() if you want to use any of the built in icons
         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'wp_panda'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'wp_panda'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**
         * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**
         * Filter hook for filtering the default value of any given field. Very useful in development mode.
         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }

        public function setSections() {

            /**
             * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns      = array();

            if ( is_dir( $sample_patterns_path ) ) :

                if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
                    $sample_patterns = array();

                    while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                        if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                            $name              = explode( '.', $sample_patterns_file );
                            $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                            $sample_patterns[] = array(
                                'alt' => $name,
                                'img' => $sample_patterns_url . $sample_patterns_file
                            );
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct          = wp_get_theme();
            $this->theme = $ct;
            $item_name   = $this->theme->get( 'Name' );
            $tags        = $this->theme->Tags;
            $screenshot  = $this->theme->get_screenshot();
            $class       = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'wp_panda' ), $this->theme->display( 'Name' ) );

            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
                <?php if ($screenshot) : ?>
                    <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                    <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'wp_panda'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'wp_panda'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'wp_panda') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
                    <?php
                    if ($this->theme->parent()) {
                        printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'wp_panda'), $this->theme->parent()->display('Name'));
                    }
                    ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                Redux_Functions::initWpFilesystem();

                global $wp_filesystem;

                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS



            /*-----------------------------------------------------------------------------------*/
            /* - Контактная иныормация
            /*-----------------------------------------------------------------------------------*/
            $this->sections[] = array(
                'title'      =>  __('Контактная информация', 'wp_panda'),
                'desc'       =>  __('В этом разделе настраиваются контактные данные.', 'wp_panda'),
                'icon'       =>  'font-icon-house',
                'customizer' =>  false,
                'fields'     =>  array(

                    array(
                        'id'       => 'phone_1',
                        'type'     => 'text',
                        'title'    => __( 'Телефон 1', 'wp_panda' ),
                        'subtitle' => __( 'Введите номер телефона', 'wp_panda' ),
                        'default'  => '',
                    ),

                    array(
                        'id'       => 'phone_2',
                        'type'     => 'text',
                        'title'    => __( 'Телефон 2', 'wp_panda' ),
                        'subtitle' => __( 'Введите номер телефона', 'wp_panda' ),
                        'default'  => '',
                    ),

                    array(
                        'id'       => 'e_mail',
                        'type'     => 'text',
                        'title'    => __( 'Электронная почта', 'wp_panda' ),
                        'subtitle' => __( 'Введите адрес электронной почты', 'wp_panda' ),
                        'default'  => '',
                    ),

                )
            );

            /*-----------------------------------------------------------------------------------*/
            /* - Региональные настройки
            /*-----------------------------------------------------------------------------------*/
            $this->sections[] = array(
                'title'      =>  __('Регион', 'wp_panda'),
                'desc'       =>  __('В этом разделе настраиваются данные специфичные для региона сайта.', 'wp_panda'),
                'icon'       =>  'font-icon-house',
                'customizer' =>  false,
                'fields'     =>  array(

                    array(
                        'id'       => 'site_city',
                        'type'     => 'text',
                        'title'    => __( 'Город', 'wp_panda' ),
                        'subtitle' => __( 'Регион к которму привязан сайт', 'wp_panda' ),
                        //'desc'     => __( 'Field Description', 'wp_panda' ),
                        'default'  => '',
                    ),

                    array(
                        'id'       => 'site_city_in',
                        'type'     => 'text',
                        'title'    => __( 'Город в предложном падеже', 'wp_panda' ),
                        'subtitle' => __( 'Введите название региона в предложном падеже', 'wp_panda' ),
                        //'desc'     => __( 'Field Description', 'wp_panda' ),
                        'default'  => '',
                    ),

                    array(
                        'id'       => 'city_district',
                        'type'     => 'multi_text',
                        'title'    => __( 'Районы', 'wp_panda' ),
                        'subtitle' => __( 'Введите районы вашего города', 'wp_panda' ),
                        'desc'     => __( 'Добавить ещще один район', 'wp_panda' )
                    ),

                )
            );

            /*-----------------------------------------------------------------------------------*/
            /* - Настройки предметов
            /*-----------------------------------------------------------------------------------*/
            $this->sections[] = array(
                'title'      =>  __('Предметы', 'wp_panda'),
                'desc'       =>  __('В этом разделе настраиваются данные о предметах.', 'wp_panda'),
                'icon'       =>  'font-icon-cycle',
                'customizer' =>  false,
                'fields'     =>  array(

                    array(
                        'id'       => 'site_student',
                        'type'     => 'multi_text',
                        'title'    => __( 'Категории учеников', 'wp_panda' ),
                        'subtitle' => __( 'Введите категории учеников с которыми иожет рабртать преподаватель', 'wp_panda' ),
                        'desc'     => __( 'Добавить ещще одну категорию', 'wp_panda' )
                    ),

                    array(
                        'id'       => 'teacher_status',
                        'type'     => 'multi_text',
                        'title'    => __( 'Статус преподавателя', 'wp_panda' ),
                        'subtitle' => __( 'Введите возможные статусы преподавателя', 'wp_panda' ),
                        'desc'     => __( 'Добавить ещще один статус', 'wp_panda' )
                    ),

                    array(
                        'id'       => 'lesson_time',
                        'type'     => 'multi_text',
                        'title'    => __( 'Длительность занятия', 'wp_panda' ),
                        'subtitle' => __( 'Введите возможные длительности занятий', 'wp_panda' ),
                        'desc'     => __( 'Добавить ещще одну длительность', 'wp_panda' )
                    ),

                )
            );

            /*-----------------------------------------------------------------------------------*/
            /*  - General
            /*-----------------------------------------------------------------------------------*/
            $this->sections[] = array(
                'title'      =>  __('Лого и фавикон', 'wp_panda'),
                // 'desc'       =>  __('Welcome to the panda Options Panel! Control and configure the general setup of your theme.', 'wp_panda'),
                'icon'       =>  'font-icon-cycle',
                'customizer' =>  false,
                'fields'     =>  array(
                    // Custom Admin Logo + Custom Favicon + Custom iOS Icons
                    array(
                        'id'        =>  'custom_logo',
                        'type'      =>  'media',
                        'title'     =>  __('Логотип', 'wp_panda'),
                        //'subtitle'  =>  __('Upload 260 x 98px image here to replace the admin login logo', 'wp_panda'),
                        'desc'      =>  ''
                    ),

                    array(
                        'id'        =>  'favicon_1',
                        'type'      =>  'media',
                        'title'     =>  __('Favicon', 'wp_panda'),
                        'subtitle'  =>  __('Загрузите  16px x 16px Png/Gif', 'wp_panda'),
                        'desc'      =>  ''
                    ),


                    array(
                        'id'        =>  'favicon_2',
                        'type'      =>  'media',
                        'title'     =>  __('Favicon', 'wp_panda'),
                        'subtitle'  =>  __('Загрузите  96px x 196px Png', 'wp_panda'),
                        'desc'      =>  ''
                    ),

                    array(
                        'id'        =>  'favicon_3',
                        'type'      =>  'media',
                        'title'     =>  __('Favicon', 'wp_panda'),
                        'subtitle'  =>  __('Загрузите  152px x 152px Png', 'wp_panda'),
                        'desc'      =>  ''
                    ),

                    array(
                        'id'        =>  'favicon_4',
                        'type'      =>  'media',
                        'title'     =>  __('Favicon', 'wp_panda'),
                        'subtitle'  =>  __('Загрузите  144px x 144px Png', 'wp_panda'),
                        'desc'      =>  ''
                    ),

                )
            );

            // Preloader
            /* $this->sections[] = array(
                 'title'         =>  __('Preloader', 'wp_panda'),
                 'subsection'    =>  true,
                 'icon'          =>  'font-icon-arrow-right-simple-thin-round',
                 'customizer'    =>  false,
                 'fields'        =>  array(

                     // Preloader
                     array(
                         'id'        =>  'preloader_settings',
                         'type'      =>  'switch',
                         'title'     =>  __('Preloader Page/Post', 'wp_panda'),
                         'subtitle'  =>  __('Enable/Disable preloader page/post for your site.', 'wp_panda'),
                         'desc'      =>  '',
                         'default'   =>  0
                     ),

                     array(
                         'id'        =>  'global_preloader_visibility',
                         'type'      =>  'button_set',
                         'required'  =>  array('preloader_settings','=','1'),
                         'title'     =>  __('Global Preloader Setting', 'wp_panda'),
                         'subtitle'  =>  __('Enable or Disable the Preloader.<br/><br/><em>If you want can modify in each page/post the setting about the preloader.</em>', 'wp_panda'),
                         'desc'      =>  '',
                         'options'   =>  array(
                             'show'  =>  'Show',
                             'hide'  =>  'Hide',
                         ),
                         'default'   =>  'show',
                     ),

                     array(
                         'id'        =>  'preloader_design_mode',
                         'type'      =>  'button_set',
                         'required'  =>  array('preloader_settings','=','1'),
                         'title'     =>  __('Preloader Design', 'wp_panda'),
                         'subtitle'  =>  __('Select your design for your preloader.', 'wp_panda'),
                         'desc'      =>  '',
                         'options'   =>  array(
                             '1'     =>  'Default',
                             '2'     =>  'Image'
                         ),
                         'default'   =>  '1'
                     ),

                     array(
                         'id'        =>  'preloader_media_image',
                         'type'      =>  'media',
                         'required'  =>  array('preloader_design_mode','=','2'),
                         'title'     =>  __('Preloader Custom Image', 'wp_panda'),
                         'subtitle'  =>  __('Upload a PNG or GIF image that will be used in all applicable areas on your site as the loading image.', 'wp_panda'),
                         'desc'      =>  ''
                     ),

                 )
             );*/

            // Common
            /**   $this->sections[] = array(
            'title'         =>  __('Common Options', 'wp_panda'),
            'subsection'    =>  true,
            'icon'          =>  'font-icon-arrow-right-simple-thin-round',
            'customizer'    =>  false,
            'fields'        =>  array(

            // Animation on Mobile Devices
            array(
            'id'        =>  'enable_mobile_scroll_animation_effects',
            'type'      =>  'switch',
            'title'     =>  __('Scroll Animation Effects on Mobile/Tablet devices', 'wp_panda'),
            'subtitle'  =>  __('Enable/Disable scroll animation effects on mobile/tablet devices for items.', 'wp_panda'),
            'desc'      =>  '',
            'default'   =>  0
            ),

            // Back to Top
            array(
            'id'        =>  'enable_back_to_top',
            'type'      =>  'switch',
            'title'     =>  __('Back to Top', 'wp_panda'),
            'subtitle'  =>  __('Enable/Disable Back to Top Feature.', 'wp_panda'),
            'desc'      =>  '',
            'default'   =>  1
            ),

            // Comments Pages
            array(
            'id'        =>  'enable_comments_page',
            'type'      =>  'switch',
            'title'     =>  __('Comments Pages', 'wp_panda'),
            'subtitle'  =>  __('Enable/Disable for Pages only.', 'wp_panda'),
            'desc'      =>  '',
            'default'   =>  1
            ),

            // Disable Right Click
            array(
            'id'        =>  'disable_right_click',
            'type'      =>  'switch',
            'title'     =>  __('Disable Right Click', 'wp_panda'),
            'subtitle'  =>  __('Enable/Disable Right Click Feature.', 'wp_panda'),
            'desc'      =>  '',
            'default'   =>  0
            ),

            )
            );

            // Tracking Code
            $this->sections[] = array(
            'title'         =>  __('Tracking Code', 'wp_panda'),
            'subsection'    =>  true,
            'icon'          =>  'font-icon-arrow-right-simple-thin-round',
            'customizer'    =>  false,
            'fields'        =>  array(

            // Tracking Code
            array(
            'id'        =>  'tracking_code',
            'type'      =>  'text',
            'title'     =>  __('Tracking Code', 'wp_panda'),
            'subtitle'  =>  __('Paste your Google Analytics Property ID ( UA-XXXX-Y ).<br/><br/>This code will be added before the closing &lt;head&gt; tag.', 'wp_panda'),
            'desc'      =>  __('NOTE: This use a default analytics js code. If you want a specific requirements not use this but include the script manually.', 'wp_panda')
            ),

            )
            );

            // Custom CSS/JS Options
            $this->sections[] = array(
            'title'         =>  __('Custom CSS/JS', 'wp_panda'),
            'subsection'    =>  true,
            'icon'          =>  'font-icon-arrow-right-simple-thin-round',
            'customizer'    =>  false,
            'fields'        =>  array(

            // Enable Custom CSS
            array(
            'id'        =>  'enable_custom_css',
            'type'      =>  'switch',
            'title'     =>  __('Custom CSS', 'wp_panda'),
            'subtitle'  =>  __('Do you want enable custom css?', 'wp_panda'),
            'desc'      =>  '',
            'default'   =>  0
            ),

            // Custom CSS
            array(
            'id'        =>  'custom_css',
            'type'      =>  'ace_editor',
            'required'  =>  array('enable_custom_css','=','1'),
            'title'     =>  __('Custom CSS Code', 'wp_panda'),
            'subtitle'  =>  __('If you have any custom CSS you would like added to the site, please enter it here.<br/><br/>This code will be added before the closing &lt;head&gt; tag.', 'wp_panda'),
            'mode'      =>  'css',
            'theme'     =>  'monokai',
            'desc'      =>  ''
            ),

            // Enable Custom JS
            array(
            'id'        =>  'enable_custom_js',
            'type'      =>  'switch',
            'title'     =>  __('Custom JS', 'wp_panda'),
            'subtitle'  =>  __('Do you want enable custom js?', 'wp_panda'),
            'desc'      =>  '',
            'default'   =>  0
            ),

            // Custom JS
            array(
            'id'        =>  'custom_js',
            'type'      =>  'ace_editor',
            'mode'      =>  'javascript',
            'theme'     =>  'chrome',
            'required'  =>  array('enable_custom_js','=','1'),
            'title'     =>  __('Custom JS Code', 'wp_panda'),
            'subtitle'  =>  __('If you have any custom js you would like added to the site, please enter it here.<br/><br/>This code will be added before the closing &lt;body&gt; tag.', 'wp_panda'),
            'desc'      =>  __('NOTE: Write or Copy &amp; Paste only the javascript/jquery code without the &lt;script&gt; tag.', 'wp_panda')
            ),

            )
            );

            // Performance
            $this->sections[] = array(
            'title'         =>  __('Performance', 'wp_panda'),
            'subsection'    =>  true,
            'icon'          =>  'font-icon-arrow-right-simple-thin-round',
            'customizer'    =>  false,
            'fields'        =>  array(

            // Preloader
            array(
            'id'        =>  'performance_minified_settings',
            'type'      =>  'switch',
            'title'     =>  __('Load Minified File', 'wp_panda'),
            'subtitle'  =>  __('Load style.css and the main.js minfied version, the other files are already minified by default.', 'wp_panda'),
            'desc'      =>  '',
            'default'   =>  0
            ),

            )
            );


             */
            /*-----------------------------------------------------------------------------------*/
            /*  - Typography
            /*-----------------------------------------------------------------------------------*/
            /**   $this->sections[] = array(
            'title'      =>  __('Контактная информация', 'wp_panda'),
            'desc'       =>  __('Welcome to the panda Options Panel! Control and configure the typography of your theme.', 'wp_panda'),
            'icon'       =>  'font-icon-pencil',
            'customizer' =>  false,
            'fields'     =>  array(



            )
            ); */

            /*-----------------------------------------------------------------------------------*/
            /*  - Colors
            /*-----------------------------------------------------------------------------------*/
            $this->sections[] = array(
                'title'      =>  __('Настройки страниц', 'wp_panda'),
                'desc'       =>  __('Welcome to the panda Options Panel! Control and configure the colors setup of your theme.', 'wp_panda'),
                'icon'       =>  'font-icon-brush',
                'customizer' =>  true,
                'fields'     =>  array(

                    // Enable Custom Colors

                    array(
                        'id'        =>  'one_step_url',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка на страницу "Регистрация шаг 1"', 'wp_panda'),
                        'subtitle'  =>  __('Введите ссылку на страницу - "Регистрация шаг 1"', 'wp_panda'),
                        'desc'      =>  '',
                        'default'   =>  home_url('/register-step-one/')
                    ),

                    array(
                        'id'        =>  'two_step_url',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка на страницу "Регистрация шаг 2"', 'wp_panda'),
                        'subtitle'  =>  __('Введите ссылку на страницу - "Регистрация шаг 2"', 'wp_panda'),
                        'desc'      =>  '',
                        'default'   =>  home_url('/register-step-two/')
                    ),

                    array(
                        'id'        =>  'three_step_url',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка на страницу "Регистрация шаг 3"', 'wp_panda'),
                        'subtitle'  =>  __('Введите ссылку на страницу - "Регистрация шаг 3"', 'wp_panda'),
                        'desc'      =>  '',
                        'default'   =>  home_url('/register-step-three/')
                    ),

                    array(
                        'id'        =>  'map_url',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка на страницу "Карта репетиторов"', 'wp_panda'),
                        'subtitle'  =>  __('Введите ссылку на страницу - "Карта репетиторов"', 'wp_panda'),
                        'desc'      =>  '',
                        'default'   =>  home_url('/map/')
                    ),

                    array(
                        'id'        =>  'order_url',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка на страницу "Доска заказов"', 'wp_panda'),
                        'subtitle'  =>  __('Введите ссылку на страницу - "Доска заказов"', 'wp_panda'),
                        'desc'      =>  '',
                        'default'   =>  home_url('/order-list/')
                    ),

                    array(
                        'id'        =>  'news_url',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка на новости', 'wp_panda'),
                        'subtitle'  =>  __('Введите ссылку на страницу - "Новости"', 'wp_panda'),
                        'desc'      =>  '',
                        'default'   =>  home_url('/news_list/raznoe/')
                    ),

                    array(
                        'id'        =>  'ega_oga_url',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка на курсы Огэ Егэ', 'wp_panda'),
                        'subtitle'  =>  __('Введите ссылку с кнопки - "Курсы Огэ Егэ"', 'wp_panda'),
                        'desc'      =>  '',
                        'default'   =>  ''
                    ),

                    array(
                        'id'        =>  'o_nas_url',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка на страницу О Нас', 'wp_panda'),
                        'subtitle'  =>  __('Введите ссылку на страницу - "О Нас"', 'wp_panda'),
                        'desc'      =>  '',
                        'default'   =>  home_url('/o-nas/')
                    ),

                    array(
                        'id'        =>  'dogovor_url',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка на Договор Оферты', 'wp_panda'),
                        'subtitle'  =>  __('Введите ссылку на страницу - "Договор Оферты"', 'wp_panda'),
                        'desc'      =>  '',
                        'default'   =>  home_url('/dogovor-oferty/')
                    ),


                    array(
                        'id'        =>  'podbor_url',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка на Подбор', 'wp_panda'),
                        'subtitle'  =>  __('Введите ссылку на страницу - "Подбор"', 'wp_panda'),
                        'desc'      =>  '',
                        'default'   =>  home_url('/podbor-repetitora/')
                    ),
                )
            );


            /*-----------------------------------------------------------------------------------*/
            /*  - Social
            /*-----------------------------------------------------------------------------------*/
            $this->sections[] = array(
                'title'     =>  __('Социальные сети', 'wp_panda'),
                'icon'      =>  'font-icon-social-twitter',
                'fields'    =>  array(
                    array(
                        'id'        =>  'vk_vk',
                        'type'      =>  'text',
                        'title'     =>  __('Вконтакте', 'wp_panda'),
                        'subtitle'  =>  __('Введите ссылку на профмль в социальной сети Вконтакте', 'wp_panda'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'ok_ok',
                        'type'      =>  'text',
                        'title'     =>  __('Одноклассники', 'wp_panda'),
                        'subtitle'  =>  __('Введите ссылку на профмль в социальной сети Одноклассники', 'wp_panda'),
                        'desc'      =>  ''
                    ),

                )
            );

            $theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'wp_panda') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'wp_panda') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'wp_panda') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'wp_panda') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            if (file_exists(dirname(__FILE__) . '/../README.md')) {
                $this->sections['theme_docs'] = array(
                    'icon'      => 'el-icon-list-alt',
                    'title'     => __('Documentation', 'wp_panda'),
                    'fields'    => array(
                        array(
                            'id'        => '17',
                            'type'      => 'raw',
                            'markdown'  => true,
                            'content'   => file_get_contents(dirname(__FILE__) . '/../README.md')
                        ),
                    ),
                );
            }

            $this->sections[] = array(
                'title'     => __('Import / Export', 'wp_panda'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'wp_panda'),
                'icon'      => 'font-icon-switch',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );

        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'wp_panda'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'wp_panda')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'wp_panda'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'wp_panda')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'wp_panda');
        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'panda',                 // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  // Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('panda', 'wp_panda'),
                'page_title'        => __('panda', 'wp_panda'),

                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key'    => 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII', // Must be defined to add google fonts to the typography module
                'google_update_weekly' => false,                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'async_typography'  => true,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                   // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                //'open_expanded'     => true,                  // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                  // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '',                  // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false,               // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'wp_panda'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'wp_panda');
            }

            // Add content after the form.
            // $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'wp_panda');
        }

    }

    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
 * Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
 * Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
