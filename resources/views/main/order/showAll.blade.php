@extends('layouts.app')

@section('title')
    <title>Все заказы</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.topTableBar', [
        'title'  => 'Заказы',
        'route'  => 'orders.create',
        'buttom' => 'Добавить заказ',
        'type'   => 'order',
    ])
    <div class="container py-2">
        <div class="row justify-content-center">
            <table class="table table-striped shadow table-responsive-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="align-middle text-center py-1">
                            <span class="d-block border-bottom border-light">№ Заказа</span>
                            <span class="d-block">Клиент</span>
                        </th>
                        <th scope="col" class="align-middle text-center py-1">
                            <span class="d-block border-bottom border-light">Тип</span>
                            <span class="d-block">SN</span>
                        </th>
                        <th scope="col" class="align-middle text-center py-1">
                            <span class="d-block border-bottom border-light">Фирма</span>
                            <span class="d-block">Модель</span>
                        </th>
                        <th scope="col" class="align-middle text-center py-1" style="width: 25%">
                            <span class="d-block border-bottom border-light">Принят</span>
                            <span class="d-block">Статус</span>
                        </th>
                        <th scope="col" class="align-middle text-center py-1">
                            <span class="d-block border-bottom border-light">Цена</span>
                            <span class="d-block">Предоплата</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="@if($order->urgency) bg-urgency @endif pointer" onclick="window.location.href='{{ route('orders.show', $order->id)}}';">
                        <td scope="row" class="align-middle text-center">
                            <span class="d-block border-bottom border-dark">{{ $order->number }}</span>
                            <span class="d-block"><a class="link" href="{{ route('customers.show', $order->customerId) }}">{{ $order->customerName }}</a></span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="d-block border-bottom border-dark">{{ $order->type }}</span>
                            <span class="d-block">{{ !empty($order->sn)? $order->sn : '-' }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="d-block border-bottom border-dark">{{ $order->manufacturer }}</span>
                            <span class="d-block">{{ $order->model }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <span>{{ Date::parse($order->date)->tz(config('custom.tz'))->format('j F Y в H:i') }}</span>
                            <span class="status px-1 bg-{{ $order->color }}">{{ $order->status }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="d-block border-bottom border-dark">{{ number_format($order->price + $order->prepayment, 2) }} {{ Session::get('currency') }}</span>
                            <span class="d-block">{{ $order->prepayment }} {{ Session::get('currency') }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>    
@endsection 
