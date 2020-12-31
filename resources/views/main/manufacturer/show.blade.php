@extends('layouts.app')

@section('title')
    <title>Бренд</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => 'Бренд',
        'route'  => 'manufacturers.index',
        'button' => 'Все бренды'
    ])
    @include('layouts.infoShow', [
        'modaltitle'    => 'Вы действительно хотите удалить бренд?',
        'modalname'     => 'deleteManufacturer',
        'destroy_route' => 'manufacturers.destroy',
        'edit_route'    => 'manufacturers.edit',
    ])
@endsection