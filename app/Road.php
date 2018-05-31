<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Road extends Model
{
	//protected $connection = 'mysql2';
	
	public $timestamps = false;

    protected $table = 'Roads';


    protected $fillable = [
		'id_local', 'update', 'sync_id', 'is_updated',
		 'oneway', 'street_number', 'road_reference',
		 'update_date', 'sync_date', 
		'user', 'name', 'speed', 'sub_type', 'provincia',
		 'longitude', 'latitude', 'type'
    ];
}

