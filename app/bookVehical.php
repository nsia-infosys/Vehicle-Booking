<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bookVehical extends Model
{
    //
   protected $fillable = ['pickup_time','return_time', 'destination','description'];
}
