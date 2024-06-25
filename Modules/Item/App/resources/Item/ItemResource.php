<?php

namespace Modules\Item\App\resources\Item;

use Illuminate\Http\Resources\Json\JsonResource;


class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'image_url' => $this->image_url,
            'discount' => $this->discount,
            'price' => $this->price,
            'rank' => $this->rank,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'brand_id' => $this->brand_id,
            'brand_name' =>$this->brand?$this->brand->name:null,
            'category_id' => $this->category_id,
            'category_name' =>$this->category?$this->category->name:null,,
            'translations' => $this->getTranslationsArray()
        ];

    }
}
