<?php

namespace Modules\Order\App\resources\OrderItem;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Item\App\resources\Item\ItemResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->pivot->order_id,
            'item_id' => $this->pivot->item_id,
            'quantity' => $this->pivot->quantity,
            'price' => $this->pivot->price,
            'item' => new ItemResource($this->whenLoaded('item')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

    }
}
