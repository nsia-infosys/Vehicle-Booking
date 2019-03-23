<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\User;
use App\Booking;
use App\Car;
use App\Driver;
use Spatie\Permission\Traits\HasRoles;
class HomeController extends Controller
{
    use HasRoles;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        Role::firstOrCreate(['name' => 'Super_admin']);
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Supervisor']);
        Role::firstOrCreate(['name' => 'User_approver']);
        Role::firstOrCreate(['name' => 'Booking_approver']);
        Role::firstOrCreate(['name' => 'Normal_user']);

        $Super_Admin = Role::findByName('Super_admin');
        $Admin = Role::findByName('Admin');
        $Supervisor = Role::findByName('Supervisor');
        $Booking_Approver = Role::findByName('Booking_approver');
        $User_Approver = Role::findByName('User_approver');
        $Normal_user = Role::findByName('Normal_user');

        Permission::firstOrCreate(['name'=>'Create_driver_car','permission_description'=>'can register new driver and car']);
        Permission::firstOrCreate(['name'=>'Update_driver_car','permission_description'=>'can update data of driver and car']);
        Permission::firstOrCreate(['name'=>'Read_driver_car','permission_description'=>'can read registered drivers and cars']);
        Permission::firstOrCreate(['name'=>'Approve_booking','permission_description'=>'can approve bookings']);
        Permission::firstOrCreate(['name'=>'Read_booking','permission_description'=>'can read bookings']);
        Permission::firstOrCreate(['name'=>'Update_booking','permission_description'=>'can update approved bookings']);
        Permission::firstOrCreate(['name'=>'Create_booking','permission_description'=>'can reserve vehical']);
        Permission::firstOrCreate(['name'=>'Create_user','permission_description'=>'can register new user with approve status']);
        Permission::firstOrCreate(['name'=>'Read_user','permission_description'=>'can read registered users']);
        Permission::firstOrCreate(['name'=>'Read_users_role','permission_description'=>'can read assigned roles for users']);
        Permission::firstOrCreate(['name'=>'Approve_user','permission_description'=>'can approve pending users']);
        Permission::firstOrCreate(['name'=>'Create_role','permission_description'=>'can create new role and assign permissions for created role']);
        Permission::firstOrCreate(['name'=>'Update_role','permission_description'=>'can update permissions of roles']);
        Permission::firstOrCreate(['name'=>'Read_role','permission_description'=>'can read roles with their permissions']);
               
        $C_driver_car = Permission::findByName('Create_driver_car');
        $U_driver_car = Permission::findByName('Update_driver_car');
        $R_driver_car = Permission::findByName('Read_driver_car');
        $App_booking = Permission::findByName('Approve_booking');
        $R_booking = Permission::findByName('Read_booking');
        $U_booking = Permission::findByName('Update_booking');
        $C_booking = Permission::findByName('Create_booking');
        $C_user = Permission::findByName('Create_user');
        $R_user = Permission::findByName('Read_user');
        $R_users_role = Permission::findByName('Read_users_role');
        $App_user = Permission::findByName('Approve_user');
        $C_role = Permission::findByName('Create_role');
        $U_role = Permission::findByName('Update_role');
        $R_role = Permission::findByName('Read_role');
        

        $oneMonthAgo = Carbon::now()->subMonths(1);

        $Super_Admin->givePermissionTo(Permission::all());
        $Admin->syncPermissions($C_driver_car,$U_driver_car,$R_driver_car,$App_booking,$C_booking,$U_booking,
        $C_user,$R_user,$App_user);
        $Supervisor->givePermissionTo($R_driver_car,$R_role,$R_user,$R_users_role,$C_booking,$R_booking);
        $Normal_user->givePermissionTo($C_booking);
        $Booking_Approver->givePermissionTo($App_booking,$U_booking,$U_driver_car);
        $User_Approver->givePermissionTo($App_user);
        
        $totalCar = Car::count();
        $totalUser = User::count();
        $totalDriver = Driver::count();
        $totalBooking = Booking::count();

