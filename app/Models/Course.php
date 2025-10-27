<?php

namespace App\Models;

use App\Models\Chapter;
use App\Models\CourseCategorie;
use App\Models\Instructor;
use App\Models\CoursePrerequisite;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Course extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'name',
        'description',
        'objectives',
        'price',
        'duration',
        'difficulty_degree',
        'thumbnail',
        'cover',
        'video',
        'status',
        'accessibility',
        'progression',
        'tags',
        'capacity',
        'days_to_complete',
        'rating',
        'show_index'
    ];

    protected $casts = [
        'title' => 'array',
        'name' => 'array',
        'description' => 'array',
        'objectives' => 'array',
        'difficulty_degree' => 'array',
    ];

    protected $translatable = [
        'title', 'description', 'objectives', 'name', 'difficulty_degree'
    ];

    /**
     * Get the enrollments for the course.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the users enrolled in the course.
     */
    public function enrolledUsers(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class, 'enrollments')
            ->using(Enrollment::class)
            ->withPivot('status', 'progress', 'grade', 'completion_date')
            ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(
            CourseCategorie::class,
            'course_category',
            'course_id',
            'course_category_id'
        );
    }

    public function getPreviewContent()
    {
        $previewCount = 1; 

        return $this
            ->lectures()
            ->orderBy('order')
            ->limit($previewCount)
            ->get();
    }
    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'course_instructor');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function prerequisiteCourses()
    {
        return $this->belongsToMany(
            Course::class,
            'course_prerequisites',
            'course_id',
            'course_prerequisite_id'
        )->withTimestamps();
    }

    public function requiredBy()
    {
        return $this->hasMany(CoursePrerequisite::class,'course_prerequisite_id');
    }
    

    // public function lectures()
    // {
    //     return $this->hasMany(Lecture::class);
    // }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'course_tag', 'course_id', 'tag_id');
    }
    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'course_plan', 'course_id', 'plan_id');
    }
    public function lectures()
    {
        return $this->hasManyThrough(
            \App\Models\Lecture::class,
            \App\Models\Chapter::class,
            'course_id',   
            'chapter_id', 
            'id',         
            'id'          
        );
    }



}
