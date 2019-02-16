<?php

namespace App\Http\Controllers;
use DB;
use App\booking;
use App\bookVehical;
use Validator;
use Illuminate\Http\Request;
use illuminate\Http\QueryException;

class bookVehicalController extends Controller

{
    public function index(){
        $rows = DB::table('bookVehicals')->get();
        return view('bookings/book vehical')->with('rows',$rows);
       
    }
    //
    public function sendData(Request $request){
      
        $destination= $request->input('destination');
        $description= $request->input('description');
        $pickup_time = $request->input('pickup_time');
        $return_time = $request->input('return_time');
        $count = $request->input('count');
        
         try { 
            
            DB::table('bookVehicals')->insert(
                ['pickup_time' => $pickup_time, 'return_time' => $return_time, 'user_id' =>1,
                'count'=>$count,'destination' =>$destination,'description'=>$description]
                    );
                        return "your request for car is wait for approval of admin ";
                    }
                 catch(QueryException $ex){ 
                      print($ex->getMessage()); 
                    }
    }
    

}
