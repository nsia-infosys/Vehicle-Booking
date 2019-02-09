<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class car extends Model
{
	protected $primaryKey = 'car_id';
	 protected $fillable = [
        'plate_no', 'color', 'type','model','status','driver_id'
    ];

    
	 public function driver(){
	 	return $this->hasOne('App\driver');
	 }
 
}
