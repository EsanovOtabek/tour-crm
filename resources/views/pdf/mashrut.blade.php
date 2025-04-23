<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <title>Маршрутный лист</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        .header { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="header">Маршрутный лист</div>
<p><strong>Booking ID:</strong> {{ $booking->id }}</p>
<p><strong>Сопровождающий:</strong> {{ $booking->guide_name ?? 'Nomaʼlum' }}</p>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Shahar</th>
        <th>Sana & Vaqt</th>
        <th>Dastur</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mashruts as $mashrut)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $mashrut->tourCity->name }}</td>
            <td>{{ $mashrut->date_time->format('d.m.Y H:i') }}</td>
            <td>{{ $mashrut->program }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<br><br>
<p style="text-align: right;">С уважением,<br>Менеджер ООО "Maftun Turizm"</p>
</body>
</html>
