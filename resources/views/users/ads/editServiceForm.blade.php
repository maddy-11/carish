@extends('layouts.app')
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

  .uploadBtn:hover {
    cursor: pointer;
  }

  .cover_photo {
    color: red;
    position: absolute;
    top: 0;
    z-index: 1000;
  }

  #image_preview {

    border: 1px solid #eee;

    padding: 10px;

  }
  .featuredlabel{
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
    <div class="alert alert-danger">
      Error<br><br>
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
        <form action="{{url('user/update-service')}}" method="post" id="myForm" class="form-horizontal" enctype="multipart/form-data" data-parsley-validate>
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
                      <input type="text" name="title" class="form-control" placeholder="{{__('spareparts.title')}}" data-parsley-error-message="Please select Service Name" data-parsley-required="true" data-parsley-trigger="change" value="{{@$service_title->title}}" id="title">
                      <div class="about-message-field mt-1">
                        <span class="font-weight-semibold">{{__('spareparts.remainingChar')}} <span id="title_count">50</span></span>
                        </div>
                    </div>
                  </div>
                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0">{{__('postOfferServiceAdPage.serviceType')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">

                      <input type="text" class="form-control" id="categories" autocomplete="off" placeholder="{{@$service_type}}" data-toggle="modal" name="spare_categories" data-target="#category-subcategory" data-parsley-error-message="Please Provide Service Info" data-parsley-required="true" data-parsley-trigger="change" value="{{@$services->get_category($services->primary_service_id,$activeLanguage['id'])}}" disabled="true">
                      <input type="hidden" name="service_id" value="{{$id}}">
                      <input type="hidden" name="category" id="category_id" value={{@$services->primary_service_id}}">
                      <input type="hidden" name="sub_category" id="sub_category">
                      <input type="hidden" name="sub_sub_category" id="sub_sub_category">
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
                          <div class="row" style="background: #f5f5f5;text-align: center;">
                            <h5 style="width: 100%;color: #aaa;padding: 5px;">{{@$services->primary_service->title}}</h5>
                          </div>
                          <div class="row car-list-row">
                            <div class="col-md-4 col-sm-12 car-info-list-col car-list-active services-catg-col d-none">
                              <h6 class="post-ad-modal-title d-flex align-items-center mb-4" class="post-ad-modal-title">{{__('postOfferServiceAdPage.serviceTypePopupCategory')}}</h6>
                              <div class="post-modal-list">


                                <!--  <ul class="list-unstyled modal-year-listings">
                         @foreach($primaryServices as $category)
                         @if(@$category->id == $services->primary_service_id)
                                        <li onclick="getSubCategory(this)" data-title="{{$category->title}}" data-id="{{$category->id}}" class="list-active" id="primary_service_{{$services->primary_service_id}}"><a class="align-items-center d-flex justify-content-between" href="JavaScript:Void(0);">{{$category->title}} <em class="fa fa-angle-right"></em></a></li>
                          @else
                                 <li data-title="{{$category->title}}" data-id="{{$category->id}}"><a class="align-items-center d-flex justify-content-between" href="JavaScript:Void(0);">{{$category->title}} <em class="fa fa-angle-right"></em></a></li>
                          @endif
                                    @endforeach
                    </ul>
                     -->
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-12 car-info-list-col car-list-active second-last-record services-sub-catg-col" style="">
                              <h6 class="post-ad-modal-title d-flex align-items-center mb-4" class="post-ad-modal-title"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> {{__('postOfferServiceAdPage.serviceTypePopupSubCategory')}}</h6>
                              <div class="post-modal-list">


                                <ul class="list-unstyled modal-year-listings" id="sub_category_list_2">
                                  @foreach($service_categories as $category)
                                  <li onclick="selectCategory(this)" data-title="{{$category->title}}" data-id="{{$category->id}}" class="" id=""><a class="align-items-center d-flex justify-content-between" href="JavaScript:Void(0);">{{$category->title}} <em class="fa fa-angle-right"></em></a></li>
                                  @endforeach
                                </ul>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-12 car-info-list-col version-list-col d-none last-record">
                              <h6 class="post-ad-modal-title d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> {{__('postOfferServiceAdPage.serviceTypePopupDetail')}}</h6>
                              <div class="post-modal-list">

                                <ul class="list-unstyled version-listings" id="subservice_cat">

                                </ul>


                              </div>
                            </div>

                          </div>
                          <div class="mb-2 mt-4 post-modal-btn text-center">
                            <a href="#" class="btn  themebtn1" data-dismiss="modal">{{__('postOfferServiceAdPage.categoryPopupButtonText')}}</a>
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
                      <input type="text" class="form-control" value="{{@$customer->customer_default_address}}" readonly="true" name="address" placeholder="{{__('postOfferServiceAdPage.address')}}" data-parsley-error-message="Address Name" data-parsley-required="true" data-parsley-trigger="change">

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
                      <input type="tel" class="form-control" value="{{@$customer->customers_telephone}}" readonly="true" name="phone" placeholder="03439088607" data-parsley-error-message="Phone Number" data-parsley-required="true" data-parsley-trigger="change">

                    </div>
                  </div>
                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0">{{__('postOfferServiceAdPage.website')}}</label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <!-- <input type="text" class="form-control" placeholder="Website"> -->
                      <input type="text" class="form-control" value="{{@$customer->website}}" readonly="true" placeholder="{{__('postOfferServiceAdPage.website')}}" name="website" data-parsley-error-message="Website Name" data-parsley-required="true" data-parsley-trigger="change">

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
                      <input type="text" class="form-control" value="{{@$time->opening_time}}" readonly="true" name="opening_time[]" placeholder="Opening Time">
                    </div>
                    <div class="col">
                      <input type="text" class="form-control" value="{{@$time->closing_time}}" readonly="true" name="closing_time[]" placeholder="Closing Time">
                    </div>
                  </div>
                </div>
              </div>
              @endforeach


              <div class="form-group mb-4 row">
                <div class="col-md-4 text-md-right">
                  <label class="mb-0">{{__('spareparts.adDescription')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-6 col-md-8 col-12">
                  <p id="description_error" class="m-0"></p>
                  <textarea id="description" class="form-control" rows="5" placeholder="{{__('spareparts.adDescriptionDefaultText')}}" name="description" data-parsley-error-message="Description" data-parsley-required="true" data-parsley-trigger="change">{{@$service_description->description}}</textarea>

                  <div class="about-message-field mt-1">
                    <span class="font-weight-semibold">{{__('spareparts.remainingChar')}} <span id="description_count">995</span></span>
                  </div>
                </div>
              </div>

              <!-- Upload Photos section starts here -->
              <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2">

                <div class="alert alert-danger alert-dismissable print-error-msg" style="display:none">
                  <ul class="error-msg"></ul>
                </div>
                <div class="alert alert-warning alert-dismissable" id="print-error-msg" style="display:none">
                        {{__('postOfferServiceAdPage.invalidFiles')}}
            </div>

                <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">{{__('postOfferServiceAdPage.uploadPhotos')}}</h4>

                <div class="row pt-4 pb-4" style="border: 2px dotted skyblue;">
                  <div class="col-md-12 text-center">
                    <div class="row">
                      <div class="col-xs-12 col-md-12">
                        <div class="col-md-12 col-lg-12 col-xs-12" id="columns">
                          <!--  <h3 class="form-label">Select the images</h3>
                <div class="desc"><p class="text-center">or drag to box</p></div> -->
                          <div class="upload-note mt-0 mb-2">
                            <!--  {{__('postOfferServiceAdPage.photo_extentions')}}
                <br>
                {{__('postOfferServiceAdPage.can_select_multiple')}}<br><br> -->
                            <!-- <button class="btn btn-sm btn-primary uploadBtn">Upload</button> -->
                            <span>
                              <img alt="Images" src="https://wsa4.pakwheels.com/assets/photos-d7a9ea70286f977064170de1eeb6dca8.svg">
                              <span class="uploadBtn ml-3" style="background-color: #007bff;padding: 10px 10px;color: white;margin-top: 5px;"><i class="fa fa-plus"></i> {{__('postOfferServiceAdPage.uploadPhotosButtonText')}}</span>
                              <p class="m-0" style="margin-left: 100px !important;position: relative;top: -20px;color: #999;">({{__('postOfferServiceAdPage.uploadPhotosButtonDetailText')}})</p>
                            </span>
                          </div>
                          <div style="text-align: left;" class="d-none main_cover_photo">
                            <span style="position: absolute;z-index: 1000;margin-left: 10px;margin-top: 17px;color: white;font-weight: bold;">Main Cover Photo</span>
                          </div>
                          <div id="uploads" class="row d-none mt-4">
                            <!-- Upload Content -->
                          </div>
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
                              <span style="color:#999;font-size: 13px;"> {{__('postOfferServiceAdPage.photoFormatNprmal')}}</span>
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
                    @if($servicesImages)
                    @foreach($servicesImages as $img)
                    <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar" id="listingCar_{{$img->id}}">
                      <figure class="mb-0 position-relative">
                        <img src="{{url('public/uploads/ad_pictures/services/'.$img->service_id.'/'.$img->image_name)}}" class="img-fluid" alt="carish used cars for sale in estonia">
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
            </div>

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
            <button data-dismiss="modal" aria-label="Close" type="button" class="btn btn-danger discard_ad" data-id="{{@$ad->id}}" style="background-color: #eeefff;border: 1px solid #ccc;color: black;">{{__('featureAdPopup.exitButtonText')}}</button>
            <button type="submit" class="btn themebtn3">{{__('paymentPopup.submitButtonText')}}</button>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
{{-- UploadHBR --}}
    <script src="{{ asset('public/js/uploadHBR.min.js') }}" ></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click', '.featuredlabel', function(e) {
      $("#overlay").fadeOut(100);
      e.preventDefault();
      var img_id = $(this).data('id');
      var ad_id = "{{$id}}"; 
            $.ajax({
              url: "{{route('service.images.remove')}}",
              method: "get",
              dataType: "json",
              data: {
                img_id: img_id,
                ad_id: ad_id
              },
              beforeSend: function() {
                $('#overlay').modal({
                  backdrop: 'static',
                  keyboard: false
                });
                $("#overlay").modal('show');
              },
              success: function(data) {
                if (data.success == true) { 
                  $("#listingCar_"+img_id).hide();
                  $("#overlay").modal('hide'); 
                  //location.reload();
                }
              },
              error: function() {
                alert("{{__('postOfferServiceAdPage.error')}}");
              }
            }); 
    });
    var primary_id = "{{$services->primary_service_id}}";
    $('#primary_service_' + primary_id).trigger('click');
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
        title: {
          required: true
        },
        product_code: {
          required: true
        },
        city: {
          required: true
        },
        spare_categories: {
          required: function(element) {
            if ($("#category_id").val() == '' || $("#all_ids").val() == '') {
              return true;
            } else {
              return false;
            }
          }
        },
        condition: {
          required: true
        },
        price: {
          required: true
        },
        fuel_average: {
          required: true
        },
        price: {
          required: true
        },
        description: {
          required: true
        },
        engine_capacity: {
          required: true
        },
        engine_power: {
          required: true
        },
        "file[]": {
          required: true
        },
        poster_city: {
          required: true
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
                url: "{{route('check_individual_spare_parts_numbers')}}",
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
      } // END SUBMIT HANDLER
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


  var ids = [];
  var pausecontent = <?php echo json_encode($sub_cats); ?>;
  document.getElementById('all_ids').value = pausecontent;

  var make_ids = [];
  $(function() {

    $('.gobackIcon').on('click', function() {
      $(this).parents('.car-info-list-col').hide();
      $(this).parents('.car-info-list-col').prev('.car-info-list-col').show().removeClass('prev-list-active');
    });

    $('.car-info-list-col:not(:last-child) li a').on('click', function() {
      $(this).parents('.car-info-list-col').removeClass('car-list-active').next('.car-info-list-col').addClass('car-list-active').show().prev('.car-info-list-col').addClass('prev-list-active');
      $(this).parents('li').addClass('list-active').siblings('li').removeClass('list-active');
      $(this).parents('.car-info-list-col').siblings('.car-info-list-col').find('li').removeClass('list-active');
    });
  });

  function getSubCategory(e) {

    // alert('here');
    var cat_id = $(e).data('id');
    var cat_title = $(e).data('title');
    // alert(cat_id);
    $('#category_id').val(cat_id);
    $('.chosen_sub').empty();

    document.getElementById('all_ids').value = '';
    ids = [];
    var display_value = $('#category_id').val();
    $('#categories').val(cat_title);

    // alert(cat_title);
    // $('#sub-categories').removeClass('d-none');

    $.ajax({
      url: "{{url('user/get-subcategories')}}/" + cat_id,
      method: "get",
      success: function(data) {
        // console.log(data);
        $('.last-record').addClass('d-none');

        $('#sub_category_list').html(data);
        $('#sub_category_list_2').html(data);
        var pausecontent = <?php echo json_encode($sub_cats); ?>;

        document.getElementById('all_ids').value = pausecontent;

      }
    });

  }

  function selectCategory(e) {
    // alert('done');
    var sub_category_id = $(e).data('id');
    var title = $(e).data('title');
    // var sub_cats = [];
    var pausecontent = <?php echo json_encode($sub_cats); ?>;
    // alert(pausecontent);
    // alert(sub_category_id);
    $('#sub_category').val(title);
    // var display_value = $('#category_id').val()+'/'+$(e).data('title');
    // $('#categories').val(display_value);
    // $('#categoriesModal').modal('hide');
    // $('#category-subcategory').modal('hide');
    $.ajax({
      url: "{{url('user/get-subcategoriess')}}/" + sub_category_id,
      // url: "{{url('user/get-subservices')}}/"+sub_category_id,
      data: {
        ids: pausecontent,
        make_ids: make_ids,
        pausecontent: pausecontent
      },

      method: "get",
      success: function(data) {
        console.log(data);
        $('.last-record').removeClass('d-none');
        $('.last-record').addClass('car-list-active');
        $('.second-last-record').removeClass('car-list-active');
        $('#subservice_cat').html(data.html);
        if (data.id != null) {
          document.getElementById('make_sub_id').value = data.id;
        }
        // $('#sub_category_list_2').html(data);
      }
    });

  }

  function selectSubCategory(e) {
    var id = $(e).data('id');
    var display_value = $('#category_id').val() + '/' + $('#sub_category').val() + '/' + $(e).data('title');
    $('#categories').val(display_value);
    // $('#categoriesModal').modal('hide');
    // $('#category-subcategory').modal('hide');

  }


  $(document).on('click', '.sub_services', function() {
    // alert('hi');
    var thisPointer = $(this);
    var value = thisPointer.val();

    if ($(this).prop("checked") == true) {

      pausecontent.push(thisPointer.val());
      // console.log('goes here '+ids);
      document.getElementById('all_ids').value = pausecontent;
    } else if ($(this).prop("checked") == false) {
      var index = pausecontent.indexOf(thisPointer.val());

      if (index > -1) {
        pausecontent.splice(index, 1);
        document.getElementById('all_ids').value = pausecontent;

      }

    }

  });

  $(document).on('click', '.make_sub_services', function() {
    // alert('hi');
    var thisPointer = $(this);
    var value = thisPointer.val();
    var cat = $('#make_sub_id').val();

    if ($(this).prop("checked") == true) {

      // make_ids.push(thisPointer.val());
      //   console.log('goes here '+make_ids);
      //   document.getElementById('make_all_ids').value = make_ids;

      pausecontent.push('m_' + cat + '_' + thisPointer.val());
      // console.log('goes here '+ids);
      document.getElementById('all_ids').value = pausecontent;
    } else if ($(this).prop("checked") == false) {
      // alert('hi');
      // var index = make_ids.indexOf(thisPointer.val());
      var index = pausecontent.indexOf('m_' + cat + '_' + thisPointer.val());

      // if (index > -1) {
      //    make_ids.splice(index, 1);
      //    document.getElementById('make_all_ids').value = make_ids;

      // }

      if (index > -1) {
        pausecontent.splice(index, 1);
        document.getElementById('all_ids').value = pausecontent;

      }

    }

  });

  $("#categories").keypress(function(e) {
    var keyCode = e.which;
    /* 
    48-57 - (0-9)Numbers
    65-90 - (A-Z)
    97-122 - (a-z)
    8 - (backspace)
    32 - (space)
    */
    // Not allow special  
    return false;
  });
  $("#categories").bind("contextmenu", function(e) {
    e.preventDefault();
  });

  $("#description").keyup(function(e) {
    // alert('hi');
    $("#description").prop('maxlength', '995');
    var max = 995;
    var text = $('#description').val().length;
    var remaining = max - text;
    $('#description_count').html(remaining);

    if (max < $('#description').val().length) {
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
    


  uploadHBR.init({
    "target": "#uploads",
    "max": 8,
        "textNew": "{{__('postOfferServiceAdPage.textNew')}}",
        "textTitle": "{{__('postOfferServiceAdPage.textTitle')}}",
        "textTitleRemove": "{{__('postOfferServiceAdPage.textTitleRemove')}}",
        "mimes": ["image/jpeg", "image/png","image/gif"],
        "showExtensionError":true,
        "messageSelector":"print-error-msg",
        "errorMessage":"{{__('postOfferServiceAdPage.invalidFiles')}}",
        "errorMessages":'{{ __("postOfferServiceAdPage.tooBigImages") }}'
  });

  $('#reset').click(function() {
    uploadHBR.reset('#uploads');
  });

  $('.uploadBtn').click(function() {
    $('#new_0').trigger('click');
    // $('#prev_0').append('<p style="position:absolute;top:-20px;">Hello </p>');

    setTimeout(function() {

      $('#uploads').removeClass('d-none');
      $('.main_cover_photo').removeClass('d-none');
    }, 1000);
  });
</script>
@endpush
@endsection