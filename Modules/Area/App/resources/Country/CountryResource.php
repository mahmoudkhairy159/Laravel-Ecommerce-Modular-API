<?php

namespace Modules\Area\App\resources\Country;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\App\resources\Role\RoleResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            "name" => $this->name,
            "description" => $this->description,
            "status" => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'translations' => $this->getTranslationsArray()
        ];
    }
}
