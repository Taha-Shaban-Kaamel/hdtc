<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LectureResource extends JsonResource
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
            'title' => $this->title,
            'order' => $this->order,
            'chapter_id' => $this->chapter_id,
            'course_id' => $this->course_id,
            'video' => $this->video_url,
            'type' => $this->type,
            'exam' => $this->exam,
            'lecture_views' => $this->lecture_views,
        ];
    }
}
