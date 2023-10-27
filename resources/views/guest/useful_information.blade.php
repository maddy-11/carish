@extends('layouts.app')
@section('title') {{ __('header.usefulInformation') }} @endsection
@push('scripts') 
@endpush
@section('content')
    <!-- header Ends here -->
      <div class="internal-page-content mt-4 sects-bg">
        <div class="container">
          <div class="row">
            <div class="col-12 mt-4 mt-lg-5 pt-3 pt-lg-0">
              <h3 class="themecolor font-weight-bold mb-4 pb-2">{{@$page_description->title}}</h3>
              <div class="bg-white border p-md-4 p-3">
                  <p>{!!@$page_description->description!!}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection