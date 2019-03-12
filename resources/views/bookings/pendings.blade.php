

@extends("layouts.app")
@section('content')

<!--  -->
{{-- PENDING BOOKINGS --}}
<div id='updateModal' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content bg-primary">
      <!--content-->
        <div class="row">
          <div class="col-md-12">
            <div class="card text-white bg-secondary ">
            <div class="card-header">Approve or Reject Booking</div>
              <div class="card-body">
               
                  <form id='updateForm'>  

                      @csrf
                      <input type="hidden" name='booking_id' value="">
                      {{--  <input type="hidden" value={{ Auth::user()->id }} name='user_id'>  --}}
                      <div class="row" >
                          <div class=" options-approve form-group col-md-4">
                            <label for="approval"><b>{{ __('approval') }}</b> </label>&nbsp;
                            <select class='form-control form-control-sm' name='approval' id="approval">
                                <option value="true">{{ __('TRUE') }}</option>
                                <option value="false">{{ __('FALSE') }}</option>
                               
                              </select>
                          </div>
                          <div class="form-group col-md-4">
                            <label  for="car"><b>{{ __('car') }} </b></label>&nbsp;
                            <select name="plate_no" class="form-control form-control-sm" id="plate_no">
                              <option value="">SELECT A CAR</option>
                              
                              @foreach ($freeCars as $item)
                              <option value="{{ $item->plate_no }}">{{ $item->type . "_" . $item->driver_id }}</option>
                             @endforeach
                            </select>
                          </div>
                          <div class="form-group col-md-4">
                            <label for="driver"><b>{{ __('driver') }} </b></label>&nbsp;
                            <select class='form-control form-control-sm' name='driver_id' id="driver_id">
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
  
  {{--  for approve details  --}}

  

  {{-- end of approve details  --}}
 
  @if(!($countPendings))
  
  <h4>{{ __("There are no pending data wait for approving") }}</h4>
  @elseif($countPendings>0)
  <h4>{{ __("There are " . $countPendings . " pending data wait for approving") }}</h4>
  
   <div class="col-md-12 bg-white">
   <table class="table-approve table table-bordered">
      <tr>
      <th>{{ __('Booking ID') }}</th>
      <th>{{ __('User') }}</th>
      <th>{{ __('Count of persons') }}</th>
      <th>{{ __('Destination') }}</th>
      <th>{{ __('pickup time') }}</th>
      <th>{{ __('return time') }}</th>
      <th>{{ __('Description') }}</th>
      <th colspan="2" class="text-center">{{ __('Action') }}</th>
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
            <td><a href="/bookings/{{ $data->booking_id }}" id="{{ $data->booking_id }} "class="btn btn-primary btn-sm updateBtn" data-toggle="modal" data-target="#updateModal">approve or reject</button></td>
            
        </tr>
      @endforeach
      
    </table>
    </div>
    
  {{ $pendings->links() }}  
  @endif
</div>

<script>
  $(document).ready(function(){

  });
</script>
 {{--  Approved tables  --}}

  @endsection()
