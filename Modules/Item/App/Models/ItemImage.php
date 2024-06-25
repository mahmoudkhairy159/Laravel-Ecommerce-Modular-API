<?php

namespace Modules\Item\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\App\Models\Admin;

class ItemImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'image',
    ];
    //image
    const FILES_DIRECTORY = 'item_images';
    public $timestamps=false;

    protected $appends = ['image_url'];
    protected function getImageUrlAttribute()
    {
        return $this->image ? $this->getFileAttribute($this->image) : null;
    }
    //image

    //relationships
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    //relationships


}
