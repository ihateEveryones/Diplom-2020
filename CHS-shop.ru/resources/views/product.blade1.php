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
<main>
<?php
$check=false;
?>
@include('includes.top')

    @foreach($products as $product)
        @if($product->id_product>-1)
            <div class='all  container '>
            <h1 class="page-title price-item-title" data-product-param="name"> {{$product->name}}</h1>
<div class='top' >


    <form  style='margin: 0;' method='get' action="{{action('AllController@buy')}}">
        <input type="hidden" name="id_product" value="{{$product->id_product}}">
        <div class='in-top' style='margin-bottom: 30px'>
            <div class='div-image'>
                <a class='in-top-a-name'   href='{{ url('product', 'id_product='.$product->id_product) }}'>
                    <img class='product-image'  src='{{asset('/storage/'.$product->url)}}'>
                </a>
            </div>
            <input type="hidden" name="url" value="{{$product->url}}">
            <input type="hidden" name="name" value="{{$product->name}}">
            <div class="d-inline">


            <div class='product-price ' >{{$product->price}}<i class='icon '></i></div>

                <div class="block" style="margin-top: 43%;">

                    <span  class="title">Производитель: </span><span><b>{{$product->vendors}}</b><a class="tooltip-link" href="javascript:" title="" data-toggle="tooltip" data-trigger="focus" data-placement="bottom" tabindex="0" data-original-title="Страна-производитель может отличаться от заявленной"><i></i></a><span>
							</span></span>
                </div>
                <div style="margin-top: 5%;margin-bottom: 1%">
                    <span>Количество: <b>{{$product->count}} шт.</b></span>
                </div>
                @if($product->count<=0)

                    <div style="margin-top: 15%">
                        <span><b>Нет в наличии</b></span>
                    </div>
                @else

                @if(Session::has('basket'))
                    @foreach(Session::get('basket') as $basket)
                        @if($product->id_product==$basket->idProduct)
                            <?php
                            $check=true;
                            ?>

                            @break
                        @endif

                    @endforeach
                    @if($check)
                        @if(isset(Auth::user()->email))
                            <div style=''><a href='{{ url('basket', 'emailbasket='.Auth::user()->email) }}'
                                                              class='btn btn-secondary product-buy'>Перейти в корзину</a></div>
                        @else
                            <div style=''><a href='{{ url('basket', 'emailbasket=1' )}}'
                                                              class='btn btn-secondary product-buy'>Перейти в корзину</a></div>
                        @endif
                    @else
                        <div >
                            <input class='btn btn-secondary product-buy' name="buy" type='submit' id='buy' value="Купить">
                        </div>
                    @endif
                @else
                    <div >
                        <input class='btn btn-secondary product-buy' name="buy" type='submit' id='buy' value="Купить">
                    </div>
                @endif

                    @endif
            </div>
            <input type="hidden" name="price" value="{{$product->price}}">
            <div>

            </div>
        </div>
        <div class="param">
            <hr>
            <div class="title d-inline-block"><h2 style="font-size: 24px;">Описание {{$product->name}}</h2></div>
            <div style="width: 90%">
                {{--<p >{!!nl2br(str_replace(" ", " &nbsp;", $product->description))!!}</p>--}}
                <p>{!! nl2br(e($product->description))!!}</p>
               {{-- <P>{{$product->description}}</P>--}}
            </div>
            {{--<div class="price_item_description" itemprop="description">
                <div class="selector ">
                    <div class="dropdown-icon d-inline-block">
                        <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                           aria-controls="collapseExample" style="text-decoration:none;color: #000 !important;">
                            <i class="arrow down"></i>
                            <div class="title d-inline-block"><h2 style="font-size: 24px;">Описание {{$product->name}}</h2></div>
                        </a>

                    </div>
                    <div class="products-table">
                        <div class="collapse" id="collapseExample">

                            <div style="">
                                <p >{{$product->description}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>--}}
            <div class="price_item_description" itemprop="description">
                <div class="selector ">
                <div class="dropdown-icon d-inline-block">
                    <a data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false"
                       aria-controls="collapseExample" style="text-decoration:none;color: #000 !important;">
                        <i class="arrow down"></i>
                        <div class="title d-inline-block">   <h2 style="font-size: 24px;">Характеристики {{$product->name}}</h2></div>
                    </a>

                </div>
                <div class="products-table">
                    <div class="collapse" id="collapseExample1">

                        <div style="">
                            <table>
                                <tbody>
                                @foreach($parameters as $parameter)
                                    <div class="dots">  </div>
                                    <tr><td class="parameter_name"><div class="dots"><span> {{$parameter->parameter_name}} </span></div></td> <td>{{$parameter->parameter_value}}</td></tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>


        </div>
    </form>
</div>
        @endif
    @endforeach
</div>
</main>
@include('includes.footer')
</body>
</html>
