@extends("layouts.app")
@section('content')

<!--  -->
<!--  -->
    <div class="row">
          <div class="col-md-8 form-inline">
            <button id="insertButton" type="button" class="btn btn-primary btn-inline" style="margin-bottom: 3px;">{{ __('Registernewuser') }}</button>
            <div class="clear-fix"></div>
                    &nbsp&nbsp&nbsp    <h4>{{__('Total Approved Users: ') . $countOfUsers}}</h4>
                    &nbsp&nbsp&nbsp&nbsp&nbsp
                <form id='searchForm' class="form-inline" style="margin-bottom: 3px;">
                  @csrf
                  
                    <input type="text" id="searchInp" name="searchInp" class="form-control form-inline" placeholder="Search...">&nbsp
                    <select id="searchon" name="searchon" class="form-control" method='post'>
                        <option>{{__('Search By')}}</option>
                        <option value="id">{{ __('User ID')}}</option>
                        <option value="position">{{__('Position')}}</option>
                        <option value="directorate">{{__('Directorate')}}</option>
                        <option value="phone">{{__('Phone')}}</option>
                        <option value="email">{{__('Email')}}</option>
                        <option value="role">{{__('Role')}}</option>
                    </select>&nbsp
                    <button id='searchBtn' type="submit" class="btn btn-info form-control">Search</button><div class='clear-fix'></div>
                    {{ csrf_field() }}
                </form>   
          </div>      
    </div>

