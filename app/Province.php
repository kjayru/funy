<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    
    public function markers(){
        return $this->hasOne('App\Marker');
    }
}
