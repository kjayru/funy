<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }

    public function dayhours()
    {
        return $this->hasMany('App\Dayhour');
    }

    public function vacations()
    {
        return $this->hasMany('App\Vacation');
    }

    public function requirements()
    {
        return $this->hasMany('App\Requirement');
    }
}
