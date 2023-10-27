@extends('layouts.app')

@section('content')
@push('styles') 
    <style>
#overlay{	
	position: fixed;
	top: 0;
	z-index: 100;
	width: 100%;
	height:100%;
	display: none;
	background: rgba(0,0,0,0.6);
}
.cv-spinner {
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;  
}
.spinner {
	width: 100px;
	height: 100px;
	border: 4px #ddd solid;
	border-top: 4px #2e93e6 solid;
	border-radius: 50%;
	animation: sp-anime 0.8s infinite linear;
}
@keyframes sp-anime {
	100% { 
		transform: rotate(360deg); 
	}
}
.is-hide{
	display:none;
}
/* OVER LAY STYLE ENDS HERE. */

	label.error {
		color: red;
		font-size: 16px;
		font-weight: normal;
		line-height: 1.4; 
		width: 100%;
		float: none;
	}
	@media screen and (orientation: portrait) {
		label.error {
			margin-left: 0;
			display: block;
		}
	}
	@media screen and (orientation: landscape) {
		label.error {
			display: inline-block; 
		}
	} 

  input.error {
  background-color: #efa1a4 !important;  
}
select.error {
  background-color: #efa1a4 !important;  
} 

textarea.error {
  background-color: #efa1a4 !important; 
}

 
/* Images section */
.box-drag {
    /* float: left; */
    display: block;
    width: 24.33%;
    padding: 0 15px;
}
.no-padding {
    padding: 0px !important;
}
.uploadArea {
    border: dashed #676465;
    text-align: center;
    line-height: 30px;
    font-size: 18px;
    margin-bottom: 20px !important;
    cursor: pointer;
}
.uploadArea .new {
    padding-top: 35px;
    padding-bottom: 30px;
    display: block;
}
.hidden {
    display: none !important;
}
.image-preview img {
    padding-top: 0px !important;
    width: 100%;
    height: 139px;
}
.image-preview .remove {
    text-align: right;
    color: white;
    position: absolute;
    width: 100%;
    padding-right: 7px;
    background-color: #373435;
    opacity: .4;
    height: 25px;
}
.uploadBtn:hover{
  cursor: pointer;
}
   .cover_photo{
        color: red;
        position: absolute;
        top: 0;
        z-index: 1000;
      }
      #image_preview{

      border: 1px solid #eee;

      padding: 10px;

    }
#errmsg
{
color: red;
}
#prev_0{
  position: relative;
}
    #image_preview img{

      width: 200px;
      height: 200px;
      padding: 5px;

    }
  .suggestion-class{
    height: calc(100% - 200px) !important;
    overflow: auto;
  }
  .carnumber-error{
    width:100%; text-align:left;color:red;font-size:16px;
  }
</style>
 @endpush
<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
  <div class="container">
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
   @if(session()->has('error'))
     <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif

   @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

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
                 
                </div>
                <div class="bg-white border">
                  <div class="ads-listing-rows filtered_ads">


 
