<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'features' => 'array',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_plan', 'plan_id', 'course_id');
    }


}
