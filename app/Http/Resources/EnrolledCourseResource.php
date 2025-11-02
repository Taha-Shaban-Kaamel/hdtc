<?php

namespace App\Http\Resources;

use App\Http\Resources\CategorieResrource;
use App\Http\Resources\InstructorResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class EnrolledCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currentLecture = $this->resource->getCurrentLecture();
        $nextLecture = $this->resource->getNextLecture();

        return [
            'enrollment_id' => $this->id,
            'course' => $this->whenLoaded('course', function () {
                return [
                    'id' => $this->course->id,
                    'title' => $this->course->title,
                    'description' => $this->course->description,
                    'image' => asset($this->course->cover),
                    'price' => $this->course->price,
                    'instructors' => $this->when($this->course->relationLoaded('instructors'), function () {
                        return InstructorResource::collection($this->course->instructors);
                    }),
                    'categories' => $this->when($this->course->relationLoaded('categories'), function () {
                        return CategorieResrource::collection($this->course->categories);
                    }),
                    'chapters' => $this->when($this->course->relationLoaded('chapters'), function () {
                        return ChapterResource::collection($this->course->chapters);
                    }),
                ];
            }),
            'enrollment_info' => [
                'status' => $this->status,
                'progress' => $this->progress,
                'completion_date' =>  $this->completion_date?->diffForHumans(),
                'start_at' => $this->start_at?->diffForHumans(),
                'last_accessed_at' => $this->last_accessed_at?->diffForHumans(),
            ],
            'current_lesson' => $currentLecture ? [
                'id' => $currentLecture->id,
                'title' => $currentLecture->title,
                'order_index' => $currentLecture->order,
            ] : null,
            'next_lesson' => $nextLecture ? [
                'id' => $nextLecture->id,
                'title' => $nextLecture->title,
                'order_index' => $nextLecture->order,
            ] : null,
        ];
    }
}
