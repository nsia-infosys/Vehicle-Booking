@extends("layouts.app")
@section('content')
  

<!-- Button trigger modal -->

      
    <div class="row">
          <div class="col-md-8 form-inline"> 
          @if(Auth::user()->can('Create_driver_car'))
            <button id="insertButton" type="button" class="btn btn-primary btn-sm btn-inline" style="margin-bottom: 3px;">{{ __('msg.Register new driver') }}</button>
          @endif
            <div class="clear-fix"></div>
            @if(Auth::user()->can('Read_driver_car'))
                    &nbsp&nbsp&nbsp    
                  <h4>{{__('msg.Total drivers: ') . $dataCounts}}</h4>
                    &nbsp&nbsp&nbsp&nbsp&nbsp
            @endif
          @if(Auth::user()->can('Read_driver_car')||Auth::user()->can('Update_driver_car'))
                <form id='searchForm' class="form-inline" style="margin-bottom: 3px;">
                  @csrf
                  
                    <input type="text" id="searchInp" name="searchInp" class="form-control form-inline" placeholder="{{ __('msg.Search') }}">&nbsp
                    <select id="searchon" name="searchon" class="form-control" method='post'>
                        <option>{{__('msg.Search by')}}</option>
                        <option value="id">{{ __('msg.ID')}}</option>
                        <option value="name">{{ __('msg.Name')}}</option>
                        <option value="father_name">{{__('msg.Father name')}}</option>
                        <option value="phone_no">{{__('msg.Phone number')}}</option>
                        <option value="status">{{__('msg.Status')}}</option>
                    </select>&nbsp
                    <button id='searchBtn' type="submit" class="btn btn-info form-control">{{ __('msg.Search') }}</button><div class='clear-fix'></div>
                    {{ csrf_field() }}
                  
                </form>      
  
                @endif
          </div>      
    </div>
      
    @if(Auth::user()->can('Create_driver_car'))
<div id='insertModal' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
<!--content-->
      <div class="row">
          <div class="col-md-12">
          <div class="card text-white bg-secondary ">
          <div class="card-header">{{ __('msg.New driver registeration') }}</div>
            <div class="card-body">
            <form method="POST" id='insertForm' name='insertForm'>
              @csrf
              <div class="form-group">
                <label for="name">{{ __('msg.Name') }} </label>
                <input type="text" class="form-control" id='name' name='name' placeholder="{{ __('msg.Insert name') }}">
                 <div class='errorsOfDriver font-italic text-light' >
                      <div class="help-block " id='nameerr'> </div>
                </div>
              </div>
              
              <div class="form-group">
                <label for="father_name">{{ __('msg.Father name') }}</label>
                <input type="text" class="form-control" id="father_name"  name="father_name"  placeholder="{{ __('msg.Insert father name') }}">
                 <div class='errorsOfDriver text-light font-italic'>
                      <div class="help-block " id='fnErr'></div>
                </div>
              </div>
              
              <div class="form-group">
                <label for="phone_no">{{ __('msg.Phone number') }}</label>
                <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="{{ __('msg.Insert phone number') }} ">
               <div class='errorsOfDriver font-italic text-light'>
                      <div class="help-block " id='phErr'> </div>
                </div>
              </div>
              <div class="form-group">
                <label  for="car">{{ __('msg.Driver existence') }}</label>
                <select class='form-control form-control-sm' name='status' id="status">
                     <option value=true>{{ __('msg.Present') }}</option>
                     <option value=false>{{ __('msg.Absent') }}</option>
                  </select>
              </div>
              <div class="form-group clear-fix">
                <button type='submit' class='btn float-right btn-primary' name="saveInsert" id='saveInsert'>{{ __('msg.Save') }}</button>
                <span class="float-right">&nbsp</span>
                <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('msg.Cancel') }}</button>
              </div>
              {{ csrf_field() }}
            
            </form>
          </div>
        </div>    
      </div>
     </div>    
    </div>
  </div>
</div>
@endif
<!-- /insert new finish  -->


