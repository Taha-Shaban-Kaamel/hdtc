<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lecture;
use App\Models\Enrollment;

class LessonProgress extends Model
{
    protected $fillable = [
        'enrollment_id',
        'lecture_id',
        'is_completed',
        'progress_percentage',
        'time_spent_seconds',
        'started_at',
        'completed_at',
        'last_accessed_at',
    ];

    public function lesson(){
        return $this->belongsTo(Lecture::class);
    }

    public function enrollment(){
        return $this->belongsTo(Enrollment::class);
    }

    public function markAsStarted(){
        if(!$this->started_at){
            $this->update([
                'started_at' => now(),
            ]);
        }
        $this->update([
            'last_accessed_at' => now(),
        ]);
    }

    public function markAsCompleted(){
        $this->update([
            'is_completed' => true,
            'progress_percentage' => 100,
            'completed_at' => now(),
        ]);

        $this->enrollment->updateProgress();
    }

    public function updateProgress(float $percentage){
        $this->update([
            'progress_percentage' => min($percentage, 100),
        ])  ; 

        if ($percentage >= 100 && !$this->is_completed) {
            $this->markAsCompleted();
        }
    }



}
