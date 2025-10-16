<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ __('reports.courses_reports') }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; direction: rtl; text-align: center; margin: 20px; }
        h1 { color: #1a237e; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; font-size: 13px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
<h1>{{ __('reports.courses_reports') }}</h1>
<p>{{ __('reports.courses_reports_description') }}</p>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>{{ __('reports.course') }}</th>
        <th>{{ __('reports.instructor') }}</th>
        <th>{{ __('reports.plans_reports') }}</th>
        <th>{{ __('reports.chapters') }}</th>
        <th>{{ __('reports.lectures') }}</th>
        <th>{{ __('reports.views') }}</th>
        <th>{{ __('reports.price') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($courses as $course)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $course->name }}</td>
            <td>{{ optional($course->instructors->first())->name ?? '-' }}</td>
            <td>{{ $course->plans_count ?? 0 }}</td>
            <td>{{ $course->chapters->count() ?? 0 }}</td>
            <td>{{ $course->lectures()->count() ?? 0 }}</td>
            <td>{{ number_format($course->lectures_sum_lecture_views ?? 0) }}</td>
            <td>{{ $course->price ? number_format($course->price, 2).' EGP' : __('common.free') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
