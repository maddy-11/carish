@extends('admin.layouts.app')

@section('content')

<!-- <div class="row mb-3">
  <div class="col-md-8 title-col">
    <h3 class="maintitle text-uppercase fontbold">Suggestions</h3>
  </div>
 
</div>
 -->
 <div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Vehicle Types</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right">Add Vehicle Type</button>
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
       <h5 class="mb-1">Vehicle Types</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" >
          <thead>
              <tr>
                  <th>Action</th>
                  <th>Title</th>
                  <th>Status</th>
              </tr>
          </thead>
          <tbody>
            
            @foreach($vehicle_types_detail as $vehicle_type_detail)
                <tr id="vehicle_type_id_{{$vehicle_type_detail->vehicle_type_id}}">
                  <td>
                    <div class="d-flex text-center">
                      <a data-toggle="modal" class="actionicon bg-info editaction"  data-id = "{{$vehicle_type_detail->vehicle_type_id}}"><i class="fa fa-pencil"></i></a>

                      <a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id = "{{$vehicle_type_detail->vehicle_type_id}}"><i class="fa fa-close"></i></a>
                    </div>
                  </td>
                  <td>{{$vehicle_type_detail->title}}</td>
                    <td>
                    @php 
                      $active = "";
                      $disabled = "";
                    @endphp
                    @if(@$vehicle_type_detail->vehicle_type->status != 0)
                      @php $active = "Selected"; @endphp
                    @else
                      @php $disabled = "Selected"; @endphp

                    @endif
                    <select class="form-control vt-status" data-id="{{$vehicle_type_detail->vehicle_type->id}}" style="width: 30%;">
                      <option value="1" {{@$active}} >Active</option>
                      <option value="0" {{@$disabled}}>Disabled</option>
                    </select>
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
  

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
    <form action="{{url('add/vehicle-type')}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}

      <div class="modal-content">
        <div class="modal-header">         
          <h4 class="modal-title">Add Vehicle Type</h4>
        </div>

        <div class="modal-body">

            <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#{{$language->language_code }}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach

            </ul>

            <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="{{$language->language_code }}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input required type="text" name="{{$language->language_code}}_vt_title" class="form-control" >

                  </div> 
                </div> 
                @endforeach
            </div>

        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Vehicle Type</button>  
        </div>
      </div>
    </form>      
    </div>  
</div>

<div class="modal fade" id="editmodal" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!-- <h4 class="modal-title">Modal Header</h4> -->
        </div>
        <div class="modal-body">
          <form action="{{url('update/vehicle-type')}}" id="editSuggestion" class="editSuggestion" method="post">
        @csrf
      <div class="modal-body">
        <input type="hidden" name="vehicle_type_id" id="vehicle_type_id">
        <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#e_{{$language->language_code }}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach

            </ul>

            <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="e_{{$language->language_code }}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input required type="text" name="{{$language->language_code}}_edit_title" id="{{$language->language_code}}_edit_title" class="form-control" >

                  </div> 
                </div> 
                @endforeach
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        
        <input type="submit" class="btn btn-primary" name="submit" value="update">
      </div>
      </form>
        </div>
      </div>
      
    </div>
</div>
  

  @push('custom-scripts')
  <script>
      $('#myTable').DataTable({
          searching: false,
          lengthMenu: [100, 200, 300, 400],
      });

      // @if(Session::has('message'))
      //   toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
      // @endif

      $(function(e){
      $(document).on('click', '.delete-btn', function(){
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Delete this vehicle type?",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          cancelButtonText: "No!",
          closeOnConfirm: true,
          closeOnCancel: true
       },
         function(isConfirm) {
           if (isConfirm){
             $.ajax({
                method:"get",
                dataType:"json",
                data:{id:id},
                url:"{{ route('delete-vehicle-type') }}",
                
                success:function(data){
                    if(data.success == true){
                     $("#vehicle_type_id_"+id).remove();
                      toastr.success('Success!', data.message ,{"positionClass": "toast-bottom-right"});
                    }
                }
             });
          } 
          else{
              swal("Cancelled", "", "error");
          }
       
    });
   });

      $(document).on('click', '.editaction', function(){
      var id = $(this).data('id');
      // alert(id);
      $.ajax({
                method:"get",
                dataType:"json",
                data:{id:id},
                url:"{{ url('edit/vehicle-type') }}",
                beforeSend:function(){
                   $('#loader_modal').modal({
                        backdrop: 'static',
                        keyboard: false
                      });
                   $("#loader_modal").modal('show');
                },
                success:function(data){
                  $("#loader_modal").modal('hide');

                    if(data.success == true){
                    $('#editmodal').modal('show');
                     // alert(data.e_vehicle_type[0]['suggesstion_id']);
                      $('#vehicle_type_id').val(data.e_vehicle_type[0]['vehicle_type_id']);

                     for( var i=0 ; i < data.e_vehicle_type.length ; i++)
                     {
                      if(data.e_vehicle_type[i]['language_id'] == 1)
                      {
                        $('#et_edit_title').val(data.e_vehicle_type[i]['title']);

                      }
                      else if(data.e_vehicle_type[i]['language_id'] == 2)
                      {
                        $('#en_edit_title').val(data.e_vehicle_type[i]['title']);
                      }
                      else if(data.e_vehicle_type[i]['language_id'] == 3)
                      {
                        $('#ru_edit_title').val(data.e_vehicle_type[i]['title']);
                      }
                     }

                    // $('#version_id').val(data.e_version['id']);
                    // $('#v_name').val(data.e_version['label']);
                    // $('#v_from_date').val(data.e_version['from_date']);
                    // $('#v_to_date').val(data.e_version['to_date']);
                    // $('#v_kw').val(data.e_version['kilowatt']);
                    // $('#v_cc').val(data.e_version['cc']);
                    // var slctVal = data.e_version['body_type_id'];
                    // console.log(slctVal);
                    // $('#edit_body_type option[value='+slctVal+']').prop('selected', true);
                    }
                },
                error: function (request, status, error) {
                  $("#loader_modal").modal('hide');

                }
            })
   });

      $(document).on('change', '.vt-status' , function(){

        var id = $(this).data('id');
        var val = $(this).val();
        swal({
            title: "Alert!",
            text: "Are you sure you want to change the status of this vehicle type?",
            type: "info",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
            closeOnConfirm: true,
            closeOnCancel: true
         },
           function(isConfirm) {
             if (isConfirm){
               $.ajax({
                  method:"get",
                  dataType:"json",
                  data:{id:id , val:val},
                  url:"{{ route('change-status-vehicle-type') }}",
                  
                  success:function(data){
                      if(data.success == true){
                        toastr.success('Success!', 'Status Updated Successfullly' ,{"positionClass": "toast-bottom-right"});
                        window.location.reload();
                      }
                  }
               });
            } 
            else{
                swal("Cancelled", "", "error");
            }
         
      });
   
    });
   });
  </script>
  @endpush

@endsection