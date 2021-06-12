@extends('layouts.app')

@section('title')
    <title>Все клиенты</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.topTableBar', [
        'title'  => 'Клиенты',
        'route'  => 'customers.create',
        'buttom' => 'Добавить клиента',
        'type'   => 'customers',
        'create' => Auth::user()->can('create', App\Models\Order::class) ? 1 : 0,
    ])
    @include('main.customer.pagination')
    <div class="container py-2">
        <div class="row justify-content-center">
            <table class="table table-striped table-responsive-sm shadow">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" class="align-middle text-center">№</th>
                    <th scope="col" class="align-middle text-center">Имя</th>
                    <th scope="col" class="align-middle text-center">Телефон</th>
                    <th scope="col" class="align-middle text-center">Заказов</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr onclick="window.location.href='{{ route('customers.show', $customer->id)}}';">
                        <th scope="row" class="align-middle text-center">{{ $customer->id }}</th>
                        <td class="align-middle">
                            <span class="">{{ $customer->name }}</span>
                        </td>
                        <td class="align-middle">                
                            @foreach ($customer->phones as $phone)
                                <div class="text-left">
                                    <span class="align-middle">{{ $phone->phone }}</span>
                                    @if($phone->telegram)<img src="/css/img/telegram-icon.png" class="messenger-icon">@endif
                                    @if($phone->viber)<img src="/css/img/viber-icon.png" class="messenger-icon">@endif
                                    @if($phone->whatsapp)<img src="/css/img/whatsapp-icon.png" class="messenger-icon">@endif
                                </div>
                            @endforeach
                        </td>
                        <td class="align-middle text-center">
                            <span class="align-middle"> {{ $customer->orders_in_process }}/{{ $customer->all_orders }}</span>
                            <button class="btn btn-sm btn-success col-12 col-md-4" onclick="addCustomerOrder(event, '{{ route('orders.create', $customer->id) }}');">
                                <i class="fas fa-plus align-middle" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('main.customer.pagination')
@endsection