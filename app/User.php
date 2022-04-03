<?php

namespace App;

<<<<<<< HEAD
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
>>>>>>> 0c61f56 (Ramonda Ecommerce (new) fixed bugs)
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
<<<<<<< HEAD
=======
    use HasRoles;
>>>>>>> 0c61f56 (Ramonda Ecommerce (new) fixed bugs)

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

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


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


//    public function posts()
//    {
//        return $this->hasMany(Post::class, 'user_id', 'id');
//    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)
            ->withPivot('created_at');
    }


<<<<<<< HEAD
    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_user', 'user_id', 'role_id')->withPivot('created_at');
    }

    public function role()
    {
        foreach (auth()->user()->roles as $role) {
            return $role;
        }
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return false;
            }
        }
        return false;
    }


    public function hasRole($role_name)
    {
        if ($this->roles->where('slug', $role_name)->first()) {
            return true;
        }
        return false;
    }
=======
    // public function roles()
    // {
    //     return $this->belongsToMany(
    //         Role::class,
    //         'role_user', 'user_id', 'role_id')->withPivot('created_at');
    // }

    // public function role()
    // {
    //     foreach (auth()->user()->roles as $role) {
    //         return $role;
    //     }
    // }

    // public function hasAnyRole($roles)
    // {
    //     if (is_array($roles)) {
    //         foreach ($roles as $role) {
    //             if ($this->hasRole($role)) {
    //                 return true;
    //             }
    //         }
    //     } else {
    //         if ($this->hasRole($roles)) {
    //             return false;
    //         }
    //     }
    //     return false;
    // }


    // public function hasRole($role_name)
    // {
    //     if ($this->roles->where('slug', $role_name)->first()) {
    //         return true;
    //     }
    //     return false;
    // }
>>>>>>> 0c61f56 (Ramonda Ecommerce (new) fixed bugs)


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


<<<<<<< HEAD

//    public function comments()
//    {
//        return $this->morphMany(Comment::class, 'commentable');
//    }


    public function getIsAdminAttribute(): bool
    {
        return $this->roles()->where('role_id', 1)->exists();
=======
    public function getIsAdminAttribute(): bool
    {
        return $this->hasRole('Admin');
>>>>>>> 0c61f56 (Ramonda Ecommerce (new) fixed bugs)
    }

    public function getGravatarAttribute()
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash";
    }
}
