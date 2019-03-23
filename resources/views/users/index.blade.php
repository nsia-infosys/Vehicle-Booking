@extends("layouts.app")
@section('content')

<!--  -->
<!--  -->
    <div class="row">
          <div class="col-md-8 form-inline">
            @if(Auth::user()->can('Create_user'))
            <button id="insertButton" type="button" class="btn btn-primary btn-inline" style="margin-bottom: 3px;">{{ __('msg.Register new user') }}</button>
            @endif
            <div class="clear-fix"></div>
            @if(Auth::user()->can('Read_user'))
                    &nbsp&nbsp&nbsp    <h4>{{__('msg.Total approved users: ') . $countOfUsers}}</h4>
                    &nbsp&nbsp&nbsp&nbsp&nbsp
                <form id='searchForm' class="form-inline" style="margin-bottom: 3px;">
                  @csrf
                  
                    <input type="text" id="searchInp" name="searchInp" class="form-control form-inline" placeholder="{{ __('msg.Search') }}">&nbsp
                    <select id="searchon" name="searchon" class="form-control" method='post'>
                        <option>{{__('msg.Search by')}}</option>
                        <option value="id">{{ __('msg.ID')}}</option>
                        <option value="name">{{ __('msg.Name')}}</option>
                        <option value="position">{{__('msg.Position')}}</option>
                        <option value="department">{{__('msg.Department')}}</option>
                        <option value="phone">{{  __('msg.Phone')}}</option>
                        <option value="email">{{__('msg.Email')}}</option>
                        <option value="status">{{__('msg.Status')}}</option>
                        <option value="approver_user_id">{{__('msg.Approver Id')}}</option>
                    </select>&nbsp
                    <button id='searchBtn' type="submit" class="btn btn-info form-control">{{ __('msg.Search') }}</button><div class='clear-fix'></div>
                    {{ csrf_field() }}
                </form>   
                @endif
          </div>      
    </div>
