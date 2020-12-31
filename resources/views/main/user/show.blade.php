@extends('layouts.app')

@section('title')
    <title>Сотрудник</title>  
@endsection

@section('content')
@include('layouts.headAlertBlock')
@include('layouts.headTitleBlock', [
    'title'  => 'Сотрудник',
    'route'  => 'users.index',
    'button' => 'Все сотрудники'
])
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-12">
            <h4>
                <label class="d-block text-center">
                    <span class="align-middle">{{ $item->name }}</span>
                    <button class="btn btn-secondary btn-sm align-top ml-2" onclick="window.location.href='{{ route('users.edit', $item->id) }}';">
                    <i class="fas fa-edit" aria-hidden="true"></i>
                    </button>
                </label>
            </h4>
        </div>
    </div>
    <div class="row justify-content-between my-3">
        <div class="col-12 col-md-6">
            <div class="pb-2">
                <span class="font-weight-bold pr-2">Email:</span> {{ $item->email }}
            </div>
            <div class="d-flex flex-row pb-2">
                <div>
                    <span class="font-weight-bold">Телефон:</span>
                </div>
                <div class="pl-2">
                    @foreach ($phones as $phone)
                        <div class="text-left">
                            <span class="align-middle">{{ $phone[0] }}</span>
                            @if($phone[1])<img src="/css/img/telegram-icon.png" class="messenger-icon">@endif
                            @if($phone[2])<img src="/css/img/viber-icon.png" class="messenger-icon">@endif
                            @if($phone[3])<img src="/css/img/whatsapp-icon.png" class="messenger-icon">@endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <span class="font-weight-bold pr-2">Адрес:</span> {{ $item->address??'Не указан' }}
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="pb-2">
                <span class="font-weight-bold pr-2">Паспорт:</span>{{ $item->passport??'Не указан' }}
            </div>
            <div class="pb-2">
                <span class="font-weight-bold pr-2">ИНН:</span>{{ $item->itin??'Не указан' }}
            </div>
            <div class="pb-2">
                <span class="font-weight-bold pr-2">Должность:</span>{{ $item->role }}
            </div>
            <div class="pb-2">
                <span class="font-weight-bold pr-2">Принят:</span>{{ Date::parse($item->hired)->tz(config('custom.tz'))->format('j F Y') }}
            </div>
            @if ($item->fired_date)
                <div class="pb-2">
                    <span class="font-weight-bold pr-2">Уволен:</span>{{ Date::parse($item->fired)->tz(config('custom.tz'))->format('j F Y') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-between text-center">
        <div class="col-12 col-md-6">
            <span class="font-weight-bold pr-2">Квалификация:</span>
            <p class="text-left desc">{{ $item->qualification??'Не указана' }}</p>
        </div>  
        <div class="col-12 col-md-6">
            <span class="font-weight-bold pr-2">Комментарий:</span>
            <p class="text-left desc">{{ $item->comment??'Не указан' }}</p>
        </div>  
    </div>
    <div class="row justify-content-end w-75 mx-auto my-2">
        <button class="btn btn-warning btn-sm mr-2" data-toggle="modal" data-target="#updatePassword" onclick="event.preventDefault();">
            <i class="fas fa-key" aria-hidden="true"></i>
            <span class="">Изменить пароль</span>
        </button>
        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUser" onclick="event.preventDefault();">
            <i class="fas fa-trash" aria-hidden="true"></i>
            <span class="">Удалить</span>
        </button>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="deleteUser">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Вы действительно хотите удалить сотрудника?</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('users.destroy', $item->id)}}">
            @csrf
            @method('delete')
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Удалить</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="updatePassword">
    <div class="modal-dialog modal-dialog-centered modal-dialog-cutom w-90" role="document">
        <div class="modal-content mx-3 border rounded border-primary">
            <div class="modal-header">
                <h5 class="modal-title">Изменить пароль</h5>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update-password-form" method="POST" action="{{ route('users.password.update', $item->id)}}">
            @csrf
            <div class="container">
                <div id="update-password" class="row justify-content-between my-2">
                    <div id="upd-password" class="col-12 col-sm-6">
                        <label for="password" class="m-fa-icon mb-2">Пароль</label>
                        <input aria-label="Пароль"
                            class="form-control {{ $errors->has('password')?'is-invalid':'' }}"
                            id="password" type="password" name="password" placeholder="Пароль"
                        >
                        <div class="d-none"><small class="text-danger"></small></div>
                    </div>
                    <div id="upd-password_confirmation" class="col-12 col-sm-6 mb-2">
                        <label for="password_confirmation" class="m-fa-icon mb-2">Подтверждение пароля</label>
                        <input aria-label="Подтверждение пароля" 
                            class="form-control {{ $errors->has('password_confirmation')?'is-invalid':'' }}" 
                            id="password_confirmation" type="password" name="password_confirmation" placeholder="Подтверждение пароля"
                        >
                        <div class="d-none"><small class="text-danger"></small></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="update-password-button" type="button" class="btn btn-primary">Изменить</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection