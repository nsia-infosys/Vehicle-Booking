<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
	protected $primaryKey = "booking_id";
 protected $fillable=[
 	'start_time','end_time', 'destination', 'user_id','car_id', 'driver_id'
 ];
    
}
