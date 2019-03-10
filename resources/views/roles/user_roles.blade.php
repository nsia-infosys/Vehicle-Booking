@extends("layouts.app")
@section('content')  

  <h3>User Roles </h3>


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
                      <div class="row">
                        <div class="col-md-5 col-sm-6 col-xs-12 form-group" id='user_role'>
                        <p >   {{ __('User ID: ') }}<span id='id'></span></p>
                        <p >   {{ __('User Name: ') }}<span id='name'></span></p>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                    <form id='updateForm' method="PUT">
                      @csrf
                      <input type='hidden' name='id' id='id' value=''>
                      <div class="form-group col-md-12">
                        @foreach ($roles as $role)
                            
                         <p> <label class="checkbox-inline"><input type="checkbox" name='role_id[]' value="{{ $role->name }}">{{ $role->name }}</label></p>
                        @endforeach
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
  </div>
</div>
<!--  -->

<div id='driverTable'>
	<table id='dataTable' class="table table-bordered table-light" >
  <thead>
    <tr>
      <th scope="col">{{ __('ID') }}</th>
      <th scope="col">{{__('Name')}}</th>
      <th scope="col">{{__('Roles')}}</th>
      <th scope="col" colspan="2" class='text-center'>Action</th>
    </tr>
  </thead>
  <tbody class='tbodyOfDriver tableOfDriver'>
  	@foreach($users as $rowData)
    <tr scope='row'>
      <td><b>{{$rowData->id}}</b></td>
      <td>{{$rowData->name}}</td>
      <td>
          @php 
         $userHasRoles = DB::table('model_has_roles')
          ->join('users', 'users.id', '=', 'model_has_roles.model_id')
          ->join('roles','roles.id','=','model_has_roles.role_id')
          ->select('roles.name')
          ->where('users.id','=', $rowData->id )
          ->get();
          @endphp
        
        @foreach ($userHasRoles as $role)
        <span style="color:white;background-color:firebrick;display:inline-block;padding:2px;border-radius:4px;margin:1px">  {{  $role->name}} </span>
        @endforeach
      </td>
      
  		<td class='text-center'><a href="/roles/{{ $rowData->id }}" id="{{$rowData->id}}" class="btn btn-sm btn-primary updateBtn">Change Role</a></td>
    </tr>
    @endforeach
  </tbody>
</table>

</div>

<!-- script part of page -->
	<script type="text/javascript">
//end of jqery                            
 </script>
@endsection()