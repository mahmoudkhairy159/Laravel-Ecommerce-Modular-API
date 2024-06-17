<?php

namespace Modules\Payment\App\resources\UserPayment;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'card_type' => $this->card_type,
            'card_number' => $this->card_number,
            'status' => $this->status,
            'active' => $this->active,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
