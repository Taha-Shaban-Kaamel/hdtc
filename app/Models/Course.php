<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Instructor;
use App\Models\Chapters;
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
        return $this->hasMany(Chapters::class);
    }


}
