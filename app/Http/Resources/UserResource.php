<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id ,
            'first_name'=> $this->resource->first_name,
            'second_name'=> $this->resource->second_name,
            'email'=> $this->resource->email,
            'avatar'=> str_starts_with($this->resource->avatar, 'http') ? $this->resource->avatar : asset('storage/'.$this->resource->avatar),
            'provider'=> $this->resource->provider,
            'user_type'=> $this->whenLoaded('userType',fn()=> $this->resource->userType->name),
            'gender'=> $this->resource->gender,
            'birth_date'=> $this->resource->birth_date,
            'phone'=> $this->resource->phone,
            'bio'=> $this->resource->bio,
            'status'=> $this->resource->status,
            'created_at'=> $this->resource->created_at->diffForHumans(),
            'updated_at'=> $this->resource->updated_at->diffForHumans(),
        ];
    }
}
