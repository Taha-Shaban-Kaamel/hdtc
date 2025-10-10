<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->user->first_name . ' ' . $this->resource->user->second_name,
            'user_id' => $this->resource->user_id,
            'specialization' => $this->resource->specialization,
            'education' => $this->resource->education,
            'bio' => $this->resource->bio,
            'experience' => $this->resource->experience,
            'company' => $this->resource->company,
            'rate' => $this->resource->rating,
            'twitter_url' => $this->resource->twitter_url,
            'linkedin_url' => $this->resource->linkedin_url,
            'facebook_url' => $this->resource->facebook_url,
            'youtube_url' => $this->resource->youtube_url,
            'is_active' => $this->resource->is_active,
            'created_at' => $this->resource->created_at->diffForHumans(),
            'updated_at' => $this->resource->updated_at->diffForHumans(),
            'user' => [
                'id' => $this->resource->user->id,
                'first_name' => $this->resource->user->first_name,
                'second_name' => $this->resource->user->second_name,
                'email' => $this->resource->user->email,
                'phone' => $this->resource->user->phone,
                'avatar' => $this->resource->user->avatar ? asset('storage/instructors/' . $this->resource->user->avatar) : null,
                'gender' => $this->resource->user->gender,
                'birth_date' => $this->resource->user->birth_date,
                'status' => $this->resource->user->status,
            ]
        ];
    }
}
