<?php

namespace Modules\Area\App\resources\City;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'country_id' => $this->country_id,
            'code' => $this->code,
            "name" => $this->name,
            "description" => $this->description,
            "status" => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'translations'=>$this->getTranslationsArray()
        ];
    }
}