@if(Auth::user()->can('Update_driver_car'))
<!-- upadate modal box -->
<div id='updateModal' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
      <!--content-->
              <div class="row">
                  <div class="col-md-12">
                  <div class="card text-white bg-secondary ">
                  <div class="card-header">{{ __('msg.Update') }}</div>
                    <div class="card-body">
                    <form id='updateForm' method="PUT">
                      @csrf
                      <input type='hidden' name='driver_id' id='driver_id' value=''>
                      
                      <div class="form-group">
                        <label for="name">{{ __('msg.Name') }} </label>
                        <input type="text" class="form-control" name='driver_name' id="driver_name" placeholder="{{ __('msg.Insert name') }}">
                        <div class='errorsOfDriver font-italic text-light' >
                          <div class="help-block" id='UnameErr'></div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="position">{{ __('msg.Father name') }}</label>
                        <input type="text" class="form-control" name="driver_father_name" id="driver_father_name" placeholder="{{ __('msg.Insert father name') }}">
                        <div class='errorsOfDriver font-italic text-light' >
                          <div class="help-block" id='UfnErr'> </div>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="directorate">{{ __('msg.Phone number') }}</label>
                        <input type="text" class="form-control" id="driver_phone_no" name="driver_phone_no" placeholder="{{ __('msg.Insert phone number')}} ">
                        <div class='errorsOfDriver font-italic text-light' >
                            <div class="help-block" id='UphErr'> </div>
                        </div>
                      </div>
              
                      <div class="form-group">
                        <label  for="car">{{ __('msg.Driver existence') }}</label>
                        <select class='form-control form-control-sm' name='driver_status'>
                             <option value=true>{{ __('msg.Present') }}</option>
                             <option value=false>{{ __('msg.Absent') }}</option>
                          </select>
                      </div>
              
                      <div class="form-group clear-fix">
                        <button type='submit' class='btn float-right btn-primary' name="saveUpdate" id='saveUpdate'>{{ __('msg.Save') }}</button>
                        <span class="float-right">&nbsp</span>
                        <button class='btn btn-dark float-right' name="cancelUpdate" id='cancelUpdate' data-dismiss="modal">{{ __('msg.Cancel') }}</button>
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
<!--  -->


<!--  -->
<!-- update modal box data -->
@if(Auth::user()->can('Read_driver_car')||Auth::user()->can('Update_driver_car'))
<div id='driverTable'>
  
	<table id='dataTable' class="table table-bordered table-light" >
  <thead>
    <tr>
      <th scope="col">{{ __('msg.Driver Id') }}</th>
      <th scope="col">{{__('msg.Name')}}</th>
      <th scope="col">{{__('msg.Father name')}}</th>
      <th scope="col">{{__('msg.Phone number')}}</th>
      <th scope="col">{{__('msg.Driver existence')}}</th>
      <th scope="col">{{__('msg.Created_at')}}</th>
      <th scope="col">{{__('msg.Updated_at')}}</th>
      
    @if(Auth::user()->can('Update_driver_car'))
      <th scope="col" colspan="2" class='text-center'>{{ __('msg.Action') }}</th>
    @endif
    </tr>
  </thead>
  <tbody class='tbodyOfDriver tableOfDriver'>
  	@foreach($driversData as $rowData)
    <tr scope='row'>
      <td><b>{{$rowData->driver_id}}</b></td>
      <td>{{$rowData->name}}</td>
      <td>{{$rowData->father_name}}</td>
      <td>{{$rowData->phone_no}}</td>
      <td>
        @if($rowData->status == "true")
          {{$rowData->status = 'true'}}
        @else {{$rowData->status = 'false'}}
      @endif
      </td>
      <td>{{$rowData->created_at}}</td>
      <td>{{$rowData->updated_at}}</td>
    @if(Auth::user()->can('Update_driver_car'))
  		<td><a href="/drivers/{{ $rowData->driver_id }}" id="{{$rowData->driver_id}}" class="btn btn-primary btn-sm updateBtn" >{{ __('msg.Update') }}</a></td>		
	  @endif
    </tr>
    @endforeach
  </tbody>
</table>

{{ $driversData->links() }}


</div>
@endif
<!-- script part of page -->
	<script type="text/javascript">
//end of jqery                            
 </script>
@endsection()

