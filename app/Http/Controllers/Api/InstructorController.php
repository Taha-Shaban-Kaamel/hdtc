<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstructorResource;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;

class InstructorController extends Controller
{
    public function index()
    {
        try {
            $instructors = InstructorResource::collection(Instructor::all()->load('courses')) ;
            return response()->json([
                'status' => true,
                'message' => 'Instructors found',
                'data' => $instructors,
                'count' => $instructors->count()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Instructors not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function show(string $id)
    {
        try {
            $instructor = new InstructorResource(Instructor::find($id)->load('courses')) ;
            return response()->json([
                'status' => true,
                'message' => 'Instructor found',
                'data' => $instructor,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Instructor not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }


    public function courses($id){
        try {
            $instructor = Instructor::find($id);
            $courses = $instructor->courses()->with('categories','instructors','tags','chapters','enrollments')->get();
            if(!$instructor){
                return response()->json([
                    'message' => 'Instructor not found',
                    'error' => 'Instructor not found'
                ], 404);
            }
            if ($instructor->courses()->count() == 0) {
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
