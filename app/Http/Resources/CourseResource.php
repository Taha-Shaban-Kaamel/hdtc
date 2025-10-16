<?php

namespace App\Http\Resources;

use App\Http\Resources\CategorieResrource;
use App\Http\Resources\InstructorResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isEnrolled = auth('sanctum')->check() &&
            auth('sanctum')->user()->isEnrolledIn($this->resource->id);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'name' => $this->name,
            'description' => $this->description,
            'objectives' => $this->objectives,
            'price' => $this->price,
            'duration' => $this->duration,
            'difficulty_degree' => $this->difficulty_degree,
            'thumbnail' => asset($this->thumbnail),
            'cover' => asset($this->cover),
            'video' => $this->video,
            'status' => $this->status,
            'categories' => $this->whenLoaded('categories', function () use ($request) {
                return CategorieResrource::collection($this->categories)->toArray($request);
            }),
            'instructors' => $this->whenLoaded('instructors', function () use ($request) {
                return InstructorResource::collection($this->instructors)->toArray($request);
            }),
            'tags' => $this->whenLoaded('tags', function ($tags) use ($request) {
                return $tags->pluck('name');
            }),
            'chapters' => $this->whenLoaded('chapters', function () use ($request) {
                return ChapterResource::collection($this->chapters)->toArray($request);
            }),
            'preview' => $this->when($this->getPreviewContent()->isNotEmpty(), function () {
                return  LectureResource::collection($this->getPreviewContent());
            }),
            'user_status' => [
                'is_enrolled' => $isEnrolled,
                'can_enroll' => !$isEnrolled && $this->status === 'active',
            ],

            'enrollments_count' => $this->enrollments()->count(),

            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
