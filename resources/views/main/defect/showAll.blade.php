@extends('layouts.app')

@section('title')
    <title>Список причин обращения</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.topTableBar', [
        'title'  => 'Список причин обращения',
        'route'  => 'defects.create',
        'buttom' => 'Добавить причину',
        'type'   => 'defects',
        'create' => Auth::user()->can('create', App\Models\Order::class) ? 1 : 0,
    ])

    @include('layouts.infoTable', ['route' => 'defects.show'])
@endsection