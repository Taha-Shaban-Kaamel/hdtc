<?php
namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Resources\EnrolledCourseResource;
class EnrollmentService
{
    public function enroll($user_id, $course_id, array $options = [])
    {
        try {
            DB::beginTransaction();
            $student = User::find($user_id);
            $course = Course::find($course_id);
            $validation = $this->enrollmentValidation($student, $course);
            $enrollmentStatus = $this->determainEnrollmentStatus($course, $options);
            if ($validation) {
                return $validation;
            }
            \Log::info('Enrollment successful!');


            $enrollment = Enrollment::create([
                'user_id' => $student->id,
                'course_id' => $course->id,
                'status' => 'active',
                'progress' => 0,
                'grade' => 0,
                'completion_date' => null,
                'start_at' => now(),
                'last_accessed_at' => null,
                'payment_status' => $options['payment_status'] ?? null,
            ]);

            if ($enrollmentStatus === 'active') {
                $this->grantImmediateAccess($enrollment);
            }

            DB::commit();

            // Load the relationships before creating the resource
            $enrollment->load([
                'course.lectures',
                'course.chapters',
                'course.categories',
                'course.instructors'
            ]);

            return [
                'success' => true,
                'message' => $enrollmentStatus === 'active'
                    ? 'Enrollment successful! You now have immediate access to the course.'
                    : 'Enrollment request submitted successfully.',
                'enrollment' => new EnrolledCourseResource($enrollment),
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Enrollment failed: ' . $e->getMessage(),
                'enrollment' => null,
            ];
        }
    }

    private function enrollmentValidation($user, $course)
    {
        $enrollment = Enrollment::where('user_id', $user->id)->where('course_id', $course->id)->first();
        $courseStudents = $course->enrolledUsers()->count();
        \Log::info(['enrollment' => $enrollment, 'courseStudents' => $courseStudents]);
        if ($enrollment) {
            return [
                'status' => false,
                'reason' => 'already enrolled',
                'enrollment' => $enrollment
            ];
        } else if ($course->capacity < $courseStudents) {
            return [
                'status' => false,
                'reason' => 'course is full',
            ];
        } else {
            return false;
        }
    }

    private function grantImmediateAccess($enrollment)
    {
        $enrollment->grantAccess();

        $this->initLectureProgress($enrollment);
    }

    private function determainEnrollmentStatus($course)
    {
        if ($course->price > 0) {
            if (!isset($options['paymetn_status']) || $options['paymetn_status'] != 'paid') {
                return 'pending';
            }
            return 'active';
        } else {
            return 'active';
        }
    }

    private function initLectureProgress($enrollment)
    {
        $lectures = $enrollment->course->lectures;

        DB::table('lecture_progress')->insert($lectures->map(function ($lecture) use ($enrollment) {
            return [
                'enrollment_id' => $enrollment->id,
                'lecture_id' => $lecture->id,
                'is_completed' => false,
                'progress_percentage' => 0,
                'time_spent_seconds' => 0,
                'started_at' => now(),
                'completed_at' => null,
                'last_accessed_at' => null,
            ];
        }));
    }
}
