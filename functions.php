<?php
/**
 * Константы
 */

define('RE_MAIN_PART',  get_template_directory_uri());
define('RE_IMG_PART',  RE_MAIN_PART . '/assets/img/');

/**
 * Запуск сессии
 */
add_action('init', 'myStartSession', 1);
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}



/**
 * Урл картинки
 */
function get_re_img_src($img) {
    return RE_IMG_PART . $img;
}
function re_img_src($img) {
    echo RE_IMG_PART . $img;
}

/**
 * Подключение всякого
 */

//require_once 'redux/redux-framework.php';
//require_once 'redux/sample/sample-config.php';
//require_once 'redux/extensions/metaboxes/extension_metaboxes.php';
$tempdir = get_template_directory();
require_once($tempdir .'/inc/framework/redux/redux-core/framework.php');
require_once($tempdir .'/inc/framework/redux/loader.php');
require_once($tempdir .'/inc/framework/redux/meta-config.php');
require_once($tempdir .'/inc/framework/redux/redux-core/az_framework/config.php');
require_once($tempdir .'/inc/framework/redux/custom-functions-meta.php');

require_once($tempdir .'/inc/framework/redux/bfi.php');
require_once($tempdir .'/inc/framework/class-cr-base.php');
require_once($tempdir .'/inc/framework/complite-functions.php');
require_once($tempdir .'/inc/framework/map-functions.php');

require_once($tempdir .'/inc/framework/class-cherry-breadcrumbs.php');

require_once($tempdir .'/inc/taxonomys.php');



/** тайтл */
add_theme_support( 'title-tag' );
/**
 * минька
 */
add_theme_support( 'post-thumbnails' );

/**
 * Классы хэдера
 */

function re_head_class(){
    $array = array();
    $array[] = 'header';
    if((is_singular() && !is_page_template(array('map-page.php','register-step-1.php')))  || is_archive())
        $array[] = ' header-inside';

    if(is_page_template('map-page.php') )
        $array[] = ' map-header hidden-nodesktop';

    if(is_page_template('register-step-1.php') )
        $array[] = ' registr-header';

    $out_classes = '';
    foreach ($array as $val)
        $out_classes .= $val;

    echo 'class="' . $out_classes . '"';
}


/**
 * Стили и скрипты
 */

function re_styles_scripts(){
    if( ! is_tax('news_list') || ! is_singular('news') ) {
        wp_enqueue_style('main-css', RE_MAIN_PART . '/assets/css/style.css');
    } else {
        wp_enqueue_style('main-css', RE_MAIN_PART . '/assets/css/style_newer.css');
    }
    wp_enqueue_style('resp-css', RE_MAIN_PART .'/assets/css/responsive.css' );
    wp_enqueue_style('anim-css', RE_MAIN_PART .'/assets/css/animate.css' );
    wp_enqueue_style('font-css', RE_MAIN_PART .'/assets/css/fonts.css' );
    wp_enqueue_style('form-css', RE_MAIN_PART .'/assets/css/jquery.formstyler.css' );

    wp_deregister_script('jquery');
    wp_register_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js');
    wp_enqueue_script('wow-js', RE_MAIN_PART .'/assets/js/wow.min.js', array('jquery'),'1.0.0',true );
    wp_enqueue_script('form-js', RE_MAIN_PART .'/assets/js/jquery.formstyler.js', array('jquery'),'1.0.0',true );
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('maskedinput-js', RE_MAIN_PART .'/assets/js/jquery.maskedinput.js', array('jquery'),'1.0.0',true );

    //if ( is_archive() ) {
    wp_enqueue_script('cookie-js', RE_MAIN_PART .'/assets/js/jquery.cookie.js', array('jquery'),'1.0.0',true );
    //}

    wp_enqueue_script('picedit-js', RE_MAIN_PART .'/assets/js/jquery.picture.cut.js', array('jquery-ui-core','jquery-ui-widget','jquery-ui-mouse','jquery-ui-position','jquery-ui-draggable','jquery-ui-resizable','jquery-ui-button','jquery-ui-dialog','jquery-ui-slider'),'1.0.0',true );
    wp_enqueue_script('main-js', RE_MAIN_PART .'/assets/js/main.js',array(),'1.0.0',true );
    wp_enqueue_script('ajax-act', RE_MAIN_PART .'/assets/js/actions.js',array(),'1.0.0',true );
    wp_localize_script('ajax-act', 'CrAjAX', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'cr-special-string' )
    ));
    //if( is_page_template('map-page.php') ) {
    wp_enqueue_script('jquery-ui-autocomplete');
    //}

}

