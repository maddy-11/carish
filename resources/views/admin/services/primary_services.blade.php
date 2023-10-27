@extends('admin.layouts.app')
@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Service / <a target="" href="{{url('admin/service-category')}}">Parent Categories</a></h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Add Parent Category</button>
  </div>
</div>
@if(session()->has('message'))
    <div class="alert alert-success  alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('message') }}
    </div>
@endif
  <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Add Primary Service</button> -->
<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Service Categories</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th style="width:5px;">Sr No.</th>
                <th>Title</th>
                <th>Status</th>
                <th>Image</th>
              </tr>
          </thead>
          <tbody>            
            @foreach($primary_services as $service)
             <tr id="service_id_{{$service->primary_service_id}}">
                <td style="width:100px;">
                   <a class="actionicon bg-info editaction text-center" data-id="{{@$service->primary_service_id}}" title="Edit" data-toggle="modal" data-target="#editmodal{{$service->primary_service_id}}"><i class="fa fa-pencil" style="color: white;"></i></a>
                   @if($service->status == 1)
                   <a class="actionicon bg-black deleteaction disable-btn text-center" href="javascript:void(0)" title="Disable" data-id="{{$service->primary_service_id}}"><i class="fa fa-ban"></i></a>
                   @else
                   <a class="actionicon bg-green deleteaction active-btn text-center" href="javascript:void(0)" title="Active" data-id="{{$service->primary_service_id}}"><i class="fa fa-undo"></i></a>
                   @endif
                </td>
                <td>{{$loop->iteration}}</td>
                <td><a target="" href="{{url('admin/sub-service/'.$service->primary_service_id)}}">{{$service->title }}</a></td>
                <td>
                  @if($service->status == 1)
                  Active
                  @else
                  Disable
                  @endif
                </td>
                <td>
                  @if($service->image != null)
                    <img src="{{asset('public/uploads/image/'.$service->image)}}" alt="service Image" style="height:30px; width:70px; margin-right:1rem;">
                  @else  
                    <img src="{{asset('public/uploads/image/car.png')}}" alt="service Image" style="height:30px; width:70px; margin-right:1rem;">
                  @endif 
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
    <form action="{{url('add/primary-service')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">         
         <h4 class="modal-title">Add Parent Category</h4>
        </div>
        <div class="modal-body">       
        <div class="col-md-">
           
          {{csrf_field()}}

          <!--  <div class="form-group">
              <label for="name">Service</label>
              <input required type="text" name="title" class="form-control" >
          </div>  -->

           <div class="form-group">
              <label for="name">Image:</label>
              <input required type="file" name="edit_image" class="form-control" >
            </div>

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
                       <input type="text" name="{{$language->language_code}}_add_title" id="{{$language->language_code}}_add_title" class="form-control" >

                  </div> 
                </div> 
                @endforeach
            </div>   
            
               
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Category</button> 
        </div>
      </div>      
      </div>
    </form>
  </div>  
</div>
 @foreach($primary_services as $service)
<div class="modal fade" id="editmodal{{$service->primary_service_id}}" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">          
          <h4 class="modal-title">Edit Parent Category</h4>
        </div>
       <div class="modal-body">
        <form action="{{url('edit/primary-services')}}" method="POST" enctype="multipart/form-data">
         	  <input type="hidden" name="id" value="{{$service->primary_service_id}}" class="service_id">
            {{csrf_field()}}
            <div class="col-md-">
            <!-- <h1 style="color: #5a386b">Edit Primary Services</h1> -->
            
                
         <!--  <div class="form-group">
              <label for="name">Service</label>
              <input required type="text" name="edit_title" value="{{$service->title}}" class="form-control" >
          </div>  -->

            @if($service->image != null)
            <div class="custom-file mb-5">
            <label class="d-block text-left">
            <a target="" href="{{url('public/uploads/image/'.$service->image)}}"><img src="{{url('public/uploads/image/'.$service->image)}}"  width="100" class="img-rounded" align="center"></a>
            </label>
            </div>                      
            @endif
           <div class="form-group">
              <label for="name">Image:</label>
              <input type="file" name="edit_image" class="form-control">
           </div>
        </div>
            <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#{{$language->language_code}}_{{@$service->primary_service_id}}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach
            </ul>
            <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="{{$language->language_code}}_{{@$service->primary_service_id}}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input type="text" name="{{$language->language_code}}_edit_title" id="{{$language->language_code}}_edit_title_{{@$service->primary_service_id}}" class="form-control" >
                  </div> 
                </div> 
                @endforeach
            </div> 
        </form>
        </div>
        <div class="modal-footer">
        	<button type="submit" class="btn" style="color: white; background-color: #5a386b">Update</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div> 
@endforeach
@push('custom-scripts')
<script>
      $('#myTable').DataTable({
          searching: false
      });

      @if(Session::has('message'))
        toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

      $(function(e){
      $(document).on('click', '.disable-btn', function(){
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Disable this Category?",
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
                url:"{{ route('disable-primary-cat') }}",
                
                success:function(data){
                    if(data.success == true){
                      toastr.success('Success!', data.message ,{"positionClass": "toast-bottom-right"});
                      location.reload();
                    }
                }
             });
          } 
          else{
              swal("Cancelled", "", "error");
          }
       
    });
   });
      $(document).on('click', '.active-btn', function(){
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Active this Category?",
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
                url:"{{ route('active-primary-cat') }}",
                
                success:function(data){
                    if(data.success == true){
                     $("#category_id_"+id).remove();
                      toastr.success('Success!', data.message ,{"positionClass": "toast-bottom-right"});
                      location.reload();
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
      $('.service_id').val(id);
      $.ajax({
                method:"get",
                dataType:"json",
                data:{id:id},
                url:"{{ url('admin/edit-p-service-category') }}",
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
                     // alert(data.e_suggesstion[0]['suggesstion_id']);
                     if(data.services.length > 0){
                      // alert('hi');
                      $('.service_id').val(data.services[0]['primary_service_id']);

                     for( var i=0 ; i < data.services.length ; i++)
                     {
                      if(data.services[i]['language_id'] == 1)
                      {
                        $('#et_edit_title_'+id).val(data.services[i]['title']);

                      }
                      else if(data.services[i]['language_id'] == 2)
                      {
                        $('#en_edit_title_'+id).val(data.services[i]['title']);
                       
                      }
                      else if(data.services[i]['language_id'] == 3)
                      {
                        $('#ru_edit_title_'+id).val(data.services[i]['title']);
                       
                      }
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
   });
  </script>
@endpush
@endsection