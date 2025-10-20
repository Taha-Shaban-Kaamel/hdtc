<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\CourseCategorie;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $instructors = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'instructor')->toArray()
        )->count();

        $studentRole = Role::where('name', 'student')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $superAdminRole = Role::where('name', 'super admin')->first();

        $totalStudents = $studentRole ? User::role('student')->count() : 0;
        $totalAdmins = ($adminRole ? User::role('admin')->count() : 0) + 
                       ($superAdminRole ? User::role('super admin')->count() : 0);

        $stats = [
            'total_courses' => Course::count(),
            'total_instructors' => $instructors,
            'total_enrollments' => Enrollment::count(),
            'total_students' => $totalStudents,
            'total_admins' => $totalAdmins,
            'total_subscriptions' => Subscription::count(),
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

        $instructorRole = Role::where('name', 'instructor')->first();
        $topInstructors = $instructorRole 
            ? User::role('instructor')
                ->withCount('courses')
                ->orderBy('courses_count', 'desc')
                ->limit(5)
                ->get()
            : collect();

        return view('dashboard', compact(
            'stats',
            'coursesByCategory',
            'monthlyEnrollments',
            'topInstructors'
        ));
    }
}
