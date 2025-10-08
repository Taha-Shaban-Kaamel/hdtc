<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Lecture ;

class Chapter extends Model
{
    use HasTranslations ;

    public $translatable = ['name'];

    protected $fillable =[
        'id',
        'name',
        'order',
        'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lectures(){
        return $this->hasMany(Lecture::class) ;
    }
}
