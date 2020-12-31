@extends('layouts.app')

@section('title')
    @if (isset($edit))
        <title>Редактирование клиента {{ $customer->name }}</title>
    @else
        <title>Добавление клиента</title>
    @endif
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.headTitleBlock', [
        'title'  => isset($edit)? 'Редактирование клиента' : 'Добавление клиента',
        'route'  => 'customers.index',
        'button' => 'Все клиенты'
    ])
    <div class="container pt-3">
        @if (!isset($edit))
            <form action="{{ route('customers.store')}}" method="POST">
        @else
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @method('put')
        @endif
        @csrf
        <div class="row justify-content-between border rounded border-primary shadow">
            
            @include('main.customer.addForm')
        
        </div>
        <div class="row justify-content-center mt-4">
            <div class="form-group has-icon ">
                <button type="submit" class="btn btn-success">
                    @if (!isset($edit))
                        <i class="fas fa-plus pr-2"></i>
                        Добавить клиента
                    @else
                        Сохранить
                    @endif
                </button>
            </div>
        </div>    
        </form>
    </div>        
@endsection