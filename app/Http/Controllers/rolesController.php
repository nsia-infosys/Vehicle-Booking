<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use QueryException;
use Validator;
use Spatie\Permission\Traits\HasRoles;


class rolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    use HasRoles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
       $roles = Role::paginate(5);
       $dataCounts = Role::count(); 
       $permissions = Permission::all()->sortBy('id');
       
        return view('roles/index')->with(['roles'=>$roles,'dataCounts'=>$dataCounts,'permissions'=>$permissions]);
     }
     public function user_roles(){
         $users = DB::table('users')->where('status',true)->orderBy('id', 'ASC')->paginate(7);
         $roles = Role::all();
         return view('roles/user_roles')->with(['users'=>$users,'roles'=>$roles]);
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
  
          if($searchOn == "role"){
          $dataArray = DB::table('roles')->where("role",'LIKE',"%$searchInput%")->get();
          $dataCount = DB::table('roles')->where("role",'LIKE',"%$searchInput%")->count();}
         
          if($dataCount >0 ){
          foreach ($dataArray as $data) {
              if($data->status === false){$data->status = 'False';}else{$data->status='True';}
              echo 
                   "<td>" . $data->id . "</td>".
                   "<td>" . $data->name . "</td>".
                   "<td>" . $data->position . "</td>" .
                   "<td>" . $data->directorate . "</td>" .
                   "<td>" . $data->email . "</td>" .
                   "<td>" . $data->phone . "</td>" .
                   "<td>" . $data->status . "</td>" .
                   "<td>" . $data->approver_user_id . "</td>" .
                   "<td>" . $data->created_at . "</td>" .
                   "<td class='Af'>" . $data->updated_at . "</td>" .
                   "<td><a href='/cars/$data->id' id='$data->id' class='btn btn-primary updateBtn'>Update</a></td>      
                   </tr>";
               }}
  
               else{return "<tr><td colspan='8'><div class='card bg-light text-dark'><div class='card-body text-center' id='notFound'><h1>Data not found!</h1></div></div></td></tr>";}
        
        }

    public function permissions(){
        
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
        $nrn =$request->input('new_role_name');
        
        $rules = array('new_role_name'=>'required');
        $validator =Validator::make($request->all(), $rules);
        if($validator->fails()){
            return $validator->errors();
        }
        else{
            $role_count =  DB::table('roles')->where('name','ILIKE',$nrn)->count();
            if($role_count>0){return "this role exists in system";}
            else{
            
                    $role = Role::create(['name' => $request->input('new_role_name')])
                    ->givePermissionTo($request->permissions_name);
                    return "successfully role created " . $role->id;;
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
        $role = Role::find($id);
       $arrayOfPermission = '';
        if ($role = $role->findByName($role->name)) {
            $permissions = $role->permissions()->get();
                foreach ($permissions as $key => $permission) {
                $arrayOfPermission .= "<span style='display:inline-block; background-color:skyblue;margin:2px;padding:4px;border-radius:3px'>" .$permission->name ."</span>";
                }  
        }
        // return $arrayOfPermission;
        $row = "<tr><td><b>".$role->id."</b></td><td>" . $role->name ."</td><td>".
        
        $arrayOfPermission
        ."</td><td>" .$role->created_at."</td><td>".$role->updated_at.
        "</td><td class='text-center'><a href='/roles/" .$role->id ."' id='".$role->id."'class='btn btn-sm btn-primary updateBtn' >
         change permission</a></td><td class='text-center'><a a href='/roles/"
                .$role->id ."' id='".$role->id. "'class='btn btn-danger btn-sm deleteBtn'>remove role </button></td></td></tr>";
     
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
        
        $userHasRoles = DB::table('model_has_roles')
        ->join('users', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles','roles.id','=','model_has_roles.role_id')
        ->select('users.id as id','roles.name as role_name','users.name as name','users.directorate','users.position')
        ->where('users.id','=', $id)
        ->get();
           if($userHasRoles =='[]'){
               $user =DB::table('users')->where('id',$id)->get();
               return $user;
           }
        return $userHasRoles;

    }
    public function edit2($id)
    {
        $role =Role::findById($id);
        $role_name = DB::table('role_has_permissions')
        ->join('roles', 'roles.id', '=', 'role_has_permissions.role_id')
        ->join('permissions','permissions.id','=','role_has_permissions.permission_id')
        ->select('roles.id as id','roles.name as role_name','permissions.name as name')
        ->where('roles.id','=', $id)
        ->get();
        if(count($role_name) == 0){
           $role = DB::table('roles')->where('id',$id)->get();
           return $role;
        }
        
        return $role_name;
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
        $ref = $_SERVER['HTTP_REFERER'];

        if (strpos($ref, '/user_roles') !== false) {
            $user = User::find($id);
            $roleArray = DB::table('roles')->pluck('name')->toArray();
            if(is_array($request->role_name)){
                if(array_intersect($roleArray,$request->role_name)){
                    $user->syncRoles($request->role_name);
                    return "successfully changed";
                }else{
                    return "there is no such role";
                }
            }else
                {foreach ($roleArray as $value) {
                    $user->removeRole($value);
                
                }
                return "role/roles removed for this user";
            }
        }else{
            $role = Role::find($id);
            if(!(empty($request->permission_name))){
                if(in_array('C_driver_car',$request->permission_name))
                    {$role->givePermissionTo('C_driver_car');}
                else{$role->revokePermissionTo('C_driver_car');}
                if(in_array('U_driver_car',$request->permission_name))
                    {$role->givePermissionTo('U_driver_car');}
                else{$role->revokePermissionTo('U_driver_car');}
                if(in_array('R_driver_car',$request->permission_name))
                    {$role->givePermissionTo('R_driver_car');}
                else{$role->revokePermissionTo('R_driver_car');}
                if(in_array('App_booking',$request->permission_name))
                    {$role->givePermissionTo('App_booking');}
                else{$role->revokePermissionTo('App_booking');}
                if(in_array('U_booking',$request->permission_name))
                    {$role->givePermissionTo('U_booking');}
                else{$role->revokePermissionTo('U_booking');}
                if(in_array('C_booking',$request->permission_name))
                    {$role->givePermissionTo('C_booking');}
                else{$role->revokePermissionTo('C_booking');}
                if(in_array('C_user',$request->permission_name))
                    {$role->givePermissionTo('C_user');}
                else{$role->revokePermissionTo('C_user');}
                if(in_array('R_user',$request->permission_name))
                    {$role->givePermissionTo('R_user');}
                else{$role->revokePermissionTo('R_user');}
                if(in_array('R_users_role',$request->permission_name))
                    {$role->givePermissionTo('R_users_role');}
                else{$role->revokePermissionTo('R_users_role');}
                if(in_array('App_user',$request->permission_name))
                    {$role->givePermissionTo('App_user');}
                else{$role->revokePermissionTo('App_user');}
                if(in_array('C_role',$request->permission_name))
                    {$role->givePermissionTo('C_role');}
                else{$role->revokePermissionTo('C_role');}
                if(in_array('U_role',$request->permission_name))
                    {$role->givePermissionTo('U_role');}
                else{$role->revokePermissionTo('U_role');}
                if(in_array('R_role',$request->permission_name))
                    {$role->givePermissionTo('R_role');}
                else{$role->revokePermissionTo('R_role');}
                return 'successfully permissions changed for selected role';}
            else{$role->revokePermissionTo(Permission::all());
             return "No permissions assigned";   
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
}
