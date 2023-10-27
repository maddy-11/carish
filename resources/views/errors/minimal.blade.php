@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 120px;margin-bottom: 152px;">
    <div class="row justify-content-center">
    	<div class="col-md-6 text-center">
        	<p class="text-primary" style="font-size:50px;"><b>404</b></p>
        	<p class="text-secondary" style="font-size:25px; margin-top: -15px;"><b>{{ __('home.page_not_found') }}</b></p>
        	<div class="progress" style="margin-left: 94px;margin-right: 94px;height: 10px;">
			  <div class="progress-bar bg-secondary" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
        </div>
        <div class="col-md-6 text-center">
        <span class="dot" style="height: 220px;width: 220px;background-color: #DEDEDE;border-radius: 50%;display: inline-block; margin-top: -20px;"><img class="" style="margin-top: 60px;" alt="carish-logo" src="{{ asset('public/assets/img/logo2.png')}}"></span>
        

      </div>
        
    </div>
</div>
@endsection
