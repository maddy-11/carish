@extends('admin.layouts.app')
@section('content')
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
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize" id="main">Active / Business Users</a></h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
  </div>
</div>
@if(session()->has('message'))
<div class="alert alert-success  alert-block">
   <button type="button" class="close" data-dismiss="alert">×</button>
   {{ session()->get('message') }}
</div>
@endif
<ul class="nav nav-tabs" style="border-bottom: none;">
  <li class="nav-item">
    <a class="nav-link business active" id="company_tab" >Business Users</a>
  </li>
  <li class="nav-item">
    <a class="nav-link individual" id="individual_tab" >Individual Users</a>
  </li>
</ul>
<div class="row" id="company_table">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder" style="box-shadow: 0 10px 10px rgba(0,0,0,0.56);">
     <!--  <div class="section-header">
       <h5 class="mb-1">Business Users</h5>
      </div> -->
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Company</th>
                <th>Email</th>
                <th>Registration#</th>
                <th>Vat</th>
                <th>Phone#</th>
                <th>City</th>
                <th>Prefered<br>Language</th>
              </tr>
          </thead>
          <tbody>
            @foreach($buisness as $user)
             <tr id="user_id_{{$user->id}}">
                <td><div class="d-flex text-center">
                  <a href="javascript:void(0);" class="login-as-user bg-info actionicon" data-userid="{{$user->id}}" data-role_name="individual" ><i class="fa fa-user"></i></a> 
                   <a data-toggle="modal" href='#deleteUser' class="actionicon bg-danger deleteaction delete-btn" data-id = "{{$user->id}}"><i class="fa fa-remove"></i></a></div>
                </td>
                <td><a href="{{url('admin/active/user-detail/'.$user->id)}}" ><b>{{$user->customer_company}}</b></a></td>
                <td>{{$user->customer_email_address}}</td>
                <td>{{@$user->customer_registeration}}</td>
                <td>{{$user->customer_vat}}</td>
                <td>{{$user->customers_telephone}}</td>
                <td>{{@$user->city->name}}</td>
                <td>{{@$user->language->language_title}}</td>
             </tr>
             @endforeach            
          </tbody>
      </table>
    </div>
   </div>
  </div>
</div>

<div class="row d-none" id="individual_table">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder" style="box-shadow: 0 10px 10px rgba(0,0,0,0.56);">
     <!--  <div class="section-header">
       <h5 class="mb-1">Individual Users</h5>
      </div> -->
      <div class="table-responsive">
        <table id="example1" class="table table-bordered">
          <thead>
              <tr>
                <th>Action</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone no</th>
                <th>City</th>
                <th>Prefered<br>Language</th>
              </tr>
          </thead>
          <tbody>
            
            @foreach($users as $user)
             <tr id="user_id_{{$user->id}}">                
                <td>
                  <div class="d-flex text-center">
                <a href="javascript:void(0);" class="login-as-user" data-userid="{{$user->id}}" data-role_name="individual" ><i class="fa fa-user"></i></a>
                   <a data-toggle="modal" href='#deleteUser' class="actionicon bg-danger deleteaction delete-btn" data-id = "{{$user->id}}"><i class="fa fa-remove"></i></a></div>
                </td>
                <td><a href="{{url('admin/active/user-detail/'.$user->id)}}" ><b>{{$user->customer_company}}</b></a></td>
                <td>{{$user->customer_email_address}}</td>
                <td>{{$user->customers_telephone}}</td>
                <td>{{@$user->city->name}}</td>
                <td width="8%">{{@$user->language->language_title}}</td>
             </tr>
             @endforeach              
          </tbody>
      </table>
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
<!--  Copy Link Modal Start Here -->
<div class="modal" id="copyLinkModal">
    <div class="modal-dialog modal-lg modal-dialog-centered parcelpop">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body text-center">
          <h3 class="text-capitalize fontmed">Copy Link</h3>
          <div class="mt-2">
            <div class="form-row">
              <div class="form-group col-12 input-group">
                <p>Please click on the copy button to copy link and paste it in a new incognito window otherwise admin will be logged out.</p>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-10 input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-asterisk" style="color: red;font-size: 5px;"></i>
                  </div>
                </div>
                <input type="text" name="" class="form-control" id="login_url">
              </div>
              <div class="form-group col-2 input-group">
                <button class="btn button-st" value="copy" onclick="copyToClipboard()">Copy!</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Copy Link Modal End Here -->
