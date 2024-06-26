<?php

namespace Modules\Order\App\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Order\App\Models\OrderItem;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderItemRepository extends BaseRepository
{
    public function model()
    {
        return OrderItem::class;
    }
    public function getAll()
    {
        return $this->model
            ->filter(request()->all())
            ->orderBy('created_at', 'desc');
    }

    public function getByOrderId($orderId)
    {
        return $this->model
            ->where('order_id', $orderId)
            ->filter(request()->all())
            ->orderBy('created_at', 'asc');
    }


}
