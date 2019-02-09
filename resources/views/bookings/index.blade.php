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
  <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">{{ __('Booking Id') }}</th>
      <th scope="col">{{__('Start Time')}}</th>
      <th scope="col">{{__('End Time')}}</th>
      <th scope="col">{{__('List Of Persons')}}</th>
      <th scope="col">{{__('Destination')}}</th>
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
    
      <td>{{$rowData->start_time}}</td>
      <td>{{$rowData->end_time}}</td>
      <td>{{$rowData->list_of_persons}}</td>
      <td>{{$rowData->destination}}</td>
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
  <script type="text/javascript">
    
    jQuery(document).ready(function(){
          $("#saveUpdate").click(function(){
             alert('saved');
          });
         });
</script>
@endsection()
