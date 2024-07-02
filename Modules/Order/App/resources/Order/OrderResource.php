<?php

namespace Modules\Order\App\resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Item\App\resources\Item\ItemResource;
use Modules\Order\App\resources\OrderHistory\OrderHistoryResource;
use Modules\Order\App\resources\OrderShippingInformation\OrderShippingInformationResource;
use Modules\Payment\App\resources\UserPayment\UserPaymentResource;
use Modules\User\App\resources\User\UserResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'order_number' => $this->order_number,
            'order_date' => $this->order_date,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'transaction_id' => $this->transaction_id,
            'total_price' => $this->total_price,
            'tax' => $this->tax,
            'notes' => $this->notes,
            'user' => new UserResource($this->whenLoaded('user')),
            'user_payment' => new UserPaymentResource($this->whenLoaded('userPayment')),
            'items' => ItemResource::collection($this->whenLoaded('items')),
            'order_histories' => OrderHistoryResource::collection($this->whenLoaded('orderHistories')),
            'order_shipping' => new OrderShippingInformationResource($this->whenLoaded('orderShipping')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

    }
}
