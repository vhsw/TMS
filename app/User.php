<?php 

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'users_roles');
    }

    public function hasRole($role)
    {
        return in_array($role, array_fetch($this->roles->toArray(), 'name'));
    }



    public function requests()
    {
        return $this->hasMany('App\Models\Requests');
    }

    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function newNotification()
    {
        $notification = new Notification;
        $notification->user()->associate($this);
 
        return $notification;
    }
}
