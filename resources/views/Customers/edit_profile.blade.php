@extends('layouts.app')
@section('title') Update Profile @endsection
@push('styles')
@endpush
@push('scripts') 
@endpush
@section('content') 
  <div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">

  <div class="container">
    <div class="row ml-0 mr-0">
      <div class="col-9 mx-auto bg-white border p-sm-4 p-3 pb-md-5 mb-md-5 mb-4">
        <div class="backto-dashboard text-right mb-md-3 mb-2">
            <a href="javascript:void(0)" class="font-weight-semibold themecolor"><em class="fa fa-chevron-circle-left"></em> Back to Dashboard</a>
        </div>
        <h3 class="">My profile</h3>
        <div class="col-xl-5 col-lg-6 col-md-6 ml-auto mr-auto pl-0 pr-0 mt-md-4 mt-3">
              <div class="row align-items-end">
                 <div class="col-lg-4 col-sm-4 col-4 user-profile-img">
                   <img src="assets/img/user-profile-Img.jpg" class="img-fluid" alt="profile image">
                 </div>  
                 <div class="col-lg-8 col-sm-8 col-8 pl-0 pl-sm-3">
                    <input type="file" class="form-control-file" name="file">
                 </div>         
              </div>          
        </div>
      </div>

      <div class="col-9 mx-auto bg-white border p-sm-4 p-3 py-lg-5 py-4">
           <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">Full name<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="text" class="form-control" placeholder="Full Name">
              </div>
           </div>
           <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">preferred language<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7"> 
                  <select class="form-control selectpicker select-cont"   name="preferredLanguage">
          <!-- @foreach(@$languages as $lang)
          <option value="{{@$lang->id}}">{{$lang->language_title}}</option>
          @endforeach -->
            <option data-content='<span class="flag-icon flag-icon-ee"></span> Estonian'>Estonian</option>
          <option data-content='<span class="flag-icon flag-icon-us"></span> English'>English</option>
  <option  data-content='<span class="flag-icon flag-icon-ru"></span> Russia'>Russia</option>
        </select> 
              </div>
           </div> 
           <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">Phone#<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="tel" class="form-control" placeholder="03075943188">
              </div>
           </div>
           <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-6 col-xl-5 col-lg-5 offset-lg-2 offset-sm-3 col-sm-7">
                <input type="submit" class="btn pl-4 post-ad-submit pr-4  pl-lg-5 pr-lg-5 pt-lg-3 pb-lg-3  themebtn1" value="SAVE CHANGES">
              </div>
           </div>

           <div class="justify-content-center align-items-center form-group mb-0 row mx-sm-n4 mt-lg-5 pt-lg-5 mt-4 pt-4 border-top">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">Linked Account</label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <a href="javascript:void(0)" class="border-0 btn btn-block facebook-btn pb-lg-3 pt-lg-3 text-white px-3 "><em class="fa fa-facebook align-middle mr-md-3 mr-sm-2 mr-1"></em> Connect with facebook</a>
              </div>
           </div>
      </div>
    </div>
</div>
</div>
@stop