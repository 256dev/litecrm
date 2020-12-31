@extends('layouts.app')

@section('title')
    <title>
        @if (!isset($edit))
            Добавление комплектации
        @else
            Редактирование комплектации
        @endif 
    </title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => isset($edit)? 'Редактирование комплектации' : 'Добавление комплектации',
        'route'  => 'equipments.index',
        'button' => 'Все комплектации'
    ])
    @include('layouts.infoAddUpdateForm', [
        'lable'        => 'Комплектации',
        'typename'     => 'equipmentname',
        'update_route' => 'equipments.update',
        'store_route'  => 'equipments.store'
    ])
@endsection