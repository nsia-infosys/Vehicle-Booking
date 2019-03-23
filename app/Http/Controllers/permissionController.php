<?php

namespace App\Http\Controllers;

use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Traits\HasRoles;

class permissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
     $this->middleware('auth');
     
     $this->middleware(['permission:Read_role|Update_role|Create_role|Read_users_role']);
    }
    public function index()
    {
        //
        $dataCounts = Permission::count();
        $permissions = Permission::all()->sortBy('id');
        
        return view("permissions/index")->with(['dataCounts'=>$dataCounts,'permissions'=>$permissions]);
    }
    public function user_permissions(){
        $user = User::all()->where('status',true)->sortBy('id');
        $dataCounts = Permission::count();
        $permissions = Permission::all()->sortBy('id');
        
        return view("permissions/user_permissions")->with(['permissions'=>$permissions,'user'=>$user]);   
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
        
        $userHasPermissions = DB::table('model_has_permissions')
        ->join('permissions', 'permissions.id', '=', 'model_has_permissions.permission_id')
        ->join('users', 'users.id', '=', 'model_has_permissions.model_id')
        ->select('users.id as id','permissions.name as permission_name','users.name as name')
        ->where('users.id','=', $id)
        ->get();
           if($userHasPermissions =='[]'){
               $user =DB::table('users')->where('id',$id)->get();
               return $user;
           }
        return $userHasPermissions;
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
        
        $user = User::find($id);
        if(!(empty($request->permission_name))){
            if(in_array('Create_driver_car',$request->permission_name))
                {$user->givePermissionTo('Create_driver_car');}
            else{$user->revokePermissionTo('Create_driver_car');}
            if(in_array('Update_driver_car',$request->permission_name))
                {$user->givePermissionTo('Update_driver_car');}
            else{$user->revokePermissionTo('Update_driver_car');}
            if(in_array('Read_driver_car',$request->permission_name))
                {$user->givePermissionTo('Read_driver_car');}
            else{$user->revokePermissionTo('Read_driver_car');}
            if(in_array('Approve_booking',$request->permission_name))
                {$user->givePermissionTo('Approve_booking');}
            else{$user->revokePermissionTo('Approve_booking');}
            if(in_array('Update_booking',$request->permission_name))
                {$user->givePermissionTo('Update_booking');}
            else{$user->revokePermissionTo('Update_booking');}
            if(in_array('Create_booking',$request->permission_name))
                {$user->givePermissionTo('Create_booking');}
            else{$user->revokePermissionTo('Create_booking');}
            if(in_array('Create_user',$request->permission_name))
                {$user->givePermissionTo('Create_user');}
            else{$user->revokePermissionTo('Create_user');}
            if(in_array('Read_user',$request->permission_name))
                {$user->givePermissionTo('Read_user');}
            else{$user->revokePermissionTo('Read_user');}
            if(in_array('Read_users_role',$request->permission_name))
                {$user->givePermissionTo('Read_users_role');}
            else{$user->revokePermissionTo('Read_users_role');}
            if(in_array('Approve_user',$request->permission_name))
                {$user->givePermissionTo('Approve_user');}
            else{$user->revokePermissionTo('Approve_user');}
            if(in_array('Create_role',$request->permission_name))
                {$user->givePermissionTo('Create_role');}
            else{$user->revokePermissionTo('Create_role');}
            if(in_array('Update_role',$request->permission_name))
                {$user->givePermissionTo('Update_role');}
            else{$user->revokePermissionTo('Update_role');}
            if(in_array('Read_role',$request->permission_name))
                {$user->givePermissionTo('Read_role');}
            else{$user->revokePermissionTo('Read_role');}
            return 'successfully permissions changed for selected user';}
        else{$user->revokePermissionTo(Permission::all());
         return "No permissions assigned";   
        }
            
            
        
        // $adminRole = Role::findByName('admin');
        // $adminRole->syncPermissions($insertPermission,$editPermission,$approvePermission,$removePermission);

        // $writerRole->givePermissionTo($insertPermission);
        // $editorRole->givePermissionTo($editPermission);
        // $user =  User::find(2);

        // $user->assignRole('admin');
        
        // auth()->user()->assignRole('writer');
        // $user->givePermissionTo('delete');
        // $permissions = $user->getDirectPermissions();
        // $permissions;
        //  $users = User::role('writer')->get(); // Returns only users with the role 'writer'
        //  return $users;
        // $user->givePermissionTo('insert');
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
