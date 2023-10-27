@extends('layouts.app')
@section('content')
@push('styles')
<style type="text/css">
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

  #errmsg {
    color: red;
  }

  #prev_0 {
    position: relative;
  }

  #image_preview img {

    width: 200px;
    height: 200px;
    padding: 5px;

  }




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
      <div class="col-11 bg-white p-md-4 p-3 pb-sm-5 pb-4">
        <h2 class="border-bottom mx-md-n4 mx-n3 pb-3 px-md-4 px-3 mb-sm-5 mb-4 themecolor">{{__('common.update_an_accessory')}}</h2>
        <form action="{{url('user/removed-update-spare-part-ad')}}" method="post" id="myForm" class="form-horizontal" enctype="multipart/form-data" data-parsley-validate>
          {{csrf_field()}}
          <!-- Vehicle Information section starts here -->
          <div class="post-an-ad-sects">
            <h4 class="mx-md-n4 mx-n3 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">{{__('spareparts.accessory_information')}}</h4>
            <div class="vehicleInformation">
              <div class="mb-3 row">
                <div class="ml-auto mr-auto col-lg-4 col-md-6 col-12 mandatory-note font-weight-semibold">
                  <span>({{__('ads.all_fields_mandatory')}})</span>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-8 col-12">
                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('common.title')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <input type="text" name="title" class="form-control" placeholder="{{$sparePart->get_sp_ad_title($sparePart->id,$activeLanguage['id'])}}" data-parsley-error-message="Please select Product Name" data-parsley-required="true" data-parsley-trigger="change" value="{{$sparePart->get_sp_ad_title($sparePart->id,$activeLanguage['id'])}}">
                    </div>
                  </div>
                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('common.product_code')}}</label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <input type="text" name="product_code" class="form-control" placeholder="{{__('common.product_code')}}" value="{{@$sparePart->product_code}}">
                    </div>
                  </div>


                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('common.category')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <input type="text" id="categories" class="form-control" placeholder="{{__('common.category')}}/{{__('common.sub_category')}}" data-toggle="modal" data-target="#category-subcategory" value="{{@$sparePart->parent_category->title.'/'.@$sparePart->category->title}}" disabled="true">
                      <!-- <input type="text" id="categories" placeholder="Category/SubCategory" class="form-control" data-toggle="modal" data-target="#categoriesModal" data-parsley-error-message="Please select Category" data-parsley-required="true" data-parsley-trigger="change"> -->
                      <input type="hidden" name="sparepart_id" value="{{$id}}">
                      <input type="hidden" name="freeAd" value="FreeAd">
                      <input type="hidden" name="category" id="category_id">
                      <input type="hidden" id="category_title" name="category_title" value="">
                      <input type="hidden" name="sub_category" id="sub_category">
                    </div>
                  </div>
                  <!-- Modal -->
                  <div class="modal fade postformmodal" id="category-subcategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content overflow-hidden">
                        <div class="modal-body overflow-hidden pt-0">
                          <div class="row car-list-row">
                            <div class="col-md-6 col-sm-12 car-info-list-col car-list-active modal-year-col">
                              <h6 class="post-ad-modal-title d-flex align-items-center mb-4" class="post-ad-modal-title">{{__('common.category')}}</h6>
                              <div class="post-modal-list">

                                <ul class="list-unstyled modal-year-listings">
                                  @foreach($categorise as $category)
                                  @if(@$sparePart->parent_category->title == $category->title)
                                  @php $class = 'active list-active'; @endphp
                                  @else
                                  @php
                                  $class = '';
                                  @endphp

                                  @endif
                                  <li onclick="getSubCategory(this)" id="sub_cat_{{$category->id}}" class="{{@$class}}" data-title="{{$category->title}}" data-id="{{$category->id}}"><a href="javascript:void(0)" class="align-items-center d-flex justify-content-between">{{$category->title}}
                                      <em class="fa fa-angle-right"></em></a></li>
                                  @endforeach
                                </ul>
                              </div>


                            </div>
                            <div class="col-md-6 col-sm-12 car-info-list-col version-list-col" id="sub-categories" style="display: block">
                              <h6 class="post-ad-modal-title d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> {{__('common.sub_category')}}</h6>
                              <div class="post-modal-list">
                                <ul class="list-unstyled version-listings" id="sub_category_list_2">
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="mb-2 mt-4 post-modal-btn text-center">
                            <a href="#" class="btn  themebtn1" data-dismiss="modal">{{__('ads.done')}}</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- My Modal -->
                  <div id="categoriesModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">{{__('common.select_category')}}</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <div class="col-md-6">
                            <h4>{{__('common.select_category')}}</h4>
                            <ul>
                              @foreach($categorise as $category)
                              <li onclick="getSubCategory(this)" data-title="{{$category->title}}" data-id="{{$category->id}}">{{$category->title}}</li>
                              @endforeach
                            </ul>
                          </div>
                          <div class="col-md-6">
                            <h4>{{__('common.select_sub_category')}}</h4>
                            <ul id="sub_category_list">

                            </ul>
                          </div>

                        </div>

                      </div>

                    </div>
                  </div>
                  <!-- My Modal Ends -->

                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('common.condition')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <!-- <select class="form-control">
          <option>Select Condition</option>
          <option>New</option>
          <option>Old</option>
          </select> -->
                      <select class="form-control" id="condition" name="condition" data-parsley-error-message="Please select a Condition" data-parsley-required="true" data-parsley-trigger="change">
                        <option value="" disabled selected>{{__('ads.select_one')}}</option>
                        <option value="New" @if(@$sparePart->condition == 'New') {{ 'selected' }} @endif>New</option>
                        <option value="Used" @if(@$sparePart->condition == 'Used') {{ 'selected' }} @endif>Used</option>

                      </select>
                    </div>
                  </div>

                  <div class="form-group mb-4 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mt-sm-1 pt-sm-2 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('common.price')}} (€)<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">

                      <input class="form-control" type="text" placeholder="{{__('common.price')}}" name="price" data-parsley-error-message="Please Enter valid price" data-parsley-required="true" data-parsley-trigger="change" value="{{@$sparePart->price}}">


                      <div class="pricecheckboxes mt-3">
                        <div class="custom-control custom-checkbox mt-2">
                          <input type="checkbox" class="custom-control-input" {{ ($sparePart->vat != '0')? "checked='true'":" " }} id="pricecheck1" name="vat">
                          <label class="custom-control-label" for="pricecheck1">{{__('common.incl_20_vat')}}</label>
                        </div>
                        <div class="custom-control custom-checkbox mt-2">
                          <input type="checkbox" class="custom-control-input" {{ ($sparePart->neg != '0')? "checked='true'":" " }} id="pricecheck2" name="neg">
                          <label class="custom-control-label" for="pricecheck2">{{__('common.negotiable')}}</label>
                        </div>
                      </div>
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
              <div class="form-group mb-4 row">
                <div class="col-md-4 mt-md-3 pt-md-3 text-md-right">
                  <label class="mb-0 text-capitalize">{{__('spareparts.ad_description')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-6 col-md-8 col-12">
                  <div class="about-message-field text-right mb-1">
                    <span class="d-inline-block text-left">{{__('spareparts.we_dont_allow_promotional')}}</span>
                  </div>
                  <!-- <textarea name="add-description" class="form-control" rows="6" placeholder="Describe Your Product"></textarea> -->
                  <p id="description_error" class="m-0"></p>
                  <textarea id="description" class="form-control" placeholder="{{__('spareparts.describe_your_product')}}" rows="6" name="description" data-parsley-error-message="Please Provide Description" data-parsley-required="true" data-parsley-trigger="change">{{@$sparePart->sp_ads_description[0]->description}}</textarea>

                  <div class="about-message-field mt-1">
                    <span class="font-weight-semibold">{{__('spareparts.remaining_characters')}} <span id="description_count">995</span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Vehicle Information section ends here -->

          <!-- Additional Information section starts here -->
          <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2">
            <div class="alert alert-danger alert-dismissable print-error-msg" style="display:none">
              <ul class="error-msg"></ul>
            </div>
            <div class="alert alert-warning alert-dismissable" id="print-error-msg" style="display:none">
                    
            </div>

            <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">{{__('spareparts.upload_photos')}}</h4>

            <div class="row pt-4 pb-4" style="border: 2px dotted skyblue;">
              <div class="col-md-12 text-center">
                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <div class="col-md-12 col-lg-12 col-xs-12" id="columns">
                      <div class="upload-note mt-0 mb-2">
                        <span>
                          <img alt="Images" src="https://wsa4.pakwheels.com/assets/photos-d7a9ea70286f977064170de1eeb6dca8.svg">
                          <span class="uploadBtn ml-3" style="background-color: #007bff;padding: 10px 10px;color: white;margin-top: 5px;"><i class="fa fa-plus"></i> {{__('common.add_photos')}}</span>
                          <p class="m-0" style="margin-left: 100px !important;position: relative;top: -20px;color: #999;">({{__('common.maxlimit_5_mb_per_image')}})</p>
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
                          <strong style="font-size: 13px;">{{__('common.atleast_five')}}</strong>
                          <span style="color:#999;font-size: 13px;">{{__('common.improves')}}</span>
                        </div>
                        <div class="col-md-5 offset-1">
                          <i class="fa fa-check-circle-o" style="color: #007bff;"></i>
                          <strong style="font-size: 13px;">{{__('common.front_clear')}}</strong>
                          <span style="color:#999;font-size: 13px;"> {{__('common.of_your_car')}}</span>
                        </div>

                        <div class="col-md-5 offset-4 mt-5">
                          <i class="fa fa-check-circle-o" style="color: #007bff;"></i>
                          <strong style="font-size: 13px;">{{__('common.photos_should_be')}}</strong>
                          <span style="color:#999;font-size: 13px;"> {{__('common.jpg_png')}}</span>
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
                @if($sparepartImages)
                @foreach($sparepartImages as $img)
                <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar">
                  <figure class="mb-0 position-relative">
                    <img src="{{asset('public/uploads/ad_pictures/spare-parts-ad/'.@$id.'/'.@$img->img)}}" class="img-fluid" alt="carish used cars for sale in estonia">
                    <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                      <span data-id="{{$img->id}}" class="delete_photo bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block mt-2">REMOVE</span>
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
                    <input type="text" class="form-control" value="{{@$customer->customer_company}}" name="poster_name" value="" placeholder="{{__('ads.name')}}" readonly="true">
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
                    <input type="text" class="form-control" placeholder="{{__('ads.email')}}" name="poster_email" value="{{@$customer->customer_email_address}}" readonly="true">


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
                    <input type="text" class="form-control" placeholder="{{__('ads.phone')}}" name="poster_phone" data-parsley-error-message="Please Enter Valid Phone No" data-parsley-required="true" data-parsley-trigger="change" value="{{@$customer->customers_telephone}}" readonly="true">

                  </div>
                </div>
              </div>
              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('common.city')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-4 col-sm-6 col-sm-7">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text justify-content-center"><em class="fa fa-home"></em></span>
                    </div>
                    <select name="poster_city" disabled="true" placeholder="Choose one City" class="form-control select2-field">
                      <option value="" disabled selected>Choose City</option>
                      @foreach($cities as $city)
                      <option value="{{$city->id}}" @if(@$customer->citiy_id == $city->id) {{ 'selected' }} @endif>{{$city->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Contact Information section ends here -->

          <div class="border-top mx-n4 pt-4 pt-sm-5 px-4 mt-sm-5 mt-4 text-center">
            <input type="submit" class="btn pb-3 pl-4 post-sp-ad-submit pr-4 pt-3  themebtn1" value="{{__('ads.submit_and_continue')}}">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewPhotos" tabindex="-1" role="dialog" aria-labelledby="viewPhotosModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Spare Part Images</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          @if(@$sparepartImages != null)
          @foreach(@$sparepartImages as $img)
          <div class="col-lg-4" id="image_row_{{$img->id}}">
            <div style="position: relative;">
              <img src="{{asset('public/uploads/ad_pictures/spare-parts-ad/'.@$id.'/'.@$img->img)}}" width="100%" height="150px;" style="border:2px dotted skyblue;" class="mb-4">
              <i class="fa fa-times delete_photo" style="position: absolute;right: -4px;top:-6px;color: red;font-weight: normal;font-size: 16px;" data-id="{{@$img->id}}"></i>
            </div>
          </div>
          @endforeach
          @endif
        </div>
      </div>

    </div>
  </div>

</div>
<!-- Loader Modal -->
<div class="modal" id="loader_modal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <h3 style="text-align:center;">{{ __('common.please_wait') }}</h3>
        <p style="text-align:center;"><img src="{{ asset('public/assets/img/gif/waiting.gif') }}"></p>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="featureModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">{{__('spareparts.post_an_accessory')}}</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="featured_request_form">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="row">
                        <p style="font-style: italic;font-weight: 400;color: red;padding-left: 35px;">{{__('spareparts.note_accessories_limit_reached')}}</p>
                    </div>

                    <div class="alert alert-danger alert-dismissable" id="featured_request_form-error" style="display:none">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <span class="carnumber-error" style="margin-left: 30px;"><strong>Error ! </strong>Please select number of days.</span>
                    </div>

                    @if(@$credit>0)
                    <div style="display:block;padding-left: 20px;">
                        <input type="checkbox" name="use_balance" class="use_balance" value="">
                        <span class="ml-2">{{__('common.use_my_account_balance')}}</span>
                    </div>
                    @endif

                    <input type="hidden" name="ad_id" class="featured_ad_id" value="{{@$adsDetails->id}}">
                    <div class="ad" style="padding: 0 20px;box-shadow: 0px 5px 0px 0px rgba('0,0,0,0.25');">
                        <div class="input-group" id="car_data" style="border: none;margin-top: 40px;margin-left: 30%;">
                            <span style="background-color: white;width: 30%;border-top-left-radius: 5px;border-bottom-left-radius: 5px;border: 1px solid #aaa;border-right: none;padding-left: 5px;line-height: 2;font-weight: 600;" class="feature_span">{{__('spareparts.post_this_accessory_for')}} </span>
                            <select name="featured_days" id="featured_days" style="width: 20%;height: 33px;border-left: none;" class="feature_select">
                                <option value="">***{{__('common.select_days')}}***</option>
                                @foreach($ads_pricing as $pricing)
                                    <option value="{{$pricing->number_of_days}}">{{$pricing->number_of_days}} {{__('common.days')}} {{$pricing->pricing}} €</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer" style="justify-content: center;border-top: none;">
                        <button data-dismiss="modal" aria-label="Close" type="button" class="btn btn-danger discard_ad" data-id="{{@$adsDetails->id}}" style="background-color: #eeefff;border: 1px solid #ccc;color: black;">{{__('common.discard')}}</button>
                        <button type="submit" class="btn themebtn3">{{__('home.submit')}}</button>
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
<script>
  $('.uploadBtn').click(function() {
    $('#new_0').trigger('click');
    // $('#prev_0').append('<p style="position:absolute;top:-20px;">Hello </p>');
    setTimeout(function() {
      $('#uploads').removeClass('d-none');
      $('.main_cover_photo').removeClass('d-none');
    }, 1000);
  });

  $(document).ready(function() {
    $("#myForm").validate({
          rules: {
            title: {
              required: true
            },
            city: {
              required: true
            },
            spare_categories: {
              required: true
            },
            condition: {
              required: true
            },
            price: {
              required: true
            },
            description: {
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
            title: "{{__('common.please_enter_title')}}",
            product_code: "{{__('common.please_select_product_code')}}",
            city: "{{__('common.please_select_city')}}",
            spare_categories: "{{__('common.please_select_categories')}}",
            condition: "{{__('common.please_select_condition')}}",
            price: "{{__('common.please_enter_price')}}",
            description: "{{__('common.please_enter_description')}}",
            "file[]": "{{__('common.please_select_atleast_one_photo')}}",
            poster_city: "{{__('common.please_select_poster_city')}}"
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
                      $('.post-sp-ad-submit').addClass('disabled');
                      return false;
                    } else {
                      $('.post-sp-ad-submit').removeClass('disabled');
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
                          window.location = "{{route('my-spear-parts-ads')}}?status=0";
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
                    window.location = "{{route('my-spear-parts-ads')}}?status=0";
                  }
                });
              } // END ELSE

          }

        });
    var images_exist = "{{$images_count}}";
    var remaining_images = 8 - images_exist;
    $('input').attr('autocomplete', 'nope');
    var val = "{{@$sparePart->parent_id}}";
    $('#sub_cat_' + val).trigger('click');
    $('.car-list-active').removeClass('car-list-active');
    $('.version-list-col').addClass('car-list-active');
    uploadHBR.init({
        "target": "#uploads",
        "max": remaining_images,
          "textNew": "{{__('common.text_new')}}",
          "textTitle": "{{__('common.text_title')}}",
          "textTitleRemove": "{{__('common.text_title_remove')}}",
          "mimes": ["image/jpeg", "image/png","image/gif"],
          "showExtensionError":true,
          "messageSelector":"print-error-msg",
          "errorMessage":"{{__('common.invalid_files')}}",
          "errorMessages":'{{ __("ads.too_big_images") }}'
      });
    $('.delete_photo').on('click', function() {
        var id = $(this).data('id');  
              $.ajax({
                method: "get",
                data: 'id=' + id,
                url: "{{ route('remove-sparepart-image') }}",
                beforeSend: function() {
                  $('#loader_modal').modal({
                    backdrop: 'static',
                    keyboard: false
                  });
                  $("#loader_modal").modal('show');
                },
                success: function(data) {
                  if (data.success == true) {
                    $('#image_row_' + id).remove();
                    $("#loader_modal").modal('hide'); 
                    location.reload();

                  }

                }
              });
            });
  });
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
  function fillInfo(e) {
    var model_id = $(e).data('id');
    $('#model').val(model_id);
    $.ajax({
      url: "{{url('fill-input')}}/" + $('#year').val() + "/" + $('#maker').val() + "/" + model_id,
      method: "get",
      success: function(data) {
        $('#car_info').val(data);
        $('#myModal').modal('hide');
      }
    })

  }
  function getSentence(e) {
    var sentence = $(e).data('sentence');
    var old_sentense = $('#description').val();
    var new_sentense = old_sentense + sentence;
    $('#description').val(new_sentense);
    $(e).hide();
  }
  function getSubCategory(e) {
    // alert('here');
    var cat_id = $(e).data('id');
    var cat_title = $(e).data('title');
    var sub_id = "{{@$sparePart->category_id}}";
    // alert(cat_id);
    $('#category_id').val(cat_id);
    $('#category_title').val(cat_title);

    // alert(cat_title);
    // $('#sub-categories').removeClass('d-none');

    $.ajax({
      url: "{{url('user/get-spearpart-subcategories')}}/" + cat_id,
      method: "get",
      data: {
        sub_id: sub_id
      },
      success: function(data) {
        // console.log(data);
        $('#sub_category_list').html(data);
        $('#sub_category_list_2').html(data);
      }
    });

  }
  function selectCategory(e) {
    var sub_category_id = $(e).data('id');
    $('#sub_category').val(sub_category_id);
    var display_value = $('#category_title').val() + '/' + $(e).data('title');
    $('#categories').val(display_value);
    $('#categoriesModal').modal('hide');
    $('#category-subcategory').modal('hide');

  }
  $(function() {
    $("#description").prop('maxlength', '995');
    var max = 995;
    var text = $('#description').val().length;
    var remaining = max - text;
    $('#description_count').html(remaining);
    $('.gobackIcon').on('click', function() {
      $(this).parents('.car-info-list-col').hide();
      $(this).parents('.car-info-list-col').prev('.car-info-list-col').show().removeClass('prev-list-active');
    });
    $('.car-info-list-col:not(:last-child) li a').on('click', function() {
      $(this).parents('.car-info-list-col').removeClass('car-list-active').next('.car-info-list-col').addClass('car-list-active').show().prev('.car-info-list-col').addClass('prev-list-active');
      $(this).parents('li').addClass('list-active').siblings('li').removeClass('list-active');
      $(this).parents('.car-info-list-col').siblings('.car-info-list-col').find('li').removeClass('list-active');
    });
    $(document).on('click', '.car-info-list-col ul.version-listings li', function() {
      // alert('finaaly');
      $('ul.version-listings li').removeClass('list-active');
      $(this).addClass(' list-active');
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
  });
</script>
@endpush
@endsection