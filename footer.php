<?php global $panda;
$news = !empty($panda['news_url']) ? esc_url($panda['news_url']) : 'javascript:void(0);';
$o_nas_url = !empty($panda['o_nas_url']) ? esc_url($panda['o_nas_url']) : 'javascript:void(0);';
$order_url = !empty($panda['order_url']) ? esc_url($panda['order_url']) : 'javascript:void(0);';
$rega = !empty($panda['one_step_url']) ? esc_url($panda['one_step_url']) : 'javascript:void(0);';
$ok = !empty($panda['ok_ok']) ? esc_url($panda['ok_ok']) : 'javascript:void(0);';
$vk = !empty($panda['vk_vk']) ? esc_url($panda['vk_vk']) : 'javascript:void(0);';
$dogovor_url = !empty($panda['dogovor_url']) ? esc_url($panda['dogovor_url']) : 'javascript:void(0);';
$phone_1 = !empty($panda['phone_1']) ? preg_replace("!\\((.*?)\\)!si"," <span>(\\1)</span>",$panda['phone_1']) : 'Введите телефон 1';
$phone_2 = !empty($panda['phone_2']) ? preg_replace("!\\((.*?)\\)!si"," <span>(\\1)</span>",$panda['phone_2']) : 'Введите телефон 2';
$email = !empty($panda['e_mail']) ? $panda['e_mail'] : '';

