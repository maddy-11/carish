@extends('admin.layouts.app')
@push('styles')
<link type="text/css" rel="stylesheet" href="{{asset('public/assets/css/lightslider.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('public/assets/css/lightgallery.min.css')}}" />
@endpush
@push('scripts')
<script src="{{asset('public/assets/js/lightslider.js')}}"></script>
<script src="{{asset('public/assets/js/lightgallery-all.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<script type="text/javascript" charset="utf-8" defer>
  $(document).ready(function ()
  {
    $('#image-gallery').lightSlider({
      gallery:true,
      item:1,
      loop:true,
      thumbItem:4,
      slideMargin:0,
      enableDrag: false,
      currentPagerPosition:'left',
      onSliderLoad: function(el) {
      el.lightGallery({
      selector: '#image-gallery .lslide'
      });
      $('#image-gallery').removeClass('cS-hidden');
      }
      });
  });
    // Go to Bottom function Start here
    jQuery(function() {
    $('.gotosect').click(function() {
    $(this).parent('li').addClass('active');
    // alert("Hello Testing")
    $(this).parent('li').siblings('li').removeClass('active');
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
        $('html, body').animate({
        scrollTop: target.offset().top  -50}, 500);
        return false;
        }
      };
    });
});
</script>
@endpush
@section('content') 
<?php   use Carbon\Carbon; ?>
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
  <div class="d-md-none h-search-col search-col col-12 collapse" id="searchsection">
    <div class="input-group custom-input-group mb-3" >
      <input type="text" class="form-control" placeholder="Search">
      <div class="align-items-center input-group-prepend">
        <span class="input-group-text fa fa-search"></span>
      </div>
    </div>
  </div>

  <div class="col-lg-6 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Car Ads / <a target="" href="{{url('admin/car-ads-list/'.$ads->ads_url($ads->status))}}">{{@$ads->ads_status($ads->status)}}</a> / <a target="" href="{{url('admin/ad-details/'.@$ads->id)}}">{{@$ads_maker->title}}-{{@$ads_model->name}}&nbsp;{{@$ads->year}}</a></h3>
  </div>
  <div class="col-lg-6 col-md-5 col-sm-5 search-col text-right">
    <a class="btn btn-primary" href="{{ url()->previous() }}">
      <i class="fa fa-arrow-left"></i> Back
    </a>
  @if(@$ads->status == 0)
    <a class="btn btn-success" id="approve_ad" data-id="{{@$ads->id}}" href="javascript:void(0)">Approve</a>
    <a class="btn btn-danger" id="not_approve_modal" data-id="{{@$ads->id}}" href="javascript:void(0)">Not Approve</a>
    <a class="btn btn-success" id="translate_lang" data-id="{{@$ads->id}}" href="javascript:void(0)">Translate</a>
  @endif
  @if(@$ads->status == 5)
    <a class="btn btn-success"  href="{{url('admin/invoice-view/'.$ads->get_invoice($ads->id))}}">Invoice</a>
  @endif
  @if($ads->status == 3)
    <button type="button" class="btn btn-warning" id="pending" data-id="{{$ads->id}}">Pending</button>
  @endif
  @if(@$ads->status == 1)
    <button type="button" class="btn btn-danger" id="pending" data-id="{{$ads->id}}">Pending</button>
  @endif
  @if(@$ads->status == 2)
    <!-- <a class="btn btn-success" id="approve_ad" data-id="{{@$ads->id}}" href="javascript:void(0)">Approve</a>
    <a class="btn btn-danger" id="not_approve_modal" data-id="{{@$ads->id}}" href="javascript:void(0)">Not Approve</a> -->
  @endif
