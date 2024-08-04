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
        <div class="accept">Ваш заказ принят!</div>
        <div class="d-flex">
            <div class="left ">
                <div>
                    <div class="numberOrder">Номер заказа <span>{{Session::get('id_orders')}}</span></div>
                    <p>
                        <span class="info-span">Статус заказа:</span>
                        <span>Ожидает оплаты</span>
                    </p>
                </div>
                <div>
                    <div class="detalis">Детали получения</div>
                    <p>
                        <span class="info-span">
                            Способ получения:
                        </span>
                        <span>
                            Самовывоз из магазина
                        </span>
                    </p>
                    <p>
                        <span class="info-span">
                            Адрес магазина самовывоза:
                        </span>
                        <span>
                            Ленинградская ул., 26/2, Асбест, Россия
                        </span>
                    </p>
                    <p>
                        <span class="info-span">
                           Зарезервирован до :
                        </span>
                        <span>
                            @foreach($orders as $order)
                                <?php
                            $date=$order->order_date;

                                $datetime = new DateTime($date);
                                $datetime->add(new DateInterval('P3D'));
                                   $datetime->format('d-m-Y H:m');?>

                                @endforeach
                            {{$datetime->format('d-m-Y H:m')}}
                        </span>
                    </p>
                </div>
            </div>
            <div class="right ">
                <div class="OrderList">Состав заказа</div>
                @foreach($orders as $order)
                    <div class="OrderList-items">
                        <div class='OrderList-name'>

                        {{--    <img  width="60" height="60" src='{{asset('/storage/'.$order->url)}}'>--}}
                            <div style="   ">{{$order->name}}</div>
                        </div>
                        <div class="count"> {{$order->count_product}} шт.</div>
                        <div class="OrderList-price"> {{$order->price}}<i class='icon '></i></div>

                    </div>
                @endforeach
                <div class="order-total">
                    <label>Итого:</label>
                    <div class="title-total-price">{{Session::get('orderPrice')}}<i class='icon'></i>
                    </div>

            </div>
        </div>
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

