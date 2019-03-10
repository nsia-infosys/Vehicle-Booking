@extends('layouts.app')

@section('content')

<div class="col-md-12">
@if(!Auth::check())
{{ __('you are not logged in') }}
@endif
@if(Auth::check())
   <h5 style="color:teal"> {{ __('You are logged in as ') .Auth::user()->name }}</h5>

   
<!-- start of upadate modal box -->
<div id='updateModal' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
      <!--content-->
              <div class="row">

                  <div class="col-md-12">

                  <div class="card text-white bg-secondary ">
                  <div class="card-header">Update user</div>
                    <div class="card-body">
                        <form name="updateForm" id="updateForm">
                            @csrf
                            <input type="hidden" name="id" id="id" value="">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }} </label>
                                <input type="text" class="form-control" name='driver_name' id="driver_name" placeholder="insert name">
                                <div class='errorsOfDriver font-italic text-light' >
                                  <div class="help-block" id='UnameErr'></div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="name">{{ __('Position') }} </label>
                                <input type="text" class="form-control" name='driver_name' id="driver_name" placeholder="insert name">
                                <div class='errorsOfDriver font-italic text-light' >
                                  <div class="help-block" id='UnameErr'></div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="name">{{ __('Directorate') }} </label>
                                <input type="text" class="form-control" name='driver_name' id="driver_name" placeholder="insert name">
                                <div class='errorsOfDriver font-italic text-light' >
                                  <div class="help-block" id='UnameErr'></div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="name">{{ __('Email') }} </label>
                                <input type="text" class="form-control" name='driver_name' id="driver_name" placeholder="insert name">
                                <div class='errorsOfDriver font-italic text-light' >
                                  <div class="help-block" id='UnameErr'></div>
                                </div>
                              </div>
                          <div class="row">
                              <div class="form-group clear-fix col-md-12">
                                  <button type='submit' class='btn form-group col-sm-2 col-xs-2 float-right  btn-primary' name="saveInsert" id='saveInsert'>{{ __('Save') }}</button>
                                  <span class="float-right">&nbsp</span>
                                  <button type='button' class='btn btn-dark col-sm-2 col-xs-2 float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('Cancel') }}</button>
                                </div>
                          </div>
                           
                        </form>
                        
                  </div>
                </div>
                    
                </div>
            </div>
    </div>
  </div>
</div>

<!-- update modal box -->
{{--  change password  --}}
<div id='passModal' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content bg-primary">
        <!--content-->
                <div class="row">
  
                    <div class="col-md-12">
  
                    <div class="card text-white bg-secondary ">
                    <div class="card-header">Change Password</div>
                      <div class="card-body">
                          <form name="updateForm" id="updateForm">
                              @csrf
                              <input type="hidden" name="id" id="id" value="">
                              <div class="form-group">
                                  <label for="name">{{ __('Pervious password') }} </label>
                                  <input type="text" class="form-control" name='ppass' id="ppass" placeholder="insert pervious password">
                                  <div class='errorsOfDriver font-italic text-light' >
                                    <div class="help-block" id='UnameErr'></div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="name">{{ __('new password') }} </label>
                                  <input type="text" class="form-control" name='npass' id="npass" placeholder="insert new password">
                                  <div class='errorsOfDriver font-italic text-light' >
                                    <div class="help-block" id='UnameErr'></div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="name">{{ __('Confirm new password') }} </label>
                                  <input type="text" class="form-control" name='cnpass' id="cnpass" placeholder="confirm your password">
                                  <div class='errorsOfDriver font-italic text-light' >
                                    <div class="help-block" id='UnameErr'></div>
                                  </div>
                                </div>
                                <div class="form-group clear-fix col-md-12">
                                    <button type='submit' class='btn form-group col-sm-2 col-xs-2 float-right  btn-primary' name="saveInsert" id='saveInsert'>{{ __('Change') }}</button>
                                    <span class="float-right">&nbsp</span>
                                    <button type='button' class='btn btn-dark col-sm-2 col-xs-2 float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('Cancel') }}</button>
                                  </div>
                          </form>  
                    </div>
                  </div>
                  </div>
              </div>
      </div>
    </div>
  </div>
  

{{--  change password  --}}


