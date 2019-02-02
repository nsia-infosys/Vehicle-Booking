@extends("layouts.app")
@section('content')

<!--  -->
    <div class="row">
          <div class="col-md-8 form-inline">
            <button id="insertButton" type="button" class="btn btn-primary btn-inline" style="margin-bottom: 3px;">add new data</button>
            <div class="clear-fix"></div>
                    &nbsp&nbsp&nbsp    <h4>{{__('Total cars: ') . $dataCounts}}</h4>
                    &nbsp&nbsp&nbsp&nbsp&nbsp
                <form id='searchForm' class="form-inline" style="margin-bottom: 3px;">
                  @csrf
                  
                    <input type="text" id="searchInp" name="searchInp" class="form-control form-inline" placeholder="Search...">&nbsp
                    <select id="searchon" name="searchon" class="form-control" method='post'>
                        <option>{{__('Search By')}}</option>
                        <option value="id">{{ __('ID')}}</option>
                        <option value="name">{{ __('Name')}}</option>
                        <option value="father_name">{{__('Father name')}}</option>
                        <option value="phone_no">{{__('phone number')}}</option>
                        <option value="status">{{__('Status')}}</option>
                    </select>&nbsp
                    <button id='searchBtn' type="submit" class="btn btn-info form-control">Search</button><div class='clear-fix'></div>
                    {{ csrf_field() }}
                  
                </form>      
  
  
          </div>      
    </div>

<!-- Modal box-->
<div id='insertModal' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
    <!--content-->
              <div class="row">

                  <div class="col-md-12">

                  <div class="card text-white bg-secondary ">
                  <div class="card-header">insert new data</div>
                    <div class="card-body">
                    <form action='' id='insertForm'>
                      @csrf
                      <div class="form-group">
                        <label for="name">{{ __('Plate number') }} </label>
                        <input type="text" class="form-control"  placeholder="insert plate number" name="plate_no">
                      </div>
                      <div class="form-group">
                        <label for="color">{{ __('Color') }}</label>
                        <input type="text" class="form-control" placeholder="insert color of car" name='color'>
                      </div>
                      <div class="form-group">
                        <label for="model">{{ __('Model') }}</label>
                        <input type="text" class="form-control" name='model' placeholder="insert car model">
                      </div>
                      <div class="form-group">
                        <label for="type">{{ __('Type') }}</label>
                        <input type="text" class="form-control" name='type' placeholder="type of car">
                      </div>
                      <div class="form-group">
                        <label for="status">{{ __('Status') }}</label>
                        <input type="text" class="form-control"  placeholder="status of car" name="status">
                      </div>
                      <div class="form-group">
                        <label for="driver_id">{{ __('Driver ID') }}</label>
                        <input type="text" class="form-control"  placeholder="driver id" name="driver_id">
                      </div>
                     
                      <div class="form-group clear-fix">
                        <button type='submit' class='btn float-right btn-primary' name="saveUpdate" id='saveUpdate'>Save</button>
                        <span class="float-right">&nbsp</span>
                        <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">Cancel</button>
                      </div
                      >
                    </form>
                        
                  </div>
                </div>
                    
                </div>
            </div></div>
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
                        <label for="name">{{ __('Plate number') }} </label>
                        <input type="text" class="form-control" id="plate_no" placeholder="insert plate number">
                      </div>
                      <div class="form-group">
                        <label for="position">{{ __('Color') }}</label>
                        <input type="text" class="form-control" id="car_color" placeholder="insert color of car">
                      </div>
                      <div class="form-group">
                        <label for="directorate">{{ __('Model') }}</label>
                        <input type="text" class="form-control" id="car_model" name='car_model' placeholder="insert car model">
                      </div>
                      <div class="form-group">
                        <label for="formGroupExampleInput2">{{ __('Type') }}</label>
                        <input type="text" class="form-control" id="car_type" placeholder="type of car">
                      </div>
                      <div class="form-group">
                        <label for="formGroupExampleInput2">{{ __('Status') }}</label>
                        <input type="text" class="form-control" id="car_status" placeholder="status of car">
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
      <th scope="col">{{__('Car ID')}}</th>
      <th scope="col">{{__('Plate Number')}}</th>
      <th scope="col">{{__('Color')}}</th>
      <th scope="col">{{__('Model')}}</th>
      <th scope="col">{{__('Type')}}</th>
      <th scope="col">{{__('Status')}}</th>
      <th scope="col">{{__('Created')}}</th>
      <th scope="col">{{__('Updated')}}</th>
      <th scope="col" colspan="2" class='text-center'>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($carsData as $rowData)
    <tr>
      <td scope="row" style="font-weight: bold">{{$rowData->car_id}}</td>
      
      <td>{{$rowData->plate_no}}</td>
      <td>{{$rowData->color}}</td>
      <td>{{$rowData->model}}</td>
      <td>{{$rowData->type}}</td>
      <td>{{$rowData->status}}</td>
      <td>{{$rowData->created_at}}</td>
      <td>{{$rowData->updated_at}}</td>
 		<td><a href="/cars/{{$rowData->car_id}}" id="{{ $rowData->car_id}}" class="btn btn-primary updateBtn">Update</a></td>		
	  	<td><a href="/cars/{{$rowData->car_id}}" id="{{ $rowData->car_id}}" class='deleteBtn btn btn-danger'>Delete </a></td>
    </tr>
    @endforeach
  </tbody>
</table>
	<script type="text/javascript">
   
</script>
@endsection()
