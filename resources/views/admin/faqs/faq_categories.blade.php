@extends('admin.layouts.app')
@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Faq Categories</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Add FAQ Category</button>
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
       <h5 class="mb-1">Faq Categories</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Sr No.</th>
                <th>Title</th>
                <th>Image</th>
              </tr>
          </thead>
          <tbody>
                @foreach($faq_category_decs as $faq_category_des)
                <tr id="category_id_{{$faq_category_des->faq_category_id}}">
                   <td>
                    <div class="d-flex text-center">
                      <a data-toggle="modal" class="actionicon bg-info editaction"  data-id = "{{$faq_category_des->faq_category_id}}"><i class="fa fa-pencil"></i></a>

                      <a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id = "{{$faq_category_des->faq_category_id}}"><i class="fa fa-close"></i></a>
                    </div>
                  </td>  
                   <td>{{$loop->iteration }}</td>
                  <td>{{$faq_category_des->title}}</td>
                  <td>
                  @if($faq_category_des->FaqCategory->image != null)
                    <img src="{{asset('public/uploads/image/'.$faq_category_des->FaqCategory->image)}}" alt="Faq Category Image" style="height:30px; width:70px; margin-right:1rem;">
                  @else  
                    <img src="{{asset('public/uploads/image/car.png')}}" alt="Faq Category Image" style="height:30px; width:70px; margin-right:1rem;">
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
      <!-- Modal content-->
    <form action="{{url('add/faq-category')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">         
         <h4 class="modal-title">Add Faq Category</h4>
        </div>
        <div class="modal-body">       
        <div class="col-md-">
           
          {{csrf_field()}}

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
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Faq Category</button> 
        </div>
      </div>      
      </div>
    </form>
  </div>  
</div>
 @foreach($faq_categories as $category)
<div class="modal fade" id="editmodal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">          
          <h4 class="modal-title">Edit Faq Category</h4>
        </div>
         <form action="{{url('edit/faq-categories')}}" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
          <input type="hidden" name="id" value="{{$category->id}}" class="faq_category_id">
          {{csrf_field()}}
          <div class="col-md-">
           @if($category->image != null)
                      <div class="custom-file mb-5">
                       <label class="d-block text-left">
                      <a target="" href="{{url('public/uploads/image/'.$category->image)}}"><img src="{{url('public/uploads/image/'.$category->image)}}"  width="100" class="img-rounded" align="center"></a>
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
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#{{$language->language_code}}_{{@$category->id}}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach

            </ul>
          <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="{{$language->language_code}}_{{@$category->id}}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input type="text" name="{{$language->language_code}}_edit_title" id="{{$language->language_code}}_edit_title_{{@$category->id}}" class="form-control" >

                  </div> 
                </div> 
                @endforeach
            </div>        
        </div>
          <div class="modal-footer">
        	 <button type="submit" class="btn" style="color: white; background-color: #5a386b">Edit Faq Category</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
      $(function(e){
      $(document).on('click', '.delete-btn', function(){
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Delete this Category?",
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
                url:"{{ route('delete-primary-faqcat') }}",
                
                success:function(data){
                    if(data.success == true){
                     $("#category_id_"+id).remove();
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
      $('.faq_category_id').val(id);
      $.ajax({
        method:"get",
        dataType:"json",
        data:{id:id},
        url:"{{ url('admin/edit-faq-category') }}",
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

             if(data.faq_categories_descp.length > 0){
              
              $('.faq_category_id').val(data.faq_categories_descp[0]['faq_category_id']);

             for( var i=0 ; i < data.faq_categories_descp.length ; i++)
             {
              if(data.faq_categories_descp[i]['language_id'] == 1)
              {
                $('#et_edit_title_'+id).val(data.faq_categories_descp[i]['title']);

              }
              else if(data.faq_categories_descp[i]['language_id'] == 2)
              {
                $('#en_edit_title_'+id).val(data.faq_categories_descp[i]['title']);
               
              }
              else if(data.faq_categories_descp[i]['language_id'] == 3)
              {
                $('#ru_edit_title_'+id).val(data.faq_categories_descp[i]['title']);
               
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