<?php
$sep = get_re_img_src('bread-arrow.png');
if( function_exists('kama_breadcrumbs') )
    kama_breadcrumbs('&nbsp;&nbsp;<img src="' . $sep . '">&nbsp;&nbsp;');