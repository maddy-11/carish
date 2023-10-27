@extends('layouts.app')
@section('title') {{ __('header.forget_password') }} @endsection
@push('styles')

@endpush
@push('scripts')
@endpush
@section('content')

<div class="internal-page-content mt-4 pt-5 sects-bg">
<div class="container pt-2">
      @if(session::has('msg'))
<div class="alert alert-success">
  <strong> {{session::get('msg')}} </strong>
</div>
@endif
  <div class="row">
     <div class="col-lg-12 mx-auto col-12 sign-in-col">
      <div class="signInbg box-shadow bg-white p-md-5 p-sm-4 p-3 pt-4 rounded" style="width: 100%">
    @include('messeges.notifications')
    <div class="row">
      <div class="col">
        <h2 style="margin-bottom: 32px;">{{ __('common.reset_your_password') }}</h2>
      </div>
    </div>
                    <form class="" action="{{ route('password.reset.email') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group m-b-20 row">
                            <div class="col-12">
                                <label for="customer_email_address">{{ __('ads.email') }}</label>
                                <input class="form-control" type="email" id="customer_email_address" required="" placeholder="{{ __('common.enter_your_email') }}"  name="customer_email_address" value="{{ old('customer_email_address') }}">
                                @if ($errors->has('customer_email_address'))
                                <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{ $errors->first('customer_email_address') }}</li></ul>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row text-center m-t-10">
                            <div class="col-12">
                                <button class="btn btn-block btn-custom waves-effect waves-light" type="submit">{{ __('common.send_password_reset_link') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
  </div>
</div>
</div>

@stop