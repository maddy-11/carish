@extends('layouts.app')
@section('title') {{ __('landingPage.pageTitle') }} @endsection
@push('styles')
<link rel="stylesheet" media="all" href="{{ asset('public/css/home.css')}}">
@endpush
@push('scripts')
<script type="text/javascript" charset="utf-8" async>
    var image_path = "{{asset('public/uploads/ad_pictures/cars')}}";
    var getmakers_versions = "{{route('getmakers.versions')}}";
    var get_versions = "{{url('get_versions')}}";
    var baseUrl = "{{url('/')}}";
    var get_ads_compared = "{{route('get.ads.compared')}}";
    var getbody_types = "{{route('getbody.types')}}";
    var get_cities = "{{route('get.cities', ['type' => 'ct'])}}";
    var selectCityReg = "{{route('get.cities', ['type' => 'ctreg'])}}";
    var get_colors = "{{route('get.colors')}}";
    var getcc_versions = "{{route('getcc.versions')}}";
    var getkw_versions = "{{route('getkw.versions')}}";
    var sorry_invalid_price_range = "{{ __('landingPage.sorryInvalidPriceRange') }}";

    var searchUrl = "{{route('simple.search')}}";
    var imagespath = "{{asset('public/uploads/image/')}}";
    var categoryMakeModels = "{{route('category.make.models')}}";
    var fetchBodyTypes = "{{route('fetch.body.types')}}";
    $(document).ready(function() {
        let dateDropdown = $('.years');
        let currentYear = new Date().getFullYear();
        let earliestYear = 1942;
        while (currentYear >= earliestYear) {
            let dateOption = document.createElement('option');
            dateOption.text = currentYear;
            dateOption.value = currentYear;
            dateDropdown.append(dateOption);
            currentYear -= 1;
        }
    });
</script>