        $PendingBookings = Booking::where('approval',null)->count();
        $ApprovedBookings = Booking::where('approval',true)->count();
        $RejectedBookings = Booking::where('approval',false)->count();
        
        $trueUser = User::where('status',true)->count();
        $falseUser = User::where('status',false)->count();
        $pendingUser = User::where('status',null)->count();
        
        
        $trueCar = Car::where('status',true)->count();
        $falseCar = Car::where('status',false)->count();
        
        $trueDriver = Driver::where('status',true)->count();
        $falseDriver = Driver::where('status',false)->count();
        
        $myBookings = Booking::where('user_id',Auth::user()->id)
        ->where('created_at','>=',$oneMonthAgo)->get();
        $myPendingBookings = Booking::where('user_id',Auth::user()->id)->where('approval',null)
        ->where('created_at','>=',$oneMonthAgo)->count();
        $myApprovedBookings = Booking::where('user_id',Auth::user()->id)->where('approval',true)
        ->where('created_at','>=',$oneMonthAgo)->count();
        $myRejectedBookings = Booking::where('user_id',Auth::user()->id)->where('approval',false)
        ->where('created_at','>=',$oneMonthAgo)->count();
        
        $approvedByMeCount = Booking::where('approver_user_id',Auth::user()->id)->where('approval',true)
        ->where('created_at','>=',$oneMonthAgo)->count();
        $approvedByMe = Booking::where('approver_user_id',Auth::user()->id)->where('approval',true)
        ->where('created_at','>=',$oneMonthAgo)->get();
        
        $rejectedByMeCount = Booking::where('approver_user_id',Auth::user()->id)->where('approval',false)
        ->where('created_at','>=',$oneMonthAgo)->count();
        $rejectedByMe = Booking::where('approver_user_id',Auth::user()->id)->where('approval',false)
        ->where('created_at','>=',$oneMonthAgo)->get();
        
        $usersRejectedByMeCount = User::where('approver_user_id',Auth::user()->id)->where('status',false)
        ->where('created_at','>=',$oneMonthAgo)->count();
        $usersRejectedByMe = User::where('approver_user_id',Auth::user()->id)->where('status',false)
        ->where('created_at','>=',$oneMonthAgo)->get();
       
        $usersApprovedByMeCount = User::where('approver_user_id',Auth::user()->id)->where('status',true)
        ->where('created_at','>=',$oneMonthAgo)->count();
        $usersApprovedByMe = User::where('approver_user_id',Auth::user()->id)->where('status',true)
        ->where('created_at','>=',$oneMonthAgo)->get();
        
        $user = User::where('id',Auth::user()->id)->first();

       return view('home')->with(['user'=>$user,'myBookings'=>$myBookings,'pend'=> $myPendingBookings,'appr'=>$myApprovedBookings,
       'rej'=>$myRejectedBookings,'pendingBookings'=>$PendingBookings,'ApprovedBookings'=>$ApprovedBookings,
       'RejectedBookings'=>$RejectedBookings,'trueUser'=>$trueUser,'falseUser'=>$falseUser,
       'trueCar'=>$trueCar,'falseCar'=>$falseCar,'totalCar'=>$totalCar,'totalDriver'=>$totalDriver,'totalBooking'=>$totalBooking
       ,'totalUser'=>$totalUser,'trueDriver'=>$trueDriver,'falseDriver'=>$falseDriver,'pendingUser'=>$pendingUser,
       'approvedByMe'=>$approvedByMe,'approvedByMeCount'=>$approvedByMeCount,
       'rejectedByMe'=>$rejectedByMe,'rejectedByMeCount'=>$rejectedByMeCount,'usersApprovedByMe'=>$usersApprovedByMe
       ,'usersApprovedByMeCount'=>$usersApprovedByMeCount,'usersRejectedByMe'=>$usersRejectedByMe,'usersRejectedByMeCount'=>$usersRejectedByMeCount]);
    }
}
