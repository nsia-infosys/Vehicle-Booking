<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
	protected $primaryKey = "booking_id";
 protected $fillable=[
 	'start_time','end_time', 'destination', 'user_id','car_id', 'driver_id'
 ];
 protected $date = ['pickup_time','return_time','approval_pickup_time','approval_return_time','created_at', 'updated_at'];
    
}
