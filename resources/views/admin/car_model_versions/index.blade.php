@extends('admin.layouts.app')
@section('content')
<?php $id = Route::Input('model_id'); ?>

@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif

@if (count($errors) > 0)
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

  <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Car Model Versions</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right"></div>

</div>
<div class="row">
  <div class="col-12 col-md-12 dr-personal-prof mb-4">
    <form method="get" action="">
      <div class="bg-white custompadding customborder h-100 d-flex flex-column">
        <div class="section-header">
          <h5 class="mb-1 text-capitalize">Search Version</h5>
        </div>
        <div class="row">

          <div class="col-sm-12 col-12">
            <input type="hidden" value="{{$model->id}}" name="model_id">
            <div class="row mt-3 dr-detail-row">
              <!-- @if(@$model->id == $model->id) {{ "selected" }} @endif-->
              <div class="col-md-3 col-6 mb-3 dr-detail-col">
                <h6 class="text-capitalize font-weight-bold mb-1">Year:</h6>
                <select style="width: 100%" class="js-example-basic-single form-control" name="version_year">
                  <option value=''>Select Year</option>
                  @foreach(range(date('Y'), date('Y')-79) as $y)
                  <option value="{{$y}}" @if(!empty(request()->get('version_year')) && request()->get('version_year') == $y) selected="selected" @endif>{{$y}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2 col-3 mb-3 dr-detail-col">
                <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">Engine Capacity:</h6>
                <input type="text" class="form-control" @if(!empty(request()->get('version_cc'))) value="{{request()->get('version_cc')}}" @endif name="version_cc">
              </div>
              <div class="col-md-3 col-3 mb-3 dr-detail-col">
                <h6 class="text-capitalize font-weight-bold mb-1">Engine Power:</h6>
                <input type="number" class="form-control" @if(!empty(request()->get('version_kilowatt'))) value="{{request()->get('version_kilowatt')}}" @endif  name="version_kilowatt">
              </div>
              <div class="col-md-3 col-6 mb-3 dr-detail-col">
                <h6 class="text-capitalize font-weight-bold mb-1">Body Types:</h6>
              <select style="width: 100%"  class="js-example-basic-single form-control" name="bodytype" >
              <option value=''>Select Body Type</option>
								@foreach($version_body_types as $bodytype)
								<option value="{{$bodytype->body_type_id}}" @if(!empty(request()->get('bodytype')) && request()->get('bodytype') == $bodytype->body_type_id) selected="selected" @endif >{{$bodytype->name}}</option>
								@endforeach
				            </select>
              </div>

              <div class="col-md-3 col-6 mb-3 dr-detail-col">
                <h6 class="text-capitalize font-weight-bold mb-1">Transmission Types:</h6>
              <select style="width: 100%"  class="js-example-basic-single form-control" name="transmissiontype" >
              <option value=''>Select Transmission Type</option>
                @foreach($version_TransmissionTypes as $transmissiontype)
                <option value="{{$transmissiontype->transmission_id}}" @if(!empty(request()->get('transmissiontype')) && request()->get('transmissiontype') == $transmissiontype->transmission_id) selected="selected" @endif >{{$transmissiontype->title}}</option>
                @endforeach
                    </select>
              </div>



              <div class="col-md-3 col-6 mb-3 dr-detail-col">
                <button class="btn btn-success" type="submit">Search</button>
              </div>




            </div>

          </div>

        </div>
      </div>

    </form>
  </div>

</div>


<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
        <h5 class="mb-1">Versions</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered" id="myTable" style="width:100%">
          <thead>
            <tr>
              <th>Action</th>
              <th>Model</th>
              <th>Label</th>
              <th>Transmission Label</th>
              <th>Extra Details</th>
              <th>Engine Capacity</th>
              <th>Engine Power</th>
              <th>Car Serie</th>
              <th>Car Generation</th>
              <th>Transmission Type</th>
              <th>From Date</th>
              <th>To Date</th>
              <th>CC</th>
              <th>KW</th>
              <th>Body Type</th>
              <th>Length</th>
              <th>Width</th>
              <th>Height</th>
              <th>Total Weight</th>
              <th>Wheel Base</th>
              <th>Ground Clerance</th>
              <th>Kerb Weight</th>
              <th>Seating Capacity</th>
              <th>Fuel Tank Capacity</th>
              <th>Num of Doors</th>
              <th>Displacement</th>
              <th>Torque</th>
              <th>Gears</th>
              <th>Max Speed</th>
              <th>Acceleration (0 - 100 km/h)</th>
              <th>Num Of Cylinders</th>
              <th>Wheel Size</th>
              <!-- <th>Tyre Size</th> -->
              <th>Drive Type (Front Wheel Drive)</th>
              <th>Fuel Type</th>
              <th>Average Fuel</th>
            </tr>
          </thead>
          <tbody>
            @foreach($model_versions as $version)
            <tr id="user_id_{{$version->id}}">
              <td>
                <div class="d-flex text-center">
                  <a target="" href="{{url('admin/version/edit/'.$version->id)}}" class="actionicon bg-info editaction"><i class="fa fa-pencil"></i></a>
                  <a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id="{{@$version->id}}"><i class="fa fa-close"></i></a>
                </div>
              </td>
              <td>{{@$version->models->name}}</td>
              <td>{{$version->label}}</td>
              <td>{{@$version->transmission_label}}</td>
              <td>{{@$version->extra_details}}</td>
              <td>{{@$version->engine_capacity}}</td>
              <td>{{@$version->engine_power}}</td>
              <td>{{@$version->CarSerie->name}}</td>
              <td>{{@$version->CarGeneration->name}}</td>
              <td>
                {{@$version->transmissionDescription !== null ? @$version->transmissionDescription()->where('language_id',2)->pluck('title')->first() : '--'}}
              </td>
              <td>{{@$version->from_date}}</td>
              <td>{{@$version->to_date}}</td>
              <td>{{@$version->cc}}</td>
              <td>{{@$version->kilowatt}}</td>
              <td>
                {{@$version->body_type_description !== null ? @$version->body_type_description()->where('language_id',2)->pluck('name')->first() : '--'}}
              </td>
              <td>{{@$version->car_length}}</td>
              <td>{{@$version->car_width}}</td>
              <td>{{@$version->car_height}}</td>
              <td>{{@$version->weight}}</td>
              <td>{{@$version->wheel_base}}</td>
              <td>{{@$version->ground_clearance}}</td>
              <td>{{@$version->curb_weight}}</td>
              <td>{{@$version->seating_capacity}}</td>
              <td>{{@$version->fuel_tank_capacity}}</td>
              <td>{{@$version->number_of_door}}</td>
              <td>{{@$version->displacement}}</td>
              <td>{{@$version->torque}}</td>
              <td>{{@$version->gears}}</td>
              <td>{{@$version->max_speed}}</td>
              <td>{{@$version->acceleration}}</td>
              <td>{{@$version->number_of_cylinders}}</td>
              <td>{{@$version->front_wheel_size}}{{$version->back_wheel_size}}</td>
              <!-- <td>{{@$version->front_tyre_size}}{{$version->back_tyre_size}}</td> -->
              <td>{{@$version->drive_type}}</td>
              <td>{{@$version->fueltype}}</td>
              <td>{{@$version->average_fuel}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>


</div>

@push('custom-scripts')
<script>
  $('#myTable').DataTable({
    // searching: false
  });


  @if(Session::has('message'))
  toastr.success('Success!', "{{Session::get('message')}}", {
    "positionClass": "toast-bottom-right"
  });
  @endif

  $(function(e) {
    $(document).on('click', '.delete-btn', function() {
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Delete this version?",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          cancelButtonText: "No!",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm) {
          if (isConfirm) {
            $.ajax({
              method: "get",
              dataType: "json",
              data: {
                id: id
              },
              url: "{{ route('delete-version') }}",

              success: function(data) {
                if (data.success == true) {
                  $("#user_id_" + id).remove();
                  toastr.success('Success!', data.message, {
                    "positionClass": "toast-bottom-right"
                  });
                }
              }
            });
          } else {
            swal("Cancelled", "", "error");
          }

        });
    });



    $(document).on('submit', '.editCarModelVersion', function(e) {
      e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('edit-model-car-version') }}",
        method: 'post',
        data: $('.editCarModelVersion').serialize(),
        beforeSend: function() {
          $('#loader_modal').modal({
            backdrop: 'static',
            keyboard: false
          });
          $("#loader_modal").modal('show');
        },
        success: function(result) {
          $("#loader_modal").modal('hide');
          if (result.success === true) {
            toastr.success('Success!', 'Car Model Version Updated successfully', {
              "positionClass": "toast-bottom-right"
            });
            $('.editCarModelVersion')[0].reset();
            setTimeout(function() {
              window.location.reload();
            }, 2000);

          }


        },
        error: function(request, status, error) {

          $('.form-control').removeClass('is-invalid');
          $('.form-control').next().remove();
          json = $.parseJSON(request.responseText);
          $.each(json.errors, function(key, value) {
            $('input[name="' + key + '"]').after('<span class="invalid-feedback" role="alert"><strong>' + value + '</strong>');
            $('input[name="' + key + '"]').addClass('is-invalid');
          });
        }
      });
    });
  });
</script>
@endpush
@endsection