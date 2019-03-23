@extends("layouts.app")
@section('content')  
@if(Auth::user()->can('Read_users_role'))
  <h3>{{ __('msg.Users role') }} </h3>

@if(Auth::user()->can('Update_role'))
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
                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group font-weight-light" id='user_role'>
                        <span style="display:inline-block; margin:10px">  {{ __('msg.User Id: ') }}</b><span id='id'></span></span>
                        <span style="display:inline-block;margin:10px">   {{ __('msg.User name: ') }}</b><span id='name'></span></span>
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
  </div>
</div>
@endif
<!--  -->

<div id='driverTable'>
	<table id='dataTable' class="table table-bordered table-light" >
  <thead>
    <tr>
      <th scope="col">{{ __('msg.ID') }}</th>
      <th scope="col">{{__('msg.Name')}}</th>
      <th scope="col">{{__('msg.Roles')}}</th>
      
  @if(Auth::user()->can('Update_role'))
      <th scope="col" colspan="2" class='text-center'>{{ __('msg.Action') }}</th>
  @endif
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
  @if(Auth::user()->can('Update_role'))
  		<td class='text-center'><a href="/roles/{{ $rowData->id }}" id="{{$rowData->id}}" class="btn btn-sm btn-primary updateBtn">{{ __('msg.Give/Change role') }}</a></td>
  @endif  
    </tr>
    @endforeach
  </tbody>
</table>
{{ $users->links() }}
</div>
</div>
@endif
<!-- script part of page -->
	<script type="text/javascript">
//end of jqery                            
 </script>
@endsection()