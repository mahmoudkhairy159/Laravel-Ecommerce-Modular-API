<?php

namespace Modules\Order\App\resources\OrderShippingInformation;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderShippingInformationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => OrderShippingInformationResource::collection($this->collection),
            'pagination' => [
                'total' => $this->total(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'from' => $this->firstOrderShippingInformation(),
                'to' => $this->lastOrderShippingInformation(),
            ],
        ];

    }
}
