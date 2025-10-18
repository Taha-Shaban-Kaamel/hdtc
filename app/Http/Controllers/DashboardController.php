<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\CourseCategorie;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $instructors = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'instructor')->toArray()
        )->count();

        $stats = [
            'total_courses' => Course::count(),
            'total_instructors' => $instructors,
            'total_enrollments' => Enrollment::count(),
        ];

        $coursesByCategory = CourseCategorie::withCount('courses')->get();

        $monthlyEnrollments = Enrollment::select(
            DB::raw('count(*) as count'),
            DB::raw("DATE_FORMAT(created_at, '%b %Y') as month")
        )
            ->groupBy('month')
            ->orderBy('created_at', 'asc')
            ->limit(12)
            ->get();

        $topInstructors = User::role('instructor')
            ->withCount('courses')
            ->orderBy('courses_count', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'stats',
            'coursesByCategory',
            'monthlyEnrollments',
            'topInstructors'
        ));
    }
}
