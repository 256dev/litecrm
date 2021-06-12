@extends('layouts.app')

@section('title')
    <title>Список комплектаций</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.topTableBar', [
        'title'  => 'Список комплектаций',
        'route'  => 'equipments.create',
        'buttom' => 'Добавить комплектацию',
        'type'   => 'equipments',
        'create' => Auth::user()->can('create', App\Models\Equipment::class) ? 1 : 0,
    ])
    @include('layouts.infoTable', ['route' => 'equipments.show'])
@endsection