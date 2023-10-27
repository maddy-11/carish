@extends('layouts.app')
@section('title') {{ @$page_title }} @endsection
<style type="text/css">
  #heart {
    color: gray;
    font-size: 20px;
  }

  #heart2 {
    color: #007bff;
    font-size: 20px;
  }

  #heart3 {
    color: gray;
    font-size: 20px;
  }

  #heart4 {
    color: #007bff;
    font-size: 20px;
  }

  .show_saved_ads {
    color: red;
    text-decoration: underline;
  }

  .sellercarInfo {
    max-height: 68px;
  }

  .lSGallery>li img {
    /*height: 146px !important;*/
  }

  .lSSlideOuter .lSPager.lSGallery img {
    height: 100px !important;
    object-fit: cover;
  }

  #ex3::-webkit-scrollbar {
    width: 7px;
    background-color: #eee;
  }

  #ex3::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 0px;
  }

  #ex3::-webkit-scrollbar-thumb:hover {
    background-color: #aaa;
    /*border:1px solid #333333;*/
  }

  #ex3::-webkit-scrollbar-thumb:active {
    background-color: #aaa;
    /*border:1px solid #333333;*/
  }

  #ex3::-webkit-scrollbar-track {
    /*border:1px gray solid;*/
    /*border-radius:10px;*/
    /*-webkit-box-shadow:0 0 6px gray inset;*/
  }

  .usingCss {
    height: auto !important;
  }

  @media (max-width: 767px) {
    .usingCss {
      height: auto !important;
    }
  }

  .add_pointer {
    cursor: no-drop;
  }

  #image-gallery {
    height: auto !important;
  }

  @media (max-width: 575px) {
    .mobile-modal {
      width: 80% !important;
    }
  }

  #cke_10 {
    display: none;
  }
</style>

<link href="{{ asset('public/assets/css/lightslider.css') }}" rel="stylesheet" media="all" type="text/css" />
<link href="{{ asset('public/assets/css/lightgallery.min.css') }}" rel="stylesheet" media="all" type="text/css" />
@section('content')
<div class="alert alert-success" id="save-success" style="display: none;">
  <p align="center">{{ __('carDetailPage.adSavedSuccessfully') }}</p>
</div>
@php
$activeLanguage = \Session::get('language');
$user = Auth::guard('customer')->user();
$id = Route::Input('id');
///$ads = \App\Ad::where('id',$id)->first();
$color = $ads->colorDescription()
->where('language_id',$activeLanguage['id'])->first();
$tags = \App\AdTag::where('ad_id',$ads->id)
->pluck('tag_id')->toArray();
$ad_tags = \App\Models\TagDescription::whereIn('tag_id',$tags)
->where('language_id',$activeLanguage['id'])->get();
$checkSaved = Cookie::get('ad'.$id);
$ads_images = $ads->ads_images;
$ads_description = $ads->ads_description->where('language_id','=',$activeLanguage['id'])
->first();
if($ads_description == null){
$ads_description = $ads->ads_description->first();
}
/* $similar_ads = \App\Ad::where('id','!=',$id)
->where('model_id',$ads->model_id)
->where('status',1)->get(); */
$suggessions = $ads->suggessions;//@Mutahir Shah
$features = explode(',',@$ads->features);
$seller_comment_array = explode('#',@$ads_description->description);

