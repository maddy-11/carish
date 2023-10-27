@extends('admin.layouts.app')
@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Spare Part / <a target="" href="{{url('admin/part-category')}}">Main Categories</a>
      @if($parent_category)
      / <a target="" href="{{url('admin/child-category/'.$parent_category->id)}}">{{@$parent_category->title}}</a>
      @endif
  </h3></div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right">Add category</button>
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
       <h5 class="mb-1"> 
        @if($parent_category)
       {{@$parent_category->title}}
       @else
       Main
      @endif Categories</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Name</th>
                <th>Image</th>
              </tr>
          </thead>
          <tbody>
            
            @foreach($categories as $category)
             <tr id="category_id_{{$category->id}}">
                <td>
                  <div class="d-flex text-center">
                      <a data-toggle="modal" href='#editModal' class="actionicon bg-info editaction" data-target="#editmodal{{$category->id}}" data-id = "{{$category->id}}"><i class="fa fa-pencil"></i></a> 
                      <a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id = "{{$category->id}}"><i class="fa fa-close"></i></a>
                    </div>


                </td>
                @if($category->parent_id == 0)
                <td><a target="" href="{{url('admin/child-category/'.$category->id)}}"> <b>{{$category->title}}</b></a></td>
                @else
                <td>{{$category->title}}</td>
                @endif
                <td>
               @if($category->image != null)
                  <img src="{{asset('public/uploads/image/'.$category->image)}}" alt="category Image" style="height:30px; width:70px; margin-right:1rem;">
                 @else  
                  <img src="{{asset('public/uploads/image/car.png')}}" alt="category Image" style="height:30px; width:70px; margin-right:1rem;">
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
    <form action="{{url('add/part-category')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">         
         <h4 class="modal-title">Add Category</h4>
        </div>
        <div class="modal-body">       
        <div class="col-md-">
          {{csrf_field()}}
      
          @if($parent_category)
          <div class="form-group">
          <label for="name">Parent Category</label>
          <select class="form-control" disabled="">
          <option value="0">Select a category</option>
          @foreach($parent_categories as $p_cat)
          <option value="{{$p_cat->id}}" {{$p_cat->id == $parent_category->id ? 'selected' : ''}}>{{$p_cat->title}}</option>
          @endforeach
          </select>
          <input type="hidden" name="parent_id" value="{{$parent_category->id}}">
          </div>
          @else
          <div class="form-group">
          <label for="name">Parent Category</label>
          <select class="form-control" name="parent_id">
          <option value="0">Select a category</option>
          @foreach($categories as $cat)
          <option value="{{$cat->id}}">{{$cat->title}}</option>
          @endforeach
          </select>
          </div>
          
          @endif

           <!-- <div class="form-group">
              <label for="name">Category</label>
              <input required type="text" name="title" class="form-control" >
          </div>  -->

          <div class="form-group mb-3">
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
                       <input type="text" name="{{$language->language_code}}_add_title" id="{{$language->language_code}}_add_title" class="form-control" >

                  </div> 
                </div> 
                @endforeach
            </div>              
               
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add category</button> 
        </div>
      </div>      
      </div>
    </form>
  </div>  
</div>


@foreach($categories as $category)
<div class="modal fade" id="editmodal{{$category->id}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">          
          <h4 class="modal-title">Edit Category</h4>
        </div>
<form action="{{url('edit/part-category')}}" method="POST" enctype="multipart/form-data">
       <div class="modal-body">
           <input type="hidden" name="sparepart_id" id="sparepart_id">
            	<input type="hidden" name="id" value="{{$category->id}}">
                {{csrf_field()}}
        <div class="col-md-">
                <div class="form-group">
                    <label for="name">Parent Category</label>
                    <select class="form-control" name="parent_id">
                      <option value="0">Select a Category</option>
                      @foreach($parent_categories as $p_cat)
                        <option value="{{$p_cat->id}}" {{$p_cat->id == $category->parent_id ? 'selected' : ''}}>{{$p_cat->title}}</option>
                      @endforeach
                    </select>
                </div>

                

                 @if($category->image != null)
                      <div class="custom-file mb-5">
                       <label class="d-block text-left">
                      <a target="" href="{{url('public/uploads/image/'.$category->image)}}"><img src="{{url('public/uploads/image/'.$category->image)}}"  width="100" class="img-rounded" align="center"></a>
                      </label>
                      </div>                      
                      @endif

                <div class="form-group">
                    <label for="name">Image:</label>
                    <input type="file" name="editimage" class="form-control" >
                </div>

               <!--  <div class="form-group">
                  <label for="name">Title:</label>
                  <input required type="text" name="edit_title" class="form-control" value="{{$category->title}}" >
                </div> -->

                <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#e_{{$language->language_code }}_{{@$category->id}}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach

            </ul>

             <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="e_{{$language->language_code }}_{{@$category->id}}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input type="text" name="{{$language->language_code}}_edit_title" id="{{$language->language_code}}_edit_title_{{@$category->id}}" class="form-control" >

                  </div> 
                </div> 
                @endforeach
            </div>

        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        	 <button type="submit" class="btn">Edit Category</button>
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
                url:"{{ route('delete-part-category') }}",
                
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
   });

      $(document).on('click', '.editaction', function(){
      var id = $(this).data('id');
      // alert(id);
      $('#sparepart_id').val(id);
      $.ajax({
                method:"get",
                dataType:"json",
                data:{id:id},
                url:"{{ url('admin/edit-part-category') }}",
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
                      $('#sparepart_id').val(data.spareparts[0]['spare_part_category_id']);

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