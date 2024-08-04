<html>
<head>
    <link href="{{ asset('css/all.css') }}" rel="stylesheet" type="text/css">

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
$array = array();
?>
<main>
    <div class='all  container '>
        <div class='all   row'>
            <div class='in-all col-xl-'>
                <div class="filter ">
                    <form method="get" action="{{action('AllController@filters')}}">
                        <div>
                            <label for="price">Цена</label>


                            <div class="divfilterprice ">
                                <input class="filterprice" type="text "
                                       @if(isset($_GET['price'])) value="{{$_GET['price']}}" @endif name="price"
                                       placeholder="от {{Session::get('minprice')}}">
                            </div>
                            {{--       @if(isset($_GET['filter']))
                                       <input type="hidden" name="price" value="{{Session::get('minprice')}}">
                                   @endif--}}
                            <div class="divfilterprice ">

                                <input class="filterprice" type="text"
                                       @if(isset($_GET['price1'])) value="{{$_GET['price1']}}" @endif name="price1"
                                       placeholder="до {{Session::get('maxprice')}}">
                            </div>
                        </div>


                        {{--  <div>

                              <input type="radio" name="asc" id='asc' value="asc">
                              <label for="asc">По возрастанию цены</label>
                          </div>
                          <div>

                              <input type="radio" name="desc" id='desc' value="desc">
                              <label for="desc">По убыванию цены</label>
                          </div>--}}

                        @foreach($vendors as $vendor)
                            @if($vendor->vendors!="0"&&$vendor->vendors!="")
                                <?php

                                array_push($array, $vendor->vendors)

                                ?>
                                <div>
                                    <input type="checkbox" @if(isset($_GET["$vendor->vendors"]))
                                        checked
                                    @endif name="{{$vendor->vendors}}" value="{{$vendor->vendors}}"
                                           id="{{$vendor->vendors}}">
                                    <label for="{{$vendor->vendors}}">{{$vendor->vendors}}</label>
                                </div>

                            @endif

                        @endforeach

                        {{-- <input type="radio" name="Intel" value="Intel" id="Intel">
                         <label for="Intel">Intel</label>--}}
                        <input class="btn btn-outline-secondary" type="submit" value="Показать" name="Показать">
                    </form>
                    {{--<form method="post">
                        <div>
                            <label>По возрастанию цены</label>
                            <input type="checkbox" name="asc" id='desc' value="По возрастанию">
                        </div>
                        <div>
                            <label>По убыванию цены</label>
                            <input type="checkbox" name="desc" id='desc' value="По убыванию">
                        </div>
                        <div><label>Intel</label>
                            <input type="checkbox" name='Intel' value="Intel">
                        </div>
                        <div><label>AMD</label>
                            <input type="checkbox" name="AMD" value="AMD">
                        </div>
                        <input type="submit" name="filter" value="показать">

                    </form>--}}
                </div>
            </div>
            <div class='col-8'>

                @foreach($products as $product)

                    @if($product->id_product>-1)
                        <div class='top col'>
                            <form style='margin: 0;' method='get' action="{{action('AllController@buy')}}">

                                <div class='in-top'>
                                    <?php
                                    $pr = 0;
                                    $id_product_num = 0;
                                    $check = false;
                                    ?>

                                    <input type="hidden" name="id_product" value="{{$product->id_product}}">
                                    <div class='in-top-div-name'>
                                        <a class='in-top-a-name'
                                           href='{{ url('product', 'id_product='.$product->id_product) }}'>
                                            <img class='in-top-img' src='{{asset('/storage/'.$product->url)}}'>
                                            <input type="hidden" name="url" value="{{$product->url}}">
                                            <input type="hidden" name="name" value="{{$product->name}}">

                                        </a>

                                    </div>
                                    <div class='in-top-all'>
                                        <a class='in-top-a'
                                           href='{{ url('product', 'id_product='.$product->id_product) }}'>{{$product->name}}</a>
                                        <span class='in-top-span'>{{$product->short_description}}</span>
                                    </div>
                                    <div class='in-top-price d-flex'><input type="hidden" name="price"
                                                                            value="{{$product->price}}">{{$product->price}}
                                        <i class='icon'></i></div>

                                </div>
                                <input type="hidden" value="{{$pr=$product->id_product}}">

                                <?php
                                if (isset(Auth::user()->email)) {
                                    $pr;

                                    $emails = Auth::user()->email;
                                    $link = mysqli_connect('localhost', 'root', '', 'store');

                                    $void = mysqli_query($link, "SELECT `id_product`,`emailbasket` FROM `basket` WHERE `id_product`=$pr and `emailbasket`='$emails'");
                                    while ($num = mysqli_fetch_assoc($void)) {

                                        echo $id_product_num = $num['id_product'];

                                    }

                                } else {
                                    $pr;
                                    $link = mysqli_connect('localhost', 'root', '', 'store');
                                    $void = mysqli_query($link, "SELECT `id_product`,`emailbasket` FROM `basket` WHERE `id_product`=$pr and `emailbasket`='1'");
                                    while ($num = mysqli_fetch_assoc($void)) {

                                        $id_product_num = $num['id_product'];
                                        $emailbasket = $num['emailbasket'];
                                    }
                                }
                                ?>
                                @if(Session::has('basket'))
                                    @foreach(Session::get('basket') as $basket)
                                        @if($product->id_product==$basket->idProduct)
                                            <?php
                                            $check = true;
                                            ?>

                                            @break
                                        @endif

                                    @endforeach
                                    @if($check)
                                        @if(isset(Auth::user()->email))
                                            <div style='text-align: right'><a
                                                    href='{{ url('basket', 'emailbasket='.Auth::user()->email) }}'
                                                    class='btn btn-outline-secondary'>Перейти в корзину</a></div>
                                        @else
                                            <div style='text-align: right'><a
                                                    href='{{ url('basket', 'emailbasket=1' )}}'
                                                    class='btn btn-outline-secondary'>Перейти в корзину</a></div>
                                        @endif
                                    @else
                                        <div style='text-align: right'>
                                            <input class=' btn btn-outline-secondary white' name="buy" type='submit' id='buy'
                                                   value="Купить">
                                        </div>
                                    @endif
                                @else
                                    <div style='text-align: right'>
                                        <input class='btn btn-outline-secondary' name="buy" type='submit' id='buy'
                                               value="Купить">
                                    </div>
                                @endif
                                {{-- @if((isset($email))&& (isset(Auth::user()->email)))
                                     @if((!$email->isEmpty()))
                                         @if( ($product->id_product==$id_product_num) )
                                             <div style='text-align: right'><a href='{{ url('basket', 'emailbasket='.Auth::user()->email) }}'
                                                                               class='btn btn-outline-secondary'>Перейти в корзину</a></div>
                                         @else

                                             <div style='text-align: right'>
                                                 <input class='btn btn-outline-secondary' type='submit' id='buy' value="Купить">
                                             </div>

                                         @endif
                                     @else
                                         <div style='text-align: right'>
                                             <input class='btn btn-outline-secondary' type='submit' id='buy' value="Купить">
                                         </div>
                                     @endif
                                 @elseif(!isset(Auth::user()->email)&&(isset($_POST['buy'])))
                                     <div>Для совешения покупки нужно авторизоваться</div>
                                 @else
                                     <div style='text-align: right'>
                                         <input class='btn btn-outline-secondary' type='submit' id='buy' value="Купить">
                                     </div>
                                 @endif--}}
                                {{--   <div style='text-align: right'>
                                       <button class='btn btn-outline-secondary' type='submit' id='buy'>Купить</button>
                                   </div>--}}
                            </form>
                        </div>
                    @endif

                @endforeach
                {{-- appends(['price' => $_GET['price']])->    price=&price1=&AMD=AMD&filter=
                     ,'price1' => $_GET['price1'],'Intel' => $_GET['Intel']--}}
                {{--@if(((isset($_GET['price']))||(isset($_GET['price1'])))&&((isset($_GET["$vendor->vendors"]))))

                        {{$products->appends(['price' => $_GET['price'],'price1' => $_GET['price1'],"$vendor->vendors" => $_GET["$vendor->vendors"]])->links()}}
                    @else

                @endif--}}
                @foreach($array as $arr)
                    @if(((isset($_GET['price']))&&(isset($_GET['price1']))))

                        <?php
                            $products->appends(['price' => $_GET['price'],'price1' => $_GET['price1']])
                            ?>

                    @endif
                    @if(isset($_GET[$arr]))
                        <?php
                            $products->appends([$arr => $_GET[$arr]])
                            ?>

                        @endif
                @endforeach
                    {{$products->links()}}

            </div>
        </div>
    </div>
</main>
@include('includes.footer')
</body>
</html>

