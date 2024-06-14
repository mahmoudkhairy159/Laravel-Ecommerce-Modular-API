<?php

namespace Modules\Category\App\Models;

use App\Traits\UploadFileTrait;
use Astrotomic\Translatable\Translatable;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\App\Models\Admin;
use Modules\Category\App\Filters\CategoryFilter;

class Category extends Model implements TranslatableContract
{
    use HasFactory, Translatable, Filterable,UploadFileTrait,SoftDeletes;
    public $translatedAttributes = ['name', 'description'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'code',
        'created_by',
        'updated_by',
        'status',

    ];
//image
const FILES_DIRECTORY = 'categories';

protected $appends = ['image_url'];
protected function getImageUrlAttribute()
{
    return $this->image ? $this->getFileAttribute($this->image) : null;
}
//image
    //status
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    //status
    public function modelFilter()
    {
        return $this->provideFilter(CategoryFilter::class);
    }

    protected $table = 'categories';

/**************************Relationships************************************* */
    //  public function items()
    //  {
    //      return $this->hasMany(Item::class,'category_id');
    //  }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    /**************************Relationships************************************* */

}
