@extends('layouts.app')

@section('title')
    <title>Список типов устройств</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.topTableBar', [
        'title'  => 'Список типов устройств',
        'route'  => 'typedevices.create',
        'buttom' => 'Добавить тип',
        'type'   => 'typedevices',
    ])
    @include('layouts.infoTable', ['route' => 'typedevices.show'])
@endsection