<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header text-center" style="background-color:seagreen">
            <h4 style="color:lightgoldenrodyellow"> {{ __('Dashboard') }}</h4></div>
            <div class="card-body">

                <div class="card-group">

                    <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                        <div class="card-header"><h4 class="text-center">Users</h4></div>
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Total Users: '). $totalUser }} </h5>
                            <h5 class="card-title">{{ __('Approved Users: '). $trueUser}}</h5>
                            <h5 class="card-title">{{ __('Rejected Users: '). $falseUser}}</h5>
                            <h5 class="card-title">{{ __('Pending Users: '). $pendingUser}}</h5>
                        </div>
                    </div>
                    <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                        <div class="card-header"><h4 class="text-center">{{ __('Bookings') }}</h4></div>
                        <div class="card-body">       
                            <h5 class='card-title'>{{ __('Total Bookings: ').$totalBooking }}</h5>
                            <h5 class="card-title">{{ __('Pending Bookings: ').$pendingBookings }}</h5>
                            <h5 class='card-title'>{{   __('Approved Bookings: ').$ApprovedBookings }}</h5>
                            <h5 class='card-title'>{{   __('Rejected Bookings: ').$RejectedBookings }}</h5>
                        </div>
                    </div>
                    <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                        <div class="card-header"><h4 class="text-center">{{ __('Cars') }}</h4></div>
                        <div class="card-body">           
                            <h5 class='card-title'>{{ __('Total Cars: '). $totalCar}}</h5>
                            <h5 class='card-title'>{{ __('Good Condition Cars: '). $trueCar}}</h5>
                            <h5 class='card-title'>{{ __('Damaged Cars: '). $falseCar}}</h5>
                        </div>
                    </div>
                    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                        <div class="card-header"><h4 class="text-center">{{ __('Drivers') }}</h4></div>
                        <div class="card-body">
                            <h5 class='card-title'>{{ __('Total Drivers: '). $totalDriver}}</h5>
                            <h5 class='card-title'>{{ __('Present Drivers: '). $trueDriver}}</h5>
                            <h5 class='card-title'>{{ __('Absent Drivers: '). $falseDriver}}</h5>
                        </div>
                    </div>

                </div>                
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header text-center" style="background-color:seagreen">
            <h4 style="color:lightgoldenrodyellow"> {{ __('My Profile') }}</h4></div>
            <div class="card-body">
<div class="row">
                <div class="card-group col-md-4">
                    <table class="table">
                           <tr> <th>{{ __('ID') }}</th> <td>{{ $user->id }}</td></tr>
                           <tr> <th>{{ __('Name') }}</th> <td>{{ $user->name }}</td></tr>
                           <tr> <th>{{ __('Position') }}</th><td>{{ $user->position }}</td></tr>
                           <tr> <th>{{ __('Directorate') }}</th><td>{{ $user->directorate }}</td></tr>
                           <tr> <th>{{ __('Email') }}</th><td>{{ $user->email }}</td></tr>
                           <tr> <th>{{ __('Phone') }}</th><td>0{{ $user->phone }}</td></tr>
                        
                        <tr> 
                            <td></td>
                            <td><a href="/users/{{ $user->id }}" id="{{$user->id}}" class="btn btn-primary btn-sm updateBtn">{{ __('Update') }}</a>
                            <a href="/users/{{ $user->id }}" id="{{$user->id}}" class="btn btn-danger btn-sm passBtn">{{ __('ChangePassword') }}</a></td>
                        </tr>
                    </table>       
                </div> 
                <div class="card col-md-8 col-sm-8 text-white bg-success">
                        <div class="card-header"><h4 class="text-center">{{ __('Your Activities') }}</h4></div>
                        <div class="card-body">           
                            <h5 class='card-title'>{{ __('Approved bookings: '). $pend}}</h5>
                            <h5 class='card-title'>{{ __('Rejected Bookings: ' . $appr)}}</h5>
                            <h5 class='card-title'>{{ __('Pending Bookings: ').$rej}}</h5>
                            <h5 class='card-title'>{{ __('Bookings approved by you: '). $approvedByMeCount}}</h5>
                            <h5 class='card-title'>{{ __('Bookings rejected by you: '). $rejectedByMeCount}}</h5>
                        </div>
                    </div>  
</div>
                     
            </div>
        </div>
    </div>
</div>

<style>
    .t210px {height:210px};
