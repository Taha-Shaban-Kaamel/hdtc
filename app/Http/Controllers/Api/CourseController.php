<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\CourseResource;

class CourseController extends Controller
{
    public function index()
    {
        try {
            $courses = CourseResource::collection(Course::all());
            return response()->json([
                'status' => true,
                'message' => 'Courses found',
                'data' => $courses,
                'count' => $courses->count()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Courses not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function show($id)
    {
        try {
            $course = new CourseResource(Course::find($id));
            return response()->json([
                'status' => true,
                'message' => 'Course found',
                'data' => $course,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Course not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
