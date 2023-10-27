@extends('layouts.app')

@section('content')
<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
  <div class="container">
    <div class="row ml-0 mr-0">
          @include('users.ads.adsTabes')
      </div>

      <div class="tab-content profile-tab-content">
        <!-- Tab 1 starts here -->
        <div class="tab-pane active" id="profile-tab1">
            <div class="row ad-tab-row">
              <div class="ad-tab-sidebar col-lg-3 col-md-4">@include('users.ads.side_bar')</div>
              <div class="col-lg-9 col-md-8 mt-md-0 mt-4 pl-md-0 pl-lg-3 ad-tab-desc">
               <div class="tab-content">
               <div class="tab-pane active" id="ad-tab1"> 
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">{{__('ads.displaying')}} 1 {{__('ads.ad_listing')}}</h6>
                  </div>
                  <div class="display-ad-status">
                    <select name="ads_selector" class="form-control ads_selector form-control-sm">
                      <option value="1">{{__('ads.active')}} ()</option>
                      <option value="0">{{__('ads.Pending')}} (}})</option>
                      <option value="2">{{__('ads.removed')}} ({{}})</option>
                    </select>
                  </div>
                </div>
                <div class="bg-white border">
                  <div class="ads-listing-rows filtered_ads">
    <form action="{{route('save.ad')}}" method="post" id="myForm" class="form-horizontal" enctype="multipart/form-data" >
      {{csrf_field()}}
    <div class="col-12 bg-white p-md-4 p-3 pb-sm-5 pb-4">
        <h2 class="border-bottom mx-md-n4 mx-n3 pb-3 px-md-4 px-3 mb-sm-5 mb-4 themecolor">{{__('ads.post_an_ad')}}</h2>

  <!-- Vehicle Information section starts here -->
        <div class="post-an-ad-sects">
          <!-- <h5 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3">Vehicle Information</h5> -->
          <h4 class="mx-md-n4 mx-n3 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold"> {{__('ads.vehicle_information')}}</h4>
          <div class="vehicleInformation">
          <div class="mb-3 row">
             <div class="ml-auto mr-auto col-lg-4 col-md-6 col-12 mandatory-note font-weight-semibold">
              <span> ({{__('ads.all_fields_mandatory')}})</span>
            </div>
          </div> 
          <div class="form-group mb-4 row">
            <div class="col-md-4 mt-md-3 pt-md-2 text-md-right">
              <label class="mb-0 text-capitalize">{{__('ads.ad_description')}}<sup class="text-danger">*</sup></label>
            </div>
            <div class="col-lg-6 col-md-8 col-12">
              <div class="about-message-field text-right font-weight-semibold mb-1">
                <span>{{__('ads.remaining_characters')}} 995</span>
                <a href="javascript:void(0)" class="reset-message d-inline-block ml-2 themecolor">{{__('ads.reset')}}</a>
              </div>
              <textarea id="description" class="form-control" rows="6" name="description" data-parsley-error-message="Please Provide Description" data-parsley-required="true" data-parsley-trigger="change" placeholder="Describe your vehicle: Example: Alloy rim, first owner, genuine parts, maintained byauthorized workshop, excellent mileage, original paint etc.">{{old('description')}}</textarea>               
              <div class="add-suggestion border mt-2 p-3">
                <p> {{__('ads.you_can_also_use_suggestions')}}</p>
                <div class="suggestions-tags">
                  @foreach($suggestions as $suggestion)
                  <a href="JavaScript:Void(0);" class=""><span class="label label-info bgcolor1 badge badge-pill pl-sm-3 pr-sm-3 pr-2 pl-2 text-white mb-2" data-id="{{$suggestion->id}}" data-sentence="{{$suggestion->sentence}}" onclick="getSentence(this)">{{$suggestion->title}}</span></a>
                  @endforeach
                </div>
              </div>
              <div class="border border-top-0 pb-2 pl-3 pr-3 pt-2 show-more-suggestion text-center">
                <a href="#" class="font-weight-bold themecolor">{{__('ads.show_more')}}</a>
              </div>
            </div>
          </div>  
        </div>
        </div>
   <!-- Vehicle Information section ends here -->  

    <div class="border-top mx-n4 pt-4 pt-sm-5 px-4 mt-sm-5 mt-4 text-center">
      <input type="submit" class="btn pb-3 pl-4 post-ad-submit pr-4 pt-3  themebtn1" value="{{__('ads.submit_and_continue')}}">
    </div>




    </div>
   </form>

                  </div>{{-- END OF CONTAINER --}}
                </div>
              </div>
               </div> 
           </div>
         </div>
        </div>
        <!-- Tab 1 ends here -->        
      </div>
    </div>

@push('scripts')
<script type="text/javascript">
  $(document).ready(function(){  
  });
</script>
@endpush
@endsection