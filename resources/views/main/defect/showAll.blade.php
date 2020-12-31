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
    ])

    @include('layouts.infoTable', ['route' => 'defects.show'])
@endsection