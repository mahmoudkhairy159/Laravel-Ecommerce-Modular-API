<?php

namespace Modules\Cart\App\resources\CartItem;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Item\App\resources\Item\ItemResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'item_id' => $this->item_id,
            'quantity' => $this->quantity,
            'item' => new ItemResource($this->whenLoaded('item')),
        ];
    }
}
