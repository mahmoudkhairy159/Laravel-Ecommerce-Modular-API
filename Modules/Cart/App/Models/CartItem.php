<?php

namespace Modules\Cart\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Item\App\Models\Item;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'item_id', 'quantity'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
