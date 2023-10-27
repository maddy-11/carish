@extends('admin.layouts.app')
@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Services / 
      <a target="" href="{{url('admin/service-category')}}">Parent Categories</a> / 
      <a target="" href="{{url('admin/sub-service/'.$primary_services->primary_service_id)}}">{{$primary_services->title}}</a> /
      <a target="" href="{{url('admin/sub-subservice/'.$sub_category->sub_cat_id)}}">{{$sub_category->SubTitle}}</a>
    </h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Add Detail</button>
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
       <h5 class="mb-1">Details</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Detail</th>
                <th>Status</th>
              </tr>
          </thead>
          <tbody>            
            @foreach($sub_subservices as $sub_service)
             <tr id="service_id_{{$sub_service->id}}">
               <td style="width:100px;">
                    <a class="actionicon bg-info editaction text-center" title="edit" data-toggle="modal" data-target="#editmodal{{$sub_service->sub_cat_id}}" data-id = "{{@$sub_service->sub_cat_id}}"><i class="fa fa-pencil" style="color: white;"></i></a>

                    @if($sub_service->status == 1)
                   <a class="actionicon bg-black deleteaction disable-btn text-center" href="javascript:void(0)" title="Disable" data-id="{{$sub_service->sub_cat_id}}"><i class="fa fa-ban"></i></a>
                   @else
                   <a class="actionicon bg-green deleteaction active-btn text-center" href="javascript:void(0)" title="Active" data-id="{{$sub_service->sub_cat_id}}"><i class="fa fa-undo"></i></a>
                   @endif                 
                </td>
                <td>{{$sub_service->SubTitle }}</td> 
                <td>
                  @if($sub_service->status == 1)
                  Active
                  @else
                  Disable
                  @endif
                </td>        
             </tr>
             @endforeach            
          </tbody>
      </table>
    </div>
   </div>
  </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">  
    <form action="{{url('add/sub-service')}}" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="make" value="0">
      <input type="hidden" name="parent_id" value="{{$sub_category->sub_cat_id}}">
      <input  type="hidden" name="primary_service" value="{{$primary_services->primary_service_id}}">
      <div class="modal-content">
        <div class="modal-header">         
         <h4 class="modal-title">Add Detail</h4>
        </div>
        <div class="modal-body">       
        <div class="col-md-">
          {{csrf_field()}}
          <div class="form-group">
            <label for="" class="form-label">Parent Category</label>            
            <input type="text" name=""  class="form-control" disabled="disabled" value="{{$primary_services->title}}">
          </div>
          <div class="form-group">
            <label for="" class="form-label">Sub Category</label>
            <input  type="hidden" name="primary_service" value="{{$sub_category->sub_cat_id}}">
            <input type="text" name=""  class="form-control" disabled="disabled" value="{{$sub_category->SubTitle}}">
          </div> 
          <label for="" class="form-label">Detail</label> 
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
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Detail</button> 
        </div>
      </div>      
      </div>
    </form>
  </div>  
</div>
@foreach($sub_subservices as $sub_service)
<div class="modal fade" id="editmodal{{$sub_service->sub_cat_id}}" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">          
          <h4 class="modal-title">Edit Sub Cateogry</h4>
        </div>
       <div class="modal-body">
        <form action="{{url('edit/sub-services')}}" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="{{$sub_service->sub_cat_id}}" class="service_id">
          {{csrf_field()}}
          <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#{{$language->language_code}}_{{@$sub_service->sub_cat_id}}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach
            </ul>
          <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="{{$language->language_code}}_{{@$sub_service->sub_cat_id}}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input type="text" name="{{$language->language_code}}_edit_title" id="{{$language->language_code}}_edit_title_{{@$sub_service->sub_cat_id}}" class="form-control" >
                  </div> 
                </div> 
                @endforeach
            </div> 
        <div class="modal-footer">
           <button type="submit" class="btn" style="color: white; background-color: #5a386b">Update</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
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
      text: "Are you sure you want to Disable this Detail?",
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
            url:"{{ route('disable-sub-cat') }}",
            
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
      text: "Are you sure you want to Active this Detail?",
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
            url:"{{ route('active-sub-cat') }}",
            
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
    $(document).on('click', '.editaction', function(){
  var id = $(this).data('id');
  $('.service_id').val(id);
  $.ajax({
            method:"get",
            dataType:"json",
            data:{id:id},
            url:"{{ url('admin/edit-sub-service-category') }}",
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
                  $('.service_id').val(data.services[0]['sub_service_id']);

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