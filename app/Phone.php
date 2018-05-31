<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    public function register()
    {
        return $this->belongsTo('App\Register');
    }
}
