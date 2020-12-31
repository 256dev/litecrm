@extends('layouts.app')

@section('title')
    <title>Состояние</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => 'Состояние',
        'route'  => 'conditions.index',
        'button' => 'Все состояния'
    ])
    @include('layouts.infoShow', [
        'modaltitle'    => 'Вы действительно хотите удалить состояние?',
        'modalname'     => 'deleteCondition',
        'destroy_route' => 'conditions.destroy',
        'edit_route'    => 'conditions.edit',
    ])
@endsection