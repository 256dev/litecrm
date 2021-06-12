@extends('layouts.app')

@section('title')
<title>
    @if (!isset($edit))
    Оформление сотрудника
    @else
    Редактирование профиля сотрудника
    @endif
</title>
@endsection

@section('content')

@include('layouts.headAlertBlock')

@include('layouts.headTitleBlock', [
'title' => isset($edit)? 'Редактирование профиля сотрудника' : 'Оформление сотрудника',
'route' => 'users.index',
'button' => 'Все сотрудники'
])

<div class="container py-3">
    @if (!isset($edit))
    <form action="{{ route('users.store') }}" method="POST">
        @else
        <form action="{{ route('users.update', $item->id) }}" method="POST">
            @method('PUT')
            @endif
            @csrf
            <div class="row col-12 col-lg-10 mx-auto">
                <div class="col-12 col-sm-6 mb-2">
                    <label for="username" class="m-fa-icon mb-2">Сотрудник</label>
                    <input aria-label="Имя сотрудника"
                        class="form-control {{ $errors->has('username')?'is-invalid':'' }}"
                        value="{{ old('username')??($item->name??'') }}" required id="username" type="text"
                        name="username" placeholder="Имя сотрудника">
                    @error('username')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>

                <div class="col-12 col-sm-6 mb-2">
                    <label for="email" class="m-fa-icon mb-2">Email</label>
                    <input aria-label="Электронная почта"
                        class="form-control {{ $errors->has('email')?'is-invalid':'' }}" id="email" type="email"
                        placeholder="Электронная почта" name="email" value="{{ old('email')??($item->email??'') }}"
                        required>
                    @error('email')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>

                <div class="col-12 col-sm-6 mb-2">
                    <label for="password" class="m-fa-icon mb-2">Пароль</label>
                    <input aria-label="Пароль" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        id="password" type="password" placeholder="Пароль" name="password" {{ isset($item) ? '' : 'required' }}>
                    @error('password')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>

                <div class="col-12 col-sm-6 mb-2">
                    <label for="username" class="m-fa-icon mb-2">Подтверждение пароля</label>
                    <input aria-label="Подтверждение пароля"
                        class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                        id="username" type="password" name="password_confirmation" placeholder="Подтверждение пароля"
                        {{ isset($item) ? '' : 'required' }}>
                    @error('password_confirmation')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>

                <div class="col-12 col-sm-6 my-2">
                    <div class="mb-2">
                        <label class="m-fa-icon mb-2">Телефон</label>
                        <input aria-label="Основной телефон" type="text" placeholder="Телефон" name="phone1" required
                            class="form-control {{ $errors->has('phone1')? 'is-invalid' : '' }}"
                            value="{{ old('phone1')??(!empty($phones[0])? $phones[0][0] : '') }}">
                        @error('phone1')
                        <div>
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        </div>
                        @enderror
                    </div>
                    <div class="form-check form-check-inline m-fa-icon">
                        <input id="telegramCheck1" type="checkbox" class="form-check-input" value="1" name="telegram1"
                            {{ old('phone1')?(old('telegram1')?'checked':''):(!empty($phones[0][1])? 'checked' : '') }}>
                        <label class="form-check-label" for="telegramCheck1">
                            <img src="/css/img/telegram-icon.png" class="messenger-icon">
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input id="viberCheck1" type="checkbox" class="form-check-input" value="1" name="viber1"
                            {{ old('phone1')?(old('viber1')?'checked':''):(!empty($phones[0][2])? 'checked' : '') }}>
                        <label class="form-check-label" for="viberCheck1">
                            <img src="/css/img/viber-icon.png" class="messenger-icon">
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input id="whatsappCheck1" type="checkbox" class="form-check-input" value="1" name="whatsapp1"
                            {{ old('phone1')?(old('whatsapp1')?'checked':''):(!empty($phones[0][3])? 'checked' : '') }}>
                        <label class="form-check-label" for="whatsappCheck1">
                            <img src="/css/img/whatsapp-icon.png" class="messenger-icon">
                        </label>
                    </div>
                </div>
                <div class="col-12 col-sm-6 my-2">
                    <div class="mb-2">
                        <label class="m-fa-icon mb-2">Телефон</label>
                        <input aria-label="Основной телефон" type="text" placeholder="Телефон" name="phone2"
                            class="form-control {{ $errors->has('phone2')?'is-invalid':'' }}"
                            value="{{ old('phone2')??(!empty($phones[1])? $phones[1][0] : '') }}">
                        @error('phone2')
                        <div>
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        </div>
                        @enderror
                    </div>
                    <div class="form-check form-check-inline m-fa-icon">
                        <input id="telegramCheck2" type="checkbox" class="form-check-input" value="1" name="telegram2"
                            {{ old('phone2')?(old('telegram2')?'checked':''):(!empty($phones[1][1])? 'checked' : '') }}>
                        <label class="form-check-label" for="telegramCheck2">
                            <img src="/css/img/telegram-icon.png" class="messenger-icon">
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input id="viberCheck2" type="checkbox" class="form-check-input" value="1" name="viber2"
                            {{ old('phone2')?(old('viber2')?'checked':''):(!empty($phones[1][2])? 'checked' : '') }}>
                        <label class="form-check-label" for="viberCheck2">
                            <img src="/css/img/viber-icon.png" class="messenger-icon">
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input id="whatsappCheck2" type="checkbox" class="form-check-input" value="1" name="whatsapp2"
                            {{ old('phone2')?(old('whatsapp2')?'checked':''):(!empty($phones[1][3])? 'checked' : '') }}>
                        <label class="form-check-label" for="whatsappCheck2">
                            <img src="/css/img/whatsapp-icon.png" class="messenger-icon">
                        </label>
                    </div>
                </div>
                <div class="col-12 col-sm-6 mb-2">
                    <label for="passport" class="m-fa-icon mb-2">Паспорт</label>
                    <input aria-label="Паспортные данные сотрудника"
                        class="form-control {{ $errors->has('passport')?'is-invalid':'' }}"
                        value="{{ old('passport')??($item->passport??'') }}" id="passport" type="text" name="passport"
                        placeholder="Паспортные данные">
                    @error('passport')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="col-12 col-sm-6 mb-2">
                    <label for="address" class="m-fa-icon mb-2">Адрес</label>
                    <input aria-label="Адрес" class="form-control {{ $errors->has('address')?'is-invalid':'' }}"
                        value="{{ old('address')??($item->address??'') }}" id="address" type="text" name="address"
                        placeholder="Адрес">
                    @error('address')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="col-6 col-md-3 mb-2">
                    <label for="itin" class="m-fa-icon mb-2">ИНН</label>
                    <input aria-label="ИНН" class="form-control {{ $errors->has('itin')?'is-invalid':'' }}" id="itin"
                        type="text" placeholder="ИНН" name="itin" value="{{ old('itin')??($item->itin??'') }}">
                    @error('itin')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="col-6 col-md-3 mb-2">
                    <label for="role" class="m-fa-icon mb-2">Должность</label>
                    <select id="role" aria-label="Должность" class="form-control" name="role">
                        <option></option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ old('role')?($role->id == old('role')?'selected':''):((isset($edit) && $role->id == $item->role_id)?'selected':'') }}>
                            {{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="col-6 col-md-3 mb-2">
                    <label for="hired_date" class="m-fa-icon mb-2">Принят</label>
                    <input aria-label="Принят" class="form-control {{ $errors->has('hired_date')?'is-invalid':'' }}"
                        value="{{ old('hired_date')??(isset($edit)? Date::parse($item->hired_date)->tz(config('custom.tz'))->format('Y-m-d'):'') }}"
                        id="hired_date" type="date" name="hired_date">
                    @error('hired_date')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="col-6 col-md-3 mb-2">
                    <label for="fired_date" class="m-fa-icon mb-2">Уволен</label>
                    <input aria-label="Уволен" class="form-control {{ $errors->has('fired_date')?'is-invalid':'' }}"
                        value="{{ old('fired_date')??($item->rired_date??'') }}" id="fired_date" type="date"
                        name="fired_date">
                    @error('fired_date')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="col-12 col-lg-6 text-md-center mb-2">
                    <label class="m-fa-icon mb-2">Квалификация</label>
                    <textarea aria-label="Квалификация" rows="2" name="qualification" placeholder="Квалификация"
                        class="form-control {{ $errors->has('qualification')?'is-invalid':'' }}">{{ old('qualification')??($item->qualification??'') }}</textarea>
                    @error('qualification')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="col-12 col-lg-6 text-md-center mb-2">
                    <label class="m-fa-icon mb-2">Комментарий</label>
                    <textarea aria-label="Комментарий" rows="2" name="comment" placeholder="Комментарий"
                        class="form-control {{ $errors->has('comment')?'is-invalid':'' }}">{{ old('comment')??($item->comment??'') }}</textarea>
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