@extends('layouts.app')
@section('title') {{ __('header.edit_profile') }} @endsection
@section('content')
@push('styles')
<style type="text/css">
  label.error {
    color: red;
    font-size: 16px;
    font-weight: normal;
    line-height: 1.4;
    width: 100%;
    float: none;
  }

  @media screen and (orientation: portrait) {
    label.error {
      margin-left: 0;
      display: block;
    }
  }

  @media screen and (orientation: landscape) {
    label.error {
      display: inline-block;
    }
  }

  input.error {
    background-color: #efa1a4 !important;
  }

  select.error {
    background-color: #efa1a4 !important;
  }

  textarea.error {
    background-color: #efa1a4 !important;
  }
  /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
@endpush
<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
  <div class="container">
    <form class="add-profile-form" action="" method="POST" id="myForm">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="customer_role" value="individual">
      <input type="hidden" id="current_contact" name="current_contact" value="{{$customer->customers_telephone}}">
      <input type="hidden" id="contact_verified" name="contact_verified" value="false">
      
      <div class="row ml-0 mr-0">
        <div class="col-9 mx-auto bg-white border p-sm-4 p-3 pb-md-5 mb-md-5 mb-4">
          <div class="backto-dashboard text-right mb-md-3 mb-2">
            <a target="" href="{{url('user/my-ads')}}" class="font-weight-semibold themecolor"><em class="fa fa-chevron-circle-left"></em> {{__('profile.back_to_dashboard')}}</a>
          </div>
          <h3 class="">{{__('profile.my_profile')}}</h3>
          <div class="col-xl-5 col-lg-6 col-md-6 ml-auto mr-auto pl-0 pr-0 mt-md-4 mt-3">
            <div class="row align-items-end">
              <div class="col-lg-4 col-sm-4 col-4 user-profile-img">
                <!-- <img src="assets/img/user-profile-Img.jpg" class="img-fluid" alt="profile image"> -->
                <!-- //start -->
                @if($customer->logo != Null)
                <img src="{{asset('public/uploads/customers/logos/'.$customer->logo)}}" alt="carish used cars for sale in estonia" class="profile-image">
                @else
                <img src="{{asset('public/uploads/image/profileImg.jpg')}}" alt="Avatar" class="profile-image">
                @endif
                <!-- ends -->
              </div>
              <div class="col-lg-8 col-sm-8 col-8 pl-0 pl-sm-3">
                <input type="file" class="form-control-file" id="logo" name="logo" accept="image/*">
                <p class="m-0" style="color: #999;">({{__('common.maxlimit_5_mb_per_image')}})</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-9 mx-auto bg-white border p-sm-4 p-3 py-lg-5 py-4">
          <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
            <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
              <label class="mb-0 text-capitalize">{{__('profile.full_name')}}<sup class="text-danger">*</sup></label>
            </div>
            <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
              <input type="text" class="form-control" placeholder="{{__('profile.full_name')}}" id="customer_firstname" name="customer_firstname" value="{{@$customer->customer_company!=null?$customer->customer_company:''}}" required>
              @if ($errors->has('customer_firstname'))
              <span class="help-block">
                <strong>{{ $errors->first('customer_firstname') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <!-- City -->
          <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
            <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
              <label class="mb-0 text-capitalize">{{__('common.city')}}<sup class="text-danger">*</sup></label>
            </div>
            <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
              <select class="form-control" id="city" name="city">
                <option value="">{{__('common.select_city')}}</option>
                @foreach($cities as $city)
                <option value="{{$city->id}}" {{ ($customer->citiy_id == $city->id)? "selected='true'":" " }}>{{$city->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <!-- Phone -->
          <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
            <div class="col-4 mb-1 mb-sm-0 text-sm-right">
              <label class="mb-0 text-capitalize">{{__('profile.phone')}}#<sup class="text-danger">*</sup></label>
            </div>
            <div class="col-2">
              <input type="text" class="form-control border-0" value="+372" disabled>
            </div>
            <div class="col-3">
              <!--  <input type="number" class="form-control" id="mob-number" placeholder="Enter Mobile Number" name="mob" value="{{@$customer->customers_telephone!=null?$customer->customers_telephone:''}}"> -->  
              <input type="number" class="form-control phone-number individual-contact" placeholder="88888888" id="customer_contact" name="customer_contact" value="{{@$customer->customers_telephone!=null?$customer->customers_telephone:''}}" title="Phone number must contain only numbers" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==8) return false;">
            </div>
            <div class="col-2">
              <input type="button" class="btn rounded-0 btn-block" id="contact-verify" value="{{__('common.verify')}}" style="padding:.6rem 0rem;" disabled>
            </div>
          </div>
          <!-- Preferred language -->
          <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
            <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
              <label class="mb-0 text-capitalize">{{__('profile.prefered_language')}}<sup class="text-danger">*</sup></label>
            </div>
            <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
              <select class="form-control" name="prefered_language">
                <option value="2" {{ ($customer->language_id == '2')? "selected='true'":" " }}>English</option>
                <option value="1" {{ ($customer->language_id == '1')? "selected='true'":" " }}>Estonian</option>
                <option value="3" {{ ($customer->language_id == '3')? "selected='true'":" " }}>Russian</option>
              </select>
            </div>
          </div>
          <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
            <div class="col-md-6 col-xl-5 col-lg-5 offset-lg-2 offset-sm-3 col-sm-7">
              <input type="submit" class="btn save-btn pl-4 post-ad-submit pr-4  pl-lg-5 pr-lg-5 pt-lg-3 pb-lg-3  themebtn1" value="{{__('profile.save_changes')}}">
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- SMS Verification Modal Start -->
<div class="modal" id="SmsVerificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content sms-alert-content">
            <div class="modal-header sms-alert-header">
                <h4 class="modal-title sms-alert-title" id="exampleModalLabel">Enter the Verification code you received on your phone number <span id="display-number"></span></h4>
                <button type="button" id="sms_model_close" class="close" data-dismiss="modal" aria-label="Close" style="color: red;opacity: 1;" >
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
              <div class="sms-alert-icon">
                <img src="{{ asset('public/images/sms.png') }}" alt="SMS Icon" />
              </div>

            <form method="post" name="sms_verify_form" id="sms_verify_form" action="{{route('verify-contact-process')}}" target="_blank">
                @csrf
                <input type="hidden" name="invoice_number" class="invoice_number">
                <div class="modal-body sms-modal-body">
                    <div class="row">
                        <div class="d-flex flex-row mt-10 sms-inputs-container">
                          <div><input type="number" class="sms-inputs" name="code_1" autofocus pattern="\d*" onKeyPress="if(this.value.length==1) return false;"></div>
                          <div><input type="number" class="sms-inputs" name="code_2" pattern="\d*" onKeyPress="if(this.value.length==1) return false;"></div>
                          <div><input type="number" class="sms-inputs" name="code_3" pattern="\d*" onKeyPress="if(this.value.length==1) return false;"></div>
                          <div><input type="number" class="sms-inputs" name="code_4" pattern="\d*" onKeyPress="if(this.value.length==1) return false;"></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="d-flex flex-row mt-10 sms-inputs-container" style="width:auto;">
                          <div id="countdown"></div>
                        </div>
                    </div>
                    <div class="modal-footer" style="justify-content: center;border-top: none;">
                        <button type="button" class="btn themebtn3" id="verify_sms">{{__('common.verify')}}</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>
<!-- SMS Verification Modal Start --> 
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<!--<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script> -->
<script>
  /* MUTAHIR SCRIPT FOR MAKE MODEL VERSION */ 
$(document).ready(function(){
  $(document).on('submit', '.add-profile-form', function(e){
      e.preventDefault();
      var current_contact = $('#current_contact').val();
      var individual_contact = $('.individual-contact').val();
      if(current_contact == individual_contact)
      {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('update-profile') }}",
        method: 'post',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          $('.save-btn').val("{{ __('common.please_wait') }}...");
          $('.save-btn').addClass('disabled');
          $('.save-btn').attr('disabled', true);
        },
        success: function(data) {
          $('.save-btn').attr('disabled', true);
          $('.save-btn').removeAttr('disabled');
          if (data.error == false) {
            toastr.success('Success!', 'Profile updated successfully', {
              "positionClass": "toast-bottom-right"
            });
            location.reload();
          }
        },
        error: function(request, status, error) {
          $('.save-btn').removeClass('disabled');
          $('.save-btn').removeAttr('disabled');
          $('.form-control').removeClass('is-invalid');
          $('.form-control').next().remove();
          json = $.parseJSON(request.responseText);
          $.each(json.errors, function(key, value) {
            $('input[name="' + key + '"]').after('<span class="invalid-feedback" role="alert"><strong>' + value + '</strong>');
            $('input[name="' + key + '"]').addClass('is-invalid');
          });
        }
      });
      }
      else{
        $('.save-btn').addClass('disabled');
        $('.save-btn').attr('disabled', true);
        Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please Verify Contact Number First!!.'
        });
        return false;
      }
    });
  $("#myForm").validate({
    rules: {
      customer_firstname: {
        required: true
      },
      customer_lastname: {
        required: true
      },
      gender: {
        required: true
      },
      dob: {
        required: true
      },
      country: {
        required: true
      },
      city: {
        required: true
      },
      customer_contact: {
        required: true
      },
      prefered_language: {
        required: true
      },
      logo: {
        extension: "jpg|gif|png|bmp|jpeg"
      }
    },
    messages: {
      customer_firstname: "{{__('common.please_enter_firstname')}}",
      customer_lastname: "{{__('common.please_enter_lastname')}}",
      gender: "{{__('common.please_select_gender')}}",
      dob: "{{__('common.please_enter_date_of_birth')}}",
      country: "{{__('common.please_select_country')}}",
      city: "{{__('common.please_select_city')}}",
      customer_contact: "{{__('common.please_enter_phone_number')}}",
      prefered_language: "{{__('common.please_select_preferred_language')}}",
      logo: "{{__('common.only_jpg_gif_png_bmp_jpeg_extensions_are_allowed')}}"
    }
  });
  $('#SmsVerificationModal').on('hidden.bs.modal', function () {

  });
  $(".individual-contact").keypress(function(){
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });

  $(".individual-contact").keyup(function(e){
    var dInput = this.value;
    var current_contact = $('#current_contact').val();
    if(current_contact == dInput)
    {
      $('#contact-verify').prop("disabled", true);
    }else{
      $('#contact-verify').prop("disabled", false);
    }
  });

  $(document).on('click', '#contact-verify', function() { 
    
    $("#SmsVerificationModal").modal('hide');
    $("input[name=code_1]").val('');
    $("input[name=code_2]").val('');
    $("input[name=code_3]").val('');
    $("input[name=code_4]").val('');
    $('#display-number').html('');
    $('#countdown').html('');
    $("#sms_model_close").css("display", "none");
    $('#sms_model_close').prop("disabled", true);
    
    $('.modal-footer').html('<button type="button" class="btn themebtn3" id="verify_sms">{{__('common.verify')}}</button>');
    var customer_contact = $(".individual-contact").val();
    if(customer_contact == '' || customer_contact.length < 8)
    {
      Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Contact Number Cannot be Empty or Less then 8 digit.'
      });
      return false;
    }
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      url: "{{ route('contact-verify') }}",
      type: 'post',
      dataType: "json",
      data:
      {
        customer_contact:customer_contact
      },
      beforeSend: function() {},
      success: function(data) {
        $('#display-number').html('+372'+customer_contact);
        $("#SmsVerificationModal").modal('show'); 
        $("input[name=code_1]").focus();
        var timeleft = 60;
        var downloadTimer = setInterval(function(){
        if(timeleft <= 0){
          $.ajax({
            url: "{{ route('expire-contact-process') }}",
            type: 'post',
            dataType: "json",
            data:
            {
              customer_contact:customer_contact
            },
            success: function(data) {
              if(data['status']=='success')
                {
                  clearInterval(downloadTimer);
                  $('#countdown').html("SMS Expire. Kindly Resend!!");
                  $('.modal-footer').html('<input type="button" class="btn themebtn3" id="contact-verify" value="{{__('common.resend')}}">');
                  $("#sms_model_close").css("display", "block");
                  $('#sms_model_close').prop("disabled", false);
                  
                }    
            }
          }).fail(function(jqXHR, textStatus, errorThrown) {

      if (jqXHR.status === 422) {
        var errors = $.parseJSON(jqXHR.responseText);
        printErrorMsg(errors);
      }
    });
        } else {
          $('#countdown').html(timeleft + " seconds remaining");
        }
          timeleft -= 1;
        }, 1000);    
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      $("#overlay").fadeOut(100);
      if (jqXHR.status === 422) {
        var errors = $.parseJSON(jqXHR.responseText);
        printErrorMsg(errors);
      }
    });
  });
  $(document).on('click', '#verify_sms', function() { 
    var customer_contact = $(".individual-contact").val();
    var code1 = $("input[name=code_1]").val();
    var code2 = $("input[name=code_2]").val();
    var code3 = $("input[name=code_3]").val();
    var code4 = $("input[name=code_4]").val();
    var sms_code  = code1+code2+code3+code4;
    if(sms_code == '')
    {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Code Cannot be Empty'
      });
      return false;
    }
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      url: "{{ route('verify-contact-process') }}",
      type: 'post',
      dataType: "json",
      data:
      {
        customer_contact:customer_contact,
        sms_code:sms_code
      },
      beforeSend: function() {
        //$("#SmsVerificationModal").modal('hide');
        Swal.showLoading();
      },
      success: function(data) {
        if(data['status']=='success')
          {

            $("#current_contact").val(customer_contact);
            $("#SmsVerificationModal").modal('hide');
            Swal.hideLoading();
            $('#contact-verify').prop("disabled", true);
            $('.save-btn').removeClass('disabled');
            $('.save-btn').removeAttr('disabled');
            Swal.fire(
              'Contact Number Verified!',
              )
          }else{
            Swal.hideLoading();
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Wrong Code!'
            })
          }     
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      $("#overlay").fadeOut(100);
      if (jqXHR.status === 422) {
        var errors = $.parseJSON(jqXHR.responseText);
        printErrorMsg(errors);
      }
    });
  });
  $(".individual-contact").keydown(function(e){
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
  $('input[name=code_1]').keyup(function(e){
    var key = e.charCode || e.keyCode || 0;
    if((key >= 35 && key <= 40) || (key >= 48 && key <= 57))
    {
        $("input[name=code_2]").focus();
    }
  });
  $('input[name=code_2]').keyup(function(e){
    var key = e.charCode || e.keyCode || 0;
    if((key >= 35 && key <= 40) || (key >= 48 && key <= 57))
    {
        $("input[name=code_3]").focus();
    }

    if ((e.keyCode ? e.keyCode : e.which) == 8) {
        setTimeout(function() {flag=false}, 1000);
        if (flag1) {
            flag1=false;
            $("input[name=code_1]").focus();
        }
        flag1=true;
    }else{
        flag1=false;
    }

  });
  $('input[name=code_3]').keyup(function(e){
    var key = e.charCode || e.keyCode || 0;
    if((key >= 35 && key <= 40) || (key >= 48 && key <= 57))
    {
        $("input[name=code_4]").focus();
    }

    if ((e.keyCode ? e.keyCode : e.which) == 8) {
        setTimeout(function() {flag=false}, 1000);
        if (flag2) {
            flag2=false;
            $("input[name=code_2]").focus();
        }
        flag2=true;
    }else{
        flag2=false;
    }

  });
  $('input[name=code_4]').keyup(function(e){
    var key = e.charCode || e.keyCode || 0;
    if((key >= 35 && key <= 40) || (key >= 48 && key <= 57))
    {
       $("#verify_sms").click();
    }

    if ((e.keyCode ? e.keyCode : e.which) == 8) {
        setTimeout(function() {flag=false}, 1000);
        if (flag3) {
            flag3=false;
            $("input[name=code_3]").focus();
        }
        flag3=true;
    }else{
        flag3=false;
    }

  });
});
</script>
@endpush
@endsection