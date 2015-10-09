<?php
global $panda;
$phone_1 = !empty($panda['phone_1']) ? preg_replace("!\\((.*?)\\)!si"," <span>(\\1)</span>",$panda['phone_1']) : 'Введите телефон 1';
$phone_2 = !empty($panda['phone_2']) ? preg_replace("!\\((.*?)\\)!si"," <span>(\\1)</span>",$panda['phone_2']) : 'Введите телефон 2';
?>
<div class="top-contact">
    <p><?php echo str_replace('+7 ', '',$phone_1); ?></p>
    <p><?php echo str_replace('+7 ', '',$phone_2); ?></p>
</div>