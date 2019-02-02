<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class insertDataController extends Controller
{
    //
    public function insertData(){

    $car = new Car;

    $car->plate_no = Input::get('plate_no');
    $car->color = Input::get('color');
    $car->model = Input::get('model');
    $car->type = Input::get('type');
    $car->status = Input::get('status');
    $car->save();

    return Redirect::back();
	}
	public function insertCarPage(){
		
		insertData();
	}
}

