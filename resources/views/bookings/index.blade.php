@extends("layouts.app")
@section('content')

<!-- Modal box-->
<div id='updateModal' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
    <!--content-->
      <div class="row">
        <div class="col-md-12">
          <div class="card text-white bg-secondary ">
          <div class="card-header">{{ __('Update') }}</div>
            <div class="card-body">
                
              <form action='' id='updateForm'>
                  @csrf
                  <input type="hidden" name='booking_id' value="">
                  <div class="row" style="padding-left:15px;padding-right:15px">
                      <div class=" options-approve form-group col-md-4">
                        <label for="approval"><b>{{ __('approval') }}</b> </label>&nbsp;
                        <select class='form-control form-control-sm' name='approval' id="approval">
                            <option value="true">{{ __('TRUE') }}</option>
                            <option value="false">{{ __('FALSE') }}</option>
                          </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label  for="car"><b>{{ __('car') }} </b></label>&nbsp;
                        <select class='form-control form-control-sm plate_no' name='plate_no' id="plate_no">
                            <option value="">SELECT A CAR</option>
                            @foreach ($freeCars as $item)
                             <option value="{{ $item->plate_no }}">
                               {{ $item->plate_no . " _ " . $item->type ." _ " .$item->driver_id }}
                              </option>
                            @endforeach
  
                          </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="driver"><b>{{ __('driver') }} </b></label>&nbsp;
                        <select class='form-control form-control-sm driver_id' name='driver_id' id="driver_id">
                            <option value="">SELECT A DRIVER</option>
                            
                            @foreach ($freeDrivers as $item)
                             <option value="{{ $item->driver_id }}">{{ $item->driver_id . "_" . $item->name ."_". $item->phone_no }}</option>
                            @endforeach
                          </select>
                        </div>
                      <div class="form-group col-md-12 col-sm-12 col-lg-6">
                        <label for='approval_pickup_time'><b>{{ __('approval pickup time') }}</b></label>&nbsp;
                        <input class='form-control' type='text' name="approval_pickup_time" id='approval_pickup_time' value="" placeholder="yyyy-mm-dd hh:mm">
                      </div>
                      <div class="form-group col-md-12 col-sm-12 col-lg-6">
                        <label for='approval_return_time'><b>{{ __('approval return time') }}</b></label>&nbsp;
                        <input class='form-control' type='text' name="approval_return_time" id='approval_return_time' value="" placeholder="yyyy-mm-dd hh:mm">
                      </div>
                  
                      <div class="form-group col-md-12">
                        <label for='approver_description'><b>{{ __('approver description') }}</b></label>&nbsp;
                        <textarea class='form-control' type='text' name="approver_description" id='approver_description' placeholder=" are you agree or not agree, why?"></textarea>
                        <div class="help-error"></div>
                      </div>
                      <div class="col-md-12">
                 <input type="submit" value="APPROVE" class="btn float-right btn-primary">
                 <span class="float-right">&nbsp;</span>
                   <input type="button" value="REJECT" name='reject' class="btn float-right btn-danger">
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

<h5> {{ __('Pendings: ') . $pendingsCount.', ' . __('Approved: ')  . $approvedCount .', '. __('Rejected: ') }} {{ $rejectedCount }}</h5>
    <table class="table table-bordered table-responsive table-light">
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
          @foreach($bookingsData as $rowData)
          
        <tr>
          <th scope="row">{{$rowData->booking_id}}</th>
          <td>{{$rowData->user_id}}</td>
          <td>{{$rowData->destination}}</td>
          <td>{{$rowData->pickup_time}}</td>
          <td>{{$rowData->return_time}}</td>
          <td>{{$rowData->count}}</td>
          <td>{{$rowData->description}}</td>
          <td>
            @if($rowData->approval === true)
              <span style="background-color:dodgerblue;border-radius:3px;padding:4px">  {{  _('Approved')}}</span>
            @else
                <span style="color:white;background-color:firebrick;border-radius:3px;padding:4px">  {{  _('Rejected')}}</span>
            @endif  
          </td>
          <td>{{$rowData->approver_description}}</td>
          <td>{{$rowData->approval_pickup_time}}</td>
          <td>{{$rowData->approval_return_time}}</td>
          <td>{{$rowData->approver_user_id}}</td>
          <td>{{$rowData->driver_id}}</td>
          <td>{{$rowData->plate_no}}</td>
          <td>{{$rowData->created_at}}</td>
          <td>{{  $rowData->updated_at}}</td>  
               @if(
               Auth::user()->can('App_booking')&&
               Auth::user()->can('U_booking'))
          <td><a href="/bookings/{{ $rowData->booking_id }}" id="{{ $rowData->booking_id }} "class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateModal">Update</button></td>   
                @endif
        </tr>  
        @endforeach
        
      </tbody>
    </table>
 {{ $bookingsData->links() }}

  @endsection()
