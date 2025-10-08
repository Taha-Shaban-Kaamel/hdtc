<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
}