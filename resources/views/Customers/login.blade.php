@extends('layouts.app')
@section('title') {{ __('signIn.pageTitle') }} @endsection
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
<!-- Begin customers page -->

<div class="internal-page-content mt-4 pt-5 sects-bg">
<div class="container pt-2">
  @if(session::has('msg'))
<div class="alert alert-success">
  <strong> {{session::get('msg')}} </strong>
</div>
@endif

@if(session::has('verify'))
<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>{{ __('signIn.loginVerify') }}</strong>
</div>
@endif

@if(session::has('verified'))
<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>{{ __('signIn.loginVerified') }}</strong>
</div>
@endif

@if(session::has('not_verified'))
<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>{{ __('signIn.loginNotVerified') }}</strong>
</div>
@endif

@if(session::has('business_email_verified'))
<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>{{ __('signIn.businessEmailVerifyMsg') }}</strong>
</div>
@endif

@if(session::has('business_email_verify'))
<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>{{ __('signIn.businessAdminVerifyMsg') }}</strong>
</div>
@endif

 @include('messeges.notifications') 
  <div class="row">
    <div class="col-lg-5 mx-auto col-12 sign-in-col">
      <div class="signInbg box-shadow bg-white p-md-5 p-sm-4 p-3 pt-4 rounded">
        <h1 class="mb-4 pb-md-2  themecolor">{{ __('signIn.signInToCarish') }}</h1>

       <!--  <div class="connect-with-social">
          <a target="" href="{{url('user/redirect/facebook')}}" class="border-0 btn btn-block facebook-btn mt-2 px-3 px-sm-4 text-white"><em class="fa fa-facebook align-middle  mr-2"></em> Connect with facebook</a>
        <a target="" href="{{url('user/redirect/google')}}" class="border-0 btn btn-block google-btn mt-2 mt-3 px-3 px-sm-4 text-white"><em class="fa fa-google align-middle mr-2"></em> Connect with google</a>
        </div> -->
       
        <form class="mt-4 signIn-form" action=""  method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <label class="mb-3 signIn-note mb-3">{{ __('signIn.signInRegisteredAccount')}}:</label>
          
          <div class="form-group mb-4">
            <div class="input-group d-flex align-items-center">
              <em class="fa fa-user text-center" title="Email"></em>
              <input type="email" required="required" id="customer_email_address" name="customer_email_address" class="form-control border-0 pl-0" placeholder="{{__('signIn.email')}}" value="{{ old('customer_email_address') }}">
            </div>
          </div>
          <div class="form-group mb-4">
            <div class="input-group d-flex align-items-center">
              <em class="fa fa-key text-center" title="Password"></em>
              <input type="password" required="required" id="customer_password" name="password" class="form-control border-0 pl-0" placeholder="{{__('signIn.password')}}" value="{{ old('customer_password') }}"  >
            </div>
          </div>  

          <div class="form-group mb-4 text-right">
            <a target="" href="{{url('password/reset')}}" class="themecolor">{{ __('signIn.forgotPassword')}}?</a>
          </div> 

          <div class="form-group signIn-group">
            <input type="submit" class="btn rounded-0 btn-block themebtn1 signIn-btn" value="{{__('signIn.buttonText')}}">
          </div>    
          <div class="text-right"><p class="mb-0 themecolor"><a target="" href="{{ route('signup') }}" class="themecolor">{{ __('signIn.dontHaveAccount')}}</a></p></div>  
        </form>

      </div>
    </div>
  </div>
</div>
</div>
@stop