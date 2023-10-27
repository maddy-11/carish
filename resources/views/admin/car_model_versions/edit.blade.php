@extends('admin.layouts.app')

@section('content')

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
	<div class="d-md-none h-search-col search-col col-12 collapse" id="searchsection">
		<div class="input-group custom-input-group mb-3" >
			<input type="text" class="form-control" placeholder="Search">
			<div class="align-items-center input-group-prepend">
				<span class="input-group-text fa fa-search"></span>
			</div>
		</div>
	</div>
  <div class="col-lg-6 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Edit Car Model Version</h3>
    
  </div>
  <div class="col-lg-6 col-md-5 col-sm-5 search-col text-right">
    <a class="btn btn-primary" href="{{ url()->previous() }}">
      <i class="fa fa-arrow-left"></i> Back
    </a>
    
  </div>
</div>

@if(session('success'))
<div class="alert alert-success">
	{{ session('success') }}
</div> 
@endif

@if (count($errors) > 0)
<div class = "alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

<div class="row">
	<div class="col-12 col-md-12 dr-personal-prof mb-4">
		<form method="post" action="{{url('admin/version/update')}}" enctype="multipart/form-data" id="versionEditForm">
			@csrf
			<div class="bg-white custompadding customborder h-100 d-flex flex-column">
				<div class="section-header">
					<h5 class="mb-1 text-capitalize">Model {{$edit_version->models->name}} Version Details </h5>
				</div>
				<div class="row">
						
					<div class="col-sm-12 col-12">
						<input type="hidden" value="{{$edit_version->id}}" name="version_id">
						<input type="hidden" value="{{$edit_version->model_id}}" name="model_id">
						<div class="row mt-3 dr-detail-row">

							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1">Label:</h6>
								<input class="form-control" type="text" name="edit_label" value="{{$edit_version->label}}">
							</div>
							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1">Transmission Label:</h6>
								<input class="form-control" type="text" name="edit_transmission_label" value="{{$edit_version->transmission_label}}">
							</div>
							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1">Extra Details:</h6>
								<input class="form-control" type="text" name="edit_extra_details" value="{{$edit_version->extra_details}}">
							</div>
							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1">Engine Capacity:</h6>
								<input class="form-control" type="text" name="edit_engine_capacity" value="{{$edit_version->engine_capacity}}">
							</div>
							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1">Engine Power:</h6>
								<input class="form-control" type="text" name="edit_engine_power" value="{{$edit_version->engine_power}}">
							</div>
							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1">Car Serie:</h6>
								<input class="form-control" type="text" name="edit_serie_name" value="{{$edit_version->CarSerie->name}}" readonly="readonly">
							</div>
							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1">Car Generation:</h6>
								<input class="form-control" type="text" name="edit_genration_name" value="{{$edit_version->CarGeneration->name}}"  readonly="readonly">
							</div>
							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1">Transmission Type:</h6>
								<select style="width: 100%"  class="js-example-basic-single form-control" name="edit_bodyType" >
								@foreach($version_TransmissionTypes as $transmisiontype)
								<option value="{{$transmisiontype->transmission_id}}" @if(@$edit_version->transmissiontype == $transmisiontype->transmission_id) {{ "selected" }} @endif >{{$transmisiontype->title}}</option>
								@endforeach
				                </select>

							</div>
							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1">From Date:</h6>
								<input type="text" class="form-control" name="edit_fromDate" value="{{$edit_version->from_date}}">
							</div>
							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1">To Date:</h6>
								<input class="form-control" type="text" name="edit_toDate" value="{{$edit_version->to_date}}">
							</div>

							
							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1">Body Type:</h6>
								<select style="width: 100%"  class="js-example-basic-single form-control" name="edit_bodyType" >
								@foreach($version_bodyTypes as $bodytype)
								<option value="{{$bodytype->body_type_id}}" @if(@$edit_version->body_type_id == $bodytype->body_type_id) {{ "selected" }} @endif >{{$bodytype->name}}</option>
								@endforeach
				                </select>
							</div>
							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">CC:</h6>
								<input type="text" class="form-control" value="{{$edit_version->cc}}" name="edit_cc">
							</div>
							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1">Kilo-Watt:</h6>
								<input type="number" class="form-control" value="{{$edit_version->kilowatt}}" name="edit_kilowatt">
							</div>
							<div class="col-md-3 col-6 mb-3 dr-detail-col">
								<h6 class="text-capitalize font-weight-bold mb-1">Car Length:</h6>
								<input type="text" class="form-control" name="edit_length" value="{{$edit_version->car_length}}">
							</div>
					
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Width:</h6>
						<input type="text" class="form-control" name="edit_width" value="{{$edit_version->car_width}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Height:</h6>
						<input type="text" class="form-control" name="edit_height" value="{{$edit_version->car_height}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Weight:</h6>
						<input type="text" class="form-control" name="edit_weight" value="{{$edit_version->weight}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Curb Weight:</h6>
						<input type="text" class="form-control" name="edit_curbWeight" value="{{$edit_version->curb_weight}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Wheel Base:</h6>
						<input type="text" class="form-control" name="edit_wheelBase" value="{{$edit_version->wheel_base}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Ground Clearance:</h6>
						<input type="text" class="form-control" name="edit_groundClearance" value="{{$edit_version->ground_clearance}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Seating Capacity:</h6>
						<input type="text" class="form-control" name="edit_seatingCapacity" value="{{$edit_version->seating_capacity}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Fuel Tank Capacity:</h6>
						<input type="text" class="form-control" name="edit_fuelTankCapacity" value="{{$edit_version->fuel_tank_capacity}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">No Of Doors:</h6>
						<input type="text" class="form-control" name="edit_doors" value="{{$edit_version->number_of_door}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Displacement:</h6>
						<input type="text" class="form-control" name="edit_displacement" value="{{$edit_version->displacement}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Torque:</h6>
						<input type="text" class="form-control" name="edit_torque" value="{{$edit_version->torque}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Gears:</h6>
						<input type="text" class="form-control" name="edit_gears" value="{{$edit_version->gears}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Max Speed:</h6>
						<input type="text" class="form-control" name="edit_maxSpeed" value="{{$edit_version->max_speed}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Acceleration:</h6>
						<input type="text" class="form-control" name="edit_acceleration" value="{{$edit_version->acceleration}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">No Of Cylinders:</h6>
						<input type="text" class="form-control" name="edit_cylinders" value="{{$edit_version->number_of_cylinders}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Front Wheel Size:</h6>
						<input type="text" class="form-control" name="edit_frontWheelSize" value="{{$edit_version->front_wheel_size}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Back Wheel Size:</h6>
						<input type="text" class="form-control" name="edit_backWheelSize" value="{{$edit_version->back_wheel_size}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Front Tyre Size:</h6>
						<input type="text" class="form-control" name="edit_frontTyreSize" value="{{$edit_version->front_tyre_size}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Back Tyre Size:</h6>
						<input type="text" class="form-control" name="edit_backTyreSize" value="{{$edit_version->back_tyre_size}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Drive Type:</h6>
						<input type="text" class="form-control" name="edit_driveType" value="{{$edit_version->drive_type}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Fuel Type:</h6>
						<input type="text" class="form-control" name="edit_fueltype" value="{{$edit_version->fueltype}}">
					</div>
					<div class="col-md-3 col-6 mb-3 dr-detail-col">
						<h6 class="text-capitalize font-weight-bold mb-1">Average Fuel:</h6>
						<input type="text" class="form-control" name="edit_averageFuel" value="{{$edit_version->average_fuel}}">
					</div>
					
					<button class="btn btn-success" type="submit" style="float: right; margin-top: 10px;">Update</button>
				</div>
			
				</div>

				</div>
				</div>
				
			</div>
		</form>
	</div>  
	
</div>
<script type="text/javascript">
	$(document).ready( function () {
		$('#table_id').DataTable();
	} );
</script>

<script type="text/javascript">
	
  function validateFileType(){
        var fileName = document.getElementById("test").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            return true;
        }else{
            alert("Only jpg/jpeg and png files are allowed!");
			document.getElementById('test').value = null; 
			return false;
        }   
    }


</script>
<script type="text/javascript">
    function alphaOnly(event) {
       var key = event.keyCode;
       return ((key >= 65 && key <= 90) || key == 8 || key == 9);
}
  </script>

  <script type="text/javascript">
  	function validateName()
  	{
  		var fname = document.forms["assistEditForm"]["FirstName"];

  		if(fname.value == "")                                  
    { 
        //window.alert("Please Enter First Name"); 
        fname.focus(); 
        fname.style.borderColor = "red";
        return false; 
    } 
    else{
    	fname.style.borderColor = "green";
    }

  	}
  </script>


@endsection