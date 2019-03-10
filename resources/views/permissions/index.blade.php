


@extends("layouts.app")
@section('content')

  <div id='driverTable'>
  
	<table id='dataTable' class="table table-bordered table-light" >
  <thead>
    <tr>
      <th scope="col">{{ __('ID') }}</th>
      <th scope="col">{{__('Name')}}</th>
      <th scope="col">{{__('Description')}}</th>
      <th scope="col">{{__('created')}}</th>
      <th scope="col">{{__('updated')}}</th>
      
    </tr>
  </thead>
  <tbody class='tbodyOfDriver tableOfDriver'>
  	@foreach($permissions as $rowData)
    <tr scope='row'>
      <td><b>{{$rowData->id}}</b></td>
      <td>{{$rowData->name}}</td>
      <td>{{$rowData->permission_description}}</td>
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