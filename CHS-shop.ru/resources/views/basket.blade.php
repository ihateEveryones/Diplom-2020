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
</head>
<body class="body">
@include('includes.top')
<?php
$countsum=0;
$priceall=0;
$emailbasket=0;
$count=0;
?>
<main>
<div class="container " style="margin-top: 10px">
    <input type="hidden" value="">



   {{-- @if(($countbasket>0) && ($emailbasket!='0') && ($email[0]->id_user==Auth::user()->id) /*&& ($status=="не оплачен")*/)--}}

    @if(Session::has('basket')&&(count(Session::get('basket')))!=0)
        <div class="row">
            <div class="col-8 mr-0">
        @foreach(Session::get('basket') as $basket)



        <div class='top    ' style='' >

                    <div class='in-top ' >
                        <div class='in-top-div-name'>
                            <a class='in-top-a-name'   href='{{ url('product', 'id_product='.$basket->idProduct) }}'>
                            <img class='in-top-img' src='{{asset('/storage/'.$basket->url)}}'>
                        </a>
                    </div>
                    <div class='in-top-all'>

                    <a class='in-top-a' href='{{ url('product', 'id_product='.$basket->idProduct) }}'>{{$basket->name}} </a>
                        <form method="get"   action="{{action('AllController@delete')}}">
                            <div style='text-align: right ;width: 120px;'>
                                <input  class='btn btn-outline-secondary' type='submit'  name='delete' id='delete' value='удалить'>
                                <div class='in-top-count'><input name ='id_product' type='hidden' style='width: 25px;' value=' {{ $count}}'></div>

                            </div>
                        </form>
                    </div>

                    <div class="btn-group d-flex">
                        <input type="hidden" name='count' style='width: 25px;height: 37px' value=' {{$countminus=$basket->count}}'>
                        <form method="get"   action="{{action('AllController@minus')}}">
                        <div style='text-align: right ;width: 100px;'>
                            <input  class='buttons-minus count-buttons ' type='submit'  name='minus' id='minus' value='-'>
                            <input name ='id_product' type='hidden' style='width: 25px;' value=' {{$count}}'>
                        </div>
                        </form>
                        <div class='in-top-count'>
                          {{--  <div class="form-group phone ">
                                <input name="phone" id="phone" value="{{$basket->count}}" class="form-control ">
                            </div>--}}


                        </div>
                        <input  name='count'  class=" buttons " value='{{$basket->count}}'>
                        <form style="width: 160px" method="get"  action="{{action('AllController@plus')}}">

                            <div style=''>
                           <input  class='buttons-plus count-buttons' type='submit'  name='plus' id='plus' value='+'>
                                <input name ='id_product' type='hidden' style='width: 25px;' value=' {{$count}}'>

                        </div>
                        </form>
                    </div>



                </div>
                    <div class='in-top-price' style=''>{{$basket->price}}<i class='icon'></i></div>


    </div>
        {{--    <input type="hidden" value="{{$id_product=$basket->id_product}}">--}}
        <input name ='id_user' type='hidden' style='width: 25px;' value=' {{$basket->idUser}}'>
      {{--  <input type="hidden" value="{{$id_basket=$basket->id_basket}}">--}}
        <input type="hidden" value="{{$countsum=$basket->count+$countsum}}">

        <input type="hidden" value="{{$priceall=($basket->price*$basket->count)+$priceall}}">
<?php
        $count++;
?>
    @endforeach
            </div>
            <div class="col-4 ml-0">
    <div class=''style='width: 300px;margin-bottom: 15px' >
        <form  style='margin: 0;' method='get' action="{{action('AllController@giveorders')}}">
            <div class='bot  ' >

                {{--<input name="id_basket" type="hidden"value="{{$id_basket}}">--}}

                <div>Итого:  {{$countsum}}  товар на {{$priceall}}<i class='icon'></i></div>
                <input name="priceall" type="hidden"{{Session::put('orderPrice',$priceall)}}value="{{$priceall}}">

              {{--  <div style='text-align: right ;width: 120px;'>
                    <input   class='btn btn-outline-secondary' type='submit' onclick='button()'  name='order' id='order' value='оформить заказ'>
                </div>--}}
                @if(isset(Auth::user()->email))
                    <div>
                        <a class='btn btn-outline-secondary' href="{{ url('/orderbasket') }}">
                            Сформировать заказ
                        </a>
                    </div>
                @else
                    <div>
                        <a class='btn btn-outline-secondary' href="{{ url('/orderbasket') }}">
                            Сформировать заказ
                        </a>
                    </div>
                @endif

            </div>
        </form>
    </div>
            </div>
        </div>


@else

       {{-- @else--}}
    <div class="basket" style='text-align: center;margin-top: 350px;'> Корзина пуста </div>
  {{--      @endif--}}
        @endif

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