</div>
</div>
<div class="container-fluid">
<div class="row">
    <div class="col-6 col-md-5 dr-personal-prof mb-4 productImgCol">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
            <div class="section-header">
                <h5 class="mb-1 text-capitalize"> Car Image</h5>
            </div>
            <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
              @foreach(@$ads_images as $ad_image)
              @if(@$ad_image->img !== null && file_exists( public_path() . '/uploads/ad_pictures/cars/'.$ads->id.'/'.@$ad_image->img))
              <li class="position-relative overflow-hidden rounded car_gallery" data-thumb="{{asset('public/uploads/ad_pictures/cars/'.$ads->id.'/'.$ad_image->img)}}" data-src="{{asset('public/uploads/ad_pictures/cars/'.$ads->id.'/'.$ad_image->img)}}">
              <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
              @if(@$ads->is_featured == 'true')
              <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-uppercase text-white d-inline-block">FEATURED</span>
              @endif
              <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
              </span>
              </figcaption>
              @if(@$ad_image->img !== null && file_exists( public_path() . '/uploads/ad_pictures/cars/'.$ads->id.'/'.@$ad_image->img))
              <img src="{{asset('public/uploads/ad_pictures/cars/'.$ads->id.'/'.$ad_image->img)}}" class="img-fluid" style="width:100%;height: 370px;">
              @else
              <img src="{{ asset('public/assets/img/caravatar.jpg')}}" class="img-fluid" style="width:100%;height: 370px;">
              @endif
            </li>
              @else
              <li class="position-relative overflow-hidden rounded car_gallery" data-thumb="{{ asset('public/assets/img/caravatar.jpg')}}" data-src="{{ asset('public/assets/img/caravatar.jpg')}}">
              <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
              @if(@$ads->is_featured == 'true')
              <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-uppercase text-white d-inline-block">FEATURED</span>
              @endif
              <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
              </span>
              </figcaption>
              @if(@$ad_image->img !== null && file_exists( public_path() . '/uploads/ad_pictures/cars/'.$ads->id.'/'.@$ad_image->img))
              <img src="{{asset('public/uploads/ad_pictures/cars/'.$ads->id.'/'.$ad_image->img)}}" class="img-fluid" style="width:100%;height: 370px;">
              @else
              <img src="{{ asset('public/assets/img/caravatar.jpg')}}" class="img-fluid" style="width:100%;height: 370px;">
              @endif
            </li>
              @endif
              @endforeach
            </ul>
          </div>
        </div>
    <div class="col-6 col-md-7 dr-personal-prof mb-4">
      <div class="bg-white custompadding customborder h-100 d-flex flex-column">
        <div class="section-header">
              <h5 class="mb-1 text-capitalize"> Car Detail</h5>
          </div>
        <div class="col-sm-8 col-9">
            <h5 class="font-weight-bold mb-1"></h5>
            <div class="dr-job text-capitalize"></div>
            <div class="row mt-3 dr-detail-row">
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">
                    Registration number:</h6>
                    <p class="mb-0">{{@$ads->car_number !== null ? @$ads->car_number : '--'}}


                    </p>
                </div>

                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">Bought From:</h6>
                    <p class="mb-0">
                    @if(!empty($ads->bought_from_id))
                  @php
                  $boughtFromCollection = $ads->countryRegistered->boughtFromDescription->where('language_id',$ads->customer->language_id)->first();
                  @endphp
                  {{$boughtFromCollection->title}}
                  @endif </p>
                </div>

                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">{{ __('Registered In') }}:</h6>
                    <p class="mb-0">{{!empty($ads->country_id) ? $ads->country->name : '--'}}</p>
                </div>

                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">{{ __('Registered In') }} {{!empty($ads->country_id) ? $ads->country->name : ''}}:</h6>
                    <p class="mb-0">{{!empty($ads->register_in_estonia) ? Carbon::parse($ads->register_in_estonia)->format("m/Y") : '--'}}</p>
                </div>


                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">Register:</h6>
                    <p class="mb-0">{{@$ads->year}}</p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">Color:</h6>
                    <p class="mb-0">{{@$ads_colors->color_description !== null ? @$ads_colors->color_description->where('language_id',2)->pluck('name')->first() : '--'}}</p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">Transmission:</h6>
                    <p class="mb-0">{{@$ads->transmission !== null ? @$ads->transmission->transmission_description->where('language_id',2)->pluck('title')->first() : '--'}}</p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">Model:</h6>
                    <p class="mb-0">{{@$ads_model->name}}</p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">Maker:</h6>
                    <p class="mb-0">{{@$ads_maker->title}}</p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">Year:</h6>
                    <p class="mb-0">{{@$ads->year}}</p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">bodyType:</h6>
                    <p class="mb-0">{{@$ads->body_type->bodyType_description !== null ? @$ads->body_type->bodyType_description->where('language_id',2)->pluck('name')->first() : '--'}}</p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">Fuel:</h6>
                   <p class="mb-0">{{@$ads->fuel !== null ? @$ads->fuel->engine_type_description->where('language_id',2)->pluck('title')->first() : '--'}}</p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">Doors:</h6>
                    <p class="mb-0">{{@$ads->doors}}</p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">Average:</h6>
                    <p class="mb-0">{{@$ads->fuel_average}} Ltr / 100 km</p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">Add by:</h6>
                    <p class="mb-0"> <a target="" href="{{url('admin/active/user-detail/'.@$ads->customer->id)}}">{{ @$ads->customer !== null ? (@$ads->customer->customer_firstname !== '' ? @$ads->customer->customer_firstname : @$ads->customer->customer_company) : '--' }}</a></p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">Updated at:</h6>
                    <p class="mb-0"> {{ @$ads->updated_at->format('d/m/Y')}}</p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                    <h6 class="text-capitalize font-weight-bold mb-1">Created at:</h6>
                    <p class="mb-0"> {{ @$ads->created_at->format('d/m/Y')}}</p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">Status:</h6>
                <p class="mb-0">
                {{ @$ads->ads_status($ads->status) }}

                @if($ads->status == '3')
                <br /><b>Reason</b>
                {!! $ads->get_reasons($ads->id) !!}
                @endif

                </p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">IsFeature:</h6>
                <p class="mb-0">{{ @$ads->is_featured }}</p>
                </div>
                <div class="col-md-6 col-6 mb-3 dr-detail-col">
                <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">User Type:</h6>
                <p class="mb-0">{{ @$ads->customer->customer_role }}</p>
                </div>
              </div>
          </div>
      </div> 
    </div>
