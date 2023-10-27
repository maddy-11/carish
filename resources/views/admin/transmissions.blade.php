@extends('admin.layouts.app')
@section('content')
<!-- <div class="row mb-3">
   <div class="col-md-8 title-col">
      <h3 class="maintitle text-uppercase fontbold">Color</h3>
   </div>
</div> -->
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Transmissions</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right">Add Transmission</button>
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
       <h5 class="mb-1">Transmissions</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Name</th>
                <th>Api Code</th>
              </tr>
          </thead>
          <tbody>
            @foreach($transmissions as $engine)
             <tr id="engine_type_id_{{$engine->id}}">
                
                <td>
                  <div class="d-flex text-center">
                    <a data-toggle="modal" href='#editModal' class="actionicon bg-info editaction" data-target="#editmodal{{$engine->id}}" data-id="{{@$engine->id}}"><i class="fa fa-pencil"></i></a> 
                    <a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id ="{{$engine->id}}"><i class="fa fa-close"></i></a>
                  </div>
                </td>
                <td>
                  @php
                   $p_caty = ($engine->transmission_description()->where('language_id',2)->pluck('title')->first());
                   @endphp
                  {{$p_caty !== null ? @$p_caty : '--'}}
                </td>
                <td>{{$engine->api_code}}</td>
                
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
    <form action="{{url('add/transmission')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Transmission</h4>
         </div>
         <div class="modal-body">
            <div class="col-md-">
                  {{csrf_field()}}
                  <div class="form-group">
                     <label for="name">Api Code:</label>
                     <input required type="text" name="code" class="form-control" >
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
                       <input type="text" name="{{$language->language_code}}_add_title" id="{{$language->language_code}}_edit_title" class="form-control" >

                  </div> 
                </div> 
                @endforeach
            </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Transmission</button>
            </div>
      </div>
    </form>
   </div>
</div>
@foreach($transmissions as $engine)
<div class="modal fade" id="editmodal{{$engine->id}}" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <form action="{{url('edit/transmission')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit Transmission</h4>
         </div>
         <div class="modal-body">
               <input type="hidden" name="id" value="{{$engine->id}}">
           <input type="hidden" name="transmission_id" id="transmission_id">

               {{csrf_field()}}
               <div class="col-md-">
                  <div class="form-group">
                     <label for="name">Api Code:</label>
                    
                     <input required type="text" name="edit_code" class="form-control" value="{{$engine->api_code}}" >
                  </div>
               </div>

               <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#e_{{$language->language_code }}_{{@$engine->id}}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach

            </ul>

              <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="e_{{$language->language_code }}_{{@$engine->id}}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input type="text" name="{{$language->language_code}}_edit_title" id="{{$language->language_code}}_edit_title_{{@$engine->id}}" class="form-control" >

                  </div> 
                </div> 
                @endforeach
            </div>
         </div>
         <div class="modal-footer">
         <button type="submit" class="btn" style="color: white; background-color: #5a386b">Edit Transmission</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
      </form>

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

   @if(Session::has('updated'))
     toastr.success('Success!',"{{Session::get('updated')}}" ,{"positionClass": "toast-bottom-right"});
   @endif

   $(function(e){
      $(document).on('click', '.delete-btn', function(){
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Delete this Transmission?",
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
                url:"{{ route('delete-transmission') }}",
                
                success:function(data){
                    if(data.success == true){
                     $("#engine_type_id_"+id).remove();
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
   });

   $(document).on('click', '.editaction', function(){
      var id = $(this).data('id');
      // alert(id);
      $('#transmission_id').val(id);
      $.ajax({
                method:"get",
                dataType:"json",
                data:{id:id},
                url:"{{ url('admin/edit-transmission') }}",
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
                     if(data.spareparts.length > 0){
                      // alert('hi');
                      $('#transmission_id').val(data.spareparts[0]['transmission_id']);

                     for( var i=0 ; i < data.spareparts.length ; i++)
                     {
                      if(data.spareparts[i]['language_id'] == 1)
                      {
                        $('#et_edit_title_'+id).val(data.spareparts[i]['title']);

                      }
                      else if(data.spareparts[i]['language_id'] == 2)
                      {
                        $('#en_edit_title_'+id).val(data.spareparts[i]['title']);
                       
                      }
                      else if(data.spareparts[i]['language_id'] == 3)
                      {
                        $('#ru_edit_title_'+id).val(data.spareparts[i]['title']);
                       
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
</script>
@endpush
@endsection