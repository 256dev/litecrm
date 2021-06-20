@extends('layouts.app')

@section('content')
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-6 col-md-3 p-md-0 p-lg-3 mb-2">
                <div class="card text-white bg-primary shadow">
                    <div class="card-header p-0 p-md-2">
                        Оформлен
                    </div>
                    <div class="card-body icon-card pt-0">
                        <span class="fas fa-plus-square fa-2x "></span>
                        <div class="pl-3">{{ $count->received }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 p-md-0 p-lg-3 mb-2">
                <div class="card text-white bg-secondary shadow">
                    <div class="card-header p-0 p-md-2">
                        В работе
                    </div>
                    <div class="card-body icon-card pt-0">
                        <span class="fas fa-wrench fa-2x"></span>
                        <div class="pl-3">{{ $count->in_work }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 p-md-0 p-lg-3">
                <div class="card text-white bg-warning text-dark shadow">
                    <div class="card-header p-0 p-md-2">
                        На паузе
                    </div>
                    <div class="card-body icon-card pt-0">
                        <span class="far fa-pause-circle fa-2x"></span>
                        <div class="pl-3">{{ $count->on_pause }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 p-md-0 p-lg-3">
                <div class="card text-white bg-info shadow">
                    <div class="card-header p-0 p-md-2">
                        К выдаче
                    </div>
                    <div class="card-body icon-card pt-0">
                        <span class="fas fa-check fa-2x"></span>
                        <div class="pl-3">{{ $count->ready }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.topTableBar', [
        'title'  => 'Список заказов',
        'route'  => 'orders.create',
        'buttom' => 'Добавить заказ',
        'type'   => 'main',
        'create' => Auth::user()->can('create', App\Models\Order::class) ? 1 : 0,
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
                            <span class="d-block border-bottom border-dark">{{ $order->price }} {{ Session::get('currency') }}</span>
                            <span class="d-block">{{ $order->prepayment }} {{ Session::get('currency') }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>    
@endsection 
