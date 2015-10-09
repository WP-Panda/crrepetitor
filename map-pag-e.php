<?php
/**
 * Template Name: Карта4
 */
get_header(); ?>

    <div class="map-page">
        <div id="full-page" style="height: 1000px;"></div>
    </div>

    <script>
        var myMap;

        // Дождёмся загрузки API и готовности DOM.
        ymaps.ready(init);

        function init () {
            // Создание экземпляра карты и его привязка к контейнеру с
            // заданным id ("map").
            myMap = new ymaps.Map('full-page', {
                center: [55.7, 37.5],
                zoom: 9,
                controls: ['zoomControl']
            }),
                // Создаем коллекцию.
                myCollection = new ymaps.GeoObjectCollection(),
                // Создаем массив с данными.

                <?php
                $map_array = array('post_type'=> 'post');
                $map_query = new WP_Query($map_array); ?>
                <?php if ( $map_query->have_posts() ) : while ( $map_query->have_posts() ) : $map_query->the_post(); ?>
                <?php endwhile; else: ?>
                <?php endif; ?>

                myPoints = [];
                myPoints[] = {coords: [55.77, 37.46], text: 'Трактир'};
            myPoints =  myPoints.push({coords: [55.66, 37.48], text: 'Кафе'});
             { coords: [55.65, 37.42], text: 'Ресторан' },
             { coords: [55.64, 37.54], text: 'Музей' },
             { coords: [55.54, 37.52], text: 'Библиотека' },
             { coords: [55.53, 37.56], text: 'Школа' },
             { coords: [55.61, 37.61], text: 'Аптека' },
             { coords: [55.80, 37.58], text: 'Бар' },
             { coords: [55.71, 37.35], text: 'Институт' },
             { coords: [55.74, 37.57], text: 'Университет' },
             { coords: [55.58, 37.69], text: 'Больница' },
             { coords: [55.57, 37.70], text: 'Цирк' },
             { coords: [55.55, 37.64], text: 'Магазин' },
             { coords: [55.50, 37.75], text: 'Булочная' },
             { coords: [55.81, 37.73], text: 'Полиция' },
             { coords: [55.73, 37.68], text: 'Салон красоты' },
             { coords: [55.86, 37.76], text: 'Баня' },
             { coords: [55.38, 37.69], text: 'Гараж' },
             { coords: [55.91, 37.50], text: 'Дом' },
             { coords: [55.62, 37.32], text: 'Прачечная' },
             { coords: [55.85, 37.41], text: 'Стадион' },
             { coords: [55.67, 37.24], text: 'Вокзал' }
             ];

            // Заполняем коллекцию данными.
            for (var i = 0, l = myPoints.length; i < l; i++) {
                var point = myPoints[i];
                myCollection.add(new ymaps.Placemark(
                    point.coords, {
                        balloonContentBody: point.text
                    }
                ));
            }

            // Добавляем коллекцию меток на карту.
            myMap.geoObjects.add(myCollection);

            // Создаем экземпляр класса ymaps.control.SearchControl
            var mySearchControl = new ymaps.control.SearchControl({
                options: {
                    // Заменяем стандартный провайдер данных (геокодер) нашим собственным.
                    provider: new CustomSearchProvider(myPoints),
                    // Не будем показывать еще одну метку при выборе результата поиска,
                    // т.к. метки коллекции myCollection уже добавлены на карту.
                    noPlacemark: true,
                    resultsPerPage: 5
                }});

            // Добавляем контрол в верхний правый угол,
            myMap.controls
                .add(mySearchControl, { right: 10, top: 10 });
        }


        // Провайдер данных для элемента управления ymaps.control.SearchControl.
        // Осуществляет поиск геообъектов в по массиву points.
        // Реализует интерфейс IGeocodeProvider.
        function CustomSearchProvider(points) {
            this.points = points;
        }

        // Провайдер ищет по полю text стандартным методом String.ptototype.indexOf.
        CustomSearchProvider.prototype.geocode = function (request, options) {
            var deferred = new ymaps.vow.defer(),
                geoObjects = new ymaps.GeoObjectCollection(),
            // Сколько результатов нужно пропустить.
                offset = options.skip || 0,
            // Количество возвращаемых результатов.
                limit = options.results || 20;

            var points = [];
            // Ищем в свойстве text каждого элемента массива.
            for (var i = 0, l = this.points.length; i < l; i++) {
                var point = this.points[i];
                if (point.text.toLowerCase().indexOf(request.toLowerCase()) != -1) {
                    points.push(point);
                }
            }
            // При формировании ответа можно учитывать offset и limit.
            points = points.splice(offset, limit);
            // Добавляем точки в результирующую коллекцию.
            for (var i = 0, l = points.length; i < l; i++) {
                var point = points[i],
                    coords = point.coords,
                    text = point.text;

                geoObjects.add(new ymaps.Placemark(coords, {
                    name: text + ' name',
                    description: text + ' description',
                    balloonContentBody: '<p>' + text + '</p>',
                    boundedBy: [coords, coords]
                }));
            }

            deferred.resolve({
                // Геообъекты поисковой выдачи.
                geoObjects: geoObjects,
                // Метаинформация ответа.
                metaData: {
                    geocoder: {
                        // Строка обработанного запроса.
                        request: request,
                        // Количество найденных результатов.
                        found: geoObjects.getLength(),
                        // Количество возвращенных результатов.
                        results: limit,
                        // Количество пропущенных результатов.
                        skip: offset
                    }
                }
            });

            // Возвращаем объект-обещание.
            return deferred.promise();
        };
    </script>

    <div class="map-serch">
        <input type="text" placeholder="Введите название предмета" >
        <a href="#" class="wihite-button">Найти</a>
        <a href="#" class="wiev-list">Посмотреть списком</a>
        <div class="clearfix"></div>
    </div>
    <div class="map-points-container">
        <div class="wr">
            <div class="map-point-bloblock" style="top:350px;left:400px;">
                <div class="point-hover">
                    <img src="img/avatar1.jpg" alt="" width="60">
                    <div class="point-img-right">
                        <a href="#" class="point-name">Элина Рамильевна</a>
                        Школьный преподаватель
                        <span class="point-predmet">Математически анализ </span>
                    </div>
                    <div class="point-category"><span>Категория учеников:</span>с 1 по 9 класс</div>
                    <div class="point-prise-block">
                        <div class="point-prise"><span>300 руб.</span></div>
                        60 мин.
                    </div>
                    <a href="#dialog" class="green-button" name="modal">Связаться</a>
                </div>
                <div class="map-point"><div class="map-point-bg"></div><img src="img/avatar1.jpg" width="35" alt=""></div>
            </div>

            <div class="map-point-bloblock" style="top:450px;left:460px;">
                <div class="point-hover">
                    <img src="img/avatar1.jpg" alt="" width="60">
                    <div class="point-img-right">
                        <a href="#" class="point-name">Элина Рамильевна</a>
                        Школьный преподаватель
                        <span class="point-predmet">Математически анализ </span>
                    </div>
                    <div class="point-category"><span>Категория учеников:</span>с 1 по 9 класс</div>
                    <div class="point-prise-block">
                        <div class="point-prise"><span>300 руб.</span></div>
                        60 мин.
                    </div>
                    <a href="#dialog" class="green-button" name="modal">Связаться</a>
                </div>
                <div class="map-point"><div class="map-point-bg"></div><img src="img/avatar1.jpg" width="35" alt=""></div>
            </div>

            <div class="map-point-bloblock" style="top:500px;left:260px;">
                <div class="point-hover">
                    <img src="img/avatar1.jpg" alt="" width="60">
                    <div class="point-img-right">
                        <a href="#" class="point-name">Элина Рамильевна</a>
                        Школьный преподаватель
                        <span class="point-predmet">Математически анализ </span>
                    </div>
                    <div class="point-category"><span>Категория учеников:</span>с 1 по 9 класс</div>
                    <div class="point-prise-block">
                        <div class="point-prise"><span>300 руб.</span></div>
                        60 мин.
                    </div>
                    <a href="#dialog" class="green-button" name="modal">Связаться</a>
                </div>
                <div class="map-point"><div class="map-point-bg"></div><img src="img/avatar1.jpg" width="35" alt=""></div>
            </div>

        </div>
    </div>

<?php get_footer();