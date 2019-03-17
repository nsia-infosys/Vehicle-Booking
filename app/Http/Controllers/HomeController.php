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
        
        Role::firstOrCreate(['name' => 'Super_Admin']);
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Supervisor']);
        Role::firstOrCreate(['name' => 'User_Approver']);
        Role::firstOrCreate(['name' => 'Booking_Approver']);
        Role::firstOrCreate(['name' => 'Normal_User']);

        $Super_Admin = Role::findByName('Super_Admin');
        $Admin = Role::findByName('Admin');
        $Supervisor = Role::findByName('Supervisor');
        $Booking_Approver = Role::findByName('Booking_Approver');
        $User_Approver = Role::findByName('User_Approver');
        $Normal_user = Role::findByName('Normal_User');


        Permission::firstOrCreate(['name'=>'C_driver_car','permission_description'=>'can register new driver and car']);
        Permission::firstOrCreate(['name'=>'U_driver_car','permission_description'=>'can update data of driver and car']);
        Permission::firstOrCreate(['name'=>'R_driver_car','permission_description'=>'can read registered drivers and cars']);
        Permission::firstOrCreate(['name'=>'App_booking','permission_description'=>'can approve bookings']);
        Permission::firstOrCreate(['name'=>'U_booking','permission_description'=>'can update approved bookings']);
        Permission::firstOrCreate(['name'=>'C_booking','permission_description'=>'can reserve vehical']);
        Permission::firstOrCreate(['name'=>'C_user','permission_description'=>'can register new user with approve status']);
        Permission::firstOrCreate(['name'=>'R_user','permission_description'=>'can read registered users']);
        Permission::firstOrCreate(['name'=>'R_users_role','permission_description'=>'can read assigned roles for users']);
        Permission::firstOrCreate(['name'=>'App_user','permission_description'=>'can approver pending users']);
        Permission::firstOrCreate(['name'=>'C_role','permission_description'=>'can create new role and assign permissions for created role']);
        Permission::firstOrCreate(['name'=>'U_role','permission_description'=>'can update permissions of roles']);
        Permission::firstOrCreate(['name'=>'R_role','permission_description'=>'can read roles with their permissions']);
               
        $C_driver_car = Permission::findByName('C_driver_car');
        $U_driver_car = Permission::findByName('U_driver_car');
        $R_driver_car = Permission::findByName('R_driver_car');
        $App_booking = Permission::findByName('App_booking');
        $U_booking = Permission::findByName('U_booking');
        $C_booking = Permission::findByName('C_booking');
        $C_user = Permission::findByName('C_user');
        $R_user = Permission::findByName('R_user');
        $R_users_role = Permission::findByName('R_users_role');
        $App_user = Permission::findByName('App_user');
        $C_role = Permission::findByName('C_role');
        $U_role = Permission::findByName('U_role');
        $R_role = Permission::findByName('R_role');

        $oneMonthAgo = Carbon::now()->subMonths(1);

        $Super_Admin->givePermissionTo(Permission::all());
        $Admin->syncPermissions($C_driver_car,$U_driver_car,$R_driver_car,$App_booking,$C_booking,$U_booking,
        $C_user,$R_user,$R_users_role,$App_user,$R_role);
        $Supervisor->givePermissionTo($R_driver_car,$R_role,$R_user,$R_users_role,$C_booking);
        $Normal_user->givePermissionTo($C_booking);
        $Booking_Approver->givePermissionTo($App_booking,$U_booking,$U_driver_car,$C_booking);
        $User_Approver->givePermissionTo($App_user,$C_booking);
        
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
       
        $user = User::where('id',Auth::user()->id)->first();

       return view('home')->with(['user'=>$user,'myBookings'=>$myBookings,'pend'=> $myPendingBookings,'appr'=>$myApprovedBookings,
       'rej'=>$myRejectedBookings,'pendingBookings'=>$PendingBookings,'ApprovedBookings'=>$ApprovedBookings,
       'RejectedBookings'=>$RejectedBookings,'trueUser'=>$trueUser,'falseUser'=>$falseUser,
       'trueCar'=>$trueCar,'falseCar'=>$falseCar,'totalCar'=>$totalCar,'totalDriver'=>$totalDriver,'totalBooking'=>$totalBooking
       ,'totalUser'=>$totalUser,'trueDriver'=>$trueDriver,'falseDriver'=>$falseDriver,'pendingUser'=>$pendingUser,
       'approvedByMe'=>$approvedByMe,'approvedByMeCount'=>$approvedByMeCount,
       'rejectedByMe'=>$rejectedByMe,'rejectedByMeCount'=>$rejectedByMeCount]);
    }
}
