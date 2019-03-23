@extends("layouts.app")
@section('content')

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#carBooking">book a car</button>
<table class="table table-bordered">
	<tr>
	<th>{{ _('User ID') }}</th>
	<th>{{ _('Destination') }}</th>
	<th>{{ _('Pickup Time') }}</th>
	<th>{{ _('Return Time') }}</th>
	<th>{{ _('Count of persons') }}</th>
	<th>{{ _('Description') }}</th>
	<th>{{ _('Created At') }}</th>
	<th>{{ _('Updated At') }}</th>
	</tr>
@foreach ($rows as $data)
<tr>
	<td>{{ $data->user_id }}</td>
	<td>{{ $data->destination }}</td>
	<td>{{ $data->pickup_time }}</td>
	<td>{{ $data->return_time }}</td>
	<td>{{ $data->count }}</td>
	<td>{{ $data->description }}</td>
	<td>{{ $data->created_at }}</td>
	<td>{{ $data->updated_at }}</td>
	
</tr>
@endforeach
</table>

<div id='carBooking' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered " style="min-width: 50%">
		<div class="modal-content bg-primary">
								<!--content-->
			<div class="row">
				<div class="col-md-12">
					<div class=" text-white bg-secondary card">
						<div class="card-header">Car booking</div>
	                    <div class="card-body">
		                    <form action=''>
				                      @csrf
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="destination">{{ __('Destination') }} </label>
											<input type="text" class="form-control" name='destination' id="destination" placeholder="insert your destination">
										</div>
										<div class="form-group">
											<label for="timeFrom">{{ __('pickup time') }}</label>
											<input type="datetime-local" class="form-control" name="pickup_time" id="pickup_time" placeholder="">
										</div>
										<div class="form-group">
											<label for="timeTo">{{ __('return time') }}</label>
											<input type="datetime-local" class="form-control" id="return_time" name="return_time" placeholder="">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
					                        <label for="count">{{ __('Count of persons') }}</label>
					                        <input type="text" class="form-control" id="count" name="count" placeholder=" please type name of persons ">
										</div>
										<div class="form-group">
					                        <label for="driver_id">{{ __('Driver ID') }}</label>
					                        <input type="text" class="form-control" id="driver_id" name="driver_id" placeholder=" list of open drivers ">
										</div>
										<div class="form-group">
					                        <label for="car_id">{{ __('Car ID') }}</label>
					                        <input type="text" class="form-control" id="car_id" name="car_id" placeholder=" list of open cars ">
										</div>
										<div class="form-group clear-fix">
					                        <button type='button' class='btn float-right btn-primary' name="saveUpdate" id='saveUpdate'>Save</button>
					                        <span class="float-right">&nbsp</span>
					                        <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">Cancel</button>
										</div>
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


@endsection()
