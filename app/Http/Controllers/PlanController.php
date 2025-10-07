<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class PlanController extends Controller
{
    public function createPlan(Request $request)
    {



        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',  // اسم الخطة
            'description' => 'required|string',   // وصف الخطة
            'price_monthly' => 'required|numeric', // السعر الشهري
            'price_yearly' => 'required|numeric',  // السعر السنوي
            'yearly_discount_percent' => 'nullable|numeric|min:0|max:100', // ✅ نسبة الخصم السنوي

            'max_users' => 'nullable|integer',  // الحد الأقصى للمستخدمين
            'max_courses' => 'nullable|integer', // الحد الأقصى للدورات
            'features' => 'nullable|array',  // المميزات
        ]);

        try {
            // إنشاء الخطة
            $plan = Plan::create([
                'name' => $request->name,
                'description' => $request->description,
                'price_monthly' => $request->price_monthly,
                'price_yearly' => $request->price_yearly,
                'max_users' => $request->max_users,
                'yearly_discount_percent' => $request->yearly_discount_percent ?? 0, // ✅ تخزين الخصم أو 0 افتراضيًا

                'max_courses' => $request->max_courses,
                'features' => $request->features ? json_encode($request->features) : null,  // تخزين المميزات بتنسيق JSON
            ]);

            // إرجاع بيانات الخطة الجديدة
            return response()->json(['data' => $plan], 201);  // 201 تعني أنه تم إنشاؤها بنجاح
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);  // في حالة حدوث خطأ
        }
    }

    public function getPlans()
    {
        $plans = Plan::all();
        return response()->json(['data' => $plans], 200);
    }
}