</div>
<!--  Version Details -->  
<div class="bg-white custompadding customborder h-100 d-flex flex-column">
  <div class="section-header">
      <h5 class="mb-1 text-capitalize"> Version Detail 
        <a target="" href="{{url('admin/version/edit/'.@$ads_version->id)}}" class="btn btn-success" style="float:right">Edit</a> 
      </h5>
  </div>
<div class="row">
<div class="col-12">
  <table width="100%" >
      <tr>
        <td width="10%" > <h6 class="text-capitalize font-weight-bold mb-1">Label:</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_version->label}}</p></td>
        <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1">Model:</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_model->name}}</p></td>
        <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1">From Date:</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_version->frssom_date}}</p></td>
        <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1">To Date:</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_version->to_date}}</p></td>
        
       
      </tr>
      <tr>
        <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">CC:</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_version->cc}}</p></td>

        <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1">Body Type:</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_bodyType->bodyType_description !== null ? @$ads_bodyType->bodyType_description->where('language_id',2)->pluck('name')->first() : '--'}}</p></td>

        <td><h6 class="text-capitalize font-weight-bold mb-1">Transmission Type</h6></td>
        <td><p class="mb-0">{{@$ads_version->transmissiontype}}</p></td>

        <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1">Kilowatt:</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_version->kilowatt}}</p></td>
        
      </tr>

      <tr>
        <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1">Car Length:</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_version->car_length}}</p></td>
        <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1">car Width:</h6></td>
        <td width="10%"> <p class="mb-0">{{@$ads_version->car_width}}</p></td>
        <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1">Car Height:</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_version->car_height}}</p></td>

         <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1">Weight:</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_version->weight}}</p></td>
      </tr>
      <tr>
        <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1">Curb Weight:</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_version->curb_weight}}</p></td>
        <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1">Wheel Base</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_version->wheel_base}}</p></td>
        <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1">Ground Clearance</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_version->grouond_clearance}}</p></td>
        <td width="10%"><h6 class="text-capitalize font-weight-bold mb-1">Seating Capacity</h6></td>
        <td width="10%"><p class="mb-0">{{@$ads_version->seating_capacity}}</p></td>
      </tr>

      <tr>
        <td><h6 class="text-capitalize font-weight-bold mb-1">Fuel Tank Capacity</h6></td>
        <td><p class="mb-0">{{@$ads_version->fuel_tank_Capacity}}</p></td>
                    
        <td><h6 class="text-capitalize font-weight-bold mb-1">Number Of Doors</h6></td>
        <td><p class="mb-0">{{@$ads_version->number_of_door}}</p></td>
        <td><h6 class="text-capitalize font-weight-bold mb-1">Displacement</h6></td>
        <td><p class="mb-0">{{@$ads_version->displacement}}</p></td>
        <td><h6 class="text-capitalize font-weight-bold mb-1">Torque</h6></td>
        <td><p class="mb-0">{{@$ads_version->torque}}</p></td>
      </tr>
      <tr>
        <td><h6 class="text-capitalize font-weight-bold mb-1">Gear</h6></td>
        <td><p class="mb-0">{{@$ads_version->gears}}</p></td>
      
        <td><h6 class="text-capitalize font-weight-bold mb-1">Maximun Speed</h6></td>
        <td><p class="mb-0">{{@$ads_version->max_speed}}</p></td>
        <td><h6 class="text-capitalize font-weight-bold mb-1">Acceleration</h6></td>
        <td><p class="mb-0">{{@$ads_version->acceleration}}</p></td>
        <td><h6 class="text-capitalize font-weight-bold mb-1">Number Of Cylinders</h6></td>
        <td><p class="mb-0">{{@$ads_version->number_of_cylinders}}</p></td>
        </tr>
      <tr>
        
        <td><h6 class="text-capitalize font-weight-bold mb-1">Front Wheel Size</h6></td>
        <td><p class="mb-0">{{@$ads_version->front_wheel_size}}</p></td>
        <td><h6 class="text-capitalize font-weight-bold mb-1">Back Wheel Size</h6></td>
        <td><p class="mb-0">{{@$ads_version->back_wheel_size}}</p></td>
      
        <td><h6 class="text-capitalize font-weight-bold mb-1">Front Tyre Size</h6></td>
        <td><p class="mb-0">{{@$ads_version->front_tyre_Size}}</p></td>
        <td><h6 class="text-capitalize font-weight-bold mb-1">Back Tyre Size</h6></td>
        <td><p class="mb-0">{{@$ads_version->back_tyre_size}}</p></td>
        </tr>

      <tr>
        <td><h6 class="text-capitalize font-weight-bold mb-1">Drive Type</h6></td>
        <td><p class="mb-0">{{@$ads_version->drive_type}}</p></td>
        <td><h6 class="text-capitalize font-weight-bold mb-1">Fuel Type</h6></td>
        <td><p class="mb-0">{{@$ads_version->fueltype}}</p></td>
        <td><h6 class="text-capitalize font-weight-bold mb-1">Average Fuel</h6></td>
        <td><p class="mb-0">{{@$ads_version->average_fuel}}</p></td>
        <td><h6 class="text-capitalize font-weight-bold mb-1">Extra Details</h6></td>
        <td><p class="mb-0">{{@$ads_version->extra_details}}</p></td>
      </tr>

    
    </table>
  </div> 
