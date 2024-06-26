<?php

namespace Modules\Order\App\Repositories;

use Modules\Order\App\Models\OrderShippingInformation;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderShippingInformationRepository extends BaseRepository
{
    public function model()
    {
        return OrderShippingInformation::class;
    }
    public function getAll()
    {
        return $this->model
            ->filter(request()->all())
            ->orderBy('created_at', 'asc');
    }

    public function getByOrderId($orderId)
    {
        return $this->model
            ->where('order_id', $orderId);
    }
}
