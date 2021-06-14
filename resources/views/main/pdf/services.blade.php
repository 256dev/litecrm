<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Услуги</title>
</head>
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
    }

    .header {
        width: 100%;
    }

    .header-title {
        font-weight: bold;
        text-decoration: underline;
    }

    .number-info {
        width: 100%;
        height: 60px;
        border-top: 1px solid black;
        margin-top: 10px;
    }

    .number-title {
        font-weight: bold;
        margin-top: 20px;
        margin-left: 40px;
    }

    .number-order-barcode {
        margin-left: 470px;
        margin-top: -20px;
    }

    .info {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }

    th, td {
        padding: 0.2rem 0.5rem;
        border: 1px solid black;
    }

    .title {
        font-weight: bold;
    }

    .wrap {
        margin: 0 0 0.65rem 0.65rem;
    }
    
    .descr {
        width: 100%;
        padding-left: 0.75rem;
        min-height: 50px;
        white-space: pre-wrap;
    }

    .service {
        margin-bottom: 10px;
    }

    .services-list {
        margin-top: 5px;
        margin-left: 50px;
        font-style: italic;
    }

    .total-price {
        font-weight: bold;
        font-style: italic;
        text-decoration: underline;
    }

    .mb {
        margin-bottom: 20px;
    }
    .signature {
        width: 100%;
        margin-top: 20px;
        font-weight: bold;
        margin-left: 0.75rem;
    }
</style>
<body>
    <div class="header">
        <div class="header-title">
            {{ $settings->name }} {{ $settings->legal_name? "($settings->legal_name)":'' }}
        </div>
        <div class="header-desc">
            Адрес: {{ $settings->address }}, 
            тел.: 
            @foreach($settings->phones as $phone)
                <span class="align-middle">{{ $phone[0] }}</span>
            @endforeach
            <br>
            email: {{ $settings->email }}
        </div>
    </div>
    <center>
        <h3>
            Отчет по предоставленным услугам
        </h3>
    </center>
    <table>
        <thead>
            <tr>
                <th>Наименование</th>
                <th>Цена за единицу</th>
                <th>Общее количество</th>
                <th>Продано на сумму</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
                <tr>
                    <td>{{ $service->first()->typeService->name }}</td>
                    <td>{{ round($service->first()->price / $service->first()->quantity, 2) }}</td>
                    <td>{{ $service->count('quantity') }} ({{ round($service->count('quantity') * 100.0 / $count_services, 2)  }}%)</td>
                    <td>{{ $service->sum('price') }}</td>
                </tr>
            @endforeach
                <tr>
                    <th>Итого</th>
                    <td></td>
                    <td>{{ $count_services }}</td>
                    <td>{{ $sum_services }}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>