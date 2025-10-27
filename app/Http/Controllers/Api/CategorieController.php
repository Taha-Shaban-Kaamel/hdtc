<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseCategorie;
use App\Models\Course;
use App\Http\Resources\CategorieResrource;
use App\Http\Resources\CourseResource;

class CategorieController extends Controller
{
    public function index()
    {
        try {
            $categories = CategorieResrource::collection(CourseCategorie::all());
            return response()->json([
                'status' => true,
                'message' => 'Categories found',
                'data' => $categories,
                'count' => $categories->count()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Categories not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function show($id)
    {
        try {
            $category = new CategorieResrource(CourseCategorie::find($id));
            return response()->json([
                'status' => true,
                'message' => 'Category found',
                'data' => $category,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Category not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function courses($id)
    {
        try {
            $categorie = CourseCategorie::find($id);
            $courses = $categorie->courses()->with('categories','instructors','tags','chapters','enrollments')->get();
            if(!$categorie){
                return response()->json([
                    'message' => 'Category not found',
                    'error' => 'Category not found'
                ], 404);
            }
            if ($categorie->courses()->count() == 0) {
                return response()->json([
                    'message' => 'Courses not found',
                    'error' => 'Courses not found'
                ], 404);
            };

            return response()->json([
                'status' => true,
                'message' => 'Courses found',
                'data' => CourseResource::collection($courses),
                'count' => $courses->count()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Courses not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
