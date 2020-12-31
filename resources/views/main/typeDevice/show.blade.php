@extends('layouts.app')

@section('title')
    <title>Тип устройства</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => 'Тип устройства',
        'route'  => 'typedevices.index',
        'button' => 'Все типы'
    ])
    @include('layouts.infoShow', [
        'modaltitle'    => 'Вы действительно хотите удалить тип устройства?',
        'modalname'     => 'deleteTypeDevice',
        'destroy_route' => 'typedevices.destroy',
        'edit_route'    => 'typedevices.edit',
    ])
@endsection