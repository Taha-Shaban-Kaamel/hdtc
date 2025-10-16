<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Plan;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GeneralReportExport implements FromCollection, WithHeadings
{
    /**
     * البيانات اللي هتتصدّر إلى ملف Excel
     */
    public function collection()
    {
        $stats = [
            [
                'Metric' => 'Total Users',
                'Value'  => User::count(),
            ],
            [
                'Metric' => 'Active Users',
                'Value'  => User::whereHas('subscriptions')->count(),
            ],
            [
                'Metric' => 'Total Instructors',
                'Value'  => Instructor::count(),
            ],
            [
                'Metric' => 'Total Courses',
                'Value'  => Course::count(),
            ],
            [
                'Metric' => 'Total Plans',
                'Value'  => Plan::count(),
            ],
            [
                'Metric' => 'Total Subscriptions',
                'Value'  => Subscription::count(),
            ],
            [
                'Metric' => 'Total Payments',
                'Value'  => Payment::count(),
            ],
            [
                'Metric' => 'Total Revenue (Paid)',
                'Value'  => Payment::where('status', 'paid')->sum('amount'),
            ],
        ];

        return new Collection($stats);
    }

    /**
     * عناوين الأعمدة في ملف Excel
     */
    public function headings(): array
    {
        return ['Metric', 'Value'];
    }
}