</div> 
</div> 
<!-- end of version detail -->       
<br>
<div class="row">
  <div class="col-8 col-md-8 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
            <div class="section-header">
              <h5 class="mb-1 text-capitalize">Car Features</h5>    
            
            </div>

            <div class="col-sm-12 col-12 personal-profile pl-0 pr-sm-3">
              
              <div class="featureslistitem align-items-baseline" style="padding-right: 20px;">
                <table>
                   @php $i = 0; @endphp
                  <tr>
              @foreach(@$features as $feature)
                 <td style="border: 1px solid #aaa;" width="15%"><b>{{ @$ads->get_feature(@$feature)->name}}</b></td> 
                 @php $i++; @endphp
                @if($i == 6)
              </tr>
              <tr>
                @php $i = 0; @endphp
                @endif
              @endforeach
              </table>
               </div>
           
            </div>
            </div> 
        </div>

  <div class="col-4 col-md-4 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">


          <div class="section-header">
          <h5 class="mb-1 text-capitalize"> Tags 
           <button type="button" class="btn btn-success" data-toggle="modal" data-target="#allTags" style="float:right">Add Tags</button> 

          </h5>
          </div>



            <div class="col-sm-8 col-9">
              
              <div class="car-tags">
       @if($ad_tags->count() > 0)
        <ul class="list-unstyled mb-0">
          @foreach($ad_tags as $tag)
          <li class="list-inline-item mb-3" style="position: relative;">
            <span class="delete_tag" data-id="{{$tag->tag_id}}" title="Delete Tag" style="top:0px;">x</span>
            <span class="badge badge-pill bgcolor1 font-weight-normal p-2 pl-3 pr-3">{{$tag->name}}</span></li> 
              @endforeach
            </ul>
            @endif
          </div>
           
            </div>
            </div> 
    </div>
