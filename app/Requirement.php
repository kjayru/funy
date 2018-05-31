<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }
}
