<?php
global $panda;
$city = $panda['site_city'] ? $panda['site_city'] : '';
$city_district = $panda['city_district'] ? $panda['city_district'] : array();
$site_student = $panda['site_student'] ? $panda['site_student'] : array();
$lesson_time = $panda['lesson_time'] ? $panda['lesson_time'] : array();
?>
<form id="register-step-2">
    <!--div class="reg2-left-colum"-->
    <div class="reg2-textareas">
        <div class="rl-osebe ttgray">
            <strong>О себе:</strong>
            <textarea id="about_us" name='about_us' placeholder="Подробнее напишите о методике обучения. Как проходят ваши занятия? Какие приемы, пособия используете в обучении, а также ваши положительные стороны. *"></textarea>
            <div class="input-eror">Это поле обязательно для заполнения</div>
        </div>
        <div class="rl-obrazovanue">
            <strong>Образование:</strong>
            <div id="text-clonner">
                <textarea id="education" name="education[]" placeholder="Укажите полное название учреждения, факультета, специальности,год окончания. А так же присвоенную академическую степень или квалификацию."></textarea>
            </div>
        </div>
        <a href="#" id="add-experirnse" class="rb-add">Добавить еще</a>
    </div>

    <div id="work-appended">

        <div id="work-appender">
            <div id="work-clonner">

                <div class="rr-oput2 reg3-line ime">
                    <strong>Опыт работы в образовательных учреждениях:</strong>
                    <input type="text" name="company[]" placeholder="Название организации">
                    <input type="text" name="role[]" placeholder="Должность">
                </div>

                <div class="rr-work-time">

                    <span class="rr-time-title">Годы работы:</span>
                    <span>c</span>

                    <div class="rf-select">
                        <select name="work_start[]">
                            <?php $x=1949;
                            while ($x++<(date('Y'))) echo '<option value="' . $x . '">' . $x . '</option>';
                            ?>
                        </select>
                    </div>

                    <span>по</span>

                    <div class="rf-select">
                        <select name="work_stop[]">
                            <?php $x=1949;
                            while ($x++<(date('Y'))) echo '<option value="' . $x . '">' . $x . '</option>';
                            ?>
                        </select>
                    </div>

                </div>

            </div>
        </div>
        <a href="#" id="work-location-list" class="rb-add">Добавить еще</a>

    </div>

    <div class="clearfix"></div>

    <div class="reg3-line">

        <div class="rr-oput">
            <strong>Опыт работы (лет):</strong>
            <div class="rf-select">
                <select name="experience" id="experience">
                    <?php
                    $x=0;
                    while ($x++<50) echo '<option value="' . $x . '">' .  declOfNum($x, array(' год', ' года', ' лет')) . '</option>';?>
                </select>
            </div>
        </div>

        <div class="rl-col2">
            <strong>Подготовка к экзаменам</strong>
            <div class="radio-ceck"><input type="checkbox" id="oge" name="oge">Подготовка к ОГЭ (ГИА)</div>
            <div class="radio-ceck"><input type="checkbox" id="ega" name="ega">Подготовка к ЕГЭ</div>
        </div>

        <div class="rr-starus">
            <div class="rf-select required">
                <select id="status" name="status">
                    <option>Ваш текущий статус *</option>
                    <?php
                    foreach( $panda['teacher_status'] as $key=>$val ) {
                        $k = (int)$key+1;
                        echo '<option value="' .$k . '">' . $val . '</option>';
                    } ?>
                </select>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>

    <div class="rl-spetsializ">
        <strong>Выберите ваши специализации:</strong>
        <?php $args = array(
            'hide_empty' => false,
            'orderby' => 'id',
            'order'=> 'DESC',
            'exclude' => 1
        );

        $myterms = get_terms( array( 'category' ), $args );
        // $myterms = get_terms( 'post_tag', $args );
        foreach( $myterms as $term ){
            if( 0 == $term->parent) {
                echo '<ul>';
                echo '<li><a href="#">' . $term->name .'</a></li>';
                $args['parent'] = $term->term_id;
                $myterms2 = get_terms( array( 'category' ), $args );
                foreach( $myterms2 as $term2 ){
                    //$category_link = get_category_link( $term2->term_id );
                    echo '<li><div class="radio-ceck"><input type="checkbox" name="specialization[]" value="' . $term2->term_id . '"><a href="javascript:void(0);">' . $term2->name . '</a></div></li>';
                }
                echo '</ul>';
            }
        } ?>
        <div class="clearfix"></div>
    </div>


    <div class="reg4-line">

        <div class="rl-col1">
            <strong>Категория учеников</strong>
            <?php
            if ( !empty($site_student) ) {
                foreach ($site_student as $one)
                    echo '<div class="radio-ceck"><input  type="checkbox" name="category_student[' . $one . ']" value="' . $one . '">' . $one . '</div>';
            } else {
                echo 'Районы не введены';
            }
            ?>
        </div>

        <div class="rl-col2">
            <strong>Занятия Онлайн (Skype)</strong>
            <div class="radio"><input id="r10" type="radio" name="skype" value="yes"><label for="r10">Да</label></div>
            <div class="radio"><input id="r11" type="radio" name="skype" value="no" checked="checked"><label for="r11">Нет</label></div>
        </div>

        <div class="r-plase">
            <strong>
                Место занятий *
            </strong>
            <div class="radio"><input id="r13" type="radio" name="location_lesson" value="home"><label for="r13">Только у меня</label></div>
            <div class="radio"><input id="r14" type="radio" name="location_lesson" value="road"><label for="r14">Только у ученика</label></div>
            <div class="radio"><input id="r15" type="radio" name="location_lesson" value="all"><label for="r15">Возможны оба варианта</label></div>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="reg2-adress">
        <strong>Место проживания:</strong>
        <input id="city" type="text" placeholder="Город" name="city" value="<?php echo $city; ?>">
        <div class="rf-select district required ttgray">
            <select name="district" id="district">
                <?php
                if ( !empty($city_district) ) {
                    foreach ($city_district as $one)
                        echo '<option value="' . $one . '">' . $one . '</option>';
                } else {
                    echo '<option>Районы не введены</option>';
                }
                ?>
            </select>
        </div>
        <div class="clearfix"></div>
        <input type="hidden" id="geo" name="geo">
        <input type="text" placeholder="Дом" class="reg3-dom" id="house" name="house">
        <input type="text" placeholder="Улица / Проезд / Переулок" class="adress-input" id="address" name="address">

        <div class="rr-please hidden-nodesktop">
            <div class="district-check ttgray">
                <strong>
                    Районы выезда
                </strong>
                <?php
                if ( !empty($city_district) ) {
                    foreach ($city_district as $one)
                        echo '<div class="radio-ceck"><input type="checkbox" name="location_district['. $one .']" value="' . $one . '">' . $one . '</div>';
                } else {
                    echo '<option>Районы не введены</option>';
                }
                ?>
            </div>
        </div>

    </div>





    <div class="clearfix"></div>

    <div class="reg-map hidden-nodesktop">
        <div id="reg-map-2" class="reg-map-2" style="height: 300px;">
            <!--iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d44055.569889874256!2d48.05675744999999!3d46.36000045000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x41a90584a786c9ed%3A0x5a2144fabe5dcac2!2z0JDRgdGC0YDQsNGF0LDQvdGMLCDQkNGB0YLRgNCw0YXQsNC90YHQutCw0Y8g0L7QsdC7Liwg0KDQvtGB0YHQuNGP!5e0!3m2!1sru!2sua!4v1431677594812" style="width:100%; height:300px;border:none;" ></iframe-->
        </div>
        <script>
            (function($){
                ymaps.ready(init);

                function init() {
                    var myPlacemark,
                        myMap = new ymaps.Map('reg-map-2', {
                            center: [55.753994, 37.622093],
                            zoom: 9
                        }, {
                            searchControlProvider: 'yandex#search'
                        });
                    ymaps.geocode('Астрахань', {
                        /**
                         * Опции запроса
                         * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/geocode.xml
                         */

                    }).then(function (res) {
                        // Выбираем первый результат геокодирования.
                        var firstGeoObject = res.geoObjects.get(0),
                        // Координаты геообъекта.
                            coords = firstGeoObject.geometry.getCoordinates(),
                        // Область видимости геообъекта.
                            bounds = firstGeoObject.properties.get('boundedBy');

                        // Добавляем первый найденный геообъект на карту.
                        //myMap.geoObjects.add(firstGeoObject);
                        myPlacemark = createPlacemark(coords);
                        myMap.geoObjects.add(myPlacemark);
                        myPlacemark.events.add('dragend', function () {
                            getAddress(myPlacemark.geometry.getCoordinates());
                        });
                        // Масштабируем карту на область видимости геообъекта.
                        myMap.setBounds(bounds, {
                            // Проверяем наличие тайлов на данном масштабе.
                            checkZoomRange: true
                        });
                    });


                    // Слушаем клик на карте
                    myMap.events.add('click', function (e) {
                        var coords = e.get('coords');

                        // Если метка уже создана – просто передвигаем ее
                        if (myPlacemark) {
                            myPlacemark.geometry.setCoordinates(coords);
                        }
                        // Если нет – создаем.
                        else {
                            myPlacemark = createPlacemark(coords);
                            myMap.geoObjects.add(myPlacemark);
                            // Слушаем событие окончания перетаскивания на метке.
                            myPlacemark.events.add('dragend', function () {
                                getAddress(myPlacemark.geometry.getCoordinates());
                            });
                        }
                        getAddress(coords);
                    });

                    // Создание метки
                    function createPlacemark(coords) {
                        return new ymaps.Placemark(coords, {
                            iconContent: 'Передвиньте метку для определения адреса'
                        }, {
                            preset: 'islands#greyStretchyIcon',
                            draggable: true
                        });
                    }

                    // Определяем адрес по координатам (обратное геокодирование)
                    function getAddress(coords) {
                        myPlacemark.properties.set('iconContent', 'Передвиньте метку для определения адреса');
                        ymaps.geocode(coords).then(function (res) {
                            var firstGeoObject = res.geoObjects.get(0);

                            myPlacemark.properties
                                .set({
                                    iconContent: firstGeoObject.properties.get('name'),
                                    balloonContent: firstGeoObject.properties.get('text')
                                });
                            var $coordinata  = res.metaData.geocoder.request, //Координата
                                $country     = firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.AddressDetails.Country.CountryName'), //Город
                                $state       = firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName'),//Область
                                $city        = firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName'), //Населенный пункт
                                $street      = firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.Thoroughfare.ThoroughfareName'), //Улица
                                $house       = firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.Thoroughfare.Premise.PremiseNumber');//Дом
                            console.log('Координата: ',$coordinata );
                            //console.log('Метаданные геокодера: ', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData'));
                            console.log('Страна: ', $country);
                            console.log('Область: ', $state );
                            console.log('Населенный пункт: ', $city );
                            console.log('Улица', $street );
                            console.log('Дом', $house  );

                            $('input#geo').val($coordinata);
                            $('input#address').val($street);
                            $('input#house').val($house);
                            $('input#city').val($city);
                        });


                    }
                }
            })(jQuery);
        </script>
    </div>
    <div class="reg-map-text">
        Вы можете скорректировать положение метки, перетаскивая ее мышью. <span>Совет</span>: Если Вы<br>
        беспокоитесь о конфиденциальности адреса, сместите метку немного в сторону от точного адреса.
    </div>
    <div class="reg-bottom">
        <div class="reg-prise-block">
            <div class="otsenka-block">
                <div class="one">0</div>
                <div class="ten">1000</div>
                <div class="otsenka-title">Стоимость занятия:</div>
                <div id="slider2"></div>
                <span id="contentSlider2">0</span>
            </div>
        </div>
        <div class="reg-bottom-right">
            <strong>Дополнительно за выезд</strong>
            <input type="text" name="ran_addon" placeholder="Введите сумму">
            <strong>Длительность занятия</strong>

            <div class="rf-select">
                <select id="lesson_time" name="lesson_time">
                    <option>Выберите время</option>
                    <?php foreach ( $lesson_time as $time ){
                    echo "<option value='" . $time . "'>" . $time . "</option>";
                     } ?>
                </select>
            </div>
        </div>
        <div class="clearfix"></div>
        <!--a href="#dialog1" class="green-button" name="modal">Отправить</a-->
        <input style="padding: 0;" class="green-button" type="submit" value="Отправить" />
    </div>

    <div class="clearfix"></div>
</form>