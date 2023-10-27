@extends('layouts.app')
@section('title') Greeting For Signup @endsection
@push('styles')

@endpush
@push('scripts')
@endpush
@section('content')
<!-- Begin page -->

<div class="internal-page-content mt-4 pt-5 pb-5 sects-bg">
<div class="container pt-2 pb-3 bg-white">
  <p>
    <h4>Thank you for your registration.</h4>
    <p>Please verify your email before logging in to the system.</p>
    <a target="" href="{{url('/')}}" class="btn-sm btn-success">Home</a>
    <a target="" href="https://accounts.google.com/ServiceLogin/signinchooser?hl=en&passive=true&continue=https%3A%2F%2Fwww.google.com%2Fsearch%3Fq%3Dgmail%26rlz%3D1C1SQJL_enPK861PK861%26oq%3Dgmail%26aqs%3Dchrome..69i57j69i59l3j69i61j69i60j69i61.1327j0j9%26sourceid%3Dchrome%26ie%3DUTF-8&flowName=GlifWebSignIn&flowEntry=ServiceLogin" class="btn-sm btn-primary">Open Email</a>
  </p>
</div>
</div>
@push('scripts')

@endpush
@stop