<form action="{{route('update.ad')}}" method="post" id="myForm" class="form-horizontal" enctype="multipart/form-data" data-parsley-validate>
      {{csrf_field()}}
    <div class="col-12 bg-white p-md-4 p-3 pb-sm-5 pb-4">
    <h2 class="border-bottom mx-md-n4 mx-n3 pb-3 px-md-4 px-3 mb-sm-5 mb-4 themecolor">{{__('ads.update_an_ad')}}</h2>

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
          <div class="row">
            <div class="col-lg-8 col-12">
              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.bought_from')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-md-6 col-sm-7">
                     <select class="form-control select2-field" id="city" name="country_id" data-parsley-error-message="Please select Bought From" data-parsley-required="true" data-parsley-trigger="change">
                       <option value="" disabled selected>{{__('ads.select_one')}}</option>
                     @foreach($countries as $city)
                    <option value="{{$city->id}}"  @if(old('country_id') == $city->id ||$adsDetails->country_id == $city->id ) {{ 'selected' }} @endif>{{$city->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
             
              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.car_info')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-md-6 col-sm-7">
                  <input type="text" class="form-control" id="car_info" placeholder="{{@$adsDetails->maker->title}}/{{@$adsDetails->model->name}}/{{@$adsDetails->year}}/{{@$adsDetails->versions->name}}" data-toggle="modal"
                   data-target="#postedcarinfo" data-parsley-error-message="Please Provide Car Info" data-parsley-required="true" data-parsley-trigger="change">
                    <input type="hidden" id="maker" name="maker_id" value="{{$adsDetails->maker_id}}" >
                    <input type="hidden" id="maker_title"value="" >
                    <input type="hidden" id="model" name="model_id" value="{{$adsDetails->model_id}}" >
                    <input type="hidden" id="model_title"value="" >
                    <input type="hidden" id="year"  name="year" value="{{$adsDetails->year}}" >
                    <input type="hidden" id="version"  name="version_id" value="{{$adsDetails->version_id}}" >
                    <input type="hidden" id="version_title" value="" >
                    <input type="hidden" name="ads_id" value="{{$adsDetails->id}}">
                  </div>
              </div>

               <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.body_type')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-md-6 col-sm-7">
                     <select class="form-control select2-field" id="body_type_id" name="body_type_id" data-parsley-error-message="Please select Body Type" data-parsley-required="true" data-parsley-trigger="change">
                       <option value="" disabled selected>{{__('ads.select_one')}}</option>
                 @foreach($bodyTypes as $bodyType)
                    <option value="{{$bodyType->id}}"  @if(old('body_type_id') == $bodyType->id || $adsDetails->body_type_id == $bodyType->id) {{ 'selected' }} @endif>{{__('common.'.str_replace(" ","_",strtolower($bodyType->name)))}}</option>
                 @endforeach
                  </select>
                </div>
              </div>

              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.doors')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-md-6 col-sm-7">
                     <select class="form-control select2-field" id="doors" name="doors" data-parsley-error-message="Please select doors" data-parsley-required="true" data-parsley-trigger="change">
                       <option value="" disabled selected>{{__('ads.select_one')}}</option>
                 
                       <option value="2" @if(old('doors') == 2 || $adsDetails->doors == 2) {{ 'selected' }} @endif>2</option>
                       <option value="3" @if(old('doors') == 3 || $adsDetails->doors == 3) {{ 'selected' }} @endif>3</option>
                       <option value="4" @if(old('doors') == 4 || $adsDetails->doors == 4) {{ 'selected' }} @endif>4</option> 
                   
                  </select>
                </div>
              </div>

              <!-- Modal -->
              <div class="modal fade postformmodal" id="postedcarinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content overflow-hidden">
                    <div class="modal-body overflow-hidden pt-0">
                      <div class="row car-list-row" id="make_years">

                         <div class="col-md-3 col-sm-12 car-info-list-col modal-year-col" style="display: none">
                          <h6 class="post-ad-modal-title d-flex align-items-center mb-4" class="post-ad-modal-title">{{__('common.modal')}} {{__('common.year')}}</h6>
                          <div class="post-modal-list">
                          <ul class="list-unstyled modal-year-listings">
                          @foreach(range(date('Y'), date('Y')-79) as $y)
                          <li class="model_years" data-year="{{$y}}" id="{{$y}}"><a href="JavaScript:Void(0);" class="align-items-center d-flex justify-content-between">{{$y}}
                          <em class="fa fa-angle-right"></em></a></li>
                          @endforeach
                            
                          </ul>
                          </div>
                        </div>
                         <div class="col-md-3 col-sm-12 car-info-list-col version-list-col" style="display: none">
                         </div>
                         

                      </div>
                      <div class="mb-2 mt-4 post-modal-btn text-center">
                        <a href="#" class="btn  themebtn1" data-dismiss="modal">{{__('ads.done')}}</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.mileage')}} (km)<sup class="text-danger">*</sup></label>
                </div>
                 
                <div class="col-md-6 col-sm-7">
                  <input type="text" class="form-control" placeholder="{{__('ads.mileage')}}" data-parsley-error-message="Enter valid mileage (1-1000000)" data-parsley-required="true" data-parsley-trigger="change" name="millage" value="{{$adsDetails->millage}}">
                </div>
              </div> 

              

              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.color')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-md-6 col-sm-7">
                  <select class="form-control" id="color" name="color_id" data-parsley-error-message="Please select Color" data-parsley-required="true" data-parsley-trigger="change">
                    <option value="" disabled selected>{{__('ads.select_one')}}</option>
                    @foreach($colors as $color)
                        <option value="{{$color->id}}"  @if(old('color') == $color->id || $adsDetails->color_id == $color->id) {{ 'selected' }} @endif>{{__('common.'.$color->name)}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.fuel_average')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-md-6 col-sm-7">
                  <input class="form-control" type="text" placeholder="{{__('compare.fuel_average')}}" name="fuel_average"  data-parsley-error-message="{{__('common.please_enter_fuel_average')}}" data-parsley-required="true" data-parsley-trigger="change" required value="{{$adsDetails->fuel_average}}">
                </div>
              </div>

              <div class="form-group mb-4 row">
                <div class="col-lg-6 col-md-4 col-sm-3 mt-sm-1 pt-sm-2 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('common.price')}}(€)<sup class="text-danger">*</sup></label>
                </div>

                <div class="col-md-6 col-sm-7">
                  <input class="form-control" type="text" placeholder="{{__('common.price')}}" name="price"  data-parsley-error-message="Please Enter valid price" data-parsley-required="true" data-parsley-trigger="change"  value="{{$adsDetails->price}}">
                  <div class="pricecheckboxes mt-3">  
                    <div class="custom-control custom-checkbox mt-2">
                      <input type="checkbox" class="custom-control-input" id="pricecheck1" name="vat" value="1" @if($adsDetails->vat == '1') checked @endif >
                      <label class="custom-control-label" for="pricecheck1">{{__('common.incl_20_vat')}}</label>
                    </div>
                    <div class="custom-control custom-checkbox mt-2">
                      <input type="checkbox" class="custom-control-input" id="pricecheck2" name="neg" value="1" @if($adsDetails->neg == '1') checked @endif >
                      <label class="custom-control-label" for="pricecheck2">{{__('common.negotiable')}}</label>
                    </div>
                  </div>
                </div>

              </div> 

        
            </div> 
          </div> 
                 {{-- Desription --}}
@php 
                    $language         = Session::get('language');
                    $activeLanguage   = $language['id'];
                    $suggessions_ads = $adsDetails->suggessions; 
                    @endphp  
              <div class="form-group mb-4 row">
            <div class="col-md-4 mt-md-3 pt-md-2 text-md-right">
              <label class="mb-0 text-capitalize">{{__('ads.ad_description')}}<sup class="text-danger">*</sup></label>
            </div>
            <div class="col-lg-6 col-md-8 col-12">
              <div class="about-message-field text-right font-weight-semibold mb-1">
                <span id="description_count">{{__('ads.remaining_characters')}} 995</span>
                <a href="javascript:void(0)" id="reset" class="reset-message d-inline-block ml-2 themecolor">{{__('ads.reset')}}</a>
              </div>
               <p id="description_error" class="m-0"></p>
              <textarea id="description" class="form-control" rows="6" name="description"  placeholder="Describe your vehicle: Example: Alloy rim, first owner, genuine parts, maintained byauthorized workshop, excellent mileage, original paint etc.">{{@$descript->description}}</textarea>    

              <div class="add-suggestion border mt-2 p-3">
                <p> {{__('ads.you_can_also_use_suggestions')}}</p>
                <div class="suggestions-tags">
                  @foreach($suggestions as $suggestion)
                  <a href="JavaScript:Void(0);" class=""><span class="label label-info bgcolor1 badge badge-pill pl-sm-3 pr-sm-3 pr-2 pl-2 text-white mb-2" data-id="{{$suggestion->id}}" data-sentence="{{$suggestion->sentence}}" onclick="getSentence(this)">{{$suggestion->title}}</span></a>
                  @endforeach

                  @foreach($suggessions_ads as $suggestion)
                   <input type="hidden" name="tags[]" value="{{$suggestion->id}}">
                   <input type="hidden" name="suggessions[]" value="{{$suggestion->sentence}}"> 
                 @endforeach
                </div>
              </div>
              <div class="border border-top-0 pb-2 pl-3 pr-3 pt-2 show-more-suggestion text-center">
                <a href="#" class="font-weight-bold themecolor">{{__('ads.show_more')}}</a>
              </div>
            </div>
          </div>


              {{-- ENDS DESRIPTION --}}
        </div>
        </div>
   <!-- Vehicle Information section ends here -->

  <!-- Additional Information section starts here -->
        <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2 addInformation">
          <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">{{__('ads.additional_information')}}</h4>
          <div class="additional-info">
             
             <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.engine_capacity')}} (cc)<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-md-6 col-lg-5 col-sm-7">
                  <input type="text" class="form-control" name="engine_capacity" id="engine_capacity" placeholder="Engine Capacity* (cc)" value="{{@$adsDetails->versions->cc}}" readonly>
                </div>
             </div> 
             <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.engine_power')}} (KW)<sup class="text-danger">*</sup></label>
                </div>
                
                <div class="col-md-6 col-lg-5 col-sm-7">
                  <input type="text" class="form-control" name="engine_power" id="engine_power" placeholder="engine power (KW)"  value="{{@$adsDetails->versions->kilowatt}}" readonly>
                </div>
             </div>
             <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.engine_type')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-md-6 col-lg-5 col-sm-7">
                  <select name="fuel_type" id="fuel_type" class="form-control">
                    <option value="Petrol" @if(old('fuel_type') == "Petrol" || $adsDetails->fuel_type == "Petrol") {{ 'selected' }} @endif>Petrol</option>
                    <option value="CNG" @if(old('fuel_type') == "CNG" || $adsDetails->fuel_type == "CNG") {{ 'selected' }} @endif>CNG</option>
                    <option value="Diesel" @if(old('fuel_type') == "Diesel" || $adsDetails->fuel_type == "Diesel") {{ 'selected' }} @endif>Diesel</option>
                    <option value="Hybrid" @if(old('fuel_type') == "Hybrid" || $adsDetails->fuel_type == "Hybrid") {{ 'selected' }} @endif>Hybrid</option>
                    <option value="LPG" @if(old('fuel_type') == "LPG" || $adsDetails->fuel_type == "LPG") {{ 'selected' }} @endif>LPG</option>
                  </select>
                </div>
             </div>
             <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.transmission')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-md-6 col-lg-5 col-sm-7">
                  <select name="transmission_type" id="transmission_type" class="form-control">
                    <option value="">{{__('ads.select')}} {{__('ads.transmission')}}</option>
                    <option @if(old('transmission_type') == "Manual" || $adsDetails->transmission_type == "Manual") {{ 'selected' }} @endif>{{__('common.manual')}}</option>
                    <option @if(old('transmission_type') == "Automatic" || $adsDetails->transmission_type == "Automatic") {{ 'selected' }} @endif>{{__('common.automatic')}}</option>
                  </select>
                </div>
             </div>
             <div class="form-group row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <h6>{{__('common.features')}}<sup class="text-danger">*</sup></h6>
                </div>
                <div class="col-lg-7 col-sm-9 features-checkboxes">
                  <div class="row">
                    @php
                    $featuresArray = explode(',',$adsDetails->features);
                    @endphp
                    @foreach($features as $feature)
                    <div class="col-md-4 col-6 form-group mb-1">
                      <div class="custom-control custom-checkbox">
                       <input type="checkbox" class="custom-control-input" id="featurecheck-{{$feature->id}}" name="features[]" value="{{$feature->id}}" @if(in_array($feature->id,$featuresArray)) {{ 'checked' }} @endif>
                       <label class="custom-control-label font-weight-semibold" for="featurecheck-{{$feature->id}}">{{$feature->name}}</label>
                      </div>
                    </div>
                     @endforeach
                  </div>
                </div> 
             </div>      
          </div>
        </div>
   <!-- Additional Information section Ends here -->


  <!-- Upload Photos section starts here -->
        <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2">
        <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">{{__('spareparts.upload_photos')}}</h4>
   
        <div class="row pt-4 pb-4" style="border: 2px dotted skyblue;">
        <div class="col-md-12 text-center">
          <div class="row">
            <div class="col-xs-12 col-md-12">
              <div class="col-md-12 col-lg-12 col-xs-12" id="columns">
               <!--  <h3 class="form-label">Select the images</h3>
                <div class="desc"><p class="text-center">or drag to box</p></div> -->
                <div class="upload-note mt-0 mb-2">
             <!--  {{__('ads.photo_extentions')}}
                <br>
                {{__('ads.can_select_multiple')}}<br><br> -->
                <!-- <button class="btn btn-sm btn-primary uploadBtn">Upload</button> -->
                <span>
                  <img alt="Images" src="https://wsa4.pakwheels.com/assets/photos-d7a9ea70286f977064170de1eeb6dca8.svg">
                <span class="uploadBtn ml-3" style="background-color: #007bff;padding: 10px 10px;color: white;margin-top: 5px;"><i class="fa fa-plus"></i> {{__('common.add_photos')}}</span>
                <p class="m-0" style="margin-left: 100px !important;position: relative;top: -20px;color: #999;">({{__('common.maxlimit_5_mb_per_image')}})</p>
                </span>
            </div>
            <div style="text-align: left;" class="d-none main_cover_photo">
                  <span style="position: absolute;z-index: 1000;margin-left: 10px;margin-top: 17px;color: white;font-weight: bold;">{{__('common.main_cover_photo')}}</span>
                </div>
                <div id="uploads" class="row d-none mt-4"><!-- Upload Content --></div>
            <div class="row" style="margin-top: 50px;margin-bottom: 30px;">
              <div class="col-md-4 offset-1">
                <i class="fa fa-check-circle-o" style="color: #007bff;"></i>
                <strong style="font-size: 13px;">{{__('common.atleast_five')}}</strong>
                 <span style="color:#999;font-size: 13px;">improves the chances for a quick sale.</span>
              </div>  
              <div class="col-md-5 offset-1">
                 <i class="fa fa-check-circle-o" style="color: #007bff;"></i>
                <strong style="font-size: 13px;">Adding clear Front, Back and Interior pictures</strong>
                 <span style="color:#999;font-size: 13px;"> of your car increases the quality of your Ad and gets you noticed more.</span>
              </div>  

               <div class="col-md-5 offset-4 mt-5">
                 <i class="fa fa-check-circle-o" style="color: #007bff;"></i>
                <strong style="font-size: 13px;">Photos should be</strong>
                 <span style="color:#999;font-size: 13px;">   in "jpeg, jpg, png, gif" format only.</span>
              </div>  
            </div>
                
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
        <!-- <div id="image_preview"></div> -->

        <div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
              <div class="row"> 
               @if($adImages)
               @foreach($adImages as $img)
                <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar">
                  <figure class="mb-0 position-relative">
                    <img src="{{url('public/uploads/ad_pictures/cars/'.$img->ad_id.'/'.$img->img)}}" class="img-fluid" alt="carish used cars for sale in estonia">
                    <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                    <span data-id="{{$img->id}}" class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block mt-2">REMOVE</span>
                    </figcaption>
                  </figure>
                </div>
                @endforeach
                @endif
              </div>
            </div>
      </div> 
  <!-- AUpload Photos section Ends here -->

  <!-- Contact Information section starts here -->      
        <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2">
          <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">{{__('ads.contact_information')}}</h4>
          <div class="contact-info">
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.name')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-4 col-sm-6 col-sm-7">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text justify-content-center"><em class="fa fa-user"></em></span>
                    </div> 
                      <input type="text" class="form-control" placeholder="Name" name="poster_name" value='{{$adsDetails->poster_name}}'>
                  </div>
                </div>
            </div> 
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.email')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-4 col-sm-6 col-sm-7">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text justify-content-center"><em class="fa fa-envelope"></em></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Email" name="poster_email" value="{{$adsDetails->poster_email}}">
                  </div>
                </div>
            </div> 
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.phone')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-4 col-sm-6 col-sm-7">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text justify-content-center"><em class="fa fa-phone"></em></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Phone"  name="poster_phone" value="{{$adsDetails->poster_phone}}">
                  </div>
                </div>
            </div> 
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.city')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-4 col-sm-6 col-sm-7">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text justify-content-center"><em class="fa fa-home"></em></span>
                    </div>
                      <select placeholder="Choose one City" class="form-control select2-field" name="poster_city">
                        <option value="" disabled selected>{{__('ads.select_one')}}</option>
                        @foreach($cities as $city)
                        <option value="{{$city->id}}" @if(old('poster_city') == $city->id || $adsDetails->poster_city == $city->id) {{ 'selected' }} @endif>{{$city->name}}</option>
                        @endforeach
                        </select>
                  </div>
                 </div>
                </div>
          </div>
        </div>  
  <!-- Contact Information section ends here -->   


    <div class="border-top mx-n4 pt-4 pt-sm-5 px-4 mt-sm-5 mt-4 text-center">
      <input type="submit" class="btn pb-3 pl-4 post-ad-submit pr-4 pt-3  themebtn1" value="{{__('ads.update')}}">
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
  /* MUTAHIR SCRIPT FOR MAKE MODEL VERSION */
    $(document).ready(function(){
      /* LOAD MAKES AND MODELS */
       $.ajax({
            url: "{{route('maker-list')}}/",
            method: "get",
            success: function (data) {  
              $('#make_years').prepend(data);
            }
        });

      $(document).on( 'click','.makes', function() {       
          $('.make-list-col').removeClass('car-list-active').addClass('prev-list-active');
          $('.modal-list-col').css('display','none').removeClass('car-list-active');
          $('.version-list-col').css('display','none').removeClass('car-list-active');
          $('.modal-year-col').css('display','none').removeClass('car-list-active');
          var make = $(this).data("make");
          var maker_title = $(this).data("title");
          $('#maker').val(make);
          $('#maker_title').val(maker_title);
          $('#version').val(''); 
          $('#model').val('');
          $('#car_info').val(maker_title);  
          $('.models_for_'+make).css('display','block').addClass('car-list-active');
        });

  $(document).on( 'click','.models', function() {
    $('.modal-list-col').removeClass('car-list-active');  
     var model_id      = $(this).data("model");
     var model_title   = $(this).data("title");
     var maker_title   = $('#maker_title').val();
     var model_year  = $('#year').val();
     $('.modal-year-col').css('display','block').addClass('car-list-active');
    $('#version').val(''); 
    $('#model').val(model_id);
    $('#model_title').val(model_title);        
    $('#car_info').val(maker_title+"/"+model_title); 
    });
$(document).on( 'click','.model_years', function() {
    $('.year-list-col').removeClass('car-list-active');
    $('.version-list-col').css('display','none').removeClass('car-list-active');
      var year         = $(this).data("year");
      var maker_title  = $('#maker_title').val();
      var model_title  = $('#model_title').val();
      var model_id     = $('#model').val();
       $('#year').val(year);
      $.ajax({
            url: "{{url('get-models-year-versions')}}/"+model_id+"/"+year,
            method: "get",
            success: function (data) {
              $('.version-list-col').css('display','block').addClass('car-list-active');
              $('.version-list-col').html(data); 
            }
      }); 
    
    });

      $(document).on( 'click','.versions', function() {  
        var version_id    = $(this).data("version");
        var version_title = $(this).data("title");
        var year          = $('#year').val();
        var maker_title   = $('#maker_title').val();
        var model_title   = $('#model_title').val();
        var cc            = $(this).data("cc");
        var power         = $(this).data("power");
        $('#version').val(version_id);
        $('#version_title').val(version_title);
        $('#car_info').val(maker_title+"/"+model_title+"/"+year+"/"+version_title);
        $('.addInformation').show();
        $('#engine_capacity').val(cc);  
        $('#engine_power').val(power);       
        $('#postedcarinfo').modal('hide');        
     });


  
   uploadHBR.init({
    "target": "#uploads",
    "max": 8,
    "textNew": "ADD",
    "textTitle": "Click here or drag to upload an image",
    "textTitleRemove": "Click here to remove the image"
  });

$('#reset').click(function () {
  uploadHBR.reset('#uploads');
});

 $('.uploadBtn').click(function(){
     $('#new_0').trigger('click');
  // $('#prev_0').append('<p style="position:absolute;top:-20px;">Hello </p>');

    setTimeout(function(){ 

     $('#uploads').removeClass('d-none');
     $('.main_cover_photo').removeClass('d-none');
   }, 1000);
  });

   var max  = 995;    
   $("#reset").click(function(){
     $('#description_count').html(max);
     $('#description').val('');
   });

   var text = $('#description').val().length;
   var remaining = max - text;
   $('#description_count').html(remaining);
 $(document).on('click','.featuredlabel',function(e){
    e.preventDefault();
    var img_id = $(this).data('id');
    var ad_id = "{{$adsDetails->id}}";
    swal({
           title: "{{__('ads.you_sure')}}",
          text: "{{__('ads.you_sure_toremove')}}",
          type: "error",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "{{__('ads.yes_do')}}",
          cancelButtonText: "{{__('ads.cancel')}}",
          closeOnConfirm: true,
          closeOnCancel: true
          },
          function (isConfirm) {
              if (isConfirm) {
                 $.ajax({
                    url:"{{route('images.remove')}}",
                        method:"get",
                        dataType:"json",
                        data:{img_id:img_id,
                        ad_id:ad_id},
                        success:function(data){ 
                            if(data.success == true){
                              toastr.success('Success!', "{{__('ads.removed_success')}}",{"positionClass": "toast-botom-right"});
                              location.reload();
                            }
                          },
                          error:function(){
                              alert("{{__('ads.error')}}");
                          }
                          });
              }
              else { 
                  swal("{{__('ads.cancelled')}}", " ", "error");
                  e.preventDefault();
              }
          });
   })
});// EDN DOCUMENT READY FUNCTION
    /* END OF MUTAHIR SCRIPT */
    
        function getCarInfo(e) {

        var year_id = $(e).data('id');
        $.ajax({
            url: "{{url('get-makers-from-year')}}/"+year_id,
            method: "get",
            success: function (data) {
                $('#makers_list').html(data);
                $('#year').val(year_id);
            }
        });


        }

        function getModels(e) {
            var maker_id = $(e).data('id');
            $.ajax({
                url: "{{url('get-models-from-maker')}}/"+maker_id,
                method: "get",
                success: function (data) {
                    $('#models_list').html(data);
                    $('#maker').val(maker_id);
                }
            });

        }

        function fillInfo(e) {
            var model_id = $(e).data('id');
            $('#model').val(model_id);
            $.ajax({
                url : "{{url('fill-input')}}/"+$('#year').val()+"/"+ $('#maker').val() +"/"+ model_id,
                method : "get",
                success: function (data) {
                    $('#car_info').val(data);
                    $('#myModal').modal('hide');
                }
            })

        }
 

        function getSentence(e) {
            var sentence     = $(e).data('sentence');
            var id           = $(e).data('id');    
            var old_sentense = $('#description').val();
            var new_sentense = old_sentense +'.' + sentence;
            $('#description').val(new_sentense);
            var field = '<input type="hidden" name="tags[]" value="'+id+'"><input type="hidden" name="suggessions[]" value="'+sentence+'">';
            $('.suggestions-tags').append(field);
            $(e).hide();
        }


        $("#description").keyup(function (e) {
      $("#description").prop('maxlength', '995');
      var text = $('#description').val().length;
      var remaining = max - text;
      $('#description_count').html(remaining);
      
      if(max == $('#description').val().length){
          $("#description_error").html("Maximun letter 995").show().fadeOut("slow");
                return false;
        }
    });


        function getSubCategory(e) {
            var cat_id = $(e).data('id');
            var cat_title = $(e).data('title');

            $('#category_id').val(cat_title);

            $.ajax({
                url: "{{url('get-subcategories')}}/"+cat_id,
                method: "get",
                success: function (data) {
                    $('#sub_category_list').html(data);
                }
            });

        }

        function selectCategory(e) {
            var sub_category_id = $(e).data('id');
            $('#sub_category').val(sub_category_id);
            var display_value = $('#category_id').val()+'/'+$(e).data('title');
            $('#categories').val(display_value);
            $('#categoriesModal').modal('hide');
        }


        $(function () {

  $('.gobackIcon').on('click', function () {
  $(this).parents('.car-info-list-col').hide();
  $(this).parents('.car-info-list-col').prev('.car-info-list-col').show().removeClass('prev-list-active');
  });

  $('.car-info-list-col:not(:last-child) li a').on('click', function () {
    $(this).parents('.car-info-list-col').removeClass('car-list-active').next('.car-info-list-col').addClass('car-list-active').show().prev('.car-info-list-col').addClass('prev-list-active');
    $(this).parents('li').addClass('list-active').siblings('li').removeClass('list-active');
    $(this).parents('.car-info-list-col').siblings('.car-info-list-col').find('li').removeClass('list-active');
  });
});

 

</script>
@endpush
@endsection