<?php

namespace Modules\Order\App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Item\App\Models\Item;
use Modules\Order\App\Filters\OrderFilter;
use Modules\Payment\App\Models\UserPayment;
use Modules\User\App\Models\User;

class Order extends Model
{
    use HasFactory,Filterable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'payment_id',
        'order_date',
        'status',
        'payment_method',
        'payment_status',
        'transaction_id',
        'total_cost',
        'tax',
        'notes'
    ];
    public function modelFilter()
    {
        return $this->provideFilter(OrderFilter::class);
    }
    // Enum values for status
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPING = 'shipping';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    // Enum values for status

    // Enum values for payment_method
    const PAYMENT_METHOD_CASH = 'cash';
    const PAYMENT_METHOD_CREDIT_CARD = 'credit_card';
    const PAYMENT_METHOD_PAYPAL = 'paypal';
    const PAYMENT_METHOD_BANK_TRANSFER = 'bank_transfer';
    // Enum values for payment_method


    // Enum values for payment_status
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_FAILED = 'failed';
    // Enum values for payment_status
    /**
     * Get the list of valid statuses.
     *
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_PROCESSING,
            self::STATUS_SHIPPING,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELLED,
        ];
    }

    /**
     * Get the list of valid payment methods.
     *
     * @return array
     */
    public static function getPaymentMethods()
    {
        return [
            self::PAYMENT_METHOD_CASH,
            self::PAYMENT_METHOD_CREDIT_CARD,
            self::PAYMENT_METHOD_PAYPAL,
            self::PAYMENT_METHOD_BANK_TRANSFER,
        ];
    }

    /**
     * Get the list of valid payment statuses.
     *
     * @return array
     */
    public static function getPaymentStatuses()
    {
        return [
            self::PAYMENT_STATUS_PAID,
            self::PAYMENT_STATUS_PENDING,
            self::PAYMENT_STATUS_FAILED,
        ];
    }

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userPayment()
    {
        return $this->belongsTo(UserPayment::class);
    }
    public function items()
    {
        return $this->belongsToMany(Item::class, 'order_items')->withPivot('quantity', 'price');
    }
    public function orderHistories()
    {
        return $this->hasMany(OrderHistory::class);
    }
    /**
     * Get the shipping information associated with the order.
     */
    public function shippingInformation()
    {
        return $this->hasOne(OrderShippingInformation::class);
    }
}
