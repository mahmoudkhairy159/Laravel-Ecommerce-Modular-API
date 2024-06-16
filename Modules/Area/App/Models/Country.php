<?php

namespace Modules\Area\App\Models;

use Astrotomic\Translatable\Translatable;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Area\App\Filters\CountryFilter;
use Modules\Area\Database\factories\CountryFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\App\Models\Admin;
use Modules\User\App\Models\User;

class Country extends Model implements TranslatableContract
{
    use HasFactory, Translatable, Filterable,SoftDeletes;
    
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
        'updated_by'
    ];
    //status
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    //status

    public function modelFilter()
    {
        return $this->provideFilter(CountryFilter::class);
    }

    protected $table = 'countries';
    /**
     * Get the role that owns the admin.
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }
    public function users()
    {
        return $this->hasMany(User::class, 'country_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
