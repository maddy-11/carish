@extends('layouts.register')
@section('title')customers Reset Password @stop
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
<!-- Begin page -->
<div class="accountbg" style="background: url('{{url('/')}}/assets/images/bg-1.jpg');background-size: cover;"></div>
<div class="wrapper-page account-page-full">
    <div class="card">
        <div class="card-block">
            <div class="account-box">
                <div class="card-box p-5">
                    <h2 class=" text-center pb-4">
                    <a href="index.html" class="text-success">
                        <span><img src="{{url('/')}}/assets/images/logo.png" alt="carish used cars for sale in estonia" height="26"></span>
                    </a>
                    </h2>
                    @include('messeges.notifications')
                    <form class="" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group m-b-20 row">
                            <div class="col-12">
                                <label for="customer_email_address">Email address</label>
                                <input class="form-control" type="email" id="customer_email_address" required="" placeholder="Enter your email"  name="customer_email_address" value="{{ old('customer_email_address') }}">
                                @if ($errors->has('customer_email_address'))
                                <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{ $errors->first('customer_email_address') }}</li></ul>
                                @endif
                            </div>
                        </div>

                         <div class="form-group m-b-20 row">
                            <div class="col-12">
                                <label for="customer_password">Password</label>
                                <input class="form-control" type="password" id="customer_password" required="" placeholder="Enter your email"  name="customer_password" value="{{ old('customer_password') }}">
                                @if ($errors->has('customer_password'))
                                <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{ $errors->first('customer_password') }}</li></ul>
                                @endif
                            </div>
                        </div>


                         <div class="form-group m-b-20 row">
                            <div class="col-12">
                                <label for="password_confirmation">Confirm Password</label>
                                <input class="form-control" type="password" id="password_confirmation"  placeholder="Enter your email"  name="password_confirmation" value="{{ old('password_confirmation') }}">
                                @if ($errors->has('password_confirmation'))
                                <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{ $errors->first('password_confirmation') }}</li></ul>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row text-center m-t-10">
                            <div class="col-12">
                                <button class="btn btn-block btn-custom waves-effect waves-light" type="submit">Reset Password</button>
                            </div>
                        </div>
                    </form>
                    <div class="row m-t-50">
                        <div class="col-sm-12 text-center">
                            <p class="text-muted">Don't have an account? <a target="" href="{{url('customers/signup')}}" class="text-dark m-l-5"><b>Sign Up</b></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="m-t-40 text-center">
        <p class="account-copyright">2018 © Highdmin. - Coderthemes.com</p>
    </div>
</div>
@stop