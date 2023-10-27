@extends('admin.layouts.app')
@section('content')
<!-- <div class="row mb-3">
   <div class="col-md-8 title-col">
      <h3 class="maintitle text-uppercase fontbold">Color</h3>
   </div>
</div> -->
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Roles</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right">Add Role</button>
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
       <h5 class="mb-1">Roles</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Title</th>
              </tr>
          </thead>
          <tbody>
            @foreach($roles as $role)
             <tr id="role_id_{{$role->id}}">
                
                <td>
                  <div class="d-flex text-center">
                    <a data-toggle="modal" href='#editModal' class="actionicon bg-info editaction" data-target="#editmodal{{$role->id}}" data-id="{{@$role->id}}"><i class="fa fa-pencil"></i></a> 
                    <a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id ="{{$role->id}}"><i class="fa fa-close"></i></a>
                  </div>
                </td>
                @if(Auth::user()->role_id == 1)
                <td> <a href="{{ route('role-menus', ['role_id' => $role->id]) }}"><b>{{$role->name}}</b></a> </td> 
                @else
                <td>{{$role->name}}</td>
                @endif
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
    <form action="{{url('add/role')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Role</h4>
         </div>
         <div class="modal-body">
            <div class="col-md-">
                  {{csrf_field()}}
              
                   <div class="form-group">
                     <label for="name">Name:</label>
                     <input  type="text" name="name" class="form-control" >
                  </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Role</button>
            </div>
      </div>
    </form>
   </div>
</div>
@foreach($roles as $role)
<div class="modal fade" id="editmodal{{$role->id}}" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <form action="{{url('edit/role')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit Role</h4>
         </div>
         <div class="modal-body">
               <input type="hidden" name="id" value="{{$role->id}}">
           <input type="hidden" name="role_id" id="role_id">

               {{csrf_field()}}

                <div class="col-md-">
                  <div class="form-group">
                     <label for="name">Name</label>
                    
                     <input type="text" name="name" class="form-control" value="{{$role->name}}" >
                  </div>
               </div>
         </div>
         <div class="modal-footer">
         <button type="submit" class="btn" style="color: white; background-color: #5a386b">Edit Role</button>
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
          text: "Are you sure you want to Delete this Role?",
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
                url:"{{ route('delete-role') }}",
                
                success:function(data){
                    if(data.success == true){
                     $("#role_id_"+id).remove();
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