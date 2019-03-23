@extends("layouts.app")
@section('content')
  
@php
use App\User;    
@endphp
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
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group" id='user_role'>
                        <span class="d-inline-block col-md-4 col-sm-4" >   {{ __('msg.Role Id: ') }}<span id='id'></span></span>
                        <span class="d-inline-block col-md-7 col-sm-7" >   {{ __('msg.Role name: ') }}<span id='name'></span></span>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                    <form id='updateForm' method="PUT">
                      @csrf
                      <input type='hidden' name='id' id='id' value=''>
                      <div class="form-group col-md-12">
                        <h4>{{ __('msg.Permissions') }}</h4><hr>
                        @foreach ($permissions as $permission)                  
                         <span class="checkbox-inline d-inline-block col-md-5 col-sm-5"> <label ><input type="checkbox" name='permission_name[]' value="{{ $permission->name }}">{{ $permission->name }}</label></span>
                        @endforeach
                      </div>
                      <div class="form-group clear-fix">
                        <button type='submit' class='btn float-right btn-primary' name="saveUpdate" id='saveUpdate'>{{ ('msg.Save') }}</button>
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
  </div>
</div>
<!--  -->
@if(Auth::user()->can('Create_role'))
<button type="button" data-target='#insertModal' data-toggle='modal' class="btn btn-primary btn-sm">{{ __('msg.Create new role') }}</button> 
<!-- create modal box -->
<div id='insertModal' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
      <!--content-->
              <div class="row">
                  <div class="col-md-12">
                  <div class="card text-white bg-secondary ">
                  <div class="card-header">{{ __('msg.New role creation') }}</div>
                    <div class="card-body">
                      <form id='insertForm' method="PUT">
                        @csrf
                        <div class="form-group">
                          <div class="form-group">
                            <label class="form-group" for='new_roel'>{{ __('msg.Name') }}</label>
                            <input class="form-control" name='new_role_name' id='new_role_name'>
                            <div class='errorsOfDriver font-italic text-light' >
                                <div class="help-block " id='new_role_error'> </div>
                            </div>
                          </div>
                          {{--  <input type='hidden' name='id' id='id' value=''>  --}}
                        <div class="form-group col-md-12">
                       <div>   
                         <h3 for='permissions' class="form-group" style="padding:4px;display:block">{{ __('msg.Assign permission') }}</h3>
                       </div><hr>
                          @foreach ($permissions as $per)
                          <span class='col-md-5 col-sm-12' style="display:inline-block">
                              <label class="checkbox-inline">
                                <input type="checkbox" name='permissions_name[]' value="{{ $per->name }}">{{ $per->name }}
                              </label>
                            </span>
                          @endforeach
                        </div>
                          <button type='submit' class='btn float-right btn-primary' name="create" id='create'>Create</button>
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
@endif
<!--  -->

@if(Auth::user()->can('Read_role'))
<div id='driverTable'>
 
	<table id='dataTable' class="table table-bordered table-light" >
  <thead>
    <tr>
      <th scope="col">{{ __('msg.ID') }}</th>
      <th scope="col">{{__('msg.Name')}}</th>
      <th scope="col">{{__('msg.Permissions')}}</th>
 
      <th scope="col">{{__('msg.Created_at')}}</th>
      <th scope="col">{{__('msg.Updated_at')}}</th>
  @if(Auth::user()->can('Update_role'))
      <th scope="col" class='text-center' colspan="2">{{__('msg.Action')}}</th>
  @endif

    </tr>
  </thead>
  <tbody class='tbodyOfDriver tableOfDriver'>
  	@foreach($roles as $rowData)
    <tr scope='row'>
      <td><b>{{$rowData->id}}</b></td>
      <td>{{$rowData->name}}</td>
      <td>
        @php 
         $permissionsForRoles = DB::table('roles')
          ->join('role_has_permissions', 'roles.id', '=', 'role_has_permissions.role_id')
          ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
          ->select('permissions.name')
          ->where('roles.id','=', $rowData->id )
          ->get();
          @endphp
      @foreach ($permissionsForRoles as $value )
       <span style="background-color:#00a99d;display:inline-block;padding:4px;margin:4px;border-radius:4px"> {{ $value->name }}</span>
      @endforeach
      </td>
      <td>{{$rowData->created_at}}</td>
      <td>{{$rowData->updated_at}}</td>
      @if(Auth::user()->can('Update_role'))
      	<td class='text-center'><a href="/roles/{{ $rowData->id }}" id="{{$rowData->id}}" class="btn btn-sm btn-primary updateBtn">{{ __('msg.give/change permission') }}</a></td>
      @endif
    
    </tr>
    @endforeach
  </tbody>
</table>
{{ $roles->links() }}
</div>
@endif
<!-- script part of page -->
	<script type="text/javascript">
//end of jqery                            
 </script>
@endsection()