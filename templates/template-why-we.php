<?php
global $panda;
$city = !empty($panda['site_city_in']) ? mb_strtoupper($panda['site_city_in']) : 'Введите название города в предложном падеже';
?>
<div class="why-we-block">
    <div class="wr">
        <h3>ПОЧЕМУ "РЕПЕТИТОР <?php echo $city ?>" ?</h3>
        <div class="why-item">
            <img src="<?php re_img_src('why1.png') ?>" alt="">
            <div class="why-item-text">
                <strong>Лучшие преподаватели города</strong>
                Эксперты ЕГЭ,  преподаватели школ и<br>вузов, стаж от 5 до 30 лет.
            </div>
        </div>
        <div class="why-item">
            <img src="<?php re_img_src('why2.png') ?>" alt="">
            <div class="why-item-text">
                <strong>Качественный подбор репетитора</strong>
                Выбирайте сами или доверьте подбор нам.<br>Наши услуги всегда бесплатны.
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="why-item">
            <img src="<?php re_img_src('why3.png') ?>" alt="">
            <div class="why-item-text">
                <strong>Более 6000 учеников</strong>
                Нашли репетитора с нами и успешно прошли<br>обучение, а также оставили <a href="<?php echo get_home_url() ?>/otzyvy/">реальные отзывы.</a>
            </div>
        </div>
        <div class="why-item">
            <img src="<?php re_img_src('why4.png') ?>" alt="">
            <div class="why-item-text">
                <strong>Нам доверяют и нас рекомендуют</strong>
                На рынке репетиторских услуг мы более 5 лет.<br>Лучший сервис в городе.
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>