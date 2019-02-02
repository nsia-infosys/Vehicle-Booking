@extends("layouts.app")
@section('content')

<!--  -->
<!-- Modal box-->
<div id='data'></div>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".insert-modal-lg">add new data</button>

<div id='insertModal' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
      <!--content-->
              <div class="row">

                  <div class="col-md-12">

                  <div class="card text-white bg-secondary ">
                  <div class="card-header">INSERT NEW USER </div>
                    <div class="card-body">
                    <form>
                      @csrf
                      <div class="form-group">
                        <label for="name">{{ __('Name') }} </label>
                        <input type="text" class="form-control" name='name' placeholder="insert name">
                      </div>
                      <div class="form-group">
                        <label for="position">{{ __('Position') }}</label>
                        <input type="text" class="form-control" name='position' placeholder="insert position">
                      </div>
                      <div class="form-group">
                        <label for="directorate">{{ __('Directorate') }}</label>
                        <input type="text" class="form-control"  name='directorate' placeholder="insert directorate">
                      </div>
                      <div class="form-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="text" class="form-control" name='emali' placeholder="insert email">
                      </div>
                      <div class="form-group clear-fix">
                        <button type='button' class='btn float-right btn-primary' name="saveInsert" id='saveInsert'>Save</button>
                        <span class="float-right">&nbsp</span>
                        <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">Cancel</button>
                      </div>
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
                  <div class="card-header">Update</div>
                    <div class="card-body">
                    <form action='' id='userForm' method="POST">
                      @csrf
                      <div class="form-group">
                        <label for="name">{{ __('Name') }} </label>
                        <input type="text" class="form-control" id="name" placeholder="insert name">
                      </div>
                      <div class="form-group">
                        <label for="position">{{ __('Position') }}</label>
                        <input type="text" class="form-control" id="position" placeholder="insert position">
                      </div>
                      <div class="form-group">
                        <label for="directorate">{{ __('Directorate') }}</label>
                        <input type="text" class="form-control" id='directorate' placeholder="insert directorate">
                      </div>
                      <div class="form-group">
                        <label for="formGroupExampleInput2">{{ __('Email') }}</label>
                        <input type="text" class="form-control" id='email' placeholder="insert email">
                      </div>
                      <div class="form-group clear-fix">
                        <button type='submit' class='btn float-right btn-primary' name="saveUpdate" id='saveUpdate'>Save</button>
                        <span class="float-right">&nbsp</span>
                        <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">Cancel</button>
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
	<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Position</th>
      <th scope="col">Directorate</th>
      <th scope="col">Email</th>
      <th scope="col" colspan="2" class='text-center'>Action</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($dataOfusersTable as $rowData)
    <tr>
      <th scope="row">{{$rowData->id}}</th>
      <td>{{$rowData->name}}</td>
      <td>{{$rowData->position}}</td>
      <td>{{$rowData->directorate}}</td>
      <td>{{$rowData->email}}</td>
  		<td><a href="/users/{{ $rowData->id }}" id="{{$rowData->id}}" class="btn btn-primary updateBtn">Update</a></td>
	  	<td><a href="/users/{{ $rowData->id}} " id="{{ $rowData->id}}" class='deleteBtn btn btn-danger'>Delete </button></td>
    </tr>
    @endforeach
  </tbody>
</table>
	<script type="text/javascript">
    
    jQuery(document).ready(function(){
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
     
      $(".updateBtn").click(function(e){
            var user_id = $(this).attr('id');
            e.preventDefault();
          $("#updateModal").modal('show');
         $.ajax({
            method : "GET",
            url : "/users" + "/" + user_id,
            data: user_id,
            success: function(data) {
              $("#name").val(data['name']);
              $("#position").val(data['position']);
                
              $("#email").val(data['email']);
              $("#directorate").val(data['directorate']);
            }
          });
      });
    	$("#saveUpdate").click(function(){
	      alert('saved');
      });
   });
</script>
@endsection()
