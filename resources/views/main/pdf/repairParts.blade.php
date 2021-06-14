<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Используемые запчасти</title>
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

    <table>
        <thead>
            <tr>
                <th>Наименование</th>
                <th>Количество</th>
                <th>Продано</th>
                <th>Продано на сумму</th>
                <th>Описание</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($repairParts as $part)
                <tr>
                    <td>{{ $part->name }}</td>
                    <td>{{ $part->quantity }}</td>
                    <td>{{ $part->sales }} ({{ round($part->sales * 100.0 / ($part->quantity + $part->sales), 1)  }}%)</td>
                    <td>{{ round($part->price * $part->sales, 2) }}</td>
                    <td>{{ $part->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>