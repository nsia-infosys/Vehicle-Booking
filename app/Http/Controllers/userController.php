<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\User;
use Auth;
use App;
use illuminate\Http\QueryException;
use Validator;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class userController extends Controller
{

    public function __construct(){

        $this->middleware('auth');
        $this->middleware(['permission:Read_user|Approve_user|Create_user']);
    }
    
    public function index(){
      $countOfUsers = DB::table('users')->where('status',true)->count();
      $dataOfusersTable = User::where('status',true)->orWhere('status',false)->orderBy('created_at','DESC')->paginate(5);
      
      return view('/users/index')->with(['dataOfusersTable'=>$dataOfusersTable,'countOfUsers'=>$countOfUsers]);
       }
       public function searchUser(Request $request){
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
          $dataArray = DB::table('users')->where("id",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("id",'LIKE',"%$searchInput%")->count();}
  
          if($searchOn == "name"){
          $dataArray = DB::table('users')->where("name",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("name",'LIKE',"%$searchInput%")->count();}
  
          if($searchOn == "position"){
          $dataArray = DB::table('users')->where("position",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("position",'LIKE',"%$searchInput%")->count();}
  
          if($searchOn == "department"){
          $dataArray = DB::table('users')->where("department",'ILIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("department",'ILIKE',"%$searchInput%")->count();}
  
          if($searchOn == "status"){
              if($searchInput == 'a'){$searchInput = str_replace('a', false, false);}
          $dataArray = DB::table('users')->where("status",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("status",'LIKE',"%$searchInput%")->count();}
          if($searchOn == "email"){
          $dataArray = DB::table('users')->where("email",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("email",'LIKE',"%$searchInput%")->count();}
          if($searchOn == "approver_user_id"){
          $dataArray = DB::table('users')->where("approver_user_id",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("approver_user_id",'LIKE',"%$searchInput%")->count();}
          if($searchOn == "phone"){
          $dataArray = DB::table('users')->where("phone",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('users')->where("phone",'LIKE',"%$searchInput%")->count();}
         
          if($dataCount >0 ){
             
          foreach ($dataArray as $data) {
              if($data->status === false){$data->status = 'False';}else if($data->status == ''){$data->status='';}else{$data->status='True';}
              echo 
              "<tr>".
                   "<td>" . $data->id . "</td>".
                   "<td>" . $data->name . "</td>".
                   "<td>" . $data->position . "</td>" .
                   "<td>" . $data->department . "</td>" .
                   "<td>" . $data->email . "</td>" .
                   "<td>" . $data->phone . "</td>" .
                   "<td>" . $data->status . "</td>" .
                   "<td>" . $data->approver_user_id . "</td>" .
                   "<td>" . $data->created_at . "</td>" .
                   "<td class='Af'>" . $data->updated_at . "</td>" .
                   "<td><a href='/cars/$data->id' id='$data->id' class='btn btn-primary btn-sm updateBtn'>$update</a></td>      
                   </tr>";
               }}
  
               else{
                   
return "<tr><td colspan='11'><div class='card bg-light text-dark'><div class='card-body text-center' id='notFound'><h1>$notFound</h1></div></div></td></tr>";}
        
        }
        public function pendings(){
        
            $countPendings = DB::table('users')->where("status",null)->count();
            $pendings = User::where('status',null)->orderBy('created_at','DESC')->paginate(5);
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
            'password' => ['required', 'string', 'min:8', 'confirmed','regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
            'position' =>['required','string','min:3'],
            'department'=>['required','string','min:3'],
            'phone' =>['required','regex:/^07[0-9]{8}/','unique:users'], 
        );
        $validator = Validator::make($request->all(),$rules,$passRegexMessage);
                
        if($validator->fails()){
           
               return $validator->errors()->toArray();
        }
        else{
            // return $request->input('status');
            try{
                DB::table('users')->insert([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'position' =>$request->input('position'),
                'department' => $request->input('department'),
                'phone' => $request->input('phone'),
                'status' =>$request->input('status'),
                'created_at'=>now(),
                'updated_at'=>now(),
                'approver_user_id'=>Auth::user()->id,
                'password' => Hash::make($request->input('password')),
                ]);

                    $id = DB::getPdo()->lastInsertId();
                    if(App::getLocale()=="fa"){
                        return "استفاده کننده جدید با آی دی $id موفقانه به سیستم علاوه گردید.";
                    }
                     return 'Successfully new user with '. $id . 'saved to system' ;
            }
            catch(QueryException $e){
                return $e.getMessage();
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
      $data->phone =  0 . $data->phone;
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
            $user->approver_user_id =Auth::user()->id;
            $user->save();
                if($user->status == 'true'){
                    if(App::getLocale()=='fa'){
                        return "موفقانه در سیستم علاوه گردید.";
                    }
                    return "successfully Approved";

                }
                if($user->status == 'false'){
                    if(App::getLocale()=='fa'){
                        return "موفقانه رد گردید";
                    }
                    return "successfully Rejected";}
                if($user->status == ''){
                    if(App::getLocale()=='fa'){
                        return "هنوز هم به حالت معلق باقی ماند.";
                    }
                    return "pending not abrogated";}
           }catch(QueryException $e){
            return $e->getMessage();
           }
        }else{
            return "don't change on select options";
        }
        

         
    }
    function changePassword(Request $request, $id){
        if(App::getLocale()=='fa'){
            $passRegexMessage = [
                'new_password.regex' => 'مقدار پسورد از 8 رقم کمتر نباشد، حد اقل یک سمبول ، یک شماره و یک حرف ضروری می باشد.'
            ];
        }else{
        $passRegexMessage = [
            'new_password.regex'=>' Password must has 8 letters, at least one letter, one number and one special charecter ',
            ];}

        $rules = array(
            'previous_password' =>['required'],
            'new_password' => ['required', 'string', 'min:8',
            'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/']
             
        );
        $ppass = $request->input('previous_password');
        $npass = $request->input('new_password');
        $cnpass = $request->input('confirm_new_password');
        $data = DB::table('users')->where('id',$id)->first();
        
                if(Hash::check($ppass, $data->password)){
                    if($npass === $cnpass){
                        $validator = Validator::make($request->all(),$rules,$passRegexMessage);
                            if($validator->fails()){
                                return $validator->errors();
                            }else{
                        try{
                            DB::table('users')->update([
                                'password'=>Hash::make($npass)
                            ]);
                            if(App::getLocale()=='fa'){
                                return "پسورد شما موفقانه تغیر یافت.";
                            }
                            return "Your passsword has changed successfully";
                        }catch(QueryException $e){
                        return $e.getMessage();
                        }
                    }
                    }else{
                        if(App::getLocale()=='fa'){
                            return "پسورد ها با هم مچ نمی کنند.";
                        }
                        return "The password confirmation does not match.";
                        
                    }
                }else{
                    return "wrong password";
                }
        
    }
    public function update(Request $request, $id)
    {
        $data = $this->edit($id);
        
    $requestUrl =  $_SERVER['HTTP_REFERER'];
        
        $user = User::find($id);
        $name = $user->name = $request->input('name');
        $email = $user->email = $request->input('email');
        $phone = $user->phone = $request->input('phone');
        $pass =$user->password = Hash::make($request->input('password'));
        $position = $user->position = $request->input('position');
        $department = $user->department =$request->input('department');
        $status = $status = $request->input('status');
        $rules = array(
        'position' =>['required','string','min:3'],
        'department'=>['required','string','min:3'],
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        'phone' =>['required','regex:/^07[0-9]{8}/'], 
        );
        if(strpos($requestUrl,'/home')){
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                return $validator->errors()->toArray();
            } 
            
            if(!($data['email']==$email)){
                $countEmail = DB::table('users')->where('email',$email)->count();
                if($countEmail>0){ 
                    if(App::getLocale()=='fa'){
                        return "ایمیل تکراری است";
                    }
                    return "Duplicate Email"; }
            }
         
            if(!($data['phone']==$phone)){
                $countPhone = DB::table('users')->where('phone',$phone)->count();
                if($countPhone>0){
                    if(App::getLocale()=='fa'){
                        return "شماره تلفون تکراری است";
                    }
                    return "Duplicate phone number"; }
            }
          
                try{
                     DB::table('users')
                    ->where('id', $id)
                    ->update(['name' => $name,'email'=>$email,'phone'=>$phone,'position'=>$position,'department'=>$department]);
                    if(App::getLocale()=='fa'){
                        return "موفقانه تجدید گردید.";
                    }
                    return "successfully Updated";
                }
                    catch(QueryException $e){$e.getMessage();}  
            
        }
        
    else if(strpos($requestUrl,'/users')){
        if($status == 'true' || $status == 'false'){
            try{
             $user = User::find($id);
             $user->status = $request->input('status');
             $user->save();
                 if($user->status == 'true'){
                     return "successfully Approved";}
                 if($user->status == 'false'){
                    if(App::getLocale()=='fa'){
                        return "موفقانه رد گردید.";
                    }
                     return "successfully Rejected";}
            
            }catch(QueryException $e){
             return $e->getMessage();
            }
         }else{
             return "don't change on select options";
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
        //
        // $dataID = DB::table("users")->where('id',$id)->first();
        // $deleteResult = DB::table('users')->where('id',$id)->delete();
        // if($deleteResult ===1){
        // $result = "driver with ID: " .$dataID->id. " successfully deleted from table";
        // return $result; }
        // else{
        //     return "Deletion not occured";
        // }
    }
}