$seller_comments = array_values(array_filter($seller_comment_array));
$last_value_in_array = end($seller_comments);
$lengh = sizeof($seller_comments) - 0 ;
unset($seller_comments[$lengh]);
@endphp
@push('styles')
@endpush
<div class="internal-page-content mt-4 pt2 pt2 sects-bg">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <a href="javascript:void(0)" target=""><img src="{{asset('public/assets/img/placeholder.jpg')}}" class="img-fluid" alt="carish used cars for sale in estonia"></a>
      </div>
      <div class="col-12 pageTitle detailpageTitle mt-md-5 mt-4">
        <nav aria-label="breadcrumb" class="breadcrumb-menu">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a target="" href="{{url('/')}}">{{ __('carDetailPage.homeBackLink') }}</a></li>
            @if(@$ads->is_featured == 'true')
            <li class="breadcrumb-item"><a target="" href="{{route('simple.search')}}/used-cars-for-sale/isf_featured">{{ __('carDetailPage.featured_cars') }}</a></li>
            @else
            <li class="breadcrumb-item"><a target="" href="{{route('simple.search')}}/isp_popular">{{ __('carDetailPage.popularCars') }}</a></li>
            @endif
            <li class="breadcrumb-item"><a target="" href="{{route('simple.search')}}/used-cars-for-sale/mk_{{@$ads->maker->title}}">{{@$ads->maker->title}}</a></li>
            <li class="breadcrumb-item"><a target="" href="{{route('simple.search')}}/used-cars-for-sale/mo_{{@$ads->model->name}}">{{@$ads->model->name}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{@$ads->year}}</li> <!-- links updated -->
          </ol>
        </nav>
      </div>
    </div>
    <div class="mb-4 mt-4 pt-md-2 row">
      <div class="col-md-6 col-12 productImgCol">
        <div class="bg-white p-2 border h-100">
          <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
            @php
            $total_images = 0;
            @endphp
            @foreach(@$ads_images as $ad_image)
            @php
            $total_images++;
            @endphp
            @if(@$ad_image->img != null && file_exists(public_path().'/uploads/ad_pictures/cars/'.$ads->id.'/'.$ad_image->img))
            <li class="position-relative overflow-hidden rounded car_gallery" data-thumb="{{asset('public/uploads/ad_pictures/cars/'.$ads->id.'/'.$ad_image->img)}}" data-src="{{asset('public/uploads/ad_pictures/cars/'.$ads->id.'/'.$ad_image->img)}}">
              <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                @if(@$ads->is_featured == 'true')
                <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-uppercase text-white d-inline-block">{{ __('carDetailPage.featured') }}</span>
                @endif
                <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
                </span>
              </figcaption>
              <img src="{{asset('public/uploads/ad_pictures/cars/'.$ads->id.'/'.$ad_image->img)}}" class="img-fluid cover_image" style="display: none;">

              <div style="background-image: url('{{url('public/uploads/ad_pictures/cars/'.$ads->id.'/'.$ad_image->img)}}');background-size: cover;
    background-position: center;padding: 40%;"></div>
            </li>
            @else
            <li class="position-relative overflow-hidden rounded car_gallery" data-src="{{asset('public/assets/img/caravatar.jpg')}}" data-thumb="{{asset('public/assets/img/caravatar.jpg')}}">
              <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                @if(@$ads->is_featured == 'true')
                <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-uppercase text-white d-inline-block">{{ __('carDetailPage.featured') }}</span>
                @endif
                <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
                </span>
              </figcaption>
              <img src="{{asset('public/assets/img/caravatar.jpg')}}" class="img-fluid cover_image" style="display: none;">

              <div style="background-image: url('{{url('public/assets/img/caravatar.jpg')}}');background-size: cover;
    background-position: center;padding: 40%;"></div>
            </li>
            @endif
            @endforeach
            @for($i = $total_images; $i < 4; $i++) <li class="position-relative overflow-hidden rounded car_gallery" data-src="{{asset('public/assets/img/caravatar.jpg')}}" data-thumb="{{asset('public/assets/img/caravatar.jpg')}}">
              <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                @if(@$ads->is_featured == 'true')
                <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-uppercase text-white d-inline-block">{{ __('carDetailPage.featured') }}</span>
                @endif
                <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
                </span>
              </figcaption>
              <img src="{{asset('public/assets/img/caravatar.jpg')}}" class="img-fluid cover_image" style="display: none;">

              <div style="background-image: url('{{url('public/assets/img/caravatar.jpg')}}');background-size: cover;
    background-position: center;padding: 40%;"></div>
              </li>
              @endfor
          </ul>
        </div>
      </div>
      <div class="col-md-6 col-12 mt-4 mt-md-0 productDetialCol">
        <div class="bg-white border h-100 overflow-auto position-relative">
          <h6 class="bgcolor1 detail-page-title mb-0 pb-3 pl-md-4 pr-md-4 pl-3 pr-3 pt-3 text-white">{{$ads->maker->title}} {{$ads->model->name}} {{@$ads->versions->name}} {{$ads->year}}</h6>
          <div class="seller-desc p-lg-4 p-3 mt-3">
            <div class="d-flex justify-content-between sellerinfo">
              <div class="sellerinfo-left">
                <h6 class="mb-4">{{ __('carDetailPage.sellerInformation') }}</h6>
                @if(@$ads->customer->login_status == '1')
                <p class="bestSeller font-weight-semibold mb-1">
                  <em class="fa fa-star"></em>{{ __('carDetailPage.trustedSellerBadge') }}<em class="fa fa-star"></em>
                </p>
                @endif
                <ul class="list-unstyled">
                  <li><strong>{{ __('carDetailPage.dealer') }}:</strong>
                    @if($ads->customer->customer_role == 'individual')
                    <a target="" href="{{url('individual_profile/'.@$ads->customer_id)}}">{{@$ads->customer->customer_company}}</a>
                    @else
                    <a target="" href="{{url('company_profile/'.@$ads->customer_id)}}"> {{@$ads->customer->customer_company}}</a>
                    @endif
                  </li>
                  @if($ads->customer->customer_role == 'business')
                  <li><strong>{{ __('carDetailPage.address') }}:</strong> <a href="javascript:void(0)">{{$ads->customer->customer_default_address}}</a></li>
                  @else
                  <li><strong>{{ __('carDetailPage.address') }}:</strong> <a href="javascript:void(0)">{{$ads->customer->city->name}}</a></li>
                  @endif
                </ul>
              </div>
              <div class="sellerinfo-right pl-3 text-right">
                <span class="carPrice d-inline-block font-weight-bold font-weight-semibold ml-3">€{{$ads->price}}</span>
                <p class="incltext mb-0"> {{(@$ads->vat != null) ? __('carDetailPage.inclVat') : ''}}</p>
                <p class="themecolor2 font-weight-semibold mb-0 negotiable">{{(@$ads->neg != null) ? __('carDetailPage.negotiable') : ''}}</p>
              </div>
            </div>
            <div class="align-items-center d-lg-flex d-md-block d-flex justify-content-between sellerContact">
              <div class="mb-md-3 m-lg-0 mb-0 sellerContact-left">
                <ul class="list-unstyled">
                  @if(@$ads->customer->phone_verification_status == '1')
                  <li class="list-inline-item"><a href="javascript:void(0)" class="position-relative"><em class="fa fa-mobile"></em>
                      <img src="{{asset('public/assets/img/check.jpg')}}" class="position-absolute rounded-circle">
                    </a></li>
                  @endif
                  <li class="list-inline-item"><a href="javascript:void(0)" class="position-relative"><em class="fa fa-envelope"></em>
                      <img src="{{asset('public/assets/img/check.jpg')}}" class="position-absolute rounded-circle">
                    </a></li>
                </ul>
                <strong>{{ __('carDetailPage.viewMoreAdsBy') }} </strong>
                @if($ads->customer->customer_role == 'individual')
                <a href="{{url('individual_profile/'.@$ads->customer_id)}}" class="view-more-ad themecolor" target="_blank"><strong>{{@$ads->customer->customer_company}}</strong></a>
                @else
                <a href="{{url('company_profile/'.@$ads->customer_id)}}" class="view-more-ad themecolor" target="_blank"><strong> {{@$ads->customer->customer_company}}</strong>
                  @endif
              </div>
              <div class="pl-0 pl-lg-3 pl-md-0 pl-sm-3 sellerContact-right text-lg-right text-md-left text-right">
                <a href="javascript:void(0)" class="btn themebtn3 toggle_number">
                  <span class="d-flex align-items-center">
                    <em class="fa fa-phone"></em>
                    <span class="half_number text-left">
                      {{substr(@$ads->customer->customers_telephone,0,7)}}....<br>{{ __('carDetailPage.showPhoneNumber') }}
                    </span>
                    <span class="full_number d-none">
                      {{@$ads->customer->customers_telephone}}
                    </span>
                  </span>
                </a>

                @if(Auth::guard('customer')->user() && ($ads->customer_id !=Auth::guard('customer')->user()->id))
                <a href="javascript:void(0)" class="btn btn-transparent mt-lg-3 mt-md-0 mt-2 mt-0 send-msg-btn"><em class="fa fa-envelope"></em> {{ __('carDetailPage.sendMessage') }}</a>
                @else
                @if(empty(Auth::guard('customer')->user()) || ($ads->customer_id !=Auth::guard('customer')->user()->id))
                <a target="" href="{{url('user/login')}}" class="btn btn-transparent mt-lg-3 mt-md-0 mt-2 mt-0"><em class="fa fa-envelope"></em> {{ __('carDetailPage.sendMessage') }}</a>
                @endif
                @endif
              </div>
            </div>
            <div class="container ">
              <div class="mb-4 ml-auto mr-auto mt-3 mt-lg-4 row sellercarInforow bg-white">
                <div class="col-6 col-md-4 col-sm-4 d-flex justify-content-center sellercarInfo pl-3 pr-3 pt-lg-3 pb-lg-4 pt-2 pb-3">
                  <div class="text-center">
                    <img src="{{asset('public/assets/img/detail-car-info-1.png')}}" class="img-fluid mb-1" alt="carish used cars for sale in estonia">
                    <span class="d-block">{{@$ads->body_type_description !== null ? @$ads->body_type_description()->where('language_id',$activeLanguage['id'])->pluck('name')->first() : '--'}}</span>
                  </div>
                </div>
                <div class="col-6 col-md-4 col-sm-4 d-flex justify-content-center sellercarInfo pl-3 pr-3 pt-lg-3 pb-lg-4 pt-2 pb-3">
                  <div class="text-center">
                    <img src="{{asset('public/assets/img/detail-car-info-2.png')}}" class="img-fluid mb-1" alt="carish used cars for sale in estonia">
                    <span class="d-block">{{$ads->transmission !== null ? $ads->transmission->transmission_description->where('language_id',$activeLanguage['id'])->pluck('title')->first() : '--'}}</span>
                  </div>
                </div>
                <div class="col-6 col-md-4 col-sm-4 d-flex justify-content-center sellercarInfo pl-3 pr-3 pt-lg-3 pb-lg-4 pt-2 pb-3">
                  <div class="text-center">
                    <img src="{{asset('public/assets/img/detail-car-info-3.png')}}" class="img-fluid mb-1" alt="carish used cars for sale in estonia">
                    <span class="d-block">{{@$ads->fuel !== null ? @$ads->fuel->engine_type_description->where('language_id',$activeLanguage['id'])->pluck('title')->first() : '--'}}</span>
                  </div>
                </div>
                <div class="col-6 col-md-4 col-sm-4 d-flex justify-content-center sellercarInfo pl-3 pr-3 pt-lg-3 pb-lg-4 pt-2 pb-3">
                  <div class="text-center">
                    <img src="{{asset('public/assets/img/detail-car-info-4.png')}}" class="img-fluid mb-1" alt="carish used cars for sale in estonia">
                    <span class="d-block">{{@$ads->year}}</span>
                  </div>
                </div>
                <div class="col-6 col-md-4 col-sm-4 d-flex justify-content-center sellercarInfo pl-3 pr-3 pt-lg-3 pb-lg-4 pt-2 pb-3">
                  <div class="text-center">
                    <img src="{{asset('public/assets/img/detail-car-info-5.png')}}" class="img-fluid mb-1" alt="carish used cars for sale in estonia">
                    <span class="d-block">{{@$ads->millage}} km</span>
                  </div>
                </div>
                <div class="col-6 col-md-4 col-sm-4 d-flex justify-content-center sellercarInfo pl-3 pr-3 pt-lg-3 pb-lg-4 pt-2 pb-3">
                  <div class="text-center">
                    <img src="{{asset('public/assets/img/detail-car-info-6.png')}}" class="img-fluid mb-1" alt="carish used cars for sale in estonia">
                    <span class="d-block">{{@$ads->versions->cc}}
                      @if($ads != null)
                      @if(@$ads->versions->kilowatt)
                      /{{@$ads->versions->kilowatt}}
                      @endif
                      @endif</span>
                  </div>
                </div>
              </div>
            </div>
            <ul class="list-unstyled sharelist font-weight-semibold mb-0" style="position: absolute;bottom: 10px;">
              {{-- <li class="list-inline-item"><a href="javascript:void(0)"><em class="fa fa-share-alt"></em> {{__('search.share')}}</a></li> --}}

              @if(Auth::guard('customer')->user())
              @php
              $saved = \App\UserSavedAds::where('ad_id',$ads->id)->where('customer_id',@Auth::guard('customer')->user()->id)->first();
              @endphp
              @if(@$saved != null)
              @php $id = 'heart2'; @endphp
              @else
              @php $id = 'heart'; @endphp
              @endif
              <li class="list-inline-item mt-2"><a href="javascript:void(0)" class="saveAd saveAdBtn" data-id="{{$ads->id}}"><em id="{{$id}}" class="fa fa-heart"></em> {{__('carDetailPage.save')}}</a></li>
              @else
              @if(@$checkSaved != null)
              @php $id = 'heart4'; @endphp
              @else
              @php $id = 'heart3'; @endphp
              @endif
              <li class="list-inline-item mt-2"><a href="javascript:void(0)" class="saveAdCok saveAdBtn" data-id="{{$ads->id}}"><em id="heart3" class="fa fa-heart"></em> {{__('carDetailPage.save')}}</a></li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container position-sticky" style="top: 0px; z-index: 100;">
    <div class="row carinfoTabs">
      <div class="col-12 carinfoTabs-col text-center ">
        <ul class="bgcolor1 list-unstyled mb-0 nav nav-justified text-white">
          <li class="nav-item active"><a href="#carfeatures-sect" class="gotosect nav-link">{{ __('carDetailPage.carFeatures') }}</a></li>
          <li class="nav-item"><a href="#seller-comments-sect" class="gotosect nav-link">{{ __('carDetailPage.sellerComments') }}</a></li>
          <li class="nav-item"><a href="#similar-ads-sect" class="gotosect nav-link">{{ __('carDetailPage.similarAds') }}</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="carinfodetail-section bg-white mt-5 pt-5 pb-5">
    <div class="container">
      <div class="carinfodetail-row card-columns">
        @if(!empty($features))
        <div class="card carfeatureinfo" id="carfeatures-sect">
          <h5 class="text-capitalize carInfotitle font-weight-bold">
            <img src="{{url('public/assets/img/detail-Car-features.jpg')}}" alt="icon">{{ __('carDetailPage.carFeatures') }}
          </h5>
          <div class="form-row featureslist mb-0 row">

            @foreach($features as $feature)
            <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline">
              <figure class="mb-0"><img src="{{asset('public/uploads/image/'.@$ads->get_feature($feature)->image)}}"></figure> {{ @$ads->get_feature($feature) != null ? @$ads->get_feature($feature)->features_description()->where('language_id',@$activeLanguage['id'])->pluck('name')->first() : '' }}
            </div>
            @endforeach
          </div>
          @if(count($features)>15)
          <div class="text-right">
            <a href="javascript:void(0)" class="themecolor font-weight-semibold">{{ __('carDetailPage.carDataViewAll') }}</a>
          </div>
          @endif
        </div>
        @endif
        <div class="card cardatainfo">
          <h5 class="carInfotitle text-capitalize">
            <img src="{{url('public/assets/img/detail-Car-data.jpg')}}" alt="icon">{{ __('carDetailPage.carData') }}
          </h5>
          <table class="mb-0 table">
            <tbody>

              <tr>
                <td>{{ __('carDetailPage.regNumber') }}:</td>
                <td>{{@$ads->car_number !== null ? @$ads->car_number : '--'}}</td>
              </tr>

              <tr>
                <td>{{ __('carDetailPage.boughtFrom') }}:</td>
                <td>
                  @if(!empty($ads->bought_from_id))
                  @php
                  $boughtFromCollection = $ads->countryRegistered->boughtFromDescription->where('language_id',$activeLanguage['id'])->first();
                  @endphp
                  {{$boughtFromCollection->title}}
                  @endif
                </td>
              </tr>
              <tr>
                <td>{{ __('carDetailPage.currentRegistration') }}:</td>
                <td>{{!empty($ads->country_id) ? $ads->country->name : '--'}}</td>
              </tr>
              <tr>
                <td>{{ __('carDetailPage.estonianRegDate') }}:</td>
                <td>{{!empty($ads->register_in_estonia) ? Carbon\Carbon::parse($ads->register_in_estonia)->format("m/Y") : '--'}}</td>
              </tr>
              <tr>
                <td colspan="2"> 
                  <a data-toggle="modal" data-target="#savedCarAd2" href="javascript:void()" class="view-more-ad themecolor" title="{{__('carDetailPage.carDataViewAll')}}">{{__('carDetailPage.carDataViewAll')}}</a>  
               
                   </td>
              </tr>
              <!--   <tr>
                <td>{{ __('ads.register') }}:</td>
                <td>{{@$ads->year}}</td>
              </tr>
              <tr>
                <td>{{ __('ads.color') }}:</td>
                <td>{{@$color !=null? $color->name : '--'}}</td>
              </tr> 
              <tr>
                <td>{{ __('ads.doors') }}:</td>
                <td>{{@$ads->doors !== null ? @$ads->doors : '--'}}</td>
              </tr> -->
            </tbody>
          </table>
        </div>
        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade" id="savedCarAd2" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content sects-bg">
              <div class="modal-header border-bottom-0 pl-md-4 pr-md-4">
              <h5 class="carInfotitle text-capitalize">
            <img src="{{url('public/assets/img/detail-Car-data.jpg')}}" alt="icon">{{ __('carDetailPage.carData') }}
          </h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                
              </div>
              <div class="modal-body comp-modal-body pl-md-4 pr-md-4 pb-4">
                <div class="bg-white">

                <div class="card cardatainfo">
          <div class="table-responsive">
            
          
          <table class="mb-0 table">
          <tbody>
    <tr>
        <td>{{ __('carDetailPage.length') }}</td>
        <td>{{@$ads->versions->car_length}}</td>
        <td>{{ __('carDetailPage.width') }}</td>
        <td>{{@$ads->versions->car_width}}</td>
    </tr> 
    <tr>
        <td>{{ __('carDetailPage.height') }}</td>
        <td>{{@$ads->versions->car_height}}</td>
        <td>{{__('carDetailPage.curbWeight')}}</td>
        <td>@if($ads->versions->curb_weight !=null){{@$ads->versions->curb_weight}} @endif</td>
    </tr>

    <tr>
        <td>{{__('carDetailPage.fuelCapacity')}}</td>
        <td>@if($ads->versions->fuel_tank_capacity != null) {{$ads->versions->fuel_tank_capacity}} @endif</td>
        <td>{{__('carDetailPage.doors')}}</td>
        <td>@if($ads->versions->number_of_door != null) {{$ads->versions->number_of_door}} @endif</td>
       
    </tr>


    <tr>
        <td>{{__('carDetailPage.seats')}}</td>
        <td>@if($ads->versions->seating_capacity != null) {{$ads->versions->seating_capacity}} @endif</td>
        <td>{{__('carDetailPage.drive')}}</td>
        <td>@if($ads->versions->drive_type != null) {{$ads->versions->drive_type}} @endif</td>
     
    </tr>

    
    <tr>
         <td>{{__('carDetailPage.displacement')}}</td>
        <td>@if($ads->versions->displacement !=null) {{$ads->versions->displacement}} @endif</td>
        <td>{{__('carDetailPage.torque')}}</td>
        <td>@if($ads->versions->torque != null) {{$ads->versions->torque}} @endif</td>
     
    </tr>
    <tr>
          <td>{{__('carDetailPage.gears')}}</td>
        <td>@if($ads->versions->gears !=null) {{$ads->versions->gears}} @endif</td>
        <td>{{__('carDetailPage.maxSpeed')}}</td>
        <td>@if($ads->versions->max_speed != null) {{$ads->versions->max_speed}} @endif</td>
     
    </tr>

    <tr>
          <td>{{__('carDetailPage.acceleration')}}</td>
        <td>@if($ads->versions->acceleration !=null) {{$ads->versions->acceleration}} @endif</td>
        <td>{{__('carDetailPage.cylinder')}}</td>
        <td>@if($ads->versions->number_of_cylinders != null) {{$ads->versions->number_of_cylinders}} @endif</td>
     
    </tr>


    <tr>
        <td>{{__('carDetailPage.wheelBase')}}</td>
        <td>@if($ads->versions->wheel_base != null) {{$ads->versions->wheel_base}} @endif</td>
        <td>{{__('carDetailPage.groundClerance')}}</td>
        <td>@if($ads->versions->ground_clearance !=null) {{$ads->versions->ground_clearance}} @endif</td>

    </tr>

    <tr>
          <td>{{__('carDetailPage.frontWheelSize')}}</td>
        <td>@if($ads->versions->front_wheel_size !=null) {{$ads->versions->front_wheel_size}} @endif</td>
        <td>{{__('carDetailPage.backWheelSize')}}</td>
        <td>@if($ads->versions->back_wheel_size != null) {{$ads->versions->back_wheel_size}} @endif</td>
  
    </tr>

    <tr>
      <td>{{__('carDetailPage.frontTyreSize')}}</td>
        <td>@if($ads->versions->front_tyre_size !=null) {{$ads->versions->front_tyre_size}} @endif</td>
     
        <td>{{__('carDetailPage.backTyreSize')}}</td>
        <td>@if($ads->versions->back_tyre_size !=null) {{$ads->versions->back_tyre_size}} @endif</td>
     
    </tr> 


    <tr>
        <td>{{ __('carDetailPage.regNumber') }}:</td>
        <td>{{@$ads->car_number !== null ? @$ads->car_number : '--'}}</td>
        <td>{{ __('carDetailPage.boughtFrom') }}:</td>
        <td>
            @if(!empty($ads->bought_from_id))
            @php
            $boughtFromCollection = $ads->countryRegistered->boughtFromDescription->where('language_id',$activeLanguage['id'])->first();
            @endphp
            {{$boughtFromCollection->title}}
            @endif
        </td>
    </tr>

    <tr>
        <td>{{ __('carDetailPage.estonianRegDate') }}:</td>
        <td>{{!empty($ads->country_id) ? $ads->country->name : '--'}}</td>
        <td>{{ __('carDetailPage.estonianRegDate') }} {{!empty($ads->country_id) ? $ads->country->name : ''}}:</td>
        <td>{{!empty($ads->register_in_estonia) ? Carbon\Carbon::parse($ads->register_in_estonia)->format("m/Y") : '--'}}</td>
    </tr>
