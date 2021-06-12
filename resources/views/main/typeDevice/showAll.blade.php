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
        'create' => Auth::user()->can('create', App\Models\TypeDevice::class) ? 1 : 0,
    ])
    @include('layouts.infoTable', ['route' => 'typedevices.show'])
@endsection