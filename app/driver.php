<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class driver extends Model
{
	protected $table = "drivers";
	protected $primaryKey = 'driver_id';
	 protected $fillable = ['name', 'phone_no', 'father_name','status'];
   // public function car(){
   // 		return $this->belongsTo('App\driver');
   //  }
}
