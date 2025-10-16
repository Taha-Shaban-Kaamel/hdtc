<?php

namespace App\Exports;

use App\Models\Instructor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\App;

class InstructorsReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $locale;

    public function __construct()
    {
        $this->locale = App::getLocale();
    }

    public function collection()
    {
        return Instructor::with([
            'user:id,first_name,second_name',
            'courses' => function ($q) {
                $q->withCount('plans');
            }
        ])
            ->withCount('courses')
            ->get();
    }

    public function map($instructor): array
    {
        return [
            // Instructor Name
            $instructor->user->full_name ?? '---',

            // Courses Count
            $instructor->courses_count ?? 0,

            $instructor->courses->sum('plans_count') ?? 0,

            // Status
            $instructor->is_active
                ? ($this->locale === 'ar' ? 'نشط' : 'Active')
                : ($this->locale === 'ar' ? 'غير نشط' : 'Inactive'),
        ];
    }

    public function headings(): array
    {
        if ($this->locale === 'ar') {
            return ['المدرب', 'عدد الدورات', 'عدد الخطط المرتبطة', 'الحالة'];
        }

        return ['Instructor', 'Courses Count', 'Linked Plans Count', 'Status'];
    }
}
