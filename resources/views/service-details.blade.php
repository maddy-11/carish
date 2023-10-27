@extends('layouts.app')
<?php use Carbon\Carbon;?>
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

    .lSGallery img {
        height: 146px !important;
    }

    .lSPrev {
        background: red;
    }
      #cke_10{
        display: none;
    }
</style>

<link href="{{ asset('public/assets/css/lightslider.css') }}" rel="stylesheet" media="all" type="text/css" />
<link href="{{ asset('public/assets/css/lightgallery.min.css') }}" rel="stylesheet" media="all" type="text/css" />

@section('content')
<div class="alert alert-success" id="save-success" style="display: none;">
    <p align="center">Spare Pare Ad Saved successfully!</p>
</div>
@php
$id = Route::Input('id');

$user = Auth::guard('customer')->user();

$service_ads = \App\Models\Services::where('id',$id)->first();
$service_ads_image = $service_ads->services_images;
$parent_category   = $service_ads->primary_service_id;
$checkSaved        = Cookie::get('servicead'.$id);
$activeLanguage = \Session::get('language');
$ads_description = $service_ads->get_service_description($id,$activeLanguage['id']);
if($ads_description == null){
$service_description = $ads_description->description;
}

$seller_comment_array = explode('.',@$ads_description->description);

$seller_comments = array_values(array_filter($seller_comment_array));
$last_value_in_array = end($seller_comments);
$lengh = sizeof($seller_comments) - 0 ;
unset($seller_comments[$lengh]);
$skips = ["[","]","\""];
$p_caty = ($service_ads->primary_service->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first());
$s_caty = ($service_ads->sub_service->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first());
$s_s_caty = ($service_ads->sub_sub_service->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first());
@$title = $service_ads->get_service_ad_title($service_ads->id , $activeLanguage['id'])->title;
@endphp
@push('styles')
@endpush
@section('title') {{ @$title }} @endsection
<div class="internal-page-content mt-4 pt2 pt2 sects-bg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="javascript:void(0)" target=""><img src="{{asset('public/uploads/image/placeholder.jpg')}}"
                        class="img-fluid" alt="carish used cars for sale in estonia"></a>
            </div>
            <div class="col-12 pageTitle detailpageTitle mt-md-5 mt-4">
                <nav aria-label="breadcrumb" class="breadcrumb-menu">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a target="" href="{{url('/')}}">{{ __('findService-DetailPage.backLinkHome') }}</a></li>
                        <li class="breadcrumb-item"><a target=""
                                href="{{url('/find-car-services')}}">{{ __('findService-DetailPage.backLinkService') }}</a></li>
                        <li class="breadcrumb-item"><a target=""
                                href="{{url('find-car-services/'.@$service_ads->primary_service->slug)}}">{{@$p_caty}}</a>
                        </li>
                        <li class="breadcrumb-item " aria-current="page">{{@$s_caty}}</li>
                        <li class="breadcrumb-item " aria-current="page">{{@$s_s_caty}}</li>

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
                        @foreach(@$service_ads_image as $ad_image)
                        @if(@$ad_image->image_name != null && file_exists( public_path().'/uploads/ad_pictures/services/'.@$id.'/'.@$ad_image->image_name))
                        @php
                        $total_images++;
                        @endphp
                        <li class="position-relative overflow-hidden rounded" data-thumb="{{asset('public/uploads/ad_pictures/services/'.@$id.'/'.$ad_image->image_name)}}" data-src="{{asset('public/uploads/ad_pictures/services/'.@$id.'/'.$ad_image->image_name)}}">
                            <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-end">
                                <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url({{ asset('public/assets/img/imgZoom.png')}})">
                                </span>
                            </figcaption>
                            <img src="{{asset('public/uploads/ad_pictures/services/'.@$id.'/'.$ad_image->image_name)}}" class="img-fluid" style="min-width:100%;min-height:400px;max-height: 400px;">
                        </li>
                        @else
                        <img src="{{url('public/assets/img/serviceavatar.jpg')}}" alt="carish used cars for sale in estonia" class="img-fluid ads_image">
                        <li class="position-relative overflow-hidden rounded" data-thumb="{{asset('public/assets/img/serviceavatar.jpg')}}" data-src="{{asset('public/assets/img/serviceavatar.jpg')}}">
                            <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-end">
                                <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url({{ asset('public/assets/img/imgZoom.png')}})"></span>
                            </figcaption>
                            <img src="{{asset('public/assets/img/serviceavatar.jpg')}}" class="img-fluid" style="min-width:100%;min-height:400px;max-height: 400px;">
                        </li>
                        @endif
                        @endforeach
                        @for($i = $total_images; $i < 4; $i++) 
                        <li class="position-relative overflow-hidden rounded" data-thumb="{{asset('public/assets/img/serviceavatar.jpg')}}" data-src="{{asset('public/assets/img/serviceavatar.jpg')}}">
                            <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-end">
                                <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url({{ asset('public/assets/img/imgZoom.png')}})"></span>
                            </figcaption>
                            <img src="{{asset('public/assets/img/serviceavatar.jpg')}}" class="img-fluid" style="min-width:100%;min-height:400px;max-height: 400px;">
                        </li>
                        @endfor
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-12 mt-4 mt-md-0 productDetialCol">
                <div class="bg-white border h-100 overflow-auto position-relative">
                    <h6 class="bgcolor1 detail-page-title mb-0 pb-3 pl-md-4 pr-md-4 pl-3 pr-3 pt-3 text-white">
                        {{@$title !== null ? @$title  : ''}}</h6>
                    <div class="seller-desc p-lg-4 p-3 mt-3">
                        <div class="d-flex justify-content-between sellerinfo">
                            <div class="sellerinfo-left">
                                <h6 class="mb-4">{{ __('findService-DetailPage.sellerInformation') }}</h6>
                                @if(@$service_ads->get_customer->login_status == '1' &&
                                @$service_ads->customer->phone_verification_status == '1')
                                <p class="bestSeller font-weight-semibold mb-1"><em class="fa fa-star"></em>Trusted
                                    Seller<em class="fa fa-star"></em></p>
                                @endif
                                <ul class="list-unstyled">
                                    <li><strong>{{ __('findService-DetailPage.dealer') }}:</strong>
                                        @if($service_ads->get_customer->customer_role == 'individual')
                                        <a target=""
                                            href="{{url('individual_profile/'.@$service_ads->customer_id)}}">{{@$service_ads->get_customer->customer_firstname.' '.@$service_ads->get_customer->customer_lastname}}</a>
                                        @else
                                        <a target="" href="{{route('company_services',['id'=>$service_ads->id])}}">
                                            {{@$service_ads->get_customer->customer_company}}</a>
                                        @endif
                                    </li>
                                    @if($service_ads->get_customer->customer_role == 'business')
                                    <li><strong>{{ __('findService-DetailPage.address') }}:</strong> <a
                                            href="javascript:void(0)">{{$service_ads->get_customer->customer_default_address}}</a>
                                    </li>
                                    @else
                                      <li><strong>{{ __('findService-DetailPage.address') }}:</strong> <a href="javascript:void(0)">{{$service_ads->customer->city->name}}</a></li>
                                    @endif 
                                </ul>
                            </div>
                            <div class="sellerinfo-right pl-3 text-right">
                                <span class="carPrice d-inline-block font-weight-bold font-weight-semibold ml-3"></span>

                                <p class="incltext mb-0">{{(@$service_ads->vat != null) ?  __('findService-DetailPage.inclVat') : ''}}
                                </p>
                                <p class="themecolor2 font-weight-semibold mb-0 negotiable">
                                    {{(@$service_ads->neg != null) ? __('findService-DetailPage.negotiable') : ''}}</p>
                            </div>
                        </div>
                        <div
                            class="align-items-center d-lg-flex d-md-block d-flex justify-content-between sellerContact">
                            <div class="mb-md-3 m-lg-0 mb-0 sellerContact-left">
                                <ul class="list-unstyled">

                                    @if(@$service_ads->phone_verification_status == '1')
                                    <li class="list-inline-item"><a href="javascript:void(0)"
                                            class="position-relative"><em class="fa fa-mobile"></em><img
                                                src="{{asset('public/assets/img/check.jpg')}}"
                                                class="position-absolute rounded-circle"></a></li>
                                    @endif
                                    <li class="list-inline-item"><a href="javascript:void(0)"
                                            class="position-relative"><em class="fa fa-envelope"></em>
                                            <img src="{{asset('public/assets/img/check.jpg')}}"
                                                class="position-absolute rounded-circle">
                                        </a></li>
                                </ul>
                                <strong>{{ __('findService-DetailPage.viewMoreAdsBy') }} </strong>
                                @if($service_ads->get_customer->customer_role == 'individual')
                                <a href="{{url('individual_profile/'.@$service_ads->customer_id)}}"
                                    class="view-more-ad themecolor"
                                    target="_blank"><strong>{{@$service_ads->get_customer->customer_company}}</strong></a>
                                @else
                                <a href="{{route('company_services',["id"=>$service_ads->customer_id])}}"
                                    class="view-more-ad themecolor" target="_blank"><strong>
                                        {{@$service_ads->get_customer->customer_company}}</strong>
                                    @endif
                            </div>
                            <div
                                class="pl-0 pl-lg-3 pl-md-0 pl-sm-3 sellerContact-right text-lg-right text-md-left text-right">
                                <a href="javascript:void(0)" class="btn themebtn3 toggle_number">
                                    <span class="d-flex align-items-center">
                                        <em class="fa fa-phone"></em>
                                        <span class="half_number text-left">
                                            {{substr(@$service_ads->get_customer->customers_telephone,0,7)}}....<br>{{ __('findService-DetailPage.showPhoneNumber') }}
                                        </span>
                                        <span class="full_number d-none">
                                            {{@$service_ads->get_customer->customers_telephone}}
                                        </span>
                                    </span>

                                </a>
                               @if(Auth::guard('customer')->user() && ($service_ads->customer_id !=Auth::guard('customer')->user()->id))
                                    <a href="javascript:void(0)"
                                        class="btn btn-transparent mt-lg-3 mt-md-0 mt-2 mt-0 send-msg-btn"><em
                                            class="fa fa-envelope"></em> {{ __('findService-DetailPage.sendMessage') }}</a>
                                    @else
                                        @if(empty(Auth::guard('customer')->user()) || ($service_ads->customer_id !=Auth::guard('customer')->user()->id))
                                
                                        <a target="" href="{{url('user/login')}}"
                                        class="btn btn-transparent mt-lg-3 mt-md-0 mt-2 mt-0"><em
                                            class="fa fa-envelope"></em> {{ __('findService-DetailPage.sendMessage') }}</a>
                                            @endif
                                    @endif
                            </div>
                        </div>
                        <div class="mt-4 mt-md-5 mx-lg-n4 mx-n3">
                            <table class="table detail-table-categ">
                                <tbody>
                                    <tr>
                                        <td>{{ __('findService-DetailPage.category') }}</td>
                                        <td><a href="javascript:void(0)" class="themecolor"
                                                title="{{@$p_caty}}">{{@$p_caty}}</a></td>
                                        <td>{{ __('findService-DetailPage.subCategory') }}</td>
                                        <td><a href="javascript:void(0)" class="themecolor"
                                                title="{{@$sub_caty}}">{{@$s_caty}}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('findService-DetailPage.detail')}}</td>
                                        <td><a href="javascript:void(0)" class="themecolor"
                                                title="{{@$sub_caty}}">{{@$s_s_caty}}</a></td>
                                        <td class="ad-data">{{ __('findService-DetailPage.lastUpdated') }}:</td>
                                        <td class="last-border">{{@Carbon::parse(@$service_ads->updated_at)->format('d-M-Y') }}</td>
                                      
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <ul class="list-unstyled sharelist font-weight-semibold mb-0 mt-4 mt-md-5">
                            <!-- <li class="list-inline-item"><a href="javascript:void(0)"><em class="fa fa-share-alt"></em> Share</a></li> -->
                            @if(Auth::guard('customer')->user())
                            @php
                            $saved =
                            \App\UserSavedSpareParts::where('spare_part_ad_id',$service_ads->id)->where('customer_id',@Auth::guard('customer')->user()->id)->first();
                            @endphp
                            @if(@$saved != null)
                            @php $id = 'heart2'; @endphp
                            @else
                            @php $id = 'heart'; @endphp
                            @endif
                            <li class="list-inline-item"><a href="javascript:void(0)" id="savePart"
                                    data-id="{{$service_ads->id}}"><em id="{{@$id}}" class="fa fa-heart"></em>
                                    {{ __('findService-DetailPage.save') }}</a></li>
                            @else
                            @if(@$checkSaved != null)
                            @php $id = 'heart4'; @endphp
                            @else
                            @php $id = 'heart3'; @endphp
                            @endif
                            <li class="list-inline-item"><a href="javascript:void(0)" id="savePartCok"
                                    data-id="{{$service_ads->id}}"><em id="heart3" class="fa fa-heart"></em>
                                    {{ __('findService-DetailPage.save') }}</a></li>
                            @endif
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        <div class="row carinfoTabs">
            <div class="col-12 carinfoTabs-col text-center ">
                <ul class="list-unstyled mb-0 text-white bgcolor1">
                    <li class="list-inline-item"><a href="#seller-comments-sect"
                            class="gotosect">{{ __('findService-DetailPage.sellerComments') }}</a></li>
                    <li class="list-inline-item"><a href="#similar-ads-sect"
                            class="gotosect">{{ __('findService-DetailPage.similarAds') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="bg-white pb-4 pb-md-5 pt-md-5 pt-md-4 seller-comments-sections mt-5" id="seller-comments-sect">
        <div class="container">
            <div class="row seller-comments-row ml-auto mr-auto">
                <div class="col-12 seller-comments-col">
                    <h5 class="text-capitalize carInfotitle font-weight-bold">
                        <img src="{{asset('public/assets/img/detail-Car-seller-coments.jpg')}}"
                            alt="icon">{{ __('findService-DetailPage.sellerComments') }}</h5>
                    <ul class="list-unstyled mb-4">
                        @foreach($seller_comments as $seller_comment)
                        <li class="mb-2">{{$seller_comment}}</li>
                        @endforeach
                    </ul>
                    <p class="mb-0">{{ __('findService-DetailPage.mentionCarish') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div
            class="align-items-center col-lg-9 d-sm-flex justify-content-around ml-auto mr-auto mb-4 mb-md-5 mt-4 mt-md-5 pl-0 postAdRow pr-0 pt-2 pt-sm-3 mb-5">
            <div class="sellCarCol d-none d-md-block">
                <img src="{{asset('public/assets/img/sell-car.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
            </div>
            <div class="pl-md-3 pr-md-3 sellCartext text-center">
                <img src="{{asset('public/assets/img/sell-arrow-left.png')}}"
                    class="d-md-block d-none img-fluid mr-auto  sell-arrow-left" alt="carish used cars for sale in estonia">
                <h4 class="mb-0">{{ __('findService-DetailPage.wantToSellYourCar') }}<span
                        class="themecolor2">{{ __('findService-DetailPage.free') }}</span></h4>
                <p class="mb-0">{{__('findService-DetailPage.wantToSellYourCarDetailedText')}}</p>
                <img src="{{asset('public/assets/img/sell-arrow-right.png')}}"
                    class="d-sm-block d-none img-fluid ml-auto sell-arrow-right" alt="carish used cars for sale in estonia">
            </div>
            <div class="sellCarBtn">
                <a target="" href="{{route('sellcar')}}" class="btn themebtn1">{{ __('findService-DetailPage.wantToSellYourCarButtonText') }}</a>
            </div>
        </div>
        <div class="ml-0 mr-0 row bg-white" id="similar-ads-sect">
            <div class="col-12 p-4 similar-Ads-col">
                <h5 class="text-capitalize carInfotitle font-weight-bold">
                    <img src="{{asset('public/assets/img/detail-Car-seller-coments.jpg')}}"
                        alt="icon">{{ __('findService-DetailPage.similarAds') }}</h5>
                <div class="row">
                    @if($similar_ads != null)
                    @foreach($similar_ads as $ad)
                    <div class="col-lg-3 col-md-6 col-6 mb-4 mb-lg-3 offered-services-col offered-services-col1">
                        <figure
                            class="align-items-center border d-flex justify-content-center mb-0 position-relative text-left">
                            <img src="{{asset('public/uploads/ad_pictures/services/'.@$ad->id.'/'.@$ad->services_images[0]->image_name)}}"
                                alt="carish used cars for sale in estonia" class="img-fluid">
                        </figure>
                        <div class="p-lg-3 p-2 border border-top-0">
                            <h5 class="font-weight-bold mb-1 overflow-ellipsis"><a target=""
                                    href="{{url('service-details/'.@$ad->id)}}"
                                    class="stretched-link">{{@$ad->get_service_ad_title($ad->id,$activeLanguage['id'])->title}}</a></h5>
                            <ul class="list-unstyled mb-0 font-weight-semibold">
                            <li class="align-items-baseline d-flex"><span class="mr-2"><em
                            class="fa fa-amp-maker fa-map-marker"></em></span>
                            {{@$ad->get_customer->city->name}}</li>
                            </ul>
                            
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="col-lg-3 col-md-6 col-6 mb-4 mb-lg-3 similar-post-col">
                        <p><b>{{ __('findService-DetailPage.similarAdsNotFound') }}</b></p>
                    </div>
                    @endif

                </div>
            </div>
            <!-- <div class="col-12 mt-lg-4 p-md-4 p-3 notifyForm detail-page-notifyform" style=" background: #E4E4E4;">
                <div class="row p-sm-2 align-items-center">
                    <div class="col-lg-5 col-12 mb-lg-0 mb-3">
                        <h5 class="themecolor"><em class="fa fa-bell"></em> {{ __('findService-DetailPage.notifyMe') }}</h5>
                        <p class="mb-0">{{ __('findService-DetailPage.notifyMeDetailText1') }} <strong>{{@$p_caty}}</strong>
                            {{ __('findService-DetailPage.notifyMeDetailText2') }}</p>
                    </div>
                    <div class="col-lg-7 col-12">
                        <form method="post" action="" id="make-accessory-alert">
                            <input type="hidden" name="category" value="{{@$parent_category->id}}">

                            {{csrf_field()}}
                            <div class="row form-row">
                                <div class="col-sm-5 mb-md-0 mb-3 form-group">
                                    <input type="text" name="email" placeholder="Type Your Email Address"
                                        class="form-control">
                                </div>
                                <div class="col-sm-4 mb-md-0 mb-3 form-group">
                                    <select name="frequency" class="form-control">
                                        <option class="active">{{ __('findService-DetailPage.selectType') }}</option>
                                        <option value="daily">{{ __('findService-DetailPage.daily') }}</option>
                                        <option value="weekly">{{ __('findService-DetailPage.weekly') }}</option>
                                        <option value="monthly">{{ __('findService-DetailPage.monthly') }}</option>
                                        <option value="hourly">{{ __('findService-DetailPage.hourly') }}</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 mb-md-0 mb-3 form-group notifySubCol">
                                    <input type="submit" value="{{ __('findService-DetailPage.notifyBottonText') }}"
                                        class="btn btn-block border-0 text-white notifySubBtn text-uppercase">
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
                <h5 class="modal-title" style="color: black;">{{ __('findService-DetailPage.sendMessage') }}</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: red;">×</span>
                </button>
            </div>
            <form action="{{route('send-message-to-customer')}}" method="post" class="send_msg_form">
                <div class="modal-body comp-modal-body pl-md-4 pr-md-4 pb-4">
                    @csrf
                    <div class="row" style="font-weight: 600;color: #333;">
                        <div class="col-lg-3">{{ __('findService-DetailPage.title') }}</div>
                        <div class="col-lg-8"> {{@$p_caty !== null ? @$p_caty : ''}} </div>
                    </div>
                    <br>

                    <div class="row" style="font-weight: 600;color: #333;">
                        <div class="col-lg-3">{{ __('findService-DetailPage.name') }}<span style="color: red;">*</span> </div>
                        <div class="col-lg-8">{{@$user->customer_company}}</div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-lg-3" style="font-weight: 600;color: #333;">{{ __('findService-DetailPage.yourMessage') }}<span
                                style="color: red;">*</span></div>
                        <div class="col-lg-7">
                            <textarea class="form-control customer_message" name="customer_message"  id="customer_message"  cols="8"
                                rows="7" required style="resize: none;box-shadow: 0 0 2px 0 rgba(51,51,51,0.1);"
                                id="ex3">{{ __('findService-DetailPage.interestedInCar') }} <b>{{@$p_caty !== null ? @$p_caty : ''}}</b> {{ __('findService-DetailPage.advertisedOn') }} <a href="https://carish.ee/">Cairsh</a>. {{ __('findService-DetailPage.availability') }}<br>
              Thanks.</textarea>
                        </div>
                    </div>





                </div>

                <div class="modal-footer text-center justify-content-center">

                    <input type="hidden" name="to_id" value="{{@$service_ads->customer_id}}">
                    <input type="hidden" name="from_id" value="{{@$user->id}}">
                    <input type="hidden" name="ad_id" value="{{$service_ads->id}}">
                    <input type="hidden" name="type" value="sparepart">
                    <input type="submit" class="btn themebtn1 send_btn" value="{{ __('findService-DetailPage.send') }}">

                </div>
            </form>


        </div>
    </div>
</div>


@push('scripts')
<script src="{{url('public/admin/assets/ckeditor/ckeditor.js')}}" ></script>


<script src="{{asset('public/js/lightslider.js')}}"></script>
    <script src="{{asset('public/js/lightgallery-all.min.js')}}"></script>
<script >

$("#image-gallery").lightSlider({
                gallery: !0,
                item: 1,
                loop: !0,
                thumbItem: 4,
                slideMargin: 0,
                enableDrag: !1,
                currentPagerPosition: "left",
                onSliderLoad: function (e) {
                    e.lightGallery({ selector: "#image-gallery .lslide" }), $("#image-gallery").removeClass("cS-hidden");
                },
            });

  
    $('#savePart').on('click', function () {
        //alert('fd');
        var id = $(this).data('id');
        //alert(id);

        $.ajax({
            method: "get",
            dataType: "json",
            url: "{{url('user/save-sparePartAd')}}/" + id,

            success: function (data) {

                if (data.success == true) {
                    // $('#save-success').css('display','block');
                    $('#heart').css({
                        'color': '#007bff',
                        'transition': '0.5s all'
                    });
                    toastr.success(
                        '<a target="" href="{{url("user/my-saved-ads")}}" class="show_saved_ads">Show my saved ads </a>',
                        'Ad saved successfully.', {
                            "positionClass": "toast-bottom-right"
                        }, {
                            timeOut: 5000
                        });
                    // location.reload();

                }
                if (data.success == false) {
                    $('#heart,#heart2').css({
                        'color': 'gray',
                        'transition': '0.5s all'
                    });
                    toastr.error(
                        '<a target="" href="{{url("user/my-saved-ads")}}" class="show_saved_ads">Show my saved ads </a>',
                        'Ad removed successfully.', {
                            "positionClass": "toast-bottom-right"
                        }, {
                            timeOut: 5000
                        });

                }

            }
        });

    });

    $('#savePartCok').on('click', function () {
        //alert('fd');
        var id = $(this).data('id');
        //alert(id);
        window.location.href = "{{ url('user/login') }}";

    });

    //add alert
    $('#make-accessory-alert').on('submit', function (e) {
        e.preventDefault();
        // alert('alert created');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('make-accessory-alert') }}",
            dataType: 'json',
            method: "post",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                if (response.success === true) {
                    toastr.success('Success!', 'Alert Created Successfully.', {
                        "positionClass": "toast-bottom-right"
                    });
                    $('#make-accessory-alert')[0].reset();
                }
            }
        });
    });

    $(document).ready(function () {
       CKEDITOR.replace( 'customer_message', {
	toolbar: ['/', 
        { name: 'links', items: [ 'Link'] },
	]
});
        $(document).on('click', '.send-msg-btn', function () {
            // alert('hi');
            var id = "{{@$service_ads->customer_id}}";
            var ads_id = "{{@$ads->id}}";
            var ads_type = "sparepart";
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
                success: function (response) {
                    if (response.success === true) {
                        toastr.warning('Alert!',
                            'You already have send message to this ad owner. For further conversation please go to your messages.', {
                                "positionClass": "toast-bottom-right"
                            });
                        $('#make-car-alert')[0].reset();
                    } else if (response.success === false) {
                        $('#savedCarAd').modal('show');
                    }
                }
            });
        });

    });
    $(document).on('click', '.toggle_number', function () {
        // alert('hi');
        $('.half_number').addClass('d-none');
        $('.full_number').removeClass('d-none');
        $('.toggle_number').addClass('add_pointer');
    })
</script>
@endpush


@endsection