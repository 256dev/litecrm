@extends('layouts.app')

@section('title')
    <title>
        @if (!isset($edit))
            Добавление материала
        @else
            Редактирование материала
        @endif 
    </title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => isset($edit)? 'Редактирование материала' : 'Добавление материала',
        'route'  => 'typerepairparts.index',
        'button' => 'Все материалы'
    ])
    <div class="container py-3">
        @if (!isset($edit))
            <form action="{{ route('typerepairparts.store') }}" method="POST">
        @else
            <form action="{{ route('typerepairparts.update', $item->id) }}" method="POST">
            @method('PUT')
        @endif 
        @csrf
        <div class="row col-12 col-lg-10 mx-auto">
            <div class="col-12 col-sm-8 mb-2">
                <label for="repairpartname">Материал</label>
                <input aria-label="Название материала"
                       class="form-control {{ $errors->has('repairpartname')?'is-invalid':'' }}" 
                       value="{{ old('repairpartname')??($item->name??'') }}"
                       id="repairpartname" type="text" name="repairpartname" placeholder="Название материала"
                >
                @error('repairpartname')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-sm-4 mb-2">
                <label for="priopricerity">Цена</label>
                <input aria-label="Цена материала"
                       class="form-control {{ $errors->has('price')?'is-invalid':'' }}" 
                       id="price" type="number" name="price" min="0" step="any"
                       value="{{ old('price')??($item->price??'0') }}"
                >
                @error('price')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-sm-4 mb-2">
                <label for="infinity" class="m-fa-icon"><i class="fas fa-infinity"></i></label>
                <label for="quantity">Количество</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input aria-label="Не ограниченное количество" 
                                   id="infinity" type="checkbox" name="infinity" value="1" 
                                   {{ (old('infinity') ? 'checked' : (isset($item) && $item->infinity? 'checked' : '')) }}
                            >
                        </div>
                    </div>
                    <input aria-label="Количество материала" 
                           class="form-control {{ $errors->has('quantity')?'is-invalid':'' }}" 
                           value="{{ old('quantity')??($item->quantity??'0') }}" step="any"
                           id="quantity" type="number" min="0" max="50000" name="quantity"
                    >
                </div>
                @error('quantity')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-sm-4 mb-2">
                <label for="selfpart" class="m-fa-icon"><i class="fas fa-user"></i></label>
                <label for="priority">Продано</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input aria-label="Материал клиента" 
                                   id="selfpart" type="checkbox" name="selfpart" value="1" 
                                   {{ (old('selfpart') ? 'checked' : (isset($item) && $item->selfpart? 'checked' : '')) }}
                            >
                        </div>
                    </div>
                    <input aria-label="Проданое количетсво" 
                           class="form-control {{ $errors->has('sales')?'is-invalid':'' }}" 
                           value="{{ old('sales')??($item->sales??'0') }}" step="any"
                           id="sales" type="number" min="0" max="50000" name="sales"
                    >
                </div>
                @error('sales')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-sm-4 mb-2">
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