add_action('wp_enqueue_scripts','re_styles_scripts');


/**
 * Функция склонения числительных в русском языке
 *
 * @param int      $number  Число которое нужно просклонять
 * @param array  $titles      Массив слов для склонения
 * @return string
 **/
function declOfNum($number, $titles)
{
    $cases = array (2, 0, 1, 1, 1, 2);
    return $number." ".$titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
}

function declOfNum_title($number, $titles)
{
    $cases = array (2, 0, 1, 1, 1, 2);
    return $titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
}

/**
 * Подключение экшенов
 */

require_once 'actions/action-register-step-1.php';
require_once 'actions/action-register-step-2.php';
require_once 'actions/action-map-search.php';
require_once 'actions/action-search-list.php';
require_once 'actions/action-search-order.php';
require_once 'actions/action-send-mailes.php';
require_once 'actions/action-paginater.php';

/**
 * Мэнеджер сессий
 */
//require_once 'inc/wp_session/wp-session-manager.php';

/**
 * Таблица
 */
add_action("after_switch_theme", 'jal_install', 10 ,  2);
function jal_install ($oldname, $oldtheme=false) {
    global $wpdb;
    // global $jal_db_version;

    $table_name = $wpdb->prefix . "teachers";

    // $sql = "CREATE TABLE " . $table_name . " (
    //    id bigint(20) NOT NULL AUTO_INCREMENT, /*id*/
    //    time datetime DEFAULT '0' NOT NULL, /*время создания*/
    //    teache_id bigint(20) NOT NULL,  /*id препода */
    //   last_name text NOT NULL,  /* Фамилия */
    //    father_name text NOT NULL, /* отчество */
    //   name text NOT NULL, /*имя*/
    //   teache_content longtext, /*обомне*/
    //   sex VARCHAR(5) NOT NULL, /*пол*/
    //   both int(4) NOT NULL, /*родился*/
    //    status VARCHAR(15) NOT NULL, /*статус*/
    //    skype VARCHAR(5) NOT NULL, /*скайп*/
    //    lesson_point longtext NOT NULL, /*иесто работы*/
    //    experience_year int(2) NOT NULL, /*опыт работы лет*/
    //    prise int(5) NOT NULL, /*цена*/
    //   time_lesson int(2) NOT NULL, /*время*/
    //    prise_addon int(5), /*науенка за выезд*/
    //    education longtext NOT NULL, /*образование*/
    //    experience longtext NOT NULL, /*опыт работы*/
    //    student_cat longtext NOT NULL, /*категории учеников*/
    //    sity text NOT NULL,
    //    district text NOT NULL,
    //    street text NOT NULL,
    //   house text NOT NULL,
    //   latitude text NOT NULL,
    //   longitude text NOT NULL,
    //   emigration_district longtext,
    //   UNIQUE KEY id (id)
    //);";*/

    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE " . $table_name . " (
             id bigint(20) NOT NULL AUTO_INCREMENT,
             time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
             teache_id bigint(20) NOT NULL,
             phone text NOT NULL,
             email text NOT NULL,
             last_name text NOT NULL,
             father_name text NOT NULL,
             name_teache text NOT NULL,
             specialization longtext NOT NULL,
             teache_content longtext,
             sex VARCHAR(5) NOT NULL,
             both_teache int(4) NOT NULL,
             status VARCHAR(15) NOT NULL,
             skype VARCHAR(5) NOT NULL,
             lesson_point longtext NOT NULL,
             experience_year int(2) NOT NULL,
             prise int(5) NOT NULL,
             time_lesson int(2) NOT NULL,
             prise_addon int(5),
             education longtext NOT NULL,
             experience longtext NOT NULL,
             student_cat longtext NOT NULL,
             sity text NOT NULL,
             district text NOT NULL,
             street text NOT NULL,
             house text NOT NULL,
             latitude text NOT NULL,
             longitude text NOT NULL,
             emigration_district longtext,
             for_60 int(5) NOT NULL,
             UNIQUE KEY id (id)
       )$charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

}