<!-- Modal box-->
<div id='insertModal' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 50%">
      <div class="modal-content bg-primary">
  <!--content-->
        <div class="row">
            <div class="col-md-12">
            <div class="card text-white bg-secondary ">
            <div class="card-header">Register new user</div>
              <div class="card-body">
                        <form name="insertForm" id="insertForm">
                            @csrf
                            <div class='row'>
                                <div class="form-group col-md-6">
                                    <label for="name" >{{ __('Name') }}</label>
                                    <input id="name" type="text" class="form-control" name='name'>
                                      <div class='errorsOfUsers font-italic text-light' >
                                          <div class="help-block " id='nameErr'> </div>
                                      </div>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label for="position" >{{ __('Position') }}</label>
                                    <input id="position" type="text" class="form-control" name="position" value="" autofocus>
                                    <div class='errorsOfUsers font-italic text-light' >
                                        <div class="help-block " id='positionErr'> </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="form-group col-md-6">
                                    <label for="directorate" >{{ __('Directorate') }}</label>
                                    <input id="directorate" name='directorate' type="text" class="form-control" value=""  autofocus>
                                    <div class='errorsOfUsers font-italic text-light' >
                                        <div class="help-block " id='directorateErr'> </div>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group col-md-6">
                                    <label for="phone" >{{ __('Phone') }}</label>
                                    <input id="phone" type="text" class="form-control" name="phone" value="" autofocus>
                                    <div class='errorsOfUsers font-italic text-light' >
                                        <div class="help-block " id='phoneErr'> </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="form-group col-md-6">
                                    <label for="email" >{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control" name="email" value="">
                                    <div class='errorsOfUsers font-italic text-light' >
                                        <div class="help-block " id='emailErr'> </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status" >{{ __('Status') }}</label>
                                    <select id="status" class="form-control" name="status">
                                      <option value="true">True</option>
                                      <option value="false">False</option>
                                    </select>
                                  </div>
                          </div>
                          <div class="row">
                              <div class="form-group col-md-6">
                                <label for="password" >{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control" name="password">
                                <div class='errorsOfUsers font-italic text-light' >
                                    <div class="help-block " id='passErr1'> </div>
                                </div>
                              </div>
                              
                              <div class="form-group col-md-6">
                                  <label for="password-confirm" >{{ __('Confirm Password') }}</label>
                                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                                  <div class='errorsOfUsers font-italic text-light' >
                                      <div class="help-block " id='passErr2'> </div>
                                  </div>
                              </div>
                          </div>
                          {{--  <input type="hidden" name='approver_user_id' value="{{ Auth::user()->id }}">  --}}
                          <div class="row">
                              <div class="form-group clear-fix col-md-12">
                                  <button type='submit' class='btn form-group col-sm-2 col-xs-2 float-right  btn-primary' name="saveInsert" id='saveInsert'>{{ __('Register') }}</button>
                                  <span class="float-right">&nbsp</span>
                                  <button type='button' class='btn btn-dark col-sm-2 col-xs-2 float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('Cancel') }}</button>
                                </div>
                          </div>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- /end of Register new user  -->


<!-- start of upadate modal box -->
<div id='updateModal' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">
      <!--content-->
              <div class="row">

                  <div class="col-md-12">

                  <div class="card text-white bg-secondary ">
                  <div class="card-header">Update user</div>
                    <div class="card-body">
                        <form name="updateForm" id="updateForm">
                            @csrf
                            <input type="hidden" name="id" id="id" value="">
                           
                            <div class='row'>
                                <div class="form-group col-md-12">
                                    <label for="status" >{{ __('Status') }}</label>
                                    <select id="status" class="form-control" name="status">
                                      <option value="true">Approve</option>
                                      <option value="false">Reject</option>
                                    </select>
                                  </div>
                          </div>
                         
                          <div class="row">
                              <div class="form-group clear-fix col-md-12">
                                  <button type='submit' class='btn form-group col-sm-2 col-xs-2 float-right  btn-primary' name="saveInsert" id='saveInsert'>{{ __('Register') }}</button>
                                  <span class="float-right">&nbsp</span>
                                  <button type='button' class='btn btn-dark col-sm-2 col-xs-2 float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('Cancel') }}</button>
                                </div>
                          </div>
                           
                        </form>
                        
                  </div>
                </div>
                    
                </div>
            </div>
    </div>
  </div>
</div>

<!-- update modal box -->
	<table class="table table-light table-bordered ">
  <thead>
    <tr>
      <th scope="col">{{ __('ID') }}</th>
      <th scope="col">{{ __('Name') }}</th>
      <th scope="col">{{ __('Position') }}</th>
      <th scope="col">{{ __('Directorate') }}</th>
      <th scope="col">{{ __('Email') }}</th>
      <th scope="col">{{ __('phone') }}</th>
      <th scope="col">{{ __('status') }}</th>
      <th scope="col">{{ __('Approver ID') }}</th>
      <th scope="col">{{ __('created_at') }}</th>
      <th scope="col">{{ __('updated_at') }}</th>
      <th scope="col" colspan="2" class='text-center'>{{ __('Action') }}</th>
    </tr>
  </thead>
  <tbody class="tableOfDriver">
  	@foreach($dataOfusersTable as $rowData)
    <tr>
      <th scope="row">{{$rowData->id}}</th>
      <td>{{$rowData->name}}</td>
      <td>{{$rowData->position}}</td>
      <td>{{$rowData->directorate}}</td>
      <td>{{$rowData->email}}</td>
      <td>0{{$rowData->phone}}</td>
      <td>
      @if(!(is_bool($rowData->status)))
      <span style="background-color:yellowgreen;border-radius:3px;padding:4px">  {{  _('pending')}}</span>
        @endif
        @if($rowData->status == 1 || $rowData->status ===true)
        <span style="background-color:dodgerblue;border-radius:3px;padding:4px">  {{  _('Approved')}}</span>
        @endif
        @if( $rowData->status === false && is_bool($rowData->status))
        <span style="color:white;background-color:firebrick;border-radius:3px;padding:4px">  {{  _('Rejected')}}</span>
        @endif
      </td>
      <td>{{ $rowData->approver_user_id }}</td>
      <td>{{ $rowData->created_at }}</td>
      <td>{{ $rowData->updated_at }}</td>
  		<td class='text-center'><a href="/users/{{ $rowData->id }}" id="{{$rowData->id}}" class="btn btn-primary updateBtn">Update</a></td>
	  
    </tr>
    @endforeach
  </tbody>
</table>
{{ $dataOfusersTable->links() }}
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
