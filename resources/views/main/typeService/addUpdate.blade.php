@extends('layouts.app')

@section('title')
    <title>
        @if (!isset($edit))
            Добавление услуги
        @else
            Редактирование услуги
        @endif 
    </title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => isset($edit)? 'Редактирование услуги' : 'Добавление услуги',
        'route'  => 'typeservices.index',
        'button' => 'Все услуги'
    ])
    <div class="container py-3">
        @if (!isset($edit))
            <form action="{{ route('typeservices.store') }}" method="POST">
        @else
            <form action="{{ route('typeservices.update', $item->id) }}" method="POST">
            @method('PUT')
        @endif 
        @csrf
        <div class="row col-12 col-lg-10 mx-auto">
            <div class="col-12 col-md-6 mb-2">
                <label for="name">Услуга</label>
                <input id="name" type="text" class="form-control {{ $errors->has('servicename')?'is-invalid':'' }}" name="servicename" value="{{ old('servicename')??($item->name??'') }}">
                @error('servicename')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-sm-6 col-md-3 text-center mb-2">
                <label for="priopricerity">Цена</label>
                <input id="price" type="number" class="form-control {{ $errors->has('price')?'is-invalid':'' }}" name="price" min="0" step="any" value="{{ old('price')??($item->price??'0.00') }}" step="1">
                @error('price')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
                <label for="main" class="m-fa-icon"><i class="fas fa-home"></i></label>
                <label for="priority">Приоритет</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input aria-label="Показать в основном списке" 
                                   id="main" type="checkbox" name="main" value="1" 
                                   {{ (old('main') ? 'checked' : (isset($item) && $item->main? 'checked' : '')) }}
                            >
                        </div>
                    </div>
                    <input aria-label="Сортировка в основном списке" 
                           class="form-control {{ $errors->has('priority')?'is-invalid':'' }}" 
                           value="{{ old('priority')??($item->priority??'15') }}" step="1"
                           id="priority" type="number" min="1" max="5000" name="priority"
                    >
                </div>
                @error('priority')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-lg-6 text-md-center mb-2">
                <label class="m-fa-icon mb-2">Описаине</label>
                <textarea rows="5" class="form-control {{ $errors->has('description')?'is-invalid':'' }}" name="description">{{ old('description')??($item->description??'') }}</textarea>
                @error('description')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-lg-6 text-md-center mb-2">
                <label class="m-fa-icon mb-2">Комментарий</label>
                <textarea rows="5" class="form-control {{ $errors->has('comment')?'is-invalid':'' }}" name="comment">{{ old('comment')??($item->comment??'') }}</textarea>
                @error('comment')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group has-icon mt-2">
                <button type="submit" class="btn btn-success">
                    @if (!isset($edit))
                        <i class="fas fa-plus pr-2"></i>
                        Добавить
                    @else
                        Сохранить
                    @endif
                </button>
            </div>
        </div>  
        </form>
    </div>
@endsection