<?php

namespace Modules\Order\App\Filters;

use EloquentFilter\ModelFilter;

class OrderFilter extends ModelFilter
{
/**
     * Filter by user_id.
     *
     * @param int $userId
     * @return $this
     */
    public function userId($userId)
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Filter by payment_id.
     *
     * @param int $paymentId
     * @return $this
     */
    public function paymentId($paymentId)
    {
        return $this->where('payment_id', $paymentId);
    }

    /**
     * Filter by order_number.
     *
     * @param string $orderNumber
     * @return $this
     */
    public function orderNumber($orderNumber)
    {
        return $this->where('id', $orderNumber);
    }

    /**
     * Filter by order_date range.
     *
     * @param string $date
     * @return $this
     */
    public function fromOrderDate($fromOrderDate)
    {
        if (request()->toOrderDate === null) {
            return $this->where(function ($q) use ($fromOrderDate) {
                return $q->whereDate('order_date', $fromOrderDate);
            });
        }

        return $this->where(function ($q) use ($fromOrderDate) {
            return $q->whereDate('order_date', '>=', $fromOrderDate);
        });
    }

    /**
     * Filter by order_date range.
     *
     * @param string $toDate
     * @return $this
     */
    public function toOrderDate($toOrderDate)
    {
        if (request()->fromOrderDate === null) {
            return $this->where(function ($q) use ($toOrderDate) {
                return $q->whereDate('order_date', $toOrderDate);
            });
        }

        return $this->where(function ($q) use ($toOrderDate) {
            return $q->whereDate('order_date', '<=', $toOrderDate);
        });
    }


    /**
     * Filter by status.
     *
     * @param string $status
     * @return $this
     */
    public function status($status)
    {
        return $this->where('status', $status);
    }

    /**
     * Filter by payment_method.
     *
     * @param string $paymentMethod
     * @return $this
     */
    public function paymentMethod($paymentMethod)
    {
        return $this->where('payment_method', $paymentMethod);
    }

    /**
     * Filter by payment_status.
     *
     * @param string $paymentStatus
     * @return $this
     */
    public function paymentStatus($paymentStatus)
    {
        return $this->where('payment_status', $paymentStatus);
    }

    /**
     * Filter by transaction_id.
     *
     * @param string $transactionId
     * @return $this
     */
    public function transactionId($transactionId)
    {
        return $this->where('transaction_id', $transactionId);
    }

     /**
     * Filter by total_price range.
     *
     * @param float $minTotalCost
     * @param float $maxTotalCost
     * @return $this
     */
    public function fromTotalCost($fromTotalCost)
    {
        if (request()->toTotalCost === null) {
            return $this->where(function ($q) use ($fromTotalCost) {
                return $q->where('total_price', $fromTotalCost);
            });
        }

        return $this->where(function ($q) use ($fromTotalCost) {
            return $q->where('total_price', '>=', $fromTotalCost);
        });
    }

    public function toTotalCost($toTotalCost)
    {
        if (request()->fromTotalCost === null) {
            return $this->where(function ($q) use ($toTotalCost) {
                return $q->where('total_price', $toTotalCost);
            });
        }

        return $this->where(function ($q) use ($toTotalCost) {
            return $q->where('total_price', '<=', $toTotalCost);
        });
    }

    /**
     * Filter by tax.
     *
     * @param float $tax
     * @return $this
     */
    public function tax($tax)
    {
        return $this->where('tax', $tax);
    }

    /**
     * Filter by notes (search).
     *
     * @param string $notes
     * @return $this
     */
    public function notes($notes)
    {
        return $this->where('notes', 'like', "%$notes%");
    }

}
