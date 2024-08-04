<?php
session_start(); ?>
<html>
<head>

    <link href="css/all.css" href="css/footer.css" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Магазин компьютерных комплектующих</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>
<body class="body">
@include('includes.top')
<main>
    <div class="container">
        <div class="row">
            <div class="categories ">
                @foreach($topcategories as $categorie)


                    <a class='dropdown-item '

                       href='{{ url('products', 'id_categories='.$categorie->id_categories) }}'
                        {{--href='products.blade.php?id_categories={{$categorie->id_categories}}'--}}> {{$categorie->name}}</a>

                @endforeach
            </div>
            <div class="row">

                <div class="slider ">
                    <div class="slider__wrapper" style="border-radius: 8px;margin-top: 10px;margin-bottom: 10px;">
                        <div class="slider__items">
                            <div class="slider__item">

                                <div style="height: 250px; "><img style="height: 100%;width: 100%"
                                                                  src="https://hardzone.es/app/uploads/2018/12/cpu-roundup.jpg">
                                </div>
                            </div>
                            <div class="slider__item">
                                <div style="height: 250px; "><img style="height: 100%;width: 100%"
                                                                  src="https://greentechreviews.ru/wp-content/uploads/2017/01/1-50.jpg">
                                </div>
                            </div>
                            <div class="slider__item">
                                <div style="height: 250px;"><img style="height: 100%;width: 100%"
                                                                 src="https://www.hardwareluxx.ru/images/cdn01/E991D9D8D6DD42F7BF0E23C5451BBBDB/img/DCE285F5CC4A478990D01D73B96F6B02/Kaufberatung-Grafikkarten-Sommer-2019_DCE285F5CC4A478990D01D73B96F6B02.jpg">
                                </div>
                            </div>
                            <div class="slider__item">
                                <div style="height: 250px;"><img style="height: 250px;width: 100%"
                                                                 src="https://3dnews.ru/assets/external/illustrations/2017/09/02/957970/rw1.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="slider__control slider__control_prev" href="#" role="button"></a>
                    <a class="slider__control slider__control_next" href="#" role="button"></a>
                </div>
                <div class="actions ">
                    <div>Акции</div>
                    <div>Товары со скидкой</div>


                </div>
            </div>
        </div>
{{--        <div style="margin: 10px">
            <script type="text/javascript" charset="utf-8" async
                    src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Aecd9a68c08a008e3bbda7164463b035967b24ac0b09d3423e25b04d6e4d9c4ad&amp;width=100%25&amp;height=544&amp;lang=ru_RU&amp;scroll=true">
            </script>
        </div>--}}
    </div>
    {{--@foreach($products as $product)

        @if($product->id_product>-1)
            @include('includes.div')
        @endif

    @endforeach--}}


    <script>
        'use strict';
        var slideShow = (function () {
            return function (selector, config) {
                var
                    _slider = document.querySelector(selector), // основный элемент блока
                    _sliderContainer = _slider.querySelector('.slider__items'), // контейнер для .slider-item
                    _sliderItems = _slider.querySelectorAll('.slider__item'), // коллекция .slider-item
                    _sliderControls = _slider.querySelectorAll('.slider__control'), // элементы управления
                    _currentPosition = 0, // позиция левого активного элемента
                    _transformValue = 0, // значение транфсофрмации .slider_wrapper
                    _transformStep = 100, // величина шага (для трансформации)
                    _itemsArray = [], // массив элементов
                    _timerId,
                    _indicatorItems,
                    _indicatorIndex = 0,
                    _indicatorIndexMax = _sliderItems.length - 1,
                    _stepTouch = 50,
                    _config = {
                        isAutoplay: false, // автоматическая смена слайдов
                        directionAutoplay: 'next', // направление смены слайдов
                        delayAutoplay: 5000, // интервал между автоматической сменой слайдов
                        isPauseOnHover: true // устанавливать ли паузу при поднесении курсора к слайдеру
                    };

                // настройка конфигурации слайдера в зависимости от полученных ключей
                for (var key in config) {
                    if (key in _config) {
                        _config[key] = config[key];
                    }
                }

                // наполнение массива _itemsArray
                for (var i = 0, length = _sliderItems.length; i < length; i++) {
                    _itemsArray.push({item: _sliderItems[i], position: i, transform: 0});
                }

                // переменная position содержит методы с помощью которой можно получить минимальный и максимальный индекс элемента, а также соответствующему этому индексу позицию
                var position = {
                    getItemIndex: function (mode) {
                        var index = 0;
                        for (var i = 0, length = _itemsArray.length; i < length; i++) {
                            if ((_itemsArray[i].position < _itemsArray[index].position && mode === 'min') || (_itemsArray[i].position > _itemsArray[index].position && mode === 'max')) {
                                index = i;
                            }
                        }
                        return index;
                    },
                    getItemPosition: function (mode) {
                        return _itemsArray[position.getItemIndex(mode)].position;
                    }
                };

                // функция, выполняющая смену слайда в указанном направлении
                var _move = function (direction) {
                    var nextItem, currentIndicator = _indicatorIndex;
                    ;
                    if (direction === 'next') {
                        _currentPosition++;
                        if (_currentPosition > position.getItemPosition('max')) {
                            nextItem = position.getItemIndex('min');
                            _itemsArray[nextItem].position = position.getItemPosition('max') + 1;
                            _itemsArray[nextItem].transform += _itemsArray.length * 100;
                            _itemsArray[nextItem].item.style.transform = 'translateX(' + _itemsArray[nextItem].transform + '%)';
                        }
                        _transformValue -= _transformStep;
                        _indicatorIndex = _indicatorIndex + 1;
                        if (_indicatorIndex > _indicatorIndexMax) {
                            _indicatorIndex = 0;
                        }
                    } else {
                        _currentPosition--;
                        if (_currentPosition < position.getItemPosition('min')) {
                            nextItem = position.getItemIndex('max');
                            _itemsArray[nextItem].position = position.getItemPosition('min') - 1;
                            _itemsArray[nextItem].transform -= _itemsArray.length * 100;
                            _itemsArray[nextItem].item.style.transform = 'translateX(' + _itemsArray[nextItem].transform + '%)';
                        }
                        _transformValue += _transformStep;
                        _indicatorIndex = _indicatorIndex - 1;
                        if (_indicatorIndex < 0) {
                            _indicatorIndex = _indicatorIndexMax;
                        }
                    }
                    _sliderContainer.style.transform = 'translateX(' + _transformValue + '%)';
                    _indicatorItems[currentIndicator].classList.remove('active');
                    _indicatorItems[_indicatorIndex].classList.add('active');
                };

                // функция, осуществляющая переход к слайду по его порядковому номеру
                var _moveTo = function (index) {
                    var i = 0, direction = (index > _indicatorIndex) ? 'next' : 'prev';
                    while (index !== _indicatorIndex && i <= _indicatorIndexMax) {
                        _move(direction);
                        i++;
                    }
                };

                // функция для запуска автоматической смены слайдов через промежутки времени
                var _startAutoplay = function () {
                    if (!_config.isAutoplay) {
                        return;
                    }
                    _stopAutoplay();
                    _timerId = setInterval(function () {
                        _move(_config.directionAutoplay);
                    }, _config.delayAutoplay);
                };

                // функция, отключающая автоматическую смену слайдов
                var _stopAutoplay = function () {
                    clearInterval(_timerId);
                };

                // функция, добавляющая индикаторы к слайдеру
                var _addIndicators = function () {
                    var indicatorsContainer = document.createElement('ol');
                    indicatorsContainer.classList.add('slider__indicators');
                    for (var i = 0, length = _sliderItems.length; i < length; i++) {
                        var sliderIndicatorsItem = document.createElement('li');
                        if (i === 0) {
                            sliderIndicatorsItem.classList.add('active');
                        }
                        sliderIndicatorsItem.setAttribute("data-slide-to", i);
                        indicatorsContainer.appendChild(sliderIndicatorsItem);
                    }
                    _slider.appendChild(indicatorsContainer);
                    _indicatorItems = _slider.querySelectorAll('.slider__indicators > li')
                };

                var _isTouchDevice = function () {
                    return !!('ontouchstart' in window || navigator.maxTouchPoints);
                };

                // функция, осуществляющая установку обработчиков для событий
                var _setUpListeners = function () {
                    var _startX = 0;
                    if (_isTouchDevice()) {
                        _slider.addEventListener('touchstart', function (e) {
                            _startX = e.changedTouches[0].clientX;
                            _startAutoplay();
                        });
                        _slider.addEventListener('touchend', function (e) {
                            var
                                _endX = e.changedTouches[0].clientX,
                                _deltaX = _endX - _startX;
                            if (_deltaX > _stepTouch) {
                                _move('prev');
                            } else if (_deltaX < -_stepTouch) {
                                _move('next');
                            }
                            _startAutoplay();
                        });
                    } else {
                        for (var i = 0, length = _sliderControls.length; i < length; i++) {
                            _sliderControls[i].classList.add('slider__control_show');
                        }
                    }
                    _slider.addEventListener('click', function (e) {
                        if (e.target.classList.contains('slider__control')) {
                            e.preventDefault();
                            _move(e.target.classList.contains('slider__control_next') ? 'next' : 'prev');
                            _startAutoplay();
                        } else if (e.target.getAttribute('data-slide-to')) {
                            e.preventDefault();
                            _moveTo(parseInt(e.target.getAttribute('data-slide-to')));
                            _startAutoplay();
                        }
                    });
                    document.addEventListener('visibilitychange', function () {
                        if (document.visibilityState === "hidden") {
                            _stopAutoplay();
                        } else {
                            _startAutoplay();
                        }
                    }, false);
                    if (_config.isPauseOnHover && _config.isAutoplay) {
                        _slider.addEventListener('mouseenter', function () {
                            _stopAutoplay();
                        });
                        _slider.addEventListener('mouseleave', function () {
                            _startAutoplay();
                        });
                    }
                };

                // добавляем индикаторы к слайдеру
                _addIndicators();
                // установливаем обработчики для событий
                _setUpListeners();
                // запускаем автоматическую смену слайдов, если установлен соответствующий ключ
                _startAutoplay();

                return {
                    // метод слайдера для перехода к следующему слайду
                    next: function () {
                        _move('next');
                    },
                    // метод слайдера для перехода к предыдущему слайду
                    left: function () {
                        _move('prev');
                    },
                    // метод отключающий автоматическую смену слайдов
                    stop: function () {
                        _config.isAutoplay = false;
                        _stopAutoplay();
                    },
                    // метод запускающий автоматическую смену слайдов
                    cycle: function () {
                        _config.isAutoplay = true;
                        _startAutoplay();
                    }
                }
            }
        }());

        slideShow('.slider', {
            isAutoplay: true
        });
    </script>


    {{--<footer id="myFooter">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 myCols">
                    <h5>Get started</h5>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Sign up</a></li>
                        <li><a href="#">Downloads</a></li>
                    </ul>
                </div>
                <div class="col-sm-3 myCols">
                    <h5>About us</h5>
                    <ul>
                        <li><a href="#">Company Information</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">Reviews</a></li>
                    </ul>
                </div>
                <div class="col-sm-3 myCols">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Help desk</a></li>
                        <li><a href="#">Forums</a></li>
                    </ul>
                </div>
                <div class="col-sm-3 myCols">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="social-networks">
            <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
            <a href="#" class="twitter"><i class="fa fa-vk"></i></a>
            <a href="#" class="facebook"><i class="fa fa-facebook-official"></i></a>
            <a href="#" class="google"><i class="fa fa-google-plus"></i></a>

        </div>
        <div class="footer-copyright">
            <p>© 2020 CHS </p>
        </div>
    </footer>--}}

