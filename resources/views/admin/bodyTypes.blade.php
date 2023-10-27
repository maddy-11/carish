@extends('admin.layouts.app')

@section('content')

<!-- <div class="row mb-3">
  <div class="col-md-8 title-col">
    <h3 class="maintitle text-uppercase fontbold">BodyTypes</h3>
  </div>
 
</div> -->

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">BodyTypes</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float:right;clear:both">Add BodyType</button>
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
       <h5 class="mb-1">BODYTYPES</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                  <!-- <th>Sr No.</th> -->
                  <th>Action</th>
                  <th>BodyType Image</th>
                  <th>Name</th>
                  <th>Api Code</th>
                  <th>Slug</th>
                  
              </tr>
          </thead>
          <tbody>
            @foreach($getbodyTypes as $bodyType)
              <tr id="bodyType_id_{{$bodyType->body_type_id}}">
                  
                  <!-- <td>{{$loop->iteration}}</td> -->
                  <td>
                    <div class="d-flex text-center">
                      <a data-toggle="modal" href='#editModal' class="actionicon bg-info editaction" data-target="#editmodal{{$bodyType->body_type_id}}" data-id="{{@$bodyType->body_type_id}}"><i class="fa fa-pencil"></i></a> 
                      <a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id = "{{$bodyType->body_type_id}}"><i class="fa fa-close"></i></a>
                      
                    </div>
                  </td>
                  <td>
                    @if($bodyType->image != null)
                      <img src="{{asset('public/uploads/image/'.$bodyType->image)}}" alt="BodyType Image" style="height:30px; width:70px; margin-right:1rem;">
                    @else  
                      <img src="{{asset('public/uploads/image/car.png')}}" alt="BodyType Image" style="height:30px; width:70px; margin-right:1rem;">
                    @endif 
                  </td>
                  <td> {{$bodyType->name}}</td>
                  <td> {{$bodyType->api_code !== null ? $bodyType->api_code : '--'}}</td>
                  <td>{{$bodyType->name_slug}}</td>                        
                  
              </tr>
            @endforeach
            
            </td>
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div>


<!-- <div class="container" style="clear:both">
    
    <div style="overflow-x:auto;">
            <table id="myTable" class="table" >
                <thead>
                <tr>
                  <th>Sr No.</th>
                  <th>BodyType Image</th>
                  <th>Name</th>
                  <th>Slug</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody> 
                 @foreach($bodyTypes as $bodyType)
                  <tr id="bodyType_id_{{$bodyType->id}}">
                      <td>{{$loop->iteration}}</td>
                      <td>
                        @if($bodyType->image != null)
                          <img src="{{asset('public/uploads/image/'.$bodyType->image)}}" alt="BodyType Image" style="height:30px; width:70px; margin-right:1rem;">
                        @else  
                          <img src="{{asset('public/uploads/image/car.png')}}" alt="BodyType Image" style="height:30px; width:70px; margin-right:1rem;">
                        @endif 
                      </td>
                      <td> {{$bodyType->name}}</td>
                      <td>{{$bodyType->name_slug}}</td>                        
                      <td>
                        <button class="btn btn-success"  data-toggle="modal" data-target="#editmodal{{$bodyType->id}}" title="Update BodyType"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger delete-btn" data-id = "{{$bodyType->id}}" title="Delete Model"><i class="fa fa-trash"></i></button>
                      </td>
                  </tr>
                  @endforeach
                  </tbody>
            </table>
        </div>
    
</div> -->




