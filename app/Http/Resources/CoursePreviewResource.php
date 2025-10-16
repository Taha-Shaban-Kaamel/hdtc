<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class CoursePreviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $isEnrolled = auth('sanctum')->check() &&
                      auth('sanctum')->user()->isEnrolledIn($this->id);



        return [
            'id' => $this->resource->id ?? null,
            'name' => $this->resource->name ?? null,
            'title' => $this->resource->title ?? null,
            'description' => $this->description ?? null,
            'thumbnail' => $this->thumbnail ?? null,
            'cover' => $this->cover ?? null,
            'instructors' => $this->whenLoaded('instructors', function () {
                return $this->instructors->map(function ($instructor) {
                    return [
                        'id' => $instructor->id,
                        'name' => $instructor->name,
                        'avatar' => $instructor->avatar,
                    ];
                })->first(); 
            }),
            'categories' => $this->whenLoaded('categories', function () {
                return $this->categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                    ];
                });
            }),
            'pricing' => [
                'price' => (float) $this->price,
                'currency' => 'USD',
                'is_free' => $this->price == 0,
            ],

            'difficulty_level' => $this->difficulty_level,
            'status' => $this->status,
            'user_status' => [
                'is_enrolled' => $isEnrolled,
                'can_enroll' => !$isEnrolled && $this->status === 'published',
            ],
        ];
    }
}
