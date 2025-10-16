<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Plan;
use App\Services\PlanService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    protected $service;

    public function __construct(PlanService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $this->authorize('view', Plan::class);
        $perPage = $request->get('per_page', 10);
        $plans = $this->service->getAllPlans($perPage);
        return view('subscription.plans.index', compact('plans'));
    }

    public function create()
    {
        $this->authorize('create', Plan::class);
        $courses =Course::all(['id', 'name']);
        return view('subscription.plans.create', compact('courses'));
    }


    public function store(Request $request)
    {
        $this->authorize('create', Plan::class);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_monthly' => 'required|numeric|min:0',
            'price_yearly' => 'required|numeric|min:0',
            'yearly_discount_percent' => 'nullable|integer|min:0|max:100',
            'max_users' => 'nullable|integer|min:0',
            'max_courses' => 'nullable|integer|min:0',
            'features' => 'nullable',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',

        ]);

        if ($request->filled('features')) {
            $validated['features'] = preg_split('/\r\n|\r|\n/', $request->features);
        }

        $plan = $this->service->createPlan($validated);

        if ($request->filled('courses')) {
            $plan->courses()->sync($request->courses);
        }

        return redirect()->route('plans.index')->with('success', 'Plan created successfully.');


        return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
    }

    public function edit($id)
    {
        $this->authorize('update', Plan::class);
        $plan = $this->service->getPlanById($id);
        $courses = Course::all(['id', 'name']);
        $selectedCourses = $plan->courses->pluck('id')->toArray();

        return view('subscription.plans.edit', compact('plan', 'courses', 'selectedCourses'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'yearly_discount_percent' => 'nullable|integer|min:0|max:100',
            'price_monthly' => 'required|numeric|min:0',
            'price_yearly' => 'required|numeric|min:0',
        ]);
        if ($request->filled('features')) {
            $validated['features'] = preg_split('/\r\n|\r|\n/', $request->features);
        }

        $this->service->updatePlan($id, $validated);
        $plan = Plan::findOrFail($id);
        if ($request->filled('courses')) {
            $plan->courses()->sync($request->courses);
        } else {
            $plan->courses()->detach();
        }


        return redirect()->route('plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy($id)
    {
        $plan = Plan::withCount('payments')->findOrFail($id);

        if ($plan->payments_count > 0) {
            return redirect()->back()->withErrors('لا يمكن حذف هذه الخطة لأنها مرتبطة بعمليات دفع.');
        }

        $plan->delete();
        return redirect()->route('plans.index')->with('success', 'تم حذف الخطة بنجاح');
    }


    public function show($id)
    {
        $this->authorize('view', Plan::class);
        $plan = $this->service->getPlanById($id);
        return view('subscription.plans.show', compact('plan'));
    }
}
