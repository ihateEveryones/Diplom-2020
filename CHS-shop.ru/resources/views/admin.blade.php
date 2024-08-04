<html>
<head>
    <link href="css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Магазин компьютерных комплектующих</title>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>
<body>
@include('includes.top')
<div>



<div class='col-4'>
    <a  class='btn btn-outline-secondary'href='javascript:fseedata1()'>Добавить товар</a>
    <a  class='btn btn-outline-secondary'href='javascript:fseedata2()'>Добавить параметры товара</a>
    <a  class='btn btn-outline-secondary' href='javascript:fseedata3()'>Заказы</a>
</div>

</div>
</body>
<script type="text/javascript">
    function fseedata1() {
        parent.users.location.href = 'addproduct'
    }
    function fseedata2() {
        parent.users.location.href = 'addparameters'
    }
    function fseedata3() {
        parent.users.location.href = 'orders'
    }

</script>
<iframe class="iframeUSERS"  src="" name="users"></iframe>

</html>
