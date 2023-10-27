@extends('layouts.app')
<style type="text/css">
  .select2.select2-container {
  width: 100% !important;
}
</style>
@section('content')
    @push('styles') 
    @endpush  
<div class="internal-page-content mt-4 pt-lg-5 pt-4 sects-bg">
<div class="container pt-2">


@if(count($errors) > 0)
    <div class="alert alert-danger">
     Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif

   @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
   
    <div class="row ml-0 mr-0 post-an-ad-row">
  <div class="col-12 bg-white p-md-4 p-3 pb-sm-5 pb-4">
      <h2 class="border-bottom mx-md-n4 mx-n3 pb-3 px-md-4 px-3 mb-sm-5 mb-4 themecolor">{{ __('common.create_car_alerts') }}</h2>
      <form action="{{url('user/save-car-alerts')}}" method="post" id="myForm" class="form-horizontal" enctype="multipart/form-data" data-parsley-validate>
                        {{csrf_field()}}

<!-- Vehicle Information section starts here -->
      <div class="post-an-ad-sects">
        <!-- <h4 class="mx-md-n4 mx-n3 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">Create car alerts</h4> -->
        <div class="vehicleInformation">
        <div class="mb-3 row">
           <div class="ml-auto mr-auto col-lg-4 col-md-6 col-12 mandatory-note font-weight-semibold">
            <span>({{ __('ads.all_fields_mandatory') }})</span>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 col-12">
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{ __('common.car_make') }}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-sm-7">
          <select class="js-select2" name="car_make">
          <option disabled="true">{{ __('common.select_car_make') }}</option>
          @foreach($makes as $make)
          <option value="{{$make->id}}">{{$make->title}}</option>
          @endforeach
          
        </select>
              </div>
            </div>
           
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{ __('common.car_model') }}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-sm-7">
                <select class="js-select2" name="car_model">
          <option disabled="true">{{ __('common.select_car_model') }}</option>
          @foreach($models as $model)
          <option value="{{$model->id}}">{{$model->name}}</option>
          @endforeach
          
        </select>
              </div>
            </div>
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{ __('common.city') }}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-sm-7">
                <select class="js-select2" name="city">
          <option disabled="true">{{ __('profile.select_city') }}</option>
          @foreach($cities as $city)
          <option value="{{$city->id}}">{{$city->name}}</option>
          @endforeach
        </select>

              </div>
            </div>
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{ __('common.price_range') }}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-sm-7">
               <select class="js-select2" name="price_from">
                <option disabled="true">-- {{ __('common.price_range_from') }} --</option>
          <option value="100000">100000</option>
          <option value="200000">200000</option>
          <option value="300000">300000</option>
          <option value="400000">400000</option>
        </select><br>
         <select class="js-select2" name="price_to">
                <option disabled="true">-- {{ __('common.price_range_to') }} --</option>
          <option value="100000">100000</option>
          <option value="200000">200000</option>
          <option value="300000">300000</option>
          <option value="400000">400000</option>
        </select>
        
              </div>
            </div>
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{ __('common.year_range') }}</label>
              </div>
              <div class="col-md-6 col-sm-7">
                <select class="js-select2" name="year_from">
                <option disabled="true">-- {{ __('common.year_range_from') }} --</option>
          <option value="2015">2015</option>
          <option value="2016">2016</option>
          <option value="2017">2017</option>
          <option value="2018">2018</option>
        </select><br>
         <select class="js-select2" name="year_to">
                <option disabled="true">-- {{ __('common.year_range_to') }} --</option>
          <option value="2015">2015</option>
          <option value="2016">2016</option>
          <option value="2017">2017</option>
          <option value="2018">2018</option>
        </select>
       
              </div>
            </div>
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{ __('common.mileage_range') }}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-sm-7">
              <select class="js-select2" name="mileage_from">
                <option disabled="true">-- {{ __('common.mileage_range_from') }} --</option>
          <option value="100 km">100 km</option>
          <option value="500 km">500 km</option>
          <option value="1000 km">1000 km</option>
          <option value="2000 km">2000 km</option>
        </select><br>
        <select class="js-select2" name="mileage_to">
                <option disabled="true">-- {{ __('common.mileage_range_to') }} --</option>
          <option value="100 km">100 km</option>
          <option value="500 km">500 km</option>
          <option value="1000 km">1000 km</option>
          <option value="2000 km">2000 km</option>
        </select>

              </div>
            </div>
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{ __('common.transmission') }}</label>
              </div>
              <div class="col-md-6 col-sm-7">
               <select class="js-select2" name="transmission">
          <option disabled="true">{{ __('common.select_transmission') }}</option>
          <option value="any">Any</option>
          <option value="automatic">Automatic</option>
          <option value="manual">Manual</option>
        </select>
              </div>
            </div>

             <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{ __('common.frequency') }}</label>
              </div>
              <div class="col-md-6 col-sm-7">
               <select class="js-select2" name="frequency">
          <option disabled="true">{{ __('common.select_frequency') }}</option>
          <option value="daily">Daily</option>
          <option value="weekly">Weekly</option>
        
        </select>
              </div>
            </div>
          </div>
         
        </div>
                
      </div>
      </div>  

  <div class="border-top mx-n4 pt-4 pt-sm-5 px-4 mt-sm-5 mt-4 text-center">
    <input type="submit" class="btn pb-3 pl-4 post-ad-submit pr-4 pt-3  themebtn1" value="{{ __('ads.submit_and_continue') }}">
  </div>



  </form>
  </div>

  </div>
</div>
</div>
   @push('scripts')
   <script type="text/javascript">
     $(document).ready(function() {
  
  $(".js-select2").select2();
});
   </script>
    @endpush
@endsection