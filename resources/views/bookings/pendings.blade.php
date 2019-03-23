

@extends("layouts.app")
@section('content')

<!--  -->
@if(Auth::user()->can('Approve_booking'))
{{-- PENDING BOOKINGS --}}
<div id='updateModal' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content bg-primary">
      <!--content-->
        <div class="row">
          <div class="col-md-12">
            <div class="card text-white bg-secondary ">
            <div class="card-header">{{ __('msg.Booking approval') }}</div>
              <div class="card-body">
               
                  <form id='updateForm'>  

                      @csrf
                      <input type="hidden" name='booking_id' value="">
                      {{--  <input type="hidden" value={{ Auth::user()->id }} name='user_id'>  --}}
                      <div class="row" >
                          <div class=" options-approve form-group col-md-4">
                            <label for="approval"><b>{{ __('msg.Approval') }}</b> </label>&nbsp;
                            <select class='form-control form-control-sm' name='approval' id="approval">
                                <option value="true">{{ __('msg.TRUE') }}</option>
                                <option value="false">{{ __('msg.FALSE') }}</option>
                               
                              </select>
                          </div>
                          <div class="form-group col-md-4">
                            <label  for="car"><b>{{ __('msg.Car') }} </b></label>&nbsp;
                            <select name="plate_no" class="form-control form-control-sm" id="plate_no">
                              <option value="">{{ __('msg.Select a car') }}</option>
                              
                              @foreach ($freeCars as $item)
                              <option value="{{ $item->plate_no }}">{{ $item->type . "_" . $item->driver_id }}</option>
                             @endforeach
                            </select>
                          </div>
                          <div class="form-group col-md-4">
                            <label for="driver"><b>{{ __('msg.Driver') }} </b></label>&nbsp;
                            <select class='form-control form-control-sm' name='driver_id' id="driver_id">
                                <option value="">{{ __('msg.Select a driver') }}</option>
                                
                                @foreach ($freeDrivers as $item)
                                 <option value="{{ $item->driver_id }}">{{ $item->driver_id . "_" . $item->name ."_". $item->phone_no }}</option>
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
                            <textarea class='form-control' type='text' name="approver_description" id='approver_description' placeholder="{{ __('msg.Please write cause of approval  or rejection') }}"></textarea>
                            <div class="help-error"></div>
                          </div>
                          <div class="col-md-12 clear-fix float-right">
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
  @endif
  {{--  for approve details  --}}

  

  {{-- end of approve details  --}}
 
@if(Auth::user()->can('Approve_booking')||Auth::user()->can('Read_booking'))
  @if(!($countPendings))
  
  <h4>{{ __("msg.There are no pending booking wait for approving") }}</h4>
  @elseif($countPendings>0)
  <h4>{{ __("msg.Pending bookings number: "). $countPendings }}</h4>
  
   <div class="col-md-12 bg-white">
   <table class="table-approve table table-bordered">
      <tr>
      <th>{{ __('msg.Booking_Id') }}</th>
      <th>{{ __('msg.User') }}</th>
      <th>{{ __('msg.Count') }}</th>
      <th>{{ __('msg.Destination') }}</th>
      <th>{{ __('msg.Pickup_time') }}</th>
      <th>{{ __('msg.Return_time') }}</th>
      <th>{{ __('msg.Description') }}</th>
      
    @if(Auth::user()->can('Approve_booking'))
      <th colspan="2" class="text-center">{{ __('msg.Action') }}</th>
    @endif
    </tr>
    @foreach ($pendings as $data)  
    
   @php 
   $user_name =DB::table('users')->where('id',$data->user_id)->first();
   @endphp
      <tr>   
            <td> {{ $data->booking_id}}</td>
            <td>{{ $user_name->name . "_". $data->user_id}}</td>
            <td>{{ $data->count }}</td>
            <td>{{ $data->destination }}</td>
            <td>{{ $data->pickup_time }}</td>
            <td>{{ $data->return_time }}</td>
            <td>{{ $data->description }}</td>
          @if(Auth::user()->can('Approve_booking'))
            <td><a href="/bookings/{{ $data->booking_id }}" id="{{ $data->booking_id }} "class="btn btn-primary btn-sm updateBtn" data-toggle="modal" data-target="#updateModal">{{ __('msg.Approve or reject') }}</button></td>
          @endif
        </tr>
      @endforeach
      
    </table>
    </div>
    
  {{ $pendings->links() }}  
  @endif
  @endif
</div>

<script>
  $(document).ready(function(){

  });
</script>
 {{--  Approved tables  --}}

  @endsection()
