<?php

namespace Modules\Review\App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Item\App\Models\Item;
use Modules\Review\App\Filters\ReviewFilter;
use Modules\User\App\Models\User;

class Review extends Model
{
    use HasFactory,Filterable,SoftDeletes;
    protected $fillable = ['comment', 'rate','user_id', 'thought_id','status'];
    public function modelFilter()
    {
        return $this->provideFilter( ReviewFilter::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
