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
      <h2 class="border-bottom mx-md-n4 mx-n3 pb-3 px-md-4 px-3 mb-sm-5 mb-4 themecolor">{{ __('common.create_accessories_alert') }}</h2>
      <form action="{{url('user/save-accessories-alerts')}}" method="post" id="myForm" class="form-horizontal" enctype="multipart/form-data" data-parsley-validate>
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
                <label class="mb-0">{{ __('common.select_category') }}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-sm-7">
          <select class="js-select2 category" name="category">
          <option>--{{ __('common.select_category') }}--</option>
          @foreach($categories as $cat)
          <option value="{{$cat->id}}">{{$cat->title}}</option>
          @endforeach
          
        </select>
        <input type="hidden" id="parent_category" name="parent_category" value="">
              </div>
            </div>
           
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
              
                <label class="mb-0">{{ __('common.select_sub_category') }}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-sm-7">
                <select class="js-select2" name="sub_category" id="sub-category">
          <option>--{{ __('common.select_sub_category') }}--</option>
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
                <label class="mb-0">{{ __('common.frequency') }}</label>
              </div>
              <div class="col-md-6 col-sm-7">
               <select class="js-select2" name="frequency">
          <option disabled="true">{{ __('common.select_frequency') }}</option>
          <option value="daily">{{ __('ads.daily') }}</option>
          <option value="weekly">{{ __('ads.weekly') }}</option>
        
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
     $(document).on('change','.category',function(){
      var id = $(this).val();
       $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
  });
     $.ajax({
              url: "{{ route('get-spare-part-sub-category') }}",
              method:"get",
               data: {id:id}, 
              success: function(response){
                $('#sub-category').empty();
                $('#sub-category').append(response.html);
              }
            });
     });
   </script>
    @endpush
@endsection