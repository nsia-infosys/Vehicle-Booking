


@extends("layouts.app")
@section('content')
@if(Auth::user()->can('Read_role'))
  <div id='driverTable'>
  
	<table id='dataTable' class="table table-bordered table-light" >
  <thead>
    <tr>
      <th scope="col">{{ __('msg.ID') }}</th>
      <th scope="col">{{__('msg.Name')}}</th>
      <th scope="col">{{__('msg.Description')}}</th>
      <th scope="col">{{__('msg.Created_at')}}</th>
      <th scope="col">{{__('msg.Updated_at')}}</th>
      
    </tr>
  </thead>
  <tbody class='tbodyOfDriver tableOfDriver'>
  	@foreach($permissions as $rowData)
    <tr scope='row'>
      <td><b>{{$rowData->id}}</b></td>
      <td>{{$rowData->name}}</td>
      <td>
        @if(App::getLocale() == 'fa')
            @if($rowData->permission_description == "can register new driver and car")
            {{ 'قادر به ثبت راننده و موتر جدید می باشد' }}
            @elseif($rowData->permission_description == "can update data of driver and car")
            {{ 'قادر به تجدید معلومات راننده و موتر می باشد. ' }}
            @elseif($rowData->permission_description == "can read registered drivers and cars")
            {{ 'قادر به دیدن موتر و راننده های موجود در سیستم می باشد.' }}
            @elseif($rowData->permission_description == "can approve bookings")
            {{ ' قادر به تصویب یا رد رزرو می باشد.' }}
            @elseif($rowData->permission_description == "can read bookings")
            {{ ' قادر به دیدن رزرو ها می باشد.' }}
            @elseif($rowData->permission_description == "can update approved bookings")
            {{ 'قادر به تجدید رزرو های تصویب شده می باشد.' }}
            @elseif($rowData->permission_description == "can reserve vehical")
            {{ 'قادر به رزرو موتر می باشد. ' }}
            @elseif($rowData->permission_description == "can register new user with approve status")
            {{ 'قادر به ثبت نام و تصویب استفاده کننده جدید می باشد. ' }}
            @elseif($rowData->permission_description == "can read registered users")
            {{ 'قادر به دیدن استفاده کننده های موجود در سیستم می باشد. ' }}
            @elseif($rowData->permission_description == "can read assigned roles for users")
            {{ 'قادر به دیدن نقش های داده شده به استفاده کننده می باشد. ' }}
            @elseif($rowData->permission_description == 'can create new role and assign permissions for created role')
            {{ 'قادر به ایجاد نقش جدید و دادن صلاحیت به آن نقش می باشد.' }}
            @elseif($rowData->permission_description == "can update permissions of roles")
            {{ 'قادر به تجدید صلاحیت های نقش ها می باشد.' }}
            @elseif($rowData->permission_description == "can read roles with their permissions")
            {{ 'قادر به دیدن نقش ها با صلاحیت های شان می باشد. ' }}
            @elseif($rowData->permission_description == "can approve pending users")
            {{ 'قادر به تصویب استفاده کننده های منتظر می باشد.. ' }}
       @else
       {{ $rowData->permission_description }}
       @endif
      @endif
      </td>
      <td>{{$rowData->created_at}}</td>
      <td>{{$rowData->updated_at}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
@endif
<!-- script part of page -->
	<script type="text/javascript">
//end of jqery                            
 </script>
@endsection()