</tbody>
          </table>
          </div>
        </div> <div class="text-center mt-4  mt-md-5">
                    <button type="button"  class="close text-danger" data-dismiss="modal" aria-label="Close">{{__('carDetailPage.close')}}</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>





        <div class="card cardimensions">
          <h5 class="text-capitalize carInfotitle font-weight-bold">
            <img src="{{url('public/assets/img/detail-Car-dimensions.jpg')}}" alt="icon">{{ __('carDetailPage.dimensions') }}
          </h5>
          <table class="mb-0 table table-borderless">
            <tbody>
              <tr>
                <td>{{ __('carDetailPage.length') }}</td>
                <td>{{@$ads->versions->car_length}}</td>
              </tr>
              <tr>
                <td>{{ __('carDetailPage.width') }}</td>
                <td>{{@$ads->versions->car_width}}</td>
              </tr>
              <tr>
                <td>{{ __('carDetailPage.height') }}</td>
                <td>{{@$ads->versions->car_height}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card careconomyinfo">
          <h5 class="text-capitalize carInfotitle font-weight-bold">
            <img src="{{url('public/assets/img/detail-Car-economy.jpg')}}" alt="icon">{{ __('carDetailPage.carEconomy') }}
          </h5>
          <table class="mb-0 table table-borderless">
            <tbody>
              <tr>
                <td>{{ __('carDetailPage.average') }}</td>
                <td>{{@$ads->fuel_average}} Ltr / 100 km</td>
              </tr>
            </tbody>
          </table>
        </div>
      <div class="card cartagsinfo">
        <h5 class="text-capitalize carInfotitle font-weight-bold">
          <img src="{{url('public/assets/img/detail-Car-tags.jpg')}}" alt="icon">{{ __('carDetailPage.carTags') }}
        </h5>
        <div class="car-tags">
          @if($ad_tags->count() > 0)
          <ul class="list-unstyled mb-0">
            @foreach($ad_tags as $tag)
            <li class="list-inline-item mb-3">
              <span class="badge badge-pill bgcolor1 font-weight-normal p-2 pl-3 pr-3 text-white">{{$tag->name}}</span>
            </li>
            @endforeach
          </ul>
          @endif
        </div>
      </div>

    </div>
  </div>
</div>
<div class="container mb-5 mt-4 mt-5 mt-md-5 pb-md-3 pt-0 pt-md-3 d-none" id="taxi-Compatibility-sect">
  <div class="row taxi-comp-row ml-auto mr-auto">
    <div class="col-12 taxi-comp-col bg-white p-4">
      <h5 class="text-capitalize carInfotitle font-weight-bold">
        <img src="{{url('public/assets/img/detail-Car-taxi-compatiblity.jpg')}}" alt="icon">taxi compatibility
      </h5>
      <table class="mb-0 table table-borderless table-responsive">
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="container bg-white mb-5 mt-4 mt-5 mt-md-5 pb-3 pt-3 seller-comments-sections" id="seller-comments-sect">
  <div class="  mt-4 mt-md-5 mb-4 mb-md-5">
    <div class="row seller-comments-row ml-auto mr-auto">
      <div class="col-12 seller-comments-col">
        <h5 class="text-capitalize carInfotitle font-weight-bold">
          <img src="{{url('public/assets/img/detail-Car-seller-coments.jpg')}}" alt="icon">{{ __('carDetailPage.sellerComments') }}
        </h5>
        <ul class="list-unstyled mb-4">
          @foreach($seller_comments as $seller_comment)
          <li class="mb-2">{{$seller_comment}}</li>
          @endforeach
          {{-- @if($suggessions) 
              @foreach($suggessions as $tags)
                 <li class="mb-2">{{$tags->sentence}}</li>
          @endforeach
          @endif --}}
        </ul>
        <p class="mb-0">{{ __('carDetailPage.sellerCommentGetGoodDeal') }}</p>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="align-items-center col-lg-9 d-sm-flex justify-content-around ml-auto mr-auto mb-4 mb-md-5 mt-4 mt-md-5 pl-0 postAdRow pr-0 pt-2 pt-sm-3  mb-sm-0 mb-5">
    <div class="sellCarCol d-none d-md-block">
      <img src="{{url('public/assets/img/sell-car.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
    </div>
    <div class="pl-md-3 pr-md-3 sellCartext text-center">
      <img src="{{url('public/assets/img/sell-arrow-left.png')}}" class="d-md-block d-none img-fluid mr-auto  sell-arrow-left" alt="carish used cars for sale in estonia">
      <h4 class="mb-0">{{ __('carDetailPage.wantToSellYourCar') }}</h4>
      <p class="mb-0">{{ __('carDetailPage.wantToSellYourCarDetailedText') }}</p>
      <img src="{{url('public/assets/img/sell-arrow-right.png')}}" class="d-sm-block d-none img-fluid ml-auto sell-arrow-right" alt="carish used cars for sale in estonia">
    </div>
    <div class="sellCarBtn">
      <a target="" href="{{ route('sellcar') }}" class="btn themebtn1">{{ __('carDetailPage.wantToSellYourCarButtonText') }}</a>
    </div>
  </div>
  <div class="ml-0 mr-0 row bg-white" id="similar-ads-sect">
    <div class="col-12 p-4 similar-Ads-col">
      <h5 class="text-capitalize carInfotitle font-weight-bold">
        <img src="{{asset('public/assets/img/detail-Car-seller-coments.jpg')}}" alt="icon">{{ __('carDetailPage.similarAds') }}
      </h5>
      <div class="row">
        @if($similar_ads->count() > 0)
        @foreach($similar_ads as $similar)
        <div class="col-lg-3 col-md-6 col-6 mb-4 mb-lg-3 similar-post-col">
          <div class="box-shadow">
            <figure class="mb-0 position-relative text-left">
              @if(@$similar->ads_images[0]->img != null && file_exists( public_path() . '/uploads/ad_pictures/cars/'.$similar->id.'/'.@$similar->ads_images[0]->img))
              <div class="bgImg" style="background-image: url({{ asset('public/uploads/ad_pictures/cars/'.@$similar->id.'/'.$similar->ads_images[0]->img)}})"></div>
              @else
              <div class="bgImg" style="background-image: url({{ asset('public/assets/img/caravatar.jpg')}})"></div>

              @endif
              @if($similar->is_featured == 'true')
              <figcaption class="position-absolute top right left bottom">
                <span class="bgcolor2 d-inline-block featuredlabel font-weight-semibold mt-3 pb-1 pl-2 pr-2 pt-1 text-uppercase text-white">{{ __('carDetailPage.featured') }}</span>
              </figcaption>
              @endif
            </figure>
            <div class="m-1 p-2 pb-3">
              <h5 class="font-weight-semibold mb-2"><a target="" href="{{url('car-details/'.$similar->id)}}" class="stretched-link themecolor">{{$similar->maker->title}} {{$similar->model->name}}</a></h5>
              <p class="car-price mb-1">€{{@$similar->price}}</p>
              <span class="car-country">{{@$similar->bought_from}}</span>
            </div>
          </div>
        </div>
        @endforeach
        @else
        <div class="col-lg-3 col-md-6 col-6 mb-4 mb-lg-3 similar-post-col">
          <p><b>{{ __('carDetailPage.similarAdsNotFound') }}</b></p>
        </div>
        @endif
      </div>
    </div>
    <!-- <div class="alert alert-success " style="display: none" id="successmsg"></div>
    <div class="col-12 mt-lg-4 p-md-4 p-3 notifyForm detail-page-notifyform" style=" background: #E4E4E4;">
      <div class="row p-sm-2 align-items-center">
        <div class="col-lg-5 col-12 mb-lg-0 mb-3">
          <h5 class="themecolor"><em class="fa fa-bell"></em> {{ __('carDetailPage.notifyMe') }}</h5>
          <p class="mb-0">{{ __('carDetailPage.notifyMeDetailText1') }} <strong>{{@$ads->maker->title}} {{@$ads->model->name}} {{@$ads->year}}</strong> {{ __('carDetailPage.notifyMeDetailText2') }}</p>
        </div>
        <div class="col-lg-7 col-12">
          <form method="post" action="" id="make-car-alert">

            {{csrf_field()}}
            <input type="hidden" name="model" value="{{@$ads->model->id}}">
            <div class="row form-row">
              <div class="col-sm-5 mb-md-0 mb-3 form-group">
                <input type="email" name="email" placeholder="{{__('carDetailPage.emailAddress')}}" class="form-control" required>
              </div>
              <div class="col-sm-4 mb-md-0 mb-3 form-group">
                <select name="selectType" class="form-control" required>
                  <option class="active">{{ __('carDetailPage.selectType') }}</option>
                  <option value="daily">{{ __('carDetailPage.daily') }}</option>
                  <option value="weekly">{{ __('carDetailPage.weekly') }}</option>
                  <option value="monthly">{{ __('carDetailPage.monthly') }}</option>
                  <option value="hourly">{{ __('carDetailPage.hourly') }}</option>
                </select>
              </div>
              <div class="col-sm-3 mb-md-0 mb-3 form-group notifySubCol">
                <input type="submit" value="{{ __('carDetailPage.notifyBottonText') }}" class="btn btn-block border-0 text-white notifySubBtn text-uppercase">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div> -->
  </div>
</div>
</div>


<!-- Modal for car1 -->
<div class="modal fade" id="savedCarAd" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg mobile-modal" role="document" style="border-radius: 10px;margin: auto;">
    <div class="modal-content bgwhite" style="border-radius: 10px;">
      <div class="modal-header pl-md-4 pr-md-4">
        <h5 class="modal-title" style="color: black;">{{ __('carDetailPage.sendMessage') }}</h5>
        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: red;">×</span>
        </button>
      </div>
      <form action="{{route('send-message-to-customer')}}" method="post" class="send_msg_form">
        <div class="modal-body comp-modal-body pl-md-4 pr-md-4 pb-4">


          @csrf
          <div class="row" style="font-weight: 600;color: #333;">
            <div class="col-lg-3">{{ __('carDetailPage.title') }}</div>
            <div class="col-lg-8"> {{$ads->maker->title}} {{$ads->model->name}} {{@$ads->versions->name}} {{$ads->year}}</div>
          </div>
          <br>

          <div class="row" style="font-weight: 600;color: #333;">
            <div class="col-lg-3">{{ __('carDetailPage.name') }}<span style="color: red;">*</span> </div>
            <div class="col-lg-8">{{@$user->customer_company}}</div>
          </div>
          <br>

          <div class="row">
            <div class="col-lg-3" style="font-weight: 600;color: #333;">{{ __('carDetailPage.message') }}<span style="color: red;">*</span></div>
            <div class="col-lg-7">
              <textarea class="form-control customer_message" name="customer_message" cols="8" rows="7" required style="resize: none;box-shadow: 0 0 2px 0 rgba(51,51,51,0.1);" id="ex3">{{ __('carDetailPage.interestedInCar') }} <b>{{$ads->maker->title}} {{$ads->model->name}} {{@$ads->versions->name}} {{$ads->year}}</b> {{ __('carDetailPage.advertisedOn') }} <a href="https://carish.ee/">Cairsh</a>. {{ __('carDetailPage.pleaseLetMeKnowIfAvailable') }}<br>Thanks.</textarea>
            </div>
          </div>

        </div>

        <div class="modal-footer text-center justify-content-center">

          <input type="hidden" name="to_id" value="{{@$ads->customer_id}}">
          <input type="hidden" name="from_id" value="{{@$user->id}}">
          <input type="hidden" name="ad_id" value="{{$ads->id}}">
          <input type="hidden" name="type" value="car">

          <input type="submit" class="btn themebtn1 send_btn" value="{{ __('carDetailPage.send') }}">

        </div>
      </form>


    </div>
  </div>
</div>

@push('scripts')

<script src="{{url('public/admin/assets/ckeditor/ckeditor.js')}}"></script>



<script src="{{asset('public/js/lightslider.js')}}"></script>
<script src="{{asset('public/js/lightgallery-all.min.js')}}"></script>

<script>
  $('.saveAd').on('click', function() {
    var id = $(this).data('id');
    $.ajax({
      method: "get",
      dataType: "json",
      url: "{{url('user/save-ad')}}/" + id,

      success: function(data) {
        if (data.success == true) {
          $('#heart').css({
            'color': '#007bff',
            'transition': '0.5s all'
          });
          toastr.success('<a target="" href="{{url("user/my-saved-ads")}}" class="show_saved_ads">Show my saved ads </a>', 'Ad saved successfully.', {
            "positionClass": "toast-bottom-right"
          }, {
            timeOut: 5000
          });
        }
        if (data.success == false) {
          $('#heart,#heart2').css({
            'color': 'gray',
            'transition': '0.5s all'
          });
          toastr.error('<a target="" href="{{url("user/my-saved-ads")}}" class="show_saved_ads">Show my saved ads </a>', 'Ad removed successfully.', {
            "positionClass": "toast-bottom-right"
          }, {
            timeOut: 5000
          });

        }

        if (data.notActive == true) {
          toastr.warning('Alert!!', 'Ad cannot be saved because Ad is not in Active status!!!.', {
            "positionClass": "toast-bottom-right"
          }, {
            timeOut: 5000
          });
        }

      }
    });

  });

  //Save ad if user is not logged in
  $('.saveAdCok').on('click', function() {
    //alert('fd');
    var id = $(this).data('id');
    window.location.href = "{{ url('user/login') }}";
  });


  $('#make-car-alert').on('submit', function(e) {
    e.preventDefault();
    // alert('alert created');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      url: "{{ route('make-car-alert') }}",
      dataType: 'json',
      method: "post",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function(response) {
        if (response.success === true) {
          toastr.success('Success!', 'Alert Created Successfully.', {
            "positionClass": "toast-bottom-right"
          });
          $('#make-car-alert')[0].reset();
        }
      }
    });
  });

  $(document).ready(function() {

    CKEDITOR.replace('customer_message', {
      toolbar: ['/',
        {
          name: 'links',
          items: ['Link']
        },
      ]
    });

    $(document).on('click', '.send-msg-btn', function() {
      // alert('hi');
      var id = "{{@$ads->customer_id}}";
      var ads_id = "{{@$ads->id}}";
      var ads_type = "car";
      // alert(id);
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        method: "post",
        url: "{{ route('check-messages') }}",
        data: {
          customer_id: id,
          ads_id: ads_id,
          ads_type: ads_type,
          "_token": "{{ csrf_token() }}",
        },
        success: function(response) {
          if (response.success === true) {
            toastr.warning('Alert!', 'You already have send message to this ad owner. For further conversation please go to your messages.', {
              "positionClass": "toast-bottom-right"
            });
            $('#make-car-alert')[0].reset();
          } else if (response.success === false) {

            $('#savedCarAd').modal('show');
          }
        }
      });
    });

    $("#image-gallery").lightSlider({
      gallery: !0,
      item: 1,
      loop: !0,
      thumbItem: 4,
      slideMargin: 0,
      enableDrag: !1,
      currentPagerPosition: "left",
      onSliderLoad: function(e) {
        e.lightGallery({
          selector: "#image-gallery .lslide"
        }), $("#image-gallery").removeClass("cS-hidden");
      },
    });

  });

  $(document).on('click', '.toggle_number', function() {
    // alert('hi');
    $('.half_number').addClass('d-none');
    $('.full_number').removeClass('d-none');
    $('.toggle_number').addClass('add_pointer');
  })
</script>
@endpush

@endsection