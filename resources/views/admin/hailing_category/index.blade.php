@extends('admin.layouts.app')

@section('content')

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Maker</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Maker</button>
  </div>

</div>



@if(session()->has('message'))
    <div class="alert alert-success  alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('message') }}
    </div>
@endif


<div class="container" style="clear:both">
    
    <div style="overflow-x:auto;">
            <table id="myTable" class="table" >
                <thead>

                <tr>
                    <th>Sr No.</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Image</th>
                    <th>Action</th>

                </tr>
                </thead>
                <tbody>
            @foreach($HailingCategory as $car) 
                    <tr id="maker_id_{{$car->id}}">
                        <td>{{$loop->iteration }}</td>
                        <td>{{$car->name}}</td>
                        <td>@if($car->parent) {{$car->parent->name}} @else {{__('No Parent')}} @endif</td>

                        <td>
                         <img src="{{asset('public/uploads/image/'.$car->logo)}}" alt="couponLogo" style="height:50px; width:50px; margin-right:1rem;"></td>
                        <td>
                            <button class="btn btn-success"  data-toggle="modal" data-target="#editmodal{{$car->id}}"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger delete-btn" data-id = "{{$car->id}}"><i class="fa fa-trash"></i></button>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    
</div>



 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">    
      <form action="{{url('admin/hailing_category')}}" method="post" enctype="multipart/form-data">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!-- <h4 class="modal-title">Modal Header</h4> -->
        </div>
        <div class="modal-body">       
         <div class="col-md-">
            <h1 style="color: #5a386b">Add Category</h1>
                {{csrf_field()}}
                 @method('POST') 
       <div class="form-group">
            <label for="name">Parent Category:</label>
            <select name="hailing_category_id" class="form-control" >
              <option value="0">Select</option>
              @if(!$hailing->isEmpty())
                @foreach($hailing as $cats)
                  <option value="{{$cats->id}}">{{$cats->name}}</option>
                @endforeach
              @endif
               
            </select>
          </div>    

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div> 
          <div class="form-group">
            <label for="name">Image:</label>
            <input required type="file" name="logo" class="form-control" >
          </div>               
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Save</button>           
        </div>
      </div>
      </form>      
    </div>
  </div>  
</div>



 @foreach($HailingCategory as $car)
<div class="modal fade" id="editmodal{{$car->id}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!-- <h4 class="modal-title">Modal Header</h4> -->
        </div>
        <div class="modal-body">
        

        <div class="col-md-">
            <h1 style="color: #5a386b">Edit Maker</h1>
            <form action="{{route('edit-maker')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{$car->id}}">
                <div class="form-group">
                    <label for="name">Title:</label>
                    <input required type="text" name="edit_title" class="form-control" value="{{$car->name}}" >
                </div>

                 <!--     <div class="form-group">
                    <label for="name">Select Year:</label>
                   <select multiple name="edityear[]" class="form-control" Required>
                   @foreach($years as $year)
                    <option value="{{$year->id}}">{{$year->title}}</option>
                    @endforeach
                  </select>
                </div> -->

                 <div class="form-group">
                   <img src="{{url('public/image/'.$car->logo )}}" class="img-fluid" alt="carish used cars for sale in estonia" width="50px" height="50px"><br>
                    <label for="name">Image:</label>
                   
                    <input  type="file" name="edit_img" class="form-control">
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
          text: "Are you sure you want to Delete this Maker?",
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
                url:"{{ route('delete-maker') }}",
                
                success:function(data){
                    if(data.success == true){
                     $("#maker_id_"+id).remove();
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
  </script>
  @endpush




@endsection