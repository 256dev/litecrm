@extends('layouts.pdf')

@section('content')
    <div class="number-info">
        <div class="number-title">
            Акт выполненных работ №{{ $order->number }} от {{ Date::now()->tz(config('custom.tz'))->format('j F Y') }}
        </div>
    </div>

    @include('main.pdf.infoTable')
    
    <div class="wrap">
        <label class="title">
            Согласованная цена: 
        </label>
        {{ $order->agreed_price }} {{ Session::get('currency') }}
    </div>
    <div class="wrap">
        <label class="title">
            Предоплата: 
        </label>
        {{ $order->prepayment }} {{ Session::get('currency') }}
    </div>
    @if ($services->count())
    <div class="service wrap">
        <label class="title">
            Выполненные работы:
        </label>
        <div class="services-list">
            @foreach($services as $service)
                {{ $service->name }} - {{ $service->quantity }} x {{ $service->price }} {{ Session::get('currency') }}
                <br>
            @endforeach
            Итого - {{ $order->price_work }} {{ Session::get('currency') }}
        </div>
    </div>
    @endif
    @if ($repairParts->count())
    <div class="service wrap">
        <label class="title">
            Материалы
        </label>
        <div class="services-list">
            @foreach($repairParts as $repairPart)
                {{ $repairPart->name }} - {{ $repairPart->quantity }} x {{ $repairPart->price }} {{ Session::get('currency') }} {{ $repairPart->selfpart? '(Клиента)':'' }}
                <br>
            @endforeach
            Итого - {{ $order->price_repair_parts }} {{ Session::get('currency') }}
        </div>
    </div>
    @endif
    <div class="mb wrap">
        <span class="total-price">Итоговая стоимость ремонта: {{ $order->total_price}} {{ Session::get('currency') }}</span>
    </div>
    <div class="signature">
        Исполнитель<span style="margin-left: 20px">____________________________________</span><span style="margin-left: 30px">________________________________</span><span style="margin-left: 30px">________________
    </div>
    <div class="mb">
        <span style="margin-left: 230px">ФИО</span><span style="margin-left: 200px">Дата</span><span style="margin-left: 135px">Подпись</span>
    </div>
    <div style="margin-left: 0.75rem;">
        Работа выполнена полностью и в срок, к качеству претензий не имею
    </div>
    <div class="signature">
        Клиент<span style="margin-left: 70px">____________________________________</span><span style="margin-left: 30px">________________________________</span><span style="margin-left: 30px">________________
    </div>
    <div>
        <span style="margin-left: 230px">ФИО</span><span style="margin-left: 200px">Дата</span><span style="margin-left: 135px">Подпись</span>
    </div>
@endsection