<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
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
        $this->middleware(['permission:Read_booking|Update_booking']);
    
    }
    
    public function index()
    {

        $freeCars = DB::table('cars')->where('status',true)->get();
        $freeDrivers = DB::table('drivers')->where('status',true)->get();

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
        $pendings = DB::table('bookings')->where('approval',null)->orderByDesc('pickup_time')->paginate(5);
       
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
       $x=0;
        $pickup_time = $request->input('pickup_time');
        $return_time = $request->input('return_time');
        $count = $request->input('count');
        $description = $request->input('description');
        $destination = $request->input('destination');   
        $created_at = now(); $updated_at = now();
        
        $bookings = DB::table('bookings')->where('user_id',$user_id)->get();
        
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
            $bookingArray = array();
            foreach ($bookings as $data) {
                $x++; 
                if(
                    $data->user_id == $user_id &&$data->pickup_time ==$pickup_time &&$data->return_time ==$return_time
                 && $data->count ==$count &&$data->destination ==$destination){
                     return "DUPLICATE";
                     if(App::getLocale()=='fa'){
                        $bookingArray[$x]= "رزرویشن با این مشخصات انجام گردیده است.";
                     }else{
                        $bookingArray[$x]= "This booking has already been taken";
                     }
                    
                 }
            }
    
            try{
             
                DB::statement(DB::raw("INSERT INTO bookings (booking_id,pickup_time,return_time,count,description,destination
                ,user_id,created_at,updated_at)
                 values (
                     DEFAULT,'$pickup_time','$return_time',$count,'$description','$destination',$user_id,now(),now()
                     )
                     "));
                    if(App::getLocale()=='fa'){
                        return "رزرو شما موفقانه ثبت گردید";
                    }
                return "ُSuccessfully your booking saved";
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
             if(App::getLocale()=='fa'){
              return "رزرو را رد نمودید";   
             }
             return "you have rejected the booking";

        }   catch(QueryException $e){
            return $e->getMessage();
        }
       
       }else{
       
        if($approval == true || $approval =="true"|| $approval === true){
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
                    if(App::getLocale()=='fa'){
                        return "موفقانه تصویب گردید.";
                    }
                     return "successfully approved";
                 }
                catch(QueryException $e){
                    return $ex->getMessage();
                }
            }
    }
    }
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
