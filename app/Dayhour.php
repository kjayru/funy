<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dayhour extends Model
{
    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }
}
