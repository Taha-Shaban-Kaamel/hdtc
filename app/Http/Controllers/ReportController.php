<?php

namespace App\Http\Controllers;

use App\Exports\CoursesReportExport;
use App\Exports\GeneralReportExport;
use App\Exports\InstructorsReportExport;
use App\Exports\PlansReportExport;
use App\Exports\SubscriptionsReportExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use App\Models\{User, Plan, Course, Payment, Subscription, Instructor};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = Carbon::parse($request->input('from', Carbon::now()->subMonth()->toDateString()))->startOfDay();
        $to = Carbon::parse($request->input('to', Carbon::now()->toDateString()))->endOfDay();

        $planId = $request->input('plan_id');
        $courseId = $request->input('course_id');

        $paymentsQuery = Payment::with(['user', 'plan'])
            ->whereBetween('created_at', [$from, $to]);
        $subscriptionsQuery = Subscription::whereBetween('created_at', [$from, $to]);

        if ($planId) {
            $paymentsQuery->where('plan_id', $planId);
            $subscriptionsQuery->where('plan_id', $planId);
        }

        if ($courseId) {
            $planIds = DB::table('course_plan')
                ->where('course_id', $courseId)
                ->pluck('plan_id');
            $paymentsQuery->whereIn('plan_id', $planIds);
            $subscriptionsQuery->whereIn('plan_id', $planIds);
        }

        $totalRevenue = (clone $paymentsQuery)->where('status', 'paid')->sum('amount');
        $totalPayments = (clone $paymentsQuery)->count();
        $totalSubscriptions = (clone $subscriptionsQuery)->count();

        $payments = $paymentsQuery
            ->orderByDesc('created_at')
            ->paginate(10);

        $stats = [
            'total_users' => User::count(),
            'active_users' => User::whereHas('subscriptions')->count(),
            'total_instructors' => Instructor::count(),
            'total_courses' => Course::count(),
            'total_plans' => Plan::count(),
            'total_revenue' => $totalRevenue,
            'total_payments' => $totalPayments,
            'total_subscriptions' => $totalSubscriptions,
        ];

        $dailyRevenue = Payment::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->where('status', 'paid')
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $subscriptionsByPlan = Subscription::selectRaw('plan_id, COUNT(*) as total')
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('plan_id')
            ->with('plan:id,name')
            ->get();

        $topCourses = Course::withCount('plans')
            ->orderByDesc('plans_count')
            ->take(5)
            ->get();

        return view('reports.index', compact(
            'stats',
            'payments',
            'dailyRevenue',
            'subscriptionsByPlan',
            'topCourses',
            'from',
            'to',
            'planId',
            'courseId'
        ));
    }

    public function courses()
    {
        $courses = Course::withCount('plans')
            ->withSum('lectures', 'lecture_views')
            ->orderByDesc('lectures_sum_lecture_views')
            ->paginate(10);


        return view('reports.courses', compact('courses'));
    }

    public function instructors()
    {
        $instructors = Instructor::with([
            'user:id,first_name,second_name',
            'courses' => fn($q) => $q->withCount('plans')
        ])
            ->withCount('courses')
            ->paginate(10);


        return view('reports.instructors', compact('instructors'));
    }

    public function subscriptions()
    {
        $subscriptions = Subscription::with(['plan', 'user'])->paginate(10);

        $summary = [
            'active' => Subscription::where('end_date', '>', now())->count(),
            'expired' => Subscription::where('end_date', '<', now())->count(),
            'upcoming' => Subscription::where('start_date', '>', now())->count(),
        ];

        return view('reports.subscriptions', compact('subscriptions', 'summary'));
    }

    public function plans()
    {
        $plans = Plan::withCount(['subscriptions', 'payments'])->paginate(10);

        return view('reports.plans', compact('plans'));
    }

    public function exportGeneralExcel()
    {
        return Excel::download(new GeneralReportExport, 'general_report.xlsx');
    }


    /**
     * @throws MpdfException
     */
    public function exportGeneralPdf()
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'active_users' => \App\Models\User::whereHas('subscriptions')->count(),
            'total_instructors' => \App\Models\Instructor::count(),
            'total_courses' => \App\Models\Course::count(),
            'total_plans' => \App\Models\Plan::count(),
            'total_subscriptions' => \App\Models\Subscription::count(),
            'total_payments' => \App\Models\Payment::count(),
            'total_revenue' => \App\Models\Payment::where('status', 'paid')->sum('amount'),
        ];

        $html = view('reports.exports.general-pdf', compact('stats'))->render();

        $mpdf = new Mpdf([
            'default_font' => 'dejavusans',
            'mode' => 'utf-8',
            'format' => 'A4',
            'directionality' => 'rtl',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
        ]);

        $mpdf->SetTitle('📊 التقرير العام للنظام');
        $mpdf->WriteHTML($html);
        return $mpdf->Output('general_report.pdf', 'D');
    }
    public function exportCoursesExcel()
    {
        return Excel::download(new CoursesReportExport, 'courses_report.xlsx');
    }

    public function exportCoursesPdf()
    {
        $courses = Course::withCount('plans')
            ->withSum('lectures', 'lecture_views')
            ->orderByDesc('lectures_sum_lecture_views')
            ->get();

        $pdf = Pdf::loadView('reports.exports.courses-pdf', compact('courses'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('courses_report.pdf');
    }

    public function exportInstructorsExcel()
    {
        $instructors = \App\Models\Instructor::with([
            'user:id,first_name,second_name',
            'courses' => function ($q) {
                $q->withCount('plans');
            }
        ])
            ->withCount('courses')
            ->get();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\InstructorsReportExport($instructors),
            'instructors_report.xlsx'
        );
    }


    public function exportInstructorsPdf()
    {
        $instructors = \App\Models\Instructor::with([
            'user:id,first_name',
            'courses' => function ($q) {
                $q->withCount('plans');
            }
        ])
            ->withCount('courses')
            ->get();
        $pdf = Pdf::loadView('reports.exports.instructors-pdf', compact('instructors'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('instructors_report.pdf');
    }

    public function exportSubscriptionsExcel()
    {
        return Excel::download(new SubscriptionsReportExport, 'subscriptions_report.xlsx');
    }

    public function exportSubscriptionsPdf()
    {
        $subscriptions = Subscription::with(['plan', 'user'])->get();

        $pdf = Pdf::loadView('reports.exports.subscriptions-pdf', compact('subscriptions'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('subscriptions_report.pdf');
    }

    public function exportPlansExcel()
    {
        return Excel::download(new PlansReportExport, 'plans_report.xlsx');
    }

    public function exportPlansPdf()
    {
        $plans = \App\Models\Plan::withCount(['subscriptions', 'payments'])->with('payments')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.exports.plans-pdf', compact('plans'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('plans_report.pdf');
    }

}
