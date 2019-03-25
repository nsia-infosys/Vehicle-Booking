@extends("layouts.app")
@section('content')
@php

@endphp
<!--  -->
    <div class="row">
          <div class="col-md-8 form-inline">
            @if(Auth::user()->can('Create_driver_car'))
            <button id="insertButton" type="button" class="btn btn-primary btn-inline" style="margin-bottom: 3px;">{{ __('msg.Register new car') }}</button>
           @endif
           @if(Auth::user()->can('Read_driver_car'))
            <div class="clear-fix"></div>
                    &nbsp&nbsp&nbsp     <h4>{{__('msg.Total cars: ') . $dataCounts}}</h4>
                    &nbsp&nbsp&nbsp&nbsp&nbsp 
            @endif
            @if(Auth::user()->can('Read_driver_car')||Auth::user()->can('Update_driver_car'))
            <form id='searchForm' class="form-inline" style="margin-bottom: 3px;">
                  @csrf
                  
                    <input type="text" id="searchInp" name="searchInp" class="form-control form-inline" placeholder="{{ __('msg.Search') }}">&nbsp
                    <select id="searchon" name="searchon" class="form-control" method='post'>
                        <option>{{__('msg.Search by')}}</option>
                        <option value="plate_no">{{ __('msg.Plate number')}}</option>
                        <option value="color">{{__('msg.Car color')}}</option>
                        <option value="type">{{__('msg.Car type')}}</option>
                        <option value="model">{{__('msg.Car model')}}</option>
                        <option value="driver_id">{{__('msg.Driver Id')}}</option>
                        <option value="status">{{__('msg.Status')}}</option>
                    </select>&nbsp
                    <button id='searchBtn' type="submit" class="btn btn-info form-control">{{ __('msg.Search') }}</button><div class='clear-fix'></div>
                    {{ csrf_field() }}
                </form>
                @endif   
          </div>      
    </div>

 @if(Auth::user()->can('Create_driver_car'))   
<!-- Modal box-->
<div id='insertModal' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
    <!--content-->
              <div class="row">

                  <div class="col-md-12">

                  <div class="card text-white bg-secondary ">
                  <div class="card-header">{{ __('msg.New car registeration') }}</div>
                    <div class="card-body">
                    <form action='' id='insertForm'>
                      @csrf
                      <div class="form-group">
                        <label for="name">{{ __('msg.Plate number') }} </label>
                        <input type="text" class="form-control"  placeholder="insert plate number" name="plate_no">
                        <div class='errorsOfDriver font-italic text-light' >
                      <div class="help-block " id='plate_no_err'> </div>
                </div>
                      </div>
                      <div class="form-group">
                        <label for="color">{{ __('msg.Color') }}</label>
                        <input type="text" class="form-control" placeholder="insert color of car" name='color'>
                        <div class='errorsOfDriver font-italic text-light' >
                          <div class="help-block " id='color_error'> </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="model">{{ __('msg.Model') }}</label>
                        <input type="text" class="form-control" name='model' placeholder="insert car model">
                        <div class='errorsOfDriver font-italic text-light' >
                          <div class="help-block " id='model_error'> </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="type">{{ __('msg.Type') }}</label>
                        <input type="text" class="form-control" name='type' placeholder="type of car">
                        <div class='errorsOfDriver font-italic text-light' >
                          <div class="help-block " id='type_error'> </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="status">{{ __('msg.Status') }}</label>
                        <select class="form-control"  placeholder="status of car" name="status">
                          <option value="true">{{ __('msg.Prepared') }}</option>
                          <option value="false">{{ __('msg.Damaged') }}</option>
                        </select>
                        <div class="help-block " id='status_error'> </div>
                      </div>
                      
                      <div class="form-group">
                          <label for="driver">{{ __('msg.Driver') }}</label>
                          <select class="form-control"  name="driver_id">
                            
                            <option value="">{{ __('msg.NULL') }}</option>
                            @foreach ($drivers as $driver)
                            <option value="{{ $driver->driver_id }}"> {{ $driver->driver_id . " _ " . $driver->name  }}</option>
                            @endforeach
                          </select>
                          <div class="help-block " id='type_error'> </div>
                      </div>
                      
                      <div class="form-group clear-fix">
                        <button type='submit' class='btn float-right btn-primary' name="saveUpdate" id='saveUpdate'>{{ __('msg.Save') }}</button>
                        <span class="float-right">&nbsp</span>
                        <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('msg.Cancel') }}</button>
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

