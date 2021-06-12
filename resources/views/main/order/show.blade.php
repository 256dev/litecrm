@extends('layouts.app')

@section('title')
    <title>Заказ № {{ $order->id }}</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => 'Заказ',
        'route'  => 'orders.index',
        'button' => 'Все заказы'
    ])
    <div class="container py-3">
        <div class="d-flex justify-content-center">
            <h4>
                {{ $order->number }}
                @can('update', $order)
                    <button class="btn btn-secondary btn-sm align-top ml-2" onclick="window.location.href='{{ route('orders.edit', $order->id) }}';">
                        <i class="fas fa-edit" aria-hidden="true"></i>
                    </button>    
                @endcan
            </h4>
        </div>
        <div class="row justify-content-between">
            <div class="col-12 col-sm-7 col-md-6 col-lg-4 pl-0 mb-3">
                <div class="col-12">
                    <span class="font-weight-bold">Тип:</span>
                    <span>{{ $order->type }}</span>
                </div>
                <div class="col-12">
                    <span class="font-weight-bold">Бренд:</span>
                    <span>{{ $order->manufacturer }}</span>
                </div>
                <div class="col-12">
                    <span class="font-weight-bold">Модель:</span>
                    <span>{{ $order->model }}</span>
                </div>
                <div class="col-12">
                    <span class="font-weight-bold">SN:</span>
                    <span>{{ $order->sn }}</span>
                </div>
                <div class="col-12">
                    <span class="font-weight-bold">Принят:</span>
                    <span>{{ Date::parse($order->date)->tz(config('custom.tz'))->format('j F Y в G:i') }}</span>
                </div>
                <div class="col-12">
                    <span class="font-weight-bold">Срок:</span>
                    <span>{{ Date::now()->timespan($order->deadline . ' days') }} 
                        @if ($order->urgency)
                            <span class="badge badge-danger ml-2 px-3 py-1 ">Срочно</span>
                        @endif
                    </span>
                </div>
                <div class="col-12">
                    <span class="font-weight-bold">Принял:</span>
                    @can('view', $order->userCreatedOrder)
                        <span><a class="link" href="{{ route('users.show', $order->inspector_id) }}">{{ $order->inspector_name }}</a></span>
                    @else
                        <span>{{ $order->inspector_name }}</span>
                    @endcan
                </div>
                <div class="col-12">
                    <span class="font-weight-bold">Мастер:</span>
                    @can('view', $order->userRepairOrder)
                        <span><a class="link" href="{{ route('users.show', $order->engineer_id) }}">{{ $order->engineer_name }}</a></span>
                    @else
                        <span>{{ $order->engineer_name }}</span>
                    @endcan
                </div>
            </div>
            <div class="col-12 col-sm-5 col-md-6 col-lg-4 pl-0 mb-3">
                <div class="col-12">
                    <div>
                        @can('view', $customer)
                            <span class="font-weight-bold pr-2">Клиент:</span><a class="link" href="{{ route('customers.show', $customer->id) }}">{{ $customer->name }}</a>
                        @else
                            <span class="font-weight-bold pr-2">Клиент:</span>{{ $customer->name }}
                        @endcan

                    </div>
                    <div>
                        <span class="font-weight-bold pr-2">Статус:</span><span>{{ $customer->status }}</span>
                    </div>
                    <div>
                        <span class="font-weight-bold">Контакты:</span>
                        @foreach ($customer->phones as $phone)
                            <div class="text-left pl-3">
                                <span class="align-middle">{{ $phone->phone }}</span>
                                @if($phone->telegram)<img src="/css/img/telegram-icon.png" class="messenger-icon">@endif
                                @if($phone->viber)<img src="/css/img/viber-icon.png" class="messenger-icon">@endif
                                @if($phone->whatsapp)<img src="/css/img/whatsapp-icon.png" class="messenger-icon">@endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 pl-3 pl-0 pb-2" id="add-status-block" >
                <h4 class="text-center my-1">
                    История статусов
                    @can('update', $order)
                        <a class="btn" data-toggle="modal" data-target="#addStatus" onclick="event.preventDefault();">
                            <span class="status bg-success d-inline col-3 align-top font-weight-bold">+</span>
                        </a>
                    @endcan
                </h4>
                @foreach($statuses as $status)
                    <div class="row justify-content-center pb-1">
                        <div class="col-4 col-sm-5 col-md-4 col-lg-4 pr-1">
                            <span class="status px-1 bg-{{ $status->color }}">{{ $status->name }}</span>
                        </div>
                        <div class="col-8 col-sm-5 col-md-4 col-lg-8 pl-1">
                            <span>{{ Date::parse($status->date)->tz(config('custom.tz'))->format('j F Y в G:i') }}</span>
                        </div>
                    </div>
                @endforeach
                <div class="row justify-content-around w-85 mx-auto my-2 col-12">
                    <button class="btn btn-dark btn-sm" onclick="window.open('{{ route('download.receipt', $order->id) }}');">
                        <i class="fas fa-print" aria-hidden="true"></i>
                        <span class="">Акт приема</span>
                    </button>
                    <button class="btn btn-light btn-sm border-dark rounded" onclick="window.open('{{ route('download.act', $order->id) }}');">
                        <i class="fas fa-print" aria-hidden="true"></i>
                        <span class="">Акт выдачи</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-12 col-sm-7 col-lg-6 mb-3">
                <div>
                    <span class="font-weight-bold">Причина обращения:</span>
                    <span>{{ $order->defects }}</span>
                </div>
                <div>
                    <span class="font-weight-bold">Состояние:</span>
                    <span>{{ $order->conditions }}</span>
                </div>
                <div>
                    <span class="font-weight-bold">Комплектация:</span>
                    <span>{{ $order->equipments }}</span>
                </div>
                <div>
                    <span class="font-weight-bold">Комментарий:</span>
                    <span>{{ $order->order_comment}}</span>
                </div>
            </div>
            <div class="col-12 col-sm-5 col-lg-6">
                <div>
                    <span class="font-weight-bold">Согласованная цена:</span>
                    <span>{{ $order->agreed_price }} {{ Session::get('currency') }}</span>
                </div>
                <div>
                    <span class="font-weight-bold">Предоплата:</span>
                    <span>{{ $order->prepayment }} {{ Session::get('currency') }}</span>
                </div>
                <div>
                    <span class="font-weight-bold">Стоимость услуг:</span>
                    <span id="price-service">{{ $order->price_work }} {{ Session::get('currency') }}</span>
                </div>
                <div>
                    <span class="font-weight-bold">Стоимость материалов:</span>
                    <span id="price-repairpart">{{ $order->price_repair_parts }} {{ Session::get('currency') }}</span>
                </div>
                <div>
                    <span class="font-weight-bold">Итого:</span>
                    <span id="price-total">{{ $order->total_price }} {{ Session::get('currency') }}</span>
                </div>
                <div>
                    <span class="font-weight-bold">Скидка:</span>
                    <span id="price-discount">{{ $order->discount }} {{ Session::get('currency') }}</span>
                    @can('update', $order)
                        <a class="btn pointer" data-toggle="modal" data-target="#addDiscount" onclick="event.preventDefault();">
                            <span class="status bg-success d-inline col-3 align-top">+</span>
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="row justify-content-between py-3">
            <div class="col-12 col-md-7 col-lg-6">
                <div id="add-repairpart-block"  class="mb-2">
                    <div>
                        <span class="font-weight-bold">
                            Материалы:
                            @can('update', $order)
                                <a class="btn pointer" data-toggle="modal" data-target="#addRepairPart" onclick="event.preventDefault();">
                                    <span class="status bg-success d-inline col-3 align-top">+</span>
                                </a>
                            @endcan
                        </span>
                    </div>
                    <table class="table table-striped shadow table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="align-middle text-center py-1">
                                    Название
                                </th>
                                <th scope="col" class="align-middle text-center py-1">
                                    Кол.
                                </th>
                                <th scope="col" class="align-middle text-center py-1">
                                    Цена
                                </th>
                                <th scope="col" class="align-middle text-center py-1">
                                    Клиента
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @can('update', $order) 
                                @foreach ($repairParts as $item)
                                <tr id="repairpart-{{ $item->id }}" class="pointer" onclick="updateRepairpart({{ $item->id }});">
                                    <td scope="row" class="align-middle">
                                        {{ $item->name }}
                                    </td>
                                    <td scope="row" class="align-middle text-center quantity">
                                        {{ $item->quantity }}
                                    </td>
                                    <td scope="row" class="align-middle text-center price">
                                        {{ $item->price }} {{ Session::get('currency') }}
                                    </td>
                                    <td scope="row" class="align-middle text-center selfpart">
                                        @if ($item->selfpart)
                                            <i class="fas fa-check" aria-hidden="true"></i>
                                        @else
                                            <i class="fas fa-times" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                @foreach ($repairParts as $item)
                                <tr id="repairpart-{{ $item->id }}" class="pointer">
                                    <td scope="row" class="align-middle">
                                        {{ $item->name }}
                                    </td>
                                    <td scope="row" class="align-middle text-center quantity">
                                        {{ $item->quantity }}
                                    </td>
                                    <td scope="row" class="align-middle text-center price">
                                        {{ $item->price }} {{ Session::get('currency') }}
                                    </td>
                                    <td scope="row" class="align-middle text-center selfpart">
                                        @if ($item->selfpart)
                                            <i class="fas fa-check" aria-hidden="true"></i>
                                        @else
                                            <i class="fas fa-times" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @endcan
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-5 col-lg-6">
                <div  id="add-service-block" class="mb-2">
                    <div>
                        <span class="font-weight-bold">
                            Услуги:
                            @can('update', $order)
                                <a class="btn" data-toggle="modal" data-target="#addService" onclick="event.preventDefault();">
                                    <span class="status bg-success d-inline col-3 align-top">+</span>
                                </a>
                            @endcan
                        </span>
                    </div>
                    <table class="table table-striped shadow table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="align-middle text-center py-1">
                                    Название
                                </th>
                                <th scope="col" class="align-middle text-center py-1">
                                    Кол.
                                </th>
                                <th scope="col" class="align-middle text-center py-1">
                                    Цена
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @can('update', $order)
                                @foreach ($services as $item)
                                <tr id="service-{{ $item->id }}" class="pointer" onclick="updateService({{ $item->id }})">
                                    <td scope="row" class="align-middle">
                                        {{ $item->name }}
                                    </td>
                                    <td scope="row" class="align-middle text-center quantity">
                                        {{ $item->quantity }}
                                    </td>
                                    <td scope="row" class="align-middle text-center price">
                                        {{ $item->price }} {{ Session::get('currency') }}
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                @foreach ($services as $item)
                                <tr id="service-{{ $item->id }}" class="pointer">
                                    <td scope="row" class="align-middle">
                                        {{ $item->name }}
                                    </td>
                                    <td scope="row" class="align-middle text-center quantity">
                                        {{ $item->quantity }}
                                    </td>
                                    <td scope="row" class="align-middle text-center price">
                                        {{ $item->price }} {{ Session::get('currency') }}
                                    </td>
                                </tr>
                                @endforeach
                            @endcan
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="row justify-content-end w-75 mx-auto my-2">
            @can('delete', $order)
                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteOrder" onclick="event.preventDefault();">
                    <i class="fas fa-trash" aria-hidden="true"></i><span class="">Удалить</span>
                </button>
            @endcan
        </div>
    </div>

        <div class="modal" tabindex="-1" role="dialog" id="deleteOrder">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Вы действительно хотите удалить заказ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('orders.destroy', $order->id)}}">
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

    <div class="modal" tabindex="-1" role="dialog" id="addRepairPart">
        <div class="modal-dialog modal-dialog-centered modal-dialog-cutom w-90" role="document">
            <div class="modal-content mx-3 border rounded border-primary">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить материал</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add-repairpart-form" method="POST" action="{{ route('order.add.repairPart', $order->id)}}">
                @csrf
                <div id="add-repairpart" class="container py-2">
                    <div class="row justify-content-center">
                        <div class="row justify-content-start col-12 col-md-5">
                            <div id="add-repairpart-repairpartname" class="col-12 mt-2">
                                <label>Материал</label>
                                <select class="search-repairpart" name="repairpartname"></select>
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                            <div id="add-repairpart-selfpart" class="col-12 mt-2" >
                                <div class="form-check">
                                    <input id="repairpart-selfpart" type="checkbox" class="form-check-input" name="selfpart" value="1">
                                    <label for="repairpar-seflpart" class="form-check-label">Материал клиента</label>
                                </div>
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                            <div id="add-repairpart-price" class="col-7 mt-2">
                                <label for="repairpart-price">Стоимость</label>
                                <input id="repairpart-price" type="number" class="form-control" min="0"  step="any" value="0" name="price">
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                            <div id="add-repairpart-quantity" class="col-5 mt-2">
                                <label for="repairpart-quantity">Количество</label>
                                <input id="repairpart-quantity" type="number" class="form-control" min="1" step="1" value="1" name="quantity">
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                        </div>
                        <div id="add-repairpart-description" class="col-12 col-md-7 mt-3 mt-md-1 text-center">
                            <label for="repairpart-description">Описание материала</label>
                            <p id="repairpart-description" class="mt-1 text-left"></p>
                            <div class="d-none"><small class="text-danger"></small></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="add-repairpart-buttom" type="button" class="btn btn-primary has-icon mr-3">
                        <i class="fas fa-plus pr-2"></i>Добавить
                    </button>
                    <button type="button" class="btn btn-secondary ml-3" data-dismiss="modal">Закрыть</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="updateRepairPart">
        <div class="modal-dialog modal-dialog-centered modal-dialog-cutom w-90" role="document">
            <div class="modal-content mx-3 border rounded border-primary">
                <div class="modal-header">
                    <h5 class="modal-title">Редактировать материал</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="update-repairpart-form" method="POST" action="{{ route('order.update.repairPart', $order->id) }}">
                @csrf
                <input id="update-repairpart-id" type="hidden" name="id">
                <div id="update-repairpart" class="container py-2">
                    <div class="row justify-content-center">
                        <div class="row justify-content-start col-12 col-md-5">
                            <div id="upd-repairpart-repairpartname" class="col-12 mt-2">
                                <label>Материал</label>
                                <p></p>
                            </div>
                            <div id="update-repairpart-selfpart" class="col-12 mt-2" >
                                <div class="form-check">
                                    <input id="upd-repairpart-selfpart" type="checkbox" class="form-check-input" name="selfpart" value="1">
                                    <label for="upd-repairpar-seflpart" class="form-check-label">Материал клиента</label>
                                </div>
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                            <div id="update-repairpart-price" class="col-7 mt-2">
                                <label for="upd-repairpart-price">Стоимость</label>
                                <input id="upd-repairpart-price" type="number" class="form-control" min="0"  step="any" value="0" name="price">
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                            <div id="update-repairpart-quantity" class="col-5 mt-2">
                                <label for="upd-repairpart-quantity">Количество</label>
                                <input id="upd-repairpart-quantity" type="number" class="form-control" min="1" step="1" value="1" name="quantity">
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                        </div>
                        <div id="update-repairpart-description" class="col-12 col-md-7 mt-3 mt-md-1 text-center">
                            <label for="upd-repairpart-description">Описание материала</label>
                            <p id="upd-repairpart-description" class="mt-1 text-left"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="update-repairpart-buttom" type="button" class="btn btn-primary has-icon mr-3">
                        <i class="fas fa-plus pr-2"></i>Изменить
                    </button>
                    <button id="delete-repairpart-buttom" type="button" class="btn btn-danger has-icon mr-3">
                        <i class="fas fa-trash pr-2"></i>Удалить
                    </button>
                    <button type="button" class="btn btn-secondary ml-3" data-dismiss="modal">Закрыть</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="addService">
        <div class="modal-dialog modal-dialog-centered modal-dialog-cutom w-90" role="document">
            <div class="modal-content mx-3 border rounded border-primary">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить новую услугу</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add-service-form" method="POST" action="{{ route('order.add.service', $order->id)}}">
                @csrf
                <div id="add-service" class="container py-2">
                    <div class="row justify-content-center">
                        <div class="row justify-content-start col-12 col-md-5">
                            <div id="add-service-servicename" class="col-12 mt-2">
                                <label>Услуги</label>
                                <select class="search-service" name="servicename"></select>
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                            <div id="add-service-price" class="col-7 mt-2">
                                <label for="service-price">Стоимость</label>
                                <input id="service-price" type="number" class="form-control" min="0"  step="any" value="0" name="price">
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                            <div id="add-service-quantity" class="col-5 mt-2">
                                <label for="service-quantity">Количество</label>
                                <input id="service-quantity" type="number" class="form-control" min="1" step="1" value="1" name="quantity">
                                <div class="d-none"><small class="text-danger"></small> </div>
                            </div>
                        </div>
                        <div id="add-service-description" class="col-12 col-md-7 mt-3 mt-md-1 text-center">
                            <label for="service-description">Описание услуги</label>
                            <p id="service-description" class="mt-1 text-left"></p>
                            <div class="d-none"><small class="text-danger"></small></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="add-service-buttom" type="button" class="btn btn-primary has-icon mr-3">
                        <i class="fas fa-plus pr-2"></i>Добавить
                    </button>
                    <button type="button" class="btn btn-secondary ml-3" data-dismiss="modal">Закрыть</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="updateService">
        <div class="modal-dialog modal-dialog-centered modal-dialog-cutom w-90" role="document">
            <div class="modal-content mx-3 border rounded border-primary">
                <div class="modal-header">
                    <h5 class="modal-title">Редактировать услугу</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="update-service-form" method="POST" action="{{ route('order.update.service', $order->id) }}">
                @csrf
                <input id="update-sevice-id" type="hidden" name="id">
                <div id="update-service" class="container py-2">
                    <div class="row justify-content-center">
                        <div class="row justify-content-start col-12 col-md-5">
                            <div id="upd-service-servicename" class="col-12 mt-2">
                                <label>Услуга</label>
                                <p></p>
                            </div>
                            <div id="update-service-price" class="col-7 mt-2">
                                <label for="upd-service-price">Стоимость</label>
                                <input id="upd-service-price" type="number" class="form-control" min="0"  step="any" value="0" name="price">
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                            <div id="update-service-quantity" class="col-5 mt-2">
                                <label for="upd-service-quantity">Количество</label>
                                <input id="upd-service-quantity" type="number" class="form-control" min="1" step="1" value="1" name="quantity">
                                <div class="d-none"><small class="text-danger"></small> </div>
                            </div>
                        </div>
                        <div id="update-service-description" class="col-12 col-md-7 mt-3 mt-md-1 text-center">
                            <label for="upd-service-description">Описание услуги</label>
                            <p id="upd-service-description" class="mt-1 text-left"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="update-service-buttom" type="button" class="btn btn-primary has-icon mr-3">
                        <i class="fas fa-plus pr-2"></i>Изменить
                    </button>
                    <button id="delete-service-buttom" type="button" class="btn btn-danger has-icon mr-3">
                        <i class="fas fa-trash pr-2"></i>Удалить
                    </button>
                    <button type="button" class="btn btn-secondary ml-3" data-dismiss="modal">Закрыть</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="addStatus">
        <div class="modal-dialog modal-dialog-centered modal-dialog-cutom w-90" role="document">
            <div class="modal-content mx-3 border rounded border-primary">
                <div class="modal-header">
                    <h5 class="modal-title">Изменить статус</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add-status-form" method="POST" action="{{ route('order.add.status', $order->id)}}">
                @csrf
                <div id="add-status" class="container py-2">
                    <div class="row justify-content-center col-12">
                            <div id="add-status-statusname" class="col-12 col-md-6 mt-2">
                                <label>Статус</label>
                                <select class="search-status" name="statusname"></select>
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                            <div id="add-status-comment" class="col-12 col-md-6 mt-2">
                                <label>Комментарий</label>
                                <textarea class="form-control" name="comment"></textarea>
                                <div class="d-none"><small class="text-danger"></small></div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="add-status-buttom" type="button" class="btn btn-primary has-icon mr-3">
                        <i class="fas fa-plus pr-2"></i>Добавить
                    </button>
                    <button type="button" class="btn btn-secondary ml-3" data-dismiss="modal">Закрыть</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="addDiscount">
        <div class="modal-dialog modal-dialog-centered modal-dialog-cutom w-70" role="document">
            <div class="modal-content mx-3 border rounded border-primary">
                <div class="modal-header">
                    <h5 class="modal-title">Скидка</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form id="add-discount-form" method="POST" action="{{ route('order.add.discount', $order->id)}}">
                @csrf
                <div id="add-discount" class="container py-2">
                    <div class="row justify-content-center col-12">
                        <div id="add-discount-discount" class="col-12 col-md-6 mt-2">
                            <label>Скидка</label>
                            <input type="number" class="form-control" name="discount" value="{{ $order->discount }}">
                            <div class="d-none"><small class="text-danger"></small></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="add-discount-buttom" type="button" class="btn btn-primary has-icon mr-3">
                        <i class="fas fa-plus pr-2"></i>Изменить
                    </button>
                    <button type="button" class="btn btn-secondary ml-3" data-dismiss="modal">Закрыть</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection