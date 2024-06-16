<?php

namespace Modules\Area\App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Area\App\Filters\CityFilter;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\App\Models\Admin;
use Modules\User\App\Models\User;

class City extends Model implements TranslatableContract
{
    use HasFactory, Filterable, Translatable,SoftDeletes;

    public $translatedAttributes = ['name', 'description'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'status',
        'created_by',
        'updated_by',
        'country_id'
    ];
    //status
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    //status
    public function modelFilter()
    {
        return $this->provideFilter(CityFilter::class);
    }

    protected $table = 'cities';
    /**
     * Get the role that owns the admin.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'city_id');
    }
}
