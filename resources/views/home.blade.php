@extends('layouts.app')

@section('content')

<div class="col-md-12">
@if(Auth::check() && Auth::user()->status ==true)
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
                                <label for="name">{{ __('msg.Name') }} </label>
                                <input type="text" class="form-control" name='name' id="name" placeholder="insert name">
                                <div class='errorsOfDriver font-italic text-light' >
                                  <div class="help-block" id='UnameErr'></div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="name">{{ __('msg.Position') }} </label>
                                <input type="text" class="form-control" name='position' id="position" placeholder="insert name">
                                <div class='errorsOfDriver font-italic text-light' >
                                  <div class="help-block" id='UnameErr'></div>
                                </div>
                              </div>
                              <div class="form-group">
                                    <label for="dpeartment" >{{ __('msg.Department') }}</label>
                                    <select class='form-control' name="department" id="department">
                                      <option value="">{{ __('Select a department') }}</option>
                                      <option value="Deputy Directorate of System development">{{ __('Deputy Directorate of System development') }}</option>
                                      <option value="GIS">{{ __('GIS') }}</option>
                                      <option value="Administration">{{ __('Administration') }}</option>
                                      <option value="Maslaki">{{ __('Maslaki') }}</option>
                                    </select>
                                    <div class='errorsOfDriver font-italic text-light' >
                                            <div class="help-block" id='UnameErr'></div>
                                    </div>
                              </div>
                              <div class="form-group">
                                <label for="name">{{ __('msg.Phone') }} </label>
                                <input type="text" class="form-control" name='phone' id="phone" placeholder="insert name">
                                <div class='errorsOfDriver font-italic text-light' >
                                  <div class="help-block" id='UnameErr'></div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="name">{{ __('msg.Email') }} </label>
                                <input type="text" class="form-control" name='email' id="email" placeholder="insert name">
                                <div class='errorsOfDriver font-italic text-light' >
                                  <div class="help-block" id='UnameErr'></div>
                                </div>
                              </div>
                          <div class="row">
                              <div class="form-group clear-fix col-md-12">
                                  <button type='submit' class='btn form-group col-sm-2 col-xs-2 float-right  btn-primary' name="saveInsert" id='saveInsert'>{{ __('msg.Save') }}</button>
                                  <span class="float-right">&nbsp</span>
                                  <button type='button' class='btn btn-dark col-sm-2 col-xs-2 float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('msg.Cancel') }}</button>
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
                          <form name="changePasswordForm" id="changePasswordForm">
                              @csrf
                              <input type="hidden" name="id" id="id" value="">
                              <div class="form-group">
                                  <label for="password">{{ __('msg.Current password') }} </label>
                                  <input type="password" class="form-control" name='previous_password' id="previous_password" placeholder="insert previous password">
                                  <div class='errorsOfDriver font-italic text-light' >
                                    <div class="help-block" id='UnameErr'></div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="new password">{{ __('msg.New password') }} </label>
                                  <input type="password" class="form-control" name='new_password' id="new_password" placeholder="insert new password">
                                  <div class='errorsOfDriver font-italic text-light' >
                                    <div class="help-block" id='UnameErr'></div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="cnpass">{{ __('msg.Confirm new password') }} </label>
                                  <input type="password" class="form-control" name='confirm_new_password' id="confirm_new_password" placeholder="confirm your password">
                                  <div class='errorsOfDriver font-italic text-light' >
                                    <div class="help-block" id='UnameErr'></div>
                                  </div>
                                </div>
                                <div class="form-group clear-fix col-md-12">
                                    <button type='submit' class='btn form-group col-sm-2 col-xs-2 float-right  btn-primary' name="changePassword" id='changePassword'>{{ __('msg.Change') }}</button>
                                    <span class="float-right">&nbsp</span>
                                    <button type='button' class='btn btn-dark col-sm-2 col-xs-2 float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('msg.Cancel') }}</button>
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
<style>
    .t210px {height:400px};
    .margin10px{margin-top: 10px;margin-bottom: 10px}
    .btn10px{margin-bottom:10px;margin-top:10px}
</style>


