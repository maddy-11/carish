@extends('admin.layouts.app')
@section('content')
<!-- <div class="row mb-3">
   <div class="col-md-8 title-col">
      <h3 class="maintitle text-uppercase fontbold">Users</h3>
   </div>
</div> -->

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Users</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right">Add Suggestion</button> -->
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
       <h5 class="mb-1">Users</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Sr No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
              </tr>
          </thead>
          <tbody>
            
            @foreach($users as $user)
             <tr id="user_id_{{$user->id}}">
                <td>   
                @if($user->role_id!=1)            
                  <button class="btn btn-danger delete-btn" title="delete" data-id ="{{$user->id}}" ><i class="fa fa-trash"></i></button>
                    @endif
                </td>
                <td>{{$loop->iteration }}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{@$user->roles->name}}</td>
             </tr>
            @endforeach
            
            </td>
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div>


<!-- <div style="margin-top: 40px">
   <table id="myTable" class="table" >
      <thead>
         <tr>
            <th>Sr No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         @foreach($users as $user)
         <tr id="user_id_{{$user->id}}">
            <td>{{$loop->iteration }}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            
            <td>   
            @if($user->role_id!=1)            
              <button class="btn btn-danger delete-btn" title="delete" data-id ="{{$user->id}}" ><i class="fa fa-trash"></i></button>
                @endif
            </td>
          
         </tr>
         @endforeach
      </tbody>
   </table>
</div> -->


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
          text: "Are you sure you want to Delete this User?",
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
                url:"{{ route('delete-user') }}",
                
                success:function(data){
                    if(data.success == true){
                      toastr.success('success', data.message ,{"positionClass": "toast-bottom-right"});
                    setTimeout(window.location.reload.bind(window.location), 1000);
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