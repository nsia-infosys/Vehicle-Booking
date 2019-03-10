<?php

namespace App\Http\Controllers;
use DB;
use Auth;
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
        Role::firstOrCreate(['name' => 'Approver']);
        Role::firstOrCreate(['name' => 'Normal_user']);

        $Super_Admin = Role::findByName('Super_Admin');
        $Admin = Role::findByName('Admin');
        $Supervisor = Role::findByName('Supervisor');
        $Approver = Role::findByName('Approver');
        $Normal_user = Role::findByName('Normal_user');


        Permission::firstOrCreate(['name'=>'Do Everything','permission_description'=>'can do everything']);
        Permission::firstOrCreate(['name'=>'Approve','permission_description'=>'can approve pending bookings, users and update drivers and cars']);
        Permission::firstOrCreate(['name'=>'Booking','permission_description'=>'can reserve vehical']);
        Permission::firstOrCreate(['name'=>'monitor','permission_description'=>'can see everything and reserve vehical']);
        Permission::firstOrCreate(['name'=>'Read','permission_description'=>'can read through all system except users permissions and roles']);
        Permission::firstOrCreate(['name'=>'Update','permission_description'=>'can update through all system except user permissions and roles']);
        Permission::firstOrCreate(['name'=>'Delete','permission_description'=>'can delete temporarily through all system except users permissions and roles']);
        Permission::firstOrCreate(['name'=>'Create','permission_description'=>'can delete temporarily through all system except users permissions and roles']);
        
                 
        $Do_everyting = Permission::findByName('Do Everything');
        $Read = Permission::findByName('Read');
        $Update = Permission::findByName('Update');
        $Delete = Permission::findByName('Delete');
        $Create = Permission::findByName('Create');
        $Approve = Permission::findByName('Approve');
        $monitor = Permission::findByName('monitor');
        $Booking = Permission::findByName('Booking');

        $Super_Admin->givePermissionTo($Do_everyting);
        $Admin->syncPermissions($Read,$Update,$Delete,$Create);
        $Supervisor->givePermissionTo($monitor);
        $Normal_user->syncPermissions($Booking);
        $Approver->givePermissionTo($Approve);
        
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
        
        $myBookings = Booking::where('user_id',Auth::user()->id)->get();
        $myPendingBookings = Booking::where('user_id',Auth::user()->id)->where('approval',null)->count();
        $myApprovedBookings = Booking::where('user_id',Auth::user()->id)->where('approval',true)->count();
        $myRejectedBookings = Booking::where('user_id',Auth::user()->id)->where('approval',false)->count();
        
        $approvedByMeCount = Booking::where('approver_user_id',Auth::user()->id)->where('approval',true)->count();
        $approvedByMe = Booking::where('approver_user_id',Auth::user()->id)->where('approval',true)->get();
        
        $rejectedByMeCount = Booking::where('approver_user_id',Auth::user()->id)->where('approval',false)->count();
        $rejectedByMe = Booking::where('approver_user_id',Auth::user()->id)->where('approval',false)->get();
       
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
