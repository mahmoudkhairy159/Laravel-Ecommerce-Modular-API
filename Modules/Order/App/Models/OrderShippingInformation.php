<?php

namespace Modules\Order\App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Order\App\Filters\OrderShippingInformationFilter;

class OrderShippingInformation extends Model
{
    use HasFactory,Filterable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'shipping_type',
        'shipping_address',
        'shipping_cost'
    ];
    public function modelFilter()
    {
        return $this->provideFilter(OrderShippingInformationFilter::class);
    }
    // Enum values for shipping_type
    const SHIPPING_TYPE_STANDARD = 'standard';
    const SHIPPING_TYPE_EXPRESS = 'express';
    const SHIPPING_TYPE_OVERNIGHT = 'overnight';
    public static function getShippingTypes()
    {
        return [
            self::SHIPPING_TYPE_STANDARD,
            self::SHIPPING_TYPE_EXPRESS,
            self::SHIPPING_TYPE_OVERNIGHT,
        ];
    }
    // Enum values for shipping_type

    /**
     * Get the order that owns the shipping information.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
