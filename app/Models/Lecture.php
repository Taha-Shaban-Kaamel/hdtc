<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Lecture extends Model
{
    use HasTranslations;

    public $translatable = ['title'];

    protected $fillable = [
        'course_id',
        'chapter_id',
        'title',
        'video_url',
        'type',
        'order',
        'exam',
        'lecture_views'
    ];

    protected $casts = [
        'title' => 'array',
        'order' => 'integer',
        'lecture_views' => 'integer',
    ];


    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function isAccessibleBy($user = null)
    {
        if ($this->isPreviewable()) {
            return true;
        }

        if (!$user) {
            return false;
        }

        if ($user->isEnrolledIn($this->course_id)) {
            return true;
        }
        if ($user->teaches($this->course_id)) {
            return true;
        }

        if ($user->hasRole('admin') || $user->hasRole('super admin')) {
            return true;
        }

        return false;
    }

    public function getProgressForUser($userId)
    {
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $this->course_id)
            ->first();

        if (!$enrollment) {
            return null;
        }

        return LectureProgress::where('enrollment_id', $enrollment->enrollment_id)
            ->where('lecture_id', $this->lecture_id)
            ->first();
    }
}
