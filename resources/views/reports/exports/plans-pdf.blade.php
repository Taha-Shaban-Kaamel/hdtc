<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ __('reports.plans_reports') }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            direction: rtl;
            text-align: center;
            margin: 25px;
            color: #333;
        }
        h1 { color: #1a237e; margin-bottom: 10px; font-size: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 13px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
<h1>📦 {{ __('reports.plans_reports') }}</h1>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>{{ __('reports.plan') }}</th>
        <th>{{ __('reports.subscriptions_count') }}</th>
        <th>{{ __('reports.payments_count') }}</th>
        <th>{{ __('reports.revenue') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($plans as $plan)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $plan->name }}</td>
            <td>{{ $plan->subscriptions_count ?? 0 }}</td>
            <td>{{ $plan->payments_count ?? 0 }}</td>
            <td>{{ number_format($plan->payments->where('status', 'paid')->sum('amount'), 2) }} EGP</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
