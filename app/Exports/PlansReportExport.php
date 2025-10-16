<?php

namespace App\Exports;

use App\Models\Plan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PlansReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Plan::withCount(['subscriptions', 'payments'])
            ->with('payments')
            ->get();
    }

   
    public function map($plan): array
    {
        return [
            $plan->name,
            $plan->subscriptions_count ?? 0,
            $plan->payments_count ?? 0,
            number_format($plan->payments->where('status', 'paid')->sum('amount'), 2) . ' EGP',
        ];
    }

   
    public function headings(): array
    {
        return [
            __('reports.plan'),
            __('reports.subscriptions_count'),
            __('reports.payments_count'),
            __('reports.revenue'),
        ];
    }
}
