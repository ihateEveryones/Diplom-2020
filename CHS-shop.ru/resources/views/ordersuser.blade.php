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
@include('includes.top')
<body>
<main>
    @foreach($idOrder as $id)
        <div class="container">
            <div class="row justify-content-center" style="margin-bottom: 25px;margin-top: 25px">
                <div class="col-md-8">
                    {{$check=false}}
                    {{$pricecheck=false}}
                    @foreach($ordersUser as $orders)
                        @if($orders->id_order==$id->id_order)
                            @if($check==false)

                                <div class="card-header" style="color: #000;font-weight: 700; font-size: 18px">
                                    Заказ {{$orders->id_order}} от {{$orders->order_date}} {{$orders->status}}
                                </div>
                                <?php
                                $check = true             ?>
                            @endif
                            <div class="card">

                                <div class="card-body">
                                    <div class='in-top'>
                                        <div class='in-top-div-name'><a class='in-top-a-name'
                                                                        href='{{ url('product', 'id_product='.$orders->id_product) }}'><img
                                                    class='in-top-img' src='{{asset('/storage/'.$orders->url)}}'></a>
                                        </div>
                                        <div class='in-top-all'>
                                            <tr><a style="display: block;height: 25px;max-width: 500px;" class=''
                                                   href='{{ url('product', 'id_product='.$orders->id_product) }}'>{{$orders->name}}</a>
                                            </tr>

                                            <div class="" style="margin-top: 20px">
                                                <div class='in-top-count'>
                                                    <label style="margin: 0">Количество {{$orders->count_product}}
                                                        шт.</label>
                                                </div>

                                            </div>
                                        </div>


                                        <div class='in-top-price d-flex'
                                             style='margin-left: 30px;    font-size: 1.3em;'>
                                            <label style="color: #000;font-weight: 700;"></label><span
                                                style="color: gray;">{{$orders->price}}<i class='icon'
                                                                                          style=""></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class='in-top-price d-flex'
                         style='margin-left: 15px;    font-size: 1.3em; position: absolute;left: 75%;bottom: 2%'>

                        <label style="color: #000;font-weight: 700;">Итого:&nbsp; </label><span style="color: gray;"> {{$id->orders_price}}<i
                                class='icon' style=""></i></span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</main>
@include('includes.footer')
</body>

</html>

