@component('mail::panel')
    Уважаемый покупатель,
    Ваш заказ {{Session::get('id_orders')}}.
@endcomponent
@component('mail::message')
    Состав заказа {{Session::get('id_orders')}}.
    @component('mail::table')
        <table>
            <tr>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Кол-во</th>
                <th>Сумма</th>
            </tr>
            @foreach(Session::get('basket') as $orders)
                <tr>
                    <td style="width: 60%">{{$orders->name}}</td>
                    <td>{{$orders->price}} р.</td>
                    <td>{{$orders->count}} шт.</td>
                    <td>{{$orders->price*$orders->count}} р.</td>
                </tr>
            @endforeach
            <tr>
                <td><b>Итого: {{Session::get('orderPrice')}}</b></td>
            </tr>
        </table>
    @endcomponent
@endcomponent
