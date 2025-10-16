<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LecturePreviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = auth('sanctum')->user();
        $isAccessible = $this->isAccessibleBy($user);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'order' => $this->order,
            'access' => [
                'is_accessible' => $isAccessible,
                'is_locked' => !$isAccessible,
            ],
            'video_url' => $isAccessible ? $this->video_url : null,
        ];
    }
}
