<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'users_roles');
    }

    public function hasRole($role)
    {
        return in_array($role, array_flatten($this->roles->toArray(), 'name'));
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
        $notification = new Models\Notification;
        $notification->user()->associate($this);
 
        return $notification;
    }
}
