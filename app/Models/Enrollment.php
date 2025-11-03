<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $dates = [
        'completion_date',
        'start_at',
        'last_accessed_at',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'progress',
        'grade',
        'completion_date',
        'start_at',
        'last_accessed_at',
        'payment_id',
        'payment_status'
    ];

    protected $casts = [
        'progress' => 'decimal:2',
        'grade' => 'decimal:2',
        'completion_date' => 'date',
        'start_at' => 'date',
        'last_accessed_at' => 'date',
    ];

    /**
     * Get the user that owns the enrollment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class, 'enrollment_id', 'enrollment_id');
    }

    public function revokeAccess(): void
    {
        $this->update([
            'status' => 'inActive',
        ]);
    }

    public function grantAccess()
    {
        $this->update([
            'status' => 'active',
            'start_at' => now()
        ]);
    }

    public function updateLastAccess()
    {
        $this->update([
            'last_accessed_at' => now()
        ]);
    }

    public function scopeActive($query)
    {
        return $query->where('enrollment_status', 'active');
    }

    public function scopeWithAccess($query)
    {
        return $query
            ->where('enrollment_status', 'active')
            ->where(function ($q) {
                $q
                    ->whereNull('access_starts_at')
                    ->orWhere('access_starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q
                    ->whereNull('access_ends_at')
                    ->orWhere('access_ends_at', '>=', now());
            });
    }

    public function lectureProgress()
    {
        return $this->hasMany(LectureProgress::class, 'enrollment_id', 'enrollment_id');
    }

    public function updateLectureProgress(): void
    {
        $totalLectures = $this
            ->course
            ->lectures()
            ->where('status', 'active')
            ->count();

        if ($totalLectures === 0) {
            return;
        }

        $completedLectures = $this
            ->lectureProgress()
            ->where('is_completed', true)
            ->count();

        $progressPercentage = ($completedLectures / $totalLectures) * 100;

        $this->update([
            'progress_percentage' => $progressPercentage,
            'last_accessed_at' => now(),
        ]);

        if ($progressPercentage >= 100 && $this->status === 'active') {
            $this->markAsCompleted();
        }
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completion_date' => now(),
            'progress_percentage' => 100
        ]);
    }

    public function getNextLecture()
    {
        $incompleteLectureProgress = $this
            ->lectureProgress()
            ->where('is_completed', false)
            ->with('lecture')
            ->orderBy('lecture_id')
            ->first();

        if ($incompleteLectureProgress) {
            return $incompleteLectureProgress->lecture;
        }

        return $this
            ->course
            ->lectures()
            ->orderBy('order')
            ->first();
    }

    public function getCurrentLecture()
    {
        // Get last accessed lesson
        $lastProgress = $this
            ->lectureProgress()
            ->where('last_accessed_at', '!=', null)
            ->orderBy('last_accessed_at', 'desc')
            ->first();

        if ($lastProgress) {
            return $lastProgress->lecture;
        }

        return $this
            ->course
            ->lectures()
            ->orderBy('order')
            ->first();
    }
}
