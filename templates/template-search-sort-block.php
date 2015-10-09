<?php
if( is_archive() || is_category() ) {
$cat = get_query_var('cat');
?>
    <div class="sort-block" data-catter="<?php echo $cat; ?>">
    <?php } else { ?>
    <div class="sort-block">
        <?php } ?>
        <div class="sort-left">Цена занятия:
            <a href="javascript:void(0);" class="prise-down" data-sort="DESC">по убыванию</a>
            <a href="javascript:void(0);" class="prise-up" data-sort="ASC">по возрастанию</a>
        </div>

        <div class="sort-right">Вывод анкет:
            <a href="javascript:void(0);" class="view-list" data-show="list">списком</a>
            <a href="javascript:void(0);" class="view-list2" data-show="grid">плиткой</a>
        </div>
        <div class="clearfix"></div>
    </div>