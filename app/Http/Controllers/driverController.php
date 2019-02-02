<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $driversData = DB::table('drivers')->orderBy('driver_id','des')->get();
        $dataCounts =  DB::table('drivers')->count();
        return view('/drivers/index')->with(compact('driversData','dataCounts'));
    }
    public function searchDriver(Request $request){
        
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
            if($data->status === false){$data->status = 'False';}else{$data->status='True';}
            echo "<tr><td><b>". $data->driver_id . "</b></td>" .
                 "<td>" . $data->name . "</td>".
                 "<td>" . $data->father_name . "</td>".
                 "<td>" . $data->phone_no . "</td>" .
                 "<td>" . $data->status . "</td>" .
                 "<td>" . $data->created_at . "</td>" .
                 "<td class='Af'>" . $data->updated_at . "</td>" .
                 "<td><a href='/drivers/$data->driver_id' id='$data->driver_id' class='btn btn-primary updateBtn'>Update</a></td>      
                 <td><a href='drivers/$data->driver_id' id='$data->driver_id' class='deleteBtn btn btn-danger'>Delete </button></td>
                 </tr>";
             }}else{return "<tr><td colspan='8'><div class='card bg-light text-dark'><div class='card-body text-center' id='notFound'><h1>Data not found!</h1></div></div></td></tr>";}
      
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
      $data = DB::table('drivers')->where('driver_id',$id)->first();
      if($data->status == 1){$data->status = "True";}else{$data->status="False";}
    
    $row = "<tr><td><b>".$data->driver_id."</b></td><td>" . $data->name ."</td><td>" . $data->father_name ."</td><td>"
                .$data->phone_no."</td><td>".$data->status."</td><td>".$data->created_at."</td><td>".$data->updated_at."</td><td><a href='/drivers/"
                .$data->driver_id ."' id='".$data->driver_id."'class='btn btn-primary updateBtn' >Update</a></td><td><a a href='/drivers/"
                .$data->driver_id ."' id='".$data->driver_id. "'class='btn btn-danger deleteBtn'>Delete </button></td></td></tr>";
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
        if($name == $data['name'] && $father_name ==$data['father_name'] && $phone_no ==
         $data['phone_no']&& $status ==$data['status'])
        {
            $responseErr = "There is nothing for update, please enter new things into field/fields";
            return $responseErr;
        }else{
             if(!($data['phone_no']==$phone_no)){
                $phCount = DB::table('drivers')->where('phone_no',$phone_no)->count();
                if($phCount>0){
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

        $dataId = DB::table("drivers")->where('driver_id',$id)->first();
        $deleteId = DB::table('drivers')->where('driver_id',$id)->delete();
        if($deleteId ===1){
        $result = "driver with ID: " .$dataId->driver_id. " successfully deleted from table";
        return $result; }
        else{
            return "Deletion not occured";
        }
        
    }
    
}
