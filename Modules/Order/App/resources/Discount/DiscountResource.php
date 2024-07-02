<?php

namespace Modules\Order\App\resources\Discount;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'amount' => $this->amount,
            'percentage' => $this->percentage,
            'expires_at' => $this->expires_at,
            'usage_limit' => $this->usage_limit,
            'used_count' => $this->used_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
