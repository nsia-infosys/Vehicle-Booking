<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\booking;
use DB;
use illuminate\Http\QueryException;
class bookingController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $rows  = DB::table('bookVehicals')->get();
       $countOfRows = DB::table('bookVehicals')->count();
        // return view('bookings/index')->with('rows',$rows);
        
        $bookingsData = Booking::all();
        return view('/bookings/index')->with(['bookingsData'=>$bookingsData,'rows'=>$rows,'countOfRows'=>$countOfRows]);

    }
    public function reject(Request $request){
        $insertQuery = DB::table('bookings')->insert(['pickup_time'=>$request->input('pickup_time'),
        'return_time'=>$request->input('return_time'),'count'=>$request->input('count'),
            'description'=>$request->input('description'),'destination'=>$request->input('destination'),'approval'=>false,'driver_id'=>null,'car_id'=>null,
            'user_id'=>$request->input('user_id')]);
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bookRows = DB::table('bookVehicals')->get();

        $pickupt_time = $request->input('pickup_time');
        $return_time = $request->input('return_time');
        $count = $request->input('count');
        $description = $request->input('description');
        $destination = $request->input('destination');
        $approval = $request->input('approval');
        $driver_id = $request->input('driver_id');
        $car_id = $request->input('car_id');
        $user_id = $request->input('user_id');
        
        // return $pickupt_time . " " .$return_time . " " .$count . " " .$description . " " .$destination . " " .$driver_id . " " .
        // $car_id . " " .$user_id;

        try{

    //  $insertQuery = Booking::create($request->all());  
    if($request->input('approval')=='false' OR $request->input('approval') === false){
            $insertQuery = DB::table('bookings')->insert(['pickup_time'=>$pickupt_time,'return_time'=>$return_time,'count'=>$count,
            'description'=>$description,'destination'=>$destination,'approval'=>$approval,'driver_id'=>null,'car_id'=>null,
            'user_id'=>$user_id]);
            return "Please select true for approval field";
            }
            else{
                if(!($car_id)||!($driver_id)  || $car_id ==null ||$driver_id ==null){return "driver ID and car ID is required";}
                $insertQuery = DB::table('bookings')->insert(['pickup_time'=>$pickupt_time,'return_time'=>$return_time,'count'=>$count,
            'description'=>$description,'destination'=>$destination,'approval'=>$approval,'driver_id'=>$driver_id,'car_id'=>$car_id,
            'user_id'=>$user_id]);
            $del = DB::table('bookVehicals')->where('pickup_time',$pickupt_time)->where('return_time',$return_time)->where('count',$count)->
            where('destination',$destination)->where('description',$description)->delete();

            return "Approved!" . " driver ID ".$driver_id . " and Car ID: " .$car_id;    
        }
            
    }
    catch(QueryException $ex){
        print_r($ex->getMessage());
    }
       
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
