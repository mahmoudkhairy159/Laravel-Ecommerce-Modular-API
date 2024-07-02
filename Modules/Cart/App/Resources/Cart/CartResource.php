<?php

namespace Modules\Cart\App\resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Cart\App\resources\CartItem\CartItemResource;
use Modules\Item\App\resources\Item\ItemResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total_price' => $this->items->sum(function ($cartItem) {
                return $cartItem->item->price * $cartItem->quantity;
            }),
            'discount_amount' => $this->discount_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'items' => CartItemResource::collection($this->whenLoaded('items')),

        ];
    }
}
