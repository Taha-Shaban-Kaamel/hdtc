<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Payment::with(['user', 'plan'])
            ->where('status', 'paid')
            ->orderByDesc('created_at')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'User',
            'Plan',
            'Amount (EGP)',
            'Currency',
            'Status',
            'Transaction ID',
            'Date',
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->id,
            $payment->user->name ?? '-',
            $payment->plan->name ?? '-',
            number_format($payment->amount, 2),
            $payment->currency,
            ucfirst($payment->status),
            $payment->transaction_id,
            $payment->created_at->format('Y-m-d H:i'),
        ];
    }
}
