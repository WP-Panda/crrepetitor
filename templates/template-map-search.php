<?php global $panda;
$url =$panda['podbor_url']; ?>
<div class="map-serch">
    <input type="text" id="compliter" placeholder="<?php _e('Введите название предмета','wp_panda'); ?>" >
    <a id="search-mapper" href="javascript:void(0);" class="wihite-button"><?php _e('Найти','wp_panda'); ?></a>
    <a href="<?php echo $url; ?>" class="wiev-list"><?php _e('Посмотреть списком','wp_panda'); ?></a>
    <div class="clearfix"></div>
</div>