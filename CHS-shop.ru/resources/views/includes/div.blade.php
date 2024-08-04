<div class='top'>
    <form style='margin: 0;' method='post' action="{{action('AllController@buys')}}">
        {{ csrf_field() }}
        <div class='in-top'>
            <?php
            $pr = 0;
            $id_product_num = 0;
            $check=false;
            ?>
            <input type="hidden" name="id_product" value="{{$product->id_product}}">
            <div class='in-top-div-name'><a class='in-top-a-name'
                                            href='{{ url('product', 'id_product='.$product->id_product) }}'><img
                        class='in-top-img' src='{{asset('/storage/'.$product->url)}}'></a></div>
            <input type="hidden" name="url" value="{{$product->url}}">
            <input type="hidden" name="name" value="{{$product->name}}">
            <div class='in-top-all'>
                <tr><a class='in-top-a'
                       href='{{ url('product', 'id_product='.$product->id_product) }}'>{{$product->name}}</a>
                </tr>
                <span class='in-top-span'>{{$product->short_description}}</span>
            </div>
            <div class='in-top-price d-flex' style='margin-left: 30px'>
                <input type="hidden" name="price" value="{{$product->price}}">
                {{$product->price}} <i class='icon'></i>
            </div>
        </div>
        <input type="hidden" value="{{$pr=$product->id_product}}">
        <?php
        $count = 0;
        $nol = 0;
        if (isset(Auth::user()->email)) {
            $pr;

            $id_user = Auth::user()->id;
            $link = mysqli_connect('localhost', 'root', '', 'newbd');

            $void = mysqli_query($link, "SELECT `id_product`,`id_user` FROM `basket` WHERE `id_product`=$pr and `id_user`='$id_user'");

            while ($num = mysqli_fetch_assoc($void)) {

                $id_product_num = $num['id_product'];


            }

        } else {
            $pr;
            $link = mysqli_connect('localhost', 'root', '', 'newbd');
            $void = mysqli_query($link, "SELECT `id_product`,`id_user` FROM `basket` WHERE `id_product`=$pr and `id_user`='1'");
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
                    $check=true;
                    ?>

                    @break
                @endif

            @endforeach
            @if($check)
                @if(isset(Auth::user()->email))
                    <div style='text-align: right'><a href='{{ url('basket', 'emailbasket='.Auth::user()->email) }}'
                                                      class='btn btn-outline-secondary'>Перейти в корзину</a></div>
                    @else
                        <div style='text-align: right'><a href='{{ url('basket', 'emailbasket=1' )}}'
                                                          class='btn btn-outline-secondary'>Перейти в корзину</a></div>
                    @endif
                @else
                    <div style='text-align: right'>
                        <input class='btn btn-outline-secondary' name="buy" type='submit' id='buy' value="Купить">
                    </div>
                @endif
        @else
            <div style='text-align: right'>
                <input class='btn btn-outline-secondary' name="buy" type='submit' id='buy' value="Купить">
            </div>
        @endif
        {{-- {{$product->id_product}}
          {{Session::get('id_product')}}--}}
        {{--        @if(!Session::has('basket')){


                    {{print 1}}
            @endif--}}

        {{--    @if(Session::get('basket')[0]->idProduct==$product->id_product)
    --}}




        {{--        @else
                    <div style='text-align: right'><a href='{{ url('basket', 'emailbasket='.Auth::user()->email) }}'
                                                      class='btn btn-outline-secondary'>Перейти в корзину</a></div>
                @endif--}}


    </form>
</div>


