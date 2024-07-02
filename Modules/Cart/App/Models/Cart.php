<?php

namespace Modules\Cart\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cart\Database\factories\CartFactory;
use Modules\User\App\Models\User;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
