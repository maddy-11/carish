@extends('admin.layouts.app')

@section('content')

<!-- <div class="row mb-3">
  <div class="col-md-8 title-col">
    <h3 class="maintitle text-uppercase fontbold">Sub Services</h3>
  </div>
 
</div> -->

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Services / <a target="" href="{{url('admin/service-category')}}">Parent Categories</a> / <a target="" href="{{url('admin/sub-service/'.@$primary_services->primary_service_id)}}">{{@$primary_services->title}}</a></h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Add Sub Category</button>
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
       <h5 class="mb-1">Sub Categories</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Sub Category</th>
                <th>Status</th>
                <th>Is Make</th>
              </tr>
          </thead>
          <tbody>            
            @foreach($sub_services as $service)
             <tr id="service_id_{{$service->id}}">
                <td style="width:100px;">
                   <a class="actionicon bg-info editaction text-center" title="edit" data-toggle="modal" data-target="#editmodal{{$service->sub_cat_id}}" data-id ="{{@$service->sub_cat_id}}"><i class="fa fa-pencil" style="color: white;"></i></a>
                   @if($service->status == 1)
                   <a class="actionicon bg-black deleteaction disable-btn text-center" href="javascript:void(0)" title="Disable" data-id="{{$service->sub_cat_id}}"><i class="fa fa-ban"></i></a>
                   @else
                   <a class="actionicon bg-green deleteaction active-btn text-center" href="javascript:void(0)" title="Active" data-id="{{$service->sub_cat_id}}"><i class="fa fa-undo"></i></a>
                   @endif
                 </td>
                <td>
                  <a target="" href="{{url('admin/sub-subservice/'.$service->sub_cat_id)}}">{{$service->SubTitle }}</a></td>
                <td>
                  @if($service->status == 1)
                  Active
                  @else
                  Disable
                  @endif
                </td>
                <td>@if($service->is_make == 1)
                  True
                  @else
                  False
                  @endif</td>
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
    <form action="{{url('add/sub-service')}}" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="parent_id" value="0">
      <input  type="hidden" name="primary_service" value="{{@$primary_services->primary_service_id}}">
      <div class="modal-content">
        <div class="modal-header">         
         <h4 class="modal-title">Add Sub Category</h4>
        </div>
        <div class="modal-body">       
        <div class="col-md-">
          {{csrf_field()}}
          <div class="form-group">
            <label for="" class="form-label">Parent Category</label>
            <input type="text" name=""  class="form-control" disabled="disabled" value="{{@$primary_services->title}}">
          </div> 
          <div class="form-group">
              <div id="CategoryList"></div>
          </div> 
          <div class="form-group">
              <label for="title">IsMake:</label>
                <input  type="radio" id="true" name="make" value="1">True
                <input type="radio" checked="checked" id="false" name="make" value="0">False
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
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Sub Category</button> 
        </div>
      </div>      
      </div>
    </form>
  </div>  
</div>
@foreach($sub_services as $service)
<div class="modal fade" id="editmodal{{$service->sub_cat_id}}" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">          
          <h4 class="modal-title">Edit Sub Cateogry</h4>
        </div>
       <div class="modal-body">
        <form action="{{url('edit/sub-services')}}" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="{{$service->sub_cat_id}}" class="service_id">
          {{csrf_field()}}
          <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#{{$language->language_code}}_{{@$service->sub_cat_id}}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach
            </ul>
          <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="{{$language->language_code}}_{{@$service->sub_cat_id}}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input type="text" name="{{$language->language_code}}_edit_title" id="{{$language->language_code}}_edit_title_{{@$service->sub_cat_id}}" class="form-control" >
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
  <script type="text/javascript">
  $(document).ready(function(){
    @if(Session::has('message'))
        toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
      @endif
/*    $(document).on("change","#primary_Service",function() {
      var ps = $('#primary_Service').val();
      $.ajax({
        type: "get",
        url: "{{url('admin/getParent-primary')}}/"+ps,
        success: function(data){
          // alert(data.ProcedureObject);
          if(data.error == true){
            $('#Assignedparent').html('');
          }
          else{
            var html_string ='';
            var CategoryArray  = data.Assignedparent;
            html_string = html_string+ '<label>Choose Category:</label><select  name="CategoryName" id="SelectCategoryByid" class="form-control" ><option value="0">Select Category</option>';
            for(var i = 0;  i < CategoryArray.length ; i++){
              html_string =html_string+'<option value="'+CategoryArray[i]['id']+'">'+CategoryArray[i]['title']+'</option>';
            }
            html_string =html_string+'</select>';

            $('#CategoryList').html(html_string);
          } 
        }
      });
    });*/
  })
</script>
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
      text: "Are you sure you want to Disable this Sub Category?",
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
      text: "Are you sure you want to Active this Sub Category?",
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
  // alert(id);
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