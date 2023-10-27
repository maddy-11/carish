@extends('layouts.app')
@section('title') {{ __('postCarAdPage.pageTitle') }} @endsection
@section('content')
@push('styles')
<style>
    .themebtn1_individual {
        text-align: left;
    }

    .active {
        color: #0072BB;
        border: 1px solid #0072BB !important;
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

    #myForm {
        display: none;
    }

    /* Images section */

  

    .box-drag {
        /* float: left; */
        display: block;
      /*   width: 24.33%; */
        padding: 0 15px;
    }

    .no-padding {
        padding: 0px !important;
    }

    .uploadArea {
        border: dashed #676465;
        text-align: center;
        /* line-height: 30px; */
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
        height: 140px;
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

    .suggestion-class {
        height: calc(100% - 200px) !important;
        overflow: auto;
    }



    /*for loader*/
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 80px;
        height: 80px;
        -webkit-animation: spin 2s linear infinite;
        /* Safari */
        animation: spin 2s linear infinite;
        margin: auto;
        margin-top: 100px;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endpush
{{--Indiviual User--}}
<div class="internal-page-content mt-4 pt-lg-5 pt-4 sects-bg pb-0">
    <div class="container pt-2">
        <!-- CAR NUMBER Verification Form Start -->
        <div class="row ml-0 mr-0 post-an-ad-row mb-4">
            <div class="col-12 bg-white p-md-4 p-3 pb-sm-5 pb-4">
                <h2 class="border-bottom mx-md-n4 mx-n3 pb-3 px-md-4 px-3 mb-sm-5 mb-4 themecolor">{{__('postCarAdPage.postAnAd')}}
                </h2>
                {{-- START OF CAR NUMBER ENTRY FORM --}}
                <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2">
                    <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">
                        {{__('postCarAdPage.vehicleNumber')}}
                    </h4>
                    <div class="contact-info">
                        <div class="align-items-center form-group mb-sm-4 mb-3 row">
                            <div class="col-md-8 col-sm-12 mb-1 text-sm-right">
                                <form action="{{route('post.ad')}}" method="post" id="car_number_form">
                                    {{csrf_field()}}
                                    <div class="post-ad-auto-bg mt-md-5 mt-4 mx-auto">
                                        <div class="form-group d-flex">

                                            <div class="input-group" id="car_data" style="border: none;">
                                                <!-- <img src="{{asset('public/assets/img/est-number.jpg')}}" align="image"> -->
                                                <span style="background-color: #0072BB;width: 30px;border-top-left-radius: 5px;border-bottom-left-radius: 5px;"></span>
                                                <input type="text" required name="car_number" id="carnumber" class="border-0 form-control" placeholder="2345IBA" value="{{old('car_number')}}" style="border: 1px solid #ccc !important;height: 100%;border-radius: 0px;text-transform: uppercase;">

                                            </div>
                                            <button class="btn g-recaptcha rounded-0 themebtn1 px-4"  id='onSubmit' style="background-color: #539200;border-top-right-radius: 5px !important;border-bottom-right-radius: 5px !important;"><i class="fa fa-search"></i></button>                                        
                                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" value="">
                                        </div>
                                        <div style="display:none"></div>

                                        <div class="alert alert-danger alert-dismissable themebtn1_individual" style="display:none">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <span class="carnumber_error" style="margin-left: 30px;">
                                                {{__('postCarAdPage.enterDetailsContinue')}}
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @include('messeges.notifications')
                <div class="alert alert-danger alert-dismissable print-error-message" style="display:none">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <ul class="error-msg"></ul>
                </div>
                <div class="alert alert-danger alert-dismissable" id="carnumber-error" style="display:none">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <span class="carnumber-error" style="margin-left: 30px;"></span>
                </div>
                {{-- END OF CARE NUMBER ENTRY FORM --}}
            </div>
        </div>
        <!-- CAR NUMBER Verification Form End -->

        <!-- CAR INFORMATION Form Start -->
        <div class="row ml-0 mr-0 mt-4 post-an-ad-row not_found">
            <div class="col-12 bg-white p-md-4 p-3 pb-sm-5 pb-4">
                <form id="myForm" action="{{route('save.ad')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" id="source" name="source" value="Manually">
                <input type="hidden" name="car_number" id="car_number" value="{{old('car_number')}}">
                <!-- Vehicle Information section starts here -->
                <div class="post-an-ad-sects">
                    <!-- <h5 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3">Vehicle Information</h5> -->
                    <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">
                        {{__('postCarAdPage.vehicleInformation')}}
                    </h4>
                    <div class="vehicleInformation">
                        <div class="mb-3 row">
                            <div class="ml-auto mr-auto col-lg-4 col-md-6 col-12 mandatory-note font-weight-semibold">
                                <span> ({{__('postCarAdPage.mandatoryFeilds')}})</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <div class="align-items-center form-group mb-sm-4 mb-3 row">
                                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                                        <label class="mb-0 text-capitalize">{{__('postCarAdPage.currentRegistration')}}<sup class="text-danger">*</sup></label>
                                    </div>
                                    <div class="col-md-6 col-sm-7">
                                        <select class="form-control" id="boughtfrom" name="country_id">
                                            <option value="">{{__('postCarAdPage.selectOption')}}</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->country_id}}" @if(old('country_id')==$country->
                                                country_id ) {{ 'selected' }} @endif>{{$country->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="align-items-center form-group mb-sm-4 mb-3 row">
                                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                                        <label class="mb-0 text-capitalize">{{__('postCarAdPage.boughtFrom')}}</label>
                                    </div> 
                                    <div class="col-md-6 col-sm-7">
                                        <select class="form-control" id="boughtfrom" name="bought_from">
                                            <option value="">{{__('postCarAdPage.selectOption')}}</option>
                                            @foreach($boughtFromCountries as $cdesc) 
                                            <option value="{{$cdesc->bought_from_id}}" @if(old('bought_from')==$cdesc->
                                            bought_from_id ) {{ 'selected' }} @endif>{{$cdesc->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="align-items-center form-group mb-sm-4 mb-3 row">
                                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                                        <label class="mb-0 text-capitalize">{{__('postCarAdPage.estonianRegDate')}}</label>
                                    </div>
                                    <div class="col-md-6 col-sm-7">
                                        <input type="month" name="register_in_estonia" value="{{old('register_in_estonia')}}" class="form-control" placeholder="month-year"  pattern="[0-9]{4}-[0-9]{2}">
                                    </div>
                                </div>

                                <div class="align-items-center form-group mb-sm-4 mb-3 row">
                                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                                        <label class="mb-0 text-capitalize">{{__('postCarAdPage.carInfo')}}<sup class="text-danger">*</sup></label>
                                    </div>
                                    <div class="col-md-6 col-sm-7">
                                        <input type="text" class="form-control" id="car_info" autocomplete="off" placeholder="{{__('postCarAdPage.carInfoDefaultText')}}" value="{{old('car_info')}}" data-toggle="modal" name="car_info" data-target="#postedcarinfo" data-parsley-error-message="{{__('postCarAdPage.pleaseProvideCarInfo')}}" data-parsley-required="true" data-parsley-trigger="change">
                                        <input type="hidden" id="maker" name="make_id" value="{{old('make_id')}}">
                                        <input type="hidden" id="maker_title" name="make" value="{{old('make')}}">
                                        <input type="hidden" id="model" name="model_id" value="{{old('model_id')}}">
                                        <input type="hidden" id="model_title" name="model" value="{{old('car_number')}}">
                                        <input type="hidden" id="year" name="year" value="{{old('year')}}">
                                        <input type="hidden" id="version" name="version_id" value="{{old('car_number')}}">
                                        <input type="hidden" id="version_title" name="version" value="{{old('version')}}">
                                    </div>
                                </div>

                                <div class="align-items-center form-group mb-sm-4 mb-3 row">
                                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                                        <label class="mb-0 text-capitalize">{{__('postCarAdPage.bodyType')}}<sup class="text-danger">*</sup></label>
                                    </div>
                                    <div class="col-md-6 col-sm-7">
                                        <select class="form-control" id="body_type_id" name="body_type_id">
                                            <option value="">{{__('postCarAdPage.selectOption')}}</option>
                                            @foreach($bodyTypes as $bodyType)
                                            <option value="{{$bodyType->body_type_id}}" @if(old('body_type_id')==$bodyType->body_type_id) {{ 'selected' }}
                                                @endif>{{$bodyType->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="align-items-center form-group mb-sm-4 mb-3 row">
                                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                                        <label class="mb-0 text-capitalize">{{__('postCarAdPage.doors')}}<sup class="text-danger">*</sup></label>
                                    </div>
                                    <div class="col-md-6 col-sm-7">
                                        <select class="form-control" id="doors" name="doors" data-parsley-error-message="Please select doors" data-parsley-required="true" data-parsley-trigger="change">
                                            <option value="">{{__('postCarAdPage.selectOption')}}</option>
                                            <option value="2" @if(old('doors')==2 ) {{ 'selected' }} @endif>2</option>
                                            <option value="3" @if(old('doors')==3 ) {{ 'selected' }} @endif>3</option>
                                            <option value="4" @if(old('doors')==4 ) {{ 'selected' }} @endif>4</option>
                                            <option value="5" @if(old('doors')==5 ) {{ 'selected' }} @endif>5</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="align-items-center form-group mb-sm-4 mb-3 row">
                                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                                        <label class="mb-0 text-capitalize">{{__('postCarAdPage.mileage')}} (km)<sup class="text-danger">*</sup></label>
                                    </div>

                                    <div class="col-md-6 col-sm-7">
                                        <input type="number" pattern="[0-9]+([,\.][0-9]+)?" step="0.01" value="{{old('millage')}}" class="form-control" placeholder="e.g 5000" data-parsley-error-message="Enter valid mileage (1-1000000)" data-parsley-required="true" data-parsley-trigger="change" name="millage" id="millage" title="Mileage Can Only Contain Digits">
                                    </div>
                                </div>

                                <div class="align-items-center form-group mb-sm-4 mb-3 row">
                                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                                        <label class="mb-0 text-capitalize">{{__('postCarAdPage.color')}}<sup class="text-danger">*</sup></label>
                                    </div>
                                    <div class="col-md-6 col-sm-7">
                                        <select class="form-control" id="color" name="color">
                                            <option value="">{{__('postCarAdPage.selectOption')}}</option>
                                            @foreach($colors as $color)
                                            <option value="{{$color->color_id}}" @if(old('color')==$color->color_id)
                                                {{ 'selected' }} @endif>{{$color->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="align-items-center form-group mb-sm-4 mb-3 row">
                                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                                        <label class="mb-0 text-capitalize">{{__('postCarAdPage.fuelAverage')}}<sup class="text-danger">*</sup></label>
                                    </div>
                                    <div class="col-md-6 col-sm-7">

                                        <input class="form-control" type="number" pattern="[0-9]+([,\.][0-9]+)?" step="0.01" value="{{old('fuel_average')}}" placeholder="e.g 6.7" name="fuel_average" id="fuel_average">

                                    </div>
                                </div>

                                <div class="form-group mb-4 row">
                                    <div class="col-lg-6 col-md-4 col-sm-3 mt-sm-1 pt-sm-2 text-sm-right">
                                        <label class="mb-0 text-capitalize">{{__('postCarAdPage.price')}}<sup class="text-danger">*</sup></label>
                                    </div>
                                    <div class="col-md-6 col-sm-7">
                                        <input class="form-control" type="number" value="{{old('price')}}" pattern="[0-9]" placeholder="{{__('postCarAdPage.price')}}" id="price" name="price" data-parsley-error-message="Please Enter valid price" data-parsley-required="true" data-parsley-trigger="change">
                                        <div class="pricecheckboxes mt-3">
                                            <div class="custom-control custom-checkbox mt-2">
                                                <input type="checkbox" class="custom-control-input" id="pricecheck1" name="vat" value="customEx" @if( old('vat') !=null) checked @endif>
                                                <label class="custom-control-label" for="pricecheck1">{{__('postCarAdPage.inclVat')}}</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <input type="checkbox" class="custom-control-input" id="pricecheck2" name="neg" value="customEx" @if( old('neg') !=null) checked @endif>
                                                <label class="custom-control-label" for="pricecheck2">{{__('postCarAdPage.negotiable')}}</label>
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
                            <div class="col-md-4 mt-md-3 pt-md-2 text-md-right">
                                <label class="mb-0 text-capitalize">{{__('postCarAdPage.adDescription')}}<sup class="text-danger">*</sup></label>
                            </div>
                            <div class="col-lg-6 col-md-8 col-12">
                                <div class="about-message-field text-right font-weight-semibold mb-1">
                                    <span id="description_count">{{__('postCarAdPage.remainingChar')}} 995</span>
                                    <a href="javascript:void(0)" id="reset" class="reset-message d-inline-block ml-2 themecolor">{{__('postCarAdPage.reset')}}</a>
                                </div>
                                <p id="description_error" class="m-0"></p>
                                @php
                                $description = __('postCarAdPage.inspectionValid')
                                @endphp
                                <textarea id="description" class="form-control" rows="6" name="description" data-parsley-error-message="Please Provide Description" data-parsley-required="true" data-parsley-trigger="change" placeholder="Describe your vehicle: Example: Alloy rim, first owner, genuine parts, maintained byauthorized workshop, excellent mileage, original paint etc.">{{old('description') != null ? old('description') : $description}}</textarea>
                                <div class="add-suggestion border mt-2 p-3" style="height: 130px;-webkit-transition: all 1s linear 0s;
  transition: all 1s linear 0s;overflow: hidden;">
                                    <p> {{__('postCarAdPage.useSuggestion')}}</p>
                                    <div class="suggestions-tags">
                                        @foreach($suggestions as $suggestion)
                                        <a href="JavaScript:Void(0);" class=""><span class="label label-info bgcolor1 badge badge-pill pl-sm-3 pr-sm-3 pr-2 pl-2 text-white mb-2" data-id="{{$suggestion->suggesstion_id}}" data-sentence="{{$suggestion->sentence}}" onclick="getSentence(this)">{{$suggestion->title}}</span></a>

                                        @endforeach
                                    </div>
                                </div>
                                <div class="border border-top-0 pb-2 pl-3 pr-3 pt-2 show-more-suggestion text-center">
                                    <a href="javascript:void(0)" class="font-weight-bold themecolor show_more_suggestions">{{__('postCarAdPage.more')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Vehicle Information section ends here -->

                <!-- Additional Information section starts here -->
                <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2 addInformation" style="display: none">
                    <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">
                        {{__('postCarAdPage.additonalInformation')}}
                    </h4>
                    <div class="additional-info">
                        <div class="align-items-center form-group mb-sm-4 mb-3 row">
                            <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                                <label class="mb-0 text-capitalize">{{__('postCarAdPage.engineCapacity')}} (cc)<sup class="text-danger">*</sup></label>
                            </div>
                            <div class="col-md-6 col-lg-5 col-sm-7">
                                <input type="text" value="{{old('engine_capacity')}}" disabled="disabled" class="form-control" name="engine_capacity" id="engine_capacity" placeholder="Engine Capacity* (cc)">
                            </div>
                        </div>
                        <div class="align-items-center form-group mb-sm-4 mb-3 row">
                            <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                                <label class="mb-0 text-capitalize">{{__('postCarAdPage.enginePower')}} (KW)<sup class="text-danger">*</sup></label>
                            </div>

                            <div class="col-md-6 col-lg-5 col-sm-7">
                                <input type="text" value="{{old('engine_power')}}" disabled="disabled" class="form-control" name="engine_power" id="engine_power" placeholder="engine power (KW)">
                            </div>
                        </div>
                        <div class="align-items-center form-group mb-sm-4 mb-3 row">
                            <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                                <label class="mb-0 text-capitalize">{{__('postCarAdPage.engineType')}}<sup class="text-danger">*</sup></label>
                            </div>
                            <div class="col-md-6 col-lg-5 col-sm-7">
                                <select name="fuel_type" id="fuel_type" class="form-control">
                                    @foreach($engineTypes as $engineType)
                                    <option value="{{$engineType->engine_type_id}}" @if(old('fuel_type')==$engineType->
                                        engine_type_id) {{ 'selected' }} @endif>{{$engineType->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="align-items-center form-group mb-sm-4 mb-3 row">
                            <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                                <label class="mb-0 text-capitalize">{{__('postCarAdPage.transmission')}}<sup class="text-danger">*</sup></label>
                            </div>
                            <div class="col-md-6 col-lg-5 col-sm-7">
                                <select name="transmission_type" id="transmission_type" class="form-control">
                                    @foreach($transmissions as $transmission)
                                    <option value="{{$transmission->transmission_id}}" @if(old('transmission_type')==$transmission->transmission_id) {{ 'selected' }}
                                        @endif>{{$transmission->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                                <h6>{{__('postCarAdPage.features')}}<sup class="text-danger">*</sup></h6>
                            </div>
                            <div class="col-lg-7 col-sm-9 features-checkboxes">
                                <div class="row">
                                    @foreach($features as $feature)
                                    <input type="hidden" name="{{$feature->name}}">
                                    <div class="col-md-4 col-6 form-group mb-1">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="featurecheck-{{$feature->id}}" name="features[]" value="{{$feature->id}}">
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
                    <div class="alert alert-danger alert-dismissable print-error-msg" style="display:none">
                        <ul class="error-msg"></ul>
                    </div>
                    <div class="alert alert-warning alert-dismissable" id="print-error-msg" style="display:none"></div>

                    <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">
                        {{__('postCarAdPage.uploadPhotos')}}
                    </h4>

                    <div class="row pt-4 pb-4" style="border: 2px dotted skyblue;">
                        <div class="col-md-12 text-center">
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <div class="col-md-12 col-lg-12 col-xs-12" id="columns">
                                        <div class="upload-note mt-0 mb-2">
                                            <span>
                                                <img alt="Images" src="https://wsa4.pakwheels.com/assets/photos-d7a9ea70286f977064170de1eeb6dca8.svg">
                                                <span class="uploadBtn ml-3" style="background-color: #007bff;padding: 10px 10px;color: white;margin-top: 5px;"><i class="fa fa-plus"></i> {{__('postCarAdPage.uploadPhotosButtonText')}}</span>
                                                <p class="m-0" style="margin-left: 100px !important;position: relative;top: -20px;color: #999;">
                                                    ({{__('postCarAdPage.uploadPhotosButtonDetailText')}})</p>
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
                                                <strong style="font-size: 13px;">{{__('postCarAdPage.add5PicsBold')}}</strong>
                                                <span style="color:#999;font-size: 13px;">{{__('postCarAdPage.add5PicsNormal')}}</span>
                                            </div>
                                            <div class="col-md-5 offset-1">
                                                <i class="fa fa-check-circle-o" style="color: #007bff;"></i>
                                                <strong style="font-size: 13px;">{{__('postCarAdPage.addClearPicsBold')}}</strong>
                                                <span style="color:#999;font-size: 13px;">
                                                    {{__('postCarAdPage.addClearPicsNormal')}}</span>
                                            </div>

                                            <div class="col-md-5 offset-4 mt-5">
                                                <i class="fa fa-check-circle-o" style="color: #007bff;"></i>
                                                <strong style="font-size: 13px;">{{__('postCarAdPage.photoFormatBold')}}</strong>
                                                <span style="color:#999;font-size: 13px;">
                                                    {{__('postCarAdPage.photoFormatNprmal')}}</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- AUpload Photos section Ends here -->

                <!-- Contact Information section starts here -->
                <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2">
                    <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">
                        {{__('postCarAdPage.contactInformation')}}
                    </h4>
                    <div class="contact-info">
                        <div class="align-items-center form-group mb-sm-4 mb-3 row">
                            <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                                <label class="mb-0 text-capitalize">{{__('postCarAdPage.name')}}<sup class="text-danger">*</sup></label>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-sm-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text justify-content-center"><em class="fa fa-user"></em></span>
                                    </div>
                                    @if($customerDetail->customer_firstname !='' && $customerDetail->customer_lastname
                                    !='')
                                    <input type="text" readonly class="form-control" placeholder="Name" name="poster_name" value='{{$customerDetail->customer_firstname.$customerDetail->customer_lastname}}'>
                                    @else
                                    <input type="text" readonly class="form-control" placeholder="Name" name="poster_name" value='{{$customerDetail->customer_company}}'>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="align-items-center form-group mb-sm-4 mb-3 row">
                            <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                                <label class="mb-0 text-capitalize">{{__('postCarAdPage.email')}}<sup class="text-danger">*</sup></label>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-sm-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text justify-content-center"><em class="fa fa-envelope"></em></span>
                                    </div>
                                    <input type="text" readonly class="form-control" placeholder="Email" name="poster_email" value="{{$customerDetail->customer_email_address}}">
                                </div>
                            </div>
                        </div>
                        <div class="align-items-center form-group mb-sm-4 mb-3 row">
                            <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                                <label class="mb-0 text-capitalize">{{__('postCarAdPage.phone')}}<sup class="text-danger">*</sup></label>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-sm-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text justify-content-center"><em class="fa fa-phone"></em></span>
                                    </div>
                                    <input type="text" readonly class="form-control" placeholder="Phone" name="poster_phone" value="{{$customerDetail->customers_telephone}}">
                                </div>
                            </div>
                        </div>
                        <div class="align-items-center form-group mb-sm-4 mb-3 row">
                            <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                                <label class="mb-0 text-capitalize">{{__('postCarAdPage.city')}}<sup class="text-danger">*</sup></label>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-sm-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text justify-content-center"><em class="fa fa-home"></em></span>
                                    </div>
                                    <select placeholder="Choose one City" readonly class="form-control select2-field city_select" name="poster_city">
                                        <option value="">{{__('postCarAdPage.selectOption')}}</option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->id}}" {{$customerDetail->citiy_id == $city->id ? 'selected' : ''}}>
                                            {{$city->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Contact Information section ends here -->


                <div class="border-top mx-n4 pt-4 pt-sm-5 px-4 mt-sm-5 mt-4 text-center">
                    <input type="submit" class="btn pb-3 pl-4 post-ad-submit pr-4 pt-3  themebtn1" value="{{__('postCarAdPage.submitButtonText')}}">
                </div>

            </form>
                {{-- OVERLAY HTML ENDS HERE --}}
            </div> 
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade postformmodal" id="postedcarinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content overflow-hidden">
            <div class="modal-body overflow-hidden pt-0">
                <div class="row car-list-row" id="make_years">
                    <div class="col-md-3 col-sm-12 car-info-list-col make-list-col car-list-active"  >
                        <h6 class="post-ad-modal-title d-flex align-items-center mb-4">{{__('postCarAdPage.carInfoPopupMake')}}<br><span id="make_title_selected"></span></h6>
                        <div class="post-modal-list" id="post-modal-list">
                            <ul class="make-listings list-unstyled" id="make-listings">
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 car-info-list-col modal-list-col" style="display: none">
                        <h6 class="post-ad-modal-title d-flex align-items-center mb-4">
                            <em class="d-md-none fa fa-arrow-circle-left gobackIcon go-to-makes mr-2"></em>
                            {{__('postCarAdPage.carInfoPopupModel')}}
                        </h6>
                        <div class="post-modal-list">
                            <ul class="list-unstyled modal-listings" id="models_listing">
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 car-info-list-col modal-year-col" style="display: none">
                        <h6 class="post-ad-modal-title d-flex align-items-center mb-4" class="post-ad-modal-title"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2 go-to-models"></em>{{__('postCarAdPage.carInfoPopupModel')}}
                            {{__('postCarAdPage.year')}}<span id="year_selected"></span>
                        </h6>
                        <div class="post-modal-list">
                            <ul class="list-unstyled modal-year-listings">
                                @foreach(range(date('Y'), date('Y')-79) as $y)
                                <li class="model_years" data-year="{{$y}}" id="{{$y}}">
                                    <a href="JavaScript:Void(0);" class="align-items-center d-flex justify-content-between">{{$y}}
                                        <em class="fa fa-angle-right"></em></a>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 car-info-list-col version-list-col" style="display: none">
                        <h6 class="post-ad-modal-title d-flex align-items-center mb-4">
                            <em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2 go-to-models-years"></em>{{__('postCarAdPage.carInfoPopupVersion')}}</h6>
                        <div class="post-modal-list">
                            <ul class="list-unstyled version-listings"></ul>
                        </div>         
                    </div>
                </div>
                <div class="mb-2 mt-4 post-modal-btn text-center">
                    <a href="#" class="btn disabled themebtn1" data-dismiss="modal">{{__('postCarAdPage.done')}}</a>
                </div>
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

                    <div class="alert alert-danger alert-dismissable" id="featured_request_form-error" style="display:none">
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
<!-- export pdf form starts -->
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
    <!-- export pdf form ends -->
</div>
<!-- Loader Modal -->
<div class="modal" id="loader_modal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <h3 style="text-align:center;">{{ __('postCarAdPage.pleaseWait') }}</h3>
                <p style="text-align:center;"><img src="{{ asset('public/assets/img/gif/waiting.gif') }}"></p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@if(count($errors) > 0)
<script>
    $("#myForm").show();
</script>
@endif
{{-- UploadHBR --}} 
<script src="{{ asset('public/js/uploadHBR.min.js') }}" ></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

    /* Car Number Form Submit */
    $(document).on('click', '#onSubmit', function(e) { 
        var role               = "{{$customerDetail->customer_role}}";
        var carnumber          = $('#carnumber').val().toUpperCase();
        var gRecaptchaResponse = $('#g-recaptcha-response').val();
        e.preventDefault();
        if (carnumber == '') {
            html = '<h6 style="padding-top:50px" class="d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>Please enter a number.</h6>';
            //$(".post-modal-btn").html('<a href="#" class="btn  themebtn1" data-dismiss="modal">{{__("ads.close")}}</a>');
            $(".carnumber-error").html('<strong>Error!</strong>Please enter a valid number.');
            $('#carnumber-error').show();
            $("#overlay").fadeOut(300);
            clearFormInput();
            return false;
        }
        $.ajax({
                url: "{{url('user/get-car-info')}}",
                method: "post",
                dataType: "json",
                data:
                {
                    carnumber:carnumber,
                    gRecaptchaResponse:gRecaptchaResponse
                },
                success: function(data) { 
                    var html = '';
                    if (data['status'] == 'success') {
                        html +=
                            '<h6 style="padding-top:50px" class="d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>' +
                            data['message'] + '</h6>';

                        $.each(data['data'], function(index, value) {
                            $("#car_data").append(
                                '<input type="hidden" name="car_data['+index+']" value="'+value+'">');
                        }); // END FOR EACH
                        $("#car_number_form").submit();
                        
                    }
                    if (data['status'] == 'error') {
                        $('.not_found').removeClass('d-none');
                        html +=
                            '<h6 style="padding-top:50px" class="d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>' +
                            data['message'] + '</h6>';
                        $(".post-modal-btn").html(
                            '<a href="#" id="modal_closed" class="btn  themebtn1" data-dismiss="modal">{{__("postCarAdPage.carInfoPopupClose")}}</a> '
                        );
                        $(".carnumber-error").html('<strong>Error! </strong>' + data[
                            'message']);
                        $('#carnumber-error').show();
                        if(data['captacha']){
                            $("#myForm").show();
                        }
                        $('#myForm').trigger("reset"); 
                        $("#overlay").fadeOut(300);
                        clearFormInput();
                    } 
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 404 || xhr.status == 500) {
                        html =
                            '<h6 style="padding-top:50px" class="d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>{{__("postCarAdPage.userAlertNotify")}}</h6>';
                        $(".post-modal-btn").html('<a href="#" class="btn  themebtn1" data-dismiss="modal">{{__("postCarAdPage.carInfoPopupClose")}}</a>');
                        $(".carnumber-error").html('{{__("postCarAdPage.userAlertNotify")}}');
                        $('#carnumber-error').show();
                        $("#myForm").show();
                        $("#overlay").fadeOut(300);
                        clearFormInput();
                    }
                }
            }).done(function() {
                setTimeout(function() {
                    $("#overlay").fadeOut(300);
                }, 500);
            });
        $('#car_number').val(carnumber);
        
    });
    /*END*/

    /* LOAD MAKES AND MODELS YEARS VERSIONS START */
    $.ajax({
        url: "{{route('maker-list')}}",
        method: "get",
        success: function(data) {
            $('#make-listings').html(data);
            var check_array_for_make = $('#maker').val();
            $('#maker_' + check_array_for_make).addClass('list-active');
            $('#make_title_selected').html('(' + $('#maker_title').val() + ')');
        }
    }).done(function() {
        setTimeout(function() {
            $("#overlay").fadeOut(300);
        }, 500);
    });

    $("#car_info").click(function() {
        var maker = $('#maker').val();
        var modal = $('#model').val();
        var version = $('#version').val();
        var year = $('#year').val();
        $('.make-listings li').removeClass("list-active");
        $('.modal-listings li').removeClass("list-active");
        $('.modal-year-listings li').removeClass("list-active");
        $('.version-listings li').removeClass("list-active");

        if (maker != '') {
            $("#maker_" + maker).addClass("list-active");
            
        }
        if (modal != '') {
            $("#model_" + modal).addClass("list-active");
        }
        if (year != '') {
            $("#" + year).addClass("list-active");
        }
        if (version != '') {
            $("#version_" + version).addClass("list-active");
        }
    });

    function loadModels(id) {
        $.ajax({
            url: "{{url('get-make-models')}}/" + id,
            method: "get",
            beforeSend: function() {
                $('#models_listing').html('<div class="loader loader_models"></div>');
            },
            success: function(data) {
                $('.loader_models').addClass('d-none');
                $('.modal-listings li').removeClass('list-active');
                $('#models_listing').html(data);
            }
        }).done(function() {
            setTimeout(function() {
                $("#overlay").fadeOut(300);
            }, 500);
        });

    }

    function loadVersions(model_id,year) {
        $.ajax({
            url: "{{url('get-models-year-versions')}}/" + model_id + "/" + year,
            method: "get",
            beforeSend: function() {
                $('.version-list-col').css('display', 'block').addClass('car-list-active');
                $('.version-listings').html('<div class="loader loader_version"></div>');
            },
            success: function(data) {
                $('.loader_version').addClass('d-none');
                $('.version-listings').html(data);
                $('#year_selected').html('(' + $('#year').val() + ')');
                $('.modal-year-col').removeClass('car-list-active').addClass('prev-list-active');
                $('.version-list-col').css('display', 'block').addClass('car-list-active');
            }
        }).done(function() {});

    }

    function getVersionData(version_id) {
        $.ajax({
            url: "{{url('user/get-version-details')}}/" + version_id,
            method: "get",
            success: function(data) {
                if (data.body_type_id != null) {
                    $('#body_type_id').val(data.body_type_id).prop('selected', true);
                }
                if (data.number_of_door != null) {
                    $('#doors').val(data.number_of_door).prop('selected', true);
                }
                if (data.fueltype != null) {
                    $('#fuel_type').val(data.fueltype).prop('selected', true);
                }
                if (data.transmissiontype != null) {
                    $('#transmission_type').val(data.transmissiontype).prop('selected', true);
                }

            }
        }).done(function() {
            setTimeout(function() {
                $("#overlay").fadeOut(300);
            }, 500);
        });
    }

    $(document).on('click', '.makes', function() {

        var old_make_id = $('#maker').val();
        var make_id = $(this).data('make');
        
        if(old_make_id != make_id){
        $('.make-listings li').removeClass("list-active");

        loadModels(make_id);

        $('.make-list-col').removeClass('car-list-active').addClass('prev-list-active');
        $('.modal-list-col').css('display', 'block').addClass('car-list-active').removeClass('prev-list-active');
        $('.modal-year-col').css('display', 'none').removeClass('car-list-active');
        $('.version-list-col').css('display', 'none').removeClass('car-list-active');

        var maker_title = $(this).data("title");
        $('#maker').val(make_id);
        $('#maker_title').val(maker_title);
        $('#model').val('');
        $('#version').val('');

        $('#make_title_selected').html('(' + maker_title + ')');
        $('#model_value_selected').html('');
        $('#year_selected').html('');

        $("#maker_" + make_id).addClass("list-active");
        }
    });
    
    $(document).on('click', '.models', function() {
        
        var old_modal_id = $('#model').val();
        var model_id = $(this).data("model");
        
        if(old_modal_id != model_id){

        $('.modal-list-col').removeClass('car-list-active').addClass('prev-list-active');
        $('.modal-year-col').css('display', 'block').addClass('car-list-active');
        $('.version-list-col').addClass('d-none');

        $('#model').val(model_id);
        $('#model_title').val($(this).data("title"));

        
        $('#model_value_selected').html('(' + $('#model_title').val() + ')');
        $('#year_selected').html('');
        
        $('#version').val('');
        $('#year').val('');

        $('.modal-listings li').removeClass("list-active");
        $('.modal-year-listings li').removeClass("list-active");
        $('.version-listings li').removeClass("list-active");
        $('#model_' + model_id).addClass('list-active');

        }
    });

    $(document).on('click', '.model_years', function() {
        var old_year = $('#year').val();
        var year = $(this).data("year");
        if(old_year != year){

        $('.modal-year-col').removeClass('car-list-active').addClass('prev-list-active');
        $('.version-list-col').css('display', 'block').addClass('car-list-active');

        $('#year').val(year);
        
        $('.modal-year-listings li').removeClass("list-active");
        $('.version-listings li').removeClass("list-active");
        $("#" + year).addClass("list-active");

        var model_id = $('#model').val();
        $('#year_selected').html('(' + $('#year').val() + ')');
        $('.version-list-col').removeClass('d-none');

        loadVersions(model_id,year);
        }
    });

    $(document).on('click', '.versions', function() {
        var old_version_id = $('#version').val();
        var version_id = $(this).data("version");
        if(old_version_id != version_id){

        
        var maker_title = $('#maker_title').val();
        var model_title = $('#model_title').val();
        var year = $('#year').val();
        var version_title = $(this).data("title");
        var cc = $(this).data("cc");
        var power = $(this).data("power");
        var transmission_body = $(this).data("transmission_body");

        $('#version').val(version_id);
        $('#version_title').val(version_title);

        $('.version-listings li').removeClass("list-active");
        $("#version_" + version_id).addClass("list-active");
        
        $('#car_info').val(maker_title + "/" + model_title + "/" + year + "/" + version_title + " " + cc + " L " + transmission_body);
        
        $('.addInformation').show();
        $('#engine_capacity').val(cc);
        $('#engine_power').val(power);
        getVersionData(version_id);
        }
        $('#postedcarinfo').modal('hide');
    });
   
    $("#car_info").keypress(function(e) {
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
    $("#car_info").bind("contextmenu", function(e) {
        e.preventDefault();
    });


    function clearFormInput() {
        $('#myForm').trigger("reset");
        $("#myForm")[0].reset();
        $("select").closest("form").on("reset", function(ev) {
            var targetJQForm = $(ev.target);
            setTimeout((function() {
                this.find("select").trigger("change");
            }).bind(targetJQForm), 0);
        });
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    uploadHBR.init({
        "target": "#uploads",
        "max": 8,
        "textNew": "{{__('postCarAdPage.textNew')}}",
        "textTitle": "{{__('postCarAdPage.textTitle')}}",
        "textTitleRemove": "{{__('postCarAdPage.textTitleRemove')}}",
        "mimes": ["image/jpeg", "image/png","image/gif"],
        "showExtensionError":true,
        "messageSelector":"print-error-msg",
        "errorMessage":"{{__('postCarAdPage.invalidFiles')}}",
        "errorMessages":'{{ __("postCarAdPage.tooBigImages") }}'
        });

    $('#reset').click(function() {
        uploadHBR.reset('#uploads');
    });

    $('.uploadBtn').click(function() {
        $('#new_0').trigger('click');
        setTimeout(function() {
            $('#uploads').removeClass('d-none');
            $('.main_cover_photo').removeClass('d-none');
        }, 1000);
    });

    setTimeout(function() {
            $('#carnumber-error').hide(); 
            $('#carnumbererror').hide(); 
        }, 30000);
    var customer_role = "{{$customerDetail->customer_role}}";
    $('select.city_select').prop('disabled', true);
    @if(Session::has('ad'))
        $('.not_found').removeClass('d-none');
        $('.make_it_featured').trigger('click');
    @endif

    $("#reset").click(function() {
        $('#description_count').html(995);
        $('#description').val('');
        $('.suggestions-tags a span').css('display', 'inline-block');
    });

    $('.show_more_suggestions').on('click', function() {
        $('.add-suggestion').toggleClass('suggestion-class');
        var check = $('.add-suggestion').hasClass('suggestion-class');
        if (check == true) {
            // alert(check);
            $('.show_more_suggestions').text('{{__("postCarAdPage.less")}}');
        } else {
            $('.show_more_suggestions').text('{{__("postCarAdPage.more")}}');

        }
    });

    $("#description").keyup(function(e) {
        // alert('hi');
        $("#description").prop('maxlength', '995');
        var max = 995;
        var text = $('#description').val().length;
        var remaining = max - text;
        $('#description_count').html(remaining);

        if (max == $('#description').val().length) {
            $("#description_error").html("Maximun letter 995").show().fadeOut("slow");
            return false;
        }
    });

    /* AUT FORM SCRIPT */
    $(document).ajaxSend(function() {
        $("#overlay").fadeIn(300);
    });

    $(document).on('click', '#form_submit', function(e) {
        $("#car_number_form").submit();
    });

    function clearForm() {
        $('#myForm').trigger("reset");
        $("#myForm")[0].reset();
        $("select").closest("form").on("reset", function(ev) {
            var targetJQForm = $(ev.target);
            setTimeout((function() {
                this.find("select").trigger("change");
            }).bind(targetJQForm), 0);
        });
    }
    $("#myForm").validate({
        rules: {
            country_id: {
                required: true
            },
            car_info: {
                required: function(element) {
                    if ($("#car_info").val() == '' || $("#maker").val() == '' || $("#model")
                        .val() == '' || $("#version").val() == '') {
                        return true;
                    } else {
                        return false
                    }
                }
            },
            body_type_id: {
                required: true
            },
            doors: {
                required: true
            },
            color: {
                required: true
            },
            millage: {
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
            poster_city: {
                required: true
            }
        },
        messages: {
            country_id: "{{__('postCarAdPage.pleaseSelectACountry')}}",
            car_info: "{{__('postCarAdPage.pleaseSelectMakeModelYearAndVersionsEtc')}}",
            body_type_id: "{{__('postCarAdPage.pleaseSelectaBodytype')}}",
            doors: "{{__('postCarAdPage.pleaseSelectDoor')}}",
            color: "{{__('postCarAdPage.pleaseSelectColor')}}",
            millage: "{{__('postCarAdPage.pleaseEnterMileage')}}",
            price: "{{__('postCarAdPage.pleaseEnterPrice')}}",
            description: "{{__('postCarAdPage.pleaseEnterDescription')}}",
            engine_capacity: "{{__('postCarAdPage.pleaseEnterEngineCapacity')}}",
            engine_power: "{{__('postCarAdPage.pleaseEnterEnginePower')}}",
            poster_city: "{{__('postCarAdPage.pleaseSelectPosterCity')}}"
        },
        submitHandler: function(form) {
                var number_of_days = $("[name=number_of_days]").val();
                if (typeof number_of_days == 'undefined') {
                    $.ajax({
                        url: "{{route('check_individual_ads')}}",
                        type: 'GET',
                        beforeSend: function() {
                            $("#overlay").fadeOut(300);
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
                                    headers: {
                                        "accept": "application/json",
                                    },
                                    cache: false,
                                    dataType: 'json',
                                    beforeSend: function() {
                                        $("#overlay").fadeIn(300);
                                    },
                                    success: function(response) {
                                        $("#overlay").fadeOut(300);
                                        
                                        window.location = "{{route('my-ads')}}?status=0";
                                    }
                                }).fail(function(jqXHR, textStatus, errorThrown) {
                                    $("#overlay").fadeOut(100);
                                    if (jqXHR.status === 422) {
                                        var errors = $.parseJSON(jqXHR.responseText);
                                        printErrorMsg(errors);
                                    }
                                });
                            }
                        }
                    });
                } // END typeof number_of_days == 'undefined'
                else {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        headers: {
                            "accept": "application/json",
                        },
                        cache: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $("#overlay").fadeIn(300);
                        },
                        success: function(response) {
                            $("#overlay").fadeOut(300);
                            $('.invoice_number').val(response.invoice_id);
                            if (response.payment_status != 'full') {
                                $("#invoice_number_form").submit();
                            }
                            
                            window.location = "{{route('my-ads')}}?status=0";
                        }

                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        $("#overlay").fadeOut(100);
                        if (jqXHR.status === 422) {
                            var errors = $.parseJSON(jqXHR.responseText);
                            printErrorMsg(errors);
                        }
                    });
                } // ELSE ENDS HERE
            

        } //SUBMIT HANDLER ENDS HERE.

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
                $(cssClass + " .print-error-message").find("ul").append('<li>' + "{{__('postCarAdPage.message')}}" + '</li>'); //this is my div with messages
            }
        });
    }



    function getCarInfo(e) {

        var year_id = $(e).data('id');
        $.ajax({
            url: "{{url('get-makers-from-year')}}/" + year_id,
            method: "get",
            success: function(data) {
                $('#makers_list').html(data);
                $('#year').val(year_id);
            }
        });


    }
    function getModels(e) {
        var maker_id = $(e).data('id');
        $.ajax({
            url: "{{url('get-models-from-maker')}}/" + maker_id,
            method: "get",
            success: function(data) {
                $('#models_list').html(data);
                $('#maker').val(maker_id);
            }
        });

    }
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
    function textAreaCharacters() {
        $("#description").prop('maxlength', '995');
        var max = 995;
        var text = $('#description').val().length;
        var remaining = max - text;
        $('#description_count').html(remaining);

        if (max == $('#description').val().length) {
            $("#description_error").html("Maximun letter 995").show().fadeOut("slow");
            return false;
        }

    }
    function getSentence(e) {
        textAreaCharacters();
        var sentence = $(e).data('sentence');
        var id = $(e).data('id');
        var old_sentense = $('#description').val();
        var new_sentense = old_sentense + ' # ' + sentence;
        $('#description').val(new_sentense);
        var field = '<input type="hidden" name="tags[]" value="' + id +
            '"><input type="hidden" name="suggessions[]" value="' + sentence + '">';
        $('.suggestions-tags').append(field);
        $(e).hide();
    }
    function getSubCategory(e) {
        var cat_id = $(e).data('id');
        var cat_title = $(e).data('title');
        $('#category_id').val(cat_title);
        $.ajax({
            url: "{{url('get-subcategories')}}/" + cat_id,
            method: "get",
            success: function(data) {
                $('#sub_category_list').html(data);
            }
        });

    }
    function selectCategory(e) {
        var sub_category_id = $(e).data('id');
        $('#sub_category').val(sub_category_id);
        var display_value = $('#category_id').val() + '/' + $(e).data('title');
        $('#categories').val(display_value);
        $('#categoriesModal').modal('hide');
    }

    $(".featured_request_form").on('submit', function(e) {
        e.preventDefault();
        var use_balance = $('.use_balance').val();
        var featured_days = $('#featured_days').val();
        if (featured_days == '') {
            $("#featured_request_form-error").show();
            return false;
        } else {
            $('#myForm').find('.number_of_days').remove();
            $('#myForm').find('#use_balance').remove();
            if (use_balance == 'on') {
                $('#myForm').append('<input type="hidden"  name="use_balance" id="use_balance" value="' + use_balance + '" />');
            }

            $('#myForm').append('<input type="hidden" class="number_of_days" name="number_of_days" id="number_of_days" value="' + featured_days + '" />');
            $("#featured_request_form-error").hide();
            $('#myForm').submit();
        }

    });
    $(document).on('click', '.discard_ads', function() { // For time beign not in use
        var ad_id = $(this).data('id');
        /*******************/
        swal({
                title: "Alert!",
                text: "Are you sure you want to discard this Ad?",
                type: "info",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes!",
                cancelButtonText: "No!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    $('#loader_modal').modal('show');
                    /*******************************/
                    $.ajax({
                        url: "{{ route('discard-ad')}}",
                        method: "get",
                        data: {
                            id: ad_id
                        },
                        success: function(data) {
                            if (data.success == true) {
                                window.location = data.url;
                            }
                        }
                    });


                    /*******************************/
                } else {
                    swal("Cancelled", "", "error");
                }

            });
        /*******************/

    });
});    
</script>
@endpush
@endsection