<?php

namespace Modules\Order\App\Repositories;

use Modules\Order\App\Models\OrderHistory;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderHistoryRepository extends BaseRepository
{
    public function model()
    {
        return OrderHistory::class;
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
            ->where('order_id', $orderId)
            ->filter(request()->all())
            ->orderBy('created_at', 'asc');
    }
}
