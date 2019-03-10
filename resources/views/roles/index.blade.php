


@extends("layouts.app")
@section('content')
  
<div id='driverTable'>
 
	<table id='dataTable' class="table table-bordered table-light" >
  <thead>
    <tr>
      <th scope="col">{{ __('ID') }}</th>
      <th scope="col">{{__('Name')}}</th>
      <th scope="col">{{__('permissions')}}</th>
 
      <th scope="col">{{__('created')}}</th>
      <th scope="col">{{__('updated')}}</th>
      {{--  <th scope="col" colspan="2" class='text-center'>Action</th>  --}}
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
       <span style="background-color:skyblue;display:inline-block;padding:4px;margin-right:4px;border-radius:4px"> {{ $value->name }}</span>
      @endforeach
      </td>
      <td>{{$rowData->created_at}}</td>
      <td>{{$rowData->updated_at}}</td>
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