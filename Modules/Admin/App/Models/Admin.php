<?php

namespace Modules\Admin\App\Models;

use App\Traits\UploadFileTrait;
use EloquentFilter\Filterable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\App\Filters\AdminFilter;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;
    use Filterable;
    use UploadFileTrait;

    const FILES_DIRECTORY = 'admins';

    public function modelFilter()
    {
        return $this->provideFilter(AdminFilter::class);
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
    protected $table = 'admins';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'image',
        'password',
        'role_id',
        'status',
        'blocked',
        'password_updated_at',
        'created_by',
        'updated_by'
    ];
    //status
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    //status
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends = ['image_url'];
    //image
    protected function getImageUrlAttribute()
    {
        return $this->image ? $this->getFileAttribute($this->image) : null;
    }
    //Mutators
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    //Mutators
    /**
     * Get the role that owns the admin.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function permissions()
    {
        return collect($this->role->permissions);
    }

    public function hasPermission($permission)
    {
        if ($this->role->permission_type == Role::PERMISSION_TYPE_ALL) {
            return true;
        }
        if ($this->role->permission_type == Role::PERMISSION_TYPE_CUSTOM && !$this->role->permissions) {
            return false;
        }
        if (in_array($permission, $this->role->permissions)) {
            return true;
        }
        return false;
    }

    /********************************Relationships*************************************/

    /********************************EndRelationships*********************************/

}
