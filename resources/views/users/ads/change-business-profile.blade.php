@extends('layouts.app')
@section('title') {{ __('dashboardMyProfile.pageTitle') }} @endsection
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
</style>
@endpush
<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
  <div class="container">
    <form class="add-profile-form" action="" method="POST" id="myForm">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="customer_role" value="individual">
      <input type="hidden" name="customer_id" value="{{$customer->id}}">
      <div class="row ml-0 mr-0">
        <div class="col-12 mx-auto bg-white border p-sm-4 p-3 pb-md-5 mb-md-5 mb-4">
          <div class="backto-dashboard text-right mb-md-3 mb-2">
            <a target="" href="{{url('user/my-ads')}}" class="font-weight-semibold themecolor"><em class="fa fa-chevron-circle-left"></em> {{__('dashboardMyProfile.back')}}</a>
        </div>
          <h3 class="">{{__('dashboardMyProfile.pageTitle')}}</h3>
          <div class="col-xl-5 col-lg-6 col-md-6 ml-auto mr-auto pl-0 pr-0 mt-md-4 mt-3">
              <div class="row align-items-end">
                 <div class="col-lg-4 col-sm-4 col-4 user-profile-img">
                    @if($customer->logo != Null && file_exists( public_path().'/uploads/customers/logos/'.@$customer->logo))
                    <img src="{{asset('public/uploads/customers/logos/'.$customer->logo)}}" alt="carish used cars for sale in estonia" class="profile-image" style="width: 90px;height: 90px;">
                    @else
                    <img src="{{asset('public/uploads/image/profileImg.jpg')}}" alt="Avatar" class="profile-image">
                    @endif
                  <!-- ends -->
                 </div>  
                 <div class="col-lg-8 col-sm-8 col-8 pl-0 pl-sm-3">
                    <input type="file" class="form-control-file" id="logo" name="logo" accept="image/*">
                    <p class="m-0" style="color: #999;">({{__('dashboardMyProfile.maxLimit')}})</p>
                 </div>         
              </div>          
        </div>
        </div>
        <div class="col-12 mx-auto bg-white border p-sm-4 p-3 py-lg-5 py-4">
          <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">{{__('dashboardMyProfile.companyName')}}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="text" class="form-control" name="company_name" value="{{@$customer->customer_company}}" placeholder="{{__('dashboardMyProfile.companyName')}}">
              </div>
           </div>
          <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">{{__('dashboardMyProfile.address')}}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="text" class="form-control" name="address" value="{{@$customer->customer_default_address}}" placeholder="{{__('dashboardMyProfile.address')}}">
              </div>
           </div>
          <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">{{__('dashboardMyProfile.vat')}}</label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="text" class="form-control" name="vat" value="{{@$customer->customer_vat}}" placeholder="{{__('dashboardMyProfile.vat')}}" pattern="[A-za-z]{2}[0-9]{9}" title="{{__('dashboardMyProfile.vatValidation')}}">
              </div>
           </div>
          <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">{{__('dashboardMyProfile.phone')}}#<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="number" pattern="[0-9]+"  class="form-control" name="phone" value="{{@$customer->customers_telephone}}" placeholder="03075943188">
              </div>
           </div>
          <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">{{__('dashboardMyProfile.regNumber')}}#<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="tel" class="form-control" name="registration" value="{{@$customer->customer_registeration}}" placeholder="03075943188">
              </div>
           </div>
          <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">{{__('dashboardMyProfile.website')}}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="text" class="form-control" value="{{@$customer->website}}" name="website" placeholder="{{__('dashboardMyProfile.website')}}"
               pattern="(http(s)?://)?(www\.)?[A-Za-z0-9]+\.[a-z]{2,3}" required>
              </div>
           </div>
          <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">{{__('dashboardMyProfile.city')}}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <select class="form-control" name="city">
                  <option value="">Select City</option>
                  @foreach($cities as $city)
                    <option value="{{$city->id}}" {{ ($customer->citiy_id == $city->id)? "selected='true'":" " }}>{{$city->name}}</option>
                  @endforeach
                </select>
              </div>
           </div>
          <div class="timing">
           @if($timings->count()>0)
            @foreach($timings as $key => $time)
            <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row" id="savetiming_{{@$time->id}}">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">{{__('dashboardMyProfile.workingHours')}}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-9 col-xl-9 col-lg-6 col-sm-7">
                <div class="row form-row working-hours-fields">
                  <div class="col-lg-3 col-md-3">
                    <select name="timing[]" class="form-control" required="true" >
                      <option value="">{{__('dashboardMyProfile.select')}}</option>
                      <option value="All Days" {{ ($time->day_name == 'All days')? "selected":"" }}>{{__('dashboardMyProfile.allDays')}}</option>
                      <option value="Monday to Friday" {{ ($time->day_name == 'Monday to Friday')? "selected":" " }}>{{__('dashboardMyProfile.monToFri')}}</option>
                      <option value="Monday" {{ ($time->day_name == 'Monday')? "selected":"" }}>{{__('dashboardMyProfile.mon')}}</option>
                      <option value="Tuesday" {{ ($time->day_name == 'Tuesday')? "selected":"" }}>{{__('dashboardMyProfile.tue')}}</option>
                      <option value="Wednesday" {{ ($time->day_name == 'Wednesday')? "selected":"" }}>{{__('dashboardMyProfile.wed')}}</option>
                      <option value="Thursday" {{ ($time->day_name == 'Thursday')? "selected":"" }}>{{__('dashboardMyProfile.thu')}}</option>
                      <option value="Friday" {{ ($time->day_name == 'Friday')? "selected":"" }}>{{__('dashboardMyProfile.fri')}}</option>
                      <option value="Saturday" {{ ($time->day_name == 'Saturday')? "selected":"" }}>{{__('dashboardMyProfile.sat')}}</option>
                      <option value="Sunday" {{ ($time->day_name == 'Sunday')? "selected":"" }}>{{__('dashboardMyProfile.sun')}}</option>
                    </select>
                  </div>
                  <div class="col-lg-3 col-md-3">
                    <input type="time" class="form-control" value="{{@$time->opening_time}}"  name="opening_time[]" placeholder="Opening Time">
                  </div>
                  <div class="col-lg-3 col-md-3">
                    <input type="time" class="form-control" value="{{@$time->closing_time}}" name="closing_time[]" placeholder="Closing Time">
                  </div>
                  <div class="col-lg-3 col-md-3">
                    <a href="javascript:void(0)" class="fa fa-plus-square h-100 themecolor add-times-btn"></a>
                    <a href="javascript:void(0)" class="fa fa-minus-square h-100 themecolor add-times-minus-btn" data-id="{{@$time->id}}"></a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
            @else
            <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">{{__('dashboardMyProfile.workingHours')}}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-6 col-lg-6 col-sm-7">
               <div class="row form-row working-hours-fields">
                  <div class="col">
                    <select name="timing[]" class="form-control">
                      <option value="">{{__('dashboardMyProfile.select')}}</option>
                      <option value="All days">{{__('dashboardMyProfile.allDays')}}</option>
                      <option value="Monday to Friday">{{__('dashboardMyProfile.monToFri')}}</option>
                      <option value="Monday">{{__('dashboardMyProfile.mon')}}</option>
                      <option value="Tuesday">{{__('dashboardMyProfile.tue')}}</option>
                      <option value="Wednesday">{{__('dashboardMyProfile.wed')}}</option>
                      <option value="Thursday">{{__('dashboardMyProfile.thu')}}</option>
                      <option value="Friday">{{__('dashboardMyProfile.fri')}}</option>
                      <option value="Saturday">{{__('dashboardMyProfile.sat')}}</option>
                      <option value="Sunday">{{__('dashboardMyProfile.sun')}}</option>
                    </select>
                  </div>
                  <div class="col">
                    <input type="time" class="form-control" name="opening_time[]" placeholder="Opening Time" required="true">
                  </div>
                  <div class="col">
                    <input type="time" class="form-control" name="closing_time[]" placeholder="Closing Time" required="true">
                  </div>
                  <div class="col-2">
                    <a href="" class="fa fa-plus-square h-100 themecolor add-times-btn"></a>
                  </div>
                </div>
              </div>
            </div>
           @endif
         </div>
          {{-- Prefered Language --}}
          <div class="form-group mb-4 d-flex align-items-center row offset-lg-3">
            <div class="input-group-append col-md-3 col-lg-2 col-sm-4 mb-1 mb-sm-0 text-sm-right">
        <em class="fa fa-globe text-center signuo-field-icon"></em>
        </div>
            <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
        <select class="form-control" name="prefered_language">
          <option>-- Preferred Language</option>
          <option value="2" {{ ($customer->language_id == '2')? "selected":" " }}>English</option>
          <option value="1" {{ ($customer->language_id == '1')? "selected":" " }}>Estonian</option>
          <option value="3" {{ ($customer->language_id == '3')? "selected":" " }}>Russian</option>
        </select>
        </div>
        </div>
          <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-6 col-xl-5 col-lg-5 offset-lg-2 offset-sm-3 col-sm-7">
                <input type="submit" class="btn pl-4 post-ad-submit pr-4 pl-lg-5 pr-lg-5 pt-lg-3 pb-lg-3  themebtn1" value="{{__('dashboardMyProfile.buttonText')}}">
              </div>
           </div>
        </div>
      </div>
    </form>
  </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>

