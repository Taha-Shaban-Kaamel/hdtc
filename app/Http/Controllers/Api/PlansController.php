<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\PlanService;
use Illuminate\Http\JsonResponse;

class PlansController extends Controller
{
    protected $service;

    public function __construct(PlanService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $plans = $this->service->getAllPlans();

        return response()->json([
            'status' => true,
            'message' => 'Plans retrieved successfully',
            'data' => $plans
        ], 200);
    }

    public function show($id): JsonResponse
    {
        $plan = $this->service->getPlanById($id);

        if (!$plan) {
            return response()->json([
                'status' => false,
                'message' => 'Plan not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Plan details',
            'data' => $plan
        ], 200);
    }
}