@if(Auth::check() && Auth::user()->status==true && Auth::user()->can('Create_booking'))
<div class="text-right d-inline-block" style="margin:5px">
        <button class="btn btn10px" style="background-color:yellowgreen" data-target="#pendingDiv" data-toggle="collapse">{{ __('msg.My pending bookings') }}</button>
</div>
    <div class="row justify-content-center collapse margin10px" id='pendingDiv'>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center" style="background-color:yellowgreen">
                    <h4 style="color:darkslategrey;display:inline-block"> {{ __('msg.My pending bookings') }}</h4>
                </div>

                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                         
                         <table class="table table-bordered table-responsive table-light t210px">
                            <thead>
                              <tr>
                                <th scope="col">{{ __('msg.Booking_Id') }}</th>
                                
                                <th scope="col">{{__('msg.User')}}</th>
                                <th scope="col">{{__('msg.Destination')}}</th>
                                <th scope="col">{{__('msg.Pickup_time')}}</th>
                                <th scope="col">{{  __('msg.Return_time')}}</th>
                                <th scope="col">{{__('msg.Count')}}</th>
                                <th scope="col">{{__('msg.Description')}}</th>
                                <th scope="col">{{__('msg.Approval')}}</th>
                                <th scope="col">{{__('msg.Created_at')}}</th>
                                <th scope="col">{{__('msg.Updated_at')}}</th>
                                <th scope="col" colspan="2" class='text-center'>{{ __('msg.Action') }}</th>
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
                                    <span style="background-color:yellowgreen;border-radius:3px;padding:4px;display:inline-block">  {{ __('msg.Pending')}}</span>
                                </td>
                                <td>{{$rowData->created_at}}</td>
                                <td>{{  $rowData->updated_at}}</td>  
                                     
                                <td><a href="/bookings/{{ $rowData->booking_id }}" id="{{ $rowData->booking_id }} "class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateModal">{{ __('msg.Update') }}</button></td>   
                                
                              </tr>  
                              @endif
                              @endforeach
                              
                            </tbody>
                          </table>
                    
                </div>
            </div>
        </div>
    </div>

    
    <div class="text-right d-inline-block " style="margin:5px">
            <button class="btn btn10px" data-target="#approvedDiv" style="color:white;background-color:dodgerblue" data-toggle="collapse">{{ __('msg.My approved bookings') }}</button>
    </div>
    <div class="row justify-content-center collapse margin10px" id='approvedDiv'>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center" style="background-color:dodgerblue">
                    <h4 style="color:lightyellow"> {{ __('msg.My approved bookings') }}</h4></div>
                <div class="card-body">    
                    <table class="table table-bordered table-responsive table-light t210px">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('msg.Booking_Id') }}</th>
                                <th scope="col">{{__('msg.Destination')}}</th>
                                <th scope="col">{{__('msg.Pickup_time')}}</th>
                                <th scope="col">{{  __('msg.Return_time')}}</th>
                                <th scope="col">{{__('msg.Count')}}</th>
                                <th scope="col">{{__('msg.Description')}}</th>
                               
                                <th scope="col">{{__('msg.Approver_description')}}</th>
                                <th scope="col">{{__('msg.Approval_pickup_time')}}</th>
                                <th scope="col">{{__('msg.Approval_return_time')}}</th>
                                <th scope="col">{{__('msg.Approver')}}</th>
                                <th scope="col">{{__('msg.Driver')}}</th>
                                <th scope="col">{{__('msg.Car_plate')}}</th>
                                <th scope="col">{{__('msg.Created_at')}}</th>
                                <th scope="col">{{__('msg.Updated_at')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($myBookings as $rowData)
                                @if(is_bool($rowData->approval) && $rowData->approval ===true)
                                    <tr>
                                        <th scope="row">{{$rowData->booking_id}}</th>
                                    
                                        <td>{{$rowData->destination}}</td>
                                        <td>{{$rowData->pickup_time}}</td>
                                        <td>{{$rowData->return_time}}</td>
                                        <td>{{$rowData->count}}</td>
                                        <td>{{$rowData->description}}</td>
                                        
                                        <td>{{$rowData->approver_description}}</td>
                                        <td>{{$rowData->approval_pickup_time}}</td>
                                        <td>{{$rowData->approval_return_time}}</td>
                                        <td>{{$rowData->approver_user_id}}</td>
                                        <td>{{$rowData->driver_id}}</td>
                                        <td>{{$rowData->plate_no}}</td>
                                        <td>{{$rowData->created_at}}</td>
                                        <td>{{  $rowData->updated_at}}</td>             
                                    </tr>  
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    
    <div class="text-right d-inline-block" style="margin:5px">
            <button class="btn btn10px" style="background-color:firebrick;color:white" data-target="#rejectedDiv" data-toggle="collapse">{{ __('msg.My rejected bookings') }}</button>
    </div>
    <div class="row justify-content-center collapse margin10px" id="rejectedDiv">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="background-color:firebrick;color:white">
                        
                      <h4>  {{ __('msg.My rejected bookings') }}</h4>
                    </div>
                    <div class="card-body">    
                        <table class="table table-bordered table-responsive table-light t210px">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('msg.Booking_Id') }}</th>
                                    <th scope="col">{{__('msg.Destination')}}</th>
                                    <th scope="col">{{__('msg.Pickup_time')}}</th>
                                    <th scope="col">{{__('msg.Return_time')}}</th>
                                    <th scope="col">{{__('msg.Count')}}</th>
                                    <th scope="col">{{__('msg.Description')}}</th>
                                    <th scope="col">{{__('msg.Approver_description')}}</th>
                                    <th scope="col">{{__('msg.Approver')}}</th>
                                    <th scope="col">{{__('msg.Created_at')}}</th>
                                    <th scope="col">{{__('msg.Updated_at')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myBookings as $rowData)
                                    @if(is_bool($rowData->approval) && $rowData->approval ===false)
                                        <tr>
                                            <th scope="row">{{$rowData->booking_id}}</th>
                                        
                                            <td>{{$rowData->destination}}</td>
                                            <td>{{$rowData->pickup_time}}</td>
                                            <td>{{$rowData->return_time}}</td>
                                            <td>{{$rowData->count}}</td>
                                            <td>{{$rowData->description}}</td>
                                            <td>{{$rowData->approver_description}}</td>
                                            <td>{{$rowData->approver_user_id}}</td>
                                            <td>{{$rowData->created_at}}</td>
                                            <td>{{  $rowData->updated_at}}</td> 
                                        </tr>  
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endif
    
    
        
        @if(auth()->user()->can('Approve_booking'))
        <div class="text-right d-inline-block" style="margin:5px">
                <button class="btn btn10px" style="background-color:teal;color:white" data-target="#appByMeDiv" data-toggle="collapse">{{ __('msg.Bookings approved by me') }}</button>
        </div>
        <div class="row justify-content-center collapse margin10px" id='appByMeDiv'>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="background-color:teal;color:white">
                        
                      <h4>  {{ __('msg.Bookings approved by me') }}</h4></div>
                    <div class="card-body">    
                        <table class="table table-bordered table-responsive table-light t210px">
                            <thead>
                                <tr>
                                  
                                <th scope="col">{{ __('msg.Booking_Id') }}</th>
                                <th scope="col">{{__('msg.User')}}</th>
                                <th scope="col">{{__('msg.Destination')}}</th>
                                <th scope="col">{{__('msg.Pickup_time')}}</th>
                                <th scope="col">{{  __('msg.Return_time')}}</th>
                                <th scope="col">{{__('msg.Count')}}</th>
                                <th scope="col">{{__('msg.Description')}}</th>
                                <th scope="col">{{__('msg.Approver_description')}}</th>
                                <th scope="col">{{__('msg.Approval_pickup_time')}}</th>
                                <th scope="col">{{__('msg.Approval_return_time')}}</th>
                                
                                <th scope="col">{{__('msg.Driver')}}</th>
                                <th scope="col">{{__('msg.Car_plate')}}</th>
                                <th scope="col">{{__('msg.Created_at')}}</th>
                                <th scope="col">{{__('msg.Updated_at')}}</th>
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
                                        <td>{{$rowData->approver_description}}</td>
                                        <td>{{$rowData->approval_pickup_time}}</td>
                                        <td>{{$rowData->approval_return_time}}</td>
                                        
                                        <td>{{$rowData->driver_id}}</td>
                                        <td>{{$rowData->plate_no}}</td>
                                        <td>{{$rowData->created_at}}</td>
                                        <td>{{  $rowData->updated_at}}</td>  
                                    </tr>  
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="text-right d-inline-block" style="margin:5px">
                <button class="btn btn10px" style="background-color:#764a2d;color:wheat" data-target="#rejByMeDiv" data-toggle="collapse">{{ __('msg.Bookings rejected by me') }}</button>
        </div>
        <div class="row justify-content-center collapse margin10px" id='rejByMeDiv'>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="background-color:#764a2d;color:white">
                        
                      <h4>  {{ __('msg.Bookings rejected by me') }}</h4></div>
                    <div class="card-body">    
                        <table class="table table-bordered table-responsive table-light t210px">
                            <thead>
                                <tr>
                                  
                                <th scope="col">{{ __('msg.Booking_Id') }}</th>
                                <th scope="col">{{__('msg.User')}}</th>
                                <th scope="col">{{__('msg.Destination')}}</th>
                                <th scope="col">{{__('msg.Pickup_time')}}</th>
                                <th scope="col">{{  __('msg.Return_time')}}</th>
                                <th scope="col">{{__('msg.Count')}}</th>
                                <th scope="col">{{__('msg.Description')}}</th>
                                <th scope="col">{{__('msg.Approver_description')}}</th>

                                <th scope="col">{{__('msg.Created_at')}}</th>
                                <th scope="col">{{__('msg.Updated_at')}}</th>
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
                                        <td>{{$rowData->approver_description}}</td>
                                        <td>{{$rowData->created_at}}</td>
                                        <td>{{  $rowData->updated_at}}</td>  
                                    </tr>  
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
{{--  
        <div class="text-right d-inline-block" style="margin:5px">
                <button class="btn btn10px" style="background-color:burlywood;" data-target="#userRejByMeDiv" data-toggle="collapse">{{ __('Users rejected by me') }}</button>
        </div>
        <div class="row justify-content-center collapse margin10px" id='userRejByMeDiv'>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="background-color:burlywood;color:white">
                        
                    <span>{{ $rejectedByMeCount .__(' Users rejected by me')}}</span>
                      <h4>  {{ __('Bookings approved by me') }}</h4></div>
                    <div class="card-body">    
                        <table class="table table-bordered table-responsive table-light t210px">
                            <thead>
                                <tr>
                                  
                                <th scope="col">{{ __('User Id') }}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Position')}}</th>
                                <th scope="col">{{__('Department')}}</th>
                                <th scope="col">{{  __('Email')}}</th>
                                <th scope="col">{{__('Phone')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th scope="col">{{__('Approver user Id')}}</th>
                                <th scope="col">{{ __('Created_at')}}</th> 
                                <th scope="col">{{__('Updated_at')}}</th>
                                <th scope="col" colspan="2" class='text-center'>{{ _('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usersRejectedByMe as $rowData)
                                    @if(is_bool($rowData->approval) && $rowData->approval ===false)
                                    <tr>
                                        <th scope="row">{{$rowData->id}}</th>
                                        <td>{{$rowData->name}}</td>
                                        <td>{{$rowData->position}}</td>
                                        <td>{{$rowData->department}}</td>
                                        <td>{{$rowData->email}}</td>
                                        <td>{{$rowData->phone}}</td>
                                        <td>{{$rowData->status}}</td>
                                        <td>{{$rowData->Approver}}</td>
                                        <td>{{$rowData->created_at}}</td>
                                        <td>{{$rowData->updated_at}}</td>
                                        <td>
                                            <span style="background-color:darkred;color:wheat;display:inline-block;border-radius:3px;padding:4px">  {{  _('Rejected')}}</span>
                                        </td>
                                        <td>{{$rowData->approver_description}}</td>
                                        <td>{{$rowData->approver_user}}</td>
                                        <td>{{$rowData->created_at}}</td>
                                        <td>{{  $rowData->updated_at}}</td>            
                                        <td><a href="/users/{{ $rowData->id }}" id="{{ $rowData->id }} "class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateModal">{{ __('Update') }}</button></td>   
                                         
                                    </tr>  
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right d-inline-block" style="margin:5px">
                <button class="btn btn10px" style="background-color:burlywood;" data-target="#userAppByMeDiv" data-toggle="collapse">{{ __('Users approved by me') }}</button>
        </div>
        <div class="row justify-content-center collapse margin10px" id='userAppByMeDiv'>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="background-color:burlywood;color:white">
                        
                    <span>{{ $rejectedByMeCount .__(' Users approved by me')}}</span>
                      <h4>  {{ __('Bookings approved by me') }}</h4></div>
                    <div class="card-body">    
                        <table class="table table-bordered table-responsive table-light t210px">
                            <thead>
                                <tr>
                                  
                                <th scope="col">{{ __('User Id') }}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Position')}}</th>
                                <th scope="col">{{__('Department')}}</th>
                                <th scope="col">{{  __('Email')}}</th>
                                <th scope="col">{{__('Phone')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th scope="col">{{__('Approver user Id')}}</th>
                                <th scope="col">{{ __('Created_at')}}</th> 
                                <th scope="col">{{__('Updated_at')}}</th>
                                <th scope="col" colspan="2" class='text-center'>{{ _('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usersApprovedByMe as $rowData)
                                    @if(is_bool($rowData->approval) && $rowData->approval ===true)
                                    <tr>
                                        <th scope="row">{{$rowData->id}}</th>
                                        <td>{{$rowData->name}}</td>
                                        <td>{{$rowData->position}}</td>
                                        <td>{{$rowData->department}}</td>
                                        <td>{{$rowData->email}}</td>
                                        <td>{{$rowData->phone}}</td>
                                        <td>{{$rowData->status}}</td>
                                        <td>{{$rowData->Approver_id}}</td>
                                        <td>{{$rowData->created_at}}</td>
                                        <td>{{$rowData->updated_at}}</td>
                                        <td>
                                            <span style="background-color:darkred;color:wheat;display:inline-block;border-radius:3px;padding:4px">  {{  _('Rejected')}}</span>
                                        </td>
                                        <td>{{$rowData->approver_description}}</td>
                                        <td>{{$rowData->Approver_id}}</td>
                                        <td>{{$rowData->created_at}}</td>
                                        <td>{{  $rowData->updated_at}}</td>            
                                        <td><a href="/users/{{ $rowData->id }}" id="{{ $rowData->id }} "class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateModal">{{ __('Update') }}</button></td>   
                                         
                                    </tr>  
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
          --}}
        
@if(
    auth()->user()->can('Read_driver_car')&&
    auth()->user()->can('Create_booking')&&
    auth()->user()->can('Read_user')&&
    auth()->user()->can('Read_users_role')&&
    auth()->user()->can('Read_role')OR
    auth()->user()->can('Read_driver_car')&&
    auth()->user()->can('Create_booking')&&
    auth()->user()->can('Read_user')&&
    auth()->user()->can('Read_users_role')&&
    auth()->user()->can('Create_driver_car')&&
    auth()->user()->can('Update_driver_car')&&
    auth()->user()->can('Approve_booking')&&
    auth()->user()->can('Update_booking')&&
    auth()->user()->can('Create_booking')&&
    auth()->user()->can('Create_user')&&
    auth()->user()->can('Approve_user')&&
    auth()->user()->can('Create_driver_car')
    )
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center" style="background-color:seagreen">
                <h4 style="color:lightgoldenrodyellow"> {{ __('msg.Dashboard') }}</h4></div>
                <div class="card-body">
    
                    <div class="card-group">
    
                        <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                            <div class="card-header"><h4 class="text-center">{{ __('msg.Users') }}</h4></div>
                            <div class="card-body">
                                
                                <h5 class="card-title">{{ __('msg.Total users: '). $totalUser }} </h5>
                                <h5 class="card-title">{{ __('msg.Approved users: '). $trueUser}}</h5>
                                <h5 class="card-title">{{ __('msg.Rejected users: '). $falseUser}}</h5>
                                <h5 class="card-title">{{ __('msg.Pending users: '). $pendingUser}}</h5>
                            </div>
                        </div>
    
                        <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                            <div class="card-header"><h4 class="text-center">{{ __('msg.Bookings') }}</h4></div>
                            <div class="card-body">       
                                <h5 class='card-title'>{{ __('msg.Total bookings: ').$totalBooking }}</h5>
                                <h5 class="card-title">{{ __('msg.Pending bookings: ').$pendingBookings }}</h5>
                                <h5 class='card-title'>{{   __('msg.Approved bookings: ').$ApprovedBookings }}</h5>
                                <h5 class='card-title'>{{   __('msg.Rejected bookings: ').$RejectedBookings }}</h5>
                            </div>
                        </div>
                        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                            <div class="card-header"><h4 class="text-center">{{ __('msg.Cars') }}</h4></div>
                            <div class="card-body">           
                                <h5 class='card-title'>{{ __('msg.Total cars: '). $totalCar}}</h5>
                                <h5 class='card-title'>{{ __('msg.Good condition cars: '). $trueCar}}</h5>
                                <h5 class='card-title'>{{ __('msg.Damaged cars: '). $falseCar}}</h5>
                            </div>
                        </div>
                        <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                            <div class="card-header"><h4 class="text-center">{{ __('msg.Drivers') }}</h4></div>
                            <div class="card-body">
                                <h5 class='card-title'>{{ __('msg.Total drivers: '). $totalDriver}}</h5>
                                <h5 class='card-title'>{{ __('msg.Present drivers: '). $trueDriver}}</h5>
                                <h5 class='card-title'>{{ __('msg.Absent drivers: '). $falseDriver}}</h5>
                            </div>
                        </div>
    
                    </div>                
                </div>
            </div>
        </div>
    </div>
    @endif

    
<div class="row justify-content-center margin10px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center" style="background-color:seagreen">
                <h4 style="color:lightgoldenrodyellow"> {{ __('msg.My profile') }}</h4></div>
                <div class="card-body">
                <div class="row">
                    <div class="card-group col-md-5 col-sm-12 col-xs-12">
                        <table class="table">
                               <tr> <th>{{ __('msg.ID') }}</th> <td>{{ $user->id }}</td></tr>
                               <tr> <th>{{ __('msg.Name') }}</th> <td>{{ $user->name }}</td></tr>
                               <tr> <th>{{ __('msg.Position') }}</th><td>{{ $user->position }}</td></tr>
                               <tr> <th>{{ __('msg.Department') }}</th><td>{{ $user->department }}</td></tr>
                               <tr> <th>{{ __('msg.Email') }}</th><td>{{ $user->email }}</td></tr>
                               <tr> <th>{{ __('msg.Phone') }}</th><td>0{{ $user->phone }}</td></tr>
                            
                            <tr> 
                                
                                <td colspan="2"><a href="/users/{{ $user->id }}" id="{{$user->id}}" class="btn btn-primary float-right btn-sm updateBtn">{{ __('msg.Update') }}</a>
                                    <span class="float-right">&nbsp;</span>
                                <a href="/changePassword/{{ $user->id }}" id="{{$user->id}}" class="btn btn-danger float-right btn-sm passBtn">{{ __('msg.Change password') }}</a></td>
                            </tr>
                        </table>       
                    </div> 
                    
                    @if(Auth::check() && Auth::user()->status==true && Auth::user()->can('Create_booking'))
                    <div class="card col-md-7 col-sm-12 ">
                            <div class="" style="padding:10px"><h4 class="text-center">{{ __('msg.One month ago of your activities') }}</h4><hr></div>
                            <div class="card-body">           
                                <h5 class='card-title' style="color:dodgerblue">{{ __('msg.Total of my approved bookings: '). $appr}}</h5>
                                <h5 class='card-title' style="color:firebrick">{{ __('msg.Total of my rejected bookings: ') . $rej}}</h5>
                                <h5 class='card-title' style="color:yellowgreen">{{ __('msg.Total of my pending bookings: ').$pend}}</h5>
                            @if(auth()->user()->can('Approve_booking'))    
                                <h5 class='card-title' style="color:teal">{{ __('msg.Total of bookings approved by you: '). $approvedByMeCount}}</h5>
                                <h5 class='card-title' style='color:#764a2d'>{{ __('msg.Total of bookings rejected by you: '). $rejectedByMeCount}}</h5>
                            @endif
                            @endif
                            </div>
                        </div>  
                    </div>
                         
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="card-body">
<h1 class="text-center text-success">
    {{ __('msg.Your request for membership is waiting for approving!') }}
</h1>
</div>
@endif

@endsection
