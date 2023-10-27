@extends('admin.layouts.app')
<style type="text/css">
  .business.active{
    background-color: #017baa !important;
    color: white !important;
  }

  .individual.active{
    background-color: #017baa !important;
    color: white !important;
  }
  
</style>
@section('content')
<!-- <div class="row mb-3">
   <div class="col-md-8 title-col">
      <h3 class="maintitle text-uppercase fontbold">Users</h3>
   </div>
</div> -->

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
  <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize" id="main">Admin Pending / Business Users</h3>
  </div>
</div>

@if(session()->has('message'))
<div class="alert alert-success  alert-block">
   <button type="button" class="close" data-dismiss="alert">×</button>
   {{ session()->get('message') }}
</div>
@endif

<ul class="nav nav-tabs" id="tabMenu">
  <li class="nav-item">
    <a class="nav-link business active" id="company_tab" >Business Users</a>
  </li>
<!--   <li class="nav-item">
    <a class="nav-link individual" id="individual_tab" >Individual Users</a>
  </li> -->
</ul>
  
<div class="row" id="company_table">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder" style="box-shadow: 0 10px 10px rgba(0,0,0,0.56);">
      <div class="table-responsive">
        <table id="example1" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Company</th>
                <th>Email</th>
                <th>Registration#</th>
                <th>Vat</th>
                <th>Phone#</th>
                <th>Prefered<br>Language</th>
              </tr>
          </thead>
          <tbody>
            @foreach($buisness as $user)
             <tr id="user_id_{{$user->id}}">
                <td>
                  <div class="d-flex text-center">
                    <a data-toggle="modal" href='#deleteModal' class="actionicon bg-green deleteaction active-btn" data-id="{{$user->id}}" alt="Approve It"><i class="fa fa-check"></i></a>
                    <!--<a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id="{{$user->id}}" alt="Delete It"><i class="fa fa-close"></i></a>-->
                    <a data-toggle="modal" id="not_approve_modal" href='#deleteModal' class="actionicon bg-green" data-id="{{$user->id}}"  alt="Reject It"><i class="fa fa-ban"></i></a>
                  </div>
                </td>
                <td><a href="{{url('admin/in-active/user-detail/'.$user->id)}}" ><b>{{$user->customer_company}}</b></a></td>
                <td>{{$user->customer_email_address}}</td>
                <td>{{@$user->customer_registeration}}</td>
                <td>{{$user->customer_vat}}</td>
                <td>{{$user->customers_telephone}}</td>
                <td>{{@$user->language->language_title}}</td>
             </tr>
             @endforeach
          </tbody>
      </table>
    </div>
   </div>
  </div>
</div>
<div class="modal fade" id="adMessageModal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="{{route('business-not-approved')}}" id="not_approve_business_form" class="editSuggestion" method="post">
          @csrf
          <div class="modal-body">
        <input type="hidden" name="msg_customer_id" id="msg_customer_id" value="{{@$ads->id}}">
        <div class="form-group">
            <p><span style="color: red;font-style: italic;">Note: </span><span style="font-style: italic;font-weight: 300;">Hold down the Ctrl (windows) or Command (Mac) button to select multiple options.</span></p>
            <hr>
            <label>Reasons</label>
            <select name="reason[]" class="form-control selectpicker" multiple data-live-search="true">
              <option>---Select Reason---</option>
              @foreach($reasons as $reason)
                <option value="{{@$reason->id}}">{{$reason->reason_description()->where('language_id',2)->pluck('title')->first()}}</option>
              @endforeach
            </select>
        </div> 
      </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" id="not_approve_business" class="btn btn-primary" style="background-color: #017baa !important;border-color: #017baa !important">Submit</button>
      </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal" id="loader_modal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <h3 style="text-align:center;">Please wait</h3>
          <p style="text-align:center;"><img src="{{ asset('assets/admin/img/waiting.gif') }}"></p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="loader_modal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <h3 style="text-align:center;">Please wait</h3>
        <p style="text-align:center;"><img src="{{ asset('public/assets/img/gif/waiting.gif') }}"></p>
      </div>
    </div>
  </div>
</div>

@push('custom-scripts')
<script>
  $(document).ready(function() {
    $('#example1').DataTable();
    $('#example2').DataTable();
    $(document).on('click','#individual_tab' , function(){
      $(this).addClass('active');
      $('#individual_table').removeClass('d-none');
      $('#company_tab').removeClass('active');
      $('#company_table').addClass('d-none');
    });
    $(document).on('click','#company_tab' , function(){
      $(this).addClass('active');
      $('#company_table').removeClass('d-none');
      $('#individual_tab').removeClass('active');
      $('#individual_table').addClass('d-none');
    });
  });
   @if(Session::has('message'))
     toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
   @endif
   $(function(e){
      $(document).on('click', '.delete-btn', function(){
      var c_id = $(this).data('id');
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
             $.ajax(
                {
              method: "get",
              dataType: "json",
              data: {
                id: c_id
              },
              url: "{{ route('delete-inactivecustomer') }}",

                
                success:function(data){
                    if(data.success == true){
                      toastr.error('Error!', data.message ,{"positionClass": "toast-bottom-right"});
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
      
      $(document).on('click', '.active-btn', function() {
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Verify this User?",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          cancelButtonText: "No!",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm) {
          if (isConfirm) {
            $.ajax({
              method: "get",
              dataType: "json",
              data: {
                id: id
              },
              url: "{{ route('verify-customer') }}",
              success: function(data) {
                if (data.success == true) {
                 // $("#maker_id_" + id).remove();
                  //$('.maker_table').DataTable().ajax.reload();
                  location.reload();
                  toastr.success('Success!', data.message, {
                    "positionClass": "toast-bottom-right"
                  });
                } else if (data.success == false) {
                  toastr.success('Success!', data.message, {
                    "positionClass": "toast-bottom-right"
                  });
                }

              }
            });
          } else {
            swal("Cancelled", "", "error");
          }

        });
    });

    $(document).on('click', '#not_approve_modal' , function(){
      var c_id = $(this).data('id');
      $("#msg_customer_id").val(c_id);
      $('#adMessageModal').modal('show');
    });

    $(document).on('click', '#not_approve_business' , function(){
      // e.preventDefault();
      id = $(this).data('id');
      /*******************/
      swal({
          title: "Alert!",
          text: "Are you sure you want to not Approve this Business?",
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
            $('#not_approve_business_form').submit();
          } 
          else{
            $('#adMessageModal').modal('hide');
              swal("Cancelled", "", "error");
          }
       
    });
      /*******************/

    });

   });
</script>
<script type="text/javascript">
  $('#company_tab').on('click',function(){
    $('#main').text('');
    $('#main').append('<a target="" href="{{url("admin/in-active/user")}}">Inactive</a> / Business Users');
    $('#loader_modal').modal('show');
    window.location.reload();
  });
  $('#individual_tab').on('click',function(){
    $('#loader_modal').modal('show');
    setTimeout(function(){ $('#loader_modal').modal('hide'); }, 1000);
    $('#main').text('');
    $('#main').append('Inactive / Individual Users');

  });
</script>
@endpush
@endsection