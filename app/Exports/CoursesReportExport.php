<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CoursesReportExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * ✅ استرجاع البيانات
     */
    public function collection()
    {
        return Course::withCount('plans')
            ->withSum('lectures', 'lecture_views')
            ->with(['instructors', 'chapters', 'lectures'])
            ->orderByDesc('lectures_sum_lecture_views')
            ->get();
    }

    /**
     * ✅ خريطة الأعمدة (الصفوف)
     */
    public function map($course): array
    {
        return [
            // اسم الكورس بلغة الواجهة
            is_array($course->name)
                ? ($course->name[app()->getLocale()] ?? reset($course->name))
                : $course->name,

            // اسم المدرب الأول (إن وُجد)
            optional($course->instructors->first())->name ?? __('reports.no_data'),

            // عدد الخطط المرتبطة بالكورس
            $course->plans_count ?? 0,

            // عدد الفصول
            $course->chapters->count() ?? 0,

            // عدد المحاضرات
            $course->lectures->count() ?? 0,

            // عدد المشاهدات
            $course->lectures_sum_lecture_views ?? 0,

            // السعر
            $course->price ? number_format($course->price, 2) . ' EGP' : __('common.free'),
        ];
    }

    /**
     * ✅ العناوين (تُترجم تلقائيًا)
     */
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
