<?php

namespace App\Exports;

use App\Models\Subscription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubscriptionsReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Subscription::with(['user', 'plan'])->get();
    }

    public function map($subscription): array
    {
        return [
            $subscription->user->full_name ?? '-',
            $subscription->plan->name ?? '-',
            optional($subscription->start_date)->format('Y-m-d') ?? '-',
            optional($subscription->end_date)->format('Y-m-d') ?? '-',
            $subscription->end_date && $subscription->end_date->isFuture()
                ? __('reports.active')
                : ($subscription->start_date && $subscription->start_date->isFuture()
                ? __('reports.upcoming')
                : __('reports.expired')),
        ];
    }

    public function headings(): array
    {
        return [
            __('reports.user'),
            __('reports.plan'),
            __('reports.start_date'),
            __('reports.end_date'),
            __('reports.status'),
        ];
    }
}
