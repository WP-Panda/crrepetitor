<?php
global $panda;
$phone = $panda['phone_2'];
?>
<div class="order-work">
    <div class="order-work-title">Как это работает</div>
    <div class="order-work-item">
        <img src="<?php re_img_src('ow1.png') ?>" alt="">
        <div class="order-work-text">
            <span>1.</span> Создайте анкету на сайте, пройдите собеседование,<br>получите ваш персональный ID номер.
        </div>
    </div>
    <div class="order-work-item order-work-item-right">
        <img src="<?php re_img_src('ow3.png') ?>" alt="">
        <div class="order-work-text">
            <span>2.</span> Выбирайте наиболее подходящих учеников в<br>списке заявок.
        </div>
    </div>
    <div class="order-work-item">
        <img src="<?php re_img_src('ow2.png') ?>" alt="">
        <div class="order-work-text">
            <span>3.</span> Позвоните нам по телефону <?php echo $phone; ?><br>назовите ваш ID и номер выбранной заявки.
        </div>
    </div>
    <div class="order-work-item order-work-item-right">
        <img src="<?php re_img_src('ow4.png') ?>" alt="">
        <div class="order-work-text">
            <span>4.</span> Мы предоставим Вам контакты ученика<br>совершенно бесплатно!
        </div>
    </div>
    <div class="clearfix"></div>
</div>