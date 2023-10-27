@extends('admin.layouts.app')

@section('content')
@php
use App\Models\Cars\Carmodel;
@endphp
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

  <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Maker</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    <button type="button" class="btn btn-primary update-make-year" data-toggle="modal" data-target="#UpdateModal">Update Year</button>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Maker</button>
  </div>

</div>
@if(session()->has('message'))
<div class="alert alert-success  alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{ session()->get('message') }}
</div>
@endif

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
        <h5 class="mb-1">Maker</h5>
      </div>
      <div class="table-responsive">
        <table id="" class="table table-bordered maker_table" style="width: 100% !important;">
          <thead>
            <tr>
              <th>Action</th>
              <th>Image</th>
              <th>Title</th>
              <th>Status</th>
              <th>Year Begin</th>
              <th>Year End</th>
              <th>Models Count</th>
            </tr>
          </thead>
          <tbody>
            @foreach($makers as $maker)
            <tr id="maker_id_{{$maker->id}}">
              <td>
                <div class="d-flex text-center">
                  <a data-toggle="modal" href='#editModal' class="actionicon bg-info editaction" data-target="#editmodal{{$maker->id}}"><i class="fa fa-pencil"></i></a>
                  <?php if($maker->status == 1){ ?>
                  <a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id="{{$maker->id}}"><i class="fa fa-close"></i></a>
                <?php }else{ ?>
                  <a data-toggle="modal" href='#deleteModal' class="actionicon bg-green deleteaction active-btn" data-id="{{$maker->id}}"><i class="fa fa-undo"></i></a>
                <?php } ?>
                </div>
              </td>
              <td><img src="{{asset('public/uploads/image/'.$maker['image'])}}" alt="couponLogo" style="height:50px; width:50px; margin-right:1rem;"></td>
              <td>{{$maker->title}}</td>
              <td>@if($maker->status == '1') {{'Active'}} @else {{'Inactive'}}@endif</td>
              <td>{{ $maker->year_begin }}</td>
              <td>{{ $maker->year_end }}</td>

              <?php $models_count = Carmodel::where('make_id', $maker->id)->count(); ?>
              <td onclick="location.href = 'models/{{$maker->id}}/showall'">
                {{$models_count}}
              </td>
            </tr>
            @endforeach

            </td>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="loader_modal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <h3 style="text-align:center;">Please wait</h3>
        <p style="text-align:center;"><img src="{{ asset('public/assets/img/gif/waiting.gif') }}"></p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <form action="{{url('admin/add-maker')}}" method="post" enctype="multipart/form-data">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!-- <h4 class="modal-title">Modal Header</h4> -->
        </div>
        <div class="modal-body">
          <div class="col-md-">
            <h1 style="color: #5a386b">Add Maker</h1>
            {{csrf_field()}}
            <div class="form-group">
              <label for="name">Title:</label>
              <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="status">Status:</label>
              <select name="status" require class="form-control">
                <option value="1"  >Active</option>
                <option value="0" >Inactive</option>
              </select>
            </div>
            <div class="form-group">
              <label for="name">Image:</label>
              <input required type="file" name="img" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Maker</button>
        </div>
      </div>
    </form>
  </div>
</div>
</div>
@foreach($makers as $maker)
<div class="modal fade" id="editmodal{{$maker->id}}" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <!-- <h4 class="modal-title">Modal Header</h4> -->
      </div>
      <form action="{{route('edit-maker')}}" method="POST" enctype="multipart/form-data">
       <div class="modal-body">
        <div class="col-md-">
          <h1 style="color: #5a386b">Edit Maker</h1>
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$maker->id}}">
            <div class="form-group">
              <label for="name">Title:</label>
              <input required type="text" name="edit_title" class="form-control" value="{{$maker->title}}">
            </div>
            <div class="form-group">
              <label for="status">Status:</label>
              <select name="status" require class="form-control">
                <option value="1" @if($maker->status == '1') selected @endif >Active</option>
                <option value="0" @if($maker->status == '0') selected @endif>Inactive</option>
              </select>
            </div>
            <div class="form-group">
              <img src="{{url('public/image/'.$maker->image )}}" class="img-fluid" alt="carish used cars for sale in estonia" width="50px" height="50px"><br>
              <label for="name">Image:</label>

              <input type="file" name="edit_img" class="form-control">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn" style="color: white; background-color: #5a386b">Update</button>

      </div>
    </form>
    </div>
  </div>
</div>
@endforeach

@push('custom-scripts')
<script>
  $('.maker_table').DataTable({
    scrollX: true,
    scrollY: '90vh',
    scrollCollapse: true,

  });

  @if(Session::has('message'))
  toastr.success('Success!', "{{Session::get('message')}}", {
    "positionClass": "toast-bottom-right"
  });
  @endif

  $(function(e) {
        $(document).on('click', '.update-make-year', function() {
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Update Make Year?",
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
            $("#loader_modal").modal('show');
            $.ajax({
              method: "get",
              dataType: "json",
              data: {
                id: id
              },
              url: "{{ route('update-make-year') }}",

              success: function(data) {
                $("#loader_modal").modal('hide');
                if (data.success == true) {
                  //$("#maker_id_" + id).remove();
                  //$('.maker_table').DataTable().ajax.reload();
                  location.reload();
                  toastr.success('Success!', data.message, {
                    "positionClass": "toast-bottom-right"
                  });
                } else if (data.success == false) {
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

    $(document).on('click', '.delete-btn', function() {
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Disable this Maker?",
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
              url: "{{ route('delete-maker') }}",

              success: function(data) {
                if (data.success == true) {
                  //$("#maker_id_" + id).remove();
                  //$('.maker_table').DataTable().ajax.reload();
                  location.reload();
                  toastr.success('Success!', data.message, {
                    "positionClass": "toast-bottom-right"
                  });
                } else if (data.success == false) {
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

    $(document).on('click', '.active-btn', function() {
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Active this Maker?",
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
              url: "{{ route('active-maker') }}",

              success: function(data) {
                if (data.success == true) {
                 // $("#maker_id_" + id).remove();
                  //$('.maker_table').DataTable().ajax.reload();
                  location.reload();
                  toastr.success('Success!', data.message, {
                    "positionClass": "toast-bottom-right"
                  });
                } else if (data.success == false) {
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
  });
</script>
@endpush




@endsection