@extends('layouts.app')
@section('title') {{ __('signUp.pageTitle') }} @endsection
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

.new_icon{
      /*width: 4rem;*/
    color: rgba(0, 0, 0, 0.5);
    font-size: 1.25rem;
    position:relative;
    top: calc(50% - 10px); 
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
@push('scripts')
@endpush
@section('content')
<!-- Begin page -->
<div class="internal-page-content mt-4 pt-5 sects-bg">
<div class="container pt-2">
  @include('messeges.notifications')
  <div class="row">
    <div class="col-lg-6 mx-auto col-12 sign-in-col sign-up-col">
      <div class="signInbg box-shadow bg-white p-md-5 p-sm-4 p-3 pt-4 rounded">
        <h1 class="mb-4 pb-md-2  themecolor">{{ __('signUp.signUpToCarish') }}</h1>
        <!-- Nav tabs -->
        <ul class="mx-md-n5 mx-sm-n4 mx-n3 nav nav-tabs sign-up-tabs nav-justified  mb-5">
          <li class="nav-item">
            @if(session::has('msg'))
            <a class="font-weight-semibold nav-link rounded-0" data-toggle="tab" href="#Individual">{{ __('signUp.individualUser') }}</a>
            @else
            <a class="font-weight-semibold nav-link rounded-0 active" data-toggle="tab" href="#Individual">{{ __('signUp.individualUser') }}</a> 
            @endif
          </li>
          <li class="nav-item">
            @if(session::has('msg'))
            <a class="font-weight-semibold nav-link rounded-0 active" data-toggle="tab" href="#company">{{ __('signUp.businessUser') }}</a>
            @else
            <a class="font-weight-semibold nav-link rounded-0" data-toggle="tab" href="#company">{{ __('signUp.businessUser') }}</a> 
            @endif
          </li>
        </ul>
        <!-- Tab panes -->
        @if ($errors->has('customer_role'))
        <span class="help-block"><strong>{{ $errors->first('customer_role') }}</strong></span>
        @endif
        <div class="tab-content signup-form">
        @if(session::has('msg'))
        <div class="tab-pane" id="Individual">
          @else
          <div class="tab-pane active" id="Individual">  
          @endif
          <form class="" action="" method="POST" id="myForm">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="customer_role" value="individual">
              {{-- First Name | Last Name --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="max-height: 46.5px;">
                    <em class="fa fa-user text-center new_icon" title="{{__('signUp.fullName')}}"></em>                
                  </div>
                  <div class="col-11">
                    <input type="text" class="form-control border-0 mr-3" placeholder="{{__('signUp.fullName')}}" id="customer_firstname" name="full_name" value="" pattern="[a-zA-Z]+" title="Full Name must contain only alphabets and spaces" required>
                      @if ($errors->has('customer_firstname'))
                      <span class="help-block">
                      <strong>{{ $errors->first('customer_firstname') }}</strong>
                      </span>
                      @endif
                  </div>
                </div>
              </div>
              {{-- Email --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="max-height: 46.5px;">
                     <em class="fa fa-envelope text-center new_icon" title="{{__('signUp.email')}}"></em>
                  </div>
                  <div class="col-11">
                    <input class="form-control border-0" type="email" id="customer_email_address" placeholder="{{__('signUp.email')}}"  name="customer_email_address" value="{{ old('customer_email_address') }}" required="true">
                    @if ($errors->has('customer_email_address'))
                    <span class="help-block">
                    <strong>{{ $errors->first('customer_email_address') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
              {{-- Contact --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="max-height: 46.5px;">
                     <em class="fa fa-phone text-center new_icon" title="Phone Number"></em>
                  </div>
                  <div class="col-2">
                    <input type="text" class="form-control border-0" value="+372" disabled>
                  </div>
                    <div class="col-5">
                      <input type="number" class="form-control border-0 phone-number individual-contact" placeholder="5366***8" id="customer_contact" name="customer_contact" value="{{ old('customer_contact') }}" title="Phone number must contain only numbers" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==8) return false;">
                      @if ($errors->has('customer_contact'))
                      <span class="help-block">
                      <strong>{{ $errors->first('customer_contact') }}</strong>
                      </span>
                      @endif
                  </div>

                  <div class="col-4">
                    <input type="button" class="btn rounded-0 btn-block" id="contact-verify" value="{{__('signUp.verify')}}">
                  </div>

                </div>
              </div>
              {{-- Password --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="max-height: 46.5px;">
                    <em class="fa fa-key text-center new_icon" title="{{__('signUp.password')}}"></em>
                  </div>
                  <div class="col-11">
                    <input class="form-control border-0" type="password" required="" id="customer_password" placeholder="{{__('signUp.password')}}" value="{{ old('customer_password') }}"  name="customer_password" pattern=".{8,16}" title="Password must be atleast 8 characters long">

                        @if ($errors->has('customer_password'))
                        <span class="help-block">
                        <strong>{{ $errors->first('customer_password') }}</strong>
                        </span>
                        @endif
                  </div>
                </div>
              </div>
              {{-- Confirm Password --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="max-height: 46.5px;">
                    <em class="fa fa-key text-center new_icon" title="{{__('signUp.confirmPassword')}}"></em>
                  </div>
                  <div class="col-11">
                     <input class="form-control border-0" type="password" id="password_confirmation" placeholder="{{__('signUp.confirmPassword')}}" value="{{ old('password_confirmation') }}"  name="password_confirmation">

                      @if ($errors->has('password_confirmation'))
                      <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{ $errors->first('password_confirmation') }}</li></ul>
                      @endif
                  </div>
                </div>
              </div>
              {{-- City --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1">
                    <em class="fa fa-globe text-center new_icon" title="{{__('signUp.city')}}"></em>
                  </div>
                  <div class="col-11">
                     <select class="form-control" name="city_id">
                 @foreach(@$cities as $city)
                  <option value="{{@$city->id}}">{{$city->name}}</option>
                  @endforeach
              </select>
                  </div>
                </div>
              </div>
              {{-- Prefered Language --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1">
                    <em class="fa fa-globe text-center new_icon" title="Prefered Language"></em>
                  </div>
                  <div class="col-11">
                    <select class="form-control selectpicker select-cont"   name="prefered_language"> 
                      <option data-content='<span class="flag-icon flag-icon-ee"></span> Eesti keel' value="1">Eesti keel </option>
                      <option data-content='<span class="flag-icon flag-icon-us"></span> English' value="2">English</option>
                      <option  data-content='<span class="flag-icon flag-icon-ru"></span> русский язык' value="3">русский язык</option>
                    </select> 
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-1"></div>
                <div class="col-11">
                   <input type="submit" class="btn rounded-0 btn-block themebtn1 signIn-btn individual" disabled value="{{__('signUp.buttonText')}}">
                </div>
              </div> 
              <div class="connect-with-other">
              <p class="font-weight-semibold signup-note mb-2">{{__('signUp.acknowledgement')}}</p>
              <a target="" href="{{ route('terms-of-service') }}" class="themecolor">{{__('signUp.termsOfUse')}}</a>
            </div>   
          </form>
          </div>
          @if(session::has('msg'))
          <div class="tab-pane active" id="company">
          @else
          <div class="tab-pane" id="company">  
          @endif
            <form class="" action="" method="POST" id="myForm2">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="customer_role" value="business">
              {{-- Company Name --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="max-height: 46.5px;">
                     <em class="fa fa-user text-center new_icon" title="{{__('signUp.nameBusiess')}}"></em>
                  </div>
                  <div class="col-11">
                     <input class="form-control border-0" type="text" id="customer_company"  placeholder="{{__('signUp.nameBusiness')}}"  name="customer_company" value="{{ old('customer_company') }}">
                      @if ($errors->has('customer_company'))
                      <span class="help-block">
                      <strong>{{ $errors->first('customer_company') }}</strong>
                      </span>
                      @endif
                  </div>
                </div>
              </div>
              {{-- Address --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="max-height: 46.5px;">
                    <em class="fa fa-map-marker text-center new_icon" title="{{__('signUp.addressBusiess')}}"></em>
                  </div>
                  <div class="col-11">
                     <input class="form-control border-0" type="text" id="customer_address"  placeholder="{{__('signUp.addressBusiness')}}"  name="customer_address" value="{{ old('customer_address') }}">
                      @if ($errors->has('customer_address'))
                      <span class="help-block">
                      <strong>{{ $errors->first('customer_address') }}</strong>
                      </span>
                      @endif
                  </div>
                </div>
              </div>
              {{-- Registration Number --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="max-height: 46.5px;">
                    <em class="fa fa-registered text-center new_icon" title="{{__('signUp.registrationBusiess')}}"></em>
                  </div>
                  <div class="col-11">
                    <input class="form-control border-0" type="number" id="customer_registration"  placeholder="{{__('signUp.registrationBusiess')}}"  name="customer_registration" value="{{ old('customer_registration') }}" pattern=".{8,}" title="{{__('signUp.registrationBusiness')}}">
                    @if ($errors->has('customer_registration'))
                    <span class="help-block">
                    <strong>{{ $errors->first('customer_registration') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
              {{-- VAT Number --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="max-height: 46.5px;">
                     <em class="fa fa-file-text text-center new_icon" title="{{__('signUp.vatBusiess')}}"></em>
                  </div>
                  <div class="col-11">
                    <input class="form-control border-0" type="text" id="customer_vat"  placeholder="{{__('signUp.vatBusiess')}}"  name="customer_vat" value="{{ old('customer_vat') }}" pattern="[A-za-z]{2}[0-9]{9}" title="{{__('signUp.vatBusniessNull')}}">
                    @if ($errors->has('customer_vat'))
                    <span class="help-block">
                    <strong>{{ $errors->first('customer_vat') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
              {{-- Email --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="max-height: 46.5px;">
                    <em class="fa fa-envelope text-center new_icon" title="{{__('signUp.email')}}"></em>
                  </div>
                  <div class="col-11">
                    <input class="form-control border-0" type="email" id="customer_email_address" placeholder="{{__('signUp.email')}}"  name="customer_email_address" value="{{ old('customer_email_address') }}" required="true">
                    @if ($errors->has('customer_email_address'))
                    <span class="help-block">
                    <strong>{{ $errors->first('customer_email_address') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
              {{-- Contact --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="max-height: 46.5px;">
                   <em class="fa fa-phone text-center new_icon" title="{{__('signUp.phone_number')}}"></em>
                  </div>
                  <div class="col-11">
                     <input type="number" class="form-control border-0 phone-number" placeholder="5943188" id="customer_contact" name="customer_contact" value="{{ old('customer_contact') }}" pattern="[0-9]+" title="{{__('signUp.phoneNumberNull')}}">
                      @if ($errors->has('customer_contact'))
                      <span class="help-block">
                      <strong>{{ $errors->first('customer_contact') }}</strong>
                      </span>
                      @endif
                  </div>
                </div>
              </div>
              {{-- Password --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="max-height: 46.5px;">
                    <em class="fa fa-key text-center new_icon" title="{{__('signUp.password')}}"></em>
                  </div>
                  <div class="col-11">
                    <input class="form-control border-0" type="password" required="" id="customer_password" placeholder="{{__('signUp.password')}}" value="{{ old('customer_password') }}"  name="customer_password" pattern=".{8,16}" title="{{__('signUp.passwordNull')}}">

                    @if ($errors->has('customer_password'))
                    <span class="help-block">
                    <strong>{{ $errors->first('customer_password') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
              {{-- Confirm Password --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="min-height: 46.5px;">
                    <em class="fa fa-key text-center new_icon" title="{{__('signUp.confirmPassword')}}"></em>
                  </div>
                  <div class="col-11">
                    <input class="form-control border-0" type="password" id="password_confirmation" placeholder="{{__('signUp.confirmPassword')}}" value="{{ old('password_confirmation') }}"  name="password_confirmation">

                    @if ($errors->has('password_confirmation'))
                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{ $errors->first('password_confirmation') }}</li></ul>
                    @endif
                  </div>
                </div>
              </div>
              {{-- City --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1">
                    <em class="fa fa-globe text-center new_icon" title="{{__('signUp.city')}}"></em>
                  </div>
                  <div class="col-11">
                     <select class="form-control" name="city_id">
                 @foreach(@$cities as $city)
                  <option value="{{@$city->id}}">{{$city->name}}</option>
                  @endforeach
              </select>
                  </div>
                </div>
              </div>
              {{-- Prefered Language --}}
              <div class="form-group mb-4 align-items-center">
                <div class="row">
                  <div class="col-1" style="min-height: 46.5px;">
                    <em class="fa fa-globe text-center new_icon" title="Prefered Language"></em>
                  </div>
                  <div class="col-11">
                     <select class="form-control selectpicker select-cont" name="prefered_language">
                        <option data-content='<span class="flag-icon flag-icon-ee"></span> Eesti keel' value="1">Eesti keel </option>
                        <option data-content='<span class="flag-icon flag-icon-us"></span> English' value="2">English</option>
                        <option  data-content='<span class="flag-icon flag-icon-ru"></span> русский язык' value="3">русский язык</option>
                      </select> 
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-1"></div>
                <div class="col-11">
                  <input type="submit" class="btn rounded-0 btn-block themebtn1 signIn-btn" value="{{__('signUp.buttonText')}}">
                </div>
              </div>
              <div class="connect-with-other">
                <p class="font-weight-semibold signup-note mb-2">{{__('signUp.acknowledgement')}}</p>
                <a target="" href="{{ route('terms-of-service') }}" class="themecolor">{{__('signUp.termsOfUse')}}</a>
              </div>   
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- SMS Verification Modal Start -->
<div class="modal" id="SmsVerificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content sms-alert-content">
            <div class="modal-header sms-alert-header">
                <h4 class="modal-title sms-alert-title" id="exampleModalLabel">{{__('signUp.smsPopUpTitle')}}<span id="display-number"></span></h4>
                <button type="button" id="sms_model_close" class="close" data-dismiss="modal" aria-label="Close">
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
                        <button type="button" class="btn themebtn3" id="verify_sms">{{__('signUp.verify')}}</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>
<!-- SMS Verification Modal Start -->    
<!-- export pdf form ends -->
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(document).on("click","#ads_first_text",function(){
    var e=$(".individual-contact").val();
    $.ajax({
      url:get_ads_compared,
      method:"get",
      data:{
        excludedAd:e
      },
      success:function(e){
        var a="";
        "string"!=typeof e?($.each(e,function(e,t){
          a+='<div class="align-items-center media mb-3"><img class="mr-3 saved-adImg" src="'+t.image+'" alt="Generic placeholder image"><div class="media-body"><h5 class="mb-0"> <a href="JavaScript:void(0);" class="themecolor select-for-compare1" data-value="'+t.ads_id+'" data-text="'+t.make_name+" "+t.model_name+" "+t.from_date+"-"+t.to_date+" "+t.version_label+" CC "+t.engine_power+' KW">'+t.make_name+" "+t.model_name+" "+t.from_date+"-"+t.to_date+" "+t.version_label+" CC "+t.engine_power+" KW</a></h5></div></div>"
          }),
          $(".saved-cars1").html(a)):$(".saved-cars1").html(e)
      },
      beforeSend:function(){
          $(".saved-cars1").html("loading data ..."),
          $("#savedCarAd").modal("show")
        }
      })
  });

  $("#myForm").validate({
  rules: {
  customer_firstname:{
  required:true
  },
  customer_lastname:{
  required: true
  },
  customer_email_address:{
  required: true
  },
  customer_contact:{
  required: true
  },
  customer_password:{
  required:true
  },
  password_confirmation: {
  required: true
  },


  },
  messages: {
  customer_firstname: "{{__('signUp.pleaseEnterFirstname')}}",
  customer_lastname: "{{__('signUp.pleaseEnterLastname')}}",
  customer_email_address: "{{__('signUp.emailNull')}}",
  customer_contact: "{{__('signUp.phoneNumberNull')}}",
  customer_password: "{{__('signUp.passwordNull')}}",
  password_confirmation: "{{__('signUp.reEnterPasswordNull')}}",
  customer_company: "{{__('signUp.nameBusiness')}}",
  customer_address: "{{__('signUp.addressBusiness')}}"
  }
  }); 

  $.validator.addMethod("valValidate", function(value, element) {
  var letters = /^[A-Za-z]{2}[0-9]{9}$/;  
  return this.optional(element) || letters.test(value);
  },
  "{{__('signUp.vatBusniessNull')}}");

  $("#myForm2").validate({
  rules: {
  customer_vat : { required:false,valValidate : true },
  customer_company: {
  required: true
  },
  customer_address:{
  required:true
  },
  customer_registration:{
  required:true,
  rangelength:[8,8]
  },
  engine_power:{
  required:true
  },
  customer_contact:{
  required: true
  },
  },
  messages: {
  customer_email_address: "{{__('signUp.emailNull')}}",
  customer_contact: "{{__('signUp.phoneNumberNull')}}",
  customer_password: "{{__('signUp.passwordNull')}}",
  password_confirmation: "{{__('signUp.reEnterPasswordNull')}}",
  customer_company: "{{__('signUp.nameBusiness')}}", 
  customer_address: "{{__('signUp.addressBusiness')}}",
  }
  }); 

  function validateInput() {
     var letters = /^[A-Za-z]{2}[0-9]{9}$/;
    var val = document.getElementById("customer_vat").value;
    return letters.test(val);
  }

  $('#customer_vat').focusout(function() {
    // put your code here!
    console.log(validateInput());
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
    $('.modal-footer').html('<button type="button" class="btn themebtn3" id="verify_sms">{{__('signUp.verify')}}</button>');
    var customer_contact = $(".individual-contact").val();
    if(customer_contact == '' || customer_contact.length < 8)
    {
      Swal.fire({
      icon: 'error',
      title: '{{__('signUp.smsPopUpAlertOps')}}',
      text: '{{__('signUp.smsPopUpAlertWarning')}}'
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
                  $('#countdown').html("{{__('signUp.smsPopUpExpire')}}");
                  $('.modal-footer').html('<input type="button" class="btn themebtn3" id="contact-verify" value="{{__('signUp.resend')}}">');
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
          $('#countdown').html(timeleft + " {{__('signUp.smsPopUpSecondsRemaining')}}");
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
        title: '{{__('signUp.smsPopUpAlertOps')}}',
        text: '{{__('signUp.smsPopUpAlertEmptyMsg')}}'
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
            $("#SmsVerificationModal").modal('hide');
            Swal.hideLoading();
            $('#contact-verify').prop("disabled", true);
            $('.individual').prop("disabled", false);
            Swal.fire(
              '{{__('signUp.smsPopUpAlertSuccessMsg')}}',
              )
          }else{
            Swal.hideLoading();
            Swal.fire({
              icon: 'error',
              title: '{{__('signUp.smsPopUpAlertOps')}}',
              text: '{{__('signUp.smsPopUpAlertWrongCode')}}'
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
@stop