@if(Auth::user()->can('Create_user'))
<!-- Modal box-->
<div id='insertModal' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 50%">
      <div class="modal-content bg-primary">
  <!--content-->
        <div class="row">
            <div class="col-md-12">
            <div class="card text-white bg-secondary ">
            <div class="card-header">{{ __('msg.New user registeration') }}</div>
              <div class="card-body">
                        <form name="insertForm" id="insertForm">
                            @csrf
                            <div class='row'>
                                <div class="form-group col-md-6">
                                    <label for="name" >{{ __('msg.Name') }}</label>
                                    <input id="name" type="text" class="form-control" name='name'>
                                      <div class='errorsOfUsers font-italic text-light' >
                                          <div class="help-block " id='nameErr'> </div>
                                      </div>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label for="position" >{{ __('msg.Position') }}</label>
                                    <input id="position" type="text" class="form-control" name="position" value="" autofocus>
                                    <div class='errorsOfUsers font-italic text-light' >
                                        <div class="help-block " id='positionErr'> </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="form-group col-md-6">
                                    <label for="dpeartment" >{{ __('msg.Department') }}</label>
                                    <select class='form-control' name="department" id="department">
                                      <option value="">{{ __('msg.Select a department') }}</option>
                                      <option value="Deputy Directorate of System development">{{ __('msg.Deputy Directorate of System development') }}</option>
                                      <option value="GIS">{{ __('msg.GIS') }}</option>
                                      <option value="Administration">{{ __('msg.Administration') }}</option>
                                      <option value="Maslaki">{{ __('msg.Maslaki') }}</option>
                                    </select>
                                    <div class='errorsOfUsers font-italic text-light' >
                                        <div class="help-block " id='depErr'> </div>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group col-md-6">
                                    <label for="phone" >{{ __('msg.Phone') }}</label>
                                    <input id="phone" type="text" class="form-control" name="phone" value="" autofocus>
                                    <div class='errorsOfUsers font-italic text-light' >
                                        <div class="help-block " id='phoneErr'> </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="form-group col-md-6">
                                    <label for="email" >{{ __('msg.Email') }}</label>
                                    <input id="email" type="email" class="form-control" name="email" value="">
                                    <div class='errorsOfUsers font-italic text-light' >
                                        <div class="help-block " id='emailErr'> </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status" >{{ __('msg.Status') }}</label>
                                    <select id="status" class="form-control" name="status">
                                      <option value="true">{{ __('msg.TRUE') }}</option>
                                      <option value="false">{{ __('msg.FALSE') }}</option>
                                    </select>
                                  </div>
                          </div>
                          <div class="row">
                              <div class="form-group col-md-6">
                                <label for="password" >{{ __('msg.Password') }}</label>
                                <input id="password" type="password" class="form-control" name="password">
                                <div class='errorsOfUsers font-italic text-light' >
                                    <div class="help-block " id='passErr1'> </div>
                                </div>
                              </div>
                              
                              <div class="form-group col-md-6">
                                  <label for="password-confirm" >{{ __('msg.Confirm password') }}</label>
                                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                                  <div class='errorsOfUsers font-italic text-light' >
                                      <div class="help-block " id='passErr2'> </div>
                                  </div>
                              </div>
                          </div>
                          {{--  <input type="hidden" name='approver_user_id' value="{{ Auth::user()->id }}">  --}}
                          <div class="row">
                              <div class="form-group clear-fix col-md-12">
                                  <button type='submit' class='btn form-group col-sm-2 col-xs-2 float-right  btn-primary' name="saveInsert" id='saveInsert'>{{ __('msg.Save') }}</button>
                                  <span class="float-right">&nbsp</span>
                                  <button type='button' class='btn btn-dark col-sm-2 col-xs-2 float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('msg.Cancel') }}</button>
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
                  <div class="card-header">{{ __('msg.Update') }}</div>
                    <div class="card-body">
                        <form name="updateForm" id="updateForm">
                            @csrf
                            <input type="hidden" name="id" id="id" value="">
                           
                            <div class='row'>
                                <div class="form-group col-md-12">
                                    <label for="status" >{{ __('msg.Status') }}</label>
                                    <select id="status" class="form-control" name="status">
                                      <option value="true">{{ __('msg.TRUE') }}</option>
                                      <option value="false">{{ __('msg.FALSE') }}</option>
                                      
                                    </select>
                                  </div>
                          </div>
                         
                          <div class="row">
                              <div class="form-group clear-fix col-md-12">
                                  <button type='submit' class='btn form-group col-sm-2 col-xs-2 float-right  btn-primary' name="saveInsert" id='saveInsert'>{{ __('msg.Save') }}</button>
                                  <span class="float-right">&nbsp</span>
                                  <button type='button' class='btn btn-dark col-sm-2 col-xs-2 float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('msg.Cancel') }}</button>
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
@endif
@if(Auth::user()->can('Read_user')||Auth::user()->can('Create_user'))
<table class="table table-bordered table-responsive table-light">
  <thead>
    <tr>
      <th scope="col">{{ __('msg.ID') }}</th>
      <th scope="col">{{ __('msg.Name') }}</th>
      <th scope="col">{{ __('msg.Position') }}</th>
      <th scope="col">{{ __('msg.Department') }}</th>
      <th scope="col">{{ __('msg.Email') }}</th>
      <th scope="col">{{ __('msg.Phone') }}</th>
      <th scope="col">{{ __('msg.Status') }}</th>
      <th scope="col">{{ __('msg.Approver Id') }}</th>
      <th scope="col">{{ __('msg.Created_at') }}</th>
      <th scope="col">{{ __('msg.Updated_at') }}</th>
      @if(Auth::user()->can('Create_user'))
      <th scope="col" colspan="2" class='text-center'>{{ __('msg.Action') }}</th>
      @endif
    </tr>
  </thead>
  <tbody class="tableOfDriver">
  	@foreach($dataOfusersTable as $rowData)
    <tr>
      <th scope="row">{{$rowData->id}}</th>
      <td>{{$rowData->name}}</td>
      <td>{{$rowData->position}}</td>
      <td>
        @if($rowData->department == "Deputy Directorate of System development")
        {{ __('msg.Deputy Directorate of System development')}}
        
        @elseif($rowData->department == "GIS")
        {{ __('msg.GIS') }}
        
        @elseif($rowData->department == "Administration")
        {{ __('msg.Administration') }}
        
        @elseif($rowData->department == "Maslaki")
        {{ __('msg.Maslaki') }}
        @else 
        {{ $rowData->department }}
        @endif
      </td>
      <td>{{$rowData->email}}</td>
      <td>0{{$rowData->phone}}</td>
      <td>
      @if(!(is_bool($rowData->status)))
      <span style="background-color:yellowgreen;border-radius:3px;padding:4px;display:inline-block">{{  __('msg.pending')}}</span>
        @endif
        @if($rowData->status == 1 || $rowData->status ===true)
        <span style="background-color:dodgerblue;border-radius:3px;padding:4px;display:inline-block">{{  __('msg.Approved')}}</span>
        @endif
        @if( $rowData->status === false && is_bool($rowData->status))
        <span style="color:white;background-color:firebrick;border-radius:3px;padding:4px;display:inline-block">{{  __('msg.Rejected')}}</span>
        @endif
      </td>
      <td>{{ $rowData->approver_user_id }}</td>
      <td>{{ $rowData->created_at }}</td>
      <td>{{ $rowData->updated_at }}</td>
    @if(Auth::user()->can('Create_user'))
  		<td class='text-center'><a href="/users/{{ $rowData->id }}" id="{{$rowData->id}}" class="btn btn-primary btn-sm updateBtn">{{ __('msg.Update') }}</a></td>
	  @endif
    </tr>
    @endforeach
  </tbody>
</table>

{{ $dataOfusersTable->links() }}
@endif
<script type="text/javascript">
    
    jQuery(document).ready(function(){
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
     
       
   });
</script>
@endsection()