</main>
@include('includes.footer')
</body>
{{--<body class="body">

@include('includes.top')
@foreach($products as $product)
        {{Session::put('idProduct',$product->id_product)}}
    @if($product->id_product>-1)

          --}}{{--  {{$id_products->id_product}}--}}{{--



        @include('includes.div')

      --}}{{--  <div class='top'>
            <form style='margin: 0;' method='post' action="{{action('HomeController@buys')}}">
                {{ csrf_field() }}
                <div class='in-top'>

                    <input type="hidden" name="id_product" value="{{$product->id_product}}">
                    <div class='in-top-div-name'><a class='in-top-a-name'
                                                    href='product.php?id={{$product->id_product}}'><img
                                class='in-top-img' src='{{$product->url}}'></a></div>
                    <div class='in-top-all'>
                        <tr><a class='in-top-a' href='product.php?id={{$product->id_product}}'>{{$product->name}}</a>
                        </tr>
                        <span class='in-top-span'>{{$product->short_description}}</span>
                    </div>
                    <div class='in-top-price d-flex' style='margin-left: 30px'>
                        <input type="hidden" name="price" value="{{$product->price}}">
                        {{$product->price}} <i class='icon'></i>
                    </div>
                </div>
                <div style='text-align: right'>
                    <button class='btn btn-outline-secondary' type='submit' id='buy'>Купить</button>
                </div>
            </form>
        </div>--}}{{--

    @endif

@endforeach


</body>--}}
</html>
