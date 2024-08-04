@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card ">
            <div class="card-body">
                <h3><b>Личный кабинет</b></h3>
            </div>
        </div>
        <div class="row justify-content-center" style="margin-top: 20px">
            <div class="col-4">
                <div class="card " style="height: 100%">

                    <div class="card-body">
                        <div style="font-size: 24px;font-weight: bold">Личный кабинет</div>
                        <div class="profile">

                            <a class="link" href='home'>Мой профиль</a>
                        </div>
                        <div class="profile">

                            <a class="link" href='settingsprofile'>Настройки профиля</a>
                        </div>
                        <div class="profile">
                            <a class="link" href='ordersuser'>Заказы</a>
                        </div>
                        <div class="profile ">
                            @if(Auth::user()->role<3)
                                <a class="link" href='admin'>Панель администрирования</a>
                            @else

                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 ">

                <div class="card">

                    <div
                        style="margin-top: 15px;margin-left: 25px;color: #4e4e4e;font-size: 20px;font-weight: bold;font-family: Tahoma,sans-serif">
                        Настройки профиля
                    </div>

                    <div class="card-body">

                        <form enctype="multipart/form-data" action="{{action('AllController@avatars')}}"
                              method="post">
                            {{csrf_field()}}
                        <div class="FrameAVA " style="float: left">

                                {{--            <div class="button-wrapper">
                                                <span class="label">
                                                    Выберите файл
                                                </span>
                                                <input  type="file" name="avatars" id="upload" class="upload-box"
                                                       placeholder="Upload File">
                                            </div>

                                            <input type="submit" value="Загрузить">--}}

                                <label for="ava" ><img  style="width: 150px;height: 150px;border-radius: 50%;"
                                                      class="ProfileAVA"
                                                      src="{{asset('/storage/'.Auth::user()->avatars)}} "></label>
                                <input type="file" id="ava" name="avatars"/><br/>

                                @if(isset(Auth::user()->role))

                                    <input type="hidden" value=" @switch(Auth::user()->role)
                                    @case(0)
                                    {{$Role="Создатель"}}
                                    {{Session::put('role', $Role)}}
                                    @break
                                    @case(1)
                                    {{$Role="Администратор"}}
                                    {{Session::put('role', $Role)}}
                                    @break
                                    @case(2)
                                    {{$Role="Новичок"}}
                                    {{Session::put('role', $Role)}}
                                    @break
                                    @endswitch">
                                @endif
                                <p style="font-size: 22.5px;text-align: center">{{$Role}}</p>


                        </div>
                        <div style="margin-left: 35%">
                            <div >
                                <label class="hint-block pos-right">Имя</label>
                                <input class="form-control" name="name" value="{{Auth::user()->name}}">
                            </div>
                            <div >
                                <label class="hint-block pos-right">email</label>
                                <input class="form-control"  name="email" value="{{Auth::user()->email}}">
                            </div>
                            <div >
                                <label class="hint-block pos-right">телефон</label>
                                <input class="form-control" name="phone" value="{{Auth::user()->phone}}">
                            </div>

                        </div>
                        <input style="margin-top: 10px" class="btn btn-outline-secondary" type="submit" value="Сохранить">
                    </form>
                    </div>


                    {{--<div class="">

                        <div class="ProfileDIV " style="font-size: 22.5px; padding-left: 23%">
                            <div class='menu'>

                                <p>Email:{{Auth::user()->email}}</p>
                                @if(Auth::user()->count_orders>0)
                                    <p><a class="link" href='ordersuser'>Заказы:{{Auth::user()->count_orders}}</a>
                                    </p>
                                @else
                                    <p>Заказы:0</p>
                                @endif
                                <p>@if(Auth::user()->role<3)
                                        <a class="link" href='admin'>Панель администрирования</a>
                                    @else

                                    @endif
                                    @if(isset(Auth::user()->role))

                                        <input type="hidden" value=" @switch(Auth::user()->role)
                                        @case(0)
                                        {{$Role="Создатель"}}
                                        {{Session::put('role', $Role)}}
                                        @break
                                        @case(1)
                                        {{$Role="Админ"}}
                                        {{Session::put('role', $Role)}}
                                        @break
                                        @case(2)
                                        {{$Role="Модератор"}}
                                        {{Session::put('role', $Role)}}
                                        @break
                                        @case(3)
                                        {{$Role="Новичок"}}
                                        {{Session::put('role', $Role)}}

                                        @break
                                        @endswitch">
                                @endif
                                <p style="font-size: 22.5px;">Роль: {{Session::get('role')}}</p>
                                </p>
                            </div>
                        </div>
                    </div>--}}

                </div>
            </div>
        </div>
    </div>

    </div>

@endsection
