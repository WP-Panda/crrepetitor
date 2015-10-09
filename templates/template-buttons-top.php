<?php
global $panda;
$map_url = !empty($panda['map_url']) ? esc_url($panda['map_url']) : 'javascript:void(0);';
$ega_oga_url = !empty($panda['ega_oga_url']) ? esc_url($panda['ega_oga_url']) : 'javascript:void(0);';
?>
<a href="<?php echo $map_url; ?>" class="green-button"><?php _e('Карта репетиторов','wp_panda'); ?></a>
<a href="<?php echo $ega_oga_url; ?>" class="yelow-button"><?php _e('Курсы ОГЭ и ЕГЭ','wp_panda'); ?></a>