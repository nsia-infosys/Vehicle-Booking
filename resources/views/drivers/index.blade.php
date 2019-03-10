@extends("layouts.app")
@section('content')
  

<!-- Button trigger modal -->

      
    <div class="row">
          <div class="col-md-8 form-inline">
            <button id="insertButton" type="button" class="btn btn-primary btn-inline" style="margin-bottom: 3px;">add new data</button>
            <div class="clear-fix"></div>
                    &nbsp&nbsp&nbsp    <h4>{{__('Total drivers: ') . $dataCounts}}</h4>
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
      
<div id='insertModal' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
<!--content-->
      <div class="row">
          <div class="col-md-12">
          <div class="card text-white bg-secondary ">
          <div class="card-header">Insert new data</div>
            <div class="card-body">
            <form method="POST" id='insertForm' name='insertForm'>
              @csrf
              <div class="form-group">
                <label for="name">{{ __('Name') }} </label>
                <input type="text" class="form-control" id='name' name='name' placeholder="insert name">
                 <div class='errorsOfDriver font-italic text-light' >
                      <div class="help-block " id='nameerr'> </div>
                </div>
              </div>
              
              <div class="form-group">
                <label for="father_name">{{ __('Father Name') }}</label>
                <input type="text" class="form-control" id="father_name"  name="father_name"  placeholder="insert father name">
                 <div class='errorsOfDriver text-light font-italic'>
                      <div class="help-block " id='fnErr'></div>
                </div>
              </div>
              
              <div class="form-group">
                <label for="phone_no">{{ __('Phone Number') }}</label>
                <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="insert driver phone number ">
               <div class='errorsOfDriver font-italic text-light'>
                      <div class="help-block " id='phErr'> </div>
                </div>
              </div>
              <div class="form-group">
                <label  for="car">{{ __('driver status') }}</label>
                <select class='form-control form-control-sm' name='status' id="status">
                     <option value=true>present</option>
                     <option value=false>absent</option>
                  </select>
              </div>
              <div class="form-group clear-fix">
                <button type='submit' class='btn float-right btn-primary' name="saveInsert" id='saveInsert'>Save</button>
                <span class="float-right">&nbsp</span>
                <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">Cancel</button>
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

<!-- /insert new finish  -->


<!-- upadate modal box -->
<div id='updateModal' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
      <!--content-->
              <div class="row">
                  <div class="col-md-12">
                  <div class="card text-white bg-secondary ">
                  <div class="card-header">UPDATE</div>
                    <div class="card-body">
                    <form id='updateForm' method="PUT">
                      @csrf
                      <input type='hidden' name='driver_id' id='driver_id' value=''>
                      <div class="form-group">
                        <label for="name">{{ __('Name') }} </label>
                        <input type="text" class="form-control" name='driver_name' id="driver_name" placeholder="insert name">
                        <div class='errorsOfDriver font-italic text-light' >
                          <div class="help-block" id='UnameErr'></div>
                        
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="position">{{ __('Father Name') }}</label>
                        <input type="text" class="form-control" name="driver_father_name" id="driver_father_name" placeholder="insert father name">
                        <div class='errorsOfDriver font-italic text-light' >
                          <div class="help-block" id='UfnErr'> </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="directorate">{{ __('Phone Number') }}</label>
                        <input type="text" class="form-control" id="driver_phone_no" name="driver_phone_no" placeholder="insert driver phone number ">
                        <div class='errorsOfDriver font-italic text-light' >
                            <div class="help-block" id='UphErr'> </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label  for="car">{{ __('driver status') }}</label>
                        <select class='form-control form-control-sm' name='driver_status'>
                             <option value=true>present</option>
                             <option value=false>absent</option>
                          </select>
                      </div>
              
                      <div class="form-group clear-fix">
                        <button type='submit' class='btn float-right btn-primary' name="saveUpdate" id='saveUpdate'>Save</button>
                        <span class="float-right">&nbsp</span>
                        <button class='btn btn-dark float-right' name="cancelUpdate" id='cancelUpdate' data-dismiss="modal">Cancel</button>
                      </div>
                      
                    </form>
                        
                  </div>
                </div>
                    
                </div>
            </div>
    </div>
  </div>
</div>
<!--  -->


<!--  -->
<!-- update modal box data -->
<div id='driverTable'>
  
	<table id='dataTable' class="table table-bordered table-light" >
  <thead>
    <tr>
      <th scope="col">{{ __('Driver ID') }}</th>
      <th scope="col">{{__('Name')}}</th>
      <th scope="col">{{__('Father Name')}}</th>
      <th scope="col">{{__('Phone Number')}}</th>
      <th scope="col">{{__('Status')}}</th>
      <th scope="col">{{__('created')}}</th>
      <th scope="col">{{__('updated')}}</th>
      <th scope="col" colspan="2" class='text-center'>Action</th>
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
  		<td><a href="/drivers/{{ $rowData->driver_id }}" id="{{$rowData->driver_id}}" class="btn btn-primary updateBtn" >Update</a></td>		
	  	<td><a href="/drivers/{{$rowData->driver_id}}" id="{{$rowData->driver_id}}" class='deleteBtn btn btn-danger'>Delete </button></td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $driversData->links() }}


</div>

<!-- script part of page -->
	<script type="text/javascript">
//end of jqery                            
 </script>
@endsection()

