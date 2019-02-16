@extends("layouts.app")
@section('content')

<!--  -->
<!-- Modal box-->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".insert-modal-lg">add new data</button>

<div id='insertModal' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
<!--content-->
              <div class="row">

                  <div class="col-md-12">

                  <div class="card text-white bg-secondary ">
                  <div class="card-header">Update</div>
                    <div class="card-body">
                    <form action=''>
                      @csrf
                      <div class="form-group">
                        <label for="name">{{ __('Name') }} </label>
                        <input type="text" class="form-control" name='driver_name' id="driver_name" placeholder="insert name">
                      </div>
                      <div class="form-group">
                        <label for="position">{{ __('Father Name') }}</label>
                        <input type="text" class="form-control" name="driver_f_name" id="driver_f_name" placeholder="insert father name">
                      </div>
                      <div class="form-group">
                        <label for="directorate">{{ __('Phone Number') }}</label>
                        <input type="text" class="form-control" id="driver_phone_no" name="driver_phone_no" placeholder="insert driver phone number ">
                      </div>
                      <div class="form-group">
                        <label for="formGroupExampleInput2">{{ __('Status') }}</label>
                        <input type="text" class="form-control" id="driver_status" name="driver_status" placeholder=" stattus ">
                      </div>
                      <div class="form-group clear-fix">
                        <button type='button' class='btn float-right btn-primary' name="saveUpdate" id='saveUpdate'>Save</button>
                        <span class="float-right">&nbsp</span>
                        <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">Cancel</button>
                      </div
                      >
                    </form>
                        
                  </div>
                </div>
                    
                </div>
            </div>    </div>
  </div>
</div>

<!-- /insert new finish  -->


<!-- upadate modal box -->
<div id='updateModal' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
      <!--content-->
              <div class="row">

                  <div class="col-md-12">

                  <div class="card text-white bg-secondary ">
                  <div class="card-header">Update</div>
                    <div class="card-body">
                    <form action=''>
                      @csrf
                      <div class="form-group">
                        <label for="name">{{ __('Name') }} </label>
                        <input type="text" class="form-control" name='driver_name' id="driver_name" placeholder="insert name">
                      </div>
                      <div class="form-group">
                        <label for="position">{{ __('Father Name') }}</label>
                        <input type="text" class="form-control" name="driver_f_name" id="driver_f_name" placeholder="insert father name">
                      </div>
                      <div class="form-group">
                        <label for="directorate">{{ __('Phone Number') }}</label>
                        <input type="text" class="form-control" id="driver_phone_no" name="driver_phone_no" placeholder="insert driver phone number ">
                      </div>
                      <div class="form-group">
                      <label for="formGroupExampleInput2">{{ __('Status') }}</label>
                        <input type="text" class="form-control" id="driver_status" name="driver_status" placeholder=" stattus ">
                      </div>
                      <div class="form-group clear-fix">
                        <button type='button' class='btn float-right btn-primary' name="saveUpdate" id='saveUpdate'>Save</button>
                        <span class="float-right">&nbsp</span>
                        <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">Cancel</button>
                      </div
                      >
                    </form>
                        
                  </div>
                </div>
                    
                </div>
            </div>
    </div>
  </div>
</div>

<!-- update modal box -->
<div id="rejectCase" class="modal fade insert-modal-lg" tabindex="-1" role="dialog">


</div>
<div class="text-center" style="margin-top:10px"><h4>PENDINGS BOOKS</h4></div>

