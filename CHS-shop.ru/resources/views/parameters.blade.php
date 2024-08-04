<!DOCTYPE html>
<html>
<head>
    <link href="all.css" rel="stylesheet">
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
        <span class="input-group-text" id="addon-wrapping">Search</span>
    </div>
    <input class="form-control" type="text" id="search" placeholder="   text..." aria-describedby="addon-wrapping">
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

    </tr>
    @foreach($orders as $order)
        <form method='get' action="{{action('AllController@orders')}}">
        <tr>

                <td>{{$order->id}}</td>
                <td style='display: none'>{{$order->id_orders}}</td>
                <td>
                    <input style='width: 50px' id='role' name='id_orders'
                           value="{{$order->id_orders}} ">
                </td>
                <td style='display: none'>{{$order->id_product}}</td>
                <td><input readonly id='email' name='id_product' value="{{$order->id_product}} "></td>
                <td style='display: none'>{{$order->orders_count}}</td>
                <td><input style='width: 120px' id='name' name='orders_count'
                           value=" {{$order->orders_count}}">
                </td>
                <td style='display: none'>{{$order->order_price}}</td>
                <td><input id='image' name='order_price' value=" {{$order->order_price}} "></td>
                <td style='display: none'>{{$order->emailorders}}</td>
                <td><input id='image' name='emailorders' value=" {{$order->emailorders}} "></td>
                <td><input class='btn btn-info' type='submit' value='Удалить' name='delete'></td>

        </tr>
        </form>
    @endforeach
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
