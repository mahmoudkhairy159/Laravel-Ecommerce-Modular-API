<?php

namespace Modules\Payment\App\Filters;

use EloquentFilter\ModelFilter;

class UserPaymentFilter extends ModelFilter
{

    public function search($search)
    {
        return $this->where(function ($q) use ($search) {
            return $q->where('name', 'LIKE', "%$search%")
                ->orWhere('card_number', 'LIKE', "%$search%")
                ->orWhere('card_type', 'LIKE', "%$search%");
        });
    }
    public function status($status)
    {
        return $this->where(function ($q) use ($status) {
            return $q->where('status', $status);
        });
    } public function active($active)
    {
        return $this->where(function ($q) use ($active) {
            return $q->where('active', $active);
        });
    }
    public function cardType($cardType)
    {
        return $this->where(function ($q) use ($cardType) {
            return $q->where('card_type', $cardType);
        });
    }
    public function cardNumber($cardNumber)
    {
        return $this->where(function ($q) use ($cardNumber) {
            return $q->where('card_number', $cardNumber);
        });
    }
}