@if($countOfRows==0)
<h6 class="text-center text-primary">There is no booking wait for approval</h6><br>
@else
<p id='countOfRows'>there are {{ $countOfRows }} bookings wait for approvement</p>
@endif

      @foreach($rows as $rowData)
    
      <form class='pending_table'>
      @csrf
  <table class="table table-bordered table-light">
      <thead>
        <tr>
          <th scope="col">{{ _('User ID') }}</th>
          <th scope="col">{{__('Pickup Time')}}</th>
          <th scope="col">{{__('Return Time')}}</th>
          <th scope="col">{{__('Count of persons')}}</th>
          <th scope="col">{{__('Destination')}}</th>
          <th scope="col">{{__('Description')}}</th>
          <th scope="col">{{__('Approval')}}</th>
          <th scope="col">{{__('Driver ID')}}</th>
          <th scope="col">{{__('Car ID')}}</th>
          <th scope="col" colspan="2" class='text-center'>Action</th>
        </tr>
      </thead>
        
        <tr>
          <td><input type="hidden" name="user_id" id="user_id" value="{{ $rowData->user_id }}">{{ $rowData->user_id}}</td>
          <td><input type="hidden" name='pickup_time' value="{{ $rowData->pickup_time }}"> {{ $rowData->pickup_time }}</td>
          <td><input type="hidden" name="return_time" id="return_time" value="{{ $rowData->return_time }}">{{$rowData->return_time}}</td>
          <td><input type="hidden" name='count' id='count' value="{{ $rowData->count }}">{{$rowData->count}}</td>
          <td><input type="hidden" name="destination" id="destination" value="{{ $rowData->destination }}">{{$rowData->destination}}</td>
          <td><input type="hidden" name="description" id="description" value="{{ $rowData->description }}">{{$rowData->description}}</td>
          <td> <select class="form-control" name="approval" id='approval'>
            <option value='true' selected>{{ _('True') }}</option>  
            <option value='false'>{{ _('False') }}</option>  
          </select></td>
          <td> <select  class="form-control" name="driver_id">
            <option selected value=''>NULL</option>
          <option value="1">1</option>  
          </select></td>
          <td> <select  class="form-control" name="car_id">
            <option selected value=''>NULL</option>
            <option value="1">1</option>
          </select></td>
          <td><button type="submit" name='approveBtn' class="btn btn-primary">{{ _('Approve') }}</button></td>   
          <td><button type='button' name='rejectBtn' class='btn rejectBtn btn-danger' data-toggle="modal" data-target="#rejectCase">{{ _('Reject') }} </button></td>
        </tr>
        </table>
      </form>
      
      @endforeach
    </tbody>
  </table>
<script>
  $(document).ready(function(){
    $(".rejectBtn").click(function(){
      $("#approval").val('false');
      alert("rejected");
     var data = $(this).closest('form').serialize();
    
  $.ajax({
    method: "post",
    url: "/bookings/reject",
    data: data,
    success:function(data){  
        console.log(data);  
    }
  });
    });
  });
</script>
 {{--  Approved tables  --}}

 <div class="text-center" style="margin-top:10px"><h4>APPROVED BOOKS</h4></div>
 <form name='approved_table' id='approved_table'>
  <table class="table table-bordered table-light">
      <thead>
        <tr>
          <th scope="col">{{ __('Booking Id') }}</th>
          <th scope="col">{{__('Pickup Time')}}</th>
          <th scope="col">{{__('Return Time')}}</th>
          <th scope="col">{{__('Count of persons')}}</th>
          <th scope="col">{{__('Destination')}}</th>
          <th scope="col">{{__('Description')}}</th>
          <th scope="col">{{__('Approval Status')}}</th>
          <th scope="col">{{__('Driver ID')}}</th>
          <th scope="col">{{__('Car ID')}}</th>
          <th scope="col">{{__('User ID')}}</th>
          <th scope="col" colspan="2" class='text-center'>Action</th>
        </tr>
      </thead>
      <tbody>
          @foreach($bookingsData as $rowData)
        <tr>
          <th scope="row">{{$rowData->booking_id}}</th>
        
          <td>{{$rowData->pickup_time}}</td>
          <td>{{$rowData->return_time}}</td>
          <td>{{$rowData->count}}</td>
          <td>{{$rowData->destination}}</td>
          <td>{{$rowData->description}}</td>
          <td>{{$rowData->approval}}</td>
          <td>{{$rowData->driver_id}}</td>
          <td>{{$rowData->car_id}}</td>
          <td>{{$rowData->user_id}}</td>
          <td><button type="button" class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateModal">Update</button></td>   
          <td><button class='deleteBtn btn btn-danger'>Delete </button></td>
        </tr>  
        @endforeach
        
      </tbody>
    </table>
  </form>

  @endsection()
