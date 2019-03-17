<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\booking;
use DB;
use Response;
use illuminate\Http\QueryException;
use Validator;
class bookingController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        
        $this->middleware('auth');
    }
    public function index()
    {

        $freeCars = DB::table('cars')->get();
        $freeDrivers = DB::table('drivers')->get();

        $approvedCount = DB::table('bookings')->where('approval',true)->count();
        $rejectedCount = DB::table('bookings')->where('approval',false)->wherenotnull('approver_description')->count();
        $pendingsCount = DB::table('bookings')->wherenull('approval')->wherenull('approver_description')->count();
        $bookingsData = Booking::orderByDesc('pickup_time')->paginate(4);
        return view('/bookings/index')->with(['bookingsData'=>$bookingsData,'approvedCount'=>$approvedCount
        ,'rejectedCount'=>$rejectedCount,'pendingsCount'=>$pendingsCount,'freeCars'=>$freeCars,'freeDrivers'=>$freeDrivers]);

    }
    public function pendings(){
        $freeCars = DB::table('cars')->where('status',true)->get();

        $freeDrivers = DB::table('drivers')->where('status',true)->get();

        $countPendings = DB::table('bookings')->where("approval",null)->count();
        $pendings = DB::table('bookings')->where('approval',null)->paginate(5);
       
        return view('/bookings/pendings')->with(['pendings'=>$pendings,"countPendings"=>$countPendings,
        'freeDrivers'=>$freeDrivers,'freeCars'=>$freeCars]);
    }
    public function reject(Request $request){
        $insertQuery = DB::table('bookings')->insert(['pickup_time'=>$request->input('pickup_time'),
        'return_time'=>$request->input('return_time'),'count'=>$request->input('count'),
            'description'=>$request->input('description'),'destination'=>$request->input('destination'),'approval'=>false,'driver_id'=>null,'plate_no'=>null,
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
        $user_id =$request->input('user_id');
       
        $pickup_time = $request->input('pickup_time');
        $return_time = $request->input('return_time');
        $count = $request->input('count');
        $description = $request->input('description');
        $destination = $request->input('destination');   
        $created_at = now(); $updated_at = now();
        $rules = array('pickup_time'=>'date|required',
        'return_time'=>'after:pickup_time|date|required',
        'count'=>'numeric|min:1',
        'description'=>'string|min:10',
        'destination'=>'string|min:5');
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return $validator->errors()->toArray();
        }
        else{
         try{
             
                DB::statement(DB::raw("INSERT INTO bookings (booking_id,pickup_time,return_time,count,description,destination
                ,user_id,created_at,updated_at)
                 values (
                     DEFAULT,'$pickup_time','$return_time',$count,'$description','$destination',$user_id,now(),now()
                     )
                     "));
                    
                return "Your booking is wait for response";
        }catch(QueryException $e){
            return $e->getMessage();
        }
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
        
        $bookings = Booking::find($id);
        $pickup_to_dateTime = strtotime($bookings->pickup_time);
        $return_to_dateTime = strtotime($bookings->return_time);
        $p_newformat = date('Y/m/d H:i:m',$pickup_to_dateTime);
        $r_newformat = date('Y/m/d H:i:m',$return_to_dateTime);
        
        
        $bookings->pickup_time = $p_newformat;
        $bookings->return_time = $r_newformat;
       return $bookings;

    //     if (\Illuminate\Support\Facades\Request::ajax()) {
            
    //        return Response::json(array('bookings'=>$bookings));}   
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
        
        $app_user_id = Auth::user()->id;
       
        $booking_id = $id;
        $approval = $request->input('approval');
       $approval_pickup_time =  $request->input('approval_pickup_time');
       $approval_return_time =  $request->input('approval_return_time');
       $driver_id =  $request->input('driver_id');
       $plate_no =  $request->input('plate_no');
       $approver_description =  $request->input('approver_description');
        

       if($approval===false||$approval==false||$approval=="false"){
        try{
            DB::statement(DB::raw("update bookings set approval = $approval, approver_description =
             '$approver_description',approver_user_id=$app_user_id,updated_at=now() where booking_id = $id"));
             return "you have rejected";

        }   catch(QueryException $e){
            return $e->getMessage();
        }
       
       }else{
       
        if($approval == true || $approval =="true"|| $approval ===true){
            $rules = array(
                'approval_pickup_time' => 'required|date',
                'approval_return_time' => 'required|date|after:approval_pickup_time',
                'driver_id' => 'required',
                'plate_no' => 'required',
            );
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                return $validator->errors()->toArray();
            }
            else{
                try{
                    DB::statement(DB::raw("update bookings set plate_no=$plate_no, approval =$approval,approval_pickup_time='$approval_pickup_time'
                    ,approval_return_time='$approval_return_time',driver_id=$driver_id,approver_description = '$approver_description',approver_user_id=$app_user_id,
                    updated_at=now() where 
                    booking_id=$id"));
                     return "successfully approved";
                 }
                catch(QueryException $e){
                    return $ex->getMessage();
                }
            }

      
    }
    }
    //    if($approval){
    //        return "Null Value";
    //    }
        // if(empty($request->input('approval')) || $request->input('approval')==null || $request->input('approval')==""
        // || $request->input('approval')=="null"){
        //     $approval_pickup_time = null;  $approval_return_time = null; $driver_id = null; $car_id =null;$approver_description =null;
        // $rules = array("approval_pickup_time"=>"required|date_format:Y-m-d H:i:s",
        // "approval_return_time"=>"date_format:Y-m-d H:i:s");
        // return $request->all();
        // die();
        // }
        // return $approval;
        // $validator = Validator::make($request->all(), $rules);
        // if($validator->fails()){
        //     return $validator->errors()->toArray();
        // }
        // else{
        //     return "There is no Error";
        // }
        
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
    public function freeCar(Request $request){
        $pickup_time = $request->input('pickup_time');
        
        $pick_time_plate= DB::select(DB::raw("SELECT plate_no FROM bookings where
        approval_return_time < '$pickup_time'"));
        $x=0;
           foreach ($pick_time_plate as  $value) {
             $freeCar[$x] = $value->plate_no;
             $x++;
           }
           return $pick_time_plate;

    }
    public function freeDriver(Request $request){
        $pickup_time = $request->input('pickup_time');
     

        $pick_time_driver= DB::select(DB::raw("SELECT driver_id FROM bookings where
        approval_return_time < '$pickup_time'"));
        $x=0;
           foreach ($pick_time_driver as  $value) {
             $freeDriver[$x] = $value->driver_id;
             $x++;
           }
           return $pick_time_driver;
    }
}
