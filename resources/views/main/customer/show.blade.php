@extends('layouts.app')

@section('title')
    <title>Клиент {{ $customer->name }}</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => 'Клиент',
        'route'  => 'customers.index',
        'button' => 'Все клиенты'
    ])
    <div class="container py-3">
        <div class="row justify-content-center">
            <h4>{{ $customer->name }}</h4>
        </div>
        <div class="row justify-content-around w-75 m-auto">
            <button class="btn btn-success btn-sm" onclick="window.location.href='{{ route('orders.create', $customer->id) }}';">
                <i class="fas fa-plus" aria-hidden="true"></i>
                <span class="d-none d-sm-inline"> Заказ</span>
            </button>
            <button class="btn btn-secondary btn-sm" onclick="window.location.href='{{ route('customers.edit', $customer->id) }}';">
                <i class="fas fa-edit" aria-hidden="true"></i>
                <span class="d-none d-sm-inline">Редактировать</span>
            </button>
            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteCustomer" onclick="event.preventDefault();">
                <i class="fas fa-trash" aria-hidden="true"></i>
                <span class="d-none d-sm-inline">Удалить</span>
            </button>
        </div>
        <div class="row justify-content-between my-3">
            <div class="col-12 col-md-5">
                <div class="pb-2">
                    <span class="font-weight-bold pr-2">Email:</span> {{ $customer->email }}
                </div>
                <div class="d-flex flex-row">
                    <div>
                        <span class="font-weight-bold">Телефон:</span>
                    </div>
                    <div class="pl-2">
                        @foreach ($phones as $phone)
                            <div class="text-left">
                                <span class="align-middle">{{ $phone->phone }}</span>
                                @if($phone->telegram)<img src="/css/img/telegram-icon.png" class="messenger-icon">@endif
                                @if($phone->viber)<img src="/css/img/viber-icon.png" class="messenger-icon">@endif
                                @if($phone->whatsapp)<img src="/css/img/whatsapp-icon.png" class="messenger-icon">@endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <span class="font-weight-bold pr-2">Статус:</span>{{ $customer->status??'Не указан' }}
                </div>
            </div>
            <div class="col-12 col-md-7">
                <div class="pb-2">
                    <span class="font-weight-bold pr-2">Адрес:</span>{{ $customer->address??'Не указан' }}
                </div>
                <div class="pb-2">
                    <span class="font-weight-bold pr-2">Паспорт:</span>{{ $customer->passport??'Не указан' }}
                </div>
                <div>
                    <span class="font-weight-bold pr-2">Комментарий:</span>{{ $customer->comment_about??'Нет комментария' }}
                </div>    
            </div>
        </div>
        <div class="row justify-content-center ">
            <h3>Заказы</h3>
        </div>
        <div class="row justify-content-around">
            <div>
                <h4><span class="badge badge-success">В работе -  {{ $customer->orders_in_process }}</span></h4>
            </div>
            <div>
                <h4><span class="badge badge-secondary">Всего -  {{ $customer->all_orders }}</span></h4>
            </div>
        </div>   
        <div class="row justify-content-center">   
            <table class="table table-striped table-responsive-sm shadow">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="align-middle text-center py-1">
                            <span class="d-block border-bottom border-light">№ Заказа</span>
                            <span class="d-block">Исполнитель</span>
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
                        <th scope="col" class="align-middle text-center py-1">Цена</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr onclick="window.location.href='{{ route('orders.show', $order->id)}}';">
                        <td scope="row" class="align-middle text-center">
                            <span class="d-block border-bottom border-dark">{{ $order->number }}</span>
                            <span class="d-block">Вейдер</span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="d-block border-bottom border-dark">{{ $order->type }}</span>
                            <span class="d-block">{{ $order->sn }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="d-block border-bottom border-dark">{{ $order->manufacturer }}</span>
                            <span class="d-block">{{ $order->model }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <span>{{ Date::parse($order->date)->tz(config('custom.tz'))->format('j F Y в H i') }}</span>
                            <span class="status px-1 bg-{{ $order->color }}">{{ $order->status }}</span>
                        </td>
                        <td class="align-middle text-center">{{ number_format($order->price + $order->prepayment, 2) }} {{ Session::get('currency') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(!$orders->count())
                <h3>Нет заказов</h3>
            @endif
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="deleteCustomer">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Вы действительно хотите удалить клиента?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('customers.destroy', $customer->id)}}">
                    @csrf
                    @method('delete')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Удалить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection