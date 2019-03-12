@extends("layouts.app")
@section('content')

<!--  -->
<!--  -->
    <div class="row">
          <div class="col-md-8 form-inline">
            
            <div class="clear-fix"></div>
                    &nbsp&nbsp&nbsp    <h4>{{__('Total pendings users: ') . $countPendings}}</h4>
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


<!-- start of upadate modal box -->
<div id='updateModal' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">  
      <div class="row">
        <div class="col-md-12">
          <div class="card text-white bg-secondary ">
          <div class="card-header">Update user</div>
            <div class="card-body">
                <form name="updateForm" id="updateForm">
                @csrf
                  <input type="hidden" name="id" id="id" value="">
                  <div class="form-group col-md-6">
                      <label for="status" class="text-center">{{ __('Approving of User') }}</label>
                      <select id="status" class="form-control" name="status">
                        <option value=''>pending</option>
                        <option value=true>Approve</option>
                        <option value=false>Reject</option>
                      </select>
                  </div>
                  <button type='submit' class='btn form-group  float-right  btn-primary' name="saveInsert" id='saveInsert'>{{ __('Apply') }}</button>
                  <span class="float-right">&nbsp</span>
                  <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('Cancel') }}</button>
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
      <th scope="col" colspan="2" class='text-center'>{{ __('Action') }}</th>
    </tr>
  </thead>
  <tbody class="tableOfDriver">
  	@foreach($pendings as $rowData)
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
  		<td class='text-center'><a href="/users/{{ $rowData->id }}" id="{{$rowData->id}}" class="btn btn-primary updateBtn">{{ __('Approve') }}</a></td>
	  	<td class="text-center"><a href="/users/{{ $rowData->id}} " id="{{ $rowData->id}}" class='deleteBtn btn btn-danger'>{{ __('Delete') }} </button></td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $pendings->links()}}
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
