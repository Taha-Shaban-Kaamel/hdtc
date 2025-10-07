<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategorieResrource;
use App\Http\Resources\InstructorResource;

class CourseResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'objectives' => $this->objectives,
            'price' => $this->price,
            'duration' => $this->duration,
            'difficulty_degree' => $this->difficulty_degree,
            'thumbnail' => $this->thumbnail,
            'cover' => $this->cover,
            'video' => $this->video,
            'status' => $this->status,
            'categories' => $this->whenLoaded('categories', function () use ($request) {
                return CategorieResrource::collection($this->categories)->toArray($request);
            }),
            'instructors' => $this->whenLoaded('instructors', function () use ($request) {
                return InstructorResource::collection($this->instructors)->toArray($request);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