<div class="modal" id="deleteUser">
    <div class="modal-dialog modal-lg modal-dialog-centered parcelpop">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body text-center">
          <h3 class="text-capitalize fontmed">Confirm Delete User</h3>
        <form method="post" action="{{route('delete-customer')}}">
          {{csrf_field()}}
          <input type="hidden" name="customer_id" id="customer_id" value="">
          <div class="mt-2">
            <div class="form-row">
              <div class="form-group col-12 input-group">
                <p>Please Confirm below data which will also be permanently deleted with this user e.g ads,spareparts,chats,invoices and other all user related data.</p>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-10 input-group"> 
                <input type="checkbox" checked name="deleteads" value="deleteads"> Delete All Ads
               </div> 
            </div>
             <div class="form-row">
              <div class="form-group col-10 input-group"> 
                <input type="checkbox" checked name="delete_services" value="delete_services"> Delete All Services
               </div> 
            </div>
             <div class="form-row">
              <div class="form-group col-10 input-group"> 
                <input type="checkbox" checked name="delete_spareparts" value="delete_spareparts"> Delete All Spareparts
               </div> 
            </div>
              <div class="form-row"> 
              <div class="form-group col-2 input-group">
                <button class="btn btn-danger" value="Delete"> Confirm </button>
              </div>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
</div>
<!-- DELETE USER ENDS HERE -->
@push('custom-scripts')
<script type="text/javascript">
  function copyToClipboard() {
        document.getElementById("login_url").select();
        document.execCommand('copy');
    }
    
  $(document).ready(function() {
    var full_path = $('#site_url').val()+'/';
    $('#example1').DataTable();
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
    $(document).on("click",".login-as-user",function(){
      // alert('hi');
      var user_id=$(this).data('userid');
      $.ajax({
        method:"get",
        url:"{{route('create-token-of-user-for-admin-login')}}",
        dataType:"json",
        data:{user_id:user_id},
        beforeSend:function(){
           $('#loader_modal').modal({
                backdrop: 'static',
                keyboard: false
              });
            $("#loader_modal").modal('show');
        },
        success:function(data){
            $("#loader_modal").modal('hide');
            if(data.success == false){
                swal("the selected user is either suspended or inactive");
                swal("User not active", "the selected user is either suspended or inactive", "info")
            }else{
                // alert(data.token_for_admin_login+' User id='+data.user_id);
                var url_for_login=full_path+"user-login-from-admin/"+data.token_for_admin_login+'/'+data.user_id;
                $("#login_url").val(url_for_login);
                $("#copyLinkModal").modal("show");
            }
        },error: function(request, status, error) {
          $("#loader_modal").modal('hide');
          console.log(status);
        }
      });
    });
  }); 

   $('#myTable').DataTable({
       searching: false
   });
   
   @if(Session::has('message'))
     toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
   @endif

   $(function(e){
      $(document).on('click', '.delete-btn', function(){
        var c_id = $(this).data('id');
        $("#customer_id").val(c_id);
        var route = "{{ route('remove','c_id') }}";
        route = route.replace('c_id',c_id);
      });
    });

  $('#company_tab').on('click',function(){
    $('#main').text('');
    $('#main').append('<a target="" href="{{url("admin/active/user")}}">Active</a> / Business Users');
     $('#loader_modal').modal('show');
    window.location.reload();

  });

  $('#individual_tab').on('click',function(){
    $('#loader_modal').modal('show');
    setTimeout(function(){ $('#loader_modal').modal('hide'); }, 1000);
    $('#main').text('');
    $('#main').append('<a href="javascript:void(0)">Active</a> / Individual Users');

  });
</script>
@endpush
@endsection