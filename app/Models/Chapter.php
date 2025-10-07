<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Chapter extends Model
{
    use HasTranslations ;

    public $translatable = ['name'];

    protected $fillable =[
        'name',
        'order',
        'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
