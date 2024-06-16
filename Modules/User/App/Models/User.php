<?php

namespace Modules\User\App\Models;

use App\Traits\UploadFileTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Modules\User\App\Filters\UserFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Modules\Area\App\Models\City;
use Modules\Area\App\Models\Country;
use Modules\User\Database\Factories\UserFactory;


class User extends Authenticatable implements JWTSubject, MustVerifyEmail

{
    use HasFactory;
    use Notifiable;
    use Filterable;
    use UploadFileTrait;
    use Sluggable;


    const FILES_DIRECTORY = 'users';

    public function modelFilter()
    {
        return $this->provideFilter(UserFilter::class);
    }
    /**
     * The attributes that are mass assignable.
     */
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $table = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'password',
        'image',
        'address',
        'country_id',
        'city_id',
        'status',
        'active',
        'blocked',
        'password_updated_at',
        'created_by',
        'updated_by',
        'last_login_at'
    ];
    //slug
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name', 'id'],
                'separator' => '-',
            ],
        ];
    }
    //slug
    protected $appends = ['image_url'];
    //image
    protected function getImageUrlAttribute()
    {
        return $this->image ? $this->getFileAttribute($this->image) : null;
    }
    //image
    //status
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    //status
    //active
    const ACTIVE = 1;
    const INACTIVE = 0;
    //active
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    protected static function newFactory()
    {
        return UserFactory::new();
    }
    //Mutators
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    //Mutators

    /*******************relationships********************/
    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    // otp

    public function otps()
    {
        return $this->hasMany(UserOTP::class, 'user_id');
    }
    /******************* end relationships********************/

}
