<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of enrollments.
     */
    public function index(): AnonymousResourceCollection
    {
        
        $enrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->paginate(10);
            
        return EnrollmentResource::collection($enrollments);
    }

    /**
     * Store a newly created enrollment in storage.
     */
    public function store(StoreEnrollmentRequest $request): JsonResponse
    {
        
        $enrollment = Enrollment::create($request->validated());
        
        return response()->json([
            'message' => 'Enrollment created successfully',
            'data' => new EnrollmentResource($enrollment->load('user', 'course'))
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified enrollment.
     */
    public function show(Enrollment $enrollment): EnrollmentResource
    {
        $this->authorize('view', $enrollment);
        
        return new EnrollmentResource($enrollment->load('user', 'course'));
    }

    /**
     * Update the specified enrollment in storage.
     */
    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment): JsonResponse
    {
        
        $enrollment->update($request->validated());
        
        return response()->json([
            'message' => 'Enrollment updated successfully',
            'data' => new EnrollmentResource($enrollment->load('user', 'course'))
        ]);
    }

    /**
     * Remove the specified enrollment from storage.
     */
    public function destroy(Enrollment $enrollment): JsonResponse
    {
        $this->authorize('delete', $enrollment);
        
        $enrollment->delete();
        
        return response()->json([
            'message' => 'Enrollment deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Enroll the authenticated user in a course.
     */
    public function enroll($id): JsonResponse
    {
        $course = Course::findOrFail($id);
        $isEnrolled = $course->enrolledUsers()->where('user_id', auth()->id())->exists();
        if ($isEnrolled) {
            return response()->json([
                'message' => 'You are already enrolled in this course'
            ], Response::HTTP_CONFLICT);
        }
        
        $enrollment = Enrollment::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'status' => 'active',
            'progress' => 0,
            'grade' => 0
        ]);
        
        return response()->json([
            'message' => 'Successfully enrolled in the course',
            'data' => new EnrollmentResource($enrollment->load('course'))
        ]);
    }

    /**
     * Get the authenticated user's enrollments.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function myEnrollments()
    {
        try {
            $enrollments = auth()->user()->enrollments()
                ->with('course')
                ->get();
                
            return EnrollmentResource::collection($enrollments);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve enrollments',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
