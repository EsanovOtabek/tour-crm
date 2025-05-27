<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .header {
            background-color: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>{{ $subject }}</h1>
        <p>{{ $date->format('d.m.Y') }} sanasi uchun hisobot</p>
    </div>

    <p>Hurmatli {{ $agent->name }},</p>

    <p>{!! nl2br(e($baseMessage)) !!}</p>

    @if($bookings->isNotEmpty())
        <h2>Buyurtmalar ro'yxati</h2>

        <table>
            <thead>
            <tr>
                <th>Buyurtma kodi</th>
                <th>Tur nomi</th>
                <th>Guruh</th>
                <th>Git</th>
                <th>Hotel</th>
                <th>Shahar</th>
                <th>Muammo</th>
                <th>Yechim</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->unique_code }}</td>
                    <td>{{ $booking->tour->name ?? 'N/A' }}</td>
                    <td>{{ $booking->groupMembers->count() }} kishi</td>
                    <td>
                        @foreach($booking->guides as $guideBooking)
                            {{ $guideBooking->guide->name ?? 'N/A' }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($booking->details as $detail)
                            @if($detail->objectItem->partnerObject->partner->type->name === 'Hotels')
                                {{ $detail->objectItem->partnerObject->name ?? 'N/A' }}@if(!$loop->last), @endif
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($booking->details as $detail)
                            @if($detail->objectItem->partnerObject->partner->type->name === 'Hotels')
                                {{ $detail->objectItem->partnerObject->city->code ?? 'N/A' }}@if(!$loop->last), @endif
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($booking->dailyReports->where('created_at', '>=', $date->startOfDay())->where('created_at', '<=', $date->copy()->endOfDay()) as $report)
                            {{ $report->problem }}@if(!$loop->last)<br>@endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($booking->dailyReports->where('created_at', '>=', $date->startOfDay())->where('created_at', '<=', $date->copy()->endOfDay()) as $report)
                            {{ $report->solve }}@if(!$loop->last)<br>@endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Ushbu sana uchun buyurtmalar topilmadi.</p>
    @endif

    <div class="footer">
        <p>Bu xabar avtomatik tarzda yuborilgan. Iltimos, javob yozmang.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Barcha huquqlar himoyalangan.</p>
    </div>
</div>
</body>
</html>