</style>
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center" style="background-color:yellowgreen">
                    <span style="color:darkslategray">{{ __('you have '). $pend .__(' pending bookings')}}</span>
                    <h4 style="color:darkslategrey"> {{ __('My pending bookings') }}</h4></div>

                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                         
                         <table class="table table-bordered table-responsive table-light t210px">
                            <thead>
                              <tr>
                                <th scope="col">{{ __('Booking Id') }}</th>
                                
                                <th scope="col">{{__('User')}}</th>
                                <th scope="col">{{__('Destination')}}</th>
                                <th scope="col">{{__('Pickup Time')}}</th>
                                <th scope="col">{{  __('Return Time')}}</th>
                                <th scope="col">{{__('Count of persons')}}</th>
                                <th scope="col">{{__('Description')}}</th>
                                <th scope="col">{{__('Approval')}}</th>
                                <th scope="col">{{__('created_time')}}</th>
                                <th scope="col">{{__('updated_time')}}</th>
                                <th scope="col" colspan="2" class='text-center'>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($myBookings as $rowData)
                                
                                @if(!(is_bool($rowData->approval)))
                              <tr>
                                <th scope="row">{{$rowData->booking_id}}</th>
                                <td>{{$rowData->user_id}}</td>
                                <td>{{$rowData->destination}}</td>
                                <td>{{$rowData->pickup_time}}</td>
                                <td>{{$rowData->return_time}}</td>
                                <td>{{$rowData->count}}</td>
                                <td>{{$rowData->description}}</td>
                                <td>
                                    <span style="background-color:yellowgreen;border-radius:3px;padding:4px;display:inline-block">  {{  _('Pending')}}</span>
                                </td>
                                <td>{{$rowData->created_at}}</td>
                                <td>{{  $rowData->updated_at}}</td>  
                                     
                                <td><a href="/bookings/{{ $rowData->booking_id }}" id="{{ $rowData->booking_id }} "class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateModal">Update</button></td>   
                                <td><a href="/bookings/{{ $rowData->booking_id }}" id="{{ $rowData->booking_id }}" class='deleteBtn btn btn-danger'>Delete </a></td>
                              </tr>  
                              @endif
                              @endforeach
                              
                            </tbody>
                          </table>
                    
                </div>
            </div>
        </div>
    </div>

    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center" style="background-color:dodgerblue">
                        <span style="color:lightblue">{{ __('You have '). $appr .__(' approved bookings')}}</span>
                    <h4 style="color:lightyellow"> {{ __('My Approved bookings') }}</h4></div>
                <div class="card-body">    
                    <table class="table table-bordered table-responsive table-light t210px">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Booking Id') }}</th>
                                <th scope="col">{{__('User')}}</th>
                                <th scope="col">{{__('Destination')}}</th>
                                <th scope="col">{{__('Pickup Time')}}</th>
                                <th scope="col">{{  __('Return Time')}}</th>
                                <th scope="col">{{__('Count of persons')}}</th>
                                <th scope="col">{{__('Description')}}</th>
                                <th scope="col">{{__('Approval')}}</th>
                                <th scope="col">{{__('Approval_description')}}</th>
                                <th scope="col">{{__('Approval_pickup_time')}}</th>
                                <th scope="col">{{__('Approval_return_time')}}</th>
                                <th scope="col">{{__('Approver_user')}}</th>
                                <th scope="col">{{__('Driver')}}</th>
                                <th scope="col">{{__('Car')}}</th>
                                <th scope="col">{{__('created_time')}}</th>
                                <th scope="col">{{__('updated_time')}}</th>
                                <th scope="col" colspan="2" class='text-center'>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($myBookings as $rowData)
                                @if(is_bool($rowData->approval) && $rowData->approval ===true)
                                    <tr>
                                        <th scope="row">{{$rowData->booking_id}}</th>
                                        <td>{{$rowData->user_id}}</td>
                                        <td>{{$rowData->destination}}</td>
                                        <td>{{$rowData->pickup_time}}</td>
                                        <td>{{$rowData->return_time}}</td>
                                        <td>{{$rowData->count}}</td>
                                        <td>{{$rowData->description}}</td>
                                        <td>
                                            <span style="background-color:dodgerblue;color:whitesmoke;display:inline-block;border-radius:3px;padding:4px">  {{  _('Approved')}}</span>
                                        </td>
                                        <td>{{$rowData->approver_description}}</td>
                                        <td>{{$rowData->approval_pickup_time}}</td>
                                        <td>{{$rowData->approval_return_time}}</td>
                                        <td>{{$rowData->approver_user_id}}</td>
                                        <td>{{$rowData->driver_id}}</td>
                                        <td>{{$rowData->plate_no}}</td>
                                        <td>{{$rowData->created_at}}</td>
                                        <td>{{  $rowData->updated_at}}</td>            
                                        <td><a href="/bookings/{{ $rowData->booking_id }}" id="{{ $rowData->booking_id }} "class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateModal">Update</button></td>   
                                        <td><a href="/bookings/{{ $rowData->booking_id }}" id="{{ $rowData->booking_id }}" class='deleteBtn btn btn-danger'>Delete </a></td>
                                    </tr>  
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="background-color:firebrick;color:white">
                        
                    <span style="color:lightcoral">{{ __('You have '). $rej .__(' rejected bookings')}}</span>
                      <h4>  {{ __('My rejected bookings') }}</h4></div>
                    <div class="card-body">    
                        <table class="table table-bordered table-responsive table-light t210px">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Booking Id') }}</th>
                                    <th scope="col">{{__('User')}}</th>
                                    <th scope="col">{{__('Destination')}}</th>
                                    <th scope="col">{{__('Pickup Time')}}</th>
                                    <th scope="col">{{  __('Return Time')}}</th>
                                    <th scope="col">{{__('Count of persons')}}</th>
                                    <th scope="col">{{__('Description')}}</th>
                                    <th scope="col">{{__('Approval')}}</th>
                                    <th scope="col">{{__('Approval_description')}}</th>
                                    
                                    <th scope="col">{{__('Approver_user')}}</th>
                                    <th scope="col">{{__('created_time')}}</th>
                                    <th scope="col">{{__('updated_time')}}</th>
                                    <th scope="col" colspan="2" class='text-center'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myBookings as $rowData)
                                    @if(is_bool($rowData->approval) && $rowData->approval ===false)
                                        <tr>
                                            <th scope="row">{{$rowData->booking_id}}</th>
                                            <td>{{$rowData->user_id}}</td>
                                            <td>{{$rowData->destination}}</td>
                                            <td>{{$rowData->pickup_time}}</td>
                                            <td>{{$rowData->return_time}}</td>
                                            <td>{{$rowData->count}}</td>
                                            <td>{{$rowData->description}}</td>
                                            <td>
                                                <span style="color:wheat;background-color:firebrick;display:inline-block;border-radius:3px;padding:4px">  {{  _('Rejected')}}</span>
                                            </td>
                                            <td>{{$rowData->approver_description}}</td>
                                            <td>{{$rowData->approver_user_id}}</td>
                                             <td>{{$rowData->plate_no}}</td>
                                            <td>{{$rowData->created_at}}</td>
                                            <td>{{  $rowData->updated_at}}</td>            
                                            <td><a href="/bookings/{{ $rowData->booking_id }}" id="{{ $rowData->booking_id }} "class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateModal">Update</button></td>   
                                            <td><a href="/bookings/{{ $rowData->booking_id }}" id="{{ $rowData->booking_id }}" class='deleteBtn btn btn-danger'>Delete </a></td>
                                        </tr>  
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="background-color:dodgerblue;color:white">
                        
                    <span style="color:lightblue">{{ $approvedByMeCount .__(' Bookings approved by you')}}</span>
                      <h4>  {{ __('Bookings approved by me') }}</h4></div>
                    <div class="card-body">    
                        <table class="table table-bordered table-responsive table-light t210px">
                            <thead>
                                <tr>
                                  
                                <th scope="col">{{ __('Booking Id') }}</th>
                                <th scope="col">{{__('User')}}</th>
                                <th scope="col">{{__('Destination')}}</th>
                                <th scope="col">{{__('Pickup Time')}}</th>
                                <th scope="col">{{  __('Return Time')}}</th>
                                <th scope="col">{{__('Count of persons')}}</th>
                                <th scope="col">{{__('Description')}}</th>
                                <th scope="col">{{__('Approval')}}</th>
                                <th scope="col">{{__('Approval_description')}}</th>
                                <th scope="col">{{__('Approval_pickup_time')}}</th>
                                <th scope="col">{{__('Approval_return_time')}}</th>
                                <th scope="col">{{__('Approver_user')}}</th>
                                <th scope="col">{{__('Driver')}}</th>
                                <th scope="col">{{__('Car')}}</th>
                                <th scope="col">{{__('created_time')}}</th>
                                <th scope="col">{{__('updated_time')}}</th>
                                <th scope="col" colspan="2" class='text-center'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($approvedByMe as $rowData)
                                    @if(is_bool($rowData->approval) && $rowData->approval ===true)
                                    <tr>
                                        <th scope="row">{{$rowData->booking_id}}</th>
                                        <td>{{$rowData->user_id}}</td>
                                        <td>{{$rowData->destination}}</td>
                                        <td>{{$rowData->pickup_time}}</td>
                                        <td>{{$rowData->return_time}}</td>
                                        <td>{{$rowData->count}}</td>
                                        <td>{{$rowData->description}}</td>
                                        <td>
                                            <span style="background-color:dodgerblue;color:white;display:inline-block;border-radius:3px;padding:4px">  {{  _('Approved')}}</span>
                                        </td>
                                        <td>{{$rowData->approver_description}}</td>
                                        <td>{{$rowData->approval_pickup_time}}</td>
                                        <td>{{$rowData->approval_return_time}}</td>
                                        <td>{{$rowData->approver_user_id}}</td>
                                        <td>{{$rowData->driver_id}}</td>
                                        <td>{{$rowData->plate_no}}</td>
                                        <td>{{$rowData->created_at}}</td>
                                        <td>{{  $rowData->updated_at}}</td>            
                                        <td><a href="/bookings/{{ $rowData->booking_id }}" id="{{ $rowData->booking_id }} "class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateModal">Update</button></td>   
                                        <td><a href="/bookings/{{ $rowData->booking_id }}" id="{{ $rowData->booking_id }}" class='deleteBtn btn btn-danger'>Delete </a></td>
                                    </tr>  
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="background-color:darkred;color:white">
                        
                    <span>{{ $rejectedByMeCount .__(' Bookings rejected by you')}}</span>
                      <h4>  {{ __('Bookings approved by me') }}</h4></div>
                    <div class="card-body">    
                        <table class="table table-bordered table-responsive table-light t210px">
                            <thead>
                                <tr>
                                  
                                <th scope="col">{{ __('Booking Id') }}</th>
                                <th scope="col">{{__('User')}}</th>
                                <th scope="col">{{__('Destination')}}</th>
                                <th scope="col">{{__('Pickup Time')}}</th>
                                <th scope="col">{{  __('Return Time')}}</th>
                                <th scope="col">{{__('Count of persons')}}</th>
                                <th scope="col">{{__('Description')}}</th>
                                <th scope="col">{{__('Approval')}}</th>
                                <th scope="col">{{__('Approval_description')}}</th>
                                <th scope="col">{{__('Approver_user')}}</th>
                                <th scope="col">{{__('created_time')}}</th>
                                <th scope="col">{{__('updated_time')}}</th>
                                <th scope="col" colspan="2" class='text-center'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rejectedByMe as $rowData)
                                    @if(is_bool($rowData->approval) && $rowData->approval ===false)
                                    <tr>
                                        <th scope="row">{{$rowData->booking_id}}</th>
                                        <td>{{$rowData->user_id}}</td>
                                        <td>{{$rowData->destination}}</td>
                                        <td>{{$rowData->pickup_time}}</td>
                                        <td>{{$rowData->return_time}}</td>
                                        <td>{{$rowData->count}}</td>
                                        <td>{{$rowData->description}}</td>
                                        <td>
                                            <span style="background-color:darkred;color:wheat;display:inline-block;border-radius:3px;padding:4px">  {{  _('Rejected')}}</span>
                                        </td>
                                        <td>{{$rowData->approver_description}}</td>
                                        <td>{{$rowData->approver_user_id}}</td>
                                        <td>{{$rowData->created_at}}</td>
                                        <td>{{  $rowData->updated_at}}</td>            
                                        <td><a href="/bookings/{{ $rowData->booking_id }}" id="{{ $rowData->booking_id }} "class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateModal">Update</button></td>   
                                        <td><a href="/bookings/{{ $rowData->booking_id }}" id="{{ $rowData->booking_id }}" class='deleteBtn btn btn-danger'>Delete </a></td>
                                    </tr>  
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
@endif
@endsection
