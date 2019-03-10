<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

use illuminate\Http\QueryException;
use Validator;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class userController extends Controller
{
    
    public function index(){
      $countOfUsers = DB::table('users')->count();

      $dataOfusersTable = User::where('status',true)->orWhere('status',false)->paginate(5);
      return view('/users/index')->with(['dataOfusersTable'=>$dataOfusersTable,'countOfUsers'=>$countOfUsers]);
       }
       public function searchUser(Request $request){
        
        $searchOn = $request->input('searchon');
        $searchInput= $request->input('searchInp');
          
          if($searchOn == "user_id"){
          $dataArray = DB::table('users')->where("id",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("id",'LIKE',"%$searchInput%")->count();}
  
          if($searchOn == "name"){
          $dataArray = DB::table('users')->where("name",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("name",'LIKE',"%$searchInput%")->count();}
  
          if($searchOn == "position"){
          $dataArray = DB::table('users')->where("position",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("position",'LIKE',"%$searchInput%")->count();}
  
          if($searchOn == "directorate"){
          $dataArray = DB::table('users')->where("directorate",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("directorate",'LIKE',"%$searchInput%")->count();}
  
          if($searchOn == "status"){
              if($searchInput == 'a'){$searchInput = str_replace('a', false, false);}
          $dataArray = DB::table('users')->where("status",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("status",'LIKE',"%$searchInput%")->count();}
          if($searchOn == "id"){
          $dataArray = DB::table('users')->where("id",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("id",'LIKE',"%$searchInput%")->count();}
          if($dataCount >0 ){
             
          foreach ($dataArray as $data) {
              if($data->status === false){$data->status = 'False';}else{$data->status='True';}
              echo 
                   "<td>" . $data->id . "</td>".
                   "<td>" . $data->name . "</td>".
                   "<td>" . $data->position . "</td>" .
                   "<td>" . $data->directorate . "</td>" .
                   "<td>" . $data->email . "</td>" .
                   "<td>" . $data->status . "</td>" .
                   "<td>" . $data->created_at . "</td>" .
                   "<td class='Af'>" . $data->updated_at . "</td>" .
                   "<td><a href='/cars/$data->id' id='$data->id' class='btn btn-primary updateBtn'>Update</a></td>      
                   <td><a href='cars/$data->id' id='$data->id' class='deleteBtn btn btn-danger'>Delete </button></td>
                   </tr>";
               }}
  
               else{return "<tr><td colspan='8'><div class='card bg-light text-dark'><div class='card-body text-center' id='notFound'><h1>Data not found!</h1></div></div></td></tr>";}
        
        }
        public function pendings(){
        
            $countPendings = DB::table('users')->where("status",null)->count();
            $pendings = User::where('status',null)->paginate(5);
            $permissions = DB::table('permissions')->get();
           
            return view('/users/pendings')->with(['pendings'=>$pendings,"countPendings"=>$countPendings,'permissions'=>$permissions
           ]);
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
        //
        $passRegexMessage = ['password.regex'=>' Password must has 8 letters, at least one letter, one number and one special charecter ',
    'phone.regex'=>'phone number must start with 07 and not be greater than 10 numbers'];
       $rules = array(
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'position' =>['required','string','min:4'],
            'directorate'=>['required','string','min:4'],
            'phone' =>['required','regex:/^07[0-9]{8}/'], 
        );
        $validator = Validator::make($request->all(),$rules,$passRegexMessage);
                
        if($validator->fails()){
           
               return $validator->errors()->toArray();
               
        }
        else{
             User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'position' =>$request->input('position'),
                'directorate' => $request->input('directorate'),
                'phone' => $request->input('phone'),
                'status' =>$request->input('status'),
                'password' => Hash::make($request->input('password')),
            ]);
                    $id = DB::getPdo()->lastInsertId();
                     return 'successfully done '. $id ;
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
        $data = User::find($id);
        return $data;



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id) {
        $data = User::find($id);
     return $data;
        }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approveUser(Request $request,$id){
        
         $status = $request->input('status');
         if($status == 'true' || $status == 'false' || empty($status)){
           try{
            $user = User::find($id);
            $user->status = $request->input('status');
            $user->save();
                if($user->status == 'true'){
                    return "successfully Approved";}
                if($user->status == 'false'){
                    return "successfully Rejected";}
                if($user->status == ''){
                    return "pending not abrogated";}
           }catch(QueryException $e){
            return $e->getMessage();
           }
        }else{
            return "don't change on select options";
        }
        

         
    }
    public function update(Request $request, $id)
    {
        //
        
    //     $passRegexMessage = ['password.regex'=>' Password must has 8 letters, at least one letter, one number and one special charecter ',
    // 'phone.regex'=>'phone number must start with 07 and not be greater than 10 numbers'];
    //    $rules = array(
        // 'position' =>['required','string','min:4'],
        // 'directorate'=>['required','string','min:4'],
            // 'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:6', 'confirmed'],
            // 'phone' =>['required','regex:/^07[0-9]{8}/'], 
        // );
        

        // $validator = Validator::make($request->all(),$rules);
        // if($validator->fails()){
            //    return $validator->errors()->toArray();
        // }
        // else{
             // $user->name = $request->input('name');
            // $user->email = $request->input('email');
            // $user->phone = $request->input('phone');
            // $user->password = Hash::make($request->input('password'));
            // $user->position = $request->input('position');
            // $user->directorate =$request->input('directorate');
            $status = $request->input('status');
            $user = User::find($id);
            if($status == 'true' || $status == 'false'){
                try{
                 $user = User::find($id);
                 $user->status = $request->input('status');
                 $user->save();
                     if($user->status == 'true'){
                         return "successfully Approved";}
                     if($user->status == 'false'){
                         return "successfully Rejected";}
                
                }catch(QueryException $e){
                 return $e->getMessage();
                }
             }else{
                 return "don't change on select options";
             }
                     
    //    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $yesOrNo)
    {
        //
        $dataID = DB::table("users")->where('id',$id)->first();
        $deleteResult = DB::table('users')->where('id',$id)->delete();
        if($deleteResult ===1){
        $result = "driver with ID: " .$dataID->id. " successfully deleted from table";
        return $result; }
        else{
            return "Deletion not occured";
        }
    }
}

