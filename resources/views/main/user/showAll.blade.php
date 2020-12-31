@extends('layouts.app')

@section('title')
    <title>Список сотрудников</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.topTableBar', [
        'title'  => 'Список сотрудников',
        'route'  => 'users.create',
        'buttom' => 'Добавить сотрудника',
        'type'   => 'users',
    ])
    <div class="container py-2">
        <div class="row justify-content-center">
            <table class="table table-striped shadow table-responsive-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="align-middle text-center py-1">
                            Имя
                        </th>
                        <th scope="col" class="align-middle text-center py-1">
                            Почта
                        </th>
                        <th scope="col" class="align-middle text-center py-1">
                            Телефоны
                        </th>
                        <th scope="col" class="align-middle text-center py-1">
                            Должность
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr class="pointer {{ $item->deleted?'bg-danger':'' }}" onclick="window.location.href='{{ route('users.show', $item->id)}}';">
                            <td scope="row" class="align-middle text-center">
                                {{ $item->name }}
                            </td>
                            <td scope="row" class="align-middle text-center">
                                {{ $item->email }}
                            </td>
                            <td scope="row" class="align-middle text-center">
                                @foreach (json_decode($item->phones) as $phone)
                                <div class="text-left">
                                    <span class="align-middle">{{ $phone[0] }}</span>
                                    @if($phone[1])<img src="/css/img/telegram-icon.png" class="messenger-icon">@endif
                                    @if($phone[2])<img src="/css/img/viber-icon.png" class="messenger-icon">@endif
                                    @if($phone[3])<img src="/css/img/whatsapp-icon.png" class="messenger-icon">@endif
                                </div>
                            @endforeach
                            </td>
                            <td scope="row" class="align-middle text-center">
                                {{ $item->role }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>  
@endsection