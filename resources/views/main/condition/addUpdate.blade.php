@extends('layouts.app')

@section('title')
    <title>
        @if (!isset($edit))
            Добавление состояния
        @else
            Редактирование состояние
        @endif 
    </title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => isset($edit)? 'Редактирование состояния' : 'Добавление состояния',
        'route'  => 'conditions.index',
        'button' => 'Все состояния'
    ])
    @include('layouts.infoAddUpdateForm', [
        'lable'        => 'Состояние',
        'typename'     => 'conditionname',
        'update_route' => 'conditions.update',
        'store_route'  => 'conditions.store'
    ])
@endsection