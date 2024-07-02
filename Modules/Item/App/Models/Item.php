<?php

namespace Modules\Item\App\Models;

use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Item\Database\factories\ItemFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Modules\Admin\App\Models\Admin;
use Modules\Brand\App\Models\Brand;
use Modules\Cart\App\Models\CartItem;
use Modules\Category\App\Models\Category;
use Modules\Item\App\Filters\ItemFilter;
use Modules\Order\App\Models\Order;

class Item extends Model implements TranslatableContract
{
    use HasFactory, Translatable,UploadFileTrait;
    public $translatedAttributes = ['name', 'short_description', 'description'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'image',
        'discount',
        'price',
        'brand_id',
        'category_id',
        'rank',
        'status',
        'created_by',
        'updated_by'
    ];
    //status
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    //status
    //image
    const FILES_DIRECTORY = 'items';

    protected $appends = ['image_url'];
    protected function getImageUrlAttribute()
    {
        return $this->image ? $this->getFileAttribute($this->image) : null;
    }
    //image
    public function modelFilter()
    {
        return $this->provideFilter(ItemFilter::class);
    }
    protected static function newFactory(): ItemFactory
    {
        return ItemFactory::new();
    }

    //relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function itemImages()
    {
        return $this->hasMany(ItemImage::class);
    }
     // Define the related items relationship
     public function relatedItems()
     {
         return $this->belongsToMany(Item::class, 'related_items', 'item_id', 'related_item_id');
     }
     public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')->withPivot('quantity', 'price');
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
    //relationships

}
