@extends('layouts.app')

@section('title')
    <title>Комплектация</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => 'Комплектация',
        'route'  => 'equipments.index',
        'button' => 'Все комплектации'
    ])
    @include('layouts.infoShow', [
        'modaltitle'    => 'Вы действительно хотите удалить комплектацию?',
        'modalname'     => 'deleteEquipment',
        'destroy_route' => 'equipments.destroy',
        'edit_route'    => 'equipments.edit',
    ])
@endsection