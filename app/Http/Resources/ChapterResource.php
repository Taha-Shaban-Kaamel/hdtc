<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
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
            'name' => $this->name,
            'order' => $this->order,
            'course_id' => $this->course_id,
            'lectures' => $this->whenLoaded('lectures', function () use ($request) {
                return LectureResource::collection($this->lectures)->toArray($request);
            }),
        ];
    }
}