<script> 
    /* MUTAHIR SCRIPT FOR MAKE MODEL VERSION  file: {
                required: true,
                accept: "audio/*, video/*"
            } */
    $(document).ready(function(){ 
      var i = 0;
      $(".add-times-btn").click(function(e){
        e.preventDefault();
        i++;
    $(".timing").append('<div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row" id="timing_'+i+'"><div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right"><label class="mb-0 text-capitalize">Working Hour<sup class="text-danger">*</sup></label></div><div class="row form-row working-hours-fields"><div class="col"><select name="timing[]" class="form-control"><option value="">--Select--</option><option value="All days">All days</option><option value="Monday to Friday">Monday to Friday</option><option value="Monday">Monday</option><option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option><option value="Thursday">Thursday</option><option value="Friday">Friday</option><option value="Saturday">Saturday</option><option value="Sunday">Sunday</option></select></div><div class="col"><input type="time" class="form-control" name="opening_time[]" placeholder="Opening Time"></div><div class="col"><input type="time" class="form-control" name="closing_time[]" placeholder="Closing Time"></div><div class="col-2"><a href="javascript:void(0)" class="fa fa-minus-square h-100 themecolor add-minus-times-btn" data-id="'+i+'" style="font-size:3rem;"></a></div></div></div></div>');
      });
    });
  $(function(){
    $(document).on('submit', '.add-profile-form', function(e){
      e.preventDefault();
      var timing = $('.timing_class').val();
      if(timing == 'undefined'){ }
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ route('update-business-profile') }}",
        method: 'post',
        data: new FormData(this), 
        contentType: false,       
        cache: false,             
        processData:false,
        beforeSend: function(){
          $('.save-btn').val("{{ __('dashboardMyProfile.pleaseWait') }}...");
          $('.save-btn').addClass('disabled');
          $('.save-btn').attr('disabled', true);
        },
        success: function(data){
          $('.save-btn').val('add');
          $('.save-btn').attr('disabled', true);
          $('.save-btn').removeAttr('disabled');
          if(data.error == false){
            toastr.success('Success!', 'Profile updated successfully',{"positionClass": "toast-bottom-right"});
            //$('.add-profile-form')[0].reset();
            //window.location.reload();    
            location.reload();
            //document.location.reload(true);           
          }
        },
        error: function (request, status, error) {
          $('.save-btn').val('add');
          $('.save-btn').removeClass('disabled');
          $('.save-btn').removeAttr('disabled');
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
    });   


    $.validator.addMethod("vatValidate", function(value, element) {
        var letters = /^[A-Za-z]{2}[0-9]{9}$/;  
        return this.optional(element) || letters.test(value);
        }, "{{__('dashboardMyProfile.vatValidation')}}");

          $("#myForm").validate({
            rules: {
              vat : { required:false,vatValidate : true },
              company_name:{
                required:true
              },
              address:{
                required: true
              },
              phone:{
                required: true
              },
              registration:{
                required: true,
                rangelength:[8,8]
              },
              website:{
                required:true
              },
              opening_time: {
                required: true
              },
              logo:{ required:false,
              extension: "jpg|gif|png|bmp|jpeg"
              }
          },
            messages: {
                    company_name: "{{__('dashboardMyProfile.pleaseEnterCompanyName')}}",
                    address: "{{__('dashboardMyProfile.pleaseEnterAddress')}}",
                    phone: "{{__('dashboardMyProfile.pleaseEnterValidPhoneNumber')}}",
                    registration: "{{__('dashboardMyProfile.pleaseEnterAValidRegistrationNumber')}}",
                    website: "{{__('dashboardMyProfile.pleaseEnterAValidWebsiteUrl')}}",
                    opening_time: "{{__('dashboardMyProfile.pleaseEnterOpeningTime')}}",
                    logo:"{{__('dashboardMyProfile.only_jpg_gif_png_bmp_jpeg_extensions_are_allowed')}}"
            }
          }); 
          $(document).on('click','.add-minus-times-btn',function(){
            var id = $(this).data('id');
            $('#timing_'+id).remove();
          });
          $(document).on('click','.add-times-minus-btn',function(){
            var id = $(this).data('id');
            $('#savetiming_'+id).remove();
          });
</script>
@endpush
@endsection