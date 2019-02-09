<?php

namespace App\Http\Controllers;
use DB;
use App\booking;
use Validator;
use Illuminate\Http\Request;
use illuminate\Http\QueryException;

class book_a_car extends Controller
{
    //
    public function sendData(Request $request){
    // return $request->input('destination') . " " .$request->input('pickup_time') . " " .$request->input('return_time') . " " .$request->input('list_of_persons') . " " .$request->input('open_drivers') . " " .$request->input('open_cars'); 

        $destination= $request->input('destination');
        $pickup_time = $request->input('pickup_time');
        $return_time = $request->input('return_time');
        $list_of_persons = $request->input('list_of_persons');
        $open_drivers = $request->input('open_drivers');
        $open_cars =$request->input('open_cars');

        // $request->input('user_id') = 1;

        
         try { 
            
            DB::table('bookings')->insert(
                ['start_time' => $pickup_time, 'end_time' => $return_time, 'user_id' =>1,
                'list_of_persons'=>$list_of_persons,'destination' =>$destination,'driver_id'=>$open_drivers,
                'car_id'=>$open_cars,'approval'=>true]
                    );

                        $id = DB::getPdo()->lastInsertId();
                        return "your request for car is wait for approval of admin ";
                    }
                 catch(QueryException $ex){ 
                      print($ex->getMessage()); 
                    }
    }
    public function driversData(Request $request){
    $cars = DB::table('cars')->pluck('type');
    return $cars;
    
    }

}
