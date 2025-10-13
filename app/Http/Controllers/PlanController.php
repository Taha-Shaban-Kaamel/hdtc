<?php

namespace App\Http\Controllers;

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

    public function index()
    {
        $this->authorize('view', Plan::class);
        $plans = $this->service->getAllPlans();
        return view('subscription.plans.index', compact('plans'));
    }

    public function create()
    {
        $this->authorize('create', Plan::class);
        return view('subscription.plans.create');
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
        ]);

        if ($request->filled('features')) {
            $validated['features'] = preg_split('/\r\n|\r|\n/', $request->features);
        }

        $this->service->createPlan($validated);


        return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
    }

    public function edit($id)
    {
        $this->authorize('update', Plan::class);
        $plan = $this->service->getPlanById($id);

        return view('subscription.plans.edit', compact('plan'));
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

        return redirect()->route('plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy($id)
    {
        $this->authorize('delete', Plan::class);
        $this->service->deletePlan($id);
        return redirect()->route('plans.index')->with('success', 'Plan deleted successfully.');
    }

    public function show($id)
    {
        $this->authorize('view', Plan::class);
        $plan = $this->service->getPlanById($id);
        return view('subscription.plans.show', compact('plan'));
    }
}
