<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LectureProgress extends Model
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

    protected $casts = [
        'progress_percentage' => 'decimal:2',
        'time_spent_seconds' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_accessed_at' => 'datetime',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id', 'enrollment_id');
    }

    public function lecture(): BelongsTo
    {
        return $this->belongsTo(Lecture::class, 'lecture_id', 'lecture_id');
    }

    public function markAsStarted(): void
    {
        if (!$this->started_at) {
            $this->update(['started_at' => now()]);
        }
        $this->update(['last_accessed_at' => now()]);
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);
    }

    public function updateProgress(float $percentage): void
    {
        $this->update([
            'progress_percentage' => min($percentage, 100),
            'last_accessed_at' => now(),
        ]);

        if ($percentage >= 100 && !$this->is_completed) {
            $this->markAsCompleted();
        }
    }
    
}
