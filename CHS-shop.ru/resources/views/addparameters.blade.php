<?php

?>
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
<title>
    Добавление товара
</title>
<body>
<form method='get' action="{{action('AllController@addparameters')}}">
    <div style="text-align: center">
        <h3>Добавление параметров</h3>

        <label for="name">Товар</label>
        <div>
            <select id="id_products" name="id_product">

                @foreach ($products as $product)

                    @if($product->id_product!=-1)

                        <option  value='  {{$product->id_product}} '> {{$product->id_product}} -
                            {{$product->name}}   </option>
                    @endif
                @endforeach


            </select>
        </div>
     {{--   <label for="name">Параметры товара</label>
        <div>
            <select id="id_parameters" name="id_parameters">
                @foreach($parameters as $parameter)



                       <option  value=' {{$parameter->id_parameters}}'>{{$parameter->parameter_name}} - {{$parameter->parameter_value}}</option>



                @endforeach
            </select>
        </div>--}}
        <label for="name">Название параметра</label>
        <div>

            <input id="name" name="nameParameters">

        </div>
        <br>
        <label for="name">Значение параметра товара</label>
        <div>

            <input id="name" name="valueParameters">

        </div>
        <br>
        <input class='btn btn-outline-secondary' type='submit' name='add_parameter' id='add_parameter'
               value='добавить параметр'>
    </div>
    <?php
/*    if ((isset($_POST['add_parameter']))) {
        $link = mysqli_connect('localhost', 'root', '', 'store');

        $id_product = $_POST['id_product'];
        $id_parameters = $_POST['id_parameters'];
        mysqli_query($link, "INSERT INTO `product_parameters`(`id_product`,`id_parameters`) VALUES ('$id_product','$id_parameters')");
        echo "Параметер добавлен";
        mysqli_close($link);
        echo '<script>location.replace(addparameters.blade.phpe.php")</script>';
    }
    */?>
</form>
</body>
</html>
