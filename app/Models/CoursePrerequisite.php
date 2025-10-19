<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoursePrerequisite extends Model
{
    protected $fillable = [
        'course_id',
        'course_prerequisite_id'
    ];

    protected $with = ['prerequisiteCourse'];


    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function prerequisiteCourse(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_prerequisite_id');
    }
}