<?php
/**
 Template Name: Контакты
 */
get_header();
global $panda;
//$news = !empty($panda['news_url']) ? $panda['news_url'] : 'javascript:void(0);';
?>
    <div class="inside-content">
        <div class="wr">
            <?php @get_template_part( 'templates/template','breadcrumbs' ); ?>


            <div class="about-page">
                <?php
                global $panda;
                $logo = $panda['custom_logo'] ? $panda['custom_logo']['url'] : '';
                $city = !empty($panda['site_city_in']) ? mb_strtoupper($panda['site_city_in']) : 'Введите название города в предложном падеже';
                $phone_1 = !empty($panda['phone_1']) ? preg_replace("!\\((.*?)\\)!si"," <span>(\\1)</span>",$panda['phone_1']) : 'Введите телефон 1';
                $phone_2 = !empty($panda['phone_2']) ? preg_replace("!\\((.*?)\\)!si"," <span>(\\1)</span>",$panda['phone_2']) : 'Введите телефон 2';
                $email = !empty($panda['e_mail']) ? $panda['e_mail'] : '';
                $ok = !empty($panda['ok_ok']) ? esc_url($panda['ok_ok']) : 'javascript:void(0);';
                $vk = !empty($panda['vk_vk']) ? esc_url($panda['vk_vk']) : 'javascript:void(0);';
                $count_posts = wp_count_posts();
                $args1 = array(
                    'hide_empty' => false,
                    'orderby' => 'id',
                    'order'=> 'DESC',
                    'exclude' => 1,
                );

                $myterms1 = get_terms( array( 'category' ), $args1 );
                $count  = 1;
                foreach( $myterms1 as $term ){
                    if( 0 == $term->parent) {
                        $args1['parent'] = $term->term_id;
                        $myterms3 = get_terms( array( 'category' ), $args1 );
                        foreach( $myterms3 as $term2 ){
                            $count ++;
                        }
                    }
                } ?>
                <div class="about-title"><img src="<?php echo get_re_img_src('about-title.png') ?>" alt=""></div>
                <div class="about-title2">К вашим услугам бесплатный Сервис подбора репетиторов Садись, 5!</div>
                <div class="about-left">
                    <div class="about-block-title">Самый крупный информационный портал<br>о репетиторах в <?php echo $city ?></div>
                    База данных насчитывает более <?php echo $count_posts->publish ?>&nbsp;<?php echo declOfNum_title($count_posts->publish, array(__('преподователя','wp_panda'), __('преподавателей','wp_panda'), __('преподавателей','wp_panda'))) ?>,которые помогут вам усвоить знания по всем предметам образовательных дисциплин.
                    <ul>
                        <li>Иностранные языки</li>
                        <li>Точные науки</li>
                        <li>Гуманитарные</li>
                    </ul>
                </div>
                <div class="about-right">
                    <div class="about-block-title">Всего <?php echo $count ?>&nbsp;<?php echo declOfNum_title($count, array(__('направления','wp_panda'), __('направлений','wp_panda'), __('направлений','wp_panda'))) ?>,
                        <?php echo declOfNum_title($count, array(__('который','wp_panda'), __('которые','wp_panda'), __('которые','wp_panda'))) ?> могут<br>вас заинтересовать</div>
                    Предлагаются специальные программы:
                    <ul>
                        <li>по подготовке ребенка к школе; </li>
                        <li>по подготовке к сдаче экзаменов (ОГЭ, ЕГЭ); </li>
                        <li>по исправлению дефектов речи; </li>
                        <li>а также занятия с психологами.</li>
                    </ul>
                </div>
                <div class="about-hidden">
                    <div class="about-block-title">Всего <?php echo $count ?>&nbsp;<?php echo declOfNum_title($count, array(__('направления','wp_panda'), __('направлений','wp_panda'), __('направлений','wp_panda'))) ?>, <?php echo declOfNum_title($count, array(__('который','wp_panda'), __('которые','wp_panda'), __('которые','wp_panda'))) ?> могут  вас заинтересовать</div>
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <?php the_content() ?>
                    <?php endwhile; else: ?>
                        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php endif; ?>
                </div>
                <div class="abuot-read-more">
                    <a href="javascript::void(0)" class="about-more">Читать далее</a>
                </div>
                <div class="about-contact-title">КОНТАКТНАЯ ИНФОРМАЦИЯ</div>
                <div class="about-contact">
                    <div class="about-tel"><?php echo str_replace('+7 ', '',$phone_1); ?>&nbsp;&nbsp;<?php echo str_replace('+7 ', '',$phone_2); ?></div>
                    <div class="about-mail"><a href="mailto:<?php echo $email; ?>" class="mail-link"><?php echo $email; ?></a></div>
                    <a href="<?php echo $vk; ?>" class="about-vk"><img src="<?php echo get_re_img_src('vk3.png'); ?>" alt=""></a>
                    <a href="<?php echo $ok; ?>" class="about-ok"><img src="<?php echo get_re_img_src('odnoklasniki3.png')?>" alt=""></a>
                </div>
                <div class="about-map-title">Нам доверяют 1000 репетиторов и более 7000 учеников</div>
                <div id="map"class="about-map">
                    <a href="<?php echo home_url('/otzyvy/');?>" class="create-anketa">Все отзывы</a>
                    <!--div class="aboup-map-icon">
                        <div class="about-map-hover">
                            <strong>Иван (11 класс школы № 74, Астрахань)</strong>
                            Менеджеры "Садись 5" подобрали мне репетитора по математике. После полугода занятий сдал ЕГЭ на 78 баллов - я доволен. Рекомендую сайт всем своим знакомым.
                        </div>
                    </div>
                    <div class="aboup-map-icon" style="top:300px;left:600px;">
                        <div class="about-map-hover">
                            <strong>Иван (11 класс школы № 74, Астрахань)</strong>
                            Менеджеры "Садись 5" подобрали мне репетитора по математике. После полугода занятий сдал ЕГЭ на 78 баллов - я доволен. Рекомендую сайт всем своим знакомым.
                        </div>
                    </div>
                    <div class="aboup-map-icon" style="top:400px;left:700px;">
                        <div class="about-map-hover">
                            <strong>Иван (11 класс школы № 74, Астрахань)</strong>
                            Менеджеры "Садись 5" подобрали мне репетитора по математике. После полугода занятий сдал ЕГЭ на 78 баллов - я доволен. Рекомендую сайт всем своим знакомым.
                        </div>
                    </div-->
                </div>

                <script>

                    var myMap;

                    // Дождёмся загрузки API и готовности DOM.
                    ymaps.ready(init);

                    function init () {
                        // Создание экземпляра карты и его привязка к контейнеру с
                        // заданным id ("map").
                        myMap = new ymaps.Map('map', {
                            // При инициализации карты обязательно нужно указать
                            // её центр и коэффициент масштабирования.
                            center: [37.64,55.76 ], // Москва
                            zoom: 10,
                            controls: []
                        }, {
                            searchControlProvider: 'yandex#search'
                        });
                    }

                </script>
                <div class="about-forms">
                    <div class="about-form">
                        <div class="about-form-title">Заявка на подбор репетитора</div>
                        <input type="text" class="name" placeholder="Имя">
                        <input type="text" class="tel" placeholder="Телефон">
                    </div>
                    <div class="about-form">
                        <div class="about-form-title about-form-title2">Стать репетитором</div>
                        <input type="text" class="name" placeholder="Имя">
                        <input type="text" class="tel" placeholder="Телефон">
                    </div>
                    <div class="about-form">
                        <div class="about-form-title">Доска заявок</div>
                        <a href="<a href="<?php echo $panda['order_url'] ?>"><img src="<?php echo get_re_img_src('doska.png') ?>" alt=""></a>
                    </div>
                </div>
                <div style="height:130px;padding:10px 0 0 0;">
                    <div class="about-blue">
                        <ul>
                            <li>Заполните форму заявки, и персональный менеджер в течение 20 минут свяжется с вами и бесплатно подберет наиболее подходящего репетитора.</li>
                            <li>Зарегистрируйтесь в нашей базе репетиторов, и получайте новых учениво круглый год! Мы подберем Вам учеников в соответствии с Вашими пожеланиями</li>
                            <li>Идеальная площадка для выбора подходящих учеников</li>
                        </ul>
                    </div>
                </div>
                <div class="about-buttons">
                    <ul>
                        <li><a href="<?php echo $panda['podbor_url'] ?>" class="green-button">Найти репетитора</a></li>
                        <li><a href="<?php echo $panda['one_step_url'] ?>" class="green-button">Зарегистрироваться</a></li>
                        <li><a href="<?php echo $panda['order_url'] ?>" class="green-button">Найти</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
<?php get_footer() ?>