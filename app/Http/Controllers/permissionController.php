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
        if(!(empty($request->permission_id))){
            if(in_array('Do Everything',$request->permission_id))
                {$user->givePermissionTo('Do Everything');}
            else{$user->revokePermissionTo('Do Everything');}
            if(in_array('Approve',$request->permission_id))
                {$user->givePermissionTo('Approve');}
            else{$user->revokePermissionTo('Approve');}
            if(in_array('Booking',$request->permission_id))
                {$user->givePermissionTo('Booking');}
            else{$user->revokePermissionTo('Booking');}
            if(in_array('monitor',$request->permission_id))
                {$user->givePermissionTo('monitor');}
            else{$user->revokePermissionTo('monitor');}
            if(in_array('Read',$request->permission_id))
                {$user->givePermissionTo('Read');}
            else{$user->revokePermissionTo('Read');}
            if(in_array('Update',$request->permission_id))
                {$user->givePermissionTo('Update');}
            else{$user->revokePermissionTo('Update');}
            if(in_array('Delete',$request->permission_id))
                {$user->givePermissionTo('Delete');}
            else{$user->revokePermissionTo('Delete');}
            if(in_array('Create',$request->permission_id))
                {$user->givePermissionTo('Create');}
            else{$user->revokePermissionTo('Create');}
            

            return 'successfully Done';}
            else{
                $permission = array("Create",'Delete','Update','Read',"Do Everything",'monitor','Booking','Approve');
                foreach ($permission as $key => $per) {
                    $user->revokePermissionTo($per);
                }
                return "permission/permissions remvoed for this user";
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
