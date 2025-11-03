<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

     private $progress;

     public function __construct($resource, $progress)
    {
        parent::__construct($resource);
        $this->progress = $progress;
    }
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'order' => $this->order,
            'video_url' => $this->video_url,
            'order' => $this->order,
            'progress' => $this->progress ? [
                'is_completed' => $this->progress->is_completed,
                'progress_percentage' => (float) $this->progress->progress_percentage,
                'started_at' => $this->progress->started_at?->diffForHumans(),
                'completed_at' => $this->progress->completed_at?->diffForHumans(),
                'last_accessed_at' => $this->progress->last_accessed_at?->diffForHumans(),
            ] : null,
        ];
    }
}
