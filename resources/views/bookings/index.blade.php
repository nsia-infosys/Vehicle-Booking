@extends("layouts.app")
@section('content')
@if(Auth::user()->can('Update_booking'))
<!-- Modal box-->
<div id='updateModal' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
    <!--content-->
      <div class="row">
        <div class="col-md-12">
          <div class="card text-white bg-secondary ">
          <div class="card-header">{{ __('msg.Update') }}</div>
            <div class="card-body">
                
              <form action='' id='updateForm'>
                  @csrf
                  <input type="hidden" name='booking_id' value="">
                  <div class="row" style="padding-left:15px;padding-right:15px">
                      <div class=" options-approve form-group col-md-4">
                        <label for="approval"><b>{{ __('msg.Approval') }}</b> </label>&nbsp;
                        <select class='form-control form-control-sm' name='approval' id="approval">
                            <option value="true">{{ __('msg.TRUE') }}</option>
                            <option value="false">{{ __('msg.FALSE') }}</option>
                          </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label  for="car"><b>{{ __('msg.Car') }} </b></label>&nbsp;
                        <select class='form-control form-control-sm plate_no' name='plate_no' id="plate_no">
                            <option value="">{{ __('msg.Select a car')}}</option>
                            @foreach ($freeCars as $item)
                             <option value="{{ $item->plate_no }}">
                               {{ "(".$item->plate_no . ") " . $item->type }}
                              </option>
                            @endforeach
  
                          </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="driver"><b>{{ __('msg.Driver') }} </b></label>&nbsp;
                        <select class='form-control form-control-sm driver_id' name='driver_id' id="driver_id">
                            <option value="">{{ __('msg.Select a driver') }}</option>
                            
                            @foreach ($freeDrivers as $item)
                             <option value="{{ $item->driver_id }}">{{ $item->name ."  ". $item->phone_no }}</option>
                            @endforeach
                          </select>
                        </div>
                      <div class="form-group col-md-12 col-sm-12 col-lg-6">
                        <label for='approval_pickup_time'><b>{{ __('msg.Approval_pickup_time') }}</b></label>&nbsp;
                        <input class='form-control' type='text' name="approval_pickup_time" id='approval_pickup_time' value="" placeholder="yyyy-mm-dd hh:mm">
                      </div>
                      <div class="form-group col-md-12 col-sm-12 col-lg-6">
                        <label for='approval_return_time'><b>{{ __('msg.Approval_return_time') }}</b></label>&nbsp;
                        <input class='form-control' type='text' name="approval_return_time" id='approval_return_time' value="" placeholder="yyyy-mm-dd hh:mm">
                      </div>
                  
                      <div class="form-group col-md-12">
                        <label for='approver_description'><b>{{ __('msg.Approver_description') }}</b></label>&nbsp;
                        <textarea class='form-control' type='text' name="approver_description" id='approver_description' placeholder=" {{ __('msg.Cause of agreement') }}"></textarea>
                        <div class="help-error"></div>
                      </div>
                      <div class="col-md-12">
                 <input type="submit" value="{{ __('msg.Approve') }}" class="btn float-right btn-primary">
                 <span class="float-right">&nbsp;</span>
                   <input type="button" value="{{ __('msg.Reject') }}" name='reject' class="btn float-right btn-danger">
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
@endif
@if(Auth::user()->can('Read_booking'))
<h5> {{ __('msg.Pendings: ') . $pendingsCount.', ' . __('msg.Approved: ')  . $approvedCount .', '. __('msg.Rejected: ') }} {{ $rejectedCount }}</h5>
@endif
@if(Auth::user()->can('Update_booking')||Auth::user()->can('Read_booking'))    
<table class="table table-bordered table-responsive table-light">
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
          <th scope="col">{{__('msg.Approver_description')}}</th>
          <th scope="col">{{ __('msg.Approval_pickup_time')}}</th>
          <th scope="col">{{ __('msg.Approval_return_time')}}</th>
          <th scope="col">{{__('msg.Approver_user')}}</th>
          <th scope="col">{{__('msg.Driver')}}</th>
          <th scope="col">{{__('msg.Car')}}</th>
          <th scope="col">{{__('msg.Created_at')}}</th>
          <th scope="col">{{__('msg.Updated_at')}}</th>
          
      @if(Auth::user()->can('Update_booking'))
          <th scope="col" colspan="2" class='text-center'>{{ __('msg.Action') }}</th>
      @endif
        </tr>
      </thead>
      <tbody>
          @foreach($bookingsData as $rowData)
          
        <tr>
          <th scope="row">{{$rowData->booking_id}}</th>
          <td>{{$rowData->user_id}}</td>
          <td>{{$rowData->destination}}</td>
          <td>{{$rowData->pickup_time}}</td>
          <td>{{$rowData->return_time}}</td>
          <td>{{$rowData->count}}</td>
          <td><div style="min-width:300px">{{$rowData->description}}</div></td>
          <td>
            @if($rowData->approval === true)
              <span style="background-color:dodgerblue;border-radius:3px;padding:4px;display:inline-block">  {{  __('msg.Approved')}}</span>
            @else
                <span style="color:white;background-color:firebrick;border-radius:3px;padding:4px;display:inline-block">  {{  __('msg.Rejected')}}</span>
            @endif  
          </td>
          <td><div style="min-width:300px">{{$rowData->approver_description}}</div></td>
          <td>{{$rowData->approval_pickup_time}}</td>
          <td>{{$rowData->approval_return_time}}</td>
          <td>{{$rowData->approver_user_id}}</td>
          <td>{{$rowData->driver_id}}</td>
          <td>{{$rowData->plate_no}}</td>
          <td>{{$rowData->created_at}}</td>
          <td>{{  $rowData->updated_at}}</td>  
      @if(Auth::user()->can('Update_booking'))
          <td><a href="/bookings/{{ $rowData->booking_id }}" id="{{ $rowData->booking_id }} "class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateModal">{{ __('msg.Update') }}</button></td>   
      @endif
        </tr>  
        @endforeach
        
      </tbody>
    </table>
 {{ $bookingsData->links() }}
@endif
  @endsection()
