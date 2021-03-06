<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use Validator;
use Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\driver;
use DB;


class driverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
// protected $redirectTo = '/drivers';
    public function __construct(){
        $this->middleware('auth');
        $this->middleware(['permission:Read_driver_car|Update_driver_car|Create_driver_car']);
    }
    public function index()
    {
        $driversData = DB::table('drivers')->orderBy('driver_id','des')->paginate(5);
        $dataCounts =  DB::table('drivers')->count();
        
        return view('/drivers/index')->with(compact('driversData','dataCounts'));
    }
    public function searchDriver(Request $request){
        if(App::getLocale()=='fa'){
            $update = 'تجدید';
            $notFound = 'به این مشخصات معلوماتی وجود ندارد';
        }else{
            $update = 'Update';
            $notFound = 'Data not found!';
        }
        
      $searchOn = $request->input('searchon');
      $searchInput= $request->input('searchInp');

        if($searchOn == "id"){
        $dataArray = DB::table('drivers')->where("driver_id",'LIKE',"%$searchInput%")->get();
        $dataCount = DB::table('drivers')->where("driver_id",'LIKE',"%$searchInput%")->count();}

        if($searchOn == "name"){
        $dataArray = DB::table('drivers')->where("name",'LIKE',"%$searchInput%")->get();
        $dataCount = DB::table('drivers')->where("name",'LIKE',"%$searchInput%")->count();}

        if($searchOn == "father_name"){
        $dataArray = DB::table('drivers')->where("father_name",'LIKE',"%$searchInput%")->get();
        $dataCount = DB::table('drivers')->where("father_name",'LIKE',"%$searchInput%")->count();}

        if($searchOn == "phone_no"){
        $dataArray = DB::table('drivers')->where("phone_no",'LIKE',"%$searchInput%")->get();
        $dataCount = DB::table('drivers')->where("phone_no",'LIKE',"%$searchInput%")->count();}

        if($searchOn == "status"){
            if($searchInput == 'a'){$searchInput = str_replace('a', false, false);}
        $dataArray = DB::table('drivers')->where("status",'LIKE',"%$searchInput%")->get();
        $dataCount = DB::table('drivers')->where("status",'LIKE',"%$searchInput%")->count();}
        if($dataCount >0 ){
            
        foreach ($dataArray as $data) {
            if($data->status === false){$data->status = 'false';}else{$data->status='true';}
            if(App::getLocale()=='fa'){$update = "تجدید";}else{$update = 'Update';}
            echo "<tr><td><b>". $data->driver_id . "</b></td>" .
                 "<td>" . $data->name . "</td>".
                 "<td>" . $data->father_name . "</td>".
                 "<td>" . $data->phone_no . "</td>" .
                 "<td>" . $data->status . "</td>" .
                 "<td>" . $data->created_at . "</td>" .
                 "<td class='Af'>" . $data->updated_at . "</td>" .
                 "<td><a href='/drivers/$data->driver_id' id='$data->driver_id' class='btn btn-primary btn-sm updateBtn'>$update</a></td>      
                 
                 </tr>";
             }}else{return "<tr><td colspan='8'><div class='card bg-light text-dark'><div class='card-body text-center' id='notFound'><h1>$notFound</h1></div></div></td></tr>";}
      
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
        $name = $request->input('name');
        $father_name = $request->input('father_name');
        $phone_no = $request->input('phone_no');
        $rules = array(
                'name' => 'required|max:45|string|min:3',
                'father_name' => 'required|string|min:3|max:45',
                'phone_no' => 'required|regex:/^07[0-9]{8}/|unique:drivers',
                'status' => 'required');
                
        $validator = Validator::make($request->all(),$rules);
                
                if($validator->fails()){
                   
                       return $validator->errors()->toArray();
                       
                }
                else{
                             Driver::create($request->all());
                             $id = DB::getPdo()->lastInsertId();
                             return 'successfully done: '. $id;
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
        if(App::getLocale()=='fa'){
            $update = 'تجدید';
        }else{
            $update = 'Update';
        }
      $data = DB::table('drivers')->where('driver_id',$id)->first();
      if($data->status == 1){$data->status = 'true';}else{$data->status='false';}
    
    $row = "<tr><td><b>".$data->driver_id."</b></td><td>" . $data->name ."</td><td>" . $data->father_name ."</td><td>"
                .$data->phone_no."</td><td>".$data->status."</td><td>".$data->created_at."</td><td>".$data->updated_at."</td><td><a href='/drivers/"
                .$data->driver_id ."' id='".$data->driver_id."'class='btn btn-primary updateBtn btn-sm' >$update</a></td></tr>";
     // return json_encode($data);
     return $row;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $data = Driver::find($id);
        return $data;
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
        $id;
        $data = $this->edit($id);
        $name = $request->input('driver_name');
        $father_name = $request->input('driver_father_name');
        $phone_no = $request->input('driver_phone_no');
        $status = $request->input('driver_status');
     
        if($name == $data['name'] && $father_name ==$data['father_name'] &&
         $phone_no == $data['phone_no'] && $status ===$data['status'])
        {
            $responseErr = "There is nothing for update, please enter new things into field/fields";
            return $responseErr;
        }else{
             if(!($data['phone_no']==$phone_no)){
                $phCount = DB::table('drivers')->where('phone_no',$phone_no)->count();
                if($phCount>0){
                    if(App::getLocale()=='fa'){
                        return "این شماره مربوط راننده دیگر می باشد.";
                    }
                    return "the phone no has already been taken";
                }
            }
        $rules = array(
                        'driver_name' => 'required|max:45|string|min:3',
                        'driver_father_name' => 'required|string|min:3|max:45',
                        'driver_status' => 'required',
                        'driver_phone_no' => "required|max:10|regex:/^07[0-9]{8,8}/"
                    );
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                return $validator->errors()->toArray();
            }
                try { 
                     $update = DB::table('drivers')->where('driver_id',$id)
                    ->update(['name'=>$name,'father_name'=>$father_name,'phone_no'=>$phone_no,'status'=>$status]);
                        return "successfully updated";
                    }
                 catch(QueryException $ex){ 
                      print($ex->getMessage()); 
                    }
            }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $yesOrNo)
    {

        // $dataId = DB::table("drivers")->where('driver_id',$id)->first();
        // $deleteId = DB::table('drivers')->where('driver_id',$id)->delete();
        // if($deleteId ===1){
        // $result = "driver with ID: " .$dataId->driver_id. " successfully deleted from table";
        // return $result; }
        // else{
        //     return "Deletion not occured";
        // }
        
    }
    
}
