@extends('layouts.app')

@section('title')
    <title>Материал</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => 'Материал',
        'route'  => 'typerepairparts.index',
        'button' => 'Все материалы'
    ])
    <div class="container py-2">
        <div class="row justify-content-center">
            <div class="col-12">
                <h4>
                    <label class="d-block text-center">
                        <span class="align-middle">{{ $item->name }}</span>
                        <button class="btn btn-secondary btn-sm align-top ml-2" onclick="window.location.href='{{ route('typerepairparts.edit', $item->id) }}';">
                        <i class="fas fa-edit" aria-hidden="true"></i>
                        </button>
                    </label>
                </h4>
            </div>
        </div>
        <div class="d-flex flex-wrap justify-content-center">
            <div class="col-6 col-md-3 text-center">
                <label class="font-weight-bold">Цена</label>
                <p>{{ $item->price }} {{ Session::get('currency') }}</p>
            </div>
            <div class="col-6 col-md-3 text-center">
                <label class="font-weight-bold">Количество</label>
                <p> 
                    @if ($item->infinity)
                        <i class="fas fa-infinity"></i>
                    @else
                        {{ $item->quantity }}
                    @endif
                </p>
            </div>
            <div class="d-flex justify-content-center col-6 col-md-3 text-center">
                <div class="m-fa-icon">
                    <label class="font-weight-bold"><i class="fas fa-home"></i></label>
                    <p>
                        @if ($item->main)
                            <i class="fas fa-check" aria-hidden="true"></i>
                        @else
                            <i class="fas fa-times" aria-hidden="true"></i>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="font-weight-bold">Приоритет</label>
                    <p>{{ $item->priority }}</p>
                </div>
            </div>
            <div class="d-flex justify-content-center col-6 col-md-3 text-center">
                <div class="m-fa-icon">
                    <label class="font-weight-bold"><i class="fas fa-user"></i></label>
                    <p>
                        @if ($item->selfpart)
                            <i class="fas fa-check" aria-hidden="true"></i>
                        @else
                            <i class="fas fa-times" aria-hidden="true"></i>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="font-weight-bold">Продано</label>
                    <p>{{ $item->sales }}</p>
                </div>
            </div>
            <div class="col-12 col-md-6 text-center">
                <label class="font-weight-bold">Описание</label>
                <p class="text-left desc">{{ $item->description }}</p>
            </div>
            <div class="col-12 col-md-6 text-center">
                <label class="font-weight-bold">Комментарий</label>
                <p class="text-left desc">{{ $item->comment }}</p>
            </div>
        </div>
        <div class="row justify-content-end w-75 mx-auto my-2">
            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteRepairpart" onclick="event.preventDefault();">
                <i class="fas fa-trash" aria-hidden="true"></i>
                <span class="">Удалить</span>
            </button>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="deleteRepairpart">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Вы действительно хотите удалить материал?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('typerepairparts.destroy', $item->id)}}">
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