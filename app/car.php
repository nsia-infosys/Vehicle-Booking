<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class car extends Model
{
	protected $primaryKey = 'plate_no';
	 protected $fillable = [
        'plate_no', 'color', 'type','model','status','driver_id'
	];
	
	protected $dates = ['created_at', 'updated_at'];

    
	 public function driver(){
	 	return $this->hasOne('App\driver');
	 }
 
}
