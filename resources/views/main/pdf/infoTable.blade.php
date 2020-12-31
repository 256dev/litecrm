<table class="info">
    <tr>
        <td>Клиент</td>
        <td>{{ $customer->name }}</td>
    </tr>
    <tr>
        <td>Телефон</td>
        <td>{{ $customer->phones }}</td>
    </tr>
    <tr>
        <td>Адрес</td>
        <td>{{ $customer->address }}</td>
    </tr>
    <tr>
        <td>Устройство</td>
        <td>
            {{ $order->type }}
            {{ $order->manufacturer }}
            {{ $order->model }}
        </td>
    </tr>
    <tr>
        <td>Серийный номер</td>
        <td>
            {!! $device_barcode !!} 
            {{ $order->sn }}
        </td>
    </tr>
    <tr>
        <td>Комплектность</td>
        <td>{{ $order->equipments }}</td>
    </tr>
    <tr>
        <td>Состояние</td>
        <td>{{ $order->conditions }}</td>
    </tr>
    <tr>
        <td>Дата приема</td>
        <td>
            {{ Date::parse($order->date)->tz(config('custom.tz'))->format('j F Y в G:i') }}
        </td>
    </tr>
</table>