</div>
<form id="ad_languages" method="post" action="{{route('pending-ad-detail')}}">
  {{ csrf_field() }}
  <input type="hidden" name="ad_id" id="ad_id" value="{{$ads->id}}">
<div class="row">    
  @foreach(@$languages as $language)
    <div class="col-4 col-md-4 dr-personal-prof mb-4">
      <div class="bg-white custompadding customborder h-100 d-flex flex-column">
        <div class="section-header" >      
            <h5>Ad Description ( {{@$language->language_title}}  )</h5>    
        </div>
        <div class="form-group green-border-focus">
          <textarea class="form-control" rows="5" id="lang_{{@$language->id}}" name="lang_{{@$language->id}}">{{@$ads->get_ad_description($ads->id , $language->id)->description}}</textarea>
        </div>
      </div> 
    </div>
  @endforeach   
  @if(@$ads->status == 0)
  <div class="col-lg-12 col-md-6 col-sm-6 search-col text-right">
    <button class="btn btn-success" id="ads_detail" >Save</button>
  </div> 
  @endif
</div>
</form>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 search-col p-0 h-100">
    <div class="purchase-order-detail pt-2 pb-3 pr-3 pl-3 h-100 ">
        <table class="my-tablee dot-dash customborder" width="100%" >
         <thead class="sales-coordinator-thead section-header">
           <tr>
            <th>User</th>
            <th>User Type</th>
            <th>Date/time</th>
            <th>Status </th>
            <th>New Status</th>
           </tr>
         </thead>
         <tbody>
            @foreach($status_history as $history)
            <tr>
              @if($history->usertype == 'customer')
              <td>{{@$history->get_user->customer_company}}</td>
              <td>Customer</td>
              @elseif($history->usertype == 'staff')
              <td>{{@$history->get_staff->name}}</td>
              <td>Staff</td>
              @else
              <td></td>
              <td></td>
              @endif
              
              <td>{{Carbon::parse(@$history->created_at)->format('d/m/Y h:i:s A')}}</td>
              <td>{{$history->status}}</td>
              <td>{{$history->new_status}}</td>
            </tr>
            @endforeach
         </tbody>
        </table>
      </div>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-6 search-col p-0 h-100">
    <div class="purchase-order-detail pt-2 pb-3 pr-3 pl-3 h-100 ">
        <table class="my-tablee dot-dash customborder" width="100%" >
         <thead class="sales-coordinator-thead section-header">
           <tr>
            <th>User</th>
            <th>User Type</th>
            <th>Date/time </th>
            <th>Column</th>
            <th>Old Value </th>
            <th>New Value</th>
           </tr>
         </thead>
         <tbody>
          @if($ad_history->count() == 0)
          <tr>
            <td colspan="5" class="text-center">No Data Found</td>
          </tr>
          @else
            @foreach($ad_history as $history)
            <tr>
              @if($history->usertype == 'customer')
              <td>{{$history->get_user->customer_company}}</td>
              <td>Customer</td>
              @elseif($history->usertype == 'staff')
              <td>{{$history->get_staff->name}}</td>
              <td>Staff</td>
              @else
              <td></td>
              <td></td>
              @endif
              <td>{{Carbon::parse(@$history->created_at)->format('d/m/Y h:i:s A')}}</td>
              <td>{{$history->column_name}}</td>
              <td>{{$history->status}}</td>
              <td>{{$history->new_status}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
      </table>
    </div>
  </div>
  
</div>
</div>
<div class="modal fade" id="adMessageModal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="{{route('admin-not-approve-ad')}}" id="not_approve_ad_form" class="editSuggestion" method="post">
          @csrf
          <div class="modal-body">
        <input type="hidden" name="msg_ad_id" id="msg_ad_id" value="{{@$ads->id}}">
        <div class="form-group">
            <p><span style="color: red;font-style: italic;">Note: </span><span style="font-style: italic;font-weight: 300;">Hold down the Ctrl (windows) or Command (Mac) button to select multiple options.</span></p>
            <hr>
            <label>Reasons</label>
            <select name="reason[]" class="form-control selectpicker" multiple data-live-search="true">
              <option>---Select Reason---</option>
              @foreach($reasons as $reason)
                <option value="{{@$reason->id}}">{{$reason->reason_description()->where('language_id',2)->pluck('title')->first()}}</option>
              @endforeach
            </select>
        </div> 
      </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" id="not_approve_ad" class="btn btn-primary" style="background-color: #017baa !important;border-color: #017baa !important">Submit</button>
      </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal" id="loader_modal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <h3 style="text-align:center;">Please wait</h3>
          <p style="text-align:center;"><img src="{{ asset('assets/admin/img/waiting.gif') }}"></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="allTags" tabindex="-1" role="dialog" aria-labelledby="allTags" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">All Tags</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
          <label for="exampleFormControlSelect2">Select Multiple/Single Tag(s)</label>
          <select multiple class="form-control" id="ad_tags">
            @foreach($all_tags as $tag)
              <option value="{{$tag->tag_id}}">{{$tag->name}}</option>
              @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn add_tags" style="color: #fff !important;
    background-color: #28a745 !important;
    border-color: #28a745 !important;">Add Tags</button>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  .green-border-focus .form-control:focus {
    border: 1px solid #8bc34a;
    box-shadow: 0 0 0 0.2rem rgba(139, 195, 74, .25);
}
table td
{
  border: 1px solid #aaa;
  height: 40px;
  padding: 0 5px;
}
  .lSGallery > li img {
    height: 146px !important;
}
.bgcolor1 {
    background: #0072BB;
    color: white;
}
</style>
<!-- container end -->
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click',"#approve_ad_1",function(){
        $("#ad_languages").submit();

    });
    $(document).on('click', '#approve_ad' , function(){
      // e.preventDefault();

     // $("#ad_languages").submit();
      id = $(this).data('id');
      /*******************/
      swal({
          title: "Alert!",
          text: "Are you sure you want to Approve this Ad?",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          cancelButtonText: "No!",
          closeOnConfirm: true,
          closeOnCancel: true
       },
         function(isConfirm) {
           if (isConfirm){
            $('#loader_modal').modal('show');
             /*******************************/

            
                $.ajax({
                    url:"{{ route('admin-approve-ad')}}",
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        if(data.success == true){
                          window.location = data.url;
                        }

                        if(data.des == false){
                           $('#loader_modal').modal('hide');
                           toastr.error('Error!', 'All Descriptions Must Be Saved', {
                          "positionClass": "toast-bottom-right"
                          });
                          
                        }
                    }
                });
            
        
             /*******************************/
          } 
          else{
              swal("Cancelled", "", "error");
          }
       
    });
      /*******************/

    });

       $(document).on('click', '#add_to_pending' , function(){
      // e.preventDefault();
      id = $(this).data('id');
      /*******************/
      swal({
          title: "Alert!",
          text: "Are you sure you want to add this Ad to pending?",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          cancelButtonText: "No!",
          closeOnConfirm: true,
          closeOnCancel: true
       },
         function(isConfirm) {
           if (isConfirm){
            $('#loader_modal').modal('show');
             /*******************************/

            
                $.ajax({
                    url:"{{ route('admin-add-to-pending-ad')}}",
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        if(data.success == true){
                          window.location = data.url;
                        }

                        if(data.des == false){
                           $('#loader_modal').modal('hide');
                           toastr.error('Error!', 'All Descriptions Must Be Filled', {
                          "positionClass": "toast-bottom-right"
                          });
                          
                        }
                    }
                });
            
        
             /*******************************/
          } 
          else{
              swal("Cancelled", "", "error");
          }
       
    });
      /*******************/

    });



    $(document).on('click', '#not_approve_modal' , function(){
      $('#adMessageModal').modal('show');
    });

    $(document).on('click', '#not_approve_ad' , function(){
      // e.preventDefault();
      id = $(this).data('id');
      /*******************/
      swal({
          title: "Alert!",
          text: "Are you sure you want to not Approve this Ad?",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          cancelButtonText: "No!",
          closeOnConfirm: true,
          closeOnCancel: true
       },
         function(isConfirm) {
           if (isConfirm){
            $('#not_approve_ad_form').submit();
          } 
          else{
            $('#adMessageModal').modal('hide');
              swal("Cancelled", "", "error");
          }
       
    });
      /*******************/

    });

    $('#ads_detail').click(function(){
      // e.preventDefault();
      $("#ad_languages").submit();
    });

    $(document).on('click','.delete_tag',function(e){
      var tag_id = $(this).data('id');
      var ad_id = "{{$ads->id}}";

       /*******************/
      swal({
          title: "Alert!",
          text: "Are you sure you want to delete this tag?",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          cancelButtonText: "No!",
          closeOnConfirm: true,
          closeOnCancel: true
       },
         function(isConfirm) {
           if (isConfirm){
            $('#loader_modal').modal('show');
             /*******************************/

            
                $.ajax({
                    url:"{{ route('admin-delete-tag')}}",
                    method:"get",
                    data:{ad_id:ad_id,tag_id:tag_id},
                    success:function(data)
                    {
                        if(data.success == true){
                           $('#loader_modal').modal('hide');
                           toastr.success('Success!', 'Tag Deleted Successfully!!!', {
                          "positionClass": "toast-bottom-right"
                          });  

                           location.reload();
                        }
                    }
                });
            
        
             /*******************************/
          } 
          else{
              swal("Cancelled", "", "error");
          }
       
    });
      /*******************/
    })

        $(document).on('click','.add_tags',function(e){
      var all_tags = $('#ad_tags').val();
      var ad_id = "{{$ads->id}}";
       /*******************/
            $('#loader_modal').modal('show');
             /*******************************/
                $.ajax({
                    url:"{{ route('admin-add-tags')}}",
                    method:"get",
                    data:{all_tags_id:all_tags,ad_id:ad_id},
                    success:function(data)
                    {
                        if(data.success == true){
                           toastr.success('Success!', 'Tag(s) Added Successfully!!!', {
                          "positionClass": "toast-bottom-right"
                          });  
                           location.reload();
                        }

                        if(data.success == false){
                           $('#loader_modal').modal('hide');
                           toastr.error('Error!', 'Something went wrong!!!', {
                          "positionClass": "toast-bottom-right"
                          });  
                           location.reload();
                        }
                    }
                });            
        
             /*******************************/
    });
      /*******************/

      $('#pending').on('click',function(){

    var ad_id = $(this).data('id');
    //alert(id);
   // var ad_id = $('#ad_id').val();

     swal({
          title: "Alert!",
          text: "Are you sure you want to make this Ad pending?",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          cancelButtonText: "No!",
          closeOnConfirm: true,
          closeOnCancel: true
       },
         function(isConfirm) {
           if (isConfirm){
            $.ajax({
                type: "get",
                dataType: "json",
                url: "{{url('admin/make-ad-pending')}}/"+ad_id,
                
                success: function(data){

                    if(data.success==true)
                    {
                      // redirect to active ads
                      window.location.href = "{{ route('pending-ads')}}";
                    }
                    // setTimeout(function(){ location.reload(); }, 1000);
                    

                },

                    });

        }

        else{
              swal("Cancelled", "", "error");

          }

   });
  


  });


  $(document).on('click', '#translate_lang' , function(){ 
      id = $(this).data('id');
      /*******************/
      swal({
          title: "Alert!",
          text: "Are you sure you want to Translate this Car Ad?",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          cancelButtonText: "No!",
          closeOnConfirm: true,
          closeOnCancel: true
       },
         function(isConfirm) {
           if (isConfirm){ 
                $.ajax({
                    url:"{{ route('admin-translate-ads')}}",
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        if(data.success == true){
                          $('#loader_modal').modal('hide');
                           toastr.success('Success!', 'All Descriptions Translate Successfully', {
                          "positionClass": "toast-bottom-right"
                          });

                          window.location = data.url;
                        } 
                    }
                });
            
        
             /*******************************/
          } 
          else{
              swal("Cancelled", "", "error");
          }
       
    });
      /*******************/

    });



  });
</script>
@endsection