<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <form action="{{url('admin/add-bodyType')}}" method="POST" enctype="multipart/form-data">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">         
          <h4 class="modal-title">Add BodyType</h4>
        </div>
      <!--   <div class="modal-header">
          <h1 style="color: #5a386b">Add BodyType</h1>         
        </div> -->
        <div class="modal-body">       
          <div class="col-md-">           
            {{csrf_field()}}
            <!-- <div class="form-group">
              <div class="form-group">
              <label for="name">Name:</label>
              <input required type="text" name="name" class="form-control" >
              </div>
            </div> -->

             <div class="form-group">
                     <label for="name">Api Code:</label>
                     <input  type="text" name="code" class="form-control" >
                  </div>

           <!--  <div class="form-group">
              <div class="form-group">
              <label for="name">Name Slug:</label>
              <input type="text" name="name_slug" class="form-control" >
              </div>
            </div> -->

            <div class="form-group">
              <label for="name">Image:</label>
              <input required type="file" name="image" class="form-control" >
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
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add BodyType</button>           
        </div>
      </div>
      </form>
      
    </div>
</div>  


@foreach($bodyTypes as $bodyType)
<div class="modal fade" id="editmodal{{$bodyType->id}}" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">         
          <h4 class="modal-title">Update BodyType</h4>
        </div>
        <div class="modal-body">
        <div class="col-md-">
            <form action="{{url('admin/edit-bodyType')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{$bodyType->id}}">
                <input type="hidden" name="body_type_id" id="body_type_id">
               <!--  <div class="form-group">
                  <div class="form-group">
                    <label for="name">Name:</label>
                    <input required type="text" name="editName" value="{{$bodyType->name}}" class="form-control" >
                  </div>
                </div> -->

                <!-- <div class="form-group">
                  <div class="form-group">
                    <label for="name">Name Slug:</label>
                    <input required type="text" name="editSlug" value="{{$bodyType->name_slug}}" class="form-control" >
                  </div>
                </div> -->

                <div class="col-md-">
                  <div class="form-group">
                     <label for="name">Api Code:</label>
                    
                     <input type="text" name="edit_code" class="form-control" value="{{$bodyType->api_code}}" >
                  </div>
               </div>

                @if($bodyType->image != null)
                      <div class="custom-file mb-5">
                       <label class="d-block text-left">
                      <a target="" href="{{url('public/uploads/image/'.$bodyType->image)}}"><img src="{{url('public/uploads/image/'.$bodyType->image)}}"  width="100" class="img-rounded" align="center"></a>
                      </label>
                      </div>                      
                      @endif

                <div class="form-group">
                    <label for="name">Image:</label>
                    <input type="file" name="editimage" class="form-control" >
                </div>

                <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#e_{{$language->language_code }}_{{@$bodyType->id}}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach

            </ul>

              <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="e_{{$language->language_code }}_{{@$bodyType->id}}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input type="text" name="{{$language->language_code}}_edit_title" id="{{$language->language_code}}_edit_title_{{@$bodyType->id}}" class="form-control" >

                  </div> 
                </div> 
                @endforeach
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Update bodyType</button>
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

       @if(Session::has('updated'))
        toastr.success('Success!',"{{Session::get('updated')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

      $(function(e){
      $(document).on('click', '.delete-btn', function(){
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Delete this Body Type?",
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
                url:"{{ route('delete-bodyType') }}",
                
                success:function(data){
                    if(data.success == true){
                     $("#model_id_"+id).remove();
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
      $('#body_type_id').val(id);
      $.ajax({
                method:"get",
                dataType:"json",
                data:{id:id},
                url:"{{ url('admin/get-edit-body-type') }}",
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
                      $('#body_type_id').val(data.spareparts[0]['body_type_id']);

                     for( var i=0 ; i < data.spareparts.length ; i++)
                     {
                      if(data.spareparts[i]['language_id'] == 1)
                      {
                        $('#et_edit_title_'+id).val(data.spareparts[i]['name']);

                      }
                      else if(data.spareparts[i]['language_id'] == 2)
                      {
                        $('#en_edit_title_'+id).val(data.spareparts[i]['name']);
                       
                      }
                      else if(data.spareparts[i]['language_id'] == 3)
                      {
                        $('#ru_edit_title_'+id).val(data.spareparts[i]['name']);
                       
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

