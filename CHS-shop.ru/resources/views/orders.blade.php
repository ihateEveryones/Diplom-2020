<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Магазин компьютерных комплектующих</title>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>
<body>
<br>
<div class="input-group flex-nowrap">
    <div class="input-group-prepend">
        <span class="input-group-text" id="addon-wrapping">Поиск</span>
    </div>
    <input class="form-control" type="text" id="search" placeholder=" " aria-describedby="addon-wrapping">
</div>

<br/>
<table id="myTable" class="table table-dark">
    <tr class="header">
        <th scope="col">id</th>
        <th scope="col">id_заказа</th>
        <th scope="col">id_продукта</th>
        <th scope="col">количество</th>
        <th scope="col">цена заказа</th>
        <th scope="col">email</th>
        <th scope="col">телефон</th>
        <th scope="col">статус</th>
        <th scope="col">дата заказа</th>
        <th scope="col">дата резерва</th>

    </tr>

    @foreach($orders as $order)
        <form method='get' action="{{action('AllController@orders')}}">
            <tr>
                <td>{{$order->id}}</td>
                <td style="text-align: center" ><input  type="hidden" id='id_orders' name='id_orders' value=" {{$order->id_order}} ">{{$order->id_order}}</td>
                <td style='text-align: center'>{{$order->id_product}}</td>
                <td style='text-align: center'>{{$order->count_product}}</td>
                <td style='text-align: center'>{{$order->orders_price}}  <i class='icon'></i></td>
                <td style='text-align: center'><input type="hidden" id='email' name='email' value=" {{$order->email}} ">{{$order->email}}</td>
                <td style='text-align: center'>{{$order->phone}}</td>
                <td style='display: none'>{{$order->status}}</td>
                <td> <input id='status' name='status' value=" {{$order->status}} "></td>
                <td style='display: none'>{{$order->order_date}}</td>
                <td style='text-align: center'>{{$order->order_date}}</td>
                <td style='text-align: center'>{{$order->reserved_date}}</td>
                <td><input class='btn btn-info' type='submit' value='Удалить' name='delete'></td>
                <td><input class='btn btn-info' type='submit' value='Изменить' name='change'></td>
            </tr>
        </form>
    @endforeach
    {{$orders->links()}}
    {{--    if (isset($_POST['delete'])) {

        mysqli_query($link, "DELETE FROM `orders` WHERE `id`=$id AND `emailorders`='$emailorders'");
        echo '
        <script>location.replace("orders.php")</script>
        ';
        }
        ?>--}}
</table>

<script>
    $("#search").on("keyup", function () {
        var value = $(this).val();

        $("table tr").each(function (index) {
            if (index !== 0) {
                var id = $(this).children().text()
                if (id.indexOf(value) < 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            }
        });
    });

</script>

</body>

<?php
/*require_once 'scrollTop.php'; */?>

</html>
