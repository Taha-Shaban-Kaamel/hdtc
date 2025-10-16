<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CoursesReportExport implements FromCollection, WithHeadings, WithMapping
{
   
    public function collection()
    {
        return Course::withCount('plans')
            ->withSum('lectures', 'lecture_views')
            ->with(['instructors', 'chapters', 'lectures'])
            ->orderByDesc('lectures_sum_lecture_views')
            ->get();
    }

   
    public function map($course): array
    {
        return [
            is_array($course->name)
                ? ($course->name[app()->getLocale()] ?? reset($course->name))
                : $course->name,

            optional($course->instructors->first())->name ?? __('reports.no_data'),

            $course->plans_count ?? 0,

            $course->chapters->count() ?? 0,

            $course->lectures->count() ?? 0,

            $course->lectures_sum_lecture_views ?? 0,

            $course->price ? number_format($course->price, 2) . ' EGP' : __('common.free'),
        ];
    }

   
    public function headings(): array
    {
        return [
            __('reports.course'),
            __('reports.instructor'),
            __('reports.plans_reports'),
            __('reports.chapters'),
            __('reports.lectures'),
            __('reports.views'),
            __('reports.price'),
        ];
    }
}
