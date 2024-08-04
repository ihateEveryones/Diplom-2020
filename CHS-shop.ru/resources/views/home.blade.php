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
                    {{--    <div style="font-size: 24px;font-weight: bold">Личный кабинет</div>--}}
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
                        Мой профиль
                    </div>


                    <div class="card-body">

                        <div class="FrameAVA " style="float: left">
                            <form enctype="multipart/form-data" action="{{action('AllController@avatars')}}"
                                  method="post">
                                {{csrf_field()}}
                                {{--            <div class="button-wrapper">
                                                <span class="label">
                                                    Выберите файл
                                                </span>
                                                <input  type="file" name="avatars" id="upload" class="upload-box"
                                                       placeholder="Upload File">
                                            </div>

                                            <input type="submit" value="Загрузить">--}}
                                <img style="width: 150px;height: 150px;border-radius: 50%;"
                                     class="ProfileAVA"
                                     src="{{asset('/storage/'.Auth::user()->avatars)}} ">
                               {{-- <label for="ava"><img style="width: 150px;height: 150px;border-radius: 50%;"
                                                      class="ProfileAVA"
                                                      src="{{asset('/storage/'.Auth::user()->avatars)}} "></label>
                                <input type="file" id="ava" name="ava"/><br/>--}}

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
                                    {{$Role="Покупатель"}}
                                    {{Session::put('role', $Role)}}
                                    @break
                                    @endswitch">
                                @endif
                                <p style="font-size: 22.5px;text-align: center">{{$Role}}</p>
                                {{--<input type="submit" value="Загрузить">--}}
                            </form>
                        </div>

                        <div class="" style="margin-left: 35%">
                            <div class="info-profile">
                            Email: {{Auth::user()->email}}
                            </div>
                            <div class="info-profile">
                            Имя: {{Auth::user()->name}}
                            </div>
                            <div class="info-profile">
                                Телефон: {{Auth::user()->phone}}
                            </div>
                            <div class="info-profile">
                                Дата регистрации: {{Auth::user()->created_at->toDateTime()->format('d-m-Y')}}
                            </div>
                        </div>

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
