<?php

namespace Modules\Order\App\Filters;

use EloquentFilter\ModelFilter;

class OrderHistoryFilter extends ModelFilter
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
