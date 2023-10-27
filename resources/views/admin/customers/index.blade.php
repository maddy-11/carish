@extends('admin.layouts.app')
@section('content')
<!-- <div class="row mb-3">
  <div>
  <button type="button" class="btn btn-primary" style="float: right; display: none;" id="send">Send Mail</button>
  </div>
   <div class="col-md-8 title-col">
      <h3 class="maintitle text-uppercase fontbold">Individual Customers</h3>

   </div>
</div> -->

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Individual Customers</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-primary" style="float: right; display: none;" id="send">Send Mail</button>
  </div>

</div>

@if(session()->has('message'))
<div class="alert alert-success  alert-block">
   <button type="button" class="close" data-dismiss="alert">×</button>
   {{ session()->get('message') }}
</div>
@endif
<div id="mailModalForSelectedUsers" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h3>Send Email
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </h3>
      </div>
      <form  method="post" id="customer_email_form">
        {{ csrf_field() }}
        <div class="modal-body"> 
         
          <label>Message</label>
          <textarea class="form-control" name="message"  id="messsage_body_for_selected_users"></textarea>
         
        </div>
        {{-- <div class="col-md-offset-5">
          <label>
            <input type="checkbox" value="1" class="form-control" name="sendemail">
            Send Email </label>
        </div> --}}
        <div class="modal-footer">
          {{-- <button type="submit" class="btn btn-danger" id="subBtn" onclick="$('#sendMailForm')[0].reset();">Clear</button> --}}
          <button type="button" class="btn btn-primary" id="customer_email">Send</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Individual Customers</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>select</th>
                <th>Sr No.</th>
                <th>Name</th>
                <th>Email</th>
              </tr>
          </thead>
          <tbody>
            
            @foreach($users as $user)
             <tr id="user_id_{{$user->id}}">
                <td>               
                  <button class="btn btn-danger delete-btn" title="delete" data-id ="{{$user->id}}" ><i class="fa fa-trash"></i></button>
                </td>
                <td><input type="checkbox" name="checkbox" id="check"> <input type="hidden" name="user_id" value="{{$user->id}}" id="user_id"></td>
                <td>{{$loop->iteration }}</td>
                <td>{{$user->customer_firstname}} {{$user->customer_lastname}}</td>
                <td>{{$user->customer_email_address}}</td>
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
            <th>select</th>
            <th>Sr No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         @foreach($users as $user)
         <tr id="user_id_{{$user->id}}">
            <td><input type="checkbox" name="checkbox" id="check"> <input type="hidden" name="user_id" value="{{$user->id}}" id="user_id"></td>
            <td>{{$loop->iteration }}</td>
            <td>{{$user->customer_firstname}} {{$user->customer_lastname}}</td>
            <td>{{$user->customer_email_address}}</td>
            <td>               
              <button class="btn btn-danger delete-btn" title="delete" data-id ="{{$user->id}}" ><i class="fa fa-trash"></i></button>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
</div> -->
</div>

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
      var c_id = $(this).data('id');
     var route = "{{ route('remove','c_id') }}";
     route = route.replace('c_id',c_id); 
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
                //data:{id:id},
                url:route,
                
                success:function(data){
                    if(data.success == true){
                     $("#color_id_"+c_id).remove();
                      toastr.error('Error!', data.message ,{"positionClass": "toast-bottom-right"});
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

<script type="text/javascript">
  $('#check').on('change',function(){

      $('#send').css('display','block');
  });

  $('#send').on('click',function()
  {

    $('#mailModalForSelectedUsers').modal('show');

  });


  $('#customer_email').on('click',function(){

    var body = $('#messsage_body_for_selected_users').val();
    var id = $('#user_id').val();
//alert(id);
      $.ajax({
        type: "post",
          dataType: 'json',
          data: new FormData ($('#customer_email_form')[0]),
          cache: false,
          contentType: false,
          processData: false,
          url: "{{url('admin/sendMail')}}/"+id,
        success: function(data){

          } 
        // alert(data.total_bill);
      });
  



  });

</script>


@endpush
@endsection