@extends("layouts.app")
@section('content')  

  <h3>Users Role </h3>
<div class="row">
        <div class="col-md-12 form-inline">
         <div class="clear-fix"></div>
              <form id='searchForm' class="form-inline" style="margin-bottom: 3px;">
                @csrf
                  <input type="text" id="searchInp" name="searchInp" class="form-control form-inline" placeholder="Search...">&nbsp
                  <select id="searchon" name="searchon" class="form-control" method='post'>
                      <option>{{__('Search By')}}</option>
                      <option value="id">{{ __('User ID')}}</option>
                      <option value="name">{{__('Name')}}</option>
                      <option value="role">{{__('Role')}}</option>
                  </select>&nbsp
                  <button id='searchBtn' type="submit" class="btn btn-info form-control">Search</button><div class='clear-fix'></div>
                  {{ csrf_field() }}
              </form>   
        </div>      
</div>

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
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group font-weight-light" id='user_role'>
                        <span style="display:inline-block; margin:10px">  {{ __('User ID: ') }}</b><span id='id'></span></span>
                        <span style="display:inline-block;margin:10px">   {{ __('User Name: ') }}</b><span id='name'></span></span>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                    <form id='updateForm' method="PUT">
                      @csrf
                      <input type='hidden' name='id' id='id' value=''>
                      <div class="form-group col-md-12">
                        @foreach ($roles as $role)
                         <span class="d-inline-block col-md-5" style="margin:4px;">
                            <label class="checkbox-inline"><input type="checkbox" name='role_name[]' value="{{ $role->name }}">{{ $role->name }}</label></span>
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
      
  		<td class='text-center'><a href="/roles/{{ $rowData->id }}" id="{{$rowData->id}}" class="btn btn-sm btn-primary updateBtn">{{ __('Add/Change role') }}</a></td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $users->links() }}
</div>
</div>
<!-- script part of page -->
	<script type="text/javascript">
//end of jqery                            
 </script>
@endsection()