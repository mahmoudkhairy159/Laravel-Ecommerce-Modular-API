<?php

namespace Modules\User\App\resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\App\resources\UserProfile\UserProfileResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'slug' => $this->slug,
            'email'         => $this->email,
            'phone'    => $this->phone,
            'name'          => $this->name,
            'address'          => $this->address,
            'country_id' => $this->country_id,
            "image_url" => $this->image_url,
            'country' => $this->country ? $this->country->name : null,
            'city_id' => $this->city_id,
            'city' => $this->city ? $this->city->name : null,
            'status'        => $this->status,
            'active'        => $this->active,
            'blocked'        => $this->blocked,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'verified_at' => $this->verified_at,
            'profile' => new UserProfileResource($this->profile),
        ];
    }
}
