@extends("layouts.app")
@section('content')
<div class='usersTable text-centered'>	
	<div class='text-center' >
		<h1>user tables</h1>
	</div>
		<div style="overflow-x:auto;">
			<table class='table-striped' style='margin:0 auto;'>
				<thead class="table">
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Position</th>
						<th>Directorate</th>
						<th>Email</th>
						<th colspan="2" class='text-center'>Action</th>
					</tr>			
				</thead>
				@foreach($tableData as $rowData)
					<tr class='table'>
						<td>{{$rowData->id}}</td>
						<td>{{$rowData->name}}</td>
						<td>{{$rowData->position}}</td>
						<td>{{$rowData->directorate}}</td>
						<td>{{$rowData->email}}</td>
						<td><button class='btn btn-danger'>Delete </button></td>
						<td><button class='btn btn-primary'>Update</button></td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>

	<!-- Button trigger modal -->


@endsection()