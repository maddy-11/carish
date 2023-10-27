@extends('admin.layouts.app')

@section('content')

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Profile</a></h3>
  </div>
</div>

<div class="row">
  <div class="col-3"></div>
  <div class="col-lg-6 col-6 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Profile</h5>
      </div>
      <div>
          <form id="change-profile-form" enctype="multipart/form-data">
                 {{csrf_field()}}
                 <input type="hidden" class="form-control" id="email" name="email" value="{{@$user->email}}">
          <div class="form-group">
            <label for="fname">Full Name:</label>
            <input type="text" class="form-control" id="fname" name="name" value="{{@$user->name}}">
          </div>
          @if($user->role_id == 1)
           <div class="form-group">
            <label for="pwd">Role Type:</label>
            <select class="form-control" name="role" required>
              <option class="active">Select Role</option>
              @foreach($roles as $role)
              <option value="{{@$role->id}}" {{@$user->role_id == @$role->id ? 'selected' : ''}}>{{@$role->name}}</option>
              @endforeach
            </select>
          </div>
          @else
           <input type="hidden" name="role" value="{{@$user->role_id}}">
          @endif

           <div class="custom-file mb-5">
                        <label class="d-block text-left">Old Password <strong>*</strong></label>
                        <input type="password" class="font-weight-bold form-control-lg form-control" id="old_password" name="old_password">
                        <span class="text-left d-none" id="old_password_error" role="alert" style="color:red;margin-top:-15px;"><strong>Old password not matched.</strong></span>
                      </div>

                      
                      <div class="custom-file mb-5">
                        <label class="d-block text-left">New Password <strong>*</strong></label>
                        <input type="password" class="font-weight-bold form-control-lg form-control" id="new_password" name="new_password">
                      </div>
                      
                      <div class="custom-file mb-5">
                        <label class="d-block text-left">Confirm New Password <strong>*</strong></label>
                        <input type="password" class="font-weight-bold form-control-lg form-control" id="confirm_new_password" name="confirm_new_password">
                      </div>
                      <p class="text-left d-none" id="not_matched_error" style="color:red;margin-top:0px;">Password and confirm password not matched.</p>
                      <p class="text-left d-none" id="length_error" style="color:red;margin-top:0px;">Password must be atleast 6 characters long.</p>

         
          <button type="submit" class="btn btn-primary mt-2">Update</button>
        </form>
      </div>
   </div>
  </div>

</div>
    @push('custom-scripts')
    <script>
        $('#UserAds').DataTable();

        $("#old_password").on("focusout",function(){

    var old_password = $(this).val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
     $.ajax({
        url: "{{ route('check-admin-old-password') }}",
        method: 'post',
        dataType:'json',
        data:{old_password:old_password,"_token": "{{ csrf_token() }}"},
        
        success: function(result){
        
          if(result.error == true)
          {
            // alert("true");

            $("#old_password_error").removeClass('d-none');
            $("#save-btn").attr("disabled",true);
          }
          else
          {
            // alert("false");

            $("#old_password_error").addClass('d-none');
            $("#save-btn").removeAttr("disabled",true);

          }
          
          
        },
        error: function (request, status, error) {
        }
      });


  });

        $(document).on('submit', '#change-profile-form', function(e){
       e.preventDefault();
       
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
           }
       });

       var new_password= $("#new_password").val();
       var confirm_new_password= $("#confirm_new_password").val();
       var new_password_length = new_password.length;
       var confirm_new_password_length = new_password.length;

       if(new_password != confirm_new_password)
       {
        $("#confirm_new_password").addClass('is-invalid');
        $("#not_matched_error").removeClass('d-none');
        return false;
       }
       if(new_password_length < 6){
        $("#confirm_new_password").addClass('is-invalid');
        $("#length_error").removeClass('d-none');
        return false;
       }
       else
       {
        $("#confirm_new_password").removeClass('is-invalid');
        $("#not_matched_error").addClass('d-none');
       }


        $.ajax({
           url: "{{ route('change-admin-profile') }}",
           method: 'post',
           data: $('#change-profile-form').serialize(),
           beforeSend: function(){
             $('#save-btn').val('Please wait...');
             $('#save-btn').addClass('disabled');
             $('#save-btn').attr('disabled', true);
           },
           success: function(result){
             if(result.success === true){
              
              $('#change-profile-form').trigger('reset');
              toastr.success('Success!', 'Profile Updated successfully',{"positionClass": "toast-bottom-right"});
              window.location.href="{{url('admin/dashboard')}}";              
             }
             
             
           },
           error: function (request, status, error) {
                 $('#save-btn').val('add');
                 $('#save-btn').removeClass('disabled');
                 $('#save-btn').removeAttr('disabled');
                 $('.form-control').removeClass('is-invalid');
                 $('.form-control').next().remove();
                 json = $.parseJSON(request.responseText);
                 $.each(json.errors, function(key, value){
                     $('input[name="'+key+'"]').after('<span class="invalid-feedback" role="alert"><strong>'+value+'</strong>');
                      $('input[name="'+key+'"]').addClass('is-invalid');
                 });
             }
         });
     });

    </script>
    @endpush

@endsection