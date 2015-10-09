<div class="reg1-plashaka">РЕГИСТРАЦИЯ</div>
<?php
global $panda;
if(isset($_SESSION['reg'])) {}?>
<div class="reg1-form-block">
    <div class="regform1-img">
        <div class="rf1-title">Ваше фото<br>для анкеты:</div>
        <!--img src="<?php // re_img_src('no-avatar.jpg') ?>" alt=""-->
        <!--input type="file" name="thefile" id="thebox"-->
        <div id="container_image"></div>
        <div class="photo-about hidden-desktop">Загрузите фото отличного качества в формате JPG или PNG. Ученики всегда охотнее выбирают репетиторов с фотографиями.</div>
        <div>Нажмите на изображение для загрузки картинки</div>
        <!--a href="#" class="create-anketa">Загрузить фото</a-->
    </div>
    <form id="info-step-1" class="rf1-inputs-block">

        <div class="rf-input-wrap ttgray">
            <div class="rf-select">
                <select name="sex" id="sex">
                    <option>Ваш пол *</option>
                    <option value="man">Мужской</option>
                    <option value="woman">Женский</option>
                </select>
                
            </div>
        </div>
        <div class="rf-input-wrap ttgray">
            <input type="text" id="last_name" name="last_name" placeholder="Фамилия *" class="" >
            
        </div>
        <div class="rf-input-wrap ttgray">
            <input type="text" id="name" name="name" placeholder="Имя *" class="" >

        </div>
        <div class="rf-input-wrap ttgray">
            <input type="text" id="father_name" name="father_name" placeholder="Отчество *" class="" >
            
        </div>
        <div class="rf-input-wrap ttgray">
            <div class="rf-select">
                <select id="both_year" name="both_year">
                    <option>Год рождения *</option>
                    <?php
                        $x=1949;
                        while ($x++<(date('Y')-20)) echo '<option value="' . $x . '">' . $x . '</option>';
                    ?>
                </select>
                
            </div>
        </div>
        <div class="rf-input-wrap ttgray">
            <input type="text" id="phone" name="phone" placeholder="" class="tel" >
            <input type="hidden" id="namer" name="namer">
            
        </div>
        <div class="rf-input-wrap ttgray">
            <input type="text" id="e_mail" name="e_mail" placeholder="E-mail адрес">
            
        </div>
        <div class="rf1-input-text">
            Подтверждаю ознакомление и согласие с условиями <a href="<?php echo $panda['dogovor_url']; ?>">Публичной оферты</a> в полном объёме.
        </div>
        <div class="rf-chekbox"><input id="i_accsept" name="i_accsept" type="checkbox"></div>

    </form>
    <div class="clearfix"></div>
</div>
<div class="reg1-form-text">
    <div class="rb1-left hidden-nodesktop">Загрузите фото отличного качества в формате JPG или PNG.
        Ученики всегда охотнее выбирают репетиторов с фотографиями.</div>
    <div class="rb1-right">(Фамилия и контактные телефоны не отображаются в анкете, не распространяются и не передаются кому-либо без вашего согласия)</div>
    <div class="clearfix"></div>
    <a id="send-step-1" href="#" class="green-button">Далее</a>
</div>