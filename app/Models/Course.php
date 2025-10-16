<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Instructor;
use App\Models\Chapter;
use App\Models\Tag;
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
        'objectives',
        'thumbnail',
        'cover',
        'video',
        'status',
        'accessibility',
        'progression',
        'tags',
    ];

    protected $casts = [
        'title' => 'array',
        'name' => 'array',
        'description' => 'array',
        'objectives' => 'array',
    ];

    public $translatable = ['title', 'name', 'description', 'objectives' , 'difficulty_degree'];
    public function categories()
    {
        return $this->belongsToMany(
            CourseCategorie::class,
            'course_category',
            'course_id',
            'course_category_id'
        );
    }

    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'course_instructor');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

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
            'course_id',   // Foreign key on chapters table
            'chapter_id',  // Foreign key on lectures table
            'id',          // Local key on courses table
            'id'           // Local key on chapters table
        );
    }



}
