@extends('layouts.app')

@section('title')
    <title>
        Редактирование профиля
    </title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => 'Редактирование профиля',
        'route'  => 'dashboard',
        'button' => 'На главную'
    ])
    <div class="container py-3">
        <form action="{{ route('settings.user.update') }}" method="POST">
        @method('PUT')
        @csrf
        <div class="row col-12 col-lg-10 mx-auto">
            <div class="col-12 col-sm-6 mb-2">
                <label for="selfname" class="m-fa-icon mb-2">Имя</label>
                <input aria-label="Имя"
                       class="form-control {{ $errors->has('selfname')?'is-invalid':'' }}" 
                       value="{{ old('selfname')??($item->name??'') }}" required
                       id="selfname" type="text" name="selfname" placeholder="Имя"
                >
                @error('selfname')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <label for="email" class="m-fa-icon mb-2">Email</label>
                <input aria-label="Электронная почта"
                       class="form-control {{ $errors->has('email')?'is-invalid':'' }}" 
                       id="email" type="email" placeholder="Электронная почта" name="email"
                       value="{{ old('email')??($item->email??'') }}" required
                >
                @error('email')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-sm-6 my-2">
                <div class="mb-2">
                    <label class="m-fa-icon mb-2">Телефон</label>
                    <input aria-label="Основной телефон"
                            type="text" placeholder="Телефон" name="phone1" required
                            class="form-control {{ $errors->has('phone1')? 'is-invalid' : '' }}" 
                            value="{{ old('phone1')??(!empty($phones[0])? $phones[0][0] : '') }}"
                    >
                    @error('phone1')
                        <div>
                            <small class="text-danger">
                                {{ $message }}
                            </small> 
                        </div>
                    @enderror
                </div>
                <div class="form-check form-check-inline m-fa-icon">
                    <input id="telegramCheck1" type="checkbox" class="form-check-input" value="1" name="telegram1" {{ old('phone1')?(old('telegram1')?'checked':''):(!empty($phones[0][1])? 'checked' : '') }}>
                    <label class="form-check-label" for="telegramCheck1">
                        <img src="/css/img/telegram-icon.png" class="messenger-icon">
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="viberCheck1" type="checkbox" class="form-check-input" value="1" name="viber1" {{ old('phone1')?(old('viber1')?'checked':''):(!empty($phones[0][2])? 'checked' : '') }}>
                    <label class="form-check-label" for="viberCheck1">
                        <img src="/css/img/viber-icon.png" class="messenger-icon">
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="whatsappCheck1" type="checkbox" class="form-check-input" value="1" name="whatsapp1" {{ old('phone1')?(old('whatsapp1')?'checked':''):(!empty($phones[0][3])? 'checked' : '') }}>
                    <label class="form-check-label" for="whatsappCheck1">
                        <img src="/css/img/whatsapp-icon.png" class="messenger-icon">
                    </label>
                </div>
            </div>
            <div class="col-12 col-sm-6 my-2">
                <div class="mb-2">
                    <label class="m-fa-icon mb-2">Телефон</label>
                    <input aria-label="Основной телефон"
                        type="text" placeholder="Телефон" name="phone2"
                        class="form-control {{ $errors->has('phone2')?'is-invalid':'' }}"  
                        value="{{ old('phone2')??(!empty($phones[1])? $phones[1][0] : '') }}"
                    >
                    @error('phone2')
                        <div>
                            <small class="text-danger">
                                {{ $message }}
                            </small> 
                        </div>
                    @enderror
                </div>
                <div class="form-check form-check-inline m-fa-icon">
                    <input id="telegramCheck2" type="checkbox" class="form-check-input" value="1" name="telegram2" {{ old('phone2')?(old('telegram2')?'checked':''):(!empty($phones[1][1])? 'checked' : '') }}>
                    <label class="form-check-label" for="telegramCheck2">
                        <img src="/css/img/telegram-icon.png" class="messenger-icon">
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="viberCheck2" type="checkbox" class="form-check-input" value="1" name="viber2" {{ old('phone2')?(old('viber2')?'checked':''):(!empty($phones[1][2])? 'checked' : '') }}>
                    <label class="form-check-label" for="viberCheck2">
                        <img src="/css/img/viber-icon.png" class="messenger-icon">
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="whatsappCheck2" type="checkbox" class="form-check-input" value="1" name="whatsapp2" {{ old('phone2')?(old('whatsapp2')?'checked':''):(!empty($phones[1][3])? 'checked' : '') }}>
                    <label class="form-check-label" for="whatsappCheck2">
                        <img src="/css/img/whatsapp-icon.png" class="messenger-icon">
                    </label>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <label for="password" class="m-fa-icon mb-2">Пароль</label>
                <input aria-label="Пароль"
                    class="form-control {{ $errors->has('password')?'is-invalid':'' }}"
                    id="password" type="password" name="password" placeholder="Пароль"
                >
                @error('password')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <label for="password_confirmation" class="m-fa-icon mb-2">Подтверждение пароля</label>
                <input aria-label="Подтверждение пароля" 
                    class="form-control" 
                    id="password_confirmation" type="password" name="password_confirmation" placeholder="Подтверждение пароля"
                >
        </div>
        </div>
        <div class="row justify-content-around">
            <button type="submit" class="btn btn-success">
                    Сохранить
            </button>
        </div>  
        </form>
    </div>
@endsection