<?php

namespace Modules\Order\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'amount', 'percentage', 'expires_at', 'usage_limit', 'used_count'
    ];

    public function isValid()
    {
        return $this->expires_at && $this->expires_at->isFuture() &&
               (!$this->usage_limit || $this->used_count < $this->usage_limit);
    }
}
