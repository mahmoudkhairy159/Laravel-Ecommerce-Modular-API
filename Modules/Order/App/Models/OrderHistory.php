<?php

namespace Modules\Order\App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Order\App\Filters\OrderHistoryFilter;
use Modules\Order\Database\factories\OrderHistoryFactory;

class OrderHistory extends Model
{
    use HasFactory,Filterable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'status',
        'notes'
    ];
    public function modelFilter()
    {
        return $this->provideFilter(OrderHistoryFilter::class);
    }
    // Enum values for status
      const STATUS_PENDING = 'pending';
      const STATUS_PROCESSING = 'processing';
      const STATUS_SHIPPING = 'shipping';
      const STATUS_COMPLETED = 'completed';
      const STATUS_CANCELLED = 'cancelled';
      // Enum values for status
      public function order()
      {
          return $this->belongsTo(Order::class);
      }
}
