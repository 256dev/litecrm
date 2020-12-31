@extends('layouts.pdf')

@section('content')
    <div class="number-info">
        <div class="number-title">
            Квитанция №{{ $order->number }} от {{ Date::parse($order->date)->tz(config('custom.tz'))->format('j F Y') }}.
        </div>
        <div class="number-order-barcode">
            {!! $order_barcode !!}
        </div>
    </div>

    @include('main.pdf.infoTable')
    
    <div class="wrap">
        <label class="title">
            Причина обращения:
        </label>
        {{ $order->defects }}
    </div>
    <div class="wrap">
        <label class="title">
            Примечания:
        </label>
        {{ $order->comment }}
    </div>
    <div class="wrap">
        <label class="title">
            Условия ремонта
        </label>
        <span class="descr">
{{ $settings->repair_conditions}}
        </span>
    </div>
    <div class="signature">
        Принял<span style="margin-left: 70px">____________________________________</span><span style="margin-left: 30px">________________________________</span><span style="margin-left: 30px">________________
    </div>
    <div class="mb">
        <span style="margin-left: 230px">ФИО</span><span style="margin-left: 200px">Дата</span><span style="margin-left: 135px">Подпись</span>
    </div>
    <div class="signature">
        Клиент<span style="margin-left: 70px">____________________________________</span><span style="margin-left: 30px">________________________________</span><span style="margin-left: 30px">________________
    </div>
    <div>
        <span style="margin-left: 230px">ФИО</span><span style="margin-left: 200px">Дата</span><span style="margin-left: 135px">Подпись</span>
    </div>
@endsection