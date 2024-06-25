<?php

namespace Modules\Item\App\resources\ItemImage;

use Illuminate\Http\Resources\Json\JsonResource;


class ItemImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'image_url' => $this->image_url,
            'item_id' => $this->item_id,
        ];

    }
}