/**
 * Количество записей в категории
 */

function wp_get_cat_postcount() {
    $term = get_queried_object();
    if ( !$term )
        return;
    $cat = get_category($term->term_id);
    $count = (int) $cat->count;
    $taxonomy = 'category';
    $args = array(
        'child_of' => $term->term_id,
    );
    $tax_terms = get_terms($taxonomy,$args);
    foreach ($tax_terms as $tax_term) {
        $count +=$tax_term->count;
    }
    return $count;
}

/**
 * Первую букву в верхний регистр
 */

function upFirstLetter($str)
{
    $encoding = get_option('blog_charset');
    return mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding)
    . mb_substr($str, 1, null, $encoding);
}

/**
 * Русские даты
 */
function true_russian_date_forms($the_date = '') {
    if ( substr_count($the_date , '---') > 0 ) {
        return str_replace('---', '', $the_date);
    }
    $replacements = array(
        "Январь" => "января",
        "Февраль" => "февраля",
        "Март" => "марта",
        "Апрель" => "апреля",
        "Май" => "мая",
        "Июнь" => "июня",
        "Июль" => "июля",
        "Август" => "августа",
        "Сентябрь" => "сентября",
        "Октябрь" => "октября",
        "Ноябрь" => "ноября",
        "Декабрь" => "декабря"
    );
    return strtr($the_date, $replacements);
}

add_filter('the_time', 'true_russian_date_forms');
add_filter('get_the_time', 'true_russian_date_forms');
add_filter('the_date', 'true_russian_date_forms');
add_filter('get_the_date', 'true_russian_date_forms');
add_filter('the_modified_time', 'true_russian_date_forms');
add_filter('get_the_modified_date', 'true_russian_date_forms');
add_filter('get_post_time', 'true_russian_date_forms');
add_filter('get_comment_date', 'true_russian_date_forms');


add_action( 'wp_head', 'cr_setup_favicons_group' );

function cr_setup_favicons_group() {
    global $panda;
    $out ='';

    if($panda['favicon_3'])
        $out .= '<link rel="apple-touch-icon" href="' . $panda['favicon_3']['url'] . '">';

    if($panda['favicon_2'])
        $out .= '<link rel="icon" href="' . $panda['favicon_2']['url'] . '">';

    if($panda['favicon_1'])
        $out .=  '<!--[if IE]><link rel="shortcut icon" href="' . $panda['favicon_1']['url'] . '"><![endif]-->';

    if($panda['favicon_4'])
        $out .=  '<meta name="msapplication-TileImage" content="' . $panda['favicon_4']['url'] . '">';


    echo $out;

}


function new_excerpt_more($more) {
    global $post;
    if(!is_front_page()) {
        return '<a class="read-more" href="' . get_permalink($post->ID) . '">' . __('Читать далее', 'wp_panda') . '</a>';
    }
}
add_filter('excerpt_more', 'new_excerpt_more');

function new_excerpt_length($length) {
    if(is_front_page()) {
        return 12;
    } else {
        return 20;
    }
}
add_filter('excerpt_length', 'new_excerpt_length');


/***********************/
add_filter('comment_form_default_fields', 'custom_fields');
function custom_fields($fields) {

    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $fields[ 'author' ] = ''.
        '<div class="litebox-form otzuv-form"><div class="little-container ttgray">'.
        ( $req ? '<span class="required">*</span>' : '' ).
        '<input id="author" name="author" type="text"  class="name" value="'. esc_attr( $commenter['comment_author'] ) .
        '" size="30" tabindex="1"' . $aria_req . ' /></div>';

    $fields[ 'phone' ] = '' .
        '<div class="little-container ttgray">'.
        '<input id="phone" name="phone" type="text" size="30"  class="tel" tabindex="4" /></div></div>';



    return $fields;
}

