<html>
<head>
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Магазин компьютерных комплектующих</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
    <!-- Подключение jQuery плагина Masked Input -->
</head>
<body class="body">
@include('includes.top')
<?php
$countsum = 0;
$priceall = 0;
$emailbasket = 0;
$count = 0;
?>
<main>


    <div class="container" style="margin-top: 15px">
        <div class="top ">
            <div class="checkout">Оформление заказа</div>
            <div class="selector ">
                <div class="dropdown-icon d-inline-block">
                    <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                       aria-controls="collapseExample">
                        <i class="arrow down"></i>
                    </a>
                    <div class="title d-inline-block">Подробнее о составе заказа</div>
                </div>
                <div class="products-table">
                    <div class="collapse" id="collapseExample">
                        @if(Session::has('basket'))
                            @foreach(Session::get('basket') as $title)

                                <div class="item">
                                    <div class="title-name">{{$title->name}}</div>
                                    <div class="title-count">{{$title->count}} шт</div>
                                    <div class="title-price">{{$title->price}}&nbsp;<i class='icon'></i></div>
                                </div>
                            @endforeach
                        @endif
                        <div class="title-total-price">Итого: {{Session::get('orderPrice')}}&nbsp;<i class='icon'></i>
                        </div>
                    </div>
                </div>
            </div>

            <form method="get" action="{{action('AllController@order')}}">
                <div class="left-column ">

                    <div class="contact-info ">
                        @if(Auth::user()==null)
                            <div class="unauthorizated-info ">Уже регистрировались на сайте?
                                <a href="/login/">Войдите</a> и Вам не придётся заполнять форму снова, а заказ
                                сохранится в
                                личном
                                кабинете.
                            </div>
                        @endif
                        <div class="order-heading heading-padding">Контактная информация</div>
                        <div class="row">
                            <div class="form-group phone col">
                                <label class="hint-block">
                                    <span class="hint-block pos-right">
                                           Сотовый телефон<sup>*</sup>
                                    </span>
                                </label>
                                @if(Auth::user()==null)
                                    <input  name="phone" required id="phone" class="form-control " @if(isset($_GET['email'])) value="{{$_GET['phone']}}" @endif></div>
                            @else
                                <input required name="phone" id="phone" value="{{Auth::user()->phone}}"
                                       class="form-control  ">
                        </div>
                        @endif
                        @if(isset($mail))
                            <div class="form-group email col">
                                <label class="hint-block">
                                            <span class="hint-block pos-right">Адрес эл. почты<sup>*</sup>
                                            </span>
                                </label>
                                @if(Auth::user()==null)
                                    <input required type="text" name="email"
                                           class="form-control is-invalid"
                                           @if(isset($_GET['email'])) value="{{$_GET['email']}}" @endif>
                                    <span class="invalid-feedback" >
                                        <strong>
                                            Данного почтового адреса не существует.
                                        </strong>
                                    </span>
                            </div>
                        @else
                            <input required type="text" name="email"
                                   class="form-control is-invalid"
                                   value="{{Auth::user()->email}}">
                            <span class="invalid-feedback" style="display: block;">
                                <strong>
                                    Данного почтового адреса не существует.
                                </strong>
                            </span>

                    </div>
                    @endif
                    @else
                        <div class="form-group email col">
                            <label class="hint-block">
                                            <span class="hint-block pos-right">Адрес эл. почты<sup>*</sup>
                                            </span>
                            </label>
                            @if(Auth::user()==null)
                                <input required type="text" name="email"
                                       class="form-control"
                                       value="">
                        </div>
                        @else
                            <input required type="text" name="email"
                                   class="form-control"
                                   value="{{Auth::user()->email}}">
                </div>
                @endif
                @endif
                <div class="form-group appeal col"><label class="hint-block pos-right">Имя</label>
                    @if(Auth::user()==null)
                        <input required
                               name="name"
                               type="text"
                               class="form-control "
                               @if(isset($_GET['email'])) value="{{$_GET['name']}}" @endif>
                    @else
                        <input required
                               name="name"
                               type="text"
                               class="form-control "
                               value="{{Auth::user()->name}}">
                    @endif
                </div>

        </div>
        <div class="footnote">* - поля, отмеченные звёздочкой, обязательны для
            заполнения
        </div>

        <div class="d-flex">
            <div style='text-align: right ;margin-right: 35px'>
                <a class="btn btn-outline-secondary" href="javascript:history.back()">Вернуться в корзину</a>

            </div>
            <div style='text-align: right ;width: 120px;'>
                <input class='btn btn-outline-secondary' type='submit' name='order'
                       id='order' value='оформить заказ'>
            </div>

            <script>

                $(function () {
                    $("#phone").mask("8(999) 999-9999");
                });
            </script>
        </div>
        </form>
    </div>
    </div>
</main>
@include('includes.footer')

</body>


<script>
    function button() {
        alert("Ваш заказ оформлен");
    }
</script>
</head>
</html>

