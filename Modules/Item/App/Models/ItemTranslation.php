<?php

namespace Modules\Item\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Item\Database\factories\ItemTranslationFactory;

class ItemTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'short_description', 'description'];
    public $timestamps = false;

}
