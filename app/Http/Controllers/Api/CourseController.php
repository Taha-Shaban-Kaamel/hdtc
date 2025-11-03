<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CoursePreviewResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\EnrolledCourseResource;
use App\Http\Resources\LessonDetailResource;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lecture;
use App\Models\LectureProgress;
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

    public function syllabuss($id)
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

    public function lastAdded()
    {
        try {
            $courses = Course::with(['instructors', 'categories', 'chapters', 'tags'])
                ->where('status', 'active')
                ->where('show_index', 1)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            if ($courses->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No courses found',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => true,
                'message' => 'Courses found',
                'data' => CourseResource::collection($courses),
                'count' => $courses->count()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching courses',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function topRated()
    {
        try {
            $courses = Course::with(['instructors', 'categories', 'chapters', 'tags'])
                ->where('status', 'active')
                ->where('show_index', 1)
                ->orderBy('rating', 'desc')
                ->take(10)
                ->get();

            if ($courses->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No courses found',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => true,
                'message' => 'Courses found',
                'data' => CourseResource::collection($courses),
                'count' => $courses->count()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching courses',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function syllabus($id)
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

    public function show($id)
    {
        $user = auth('sanctum')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'have to be logged in',
            ], 401);
        };

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $id)
            ->with(['course.instructors', 'course.lectures'])
            ->firstOrFail();

        if ($enrollment->status == 'active') {
            $lectures = $enrollment->course->lectures->map(function ($lecture) use ($enrollment) {
                $progress = LectureProgress::where('enrollment_id', $enrollment->id)
                    ->where('lecture_id', $lecture->id)
                    ->first();
                return [
                    'id' => $lecture->id,
                    'title' => $lecture->title,
                    'description' => $lecture->description,
                    'objectives' => $lecture->objectives,
                    'order' => $lecture->order,
                    'is_completed' => $progress?->is_completed ?? false,
                    'progress_percentage' => $progress?->progress_percentage ?? 0,
                ];
            });
            $course = new EnrolledCourseResource($enrollment);
            return response()->json([
                'status' => true,
                'message' => 'Course found',
                'course' => $course,
                'lectures' => $lectures,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Course not found',
            ], 404);
        }
    }

    public function getLecture($course_id , $lecture_id){
        $user = auth('sanctum')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'have to be logged in',
            ], 401);
        };

        $enrollment = Enrollment::where('user_id', $user->id)->where('course_id', $course_id)->first();

        if (!$enrollment) {
            return response()->json([
                'status' => false,
                'message' => 'you are not enrolled in this course',
            ], 404);
        }

        $lecture = Lecture::where('id', $lecture_id)->where('course_id', $course_id)->first();

        if (!$lecture) {
            return response()->json([
                'status' => false,
                'message' => 'lecture not found',
            ], 404);
        }

        $progress = LectureProgress::firstOrCreate([
            'enrollment_id' => $enrollment->id,
            'lecture_id' => $lecture->id,
        ], [
            'is_completed' => false,
            'progress_percentage' => 0,
        ]);

        $progress->markAsStarted();

        $enrollment->updateLastAccess();

        $next_lecture = $enrollment->course->lectures->where('order', '>', $lecture->order)->first();

        $previous_lecture = $enrollment->course->lectures->where('order', '<', $lecture->order)->last();

        return response()->json([
            'status' => true,
            'lecture' => new LessonDetailResource($lecture, $progress),
             'navigation' => [
                'has_next' => $next_lecture !== null,
                'next_lesson' => $next_lecture ? [
                    'id' => $next_lecture->id,
                    'title' => $next_lecture->title,
                ] : null,
                'has_previous' => $previous_lecture !== null,
                'previous_lesson' => $previous_lecture ? [
                    'id' => $previous_lecture->id,
                    'title' => $previous_lecture->title,
                ] : null,
            ],
        ], 200);

    }

};
