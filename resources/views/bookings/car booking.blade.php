@extends("layouts.app")
@section('content')

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#carBooking">book a car</button>

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
					                        <label for="list_of_persons">{{ __('List of Persons') }}</label>
					                        <input type="text" class="form-control" id="list_of_persons" name="list_of_persons" placeholder=" please type name of persons ">
										</div>
										<div class="form-group">
					                        <label for="driver_id">{{ __('Open drivers') }}</label>
					                        <input type="text" class="form-control" id="open_drivers" name="open_drivers" placeholder=" list of open drivers ">
										</div>
										<div class="form-group">
					                        <label for="list_of_persons">{{ __('Open cars') }}</label>
					                        <input type="text" class="form-control" id="open_cars" name="open_cars" placeholder=" list of open cars ">
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
