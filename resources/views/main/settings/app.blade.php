@extends('layouts.app')

@section('title')
    <title>
        Настройки
    </title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => 'Настройки',
        'route'  => 'dashboard',
        'button' => 'На главную'
    ])
    <div class="container py-3">
        <form action="{{ route('settings.update') }}" method="POST">
        @method('PUT')
        @csrf
        <div class="row col-12 col-lg-10 mx-auto mb-2">
            <div class="col-12 col-sm-6 mb-2">
                <label for="companyname" class="m-fa-icon mb-2">Название</label>
                <input aria-label="Название"
                    class="form-control {{ $errors->has('companyname')?'is-invalid':'' }}" 
                    value="{{ old('companyname')??($item->name??'') }}" required
                    id="companyname" type="text" name="companyname" placeholder="Название"
                >
                @error('companyname')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <label for="legalname" class="m-fa-icon mb-2">Юридическое название</label>
                <input aria-label="Юридическое название"
                    class="form-control {{ $errors->has('legalname')?'is-invalid':'' }}" 
                    id="legalname" type="text" placeholder="Юридическое название" name="legalname"
                    value="{{ old('legalname')??($item->legal_name??'') }}"
                >
                @error('legalname')
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
            <div class="col-12 col-sm-6 mb-2">
                <label for="address" class="m-fa-icon mb-2">Адрес</label>
                <input aria-label="Адрес"
                    class="form-control {{ $errors->has('address')?'is-invalid':'' }}" 
                    value="{{ old('address')??($item->address??'') }}"
                    id="address" type="text" name="address" placeholder="Адрес"
                >
                @error('address')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-sm-4 mb-2">
                <label for="unitcode" class="m-fa-icon mb-2">Код отделения (2-4 сивола)</label>
                <input aria-label="Код отделения (2-4 сивола)" style="text-transform: uppercase"
                    class="form-control {{ $errors->has('unitcode')?'is-invalid':'' }}" required
                    value="{{ old('unitcode')??($item->unitcode??'') }}" minlength="2" maxlength="4"
                    id="unitcode" type="text" name="unitcode"
                >
                @error('unitcode')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 col-sm-2 mb-2">
                <label for="currency" class="m-fa-icon mb-2">Валюта</label>
                <input aria-label="Валюта"
                    class="form-control {{ $errors->has('currency')?'is-invalid':'' }}" required
                    value="{{ old('currency')??($item->currency??'') }}" minlength="1" maxlength="3"
                    id="currency" type="text" name="currency"
                >
                @error('currency')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="col-12 text-md-center mb-2">
                <label class="m-fa-icon mb-2">Условия ремонта </label>
                <textarea rows="7" class="form-control {{ $errors->has('repair_conditions')?'is-invalid':'' }}" name="repair_conditions">{{ old('repair_conditions')??($item->repair_conditions??'') }}</textarea>
                @error('repair_conditions')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
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