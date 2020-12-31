@extends('layouts.app')

@section('title')
    <title>Причин обращения</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => 'Причина обращения',
        'route'  => 'defects.index',
        'button' => 'Все причины'
    ])
    @include('layouts.infoShow', [
        'modaltitle'    => 'Вы действительно хотите удалить причину обращения?',
        'modalname'     => 'deleteDefect',
        'destroy_route' => 'defects.destroy',
        'edit_route'    => 'defects.edit',
    ])
@endsection