add_action( 'comment_form_logged_in_after', 'additional_fields' );
add_action( 'comment_form_after_fields', 'additional_fields' );

function additional_fields () { ?>
    <div class="otsenka-block">
        <div class="one">0</div>
        <div class="ten">10</div>
        <div class="otsenka-title">Ваша оценка:</div>
        <div id="slider"></div>
        <span id="contentSlider"></span>

    </div>
    <?php
    echo '<input type="hidden" name="rating" id="rating" value="0"/>';


}

add_action( 'comment_post', 'save_comment_meta_data' );

function save_comment_meta_data( $comment_id ) {
    if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != '') )
        $phone = wp_filter_nohtml_kses($_POST['phone']);
    add_comment_meta( $comment_id, 'phone', $phone );

    if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '') )
        $rating = wp_filter_nohtml_kses($_POST['rating']);
    add_comment_meta( $comment_id, 'rating', $rating );
}

add_filter( 'preprocess_comment', 'verify_comment_meta_data' );
function verify_comment_meta_data( $commentdata ) {
    if ( ! isset( $_POST['rating'] ) )
        wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.' ) );
    return $commentdata;
}

function remove_comment_fields($fields) {
    unset($fields['url']);
    unset($fields['email']);
    return $fields;
}
add_filter('comment_form_default_fields', 'remove_comment_fields');


function mytheme_init() {
    add_filter('comment_form_defaults','mytheme_comments_form_defaults');
}
add_action('after_setup_theme','mytheme_init');
function mytheme_comments_form_defaults($default) {
    unset($default['comment_notes_after']);
    return $default;
}


function wpsites_modify_comment_form_text_area($arg) {
    $arg['comment_field'] = '<div class="textarea-block"><span>Поделитесь своими впечатлениями:</span><textarea id="comment" placeholder="Напишите отзыв" name="comment" cols="45" rows="1" aria-required="true"></textarea></div>';
    return $arg;
}

add_filter('comment_form_defaults', 'wpsites_modify_comment_form_text_area');

add_filter( 'comment_author_says_text', 'sp_comment_author_says_text' );
function sp_comment_author_says_text() {
    return 'author says';
}


add_filter( 'comment_form_defaults', 'sp_comment_form_defaults' );
function sp_comment_form_defaults( $defaults ) {

    $defaults['title_reply'] = __( '' );
    return $defaults;

}

// Admin Note
function adminnote($atts, $content = NULL){
    if(current_user_can('edit_themes') || is_user_logged_in()){
        return '<pre>
<div style="margin-bottom: 22px; font-family: Consolas, Monaco, \'Courier New\', Courier, monospace; font-size: 12px; font-weight: inherit; overflow-x: auto; white-space: -o-pre-wrap; width: 99%; word-wrap: break-word; background: #f3f3f7; border: 1px solid #dedee3; padding: 11px; line-height: 1.3em;"><b>Заметка администрации</b>
' . $content . '</div>
</pre>
';
    }
}
add_shortcode('notes', 'adminnote');


add_action( 'parse_request', 'idsearch' );
function idsearch( $wp ) {
    global $pagenow;

    // If it's not the post listing return
    if( 'edit.php' != $pagenow )
        return;

    // If it's not a search return
    if( !isset( $wp->query_vars['s'] ) )
        return;

    // If it's a search but there's no prefix, return
    if( '#' != substr( $wp->query_vars['s'], 0, 1 ) )
        return;

    // Validate the numeric value
    $id = absint( substr( $wp->query_vars['s'], 1 ) );
    if( !$id )
        return; // Return if no ID, absint returns 0 for invalid values

    // If we reach here, all criteria is fulfilled, unset search and select by ID instead
    unset( $wp->query_vars['s'] );
    $wp->query_vars['p'] = $id;
}

