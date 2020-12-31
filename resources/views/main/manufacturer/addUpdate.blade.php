@extends('layouts.app')

@section('title')
    <title>
        @if (!isset($edit))
            Добавление бренда
        @else
            Редактирование бренда
        @endif 
    </title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => isset($edit)? 'Редактирование бренда' : 'Добавление бренда',
        'route'  => 'manufacturers.index',
        'button' => 'Все бренды'
    ])
    @include('layouts.infoAddUpdateForm', [
        'lable'        => 'Бренд',
        'typename'     => 'manufacturername',
        'update_route' => 'manufacturers.update',
        'store_route'  => 'manufacturers.store'
    ])
@endsection