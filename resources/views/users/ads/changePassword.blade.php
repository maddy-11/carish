@extends('layouts.app')

@section('content')
<div class="internal-page-content mt-4 pb-0 pt-md-5 pt-4 sects-bg">
  <div class="container">
    <div class="row ml-0 mr-0">
      <div class="col-12 bg-white border mb-md-5 mb-4 p-0">
        @include('users.ads.profile_tabes')
      </div>

      <div class="tab-content profile-tab-content">

        <!-- Tab 5 starts here -->
        <div class="tab-pane active" id="profile-tab5">
          <div class="bg-white p-lg-5 p-md-4 p-3 change-password-sect">
            <h2>{{__('dashboardChangePassword.changePassword')}}</h2>
            <form class="mt-lg-5 mt-md-4 mt-3" id="change-password-form">
              {{csrf_field()}}
              <div class="row mx-md-0">
                <div class="col-lg-7 col-md-8 mb-sm-9 form-group">
                  <label style="color:#707070" class="f-size1"><strong>{{__('dashboardChangePassword.changePasswordFor')}}</strong> {{Auth::guard('customer')->user()->customer_email_address}}</label>
                </div>
                <div class="col-lg-7 col-md-8 mb-sm-9 form-group">
                  <div class="input-group border rounded">
                    <div class="input-group-prepend">
                      <span class="input-group-text justify-content-center border-0 bg-white pr-0"><em class="fa fa-key"></em></span>
                    </div>
                    <input type="password" class="form-control form-control-lg border-0" id="old_password" placeholder="{{__('dashboardChangePassword.currentPassword')}}" name="old_password" required="">

                  </div>
                  <span class="text-left d-none" id="old_password_error" role="alert" style="color:red;margin-top:0px;"><strong>{{__('dashboardChangePassword.oldPasswordNoMatch')}}</strong></span>
                </div>
                <div class="col-lg-7 col-md-8 mb-sm-9 form-group">
                  <div class="input-group border rounded">
                    <div class="input-group-prepend">
                      <span class="input-group-text justify-content-center border-0 bg-white pr-0"><em class="fa fa-key"></em></span>
                    </div>
                    <input type="password" class="form-control form-control-lg border-0" name="new_password" id="new_password" placeholder="{{__('dashboardChangePassword.newPassword')}}" required="">
                  </div>
                </div>
                <div class="col-lg-7 col-md-8 mb-sm-9 form-group">
                  <div class="input-group border rounded">
                    <div class="input-group-prepend">
                      <span class="input-group-text justify-content-center border-0 bg-white pr-0"><em class="fa fa-key"></em></span>
                    </div>
                    <input type="password" class="form-control form-control-lg border-0" id="confirm_new_password" placeholder="{{__('dashboardChangePassword.reTypeNewPassword')}}" name="confirm_new_password" required="">
                  </div>
                  <p class="text-left d-none" id="not_matched_error" style="color:red;margin-top:0px;">{{__('dashboardChangePassword.newPasswordNotMatch')}}</p>
                </div>
                <div class="col-md-7 mb-md-0 mt-lg-4 form-group">
                  <input type="submit" name="Submit" value="{{__('dashboardChangePassword.buttonText')}}" id="save-btn" class="btn themebtn1 pt-3 pb-3 pl-5 pr-5">
                </div>
              </div>


            </form>
          </div>
        </div>
        <!-- Tab 5 ends here -->
      </div>

    </div>

    @push('scripts')
    <script type="text/javascript">
      $(document).ready(function() {
        $("#old_password").on("focusout", function() {

          var old_password = $(this).val();
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
          });
          $.ajax({
            url: "{{ route('check-old-password') }}",
            method: 'post',
            dataType: 'json',
            data: {
              old_password: old_password,
              "_token": "{{ csrf_token() }}",
            },

            success: function(result) {

              if (result.error == true) {
                // alert("true");

                $("#old_password_error").removeClass('d-none');
                // $("#save-btn").attr("disabled",true);
              } else {
                // alert("false");

                $("#old_password_error").addClass('d-none');
                // $("#save-btn").removeAttr("disabled",true);

              }


            },
            error: function(request, status, error) {}
          });


        });
        $(document).on('submit', '#change-password-form', function(e) {
          e.preventDefault();

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
          });

          var new_password = $("#new_password").val();
          var confirm_new_password = $("#confirm_new_password").val();

          if (new_password != confirm_new_password) {
            $("#confirm_new_password").addClass('is-invalid');
            $("#not_matched_error").removeClass('d-none');
            return false;
          } else {
            $("#confirm_new_password").removeClass('is-invalid');
            $("#not_matched_error").addClass('d-none');
          }


          $.ajax({
            url: "{{ route('change-password-process') }}",
            method: 'post',
            data: $('#change-password-form').serialize(),
            beforeSend: function() {
              $('#save-btn').val("{{ __('dashboardChangePassword.pleaseWait') }}...");
              $('#save-btn').addClass('disabled');
              $('#save-btn').attr('disabled', true);
            },
            success: function(result) {
              $('#save-btn').val('add');
              $('#save-btn').attr('disabled', true);
              $('#save-btn').removeAttr('disabled');
              if (result.success === true) {

                $('#change-password-form').trigger('reset');
                toastr.success('Success!', 'Password changed successfully', {
                  "positionClass": "toast-bottom-right"
                });
                // window.location.href="{{url('sales/')}}";              
              }


            },
            error: function(request, status, error) {
              $('#save-btn').val('add');
              $('#save-btn').removeClass('disabled');
              $('#save-btn').removeAttr('disabled');
              $('.form-control').removeClass('is-invalid');
              $('.form-control').next().remove();
              json = $.parseJSON(request.responseText);
              $.each(json.errors, function(key, value) {
                $('input[name="' + key + '"]').after('<span class="invalid-feedback" role="alert"><strong>' + value + '</strong>');
                $('input[name="' + key + '"]').addClass('is-invalid');
              });
            }
          });
        });
      });
    </script>
    @endpush


    @endsection