<?php

namespace Modules\Payment\App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\App\Models\Admin;
use Modules\Payment\App\Filters\UserPaymentFilter;
use Modules\Payment\Database\factories\UserPaymentFactory;
use Modules\User\App\Models\User;

class UserPayment extends Model
{
    use HasFactory, Filterable;


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'name',
        'card_type',
        'card_number',
        'status',
        'active',
        'created_by',
        'updated_by',
    ];

    public $timestamps = false;
    public function modelFilter()
    {
        return $this->provideFilter(UserPaymentFilter::class);
    }
    protected static function newFactory()
    {
        return UserPaymentFactory::new();
    }
    //status
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    //status

//active
const ACTIVE = 1;
const INACTIVE = 0;
//active
    /*******************relationships********************/

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    /*******************end relationships********************/
}
