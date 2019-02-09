<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\car;
use DB;
use Validator;
use Illuminate\Database\QueryException;


class carController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $carsData = DB::table('cars')->orderBy('car_id','des')->get();
        $dataCounts =  DB::table('cars')->count();
        return view('/cars/index')->with(compact('carsData','dataCounts'));
    }

    public function searchCar(Request $request){
        
      $searchOn = $request->input('searchon');
      $searchInput= $request->input('searchInp');
        if($searchOn == "car_id"){
        $dataArray = DB::table('cars')->where("car_id",'LIKE',"%$searchInput%")->get();
        $dataCount = DB::table('cars')->where("car_id",'LIKE',"%$searchInput%")->count();}

        if($searchOn == "plate_no"){
        $dataArray = DB::table('cars')->where("plate_no",'LIKE',"%$searchInput%")->get();
        $dataCount = DB::table('cars')->where("plate_no",'LIKE',"%$searchInput%")->count();}

        if($searchOn == "color"){
        $dataArray = DB::table('cars')->where("color",'LIKE',"%$searchInput%")->get();
        $dataCount = DB::table('cars')->where("color",'LIKE',"%$searchInput%")->count();}

        if($searchOn == "model"){
        $dataArray = DB::table('cars')->where("model",'LIKE',"%$searchInput%")->get();
        $dataCount = DB::table('cars')->where("model",'LIKE',"%$searchInput%")->count();}

        if($searchOn == "type"){
        $dataArray = DB::table('cars')->where("type",'LIKE',"%$searchInput%")->get();
        $dataCount = DB::table('cars')->where("type",'LIKE',"%$searchInput%")->count();}

        if($searchOn == "status"){
            if($searchInput == 'a'){$searchInput = str_replace('a', false, false);}
        $dataArray = DB::table('cars')->where("status",'LIKE',"%$searchInput%")->get();
        $dataCount = DB::table('cars')->where("status",'LIKE',"%$searchInput%")->count();}
        if($searchOn == "driver_id"){
        $dataArray = DB::table('cars')->where("driver_id",'LIKE',"%$searchInput%")->get();
        $dataCount = DB::table('cars')->where("driver_id",'LIKE',"%$searchInput%")->count();}
        if($dataCount >0 ){
            
        foreach ($dataArray as $data) {
            if($data->status === false){$data->status = 'False';}else{$data->status='True';}
            echo "<tr><td><b>". $data->car_id . "</b></td>" .
                 "<td>" . $data->plate_no . "</td>".
                 "<td>" . $data->color . "</td>".
                 "<td>" . $data->model . "</td>" .
                 "<td>" . $data->type . "</td>" .
                 "<td>" . $data->status . "</td>" .
                 "<td>" . $data->driver_id . "</td>" .
                 "<td>" . $data->created_at . "</td>" .
                 "<td class='Af'>" . $data->updated_at . "</td>" .
                 "<td><a href='/cars/$data->car_id' id='$data->car_id' class='btn btn-primary updateBtn'>Update</a></td>      
                 <td><a href='cars/$data->car_id' id='$data->car_id' class='deleteBtn btn btn-danger'>Delete </button></td>
                 </tr>";
             }}

             else{return "<tr><td colspan='8'><div class='card bg-light text-dark'><div class='card-body text-center' id='notFound'><h1>Data not found!</h1></div></div></td></tr>";}
      
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
        $plate_no = $request->input('plate_no');
        $color = $request->input('color');
        $model = $request->input('model');
        $type = $request->input('type');
        $status = $request->input('status');
        $driver_id = $request->input('driver_id');
        $rules = array(
                'plate_no' => 'required|max:6|min:3|unique:cars',
                'color' => 'required|string|min:3|max:15',
                'model' => 'required',
                'type' => 'required',
                'status' => 'required');

        
        $validator = Validator::make($request->all(),$rules);
                
                if($validator->fails()){
                   
                       return $validator->errors()->toArray();
                       
                }
                else{

                    try { 
                        Car::create($request->all());
                        $id = DB::getPdo()->lastInsertId();
                        return "successfully done " . $id;
                    }
                 catch(QueryException $ex){ 
                      print($ex->getMessage()); 
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
      $data = DB::table('cars')->where('car_id',$id)->first();
      if($data->status == 1){$data->status = "True";}else{$data->status="False";}
    
    $row = "<tr><td><b>".$data->car_id."</b></td><td>" . $data->plate_no ."</td><td>" . $data->color ."</td><td>"
                .$data->model."</td><td>".$data->type."</td><td>".$data->status."</td><td>".$data->driver_id."</td><td>".$data->created_at."</td><td>".$data->updated_at.
                "</td><td><a href='/cars/"
                .$data->car_id ."' id='".$data->car_id."'class='btn btn-primary updateBtn' >Update</a></td><td><a a href='/cars/"
                .$data->car_id ."' id='".$data->car_id. "'class='btn btn-danger deleteBtn'>Delete </button></td></td></tr>";
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
        $data = Car::find($id);
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
        $plate_no = $request->input('plate_no');
        $color = $request->input('car_color');
        $model = $request->input('car_model');
        $type = $request->input('car_type');
        $status = $request->input('car_status');
        $driver_id = $request->input('driver_id');
        
        if($plate_no == $data['plate_no'] && $color ==$data['color'] && $model ==
         $data['model']&& $status ==$data['status']&&$type==$data['type']&&$driver_id==$data['driver_id']){
                    $responseErr = "There is nothing for update, please enter new things into field/fields";
                    return $responseErr; 
        }else{ 
            $rules = array('plate_no' => 'required|string|max:6|min:3', 'car_color' => 'required|string|min:3|max:15',
                            'car_model' => 'required', 'car_type' => 'required','car_status' => 'required');
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                return $validator->errors()->toArray();
            }
            $d_id_driver = DB::table('drivers')->where('driver_id',$driver_id)->count();
            $arrayOfErr = array();
            if(!($data['plate_no'] == $plate_no)){$plate_count = DB::table('cars')->where('plate_no',$plate_no)->count();
                if($plate_count > 0){$arrayOfErr[0] = "plate number(".$plate_no.") has already been taken";}}

            if(!($data['driver_id'] == $driver_id)){ 
                $driver_id_count = DB::table('cars')->where('driver_id',$driver_id)->count();
                if($driver_id_count > 0){ 
                    $car_of_driver = DB::table('cars')->where('driver_id',$driver_id)->first();
                    $arrayOfErr[1] =  "car with plate number of " . $car_of_driver->plate_no
                    . " is assigned for driver with ID ". $driver_id;}
            }

            if($d_id_driver<=0 && $driver_id)
                {$arrayOfErr[2] = "there is no driver registered with ID of " . $driver_id . " ";}
            if($arrayOfErr){
                return $arrayOfErr;
            }
          else{
            try { 
                 $update = DB::table('cars')->where('car_id',$id)
                ->update(['plate_no'=>$plate_no,'color'=>$color,'model'=>$model,'type'=>$type,'status'=>$status,'driver_id'=>$driver_id]);
                    return "successfully updated";
                }
             catch(QueryException $ex){ 
                if($ex->getMessage())
                  print($ex->getMessage()); 
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
        try{
        $deleteData = Car::find($id);
        $deleteData->delete();
        return "successfully deleted";
    }
        catch(QueryException $e){
            print($ex->getMessage());
        }
    }
}
