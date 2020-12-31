@extends('layouts.app')

@section('title')
    <title>
        @if (!isset($edit))
            Добавление модели устройства
        @else
            Редактирование модели устройства
        @endif 
    </title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => isset($edit)? 'Редактирование модели устройства' : 'Добавление модели устройства',
        'route'  => 'devicemodels.index',
        'button' => 'Все модели'
    ])
    <div class="container py-3">
        @if (!isset($edit))
            <form action="{{ route('devicemodels.store') }}" method="POST">
        @else
            <form action="{{ route('devicemodels.update', $item->id) }}" method="POST">
            @method('PUT')
        @endif 
        @csrf
        <div class="row col-12 col-lg-9 mx-auto">
            <div class="col-12 col-lg-4 mb-2">
                <label for="name" class="m-fa-icon mb-2">Модель</label>
                <input id="name" type="text" class="form-control {{ $errors->has('devicemodelname')?'is-invalid':'' }}" name="devicemodelname" value="{{ old('devicemodelname')??($item->name??'') }}">
                @error('devicemodelname')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div id="new-order-typedevice" class="col-12 col-md-6 col-lg-4 py-2 py-lg-0 mb-2">
                <label class="m-fa-icon mb-2">Тип оборудования</label>
                <select class="search-typedevice" name="typedevice">
                    <option></option>
                    @isset($edit)
                        <option value="{{ $item->typeDeviceId }}" selected>{{ $item->typeDeviceName }}</option>
                    @endisset
                </select>
                @error('typedevice')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div id="new-order-manufacturer" class="col-12 col-md-6 col-lg-4 py-2 py-lg-0 mb-2">
                <label class="m-fa-icon mb-2">Производитель</label>
                <select class="search-manufacturer" name="manufacturer">
                    <option></option>
                    @isset($edit)
                        <option value="{{ $item->manufacturerId }}" selected>{{ $item->manufacturerName}}</option>
                    @endisset
                </select>
                @error('manufacturer')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 text-md-center mb-2">
                <label class="m-fa-icon mb-2">Комментарий</label>
                <textarea rows="3" class="form-control {{ $errors->has('comment')?'is-invalid':'' }}" name="comment">{{ old('comment')??($item->comment??'') }}</textarea>
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