@extends('layouts.app')

@section('title')
    @if (isset($edit))
        <title>Редактирование заказа №{{ $order->number }}</title>
    @else
        <title>Добавление заказа</title>
    @endif
@endsection

@section('content')

@include('layouts.headAlertBlock')

@include('layouts.headTitleBlock', [
    'title'  => isset($edit)? 'Редактирование заказа' : 'Оформление заказа',
    'route'  => 'orders.index',
    'button' => 'Все заказы'
])

<div class="container">
    @if(isset($edit))
        <div class="d-flex justify-content-center my-2">
            <h4>
                {{ $order->number }}
            </h4>
        </div>
    @endif
    @if (!isset($edit))
    <div id="new-customer-added" class="row border rounded border-primary px-3 py-2 my-3 shadow">
        <div class="col-12 col-lg-4 pt-3">
            <div class="row justify-content-between pl-md-2 pr-md-2">
                <h5>Выберите клиента</h5>
                <div class="form-group has-icon">
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addCustomer" onclick="event.preventDefault();">
                        <i class="fas fa-plus"></i>
                        <span class="pl-2">Добавить</span>
                    </button>
                </div>
            </div>
            <div class="row justify-content-between pl-md-2 pr-md-2">
                <select class="search-customer form-control">
                    @if(isset($customer))
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endif
                </select>
                <table class="table table-sm mt-2">
                    <tbody>
                        <tr>
                            <th scope="row">
                                Клиент: 
                            </th>
                            <td id="customer-name">
                                @if(isset($customer->name))
                                    <a class="link" href="{{ route('customers.show', $customer->id) }}">{{ $customer->name }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                Телефон:
                            </th>
                            <td id="customer-phones">
                                @if(isset($customer->phones))
                                    @foreach($customer->phones as $customer_phone)
                                    <div>
                                        <span class="align-middle">
                                            {{ $customer_phone->phone }}
                                        </span>
                                        @php
                                            echo $customer_phone->telegram ? "<img src=\"/css/img/telegram-icon.png\" class=\"messenger-icon\"> " : '';
                                            echo $customer_phone->viber ? "<img src=\"/css/img/viber-icon.png\" class=\"messenger-icon\"> " : '';
                                            echo $customer_phone->whatsapp ? "<img src=\"/css/img/whatsapp-icon.png\" class=\"messenger-icon\">" : '';
                                        @endphp
                                    </div>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                Email:
                            </th>
                            <td id="customer-email">
                                @if(empty($customer->comment_about))
                                    {{ "-" }}
                                @else
                                    {{ $customer->email }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                Статус:
                            </th>
                            <td id="customer-status">
                                @if(empty($customer->status))
                                    {{ "-" }}
                                @else
                                    {{ $customer->status }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                Комментарий:
                            </th>
                            <td id="customer-comment">
                                @if(empty($customer->comment_about))
                                    {{ "-" }}
                                @else
                                    {{ $customer->comment_about }}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 col-lg-8 pt-3">
            <div class="row justify-content-center pl-md-2 pr-md-2">
                <h5 class="text-center">Заказы пользователя</h5>
                <table class="table table-sm table-hover mt-2">
                    <thead>
                        <th class="align-middle text-center w-15">
                            Тип
                        </th>
                        <th class="align-middle text-center w-20">
                            <span class="d-block border-bottom border-dark">Фирма</span>
                            <span class="d-block">Модель</span>
                        </th>
                        <th class="align-middle text-center">
                            Дефекты
                        </th>
                        <th class="align-middle text-center w-25">
                            <span class="d-block border-bottom border-dark">Принят</span>
                            <span class="d-block">Статус</span> 
                        </th>
                    </thead>
                    <tbody id="customer-orders">
                    @if(isset($orders))
                        @foreach($orders as $order)
                            <tr onclick="getDeviceInfo({{ $order->id }})">
                                <td class="align-middle text-center">
                                    {{ $order->type }}
                                </td>
                                <td class="align-middle text-center">
                                    <span class="d-block border-bottom border-dark">
                                        {{ $order->manufacturer }}
                                    </span> 
                                    <span class="d-block">
                                        {{ $order->model }}
                                    </span>
                                </td>
                                <td>
                                    {{ $order->defects }}
                                </td>
                                <td class="align-middle text-center">
                                        {{ Date::parse($order->date)->tz(config('custom.tz'))->format('j F Y в H:i') }}
                                    <span class="d-block">
                                        <span class="status px-1 bg-{{ $order->color }}">
                                            {{ $order->status }}
                                        </span>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <form id="order-form" action="{{ route('orders.store') }}" method="POST">
    @else
    <form id="order-form" action="{{ route('orders.update', $order->id) }}" method="POST">
    @method('PUT')
    @endif
    @csrf
    <input id="customer" type="hidden" name="customer" value="{{ $customer->id??($order->customerId??'') }}">
    <div id="new-order" class="row d-flex flex-column px-3 py-2 mb-3 border rounded border-primary shadow">
        <div class="row justify-content-center p-2">
            <h5>Информация о заказе</h5>
        </div>
        <div class="row justify-content-around p-0 p-md-2">
            <div id="new-order-sn" class="col-12 col-md-6 col-lg-4 py-2 py-md-0">
                <label>Серийный номер</label>
                <select class="search-sn" name="sn">
                    @isset($edit)
                        <option value="{{ $order->deviceId }}" selected>{{ $order->deviceSN}}</option>
                    @endisset)
                </select>
                <div class="d-none">
                    <small class="text-danger"></small>
                </div>
            </div>
            <div id="new-order-model" class="col-12 col-md-6 col-lg-2 py-2 py-md-0">
                <label>Модель</label>
                <select class="search-model" name="model">
                    @isset($edit)
                        <option value="{{ $order->modelId }}" selected>{{ $order->modelName }}</option>
                    @endisset
                </select>
                <div class="d-none">
                    <small class="text-danger"></small> 
                </div>
            </div>
            <div id="new-order-typedevice" class="col-12 col-md-6 col-lg-3 py-2 py-lg-0">
                <label>Тип оборудования</label>
                <select class="search-typedevice" name="typedevice">
                    <option></option>
                    @isset($edit)
                        <option value="{{ $order->typeId }}" selected>{{ $order->typeName }}</option>
                    @endisset
                </select>
                <div class="d-none">
                    <small class="text-danger"></small> 
                </div>
            </div>
            <div id="new-order-manufacturer" class="col-12 col-md-6 col-lg-3 py-2 py-lg-0">
                <label>Производитель</label>
                <select class="search-manufacturer" name="manufacturer">
                    <option></option>
                    @isset($edit)
                        <option value="{{ $order->manufacturerId }}" selected>{{ $order->manufacturerName}}</option>
                    @endisset
                </select>
                <div class="d-none">
                    <small class="text-danger"></small> 
                </div>
            </div>
        </div>    
        <div class="row justify-content-around p-0 p-md-2">
            <div id="new-order-date" class="col-12 col-md-6 col-lg-4 py-2 py-md-0">
                <label>Дата приема</label>
                <div class="input-group">
                    <input type="date" class="form-control d-inline" name="date_contract" 
                        value="{{ isset($edit)? Date::parse($order->date)->tz(config('custom.tz'))->format('Y-m-d') : Date::now()->tz(config('custom.tz'))->format('Y-m-d') }}">
                    <div class="input-group-append">
                        <input type="time" class="form-control d-inline" name="time_contract" 
                        value="{{ isset($edit)? Date::parse($order->date)->tz(config('custom.tz'))->format('H:i') : Date::now()->tz(config('custom.tz'))->format('H:i') }}">
                    </div>
                </div>
                <div class="d-none">
                    <small class="text-danger"></small> 
                </div>
            </div>
            <div id="new-order-deadline" class="col-12 col-md-6 col-lg-2 py-2 py-md-0">
                <label>Срок выполнения</label>
                <input type="number" class="form-control" name="deadline" min="1" step="1" value="{{ $order->deadline??'1' }}">
                <div class="d-none">
                    <small class="text-danger"></small> 
                </div>
            </div>
            <div id="new-order-agreed_price" class="col-12 col-md-6 col-lg-3 py-2 py-lg-0">
                <label>Согласованная цена</label>
                <input type="number" class="form-control" name="agreed_price" min="0" step="1" value="{{ $order->agreedPrice??'0' }}">
                <div class="d-none">
                    <small class="text-danger"></small> 
                </div>
            </div>
            <div id="new-order-prepayment" class="col-12 col-md-6 col-lg-3 py-2 py-lg-0">
                <label>Предоплата</label>
                <input type="number" class="form-control" name="prepayment" min="0" step="1" value="{{ $order->prepayment??'0' }}">
                <div class="d-none">
                    <small class="text-danger"></small> 
                </div>
            </div>
        </div>
        <div class="row justify-content-around p-0 p-md-2">
            <div class="col-12 col-md-6 py-2 py-md-0">
                <label>Состояние</label>
                <select class="condition" multiple="multiple" name="conditions[]">
                    <option></option>
                    @isset($edit)
                        @foreach ($order->conditions as $item)
                            <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="col-12 col-md-6 py-2 py-md-0">
                <label>Комплектация</label>
                <select class="equipment" multiple="multiple" name="equipments[]">
                    <option></option>
                    @isset($edit)
                    @foreach ($order->equipments as $item)
                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
        <div class="row justify-content-around p-0 px-md-2 pt-md-0 pb-md-2">
            <div class="col-12 col-md-6 py-2 py-md-0">
                <label>Причина обращения</label>
                <select class="defect" multiple="multiple" name="defects[]">
                    <option></option>
                    @isset($edit)
                    @foreach ($order->defects as $item)
                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                        @endforeach
                    @endisset
                </select>            
            </div>
            <div id="new-order-order_comment" class="col-12 col-md-6 py-2 py-md-0">
                <label>Комментарий</label>
                <textarea class="form-control" placeholder="Комментарий" name="order_comment">{{ $order->comment??'' }}</textarea>
                <div class="d-none">
                    <small class="text-danger"></small> 
                </div>
            </div>
        </div>
        <div class="row justify-content-around p-0 p-md-2">          
            <div id="new-order-engineer" class="col-9 col-md-6 py-2 py-lg-0">
                <label>Исполнитель</label>
                <select class="engineer" name="engineer">
                    <option></option>
                    @foreach ($engineers as $item)
                        <option value="{{ $item->id }}" {{ isset($edit) && $item->id == $order->engineerId?'selected':'' }}>{{ $item->name}}</option>
                    @endforeach
                </select>
                <div class="d-none">
                    <small class="text-danger"></small> 
                </div>
            </div>                
            <div class="col-3 col-md-6 py-2 py-lg-0">
                <div class="form-check pt-1 pt-md-1">
                    <input id="urgency" class="form-check-input" type="checkbox" value="1"  name="urgency" {{ (isset($edit) && $order->urgency)?'checked':'' }}>
                    <label class="form-check-label" for="urgency">
                        Срочно
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row col-12 justify-content-center mt-3">
        <div class="form-group has-icon ">
            <button id="order-button" type="button" class="btn btn-success">
                @if (!isset($edit))
                <i class="fas fa-plus pr-2"></i>
                Добавить заказ
                @else
                Сохранить
                @endif
            </button>
        </div>
    </div>   
    </form>
</div>
@if (!isset($edit))
<div class="modal" tabindex="-1" role="dialog" id="addCustomer">
    <div class="modal-dialog modal-dialog-centered modal-dialog-cutom w-90" role="document">
        <div class="modal-content mx-3 border rounded border-primary">
            <div class="modal-header">
                <h5 class="modal-title modal-center">Добавление нового клиента</h5>
            </div>
            <form id="add-new-cutomer-form" action="{{ route('customers.store')}}" method="POST">
                @csrf
                <div class="container">
                <div id="new-customer" class="row justify-content-between">
                    <div class="col-md-12 col-lg-4">
                        <div class="py-3">
                            <div id="new-customer-name" class="form-group">
                                <label class="m-fa-icon mb-2">ФИО</label>
                                <input  type="text" class="form-control" placeholder="ФИО" name="name">
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                            <div id="new-customer-email" class="form-group">
                                <label class="m-fa-icon mb-2">Email</label>
                                <input type="text" class="form-control" placeholder="Email" name="email">
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                            <div id="new-customer-status" class="form-group">
                                <label class="m-fa-icon mb-2">Статус</label>
                                <input type="text" class="form-control" placeholder="Статус" name="status" maxlength="10">
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                            <div id="new-customer-comment" class="form-group">
                                <label class="m-fa-icon mb-2">Комментарий</label>
                                <textarea class="form-control" placeholder="Комментарий" name="comment"></textarea>
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>  
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-8">
                        <div class="py-3">          
                            <div id="new-customer-address" class="form-group">
                                <label class="m-fa-icon mb-2">Адрес</label>
                                <input type="text" class="form-control" placeholder="Адрес" name="address" value="">
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>                
                            <div id="new-customer-passport" class="form-group">
                                <label class="m-fa-icon mb-2">Паспортные данные</label>
                                <input type="text" class="form-control" placeholder="Паспортные данные" name="passport" value="">
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                            <div id="phones" class="row justify-content-start">
                                <div class="col-md-4 phone" > 
                                    <div id="new-customer-phone1" class="form-group">
                                        <label class="m-fa-icon mb-2">Телефон</label>
                                        <input type="text" class="form-control" placeholder="Телефон" name="phone1" value="">
                                        <div class="d-none"><small class="text-danger"></small></div>
                                    </div>
                                    <div class="form-check form-check-inline m-fa-icon">
                                        <input id="telegramCheck1" type="checkbox" class="form-check-input" value="1" name="telegram1">
                                        <label class="form-check-label" for="telegramCheck1">
                                            <img src="/css/img/telegram-icon.png" class="messenger-icon">
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="viberCheck1" type="checkbox" class="form-check-input" value="1" name="viber1" >
                                        <label class="form-check-label" for="viberCheck1">
                                            <img src="/css/img/viber-icon.png" class="messenger-icon">
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="whatsappCheck1" type="checkbox" class="form-check-input" value="1" name="whatsapp1">
                                        <label class="form-check-label" for="whatsappCheck1">
                                            <img src="/css/img/whatsapp-icon.png" class="messenger-icon">
                                        </label>
                                    </div>
                                </div>
                                <div id="addPhone" class="col-md-4 mt-2 mt-md-0  mt-button">
                                    <button type="button" class="btn btn-success" onclick="addPhone()">
                                        <i class="fas fa-plus pr-2"></i>
                                        Добавить номер
                                    </button>
                                </div>
                            </div>             
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button id="add-new-cutomer" type="button" class="btn btn-success has-icon mr-3">
                        <i class="fas fa-plus pr-2"></i>
                        Добавить клиента
                    </button>
                    <button type="button" class="btn btn-secondary ml-3" data-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection