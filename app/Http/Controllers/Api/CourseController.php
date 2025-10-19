<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CoursePreviewResource;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index(Request $request)
    {
        $query = Course::with(['instructors', 'categories'])
            ->where('status', 'active')
            ->where('show_index', 1);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('difficulty_level')) {
            $query->where('difficulty_level', $request->difficulty_level);
        }

        if ($request->has('is_free')) {
            if ($request->boolean('is_free')) {
                $query->where('price', 0);
            } else {
                $query->where('price', '>', 0);
            }
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('course_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        if ($sortBy === 'popularity') {
            $query
                ->withCount('enrollments')
                ->orderBy('enrollments_count', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $perPage = $request->get('per_page', 15);
        $courses = $query->get();

        return response()->json([
            'status' => true,
            'message' => 'Courses found',
            'data' => CourseResource::collection($courses),
            'count' => $courses->count()
        ], 200);
    }

    public function syllabus($id)
    {
        $course = Course::with(['lectures' => function ($query) {
            $query
                ->where('status', 'active')
                ->orderBy('order');
        }])->findOrFail($id);

        $user = auth('sanctum')->user();

        $lessons = $course->lectures->map(function ($lesson) use ($course, $user) {
            $isAccessible = $lesson->isAccessibleBy($user);

            return [
                'id' => $lesson->id,
                'title' => $lesson->title,
                'description' => $lesson->description,
                'objectives' => $lesson->objectives,
                'order' => $lesson->order,
                'is_accessible' => $isAccessible,
                'is_locked' => !$isAccessible,
            ];
        });

        return response()->json([
            'course_id' => $course->course_id,
            'course_name' => $course->course_name,
            'total_lessons' => $lessons->count(),
            'total_duration' => $lessons->sum('duration_minutes'),
            'preview_lessons_count' => $course->preview_lessons_count,
            'lessons' => $lessons,
        ]);
    }

    public function show($id)
    {
        try {
            $course = new CourseResource(Course::find($id)->load('categories', 'instructors', 'chapters'));
            $course_preview = Course::find($id)->getPreviewContent();
            return response()->json([
                'status' => true,
                'message' => 'Course found',
                'data' => $course,
                'preview' => $course_preview,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Course not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
