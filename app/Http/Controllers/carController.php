<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\car;
use DB;
use Validator;


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
                             Car::create($request->all());
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
        //
        $data = Car::find($id);
        return $data;
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
        $deleteData = Car::find($id);
        $deleteData->delete();
    }
}
