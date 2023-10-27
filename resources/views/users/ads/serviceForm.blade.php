@extends('layouts.app')
@section('title') {{ __('postOfferServiceAdPage.pageTitle') }} @endsection
@section('content')
  @push('styles') 
    <style type="text/css">
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

      /*for loader*/
      .loader {
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #3498db;
      width: 80px;
      height: 80px;
      -webkit-animation: spin 2s linear infinite; /* Safari */
      animation: spin 2s linear infinite;
      margin: auto;
      margin-top: 100px;
      }

      /* Safari */
      @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
      }

      @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
      }

      /*for loader*/
      .loader_2 {
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #3498db;
      width: 80px;
      height: 80px;
      -webkit-animation: spin 2s linear infinite; /* Safari */
      animation: spin 2s linear infinite;
      margin: auto;
      margin-top: 100px;
      }

      /* Safari */
      @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
      }

      @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
      }

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
    </style>
  @endpush  
  @php 
    $activeLanguage = \Session::get('language');
  @endphp
<div class="internal-page-content mt-4 pt-lg-5 pt-4 sects-bg">
  <div class="container pt-2">
    @if(count($errors) > 0)
    <div class="alert alert-danger">Error<br><br>
      <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
    </div>
   @endif
   <div class="alert alert-danger alert-dismissable print-error-message" style="display:none">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <ul class="error-msg"></ul>
    </div>
    <div class="row ml-0 mr-0 post-an-ad-row">
      <div class="col-12 bg-white p-md-4 p-3 pb-sm-5 pb-4">
      <h2 class="border-bottom mx-md-n4 mx-n3 pb-3 px-md-4 px-3 mb-sm-5 mb-4 themecolor">{{__('postOfferServiceAdPage.postAnOfferService')}}</h2>
      <form action="{{url('user/save-service')}}" method="post" id="myForm" class="form-horizontal" enctype="multipart/form-data" data-parsley-validate >
      {{csrf_field()}}
      <!-- Vehicle Information section starts here -->
      <div class="post-an-ad-sects">
        <h4 class="mx-md-n4 mx-n3 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">{{__('postOfferServiceAdPage.serviceInformation')}}</h4>
        <div class="vehicleInformation">
          <div class="mb-3 row">
           <div class="ml-auto mr-auto col-lg-4 col-md-6 col-12 mandatory-note font-weight-semibold">
            <span>({{__('postOfferServiceAdPage.mandatoryFeilds')}})</span>
          </div>
        </div>
          <div class="row">
          <div class="col-lg-8 col-12">
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-2 text-sm-right text-md-right">
                <label class="mb-0 text-capitalize">{{__('postOfferServiceAdPage.title')}}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-sm-7">
                <p id="title_error" class="m-0"></p>
                <input type="text" name="title" class="form-control" placeholder="{{__('postOfferServiceAdPage.titleDefaultText')}}" data-parsley-error-message="Please select Product Name" data-parsley-required="true" data-parsley-trigger="change" autocomplete="off" id="title">
                <div class="about-message-field mt-1">
                    <span class="font-weight-semibold">{{__('postOfferServiceAdPage.remainingChar')}} <span id="title_count">50</span></span>
                </div>
              </div>
            </div>
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{__('postOfferServiceAdPage.serviceType')}}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-sm-7">
                <input type="text" class="form-control" id="categories" autocomplete="off"   placeholder="{{__('postOfferServiceAdPage.serviceTypeDefaultText')}}" data-toggle="modal" name="spare_categories" data-target="#category-subcategory" data-parsley-error-message="Please Provide Service Info" data-parsley-required="true" data-parsley-trigger="change" >
                <input type="hidden" name="category_id" id="category_id" value="">
                <input type="hidden" name="sub_category_id" id="sub_category_id" value="">
                <input type="hidden" name="sub_sub_category_id" id="sub_sub_category_id" value="">

                <input type="hidden" name="category" id="category" value="">
                <input type="hidden" name="sub_category" id="sub_category" value="">
                <input type="hidden" name="sub_sub_category" id="sub_sub_category" value="">

                <input type="hidden" name="all_ids" value="" id="all_ids">
                <input type="hidden" name="make_all_ids" value="" id="make_all_ids">
                <input type="hidden" name="make_sub_id" id="make_sub_id">
                <div class="chosen_sub"></div>
              </div>
            </div>
            <div class="modal fade postformmodal" id="category-subcategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content overflow-hidden">
                  <div class="modal-body overflow-hidden pt-0">
                    <div class="row car-list-row">
                      <div class="col-md-4 col-sm-12 car-info-list-col car-list-active services-catg-col">
                        <h6 class="post-ad-modal-title d-flex align-items-center mb-4" class="post-ad-modal-title">{{__('postOfferServiceAdPage.serviceTypePopupCategory')}}</h6>
                        <div class="post-modal-list">                      
                          <ul class="list-unstyled modal-year-listings">
                          @foreach($primaryServices as $category)
                            @php 
                              $skips = ["[","]","\""];
                              $p_caty = ($category->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first());
                            @endphp
                            <li onclick="getSubCategory(this)" data-title="{{$category->title}}" data-id="{{$category->id}}"><a class="align-items-center d-flex justify-content-between" href="JavaScript:Void(0);">{{$p_caty[0] !== null ? $p_caty : $category->title}} <em class="fa fa-angle-right"></em></a></li>
                          @endforeach
                        </ul>                    
                      </div>
                      </div>

                      <div class="col-md-4 col-sm-12 car-info-list-col car-list-active second-last-record services-sub-catg-col"  style="display: none">
                        <h6 class="post-ad-modal-title d-flex align-items-center mb-4" class="post-ad-modal-title">
                          <em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>{{__('postOfferServiceAdPage.serviceTypePopupSubCategory')}}
                        </h6>
                        <div class="post-modal-list">
                          <div class="loader d-none"></div>
                          <ul class="list-unstyled modal-year-listings sub_clear" id="sub_category_list_2"></ul>
                        </div>
                      </div>

                      <div class="col-md-4 col-sm-12 car-info-list-col version-list-col d-none last-record">
                        <h6 class="post-ad-modal-title d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> {{__('postOfferServiceAdPage.serviceTypePopupDetail')}}</h6>
                        <div class="post-modal-list">
                          <div class="loader_2 d-none"></div>
                          <ul class="list-unstyled version-listings sub_clear_2" id="subservice_cat"></ul>
                        </div>
                      </div>

                    </div>
                    <div class="mb-2 mt-4 post-modal-btn text-center"><!--  onclick="displayCategory(this)" -->
                      <a href="#" class="btn themebtn1 disabled" data-dismiss="modal" id="done" >{{__('postOfferServiceAdPage.categoryPopupButtonText')}}</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end modal -->
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{__('postOfferServiceAdPage.companyName')}}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-sm-7">
                <input type="text" class="form-control" value="{{@$customer->customer_company}}" readonly="true" placeholder="{{__('postOfferServiceAdPage.companyName')}}">
              </div>
            </div>
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{__('postOfferServiceAdPage.address')}}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-sm-7">
                <!-- <input type="text" class="form-control" placeholder="Address"> -->
                <input type="text" class="form-control" value="{{@$customer->customer_default_address}}" readonly="true" name="address" placeholder="{{__('postOfferServiceAdPage.address')}}"  data-parsley-error-message="Address Name" data-parsley-required="true" data-parsley-trigger="change">

              </div>
            </div>
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{__('postOfferServiceAdPage.regNumber')}}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-sm-7">
                <input type="text" class="form-control" value="{{@$customer->customer_registeration}}" readonly="true" placeholder="{{__('postOfferServiceAdPage.regNumber')}}">
              </div>
            </div>
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{__('postOfferServiceAdPage.vat')}}</label>
              </div>
              <div class="col-md-6 col-sm-7">
                <input type="text" class="form-control" value="{{@$customer->customer_vat}}" readonly="true" placeholder="{{__('postOfferServiceAdPage.vat')}}">
              </div>
            </div>
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{__('postOfferServiceAdPage.phoneNum')}}<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-sm-7">
                <!-- <input type="tel" class="form-control" placeholder="03439088607"> -->
                <input type="tel" class="form-control" value="{{@$customer->customers_telephone}}" readonly="true" name="phone" placeholder="03439088607"  data-parsley-error-message="Phone Number" data-parsley-required="true" data-parsley-trigger="change">

              </div>
            </div>
            <div class="align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                <label class="mb-0">{{__('postOfferServiceAdPage.website')}}</label>
              </div>
              <div class="col-md-6 col-sm-7">
                <!-- <input type="text" class="form-control" placeholder="Website"> -->
                <input type="text" class="form-control" value="{{@$customer->website}}" readonly="true" placeholder="{{__('postOfferServiceAdPage.website')}}" name="website"  data-parsley-error-message="Website Name" data-parsley-required="true" data-parsley-trigger="change">

              </div>
            </div>
          </div>
          <div class="col-md-4 ad-publishing-plolicy d-lg-block d-none">
            <div class="ad-publishing-plolicy-bg border p-lg-4 p-3">
             <h5>{{@$page_description->title}}</h5>
              <p class="mb-2 pb-1">{!!@$page_description->description!!}</p>
            </div>
          </div>
        </div>
          @foreach($timings as $time)
          <div class="form-group mb-4 row align-items-center ">
          <div class="col-md-4 col-sm-3 text-sm-right">
            <label class="mb-0 control-label">{{__('postOfferServiceAdPage.workingHours')}}<sup class="text-danger">*</sup></label>
          </div>
          <div class="col-lg-5 col-md-8 col-sm-8 col-12">
            <div class="row form-row working-hours-fields">
              <div class="col">
                <select name="" class="form-control">
                  <option selected="true" disabled="true">{{$time->day_name}}</option>
                </select>
              </div>
              <div class="col">
                <input type="time" class="form-control" value="{{@$time->opening_time}}" readonly="true" name="opening_time[]" placeholder="Opening Time">
              </div>
              <div class="col">
                <input type="time" class="form-control" value="{{@$time->closing_time}}" readonly="true" name="closing_time[]" placeholder="Closing Time">
              </div>
            </div>
          </div>
        </div>
          @endforeach
          <div class="form-group mb-4 row">
          <div class="col-md-4 text-md-right">
            <label class="mb-0">{{__('postOfferServiceAdPage.adDescription')}}<sup class="text-danger">*</sup></label>
          </div>
          <div class="col-lg-6 col-md-8 col-12">
            <p id="description_error" class="m-0"></p>
              <textarea id="description" class="form-control" rows="5" placeholder="{{__('postOfferServiceAdPage.adDescriptionDefaultText')}}" name="description" data-parsley-error-message="Description" data-parsley-required="true" data-parsley-trigger="change">{{@$service_description->description}}</textarea>
            <div class="about-message-field mt-1">
              <span class="font-weight-semibold">{{__('postOfferServiceAdPage.remainingChar')}} <span id="description_count">995</span></span>
            </div>
          </div>
        </div>  
          <!-- Upload Photos section starts here -->
          <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2">

          <div class="alert alert-danger alert-dismissable print-error-msg" style="display:none">
              <ul class="error-msg"></ul>
            </div>

          <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">{{__('postOfferServiceAdPage.uploadPhotos')}}</h4>
          <div class="row pt-4 pb-4" style="border: 2px dotted skyblue;">
            <div class="col-md-12 text-center">
              <div class="row">
                <div class="col-xs-12 col-md-12">
                  <div class="col-md-12 col-lg-12 col-xs-12" id="columns">
                    <div class="upload-note mt-0 mb-2">
                      <span>
                        <img alt="Images" src="https://wsa4.pakwheels.com/assets/photos-d7a9ea70286f977064170de1eeb6dca8.svg">
                        <span class="uploadBtn ml-3" style="background-color: #007bff;padding: 10px 10px;color: black;margin-top: 5px;"><i class="fa fa-plus"></i> {{__('postOfferServiceAdPage.uploadPhotosButtonText')}}</span>
                        <p class="m-0" style="margin-left: 100px !important;position: relative;top: -20px;color: #999;">({{__('postOfferServiceAdPage.uploadPhotosButtonDetailText')}})</p>
                      </span>
                    </div>
                    <div style="text-align: left;" class="d-none main_cover_photo">
                      <span style="position: absolute;z-index: 1000;margin-left: 10px;margin-top: 16px;color: white;font-weight: bold;">Main Cover Photo</span>
                    </div>
                    <div id="uploads" class="row d-none mt-4"><!-- Upload Content --></div>
                    <div class="row" style="margin-top: 50px;margin-bottom: 30px;">
                      <div class="col-md-4 offset-1">
                        <i class="fa fa-check-circle-o" style="color: #007bff;"></i>
                        <strong style="font-size: 13px;">{{__('postOfferServiceAdPage.add5PicsBold')}}</strong>
                        <span style="color:#999;font-size: 13px;">{{__('postOfferServiceAdPage.add5PicsNormal')}}</span>
                      </div>  
                      <div class="col-md-5 offset-1">
                        <i class="fa fa-check-circle-o" style="color: #007bff;"></i>
                        <strong style="font-size: 13px;">{{__('postOfferServiceAdPage.addClearPicsBold')}}</strong>
                        <span style="color:#999;font-size: 13px;"> {{__('postOfferServiceAdPage.addClearPicsNormal')}}</span>
                      </div>  
                     <div class="col-md-5 offset-4 mt-5">
                      <i class="fa fa-check-circle-o" style="color: #007bff;"></i>
                      <strong style="font-size: 13px;">{{__('postOfferServiceAdPage.photoFormatBold')}}</strong>
                      <span style="color:#999;font-size: 13px;">   {{__('postOfferServiceAdPage.photoFormatNprmal')}}</span>
                    </div>  
                  </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>
        </div>  
        </div>
      </div> 
      
      <!-- Payment section start -->
      <div class="payment-section mt-4">
        <div class="payment-header">
            <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">Payment</h4>
        </div>
        <div class="payment-body">
            <div class="current-balance">
                <h6>Current account balance: 30 &euro;</h6>
            </div>
            <div class="payment-info">
                <div class="row payment-method">
                    <div class="payment-btn">
                        <input type="submit" class="btn post-ad-submit" value="Ad Payment">
                    </div>
                    <div class="payment-text">
                        <div class="p1">
                            <p>Post your add for 7, 15 or 30 days</p>
                        </div>
                        <div class="pay-dropdown">
                            <select name="" id="">
                                <option value="10">7 days - 10 &euro;</option>
                                <option value="15">15 days - 15 &euro;</option>
                                <option value="30">30 days - 30 &euro;</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row payment-method">
                    <div class="payment-btn">
                        <input type="submit" class="btn btn-sechondary post-ad-submit " value="Featured Ad">
                    </div class="p1">
                    <div class="payment-text">
                        <div>
                            <p>Have your add appear at the top of the category listing for 3, 7 or 14 days</p>
                        </div>
                        <div class="pay-dropdown">
                            <select name="" id="">
                                <option value="10">3 days - 10 &euro;</option>
                                <option value="15">7 days - 15 &euro;</option>
                                <option value="30">14 days - 30 &euro;</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Payment section end -->

      <div class="border-top mx-n4 pt-4 pt-sm-5 px-4 mt-sm-5 mt-4 text-center">
        <input type="submit" class="btn pb-3 pl-4 post-ad-submit pr-4 pt-3  themebtn1" value="{{__('postOfferServiceAdPage.submitButtonText')}}">
      </div>
      </form>
    </div>
    </div>
  </div>