add_filter( 'parse_query', 'ba_admin_posts_filter' );
add_action( 'restrict_manage_posts', 'ba_admin_posts_filter_restrict_manage_posts' );
function ba_admin_posts_filter( $query )
{
    global $pagenow;
    if ( is_admin() && $pagenow=='edit.php' && isset($_GET['ADMIN_FILTER_FIELD_NAME']) && $_GET['ADMIN_FILTER_FIELD_NAME'] != '') {
        $query->query_vars['meta_key'] = $_GET['ADMIN_FILTER_FIELD_NAME'];
        if (isset($_GET['ADMIN_FILTER_FIELD_VALUE']) && $_GET['ADMIN_FILTER_FIELD_VALUE'] != '')
            $query->query_vars['meta_value'] = $_GET['ADMIN_FILTER_FIELD_VALUE'];
    }
}
function ba_admin_posts_filter_restrict_manage_posts()
{
    global $wpdb;
    $sql = 'SELECT DISTINCT meta_key FROM '.$wpdb->postmeta.' ORDER BY 1';
    $fields = $wpdb->get_results($sql, ARRAY_N);
    ?>
    <select name="ADMIN_FILTER_FIELD_NAME">
        <option value="az_family_name_teacher"><?php _e('Фамилия', 'baapf'); ?></option>
        <?php
        $current = isset($_GET['ADMIN_FILTER_FIELD_NAME'])? $_GET['ADMIN_FILTER_FIELD_NAME']:'';
        $current_v = isset($_GET['ADMIN_FILTER_FIELD_VALUE'])? $_GET['ADMIN_FILTER_FIELD_VALUE']:'';

        foreach ($fields as $field) {
            if (substr($field[0],0,1) != "_"){
                printf
                (
                    '<option value="az_family_name_teacher"></option>'
                //$field[0],
                //$field[0] == $current? ' selected="selected"':'',
                //$field[0]
                );
            }


            break;

        }
        ?>
    </select> <?php _e('Значение:', 'baapf'); ?><input type="TEXT" name="ADMIN_FILTER_FIELD_VALUE" value="<?php echo $current_v; ?>" />
<?php
}


function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Преподаватели';
    $submenu['edit.php'][5][0] = 'Преподаватели';
    $submenu['edit.php'][10][0] = 'Дабавить нового';
    $submenu['edit.php'][15][0] = 'Предметы'; // Change name for categories
    $submenu['edit.php'][16][0] = 'Егэ огэ'; // Change name for tags
    echo '';
}

add_action( 'admin_menu', 'change_post_menu_label' );


add_filter( 'wp_mail_from', 'hg_mail_from');
add_filter( 'wp_mail_from_name', 'hg_mail_from_name');
function hg_mail_from($from_email){
    global $panda;
    $from_email = $panda['e_mail'];
    return $from_email;
}
function hg_mail_from_name($from_name){
    $from_name = 'Садись 5';
    return $from_name;
}

function sendSMS($phone,$text){
    $phone= trim($phone,'+');
    include_once "sms.php";
    list($sms_id, $sms_cnt, $cost, $balance) = send_sms($phone,$text, 0,0,0,'Sadis5');
}


add_filter('manage_edit-post_columns', 'add_views_column', 4);
function add_views_column( $defaults ){
    // удаляем колонку Автор
    unset($defaults['author']);

    $defaults['phone'] = 'Телефон';
    $defaults['email'] = 'Почта';

    /**
    // вставляем в нужное место - 3 - 3-я колонка
    $out = array();
    foreach($columns as $col=>$name) {
        if (++$i == 3)
            $out['phone'] = 'Телефон';
        $out[$col] = $name;

    }

    foreach($columns as $col=>$name){
        if(++$i==4)
            $out['email'] = 'Почта';
        $out[$col] = $name;
    }

     **/
    return $defaults;
}
// заполняем колонку данными
add_filter('manage_post_posts_custom_column', 'fill_views_column', 5, 2); // wp-admin/includes/class-wp-posts-list-table.php
function fill_views_column($column_name, $post_id) {
    if( $column_name == 'phone' )
        $phone = get_post_meta( $post_id, 'az_phone', true );
    echo  $phone;

    if( $column_name == 'email' )
        $email = get_post_meta( $post_id, 'az_email', true );
    echo $email;


}