<!-- /insert new finish  -->
@endif

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
                      <input type="hidden" name="plate_no_for_update" id='plate_no_for_update'>
                      <div class="form-group">
                        <label for="name">{{ __('msg.Plate number') }} </label>
                        <input type="text" class="form-control" id="plate_no" name="plate_no" placeholder="insert plate number">
                        <div class="help-block "> </div>
                      </div>

                      <div class="form-group">
                        <label for="position">{{ __('msg.Color') }}</label>
                        <input type="text" class="form-control" id="car_color" name='car_color' placeholder="insert color of car">
                        <div class="help-block "> </div>
                      </div>

                      <div class="form-group">
                        <label for="directorate">{{ __('msg.Model') }}</label>
                        <input type="text" class="form-control" id="car_model" name='car_model' placeholder="insert car model">
                        <div class="help-block "> </div>
                      </div>

                      <div class="form-group">
                        <label for="formGroupExampleInput2">{{ __('msg.Type') }}</label>
                        <input type="text" class="form-control" id="car_type" name="car_type" placeholder="type of car">
                        <div class="help-block "> </div>
                      </div>
                      
                      <div class="form-group">
                          <label for="status">{{ __('msg.Status') }}</label>
                          <select class="form-control"  name="car_status" id='car_status'>
                            <option value="true">{{ __('msg.Prepared') }}</option>
                            <option value="false">{{  __('msg.Damaged')}}</option>
                          </select>
                          <div class="help-block " id='status_error'> </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="driver">{{ __('msg.Driver') }}</label>
                            <select class="form-control"  name="driver_id">
                              <option value="">{{ __('msg.NULL') }}</option>
                              @foreach ($drivers as $driver)
                              <option value="{{ $driver->driver_id }}"> {{ $driver->driver_id . " _ " . $driver->name  }}</option>
                              @endforeach
                            </select>
                            <div class="help-block " id='driver_error'> </div>
                          </div>
                          
                      <div class="form-group clear-fix">
                        <button type='submit' class='btn float-right btn-primary' name="saveUpdate" id='saveUpdate'>{{ __('msg.Save') }}</button>
                        <span class="float-right">&nbsp</span>
                        <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('msg.Cancel') }}</button>
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
@if(Auth::user()->can('Read_driver_car')||Auth::user()->can('Update_driver_car'))
	<table class="table table-bordered table-light" id='dataTable'>
  <thead >
      <tr>
      
      <th scope="col">{{ __('msg.Plate number')}}</th>
      <th scope="col">{{__('msg.Color')}}</th>
      <th scope="col">{{__('msg.Model')}}</th>
      <th scope="col">{{__('msg.Type')}}</th>
      <th scope="col">{{__('msg.Status')}}</th>
      <th scope="col">{{__('msg.Driver Id')}}</th>
      <th scope="col">{{__('msg.Created_at')}}</th>
      <th scope="col">{{ __('msg.Updated_at')}}</th>
      
    @if(Auth::user()->can('Update_driver_car'))
      <th scope="col" colspan="2" class='text-center'>{{ __('msg.Action') }}</th>
    @endif
    </tr>
  </thead>
  <tbody class="tableOfDriver">
    @foreach($carsData as $rowData)
    <tr>
      <td scope="row" style="font-weight: bold">{{$rowData->plate_no}}</td>
      
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
      @if(Auth::user()->can('Update_driver_car'))
      <td><a href="/cars/{{$rowData->plate_no}}" id="{{ $rowData->plate_no}}" class="btn btn-primary btn-sm updateBtn">{{ __('msg.Update') }}</a></td>
      @endif		
    </tr>
    @endforeach
  </tbody>
</table>
{{ $carsData->links()}}
@endif
	<script type="text/javascript">
   
</script>
@endsection()
