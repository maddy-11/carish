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
	<div class="col-lg-8 col-md-7 col-sm-7  title-col">
		<h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Editable General Settings</h3>
	</div>
	<div class="col-lg-4 col-md-7 col-sm-7  title-col">
		<a class="btn btn-primary" href="{{ url()->previous() }}" style="float: right;">
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
<form method="post" action="{{url('admin/save-general-settings')}}" enctype="multipart/form-data" >
@csrf
<div class="row">
	<div class="col-12 col-md-6 dr-personal-prof mb-4">
		<div class="bg-white custompadding customborder h-100 d-flex flex-column">
			<div class="section-header">
				<h5 class="mb-1 text-capitalize">General Details</h5>
			</div>
			
			<div class="row">
				<div class="col-sm-4 col-3 personal-profile pr-0 pr-sm-3">	
					<h6 class="text-capitalize font-weight-bold mb-1">Choose  Logo:</h6>	
					<input class="form-control" type='file' name="upload_image" id="upload_image" accept="image/*"  />
					@if($settings == '')
					<img src="https://summer.pes.edu/wp-content/uploads/2019/02/default-2.jpg" id="faviconshow" style="width: 100px;height: 100px" />
					@else
					<img src="{{url('public/uploads/'.$settings->logo)}}" id="blah" style="width: 100px;height: 100px" />
					@endif

				</div>
				<div class="col-sm-4 col-3 personal-profile pr-0 pr-sm-3">	
					<h6 class="text-capitalize font-weight-bold mb-1" style="white-space: nowrap">Choose  Small Logo:</h6>	
					<input class="form-control" type='file' name="upload_small_logo" id="upload_small_logo" accept="image/*"  />
					@if($settings == '')
					<img src="https://summer.pes.edu/wp-content/uploads/2019/02/default-2.jpg" id="faviconshow" style="width: 100px;height: 100px" />
					@else
					<img src="{{url('public/uploads/'.$settings->small_logo)}}" id="imgshow" style="width: 100px;height: 100px" />
					@endif
				</div>

				<div class="col-sm-4 col-3 personal-profile pr-0 pr-sm-3">	
					<h6 class="text-capitalize font-weight-bold mb-1">Choose  Favicon:</h6>	
					<input class="form-control" type='file' name="upload_favicon" id="upload_favicon" accept="image/*"  />
					@if($settings == '')
					<img src="https://summer.pes.edu/wp-content/uploads/2019/02/default-2.jpg" id="faviconshow" style="width: 100px;height: 100px" />
					@else
					<img src="{{url('public/uploads/'.$settings->favicon)}}" id="faviconshow" style="width: 100px;height: 100px" />
					@endif
				</div>
			</div>
			<div class="mt-auto mt-3 pt-3">
					<button class="btn btn-success" type="submit">SAVE</button>
			</div>
		</div>
		
	</div> 
	
</div>
</form>

<div id="uploadimageModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Upload & Crop Image</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-8 text-center">
						<div id="image_demo" style="width:350px; margin-top:30px"></div>
					</div>
					<div class="col-md-4" style="padding-top:30px;">
						<br />
						<br />
						<br/>
						<button class="btn btn-success crop_image">Crop & Upload Image</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>  
<div id="uploadSmallLogo" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Upload & Crop Image</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-8 text-center">
						<div id="small_logo_demo" style="width:350px; margin-top:30px"></div>
					</div>
					<div class="col-md-4" style="padding-top:30px;">
						<br />
						<br />
						<br/>
						<button class="btn btn-success crop_small_logo">Crop & Upload Image</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div> 
<div id="uploadfavicon" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Upload & Crop Image</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-8 text-center">
						<div id="favcon_demo" style="width:350px; margin-top:30px"></div>
					</div>
					<div class="col-md-4" style="padding-top:30px;">
						<br />
						<br />
						<br/>
						<button class="btn btn-success crop_favicon">Crop & Upload Image</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div> 

@push('custom-scripts')

@endpush

@endsection
