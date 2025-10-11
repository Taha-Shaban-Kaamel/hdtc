<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'auto_renew' => 'boolean',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function usage()
    {
        return $this->hasOne(SubscriptionUsage::class);
    }

    public function isExpired()
    {
        return $this->end_date->isPast();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
