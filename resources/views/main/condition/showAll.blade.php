@extends('layouts.app')

@section('title')
    <title>Список состояний</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.topTableBar', [
        'title'  => 'Список состояний',
        'route'  => 'conditions.create',
        'buttom' => 'Добавить состояние',
        'type'   => 'conditions',
        'create' => Auth::user()->can('create', App\Models\Order::class) ? 1 : 0,
    ])
    @include('layouts.infoTable', ['route' => 'conditions.show'])
@endsection