<script src="{{ asset('public/js/home.js')}}"></script>
@endpush
@section('content')
<!-- header Ends here -->
<!--cheking the repo on git hub-->
<!--chekcing code on development-->
@php
$activeLanguage = \Session::get('language');
@endphp
<div class="banner text-center text-white" style="background-image: url({{ asset('public/assets/img/banner.jpg')}});">
    <div class="container">
        <div class="row">
            <div class="col-12 search-form-col">
                <h1 class="font-weight-semibold">{{ __('landingPage.mainTagLine') }}</h1>
                <h2 class="font-weight-semibold pb-4">"{{ __('landingPage.secondTagLine') }}"</h2>
                {{-- <form action="{{url('search',['true'])}}" method="get" id="simple_search"> --}}
                <div class="form-row form-search-row text-left justify-content-center mb-md-3">
                    <div class="col-12 col-lg-5 form-group pr-0 searchcol">
                        <input type="hidden" value=""  name="keyword" id="keyword" class="search_text_submit" data-value="keyword_">
                        <input type="text" id="car_make_model" name="q" data-value="q_" value="" placeholder="{{__('landingPage.makeModelText')}}" class="form-control">
                        <input type="hidden" id="make_models_combine" class="search_text_submit" data-value="m0_" value="">
                        <input type="hidden" name="car_make_model" id="make_models" class="search_text_submit" data-value="mk_" value="">
                        <input type="hidden" name="" id="make_models_version" value="" class="search_text_submit">
                    </div>
                    <div class="col-lg-3 col-12 form-group selectCol pl-0 pr-0 selectfieldcol farooq">


                        <select class="selectpicker search_text_submit" data-live-search="true">
                            <option value="" selected>{{__('landingPage.allCities')}}</option>
                            @foreach($cities as $city)
                            <option value="ct_{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 col-12 form-group selectCol pl-0 pr-0 selectfieldcol">
                        <select class="selectpicker" multiple name="tags[]" id="tags">
                            <option value="">{{__('landingPage.selectTags')}}</option>
                            @if (!$tags->isEmpty()) {
                            @foreach($tags as $tag){
                            <option value="tg_{{$tag->id}}">
                                {{$tag->tagsDescription()->where('language_id',$activeLanguage['id'])->pluck('name')->first()}}
                            </option>
                            @endforeach
                            @endif
                        </select>

                    </div>
                    <div class="form-group pl-0 searchsubmit">
                        <button type="button" value="Search" class="btn fa fa-search searchBtn themebtn3 search_check_submit"></button>
                    </div>
                </div>
                {{-- </form> --}}
                <div class="form-row advanceSearch text-center justify-content-end">
                    <div class="col-12 advSearchCol pl-0 overflow-hidden text-center">
                        <a href="javascript:void(0)" class="btn font-weight-normal px-5 text-nowrap advanced_search_btn" data-toggle="modal" data-target="#advanceSearch">{{ __('popupAdvanceSearch.advanceSearchTitle') }} <em class="fa fa-angle-right ml-1"></em></a>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal text-left fade advSearch" id="advanceSearch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form action="{{url('search',['true'])}}" method="get" id="simple_search">
                                <div class="modal-header pb-2 pt-2">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('popupAdvanceSearch.advanceSearchTitle') }}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                
                                <div class="modal-body  pl-md-4 pr-md-4 pt-4">




                                    <div class="form-row">


                                        {{-- SEARCH DROP DOWN --}}

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group selectFromCol" style="position: relative;">
                                            <label class="font-weight-semibold">{{ __('popupAdvanceSearch.price') }}</label>
                                            <span class="align-items-center border d-block d-flex pricerange px-3 py-1">
                                                <i class="fa fa-angle-down" aria-hidden="true" style="position: absolute;right: 15px;font-weight: bold;"></i>
                                                <div class="select-prng">{{__('popupAdvanceSearch.all')}}</div>
                                                <div class="pr-range-min" style="display: none"></div>
                                                <div class="pr-range-dash px-1" style="display: none">-</div>
                                                <div class="pr-range-max" style="display: none"></div>
                                            </span>
                                            <div class="pr-dropdown pr-dropdown-cls" style="display: none;position: absolute;top: 70px;width: 96%;">
                                                <div class="d-flex pt-2 pr-2 pl-2" style="background-color: #EAF0FF">
                                                    <input type="text" name="minPrice" id="minPrice" placeholder="{{__('popupAdvanceSearch.from')}}" class="form-control form-control-sm mb-2">
                                                    <span style="line-height: 2.5;" class="pr-2 pl-2">-</span>
                                                    <input type="text" name="maxPrice" id="maxPrice" placeholder="{{__('popupAdvanceSearch.to')}}" class="form-control form-control-sm mb-2">
                                                </div>
                                                <div class="d-flex">

                                                    <div class="p-2 pr-min w-50">

                                                        <ul class="min-price-list list-unstyled mb-0" style="">@for($i =
                                                            1000;$i<=5000;$i+=1000) <li>{{$i}}</li>
                                                                @endfor
                                                        </ul>
                                                    </div>
                                                    <div class="p-2 pr-max">
                                                        <ul class="max-price-list list-unstyled mb-0" style="display: none;"> @for($i = 1000;$i<=5000;$i+=1000) <li>{{$i}}</li>
                                                                @endfor
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- END DROP DOWN --}}
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label class="font-weight-semibold">{{ __('popupAdvanceSearch.year') }}</label>
                                            <div class="form-row">
                                                <div class="col-lg-6 col-md-6 col-6 pr-0 form-group mb-0 selectFromCol">
                                                    <select id="yearFrom" class="form-control years">
                                                        <option value="">{{ __('popupAdvanceSearch.from') }}</option>

                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-6 pl-0 form-group mb-0 selectToCol">
                                                    <select name="selectYearTo" id="yearTo" class="form-control years">
                                                        <option value="">{{ __('popupAdvanceSearch.to') }}</option>

                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group selectFromCol" style="position: relative;">
                                            <label class="font-weight-semibold">{{ __('popupAdvanceSearch.mileage') }}</label>
                                            <span class="align-items-center border d-block d-flex mileagerange px-3 py-1" style="height: 3rem;">
                                                <i class="fa fa-angle-down" aria-hidden="true" style="position: absolute;right: 15px;font-weight: bold;"></i>
                                                <div class="select-prng-mileage">{{__('popupAdvanceSearch.all')}}</div>
                                                <div class="pr-mileage-min" style="display: none"></div>
                                                <div class="pr-mileage-dash px-1" style="display: none">-</div>
                                                <div class="pr-mileage-max" style="display: none"></div>
                                            </span>
                                            <div class="pr-dropdown-mileage pr-dropdown-cls" style="display: none;position: absolute;top: 70px;width: 96%;">
                                                <div class="d-flex pt-2 pr-2 pl-2" style="background-color: #EAF0FF">
                                                    <input type="text" name="fromMillage" id="fromMillage" placeholder="{{__('popupAdvanceSearch.from')}}" class="form-control form-control-sm mb-2">
                                                    <span style="line-height: 2.5;" class="pr-2 pl-2">-</span>
                                                    <input type="text" name="toMillage" id="toMillage" placeholder="{{__('popupAdvanceSearch.to')}}" class="form-control form-control-sm mb-2">
                                                </div>
                                                <div class="d-flex">

                                                    <div class="p-2 pr-min w-50">

                                                        <ul class="min-mileage-list list-unstyled mb-0">
                                                            <li data-id="10000">10,000 km</li>
                                                            <li data-id="20000">20,000 km</li>
                                                        </ul>
                                                    </div>
                                                    <div class="p-2 pr-max">

                                                        <ul class="max-mileage-list list-unstyled mb-0" style="display: none;">
                                                            <li data-id="10000">10,000 km</li>
                                                            <li data-id="20000">20,000 km</li>
                                                            <li data-id="30000">30,000 km</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                    </div>

                                    <div class="form-row mt-4 pt-sm-2 collapse show" id="moreCollapsedFields">

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label class="font-weight-semibold">{{ __('popupAdvanceSearch.versions') }}</label>
                                            <select name="selectVersion" id="selectVersion" class="form-control search_selectbox_submit">
                                                <option value="">{{ __('popupAdvanceSearch.all') }}</option>
                                            </select>
                                        </div>



                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label class="font-weight-semibold">{{ __('popupAdvanceSearch.fuel') }}</label>

                                            <select id="engine_type" name="engine_type" class="form-control search_selectbox_submit">
                                                <option value="">{{ __('popupAdvanceSearch.all') }}</option>
                                                @if(!$engineTypes->isEmpty())
                                                @foreach($engineTypes as $eTypes)
                                                <option value="fuel_{{$eTypes->title}}">{{$eTypes->title}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label class="font-weight-semibold">{{ __('popupAdvanceSearch.enginePower') }}</label>
                                            <div class="form-row">
                                                <div class="col-lg-6 col-md-6 col-6 pr-0 form-group mb-0 selectFromCol">
                                                    <select name="powerFrom" id="powerFrom" class="form-control">
                                                        <option value="">{{ __('popupAdvanceSearch.from') }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-6 pl-0 form-group mb-0 selectToCol">
                                                    <select name="powerTo" id="powerTo" class="form-control">
                                                        <option value="">{{ __('popupAdvanceSearch.to') }}</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label class="font-weight-semibold">{{ __('popupAdvanceSearch.engineCapacity') }}</label>
                                            <div class="form-row">
                                                <div class="col-lg-6 col-md-6 col-6 pr-0 form-group mb-0 selectFromCol">
                                                    <select name="CapacityFrom" id="engineccFrom" class="form-control">
                                                        <option value="">{{ __('popupAdvanceSearch.from') }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-6 pl-0 form-group mb-0 selectToCol">
                                                    <select name="CapacityTo" id="engineccTo" class="form-control">
                                                        <option value="">{{ __('popupAdvanceSearch.to') }}</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 form-group mb-0">
                                            <label class="font-weight-semibold">{{ __('popupAdvanceSearch.otherDetails') }}</label>
                                            <div class="form-row">
                                            
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                                <label class="font-weight-semibold">{{ __('popupAdvanceSearch.transmission') }}</label>
                                                <select id="transmission" name="transmission" class="form-control search_selectbox_submit">
                                                    <option value="" disabled="true" selected>
                                                        {{ __('popupAdvanceSearch.all') }}
                                                    </option>
                                                    @if(!$transmissions->isEmpty())
                                                    @foreach($transmissions as $transmission)
                                                    <option value="transmission_{{$transmission->title}}">
                                                        {{$transmission->title}}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group search_selectbox_submit">
                                                <label class="font-weight-semibold">{{ __('popupAdvanceSearch.bodyType') }}</label>
                                                <select id="body_type" name="body_type" class="form-control">
                                                    <option value="" disabled="true" selected>
                                                        {{ __('popupAdvanceSearch.all') }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                                <label class="font-weight-semibold">{{ __('popupAdvanceSearch.color') }}</label>
                                                <select name="color" id="color" class="form-control search_selectbox_submit">
                                                    <option value="">{{ __('popupAdvanceSearch.all') }}</option>
                                                </select>
                                            </div>
                                    

                                    </div>
                                </div>
                                <div class="col-12 form-group mb-0">
                                    <label class="font-weight-semibold">{{ __('popupAdvanceSearch.allProperties') }}</label>
                                    <div class="form-row">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label class="font-weight-semibold">{{ __('popupAdvanceSearch.adPicture') }}</label>
                                            <select id="picture" name="have_picture" class="form-control search_selectbox_submit">
                                                <option value="" disabled="true" selected>{{ __('popupAdvanceSearch.all') }}</option> 
                                                <option value="">{{ __('popupAdvanceSearch.adWithOutPicture') }} </option>
                                                <option value="pic_Ads-With-Pictures">{{ __('popupAdvanceSearch.adWithPictureOnly') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label class="font-weight-semibold">{{ __('popupAdvanceSearch.sellerType') }}</label>
                                            <select id="ads_type" name="ads_type" class="form-control search_selectbox_submit">
                                                <option value="" disabled="true" selected>{{ __('popupAdvanceSearch.all') }}
                                                </option>
                                                <option value="seller_individual">{{ __('popupAdvanceSearch.sellerTypeIndividual') }}
                                                </option>
                                                <option value="seller_business">{{ __('popupAdvanceSearch.sellerTypeDealer') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label class="font-weight-semibold">{{ __('popupAdvanceSearch.adType') }}</label>
                                            <select id="featured" name="is_featured" class="form-control search_selectbox_submit">
                                                <option value="">{{__('popupAdvanceSearch.all')}}</option>
                                                <option value="isf_featured">{{ __('popupAdvanceSearch.adTypeFeatureAds') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>


                    <div class="align-items-center border-top-0 d-flex justify-content-between modal-footer pb-4 pl-md-4 pr-md-4 pt-0">
                        <a class="LessMoreOptions font-weight-semibold themecolor" data-toggle="collapse" href="#moreCollapsedFields" aria-expanded="true" aria-controls="moreCollapsedFields">
                            <span class="moreFields">{{ __('popupAdvanceSearch.showMore') }}</span> <span class="lessFields">{{ __('popupAdvanceSearch.showLess') }}</span><em class="fa fa-angle-down"></em>
                        </a>
                        <button type="submit" class="btn themebtn3 search_check_submit">{{ __('popupAdvanceSearch.buttonText') }}</button>
                    </div>


                    </form> {{-- END OF ADVANCE SEARCH FORM  --}}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- features Starts here -->
<div class="container mt-5 mb-sm-5 d-md-block d-none">
    <div class="row servicesRow text-center">
        <div class="col-sm-4 col-md-4 col-12 pl-xl-4 pr-xl-4 servicesCol mb-4 mb-sm-0">
            <img src="{{ asset('public/assets/img/feature-1.png')}}" class="img-fluid mb-2 mb-md-3" alt="carish used cars for sale in estonia">
            <h5 class="font-weight-bold themecolor">* {{ __('landingPage.*****') }}</h5>
            <p>{{ __('landingPage.******') }} <a target="" href="{{route('faqs')}}" class="themecolor"><u>{{ __('landingPage.forfree') }}</u></a> {{ __('landingPage.inFewSeconds') }}</p>


            <!-- Post you car ad for free( make for free text a link where after click we will revert user to more page with free post ad policy ) in few seconds -->
        </div>
        <div class="col-sm-4 col-md-4 col-12 pl-xl-4 pr-xl-4 servicesCol mb-4 mb-sm-0">
            <img src="{{ asset('public/assets/img/feature-2.png')}}" class="img-fluid mb-2 mb-md-3" alt="carish used cars for sale in estonia">
            <h5 class="font-weight-bold themecolor">{{ __('landingPage.verifiedBuyers') }}</h5>
            <p>{{ __('landingPage.verifiedBuyersDetailText') }}</p>
        </div>
        <div class="col-sm-4 col-md-4 col-12 pl-xl-4 pr-xl-4 servicesCol mb-4 mb-sm-0">
            <img src="{{ asset('public/assets/img/feature-3.png')}}" class="img-fluid mb-2 mb-md-3" alt="carish used cars for sale in estonia">
            <h5 class="font-weight-bold themecolor">{{ __('landingPage.sellFast') }}</h5>
            <p>{{ __('landingPage.sellFastDetailText') }}</p>
        </div>
    </div>
</div>
<!-- features Ends here -->


<!-- Browse Used Cars Starts here -->
<div class="browse-used-cars pb-4 pt-md-5 pt-4 sects-bg">
    <div class="container">
        <div class="section-title mb-4">
            <h2 class="sectTitle font-weight-semibold mb-0">{{ __('landingPage.browseUsed') }}
                <span>{{trans_choice('landingPage.carsTextInBlueColor', 1)}}</span>
            </h2>
        </div>
        <div class="row b-UsedCars-row">
            <div class="col-12 buCars">
                <ul class="nav nav-tabs buCarTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#buCars-tab1">{{ __('landingPage.make') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#buCars-tab2">{{ __('landingPage.city') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#buCars-tab3">{{ __('landingPage.bodyType') }}</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane p-4 browse-cb active" id="buCars-tab1"></div>
                    <div class="tab-pane p-4" id="buCars-tab2"></div>
                    <div class="tab-pane" id="buCars-tab3"></div>
                    <!-- tab one starts here -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Browse Used Cars Ends here -->


<!-- features Starts here -->
<div class="about-us pt-4">
    <div class="container">
        <div class="section-title mb-md-4 pb-1">
            <h4 class="sectTitle font-weight-semibold mb-0">{{ __('landingPage.why')}}
                <span>{{__('landingPage.keywords')}}</span>
            </h4>
        </div>
        <div class="ml-0 mr-0 row">
            <div class="col-lg-6 col-md-6 col-12 pl-4 pr-4 bg-white">
                {!!@$page_description->description!!}
            </div>
            <div class="col-lg-6 col-md-6 col-12 mt-3 mt-md-0 carish-ad pl-md-3 pr-md-3 pl-0 pr-3 text-center">
                <img src="{{ asset('public/assets/img/about_us.webp')}}" class="img-fluid" alt="carish used cars for sale in estonia">
            </div>
        </div>
    </div>
</div>
<!-- features Ends here -->

<!-- features Starts here -->
<div class="featured-UsedCars mb-md-5 mt-md-5 mb-4 mt-4 sects-bg">
    <div class="container">
        <div class="section-title d-flex justify-content-between align-items-end">
            <h2 class="sectTitle font-weight-semibold mb-0">{{__('landingPage.featuredUsed')}}
                <span>{{ __('landingPage.carsTextInBlueColor')}}</span>
            </h2>
            <a target="" href="{{route('simple.search')}}/used-cars-for-sale/isf_featured" class="viewall-post themecolor">{{__('landingPage.viewAllFeaturedUsedCars')}}</a>
        </div>
        <div class="owl-carousel owl-theme featured-uc-slider text-center" id="feat-UsedCars">
            @foreach($featured_ads as $featured_ad)
            <div class="item">
                <div class="box-shadow feature_ads" style="">
                    <figure class="mb-0 position-relative text-left">
                        @if(@$featured_ad->ads_images[0]->img != null && file_exists( public_path() .
                        '/uploads/ad_pictures/cars/'.$featured_ad->id.'/'.@$featured_ad->ads_images[0]->img))
                        {{-- <div class="bgImg" style="background-image: url({{asset('public/uploads/ad_pictures/cars/'.$featured_ad->id.'/'.$featured_ad->ads_images[0]->img)}})">
                </div> --}}
                <div class="main_page_images" style="background-image: url({{asset('public/uploads/ad_pictures/cars/'.@$featured_ad->id.'/'.$featured_ad->ads_images[0]->img)}}); width: 100%;
                height: 170px;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: 50% 50%;">
                </div>
                @else
                {{-- <div class="bgImg" style="background-image: url({{ asset('public/assets/img/caravatar.jpg')}})">
            </div> --}}
            <div class="main_page_images" style="background-image: url({{asset('public/assets/img/caravatar.jpg')}}); width: 100%;
                height: 170px;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: 50% 50%;">
            </div>
            @endif
            <figcaption class="position-absolute">
                <span class="bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-uppercase text-white d-inline-block">{{__('landingPage.featured')}}</span>
            </figcaption>
            </figure>
            <div class="p-3">
                <h5 class="font-weight-semibold mb-1"><a target="" href="{{url('car-details/'.$featured_ad->id)}}" class="stretched-link themecolor">{{$featured_ad->maker->title}} {{@$featured_ad->model->name}}
                        {{$featured_ad->year}}</a></h5>
                <p class="car-price mb-1">€{{$featured_ad->price}}</p>
                <span class="car-country">{{$featured_ad->bought_from}}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
</div>
</div>
<!-- features Ends here -->
<!-- Cars Comparison Starts here -->
<div class="cars-comparison pb-md-5 pt-md-5 pb-4 pt-4 sects-bg">
    <div class="container">
        <div class="section-title mb-md-4 pb-1">
            <h2 class="sectTitle font-weight-semibold mb-0"><span>{{ __('landingPage.carsTextInBlueColor')}}</span>
                {{__('landingPage.comparison')}}
            </h2>
        </div>
        <div class="ml-0 mr-0 row">
            <div class="col-lg-8 col-md-8 col-12 pl-4 pr-4 comparison-col bg-white">
                <h4 class="mb-lg-4 mb-md-3 mb-4 pb-xl-3">{{__('landingPage.confusedInSelection')}} <span class="font-weight-normal">{{__('landingPage.makeAComparison')}}</span></h4>
                <form method="post" action="{{route('comparedetails')}}" id="compare_form">
                    {{csrf_field()}}
                    <div class="d-sm-flex mx-0">
                        <div class="form-group w-100">
                            <label class="font-weight-semibold">{{__('landingPage.selectCar1')}}</label>
                            <input type="text" name="" placeholder="{{__('landingPage.carMakeModel')}}" class="border-dark form-control" id="ads_first_text" autocomplete="off" required>
                            <input type="hidden" name="compared_cars[]" id="ads_first" value="" required>

                        </div>
                        <div class="comparsn-logo mb-3 mt-auto px-3 text-center">
                            <span class="d-inline-block font-weight-bold rounded-circle themebtn1">VS</span>
                        </div>
                        <div class="form-group w-100">
                            <label class="font-weight-semibold">{{__('landingPage.selectCar2')}}</label>
                            <input type="text" name="" placeholder="{{__('landingPage.carMakeModel')}}" class="border-dark form-control" id="ads_second_text" autocomplete="off" required>
                            <input type="hidden" name="compared_cars[]" id="ads_second" value="" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="align-items-center col-12 d-flex form-group justify-content-between mt-lg-4 mt-2 mb-0">
                            <div class="comp-clear">
                                <a href="javascript:void(0)" class="font-weight-semibold themecolor clear_compare">{{__('landingPage.clear')}}</a>
                            </div>
                            <div class="comp-submit">
                                <input type="submit" value="{{__('landingPage.submit')}}" class="btn text-uppercase themebtn3">
                            </div>
                        </div>
                    </div>
                    <!-- Modal for car1 -->
                    <div class="modal fade" id="savedCarAd" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content sects-bg">
                                <div class="modal-header border-bottom-0 pl-md-4 pr-md-4">
                                    <h5 class="modal-title">{{__('popupCarComparison.mySavedAds')}} </h5>
                                    <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body comp-modal-body pl-md-4 pr-md-4 pb-4">
                                    <div class="bg-white">
                                        @if(Auth::guard('customer')->user() == null)
                                        <div class="overflow-auto p-4 saved-cars">
                                            <p><b>{{__('popupCarComparison.notLoggedIn')}} </b> <a href="{{url('user/login')}}" style="color: blue;text-decoration: underline;">{{__('popupCarComparison.clickHereToLogin')}}</a>
                                            </p>
                                            @else
                                            <div class="overflow-auto p-4 saved-cars saved-cars1">
                                                @endif
                                            </div>

                                        </div>
                                        <div class="text-center mt-4  mt-md-5">
                                            <button type="button" class="btn themebtn3" data-dismiss="modal">{{__('popupCarComparison.buttonText')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL FOR CAR 2 --}}

                        <div class="modal fade" id="savedCarAd2" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content sects-bg">
                                    <div class="modal-header border-bottom-0 pl-md-4 pr-md-4">
                                        <h5 class="modal-title">{{__('popupCarComparison.mySavedAds')}} </h5>
                                        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body comp-modal-body pl-md-4 pr-md-4 pb-4">
                                        <div class="bg-white">
                                            @if(Auth::guard('customer')->user() == null)
                                            <div class="overflow-auto p-4 saved-cars">
                                                <p><b>{{__('popupCarComparison.notLoggedIn')}} </b> <a href="{{url('user/login')}}" style="color: blue;text-decoration: underline;">{{__('popupCarComparison.clickHereToLogin')}}</a>
                                                </p>
                                                @else
                                                <div class="overflow-auto p-4 saved-cars saved-cars2">
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="comp-url mt-4  mt-md-5">
                                                <h5 class="mb-3">URL</h5>
                                                <span class="bg-white p-3 d-block">https://www.carish.com/used-cars/compare/carname</span>
                                            </div>
                                            <div class="text-center mt-4  mt-md-5">
                                                <button type="button" class="btn themebtn3" data-dismiss="modal">{{__('popupCarComparison.buttonText')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                </form>
            </div>
            <div class="col-lg-4 col-md-4 col-12 mt-3 mt-md-0 carish-ad pl-md-3 pr-md-3 pl-0 pr-3 text-center">
                <img src="{{ asset('public/assets/img/carish-ad.webp')}}" class="img-fluid" alt="carish used cars for sale in estonia">
            </div>
        </div>
    </div>
</div>
<!-- Cars Comparison Ends here -->
<!-- LOOKING TO SELL YOUR CAR Starts here -->
<div class="looking-sell-car pb-md-5 pt-md-5 pb-4 pt-4">
    <div class="container">
        <div class="align-items-center pl-xl-3 pr-xl-3 row sell-car-row">
            <div class="col-12 col-lg-6 col-md-6 pr-md-0 mb-3 mb-md-0 sell-car-col text-md-right text-center">
                <h2 class="font-weight-semibold mb-0 text-uppercase">{{__('landingPage.lookingToSellYourCar')}}</h2>
                <p class="mb-0">{{__('landingPage.getCashOffersToYour')}}</p>
            </div>
            <div class="col-12 col-lg-6 col-md-6 pl-md-4 pl-lg-5 sell-car-btn">
                <a target="" href="{{ route('sellcar') }}" class="btn btn-block font-weight-normal text-uppercase themebtn1">{{__('landingPage.submitYourVehicleNow')}}</a>
            </div>
            <div class="arrowImg col-12 text-center d-md-block d-none">
                <img src="{{ asset('public/assets/img/postarrow.png')}}" class="img-fluid ml-5 pl-5" alt="carish used cars for sale in estonia">
            </div>
        </div>
    </div>
</div>
<!-- LOOKING TO SELL YOUR CAR? Ends here -->

<!-- Popular Used Cars Starts here -->
<div class="popular-UsedCars pb-md-5 pt-md-5 pb-4 pt-4 sects-bg">
    <div class="container">
        <div class="section-title d-flex justify-content-between align-items-end">
            <h2 class="sectTitle font-weight-semibold mb-0">{{__('landingPage.used')}}
                <span>{{trans_choice('landingPage.carsTextInBlueColor',0)}}</span>
            </h2>
            <a target="" href="{{route('simple.search')}}/isp_popular" class="viewall-post themecolor">
                {{__('landingPage.viewALlUsedCars')}}

            </a>
        </div>
        <div class="owl-carousel owl-theme popular-uc-slider text-center" id="pop-UsedCars">
            @foreach($ads as $ad)
            <div class="item">
                <div class="box-shadow feature_ads bg-white p-0 pb-3">
                    <figure class="align-items-center d-flex justify-content-center">

                        @if(@$ad->ads_images[0]->img != null && file_exists( public_path() .
                        '/uploads/ad_pictures/cars/'.$ad->id.'/'.@$ad->ads_images[0]->img))
                        {{-- <img src="{{ asset('public/uploads/ad_pictures/cars/'.@$ad->id.'/'.$ad->ads_images[0]->img)}}"
                        class="img-fluid ads_image" alt="carish used cars for sale in estonia"> --}}
                        <div class="main_page_images" style="background-image: url({{asset('public/uploads/ad_pictures/cars/'.@$ad->id.'/'.$ad->ads_images[0]->img)}}); width: 100%;
                height: 170px;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: 50% 50%;">
                        </div>
                        @else
                        {{-- <img src="{{url('public/assets/img/caravatar.jpg')}}" alt="carish used cars for sale in estonia" class="img-fluid"
                        style="max-height: 140px;"> --}}
                        <div class="main_page_images" style="background-image: url({{asset('public/assets/img/caravatar.jpg')}}); width: 100%;
                height: 170px;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: 50% 50%;">
                        </div>
                        @endif
                    </figure>
                    <h5 class="font-weight-semibold mb-1"><a target="" href="{{url('car-details/'.$ad->id)}}" class="stretched-link themecolor">{{$ad->maker->title}} {{@$ad->model->name}}
                            {{$ad->year}}</a></h5>
                    <p class="car-price mb-1">€{{$ad->price}}</p>
                    <span class="car-country">{{$ad->bought_from}}</span>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
<!-- Popular Used Cars  Ends here -->
<!-- Cars Parts & Accessories Starts here -->
<div class="cars-parts-accessories my-md-5 my-4">
    <div class="container">
        <div class="section-title d-flex justify-content-between align-items-end">
            <h2 class="sectTitle font-weight-semibold mb-0"><span>{{trans_choice('landingPage.carsTextInBlueColor',0)}}</span>
                {{__('landingPage.partsAndAccessories')}}
            </h2>
        </div>
        <div class="owl-carousel owl-theme cars-parts text-center" id="cars-parts">
            @foreach($spare_parts_categories as $part_cat)
            <div class="item">
                <div class="box-shadow py-4 pl-3 pr-3">
                    <figure class="align-items-center d-flex justify-content-center">
                        @if(@$part_cat->image != null && file_exists( public_path() .
                        '/uploads/image/'.$part_cat->image))
                        <img src="{{ asset('public/uploads/image/'.@$part_cat->image)}}" class="img-fluid ads_image" alt="carish used cars for sale in estonia">
                        @else
                        <img src="{{ asset('public/assets/img/sparepartavatar.jpg')}}" class="img-fluid ads_image" alt="carish used cars for sale in estonia">
                        @endif
                    </figure>

                    <h5 class="font-weight-semibold"><a target="" href="{{url('find-autoparts/'.@$part_cat->slug)}}" class="stretched-link">{{$part_cat->get_category_title()->where('language_id',@$activeLanguage['id'])->pluck('title')->first()}}</a>
                    </h5>

                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4"><a target="" href="{{ route('findautoparts') }}" class="btn text-uppercase view-all-part">{{__('landingPage.viewAll')}}</a></div>
    </div>
</div>
<!-- Cars Parts & Accessories Ends here -->

<!-- Services Starts here -->
<div class="cars-parts-accessories pb-md-5 pt-md-5 sects-bg pt-4 pb-4">
    <div class="container">
        <div class="section-title d-flex justify-content-between align-items-end">
            <h2 class="sectTitle font-weight-semibold mb-0"><span>{{__('landingPage.offered')}}</span> {{__('landingPage.services')}}
            </h2>
        </div>
        <div class="owl-carousel owl-theme offered-service text-center" id="offered-service">
            @foreach($offered_services as $offered_service)
            <div class="item">
                <div class="box-shadow py-4 pl-3 pr-3">
                    <figure class="align-items-center d-flex justify-content-center">
                        @if(@$offered_service->image != null && file_exists( public_path() .
                        '/uploads/image/'.$offered_service->image))
                        <img src="{{ asset('public/uploads/image/'.@$offered_service->image)}}" class="img-fluid" alt="carish used cars for sale in estonia">
                        @else
                        <img src="{{ asset('public/assets/img/sparepartavatar.jpg')}}" class="img-fluid ads_image" alt="carish used cars for sale in estonia">
                        @endif
                    </figure>
                    <h5 class="font-weight-semibold"><a target="" href="{{url('find-car-services/'.@$offered_service->slug)}}" class="stretched-link">{{$offered_service->get_category_title()->where('language_id',@$activeLanguage['id'])->pluck('title')->first()}}</a>
                    </h5>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4"><a target="" href="{{ route('allservices') }}" class="btn text-uppercase view-all-part">{{__('landingPage.viewAll')}}</a></div>
    </div>
</div>
<!-- Services Ends here -->
@endsection
