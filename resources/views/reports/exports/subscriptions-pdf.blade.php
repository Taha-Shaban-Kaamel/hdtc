<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ __('reports.subscriptions_reports') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            text-align: center;
            direction: rtl;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 13px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        th {
            background-color: #f3f3f3;
        }
        h1 {
            color: #1a237e;
        }
    </style>
</head>
<body>
<h1>💳 {{ __('reports.subscriptions_reports') }}</h1>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>{{ __('reports.user') }}</th>
        <th>{{ __('reports.plan') }}</th>
        <th>{{ __('reports.start_date') }}</th>
        <th>{{ __('reports.end_date') }}</th>
        <th>{{ __('reports.status') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($subscriptions as $subscription)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $subscription->user->full_name ?? '-' }}</td>
            <td>{{ $subscription->plan->name ?? '-' }}</td>
            <td>{{ optional($subscription->start_date)->format('Y-m-d') ?? '-' }}</td>
            <td>{{ optional($subscription->end_date)->format('Y-m-d') ?? '-' }}</td>
            <td>
                @if($subscription->end_date && $subscription->end_date->isFuture())
                    {{ __('reports.active') }}
                @elseif($subscription->start_date && $subscription->start_date->isFuture())
                    {{ __('reports.upcoming') }}
                @else
                    {{ __('reports.expired') }}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
