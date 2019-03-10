<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

use Spatie\Permission\Traits\HasRoles;

class rolesController extends Controller
{
    
    use HasRoles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
       $roles = Role::all()->sortBy('id');
       $dataCounts = Role::count(); 
       
        return view('roles/index')->with(['roles'=>$roles,'dataCounts'=>$dataCounts]);
     }
     public function user_roles(){
         $users = User::all()->where('status',true)->sortBy('id');
         $roles = Role::all();
       
         return view('roles/user_roles')->with(['users'=>$users,'roles'=>$roles]);
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
        if(!(empty($request->role_id))){
            if(in_array('Super_Admin',$request->role_id))
                {$user->assignRole('Super_Admin');}
            else{$user->removeRole('Super_Admin');}
            if(in_array('Admin',$request->role_id))
                {$user->assignRole('Admin');}
            else{$user->removeRole('Admin');}
            if(in_array('Normal_user',$request->role_id))
                {$user->assignRole('Normal_user');}
            else{$user->removeRole('Normal_user');}
            if(in_array('Supervisor',$request->role_id))
                {$user->assignRole('Supervisor');}
            else{$user->removeRole('Supervisor');}
            if(in_array('Approver',$request->role_id))
                {$user->assignRole('Approver');}
            else{$user->removeRole('Approver');}
            

            return 'successfully Done';}
            else{
                $roles = array("Super_Admin",'Admin','Normal_user','Supervisor',"Approver");
                foreach ($roles as $key => $role) {
                    $user->removeRole($role);
                }
                return "role/roles remvoed for this user";
            }
        
    //     $Super_Admin = Role::findByName('admin');
    //     $adminRole->syncPermissions($insertPermission,$editPermission,$approvePermission,$removePermission);

    //     $writerRole->givePermissionTo($insertPermission);
    //     $editorRole->givePermissionTo($editPermission);
    //    $user =  User::find(2);

    //     $user->assignRole('admin');
        
    //     auth()->user()->assignRole('writer');
    //     $user->givePermissionTo('delete');
        //  $permissions = $user->getDirectPermissions();
        //   $permissions;
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