?>
</div><!--.wrapper -->
<?php if(!is_page_template('map-page.php')) { ?>
    <footer class="footer" role="contentinfo">
        <div class="wr">
            <div class="f-menu-block">
                <div class="fmenu-title"><?php _e('Служба','wp_panda') ?></div>
                <ul>
                    <li><a href="<?php echo $o_nas_url; ?>"><?php _e('О нас','wp_panda') ?></a></li>
                    <li><a href="<?php echo $news; ?>"><?php _e('Блог','wp_panda') ?></a></li>
                    <li><a href="<?php echo home_url('/otzyvy/'); ?>"><?php _e('Все отзывы','wp_panda') ?></a></li>
                </ul>
            </div>
            <div class="f-menu-block">
                <div class="fmenu-title"><?php _e('Для репетиторов','wp_panda') ?></div>
                <ul>
                    <li><a href="<?php echo $order_url; ?>"><?php _e('Доска заявок','wp_panda') ?></a></li>
                    <li><a href="<?php echo $dogovor_url; ?>"><?php _e('Договор – Оферта','wp_panda') ?></a></li>
                    <li><a href="<?php echo $rega; ?>"><?php _e('Регистрация','wp_panda') ?></a></li>
                    <?php if (!is_page_template( 'register-step-2.php' ) ) { ?>
                        <li><a href="javascript:void(0);" class="change-info"><?php _e('Изменить анкету','wp_panda') ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="f-menu-block">
                <div class="fmenu-title"><?php _e('Режим работы','wp_panda') ?></div>
                с 9:00 до 21:00<br>(Без выходных)
            </div>
            <div class="f-menu-block">
                <div class="fmenu-title"><?php _e('Мы в сети','wp_panda') ?></div>
                <ul>
                    <li><a href="<?php echo $vk; ?>" class="vk-link"><?php _e('Вконтакте','wp_panda') ?></a></li>
                    <li><a href="<?php echo $ok; ?>" class="odnoklasniki-link"><?php _e('Одноклассники','wp_panda') ?></a></li>
                </ul>
            </div>
            <div class="f-contacts">
                <div class="fmenu-title"><?php _e('Горячая линия','wp_panda') ?></div>
                <a href="<?php echo home_url('kontakty'); ?>" class=""><?php _e('Контакты','wp_panda') ?></a><a href="#"><?php _e('Обратный звонок','wp_panda') ?></a>
                <div class="bot-contact">
                    <p><?php echo str_replace('+7 ', '',$phone_1); ?></p>
                    <p><?php echo str_replace('+7 ', '',$phone_2); ?></p>
                </div>
                <a href="mailto:<?php echo $email; ?>" class="mail-link"><?php echo $email; ?></a>
            </div>
            <div class="clearfix"></div>
            <div class="footer2">
                <div class="footer2-left">
                    <?php _e('Согласно ФЗ РФ №436 информация, опубликованная на сайте, предназначена<br>
                    для любой аудитории, если иное не указано в отношении отдельных материалов.','wp_panda') ?>
                </div>
                <div class="f2-right"><a href="<?php echo $dogovor_url; ?>"><?php _e('Условия использования</a>ИП Яковлев А.С.','wp_panda') ?> <br class="hidden-desktop" />ОГРНИП 310301530500022</div>
                <div class="clearfix"></div>
            </div>
        </div>
    </footer><!--.footer -->


    <div id="boxes">

        <div id="mask"></div>
    </div>

    <div id="dialog1" class="window pupup-window"></div>


    <div id="dialog" class="window pupup-window">
        <a href="#" class="close closer"></a>
        <div class="litebox-top">Нужно изменить информацию в анкете?</div>
        <div class="popup-content">
            <div class="litebox-text3">
                Опишите все подробно.<br>Изменения вступят в силу в течении суток.
            </div>
            <form id="form-change">
                <div class="litebox-form">
                    <input type="text" placeholder="Имя" class="name" id="name-ch" >
                    <input type="text" placeholder="Телефон" class="tel" id="phone-ch" >
                    <textarea id="text-ch" placeholder="Что изменить?" ></textarea>
                    <div class="load-folo">
                        <input name="ava" type="file" placeholder="Загрузить фото">
                    </div>
                </div>

                <a href="javascript:void(0);" id="ggg-ggg" class="green-button">Отправить</a>
            </form>
        </div>
    </div>

    <div class="window pupup-window" id="dialog3">
        <a class="close closer" href="#"></a>
        <div class="litebox-top">Связаться с репититором</div>
        <div class="popup-content">
            <div class="popup-teacher myamazingperfectform-teacher">
                <div class="popup-teacher-foto"><img alt="" src=""></div>
                <div class="popup-teacher-right">
                    <span class="sb-name myamazingperfectform-title">Элина Рамильевна</span>
                    <span class="sd-info1-work">Школьный преподаватель</span>
                </div>
                <div class="clearfix"></div>
            </div>
            <form id="send-teacher">
                <div class="litebox-form otzuv-form myamazingperfectform-inputs">
                    <input type="hidden" name="idd" class="idd"/>
                    <div class="little-container"><input type="text" name="name" id="send-teacher-name" class="name" placeholder="Ваше имя">
                        <div class="input-eror">Это поле обязательно для заполнения</div></div>
                    <div class="little-container"><input type="text" name="phone" class="tel" id="send-teacher-phone" placeholder="Ваш телефон">
                        <div class="input-eror">Это поле обязательно для заполнения</div></div>
                </div>

                <a class="green-button" href="#">Связаться</a>
            </form>
        </div>
    </div>

    <div class="mack"></div>
<?php } else { ?>
    <div class="window pupup-window" id="dialog3">
        <a class="close closer" href="#"></a>
        <div class="litebox-top">Связаться с репититором</div>
        <div class="popup-content">
            <div class="popup-teacher myamazingperfectform-teacher">
                <div class="popup-teacher-foto"><img alt="" src=""></div>
                <div class="popup-teacher-right">
                    <span class="sb-name myamazingperfectform-title">Элина Рамильевна</span>
                    <span class="sd-info1-work">Школьный преподаватель</span>
                </div>
                <div class="clearfix"></div>
            </div>
            <form id="send-teacher">
                <div class="litebox-form otzuv-form myamazingperfectform-inputs">
                    <input type="hidden" name="idd" class="idd"/>
                    <div class="little-container ttgray">
                        <input type="text" name="name" id="send-teacher-name" class="name" placeholder="Ваше имя">
                    </div>
                    <div class="little-container ttgray">
                        <input type="text" name="phone" class="tel" id="send-teacher-phone" placeholder="Ваш телефон">
                    </div>
                </div>

                <a class="green-button" href="#">Связаться</a>
            </form>
        </div>
    </div>
    <div id="dialog1" class="window pupup-window"></div>
    <div class="mack"></div>
<?php } ?>

<?php if( is_page_template('register-step-3.php')) { ?>

    <div id="dialoga" class="window pupup-window" style="display: none;">
        <div class="litebox-top">Отлично!</div>
        <div class="popup-content">
            <div class="reg-litebox-text">
                Поздравляем! Теперь ваша анкета пройдет проверку, в ближайшее  время мы свяжемся с вами для уточнения информации. После этого ваша анкета будет опубликована на сайте и вы сможете получать новых учеников.
                <a href="<?php echo home_url(); ?>" class="green-button" >Готово</a>
            </div>
        </div>
    </div>

<?php } ?>
<?php get_template_part( 'templates/template','main-loader' );?>
<?php wp_footer(); ?>
<script>
    (function($) {
        $(function() {
            //  $('input, select').styler({});

            $('input, select').styler({
                'selectSearch':true,
                'selectVisibleOptions':8,
                'selectPlaceholder':$(this).data('placeholder'),
                'selectSearchPlaceholder' : '',
                'onSelectOpened':function() {
                   // $(this).find('.jq-selectbox__search input').attr('placeholder','');
                    $(this).find('.jq-selectbox__search input').focus();
                   // $one = $(this).find('.jq-selectbox__dropdown ul li').eq(0);
                   // $one.remove();
                   // $(this).find('.jq-selectbox__dropdown ul li').eq(0).remove();
                },
                'onSelectClosed' : function() {
                    $(this).find('.jq-selectbox__select-text').css({'color':'#2c5871'});
                   // $(this).find('.jq-selectbox__dropdown ul').prepend($one);
                    //setTimeout(function() {
                    //    $('input, select').trigger('refresh');
                    //}, 1)

                }
            });


            $(".tel").mask("+7 (999) 999-9999");

        });
    })(jQuery);
</script>

</body>
</html>