</div>
<!-- Feature Modal -->
<div class="modal" id="featureModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">{{__('paymentPopup.pageTitle')}}</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="featured_request_form">
        {{csrf_field()}}
        <div class="modal-body">
          <div class="row">
            <p style="font-style: italic;font-weight: 400;color: red;padding-left: 35px;">{{__('paymentPopup.message')}}</p>
          </div>

          <div class="alert alert-danger alert-dismissable" id="carnumber-error" style="display:none">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <span class="carnumber-error" style="margin-left: 30px;">{{__('paymentPopup.daysEmptyErrorMsg')}}</span>
          </div>

          @if(@$credit>0)
          <div style="display:block;padding-left: 20px;">
            <input type="checkbox" name="use_balance" class="use_balance">
            <span class="ml-2">{{__('paymentPopup.useAccountBalance')}}</span>
          </div>
          @endif

          <input type="hidden" name="ad_id" class="featured_ad_id" value="{{@$ad->id}}">
          <div class="ad" style="padding: 0 20px;box-shadow: 0px 5px 0px 0px rgba('0,0,0,0.25');">
            <div class="input-group" id="car_data" style="border: none;margin-top: 40px;margin-left: 30%;">
              <span style="background-color: white;width: 30%;border-top-left-radius: 5px;border-bottom-left-radius: 5px;border: 1px solid #aaa;border-right: none;padding-left: 5px;line-height: 2;font-weight: 600;" class="feature_span">{{__('paymentPopup.postAdForDays')}} </span>
              <select name="featured_days" id="featured_days" style="width: 20%;height: 33px;border-left: none;" class="feature_select">
                <option value="">***{{__('paymentPopup.select')}} {{__('paymentPopup.days')}}***</option>
                @foreach($ads_pricing as $pricing)
                  <option value="{{$pricing->number_of_days}}">{{$pricing->number_of_days}} {{__('paymentPopup.days')}} {{$pricing->pricing}} €</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer" style="justify-content: center;border-top: none;">
            <button data-dismiss="modal" aria-label="Close" type="button" class="btn btn-danger discard_ad" data-id="{{@$ad->id}}" style="background-color: #eeefff;border: 1px solid #ccc;color: black;">{{__('paymentPopup.exitButtonText')}}</button>
            <button type="submit" class="btn themebtn3">{{__('paymentPopup.submitButtonText')}}</button>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="sparePartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">{{__('paymentPopup.paymentDone')}}</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" name="invoice_number_form" id="invoice_number_form" action="{{route('download-pdf')}}" target="_blank">
        @csrf
        <input type="hidden" name="invoice_number" class="invoice_number">
        <div class="modal-body">
          <div class="row">
            <p style="font-style: italic;font-weight: 400;color: red;padding-left: 35px;">{{__('paymentPopup.printYourInvoice')}}<br>{{__('paymentPopup.continueSparepart')}}</p>
          </div>
          <div class="modal-footer" style="justify-content: center;border-top: none;">
            <button type="submit" class="btn btn-primary" id="print">{{__('paymentPopup.postSparepart')}}</button>
            <button type="submit" class="btn themebtn3" id="print_invoice">{{__('paymentPopup.printInvoice')}}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- export pdf form ends -->

   @push('scripts')
   {{-- UploadHBR --}}
    <script src="{{ asset('public/js/uploadHBR.min.js') }}"  ></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){

      $(document).on('focus', ':input', function() {
            $(this).attr('autocomplete', 'off');
          });

      $('.uploadBtn').click(function(){
          $('#new_0').trigger('click');
            setTimeout(function(){
              $('#uploads').removeClass('d-none');
              $('.main_cover_photo').removeClass('d-none');
            }, 1000);
        });
      $('input').attr('autocomplete','nope');
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
      $("#description").prop('maxlength', '995');
      var max = 995;
      var text = $('#description').val().length;
      var remaining = max - text;
      $('#description_count').html(remaining);

      $("#title").prop('maxlength', '50');
      var max = 50;
      var text = $('#title').val().length;
      var remaining = max - text;
      $('#title_count').html(remaining);

      $("#myForm").validate({
        rules: {
          title:{
            required:true
          },
          product_code:{
            required: true
          },
          city:{
            required: true
          },
          spare_categories:{
            required: function(element){
            if($("#category_id").val() == '' || $("#all_ids").val() == ''){
            return true;
            } else{
            return false;
            }     
          }
          },
          condition:{
            required:true
          },
          price: {
            required: true
          },
          fuel_average: {
            required: true
          },
          price:{
            required:true
          },
          description:{
            required:true
          },
          engine_capacity:{
            required:true
          },
          engine_power:{
            required:true
          },
          "file[]": {
                     required: true
                  },
          poster_city:{
            required:true
          }
          
        },
        messages: {
        title: "{{__('postOfferServiceAdPage.pleaseEnterTitle')}}",
        product_code: "{{__('postOfferServiceAdPage.pleaseSelectProductCode')}}",
        city: "{{__('postOfferServiceAdPage.pleaseSelectCity')}}",
        spare_categories: "{{__('postOfferServiceAdPage.pleaseSelectServices')}}",
        condition: "{{__('postOfferServiceAdPage.pleaseSelectCondition')}}",
        price: "{{__('postOfferServiceAdPage.pleaseEnterPrice')}}",
        description: "{{__('postOfferServiceAdPage.pleaseEnterDescription')}}",
        "file[]":"{{__('postOfferServiceAdPage.pleaseSelectAtLeastOnePhoto')}}",
        poster_city: "{{__('postOfferServiceAdPage.pleaseSelectPosterCity')}}"
      },
        submitHandler: function(form) {

          var number_of_days = $("[name=number_of_days]").val();
          if (typeof number_of_days == 'undefined') {
              $.ajax({
                url: "{{route('check_service_numbers')}}",
                type: 'GET',
                beforeSend: function() {
                  $("#overlay").fadeIn(300);
                },
                success: function(response) {
                  $("#overlay").fadeOut(300);
                  if (response.pay == true) {
                    $('#featureModal').modal('show');
                    $('.post-ad-submit').addClass('disabled');
                    return false;
                  } else {
                    $('.post-ad-submit').removeClass('disabled');
                    $('#featureModal').modal('hide');
                    $.ajax({
                      url: form.action,
                      type: form.method,
                      data: $(form).serialize(),
                      beforeSend: function() {
                        $("#overlay").fadeIn(300);
                      },
                      success: function(response) {
                        $("#overlay").fadeOut(300);
                        window.location = "{{route('my-services-ads')}}?status=0";
                      }
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                      $("#overlay").fadeOut(100);
                      if (jqXHR.status === 422) {
                        var errors = $.parseJSON(jqXHR.responseText);
                        printErrorMsg(errors);
                      }
                    });
                  } // END ELSE
                } // END SUCCESS
              });
            } // END typeof number_of_days == 'undefined'
          else { 
              $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                beforeSend: function() {
                  $("#overlay").fadeIn(100);
                },
                success: function(response) {
                  $("#overlay").fadeOut(100);
                  $('.invoice_number').val(response.invoice_id);
                  if (response.payment_status != 'full') {
                    $("#invoice_number_form").submit();
                  }
                  window.location = "{{route('my-services-ads')}}?status=0";
                }
              });
            } // END ELSE
        }// END SUBMIT HANDLER
      }); 
    }); 



    function printErrorMsg(errors, cssClass = '') {
      $('html, body').animate({
        scrollTop: $(".print-error-msg").offset().top
      }, 200);
      $(cssClass + " .print-error-msg").find("ul").html('');
      $(cssClass + " .print-error-msg").css('display', 'block');
      $(cssClass + " .print-error-message").find("ul").html('');
      $(cssClass + " .print-error-message").css('display', 'block');
      $.each(errors, function(key, value) {
        $(cssClass + ' .print-error-msg').remove("alert-success");
        $(cssClass + ' .print-error-msg').addClass("alert-danger");
        $(cssClass + ' .print-error-message').remove("alert-success");
        $(cssClass + ' .print-error-message').addClass("alert-danger");
        if ($.isPlainObject(value)) {
          $.each(value, function(key, value) {
            $(cssClass + " .print-error-msg").find("ul").append('<li>' + value + '</li>');
          });
        } else {
          $(cssClass + " .print-error-message").find("ul").append('<li>' + "{{__('postOfferServiceAdPage.message')}}" + '</li>'); //this is my div with messages
        }
      });
    }

    $(".featured_request_form").on('submit', function(e) {
      e.preventDefault();
      var use_balance = $('.use_balance').val();
      var featured_days = $('#featured_days').val();
      if (featured_days == '') {
        $("#carnumber-error").show();
        return false;
      } else {
        $('#myForm').find('.number_of_days').remove();
        $('#myForm').find('#use_balance').remove();
        if (use_balance == 'on') {
          $('#myForm').append('<input type="hidden"  name="use_balance" id="use_balance" value="' + use_balance + '" />');
        }

        $('#myForm').append('<input type="hidden" class="number_of_days" name="number_of_days" id="number_of_days" value="' + featured_days + '" />');
        $("#carnumber-error").hide();
        $('#myForm').submit();
      }

    });

    var ids = [];
    var make_ids = [];
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

      $(document).on('click', '.car-info-list-col ul.version-listings li', function() {
        // alert('finaaly');
        $('ul.version-listings li').removeClass('list-active');
        $(this).addClass(' list-active');
      });
      
    });
    function getSubCategory(e) {
      $('#categories').val('');
      $('#category').val('');
      $('#sub_category').val('');
      var cat_id = $(e).data('id');
      var cat_title = $(e).data('title');
      $('#category_id').val(cat_id);
      $('.chosen_sub').empty();
      document.getElementById('all_ids').value = '';
      ids = [];
      var display_value = $('#category_id').val();
      $('#category').val(cat_title);
        $.ajax({
          url: "{{url('user/get-subcategories')}}/"+cat_id,
          method: "get",
          beforeSend: function(){
          $('.sub_clear').empty();
          $('.loader').removeClass('d-none');
        },
          success: function (data) {
            $('.last-record').addClass('d-none');
            $('#sub_category_list').html(data);
            $('#sub_category_list_2').html(data);
            $('.loader').addClass('d-none');
          }
        });
    }
    function selectCategory(e) {

      //$('#done').removeClass('disabled');

      $('#sub_category').val('');
      var sub_category_id = $(e).data('id');
      $('#sub_category_id').val(sub_category_id);
      var title = $(e).data('title');
      $('#sub_category').val(title);
      document.getElementById('all_ids').value = '';
      ids = [];

      $.ajax({
        url: "{{url('user/get-sub-subcategories')}}/"+sub_category_id,
        method: "get",
        beforeSend: function(){
        $('.sub_clear_2').empty();
        $('.loader_2').removeClass('d-none');
        },
        success: function (data) {
          console.log(data);
          $('.last-record').removeClass('d-none');
          $(e).addClass('list-active').siblings('li').removeClass('list-active');
          $('.last-record').addClass('car-list-active');
          $('.second-last-record').removeClass('car-list-active');
          $('#subservice_cat').html(data);
          if(data.id != null){
            document.getElementById('make_sub_id').value = data.id;
          } 
          $('.loader_2').addClass('d-none');
        }
      });
    }
    function selectSubCategory(e){
      
      
      $('#sub_sub_category_id').val('');
      var id = $(e).data('id');
      $('#sub_sub_category_id').val(id);

      $('#sub_sub_category').val('');  
      var title = $(e).data('title');
      $('#sub_sub_category').val(title);



      var display_value = $('#category').val()+'/'+$('#sub_category').val()+'/'+$('#sub_sub_category').val();
      $('#categories').val(display_value);
    }
    function displayCategory(e){
      var display_value = $('#category').val()+'/'+$('#sub_sub_category').val()+'/'+$('#sub_sub_category').val();
      $('#categories').val(display_value);
    }
    $(document).on('click','.sub_services',function(){
      var thisPointer = $(this);
      var value = thisPointer.val();
      if($(this).prop("checked") == true){
        ids.push(thisPointer.val());
        document.getElementById('all_ids').value = ids;
      }
      else if($(this).prop("checked") == false){
        var index = ids.indexOf(thisPointer.val());
        if (index > -1) {
          ids.splice(index, 1);
          document.getElementById('all_ids').value = ids;
        }
      }
    });
    $(document).on('click','.make_sub_services',function(){
      var thisPointer = $(this);
      var value = thisPointer.val();
      var cat = $('#make_sub_id').val();     
        if($(this).prop("checked") == true){
          ids.push('m_'+cat+'_'+thisPointer.val());
            document.getElementById('all_ids').value = ids;
        }
        else if($(this).prop("checked") == false){
          var index = ids.indexOf(thisPointer.val());
          if(index > -1) {
            ids.splice(index, 1);
            document.getElementById('all_ids').value = ids;
          }
        }
    });
    $("#categories").keypress(function(e){
      var keyCode = e.which; 
      return false; 
    });

    $("#categories").click(function(e){
      $("#done").addClass("disabled");
    });

    $("#categories").bind("contextmenu", function(e) {
         e.preventDefault();
     });
    $("#description").keyup(function (e) {   
    $("#description").prop('maxlength', '995');
      var max = 995;
      var text = $('#description').val().length;
      var remaining = max - text;
      $('#description_count').html(remaining);
      if(max < $('#description').val().length){
        $("#description_error").html("Maximun letter 995").show().fadeOut("slow");
          return false;
      }
   });
    $("#title").keyup(function(e) {
        $("#title").prop('maxlength', '50');
        var max = 50;
        var text = $('#title').val().length;
        var remaining = max - text;
        $('#title_count').html(remaining);

        if (max < $('#title').val().length) {
          $("#title_error").html("Maximun letter 50").show().fadeOut("slow");
          return false;
        }
    });
      
    </script>
    @endpush
@endsection