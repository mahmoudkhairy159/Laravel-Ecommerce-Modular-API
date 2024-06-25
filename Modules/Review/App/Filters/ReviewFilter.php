<?php

namespace Modules\Review\App\Filters;

use EloquentFilter\ModelFilter;

class ReviewFilter extends ModelFilter
{

    public function search($search)
    {
        return $this->where(function ($q) use ($search) {
            return $q->where('comment', 'LIKE', "%$search%");
        });
    }
    public function rate($rate)
    {
        return $this->where(function ($q) use ($rate) {
            return $q->where('rate', $rate);
        });
    }
    public function itemId($itemId)
    {
        return $this->where(function ($q) use ($itemId) {
            return $q->where('item_id', $itemId);
        });
    }
    public function userId($userId)
    {
        return $this->where(function ($q) use ($userId) {
            return $q->where('user_id', $userId);
        });
    }

    public function status($status)
    {
        return $this->where(function ($q) use ($status) {
            return $q->where('status', $status);
        });
    }

}
