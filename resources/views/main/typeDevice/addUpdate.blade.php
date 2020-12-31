@extends('layouts.app')

@section('title')
    <title>
        @if (!isset($edit))
            Добавление типа устройства
        @else
            Редактирование типа устройства
        @endif 
    </title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => isset($edit)? 'Редактирование типа устройства' : 'Добавление типа устройства',
        'route'  => 'typedevices.index',
        'button' => 'Все типы'
    ])
    @include('layouts.infoAddUpdateForm', [
        'lable'        => 'Тип устройства',
        'typename'     => 'typedevicename',
        'update_route' => 'typedevices.update',
        'store_route'  => 'typedevices.store'
    ])
@endsection