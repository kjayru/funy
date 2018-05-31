<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\notifications\AdminResetPasswordNotification; 

use Illuminate\Database\Eloquent\Model;
use App\Role;
class Admin extends Authenticatable
{
    //use Notifiable;

    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','lastname', 'email','google_id','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
/**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }


    public function authorizeRoles($roles)
    {
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, 'Esta acción no está autorizada.');
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
                return true;
            }
        }
        return false;
    }
    public function hasRole($role)
    {
       // dd(Role::where('name', $role)->first());
        if (Role::where('name', $role)->first()) {
            return true;
        }
        return false;
    }


    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function registers()
    {
        return $this->hasMany('App\Register');
    }

    public function requirement()
    {
        return $this->hasMany('App\Requirement');
    }
}
