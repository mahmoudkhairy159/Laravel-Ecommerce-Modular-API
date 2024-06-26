<?php

namespace Modules\Order\App\Filters;

use EloquentFilter\ModelFilter;

class OrderItemFilter extends ModelFilter
{
 /**
     * Filter by item_id.
     *
     * @param int $itemId
     * @return $this
     */
    public function itemId($itemId)
    {
        return $this->where('item_id', $itemId);
    }
    /**
     * Filter by orderId.
     *
     * @param int $orderId
     * @return $this
     */
    public function orderId($orderId)
    {
        return $this->where('order_id', $orderId);
    }


    /**
     * Filter by quantity.
     *
     * @param int $quantity
     * @return $this
     */
    public function quantity($quantity)
    {
        return $this->where('quantity', $quantity);
    }

    /**
     * Filter by price.
     *
     * @param float $price
     * @return $this
     */
    public function price($price)
    {
        return $this->where('price', $price);
    }

}
