@extends('layouts.app')

@section('title')
    <title>Модель устройства {{ $item->name }}</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => 'Модель устройства',
        'route'  => 'devicemodels.index',
        'button' => 'Все модели'
    ])
    <div class="container py-2">
        <div class="row justify-content-center">
            <div class="col-12">
                <h4>
                    <label class="d-block text-center">
                        <span class="align-middle">{{ $item->name }}</span>
                        <button class="btn btn-sm btn-secondary align-top ml-2" onclick="window.location.href='{{ route('devicemodels.edit', $item->id) }}';">
                            <i class="fas fa-edit" aria-hidden="true"></i>
                        </button>
                    </label>
                </h4>
            </div>
        </div>
        <div class="d-flex flex-wrap justify-content-center col-12 col-lg-9 my-2 mx-auto">
            <div class="col-6">
                <div class="text-center">
                    <label class="font-weight-bold">Тип устройства</label>
                    <p>{{ $item->typeDevice }}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="text-center">
                    <label class="font-weight-bold">Бренд</label>
                    <p>{{ $item->manufacturer }}</p>
                </div>
            </div>
            <div class="col-12 col-sm-8">
                <div class="text-center">
                    <label class="font-weight-bold">Комментарий</label>
                    <p class="text-left desc">{{ $item->comment }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-end w-75 mx-auto">
            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteDeviceModel" onclick="event.preventDefault();">
                <i class="fas fa-trash" aria-hidden="true"></i>
                <span class="">Удалить</span>
            </button>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="deleteDeviceModel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Вы действительно хотите удалить модель?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('devicemodels.destroy', $item->id)}}">
                @csrf
                @method('delete')
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Удалить</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection