@extends('layouts.app')

@section('title')
    <title>
        @if (!isset($edit))
            Добавление причины обращения
        @else
            Редактирование причины обращения
        @endif 
    </title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => isset($edit)? 'Редактирование причины обращения' : 'Добавление причины обращения',
        'route'  => 'defects.index',
        'button' => 'Все причины'
    ])
    @include('layouts.infoAddUpdateForm', [
        'lable'        => 'Причина',
        'typename'     => 'defectname',
        'update_route' => 'defects.update',
        'store_route'  => 'defects.store'
    ])
@endsection