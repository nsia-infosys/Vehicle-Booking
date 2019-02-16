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
                        <option value="car_id">{{ __('Car ID')}}</option>
                        <option value="plate_no">{{ __('Plate Number')}}</option>
                        <option value="color">{{__('Car Color')}}</option>
                        <option value="type">{{__('Car Type')}}</option>
                        <option value="model">{{__('Car Model')}}</option>
                        <option value="driver_id">{{__('Driver ID')}}</option>
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
                        <div class='errorsOfDriver font-italic text-light' >
                      <div class="help-block " id='plate_no_err'> </div>
                </div>
                      </div>
                      <div class="form-group">
                        <label for="color">{{ __('Color') }}</label>
                        <input type="text" class="form-control" placeholder="insert color of car" name='color'>
                        <div class='errorsOfDriver font-italic text-light' >
                          <div class="help-block " id='color_error'> </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="model">{{ __('Model') }}</label>
                        <input type="text" class="form-control" name='model' placeholder="insert car model">
                        <div class='errorsOfDriver font-italic text-light' >
                          <div class="help-block " id='model_error'> </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="type">{{ __('Type') }}</label>
                        <input type="text" class="form-control" name='type' placeholder="type of car">
                        <div class='errorsOfDriver font-italic text-light' >
                          <div class="help-block " id='type_error'> </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="status">{{ __('Status') }}</label>
                        <input type="text" class="form-control"  placeholder="status of car" name="status">
                        <div class='errorsOfDriver font-italic text-light' >
                          <div class="help-block " id='status_error'> </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="driver_id">{{ __('Driver ID') }}</label>
                        <input type="text" class="form-control"  placeholder="driver id" name="driver_id" id='driver_id'>
                        <div class='errorsOfDriver font-italic text-light' >
                          <div class="help-block " id='driver_id_error'> </div>
                        </div>
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
                    <form id='updateForm'>
                      @csrf
                      <input type="hidden" name="" id='car_id'>
                      <div class="form-group">
                        <label for="name">{{ __('Plate number') }} </label>
                        <input type="text" class="form-control" id="plate_no" name="plate_no" placeholder="insert plate number">
                        <div class="help-block "> </div>
                      </div>
                      <div class="form-group">
                        <label for="position">{{ __('Color') }}</label>
                        <input type="text" class="form-control" id="car_color" name='car_color' placeholder="insert color of car">
                        <div class="help-block "> </div>
                      </div>
                      <div class="form-group">
                        <label for="directorate">{{ __('Model') }}</label>
                        <input type="text" class="form-control" id="car_model" name='car_model' placeholder="insert car model">
                        <div class="help-block "> </div>
                      </div>
                      <div class="form-group">
                        <label for="formGroupExampleInput2">{{ __('Type') }}</label>
                        <input type="text" class="form-control" id="car_type" name="car_type" placeholder="type of car">
                        <div class="help-block "> </div>
                      </div>
                      <div class="form-group">
                        <label for="formGroupExampleInput2">{{ __('Status') }}</label>
                        <input type="text" class="form-control" id="car_status" name="car_status" placeholder="status of car">
                        <div class="help-block "> </div>
                      </div>
                      <div class="form-group">
                        <label for="formGroupExampleInput2">{{ __('Driver ID') }}</label>
                        <input type="text" class="form-control" id="driver_id" placeholder="status of car" name='driver_id'>
                        <div class="help-block "> </div>
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
            </div>
    </div>
  </div>
</div>

<!-- update modal box -->
	<table class="table table-bordered table-light" id='dataTable'>
  <thead >
      <tr>
      <th scope="col">{{__('Car ID')}}</th>
      <th scope="col">{{__('Plate Number')}}</th>
      <th scope="col">{{__('Color')}}</th>
      <th scope="col">{{__('Model')}}</th>
      <th scope="col">{{__('Type')}}</th>
      <th scope="col">{{__('Status')}}</th>
      <th scope="col">{{__('Driver ID')}}</th>
      <th scope="col">{{__('Created')}}</th>
      <th scope="col">{{__('Updated')}}</th>
      <th scope="col" colspan="2" class='text-center'>Action</th>
    </tr>
  </thead>
  <tbody class="tableOfDriver">
    @foreach($carsData as $rowData)
    <tr>
      <td scope="row" style="font-weight: bold">{{$rowData->car_id}}</td>
      
      <td>{{$rowData->plate_no}}</td>
      <td>{{$rowData->color}}</td>
      <td>{{$rowData->model}}</td>
      <td>{{$rowData->type}}</td>
      <td>
        @if($rowData->status == "true")
          {{$rowData->status = 'True'}}
        @else {{$rowData->status = 'False'}}
        @endif
      </td>
      <td>
        @if($rowData->driver_id)
        {{$rowData->driver_id}}
        @else {{$rowData->driver_id="NULL"}}
        @endif
      </td>
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
