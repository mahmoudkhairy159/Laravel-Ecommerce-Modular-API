<?php

namespace Modules\Order\App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Item\App\Models\Item;
use Modules\Order\App\Filters\OrderItemFilter;
use Modules\Order\Database\factories\OrderItemFactory;

class OrderItem extends Model
{
    use HasFactory,Filterable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'item_id',
        'quantity',
        'price'
    ];
    public function modelFilter()
    {
        return $this->provideFilter(OrderItemFilter::class);
    }
    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the item that owns the order item.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
