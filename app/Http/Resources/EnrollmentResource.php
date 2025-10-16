<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'course' => [
                'id' => $this->course_id,
                'title' => $this->course->title ?? null,
                'slug' => $this->course->slug ?? null,
                'thumbnail' => $this->course->thumbnail ?? null,
            ],
            'status' => $this->status,
            'progress' => (float) $this->progress,
            'grade' => $this->whenNotNull($this->grade, (float) $this->grade),
            'completion_date' => $this->whenNotNull($this->completion_date),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
