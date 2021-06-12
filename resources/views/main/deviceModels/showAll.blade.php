@extends('layouts.app')

@section('title')
    <title>Список  моделей устройств</title>  
@endsection

@section('content')
    @include('layouts.headAlertBlock')
    @include('layouts.topTableBar', [
        'title'  => 'Список моделей устройств',
        'route'  => 'devicemodels.create',
        'buttom' => 'Добавить модель',
        'type'   => 'devicemodels',
        'create' => Auth::user()->can('create', App\Models\Order::class) ? 1 : 0,
    ])
    <div class="container py-2">
        <div class="row justify-content-center">
            <table class="table table-striped shadow table-responsive-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="align-middle text-center py-1">
                            Модель
                        </th>
                        <th scope="col" class="align-middle text-center py-1">
                            Тип устройства
                        </th>
                        <th scope="col" class="align-middle text-center py-1">
                            Бренд
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr onclick="window.location.href='{{ route('devicemodels.show', $item)}}';">
                            <td scope="row" class="align-middle text-center">
                                {{ $item->name }}
                            </td>
                            <td scope="row" class="align-middle text-center">
                                {{ $item->typeDevice }}
                            </td>
                            <td scope="row" class="align-middle text-center">
                                {{ $item->manufacturer }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>  
@endsection