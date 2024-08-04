<?php
session_start();
?>
<html>
<head>
    <link href="all.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
</head>
<title>
    Добавление товара
</title>

<body>
<form method='post' action="{{action('AllController@addproduct')}}" enctype="multipart/form-data">
    {{csrf_field()}}
    <div style="text-align: center">
        <h3>Добавление Товара</h3>
        <label for="name">Категория товара</label>
        <div>
            <select id="categories" name="id_categories">

                @foreach ($topcategories as $categories)


                    <option value="{{$categories->id_categories}}  ">{{$categories->name}}</option>

                @endforeach


            </select>
        </div>

        <label for="name">Производитель товара</label>
        <div>


            <select id="vendors" name="vendors" style="width: 175px">

                        @foreach($vendor as $vend)
                            @if($vend->vendors!=""&&$vend->vendors!="0")
                            <option id="vendor" value="{{$vend->vendors}}">{{$vend->vendors}}</option>
                            @endif
                        @endforeach

            </select>
        </div>


        <label for="name">Название товара</label>
        <div>

            <input id="name" name="name">

        </div>

        <script>

            $('#name').on('input', function () {
                var bool = true, flag = false;

                if ($('#name').val().indexOf($("#vendors").val()) != -1) {
                    bool = false;
                    /*if ($('#vendor').val() != $('#name').val()) {*/
                    $('#adds').prop('disabled', bool);
                    $("#errmsg").text("");
                } else {
                    $("#errmsg").text("не относиться к выбранному производителю");
                    $('#adds').prop('disabled', bool);
                }
            });


        </script>
        <div class="dev" id="errmsg"></div>

        <label for="name">Цена товара</label>
        <div>
            <input id="price" type="number" name="price" value="">
        </div>


        <label for="name">Краткое описание товара</label>
        <div>
            <input name="short_description">
        </div>


        <label for="name">Описание товара</label>
        <div>
            <input  name="description"><br>
        </div>
        <br>


        <label for="name">Количество товара</label>
        <div>
            <input name="count">
        </div>


        <label for="name">Изображение товара</label>
        <div>
            <input type="file" name="images"><br>
        </div>
        <br>
        <input class='btn btn-outline-secondary' type='submit' name='adds' id='adds' value='добавить товар'>

    </div>

</form>

</body>
</html>
