<?php
    global $panda;
    $city = !empty($panda['site_city_in']) ? $panda['site_city_in'] : 'Введите название города в предложном падеже';
    $city_district  = !empty($panda['city_district']) ? $panda['city_district'] : array();
    add_action('wp_footer','bottom_complite',600);

?>
<div class="top-select-block">
    <div class="top-select-title">Удобный поиск репетиторов в <?php echo $city; ?></div>
    <div class="top-select-body">
        <span>Выберите своего преподавателя прямо сейчас:</span>
        <form action="<?php echo $panda['podbor_url']; ?>" method="post">
        <input type="text" name="lesson" id="compliter" placeholder="Интересующий предмет">

        <div class="serch-select">
            <select name="district" data-placeholder="Выберите район">
                <?php
                echo '<option></option>';
                if ( !empty($city_district) ) {
                    $n=1;
                    foreach ($city_district as $one=>$key) {
                        echo '<option value="' . $n . '">' . upFirstLetter($key) . '</option>';
                        $n++;
                    }
                } else {
                    echo '<option>' .  __('Районы не введены','wp_panda') .'</option>';
                }
                ?>
            </select>
        </div>
        <button>Найти</button>
        </form>
        <div class="clearfix"></div>
    </div>
</div>