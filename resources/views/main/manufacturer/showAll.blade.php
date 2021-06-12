@extends('layouts.app')

@section('title')
    <title>Список брендов</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.topTableBar', [
        'title'  => 'Список брендов',
        'route'  => 'manufacturers.create',
        'buttom' => 'Добавить бренд',
        'type'   => 'manufacturers',
        'create' => Auth::user()->can('create', App\Models\Manufacturer::class) ? 1 : 0,
    ])  
    @include('layouts.infoTable', ['route' => 'manufacturers.show'])
@endsection