<?php
global $panda;
$href = !empty($panda['one_step_url']) ? $panda['one_step_url'] : 'javascript:void(0);';
$order = !empty($panda['order_url']) ? $panda['order_url'] : 'javascript:void(0);';
$o_nas_url = !empty($panda['o_nas_url']) ? $panda['o_nas_url'] : 'javascript:void(0);';
?>
<div class="registr-block">
    <div class="wr">
        <h3><?php _e('СТАНЬТЕ РЕПЕТИТОРОМ СЛУЖБЫ','wp_panda'); ?></h3>
        <div class="regblock-text">
            <?php _e('С нами вы сможете создать стабильный<br>канал новых учеников и оптимально<br>заполнить ваш график занятий.','wp_panda'); ?>
            <div class="reg-links">
                <a href="<?php echo $href ?>" class="create-anketa"><?php _e('Создать анкету','wp_panda'); ?></a>
                <a href="<?php echo $order; ?>" class="create-anketa create-doska"><?php _e('Доска заявок','wp_panda'); ?></a>
                <div class="clearfix"></div>
                <a href="<?php echo $o_nas_url; ?>" class="more-main"><?php _e('Подробнее о работе сервиса','wp_panda'); ?></a>
            </div>
        </div>
    </div>
</div>