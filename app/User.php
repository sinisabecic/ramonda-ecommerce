<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

//use Laravel\Sanctum\HasApiTokens; //? Only for Sanctum
//? Only for Passport
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles, HasApiTokens;

    protected $table = 'users';
    protected $guarded = [];
    protected $dates = ['deleted_at'];
//    protected $guard_name = 'web'; // If there is problem on api requests

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function needsCommentApproval($model): bool
    {
        return true;
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('last_name')->orderBy('first_name');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::needsRehash($password) ?
            Hash::make($password) :
            $password;
//        $this->attributes['password'] = Hash::make($password);
    }


    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }


    public function photo()
    {
        return $this->morphOne(Photo::class, 'imageable');
    }


    function avatar()
    {
        return env('APP_URL') . '/storage/files/1/Avatars/' . $this->id . '/' . $this->photo->url ?
            env('APP_URL') . '/storage/files/1/Avatars/' . $this->id . '/' . $this->photo->url :
            env('DEFAULT_AVATAR');
    }


    public function getIsAdminAttribute(): bool
    {
        return $this->hasRole('Admin');
    }


    public function getGravatarAttribute()
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash";
    }
}
