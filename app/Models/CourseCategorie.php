<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CourseCategorie extends Model
{
    use HasTranslations;
    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'image',
    ];
    
    public $translatable = ['name', 'description'];
    
    public function parent()
    {
        return $this->belongsTo(CourseCategorie::class, 'parent_id');
    }
    
    public function children()
    {
        return $this->hasMany(CourseCategorie::class, 'parent_id');
    }
}
