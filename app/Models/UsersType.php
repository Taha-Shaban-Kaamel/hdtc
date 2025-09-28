<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class UsersType extends Model
{
    use HasFactory, HasTranslations;
    
    protected $fillable = [
        'name',
    ];

    public $translatable = ['name'];
    
    protected $casts = [
        'name' => 'array',
    ];
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
