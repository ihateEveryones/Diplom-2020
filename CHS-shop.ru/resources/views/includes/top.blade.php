@if(($_SERVER['REQUEST_URI']=="/main"))
<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-white" style="box-shadow: 0 1px 2px 0 rgba(0,0,0,0.16);">
    <div class="container">
<div class="menu">
    <a style="" class="navbar-brand" href="../main"><img  height="30" src="{{asset('/storage/logo/CHS-text.png')}}">{{--Магазин CHS --}}</a>
</div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
       {{-- <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Каталог товаров
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                            --}}{{--@foreach($topcategories as $categorie)


                                <a class='dropdown-item'

                                   href='{{ url('products', 'id_categories='.$categorie->id_categories) }}'
                                    --}}{{----}}{{--href='products.blade.php?id_categories={{$categorie->id_categories}}'--}}{{----}}{{--> {{$categorie->name}}</a>

                            @endforeach--}}{{--

                        </div>
                    </div>
                </li>
            </ul>
        </div>--}}


<form method="get" class="input-group" style="margin: 0" action="{{action('AllController@search')}}">
    <div class="input-group" style="margin-left: 15px;
    margin-right: 12px;">


        <input type="text" @if(isset($_GET['search'])) {{Sessioon::put('search',$_GET['search'])}} value="{{$_GET['search']}}" @endif name="search" class="form-control" placeholder="Поиск по товарам">
        <div class="input-group-append">
            <button class="btn btn-secondary" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>

</form>
        @if( !empty(Auth::user()))
            <a class='btn btn-outline-secondary ' style='margin-right: 5px' href='/home'>Профиль </a>
            <a class="btn btn-outline-secondary" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                {{ __('Выйти') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <div class="my-2 my-sm-0">

                <a class='btn btn-outline-secondary' style='margin-right: 5px'
                   href="{{ url('register') }}">Регистрация</a></div>
            <div class="my-2 my-sm-0">

                <a class='btn btn-outline-secondary' href="{{ url('login') }}" name='exit'>Авторизация</a></div>
            <div style="text-align: left">
                @endif
                <ul class="navbar-nav">
                    @if(isset(Auth::user()->email))
                    <li class="nav-item active">
                        <a class="nav-link " href="{{ url('basket', 'emailbasket='. Auth::user()->email) }}">Корзина <span class="sr-only"></span></a>
                    </li>
                        @else
                        <li class="nav-item active">
                            <a class="nav-link " href="{{ url('basket', 'emailbasket='."1") }}">Корзина <span class="sr-only"></span></a>
                        </li>
                        @endif
                </ul>
            </div>
    </div>
{{--    <script src="/template/js/jquery.js"></script>
    <script src="/template/js/bootstrap.min.js"></script>
    <script src="/template/js/jquery.scrollUp.min.js"></script>
    <script src="/template/js/price-range.js"></script>
    <script src="/template/js/jquery.prettyPhoto.js"></script>
    <script src="/template/js/main.js"></script>
    <script>
        $(document).ready(function(){
            $(".add-to-cart").click(function () {
                var id = $(this).attr("data-id");
                $.post("/basket/addAjax/"+id, {}, function (data) {
                    $("#cart-count").html(data);
                });
                return false;
            });
        });
    </script>--}}
</nav>
@else
    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-white" style="box-shadow: 0 1px 2px 0 rgba(0,0,0,0.16);">
        <div class="container">
            <a style="" class="navbar-brand" href="../main"><img  width="193" height="30" src="{{asset('/storage/logo/CHS-text.png')}}">{{--Магазин CHS --}}</a>
            {{--<a class="navbar-brand" href="../main">Магазин</a>--}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Каталог товаров
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                @foreach($topcategories as $categorie)


                                    <a class='dropdown-item'

                                       href='{{ url('products', 'id_categories='.$categorie->id_categories) }}'
                                        {{--href='products.blade.php?id_categories={{$categorie->id_categories}}'--}}> {{$categorie->name}}</a>

                                @endforeach

                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <form method="get" class="input-group" style="margin: 0" action="{{action('AllController@search')}}">
                <div class="input-group" style="margin-left: 15px;
    margin-right: 15px;">
                    <input type="text" @if(isset($_GET['search'])) value="{{$_GET['search']}}" @endif name="search" class="form-control" placeholder="Поиск по товарам">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            @if( !empty(Auth::user()))
                <a class='btn btn-outline-secondary ' style='margin-right: 5px' href='/home'>Профиль </a>
                <a class="btn btn-outline-secondary" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Выйти') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <div class="my-2 my-sm-0">

                    <a class='btn btn-outline-secondary' style='margin-right: 5px'
                       href="{{ url('register') }}">Регистрация</a></div>
                <div class="my-2 my-sm-0">

                    <a class='btn btn-outline-secondary' href="{{ url('login') }}" name='exit'>Авторизация</a></div>
                <div style="text-align: left">
                    @endif
                    <ul class="navbar-nav">
                        @if(isset(Auth::user()->email))
                            <li class="nav-item active">
                                <a class="nav-link " href="{{ url('basket', 'emailbasket='. Auth::user()->email) }}">Корзина <span class="sr-only"></span></a>
                            </li>
                        @else
                            <li class="nav-item active">
                                <a class="nav-link " href="{{ url('basket', 'emailbasket='."1") }}">Корзина <span class="sr-only"></span></a>
                            </li>
                        @endif
                    </ul>
                </div>
        </div>
        {{--    <script src="/template/js/jquery.js"></script>
            <script src="/template/js/bootstrap.min.js"></script>
            <script src="/template/js/jquery.scrollUp.min.js"></script>
            <script src="/template/js/price-range.js"></script>
            <script src="/template/js/jquery.prettyPhoto.js"></script>
            <script src="/template/js/main.js"></script>
            <script>
                $(document).ready(function(){
                    $(".add-to-cart").click(function () {
                        var id = $(this).attr("data-id");
                        $.post("/basket/addAjax/"+id, {}, function (data) {
                            $("#cart-count").html(data);
                        });
                        return false;
                    });
                });
            </script>--}}
    </nav>
@endif

