@extends("layouts.app")
@section('content')
@if(Auth::user()->can('Approve_user')||Auth::user()->can('Read_user'))
<!--  -->

<h4>{{__('msg.Total pendings users: ') . $countPendings}}</h4>


<!-- start of upadate modal box -->
<div id='updateModal' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-primary">  
      <div class="row">
        <div class="col-md-12">
          <div class="card text-white bg-secondary ">
          <div class="card-header">{{ __('msg.Update') }}</div>
            <div class="card-body">
                <form name="updateForm" id="updateForm">
                @csrf
                  <input type="hidden" name="id" id="id" value="">
                  <div class="form-group col-md-6">
                      <label for="status" class="text-center">{{ __('msg.Approval') }}</label>
                      <select id="status" class="form-control" name="status">
                        <option value=''>{{ __('msg.Pending') }}</option>
                        <option value=true>{{ __('msg.TRUE') }}</option>
                        <option value=false>{{ __('msg.FALSE') }}</option>
                      </select>
                  </div>
                  <button type='submit' class='btn form-group  float-right  btn-primary' name="saveInsert" id='saveInsert'>{{ __('msg.Save') }}</button>
                  <span class="float-right">&nbsp</span>
                  <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('msg.Cancel') }}</button>
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
      <th scope="col">{{ __('msg.ID') }}</th>
      <th scope="col">{{ __('msg.Name') }}</th>
      <th scope="col">{{ __('msg.Position') }}</th>
      <th scope="col">{{ __('msg.Department') }}</th>
      <th scope="col">{{ __('msg.Email') }}</th>
      <th scope="col">{{ __('msg.Phone') }}</th>
      <th scope="col">{{ __('msg.Status') }}</th>
  @if(Auth::user()->can('Approve_user'))
      <th scope="col" colspan="2" class='text-center'>{{ __('msg.Action') }}</th>
  @endif
    </tr>
  </thead>
  <tbody class="tableOfDriver">
  	@foreach($pendings as $rowData)
    <tr>
      <th scope="row">{{$rowData->id}}</th>
      <td>{{$rowData->name}}</td>
      <td>{{$rowData->position}}</td>
      <td>{{$rowData->department}}</td>
      <td>{{$rowData->email}}</td>
      <td>0{{$rowData->phone}}</td>
      <td>
      @if(!(is_bool($rowData->status)))
      <span style="background-color:yellowgreen;border-radius:3px;padding:4px">  {{  __('msg.Pending')}}</span>
        @endif
        @if($rowData->status == 1 || $rowData->status ===true)
        <span style="background-color:dodgerblue;border-radius:3px;padding:4px">  {{  __('msg.Approved')}}</span>
        @endif
        @if( $rowData->status === false && is_bool($rowData->status))
        <span style="color:white;background-color:firebrick;border-radius:3px;padding:4px">  {{  __('msg.Rejected')}}</span>
        @endif
      </td>
      
  @if(Auth::user()->can('Approve_user'))
  		<td class='text-center'><a href="/users/{{ $rowData->id }}" id="{{$rowData->id}}" class="btn btn-primary btn-sm updateBtn">{{ __('msg.Approve') }}</a></td>
  @endif
    </tr>
    @endforeach
  </tbody>
</table>
{{ $pendings->links()}}
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
