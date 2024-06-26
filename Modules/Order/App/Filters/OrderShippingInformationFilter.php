<?php

namespace Modules\Order\App\Filters;

use EloquentFilter\ModelFilter;

class OrderShippingInformationFilter extends ModelFilter
{
    /**
     * Filter by order_id.
     *
     * @param int $orderId
     * @return $this
     */
    public function orderId($orderId)
    {
        return $this->where('order_id', $orderId);
    }

    /**
     * Filter by shipping_type.
     *
     * @param string $shippingType
     * @return $this
     */
    public function shippingType($shippingType)
    {
        return $this->where('shipping_type', $shippingType);
    }

    /**
     * Filter by shipping_address (search).
     *
     * @param string $shippingAddress
     * @return $this
     */
    public function shippingAddress($shippingAddress)
    {
        return $this->where('shipping_address', 'like', "%$shippingAddress%");
    }

    /**
     * Filter by shipping_cost range.
     *
     * @param float $fromShippingCost
     * @param float $toShippingCost
     * @return $this
     */

    public function fromshippingCost($fromshippingCost)
    {
        if (request()->toshippingCost === null) {
            return $this->where(function ($q) use ($fromshippingCost) {
                return $q->where('shipping_cost', $fromshippingCost);
            });
        }

        return $this->where(function ($q) use ($fromshippingCost) {
            return $q->where('shipping_cost', '>=', $fromshippingCost);
        });
    }

    public function toshippingCost($toshippingCost)
    {
        if (request()->fromshippingCost === null) {
            return $this->where(function ($q) use ($toshippingCost) {
                return $q->where('shipping_cost', $toshippingCost);
            });
        }

        return $this->where(function ($q) use ($toshippingCost) {
            return $q->where('shipping_cost', '<=', $toshippingCost);
        });
    }

}
