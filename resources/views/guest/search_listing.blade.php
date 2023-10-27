@extends('layouts.app')
@section('title') {{ __('carsForSale.pageTitle') }} @endsection
@push('styles')
<style type="text/css" media="screen">
   ul.ui-autocomplete {
      z-index: 1100;
   }

   .heart {
      color: gray;
      font-size: 20px;
   }

   .heart2 {
      color: #007bff;
      font-size: 20px;
   }

   @media (min-width: 1200px) {
      .desktop_size {
         padding-top: 75%;
      }
   }

   @media (max-width: 1199px) {
      .mob_size {
         padding-top: 100%;
      }
   }

   @media (min-width: 501px) {
      .contact_row {
         position: absolute;
         bottom: 0;
         width: 100%
      }

      .gridingCol .contact_row {
         position: relative;
         width: auto;
      }
   }

   @media (max-width: 500px) {
      .save_heart {
         display: none;
      }

      .share_heart {
         display: none;
      }

      .fa-share {
         font-size: 18px;
      }
   }

   @media (max-width: 767px) {
      .featuredlabel {
         font-size: 9px;
      }
   }

   @media (max-width: 414px) {
      .featuredlabel {
         font-size: 8px;
      }
   }
</style>
@endpush
@push('scripts')
<script type="text/javascript" charset="utf-8" >
   var baseUrl = "{{url('/')}}";
   var get_makers = "{{route('get.makers')}}/";
   var get_models = "{{route('get.models')}}/";
   var save_ad = "{{url('user/save-ad')}}/";
   var sorry_invalid_price_range = "{{ __('carsForSale.sorryInvalidPriceRange') }}";
</script>
<script src="{{ asset('public/js/search.js')}}" ></script>
@endpush
@section('title') @endsection
@section('content')
@php
$request_object = Request();
@endphp
<input type="hidden" id="sortBy" name="sortBy" value="{{$sortBy}}">
{{-- {{dd($side_bar_array['locations'])}} --}}
<div class="internal-page-content mt-4 pt-4 sects-bg">
   <div class="container">
      <div class="row">
         <div class="col-12 bannerAd pt-2">
            <a href="#" target=""><img src="{{url('public/assets/img/placeholder.jpg')}}" class="img-fluid" alt="carish used cars for sale in estonia"></a>
         </div>
         <div class="col-12 pageTitle mt-md-5 mt-4">
            <div class="bg-white border p-md-4 p-3">
               <h2 class="font-weight-semibold">{{__('carsForSale.pageTitle')}} ({{$search_result->total()}})</h2>
               <nav aria-label="breadcrumb" class="breadcrumb-menu" id="breadcrumb">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a target="" href="{{url('/')}}">{{ __('carsForSale.homeBackLink') }}</a></li>
                     <li class="breadcrumb-item"><a target="" href="{{url('find-used-cars')}}">{{ __('carsForSale.usedCarBackLink') }}</a></li>
                     <li class="breadcrumb-item active" aria-current="page">{{ __('carsForSale.pageTitle') }}</li>
                  </ol>
               </nav>
            </div>
         </div>
      </div>
      <div class="row mt-md-5 mt-4">
         <!-- left Sidebar start here -->
         <aside class="col-lg-3 col-12 mb-4 mb-lg-0 left-sidebar">
            <div class="leftsidebar-bg">
               <div class="sidebar-sect-title align-items-center d-flex justify-content-between filterDown pt-3 pb-3 pl-4 pr-4">
                  <h6 class=" sidebar-title mb-0">{{__('carsForSale.showResultsBy')}}:</h6>
                  <em class="fa fa-chevron-circle-down d-lg-none"></em>
               </div>
               
               <div id="searchResultFilter">
                  <div class="card">
                     <div class="card-header pl-4 pr-4" id="heading1">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby1" aria-expanded="true" aria-controls="searchby1">
                           <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-search-filter.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('carsForSale.searchFilters')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby1" class="collapse show" aria-labelledby="heading1" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <ul class="list-unstyled">
                              {!!$searched_keywords!!}
                              <li class="align-items-center d-flex justify-content-between">
                                 <br />
                              </li>
                              <li class="align-items-center d-flex justify-content-between" style="color:#0072bb">
                                 <a href="{{route('simple.search')}}/used-car-for-sale">{{__('carsForSale.clearFilter')}}</a>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header pl-4 pr-4" id="heading2">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby2" aria-expanded="false" aria-controls="searchby2">
                           <figure class="text-center mb-0"><i class="fa fa-building"></i></figure>
                           <span>{{__('carsForSale.searchByMake')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby2" class="collapse" aria-labelledby="heading2" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" class="form-control p-2 pr-2" placeholder="{{__('carsForSale.searchByMake')}}" aria-label="Recipient's username" aria-describedby="basic-addon2" id="car_makes">
                              <input type="hidden" id="car_make" data-value="mk_" value="" class="search_text_submit">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit" type="button"></button>
                              </div>
                           </div>
                           @if(count($side_bar_array['makes']) > 0)
                           <ul class="list-unstyled carselectlist mb-0">
                              @foreach($side_bar_array['makes'] as $makes)
                              <li class="d-flex justify-content-between">
                                 <div class="custom-control mr-2 custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input search_check_submit" value="mk_{{$makes->title}}" id="makesCheck{{$makes->id}}" data-value="mk_{{$makes->title}}" @if(isset($quey_string_slug['mk']) && in_array($makes->title,$quey_string_slug['mk'])) checked="checked" @endif>
                                    <label class="custom-control-label" for="makesCheck{{$makes->id}}">{{$makes->title}}</label>
                                 </div>
                                 <div><span class="badge badge-pill border pb-1 pt-1">{{$makes->total_ads_in_makes}}</span></div>
                              </li>
                              @endforeach
                           </ul>
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header pl-4 pr-4" id="heading3">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby3" aria-expanded="false" aria-controls="searchby3">
                           <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-bodystyle.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('carsForSale.searchByModel')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby3" class="collapse" aria-labelledby="heading3" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" class="form-control p-2 pr-2" placeholder="{{__('carsForSale.searchByModel')}}" aria-label="Recipient's username" aria-describedby="basic-addon2" id="car_models">
                              <input type="hidden" id="car_model" data-value="mo_" value="" class="search_text_submit">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit" type="button"></button>
                              </div>
                           </div>
                           @if(count($side_bar_array['models']) > 0)
                           <ul class="list-unstyled carselectlist mb-0">
                              @foreach($side_bar_array['models'] as $makes)
                              <li class="d-flex justify-content-between">
                                 <div class="custom-control mr-2 custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input search_check_submit" value="mo_{{$makes->name}}" id="modelsCheck{{$makes->id}}" data-value="mo_{{$makes->name}}" @if(isset($quey_string_slug['mo']) && in_array($makes->name,$quey_string_slug['mo'])) checked="checked" @endif>
                                    <label class="custom-control-label" for="modelsCheck{{$makes->id}}">{{$makes->name}}</label>
                                 </div>
                                 <div><span class="badge badge-pill border pb-1 pt-1">{{$makes->total_ads_in_models}}</span></div>
                              </li>
                              @endforeach
                           </ul>
                           @endif
                        </div>
                     </div>
                  </div>
                  {{-- YEARS STARTS HERE --}}
                  <div class="card">
                     <div class="card-header pl-4 pr-4" id="heading4">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby4" aria-expanded="false" aria-controls="searchby4">
                           <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-price.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('carsForSale.searchByYear')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     @php
                     if(Arr::has($quey_string_slug, 'year'))
                     {
                     $year = explode('-',$quey_string_slug['year'][0]);
                     if( count($year) == 1)
                     {
                     $yearFrom = $year[0];
                     }else if(count($year) == 2 && $year[0]== ""){
                     $yearTo = $year[1];
                     }
                     else if(count($year) == 2 && $year[1]== ""){
                     $yearFrom = $year[0];
                     }
                     else
                     {
                     $yearFrom = $year[0];
                     $yearTo = $year[1];
                     }
                     }
                     @endphp
                     <div id="searchby4" class="collapse" aria-labelledby="heading6" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="form-group d-flex mb-0">
                              <select name="yearFrom" id="yearFrom" style="width: 50%" class="select2-field form-control p-1">
                                 <option value="">{{ __('carsForSale.from') }}</option>
                                 @foreach(range(1979, date('Y')) as $i)
                                 <option value="{{$i}}" @if(@$yearFrom==$i) selected="selected" @endif>{{$i}}</option>
                                 @endforeach
                              </select>
                              <select name="yearTo" id="yearTo" style="width: 50%" class="select2-field form-control p-1 ml-2 mr-2">
                                 <option value="">{{ __('carsForSale.to') }}</option>
                                 @foreach(range(date('Y'), date('Y')-79) as $i)
                                 <option value="{{$i}}" @if(@$yearTo==$i) selected="selected" @endif>{{$i}}</option>
                                 @endforeach
                              </select>
                              <button type="button" class="fa fa-check themebtn3 search_check_submit"></button>
                           </div>
                        </div>
                     </div>
                  </div>
                  {{-- PRICE STARTS HERE --}}
                  <div class="card">
                     <div class="card-header pl-4 pr-4" id="heading40">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby40" aria-expanded="false" aria-controls="searchby40">
                           <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-price.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('carsForSale.searchByPrice')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     @php
                     $maximumPrice = '';
                     $minimumPrice = '';
                     if(Arr::has($quey_string_slug, 'price'))
                     {
                     $price = explode('-',$quey_string_slug['price'][0]);
                     if( count($price) == 1)
                     {
                     $minPrice = $price[0];
                     }else if(count($price) == 2 && $price[0]== ""){
                     $maxPrice = $price[1];
                     }
                     else if(count($price) == 2 && $price[1]== ""){
                     $minPrice = $price[0];
                     }
                     else
                     {
                     $minPrice = $price[0];
                     $maxPrice = $price[1];
                     }
                     }
                     @endphp
                     <div id="searchby40" class="collapse" aria-labelledby="heading6" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="form-group d-flex mb-0">
                              <!-- <select name="minPrice" id="minPrice" style="width: 50%" class="select2-field form-control p-1">
                                 <option value="">{{__('common.from')}}</option>
                                 @for($i=5;$i<=30;$i+=5)
                                         <option value="{{$i}}" @if(@$minPrice/100000 == $i) selected="selected" @endif>{{$i}} {{__('common.lacks')}}</option> 
                                 @endfor
                                 </select>
                                 <select name="maxPrice" id="maxPrice" style="width: 50%" class="select2-field form-control p-1 ml-2 mr-2">
                                 <option value="">{{ __('home.to') }}</option>
                                           @for($i=5;$i<=30;$i+=5)
                                         <option value="{{$i}}" @if(@$maxPrice/100000 == $i) selected="selected" @endif>{{$i}} {{__('common.lacks')}}</option> 
                                 @endfor
                                 </select> -->
                              <span class="align-items-center border d-block d-flex pricerange px-3 py-1" style="width: 100%;">
                                 @if(@$minPrice !== null)
                                 <div class="pr-range-min" style="">{{@$minPrice}}</div>
                                 @php
                                 $minimumPrice = $minPrice;
                                 @endphp
                                 @else
                                 <div class="select-prng">{{__('carsForSale.searchByPrice')}} </div>
                                 <div class="pr-range-min" style="display: none"></div>
                                 @endif
                                 @if(@$minPrice !== null)
                                 <div class="pr-range-dash px-1" style="">-</div>
                                 @else
                                 <div class="pr-range-dash px-1" style="display: none">-</div>
                                 @endif
                                 @if(@$maxPrice !== null)
                                 <div class="pr-range-max" style="">{{@$maxPrice}}</div>
                                 @php
                                 $maximumPrice = $maxPrice;
                                 @endphp
                                 @else
                                 <div class="pr-range-max" style="display: none"></div>
                                 @endif
                              </span>
                              <div class="pr-dropdown pr-dropdown-cls" style="display: none;position: absolute;top: 108px;width: 85%;">
                                 <div class="d-flex pt-2 pr-2 pl-2" style="background-color: #EAF0FF">
                                    <input type="text" name="minPrice" id="minPrice" placeholder="{{ __('carsForSale.from') }}" class="form-control form-control-sm mb-2" value="{{$minimumPrice}}">
                                    <span style="line-height: 2.5;" class="pr-2 pl-2">-</span>
                                    <input type="text" name="maxPrice" id="maxPrice" placeholder="{{ __('carsForSale.to') }}" class="form-control form-control-sm mb-2" value="{{$maximumPrice}}">
                                 </div>
                                 <div class="d-flex">
                                    <div class="p-2 pr-min w-50">
                                       <ul class="min-price-list list-unstyled mb-0" style="">
                                          @for($i = 1000;$i<=5000;$i+=1000) <li>{{$i}}</li>
                                             @endfor
                                       </ul>
                                    </div>
                                    <div class="p-2 pr-max">
                                       <ul class="max-price-list list-unstyled mb-0" style="display: none;">
                                          @for($i = 1000;$i<=5000;$i+=1000) <li>{{$i}}</li>
                                             @endfor
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <button type="button" class="fa fa-check themebtn3 search_check_submit"></button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header pl-4 pr-4" id="heading5">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby5" aria-expanded="false" aria-controls="searchby5">
                           <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-mileage.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('carsForSale.searchByMileage')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby5" class="collapse" aria-labelledby="heading6" data-parent="#searchResultFilter">
                        @php
                        if(Arr::has($quey_string_slug, 'millage'))
                        {
                        $millage = explode('-',$quey_string_slug['millage'][0]);
                        if( count($millage) == 1)
                        {
                        $fromMillage = $millage[0];
                        }else if(count($millage) == 2 && $millage[0]== ""){
                        $toMillage = $millage[1];
                        }
                        else if(count($millage) == 2 && $millage[1]== ""){
                        $fromMillage = $millage[0];
                        }
                        else
                        {
                        $fromMillage = $millage[0];
                        $toMillage = $millage[1];
                        }
                        }
                        @endphp
                        <div class="card-body">
                           <div class="form-group d-flex mb-0">
                              <span class="align-items-center border d-block d-flex mileagerange px-3 py-1" style="height: 3rem;width: 100%;">
                                 @if(@$fromMillage !== null)
                                 <div class="pr-mileage-min" style="">{{@$fromMillage}} Km</div>
                                 @else
                                 <div class="select-prng-mileage">{{__('carsForSale.searchByMileage')}}</div>
                                 <div class="pr-mileage-min" style="display: none"></div>
                                 @endif
                                 @if(@$fromMillage !== null)
                                 <div class="pr-mileage-dash px-1" style="">-</div>
                                 @else
                                 <div class="pr-mileage-dash px-1" style="display: none">-</div>
                                 @endif
                                 @if(@$toMillage !== null)
                                 <div class="pr-mileage-max" style="">{{@$toMillage}} Km</div>
                                 @else
                                 <div class="pr-mileage-max" style="display: none"></div>
                                 @endif
                              </span>
                              <div class="pr-dropdown-mileage pr-dropdown-cls" style="display: none;position: absolute;top: 108px;width: 85%;">
                                 <div class="d-flex pt-2 pr-2 pl-2" style="background-color: #EAF0FF">
                                    <input type="text" name="fromMillage" id="fromMillage" placeholder="{{ __('carsForSale.from') }}" class="form-control form-control-sm mb-2" value="{{@$fromMillage}}">
                                    <span style="line-height: 2.5;" class="pr-2 pl-2">-</span>
                                    <input type="text" name="toMillage" id="toMillage" placeholder="{{ __('carsForSale.to') }}" class="form-control form-control-sm mb-2" value="{{@$toMillage}}">
                                 </div>
                                 <div class="d-flex">
                                    <div class="p-2 pr-min w-50">
                                       <ul class="min-mileage-list list-unstyled mb-0" style="">
                                          <li data-id="10000">10,000 km</li>
                                          <li data-id="20000">20,000 km</li>
                                          <li data-id="30000">30,000 km</li>
                                          <li data-id="40000">40,000 km</li>
                                          <li data-id="50000">50,000 km</li>
                                          <li data-id="60000">60,000 km</li>
                                          <li data-id="70000">70,000 km</li>
                                          <li data-id="80000">80,000 km</li>
                                          <li data-id="90000">90,000 km</li>
                                          <li data-id="100000">100,000 km</li>
                                          <li data-id="125000">125,000 km</li>
                                          <li data-id="150000">150,000 km</li>
                                          <li data-id="175000">175,000 km</li>
                                          <li data-id="200000">200,000 km</li>
                                       </ul>
                                    </div>
                                    <div class="p-2 pr-max">
                                       <ul class="max-mileage-list list-unstyled mb-0" style="display: none;">
                                          <li data-id="10000">10,000 km</li>
                                          <li data-id="20000">20,000 km</li>
                                          <li data-id="30000">30,000 km</li>
                                          <li data-id="40000">40,000 km</li>
                                          <li data-id="50000">50,000 km</li>
                                          <li data-id="60000">60,000 km</li>
                                          <li data-id="70000">70,000 km</li>
                                          <li data-id="80000">80,000 km</li>
                                          <li data-id="90000">90,000 km</li>
                                          <li data-id="100000">100,000 km</li>
                                          <li data-id="125000">125,000 km</li>
                                          <li data-id="150000">150,000 km</li>
                                          <li data-id="175000">175,000 km</li>
                                          <li data-id="200000">200,000 km</li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <button type="button" class="fa fa-check themebtn3 search_check_submit"></button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header pl-4 pr-4" id="heading6">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby6" aria-expanded="false" aria-controls="searchby6">
                           <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-location.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('carsForSale.searchByLocation')}} <small class="d-block"> </small></span>
                        </a>
                     </div>
                     <div id="searchby6" class="collapse" aria-labelledby="heading6" data-parent="#searchResultFilter">
                        {{-- <div class="card-body">
                           @if(count($side_bar_array['locations']) > 0)
                           <ul class="list-unstyled carselectlist mb-0">
                              @foreach($side_bar_array['countries'] as $locations)
                              <li class="d-flex justify-content-between">
                                 <div class="custom-control mr-2 custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input search_check_submit" value="cy_{{$locations->title}}" id="locationCheck{{$locations->country_id}}" data-value="cy_{{$locations->title}}" @if(isset($quey_string_slug['cy']) && in_array($locations->title,$quey_string_slug['cy'])) checked="checked" @endif>
                        <label class="custom-control-label" for="locationCheck{{$locations->country_id}}">{{$locations->title}}</label>
                     </div>
                     <div><span class="badge badge-pill border pb-1 pt-1">{{$locations->total_ads_in_countries}}</span></div>
                     </li>
                     @endforeach
                     </ul>

                     @endif
                  </div> --}}

                  <div class="card-body">
                     @if(count($side_bar_array['locations']) > 0)
                     <ul class="list-unstyled carselectlist mb-0">
                        @foreach($side_bar_array['locations'] as $locations)
                        <li class="d-flex justify-content-between">
                           <div class="custom-control mr-2 custom-checkbox ">
                              <input type="checkbox" class="custom-control-input search_check_submit" value="ct_{{$locations->name}}" id="locationCheck{{$locations->name}}" data-value="ct_{{$locations->name}}" @if(isset($quey_string_slug['ct']) && in_array($locations->name,$quey_string_slug['ct'])) checked="checked" @endif>
                              <label class="custom-control-label" for="locationCheck{{$locations->name}}">{{$locations->name}}</label>
                           </div>
                           <div><span class="badge badge-pill border pb-1 pt-1">{{$locations->total_ads_in_cities}}</span></div>
                        </li>
                        @endforeach
                     </ul>

                     @endif
                  </div>

               </div>
            </div>
         @if(count($side_bar_array['bodyTypes']) > 0)
         <div class="card">
            <div class="card-header pl-4 pr-4" id="heading7">
               <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby7" aria-expanded="false" aria-controls="searchby7">
                  <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-bodystyle.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                  <span>{{__('carsForSale.searchByBodytype')}} <small class="d-block"></small></span>
               </a>
            </div>
            <div id="searchby7" class="collapse" aria-labelledby="heading7" data-parent="#searchResultFilter">
               <div class="card-body">
                  <ul class="list-unstyled carselectlist mb-0">
                     @foreach($side_bar_array['bodyTypes'] as $keys => $colors)
                     <li class="d-flex justify-content-between">
                        <div class="custom-control mr-2 custom-checkbox ">
                           <input type="checkbox" class="custom-control-input search_check_submit" value="bt_{{$colors->name}}" id="bodyCheck{{$colors->name}}" data-value="bt_{{$colors->name}}" @if(isset($quey_string_slug['bt']) && in_array($colors->name,$quey_string_slug['bt'])) checked="checked" @endif>
                           <label class="custom-control-label" for="bodyCheck{{$colors->name}}">{{$colors->name}}</label>
                        </div>
                        <div><span class="badge badge-pill border pb-1 pt-1">{{$colors->total_ads_in_body}}</span></div>
                     </li>
                     @endforeach
                  </ul>
               </div>
            </div>
         </div>
         @endif
            <div class="card">
               <div class="card-header pl-4 pr-4" id="heading8">
                  <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby8" aria-expanded="false" aria-controls="searchby8">
                     <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-fuel.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                     <span>{{__('carsForSale.searchByFuel')}}<small class="d-block"></small></span>
                  </a>
               </div>
               <div id="searchby8" class="collapse" aria-labelledby="heading8" data-parent="#searchResultFilter">
                  <div class="card-body">
                     @if(count($side_bar_array['fuel']) > 0)
                     <ul class="list-unstyled carselectlist mb-0">
                        @foreach($side_bar_array['fuel'] as $fuels)
                        <li class="d-flex justify-content-between">
                           <div class="custom-control mr-2 custom-checkbox ">
                              <input type="checkbox" class="custom-control-input search_check_submit" id="fuel{{$fuels->title}}" value="fuel_{{$fuels->title}}" data-value="fuel_{{$fuels->title}}" @isset($quey_string_slug['fuel']) @if(in_array($fuels->title,$quey_string_slug['fuel'])) checked="checked" @endif @endisset>
                              <label class="custom-control-label" for="fuel{{$fuels->title}}">{{$fuels->title}}</label>
                           </div>
                           <div><span class="badge badge-pill border pb-1 pt-1">{{$fuels->total_ads_in_fuel}}</span></div>
                        </li>
                        @endforeach
                     </ul>
                     @endif
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header pl-4 pr-4" id="heading9">
                  <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby9" aria-expanded="false" aria-controls="searchby9">
                     <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-gearbox.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                     <span>{{__('carsForSale.searchByGearbox')}}<small class="d-block"></small></span>
                  </a>
               </div>
               <div id="searchby9" class="collapse" aria-labelledby="heading9" data-parent="#searchResultFilter">
                  <div class="card-body">
                     @if(count($side_bar_array['transmission']) > 0)
                     <ul class="list-unstyled carselectlist mb-0">
                        @foreach($side_bar_array['transmission'] as $transmission)
                        <li class="d-flex justify-content-between">
                           <div class="custom-control mr-2 custom-checkbox ">
                              <input type="checkbox" class="custom-control-input search_check_submit" id="transmission{{$transmission->title}}" value="transmission_{{$transmission->title}}" data-value="transmission_{{$transmission->title}}" @isset($quey_string_slug['transmission']) @if(in_array($transmission->title,$quey_string_slug['transmission'])) checked="checked" @endif @endisset>
                              <label class="custom-control-label" for="transmission{{$transmission->title}}">{{$transmission->title}}</label>
                           </div>
                           <div><span class="badge badge-pill border pb-1 pt-1">{{$transmission->total_ads_in_transmission}}</span></div>
                        </li>
                        @endforeach
                     </ul>
                     @endif
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header pl-4 pr-4" id="heading10">
                  <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby10" aria-expanded="false" aria-controls="searchby10">
                     <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-color.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                     <span>{{__('carsForSale.searchByColor')}} <small class="d-block"></small></span>
                  </a>
               </div>
               <div id="searchby10" class="collapse" aria-labelledby="heading10" data-parent="#searchResultFilter">
                  <div class="card-body">
                     @if(count($side_bar_array['colors']) > 0)
                     <ul class="list-unstyled carselectlist mb-0">
                        @foreach($side_bar_array['colors'] as $keys => $colors)
                        <li class="d-flex justify-content-between">
                           <div class="custom-control mr-2 custom-checkbox ">
                              <input type="checkbox" class="custom-control-input search_check_submit" id="colorCheck{{$colors->name}}" value="cl_{{$colors->name}}" data-value="cl_{{$colors->name}}" @isset($quey_string_slug['cl']) @if(in_array($colors->name,$quey_string_slug['cl'])) checked="checked" @endif @endisset>
                              <label class="custom-control-label" for="colorCheck{{$colors->name}}">{{$colors->name}}</label>
                           </div>
                           <div><span class="badge badge-pill border pb-1 pt-1">{{$colors->total_ads_in_color}}</span></div>
                        </li>
                        @endforeach
                     </ul>
                     @endif
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header pl-4 pr-4" id="heading11">
                  <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby11" aria-expanded="false" aria-controls="searchby11">
                     <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-enginesize.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                     <span>{{__('carsForSale.searchByEngine')}}<small class="d-block"></small></span>
                  </a>
               </div>
               <div id="searchby11" class="collapse" aria-labelledby="heading11" data-parent="#searchResultFilter">
                  @php
                  if(Arr::has($quey_string_slug, 'power'))
                  {
                  $power = explode('-',$quey_string_slug['power'][0]);
                  if( count($power) == 1)
                  {
                  $powerFrom = $power[0];
                  }else if(count($power) == 2 && $power[0]== ""){
                  $powerTo = $power[1];
                  }
                  else if(count($power) == 2 && $power[1]== ""){
                  $powerFrom = $power[0];
                  }
                  else
                  {
                  $powerFrom = $power[0];
                  $powerTo = $power[1];
                  }
                  }
                  if(Arr::has($quey_string_slug, 'enginecc'))
                  {
                  $enginecc = explode('-',$quey_string_slug['enginecc'][0]);
                  if( count($enginecc) == 1)
                  {
                  $engineccFrom = $enginecc[0];
                  }else if(count($enginecc) == 2 && $enginecc[0]== ""){
                  $engineccTo = $enginecc[1];
                  }
                  else if(count($enginecc) == 2 && $enginecc[1]== ""){
                  $engineccFrom = $enginecc[0];
                  }
                  else
                  {
                  $engineccFrom = $enginecc[0];
                  $engineccTo = $enginecc[1];
                  }
                  }
                  @endphp
                  <div class="card-body">
                     <div class="form-group d-flex mb-0" style="align-items: center;">
                        <span class="mr-2" style="font-size: 14px;color: #aaa;">KW</span>
                        <input type="text" name="powerFrom" id="powerFrom" placeholder="{{__('carsForSale.from')}}" class="form-control p-1" value="{{@$powerFrom}}" style="border-radius: 0px;">
                        <input type="text" name="powerTo" id="powerTo" placeholder="{{__('carsForSale.to')}}" class="form-control p-1 ml-2 mr-2" value="{{@$powerTo}}" style="border-radius: 0px;">
                        <button type="button" class="fa fa-search themebtn3 search_check_submit" style="font-size: 14px;background-color: white;color: #aaa;border: none;"></button>
                     </div>
                     <div class="form-group d-flex mb-0" style="align-items: center;text-align: center;">
                        <span style="width: 100%;font-size: 14px;color: #aaa;" class="mt-3 mb-3">{{__('carsForSale.or')}}</span>
                     </div>
                     <div class="form-group d-flex mb-0" style="align-items: center;">
                        <span class="mr-2" style="font-size: 14px;color: #aaa;">CC</span>
                        <input type="text" name="engineccFrom" id="engineccFrom" placeholder="{{__('carsForSale.from')}}" class="form-control p-1" value="{{@$engineccFrom}}" style="border-radius: 0px;">
                        <input type="text" name="engineccTo" id="engineccTo" placeholder="{{__('carsForSale.to')}}" class="form-control p-1 ml-2 mr-2" value="{{@$engineccTo}}" style="border-radius: 0px;">
                        <button type="button" class="fa fa-search themebtn3 search_check_submit" style="font-size: 14px;background-color: white;color: #aaa;border: none;"></button>
                     </div>
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header pl-4 pr-4" id="heading10">
                  <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby12" aria-expanded="false" aria-controls="searchby12">
                     <figure class="text-center mb-0"><img src="{{url('public/assets/img/pic.jpg')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                     <span>{{__('carsForSale.searchByAdPicture')}} <small class="d-block"></small></span>
                  </a>
               </div>
               <div id="searchby12" class="collapse" aria-labelledby="heading12" data-parent="#searchResultFilter">
                  <div class="card-body">
                     <ul class="list-unstyled carselectlist mb-0">
                        <li class="d-flex justify-content-between">
                           <div class="custom-control mr-2 custom-checkbox ">
                              <input type="checkbox" class="custom-control-input search_check_submit" id="pictureCheck" value="pic_Ads-With-Pictures" data-value="pic_Ads-With-Pictures" @isset($quey_string_slug['pic']) @if(in_array('Ads-With-Pictures',$quey_string_slug['pic'])) checked="checked" @endif @endisset>
                              <label class="custom-control-label" for="pictureCheck">{{__('carsForSale.searchByAdPictureCheckbox')}}</label>
                           </div>
                           <div><span class="badge badge-pill border pb-1 pt-1"></span></div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            {{-- SELLER TYPE  --}}
            <div class="card">
               <div class="card-header pl-4 pr-4" id="heading10">
                  <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby13" aria-expanded="false" aria-controls="searchby13">
                     <figure class="text-center mb-0"><img src="{{url('public/assets/img/seller.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                     <span>{{__('carsForSale.searchBySellerType')}} <small class="d-block"></small></span>
                  </a>
               </div>
               <div id="searchby13" class="collapse" aria-labelledby="heading13" data-parent="#searchResultFilter">
                  <div class="card-body">
                     <ul class="list-unstyled carselectlist mb-0">
                        @php
                        $dealer_checked = "";
                        $dealer = true;
                        $individual_checked = "";
                        $individual = true;
                        if(isset($quey_string_slug['seller']) && in_array('individual',$quey_string_slug['seller']))
                        {
                        $dealer = false;
                        $individual_checked = "checked";
                        }
                        if(isset($quey_string_slug['seller']) && in_array('business',$quey_string_slug['seller']))
                        {
                        $individual = false;
                        $dealer_checked = "checked";
                        }
                        @endphp
                        @if($individual)
                        <li class="d-flex justify-content-between">
                           <div class="custom-control mr-2 custom-checkbox ">
                              <input type="checkbox" class="custom-control-input search_check_submit" id="sellertype1Check" value="seller_individual" data-value="seller_individual" {{$individual_checked}}>
                              <label class="custom-control-label" for="sellertype1Check">{{__('carsForSale.searchBySellerIndividual')}}</label>
                           </div>
                           <div><span class="badge badge-pill border pb-1 pt-1"></span></div>
                        </li>
                        @endif
                        @if($dealer)
                        <li class="d-flex justify-content-between">
                           <div class="custom-control mr-2 custom-checkbox ">
                              <input type="checkbox" class="custom-control-input search_check_submit" id="sellertypeCheck" value="seller_business" data-value="seller_business" {{$dealer_checked}}>
                              <label class="custom-control-label" for="sellertypeCheck">{{__('carsForSale.searchBySellerDealer')}}</label>
                           </div>
                           <div><span class="badge badge-pill border pb-1 pt-1"></span></div>
                        </li>
                        @endif
                     </ul>
                  </div>
               </div>
            </div>
            {{-- Ad Type --}}
            <div class="card">
               <div class="card-header pl-4 pr-4" id="heading10">
                  <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby14" aria-expanded="false" aria-controls="searchby14">
                     <figure class="text-center mb-0"><img src="{{url('public/assets/img/ads.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                     <span>{{__('carsForSale.adType')}} <small class="d-block"></small></span>
                  </a>
               </div>
               <div id="searchby14" class="collapse" aria-labelledby="heading14" data-parent="#searchResultFilter">
                  <div class="card-body">
                     <ul class="list-unstyled carselectlist mb-0">
                        <li class="d-flex justify-content-between">
                           <div class="custom-control mr-2 custom-checkbox ">
                              <input type="checkbox" class="custom-control-input search_check_submit" id="featuredCheck" value="isf_featured" data-value="isf_featured" @isset($quey_string_slug['isf']) @if(in_array('featured',$quey_string_slug['isf'])) checked="checked" @endif @endisset>
                              <label class="custom-control-label" for="featuredCheck">{{__('carsForSale.featuredAds')}}</label>
                           </div>
                           <div><span class="badge badge-pill border pb-1 pt-1"></span></div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            {{-- TAGS STARTS HERE --}}
            <div class="card">
               <div class="card-header pl-4 pr-4" id="heading12">
                  <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby15" aria-expanded="false" aria-controls="searchby15">
                     <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-price.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                     <span>{{__('carsForSale.searchByTags')}} <small class="d-block"></small></span>
                  </a>
               </div>
               <div id="searchby15" class="collapse" aria-labelledby="heading6" data-parent="#searchResultFilter">
                  <div class="card-body">
                     <div class="form-group d-flex mb-0">
                        <select class="selectpicker" multiple name="tags[]" id="tags" title="{{__('carsForSale.searchByTagsDefault')}}">
                           <option value="">{{__('carsForSale.searchByTagsDefault')}}</option>
                           @if (!$tags->isEmpty()) {
                           @foreach($tags as $tag){
                           <option value="tg_{{$tag->id}}" @if(Arr::has($quey_string_slug, 'tg' ) && in_array($tag->id,$quey_string_slug['tg'])) selected @endif> {{$tag->name}}</option>
                           @endforeach
                           @endif
                        </select>
                        <button type="button" class="fa fa-check themebtn3 search_check_submit"></button>
                     </div>
                  </div>
               </div>
            </div>
      </div>
   </div>
   </aside>
   <!-- left Sidebar ends here -->
   <!-- right content section starts here -->
   <div class="col-lg-9 col-12 right-content">
      <!-- sorting and listing/grid section start here -->
      <div class="sortingsection bg-white border">
         <div class="align-items-center ml-0 mr-0 pb-3 pt-3 row">
            <div class="col-md-6 col-md-6 col-sm-6 mb-sm-0 mb-3 sorting-col">
               <div class="align-items-center d-flex">
                  <label class="mb-0 mr-3 text-nowrap">{{__('carsForSale.sortBy')}}:</label>
                  <select name="sorting" id="sorting" class="form-control form-control-sm">
                     <option value="updated_at desc" @if(isset($sortBy) && $sortBy=='updated_at desc' ) selected="selected" @endif>{{__('carsForSale.sortByDateRecent')}}</option>
                     <option value="updated_at asc" @if(isset($sortBy) && $sortBy=='updated_at asc' ) selected="selected" @endif>{{__('carsForSale.sortByDateOld')}}</option>
                     <option value="price asc" @if(isset($sortBy) && $sortBy=='price asc' ) selected="selected" @endif>{{__('carsForSale.sortByPriceLowIgh')}}</option>
                     <option value="price desc" @if(isset($sortBy) && $sortBy=='price desc' ) selected="selected" @endif>{{__('carsForSale.sortByPriceHighLow')}}</option>
                     <option value="year desc" @if(isset($sortBy) && $sortBy=='year desc' ) selected="selected" @endif>{{__('carsForSale.sortByModelNewOld')}}</option>
                     <option value="year asc" @if(isset($sortBy) && $sortBy=='year asc' ) selected="selected" @endif>{{__('carsForSale.sortByModelOldNew')}}</option>
                     <option value="millage asc" @if(isset($sortBy) && $sortBy=='millage asc' ) selected="selected" @endif>{{__('carsForSale.sortByMileageLowHigh')}}</option>
                     <option value="millage desc" @if(isset($sortBy) && $sortBy=='millage desc' ) selected="selected" @endif>{{__('carsForSale.sortByMileageHighLow')}}</option>
                  </select>
               </div>
            </div>
            <div class="col-md-6 col-sm-6 d-flex list-grid-col">
               <ul class="ml-auto mb-0">
                  <li class="list-inline-item">
                     <a class="active listIcon" data-toggle="tab" href="javscriptvoid:(0)">
                        <em class="fa fa-list"></em> {{__('carsForSale.listView')}}
                     </a>
                  </li>
                  <li class="list-inline-item">
                     <a href="javscriptvoid:(0)" class="gridIcon">
                        <em class="fa fa-table"></em> {{__('carsForSale.gridView')}}
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <!-- sorting and listing/grid section ends here -->
      <!-- listing view starts here -->
      <div class="row listingtab">
         @if(@$search_result->count() > 0)
         @foreach($search_result as $show_result)
         <div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
            <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar">
                  <figure class="mb-0 position-relative">
                     @if(@$show_result->ads_images[0]->img != null && file_exists( public_path() . '/uploads/ad_pictures/cars/'.$show_result->id.'/'.@$show_result->ads_images[0]->img))
                     <a href="javascript:void(0)" style="display: block;background-image: url('{{url('public/uploads/ad_pictures/cars/'.$show_result->id.'/'.@$show_result->ads_images[0]->img)}}');
                              background-size: cover;
                              background-position: center;" class="desktop_size mob_size">
                     </a>
                     @else
                     <a href="javascript:void(0)" style="display: block;background-image: url('{{url('public/assets/img/caravatar.jpg')}}'); background-size: cover;background-position: center;" class="desktop_size mob_size">
                     </a>
                     @endif
                     <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                        @if($show_result->is_featured == 'true')
                        <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-white d-inline-block mt-2">{{__('carsForSale.featuredAds')}}
                        </span>
                        @endif
                        <span class="d-inline-block pb-1 pl-2 pr-2 pt-1 viewgallery"><em class="fa fa-camera  mr-1"></em> {{@$show_result->ads_images !== null ? @$show_result->ads_images->count() : '0'}}</span>
                     </figcaption>
                     </a>
                  </figure>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-8 listingCar-descCar">
                  <div class="align-items-center d-flex justify-content-between listingCar-title mb-1">
                     <!-- added -->
                      <h5 class="font-weight-normal mb-0"><a target="" href="{{url('car-details/'.$show_result->id)}}" target="">{{@$show_result->maker->title}} {{@$show_result->model->name}} {{@$show_result->year}} {{$show_result->version_label}}</a></h5> 
                     <!-- <form method="GET" action="{{ url('car-details/'. @$show_result->slug ) }}" id="ad_form">
                        <h5 class="font-weight-normal mb-0"><a href="#" onclick="   ">{{@$show_result->maker->title}} {{@$show_result->model->name}} {{@$show_result->year}} {{$show_result->version_label}}</a></h5>
                        <span class="lcPrice d-inline-block ml-3 font-weight-semibold">€{{$show_result->price}}</span>
                     </form> -->
                     <!-- <h5 class="font-weight-normal mb-0"><a class="getSlug" target="" data-id="{{encrypt($show_result->id)}}" href="javascript:void(0)" target="">{{@$show_result->maker->title}} {{@$show_result->model->name}} {{@$show_result->year}} {{$show_result->version_label}}</a></h5> -->
                     <span class="lcPrice d-inline-block ml-3 font-weight-semibold">€{{$show_result->price}}</span>
                  </div>
                  <div class="align-items-center d-flex justify-content-between listingCar-place mb-3">
                     <p class="carplace mb-0">{{$show_result->city_name}}</p>
                     <p class="themecolor2 font-weight-semibold mb-0 negotiable">
                        @if($show_result->neg)
                        {{__('carsForSale.negotiable')}}
                        @endif
                     </p>
                  </div>
                  <div class="align-items-center d-flex justify-content-between aboutcarlist mb-3">
                     <ul class="list-unstyled mb-0" style="opacity: 0.5">
                        <li class="list-inline-item">{{$show_result->year}}</li>
                        <span>&#124;</span>
                        <li class="list-inline-item">{{$show_result->millage}} KM</li>
                        <span>&#124;</span>
                        <li class="list-inline-item">{{$show_result->engine_title}}</li>
                        <span>&#124;</span>
                        <li class="list-inline-item">{{$show_result->engine_capacity}}/{{$show_result->engine_power}}KW</li>
                        <span>&#124;</span>
                        <li class="list-inline-item">{{$show_result->transmission_title}}</li>
                     </ul>
                     <span></span>
                  </div>
                  <div class="align-items-center d-none justify-content-between gridListprice mb-3">
                     <span class="lcPrice d-inline-block mr-3 font-weight-semibold"> €{{$show_result->price}}</span>
                     @if($show_result->neg)
                     <p class="themecolor2 font-weight-semibold mb-0 negotiable">
                        {{__('carsForSale.negotiable')}}
                     </p>
                     @endif
                  </div>
                  <div class="align-items-center row contactRow " style="">
                     <div class="col-lg-5 col-md-5 col-sm-4 col-4 ">
                        <p class="mb-0">
                           @php
                           $updated_at = \Carbon\Carbon::parse($show_result->last_updated);
                           $now = \Carbon\Carbon::now();
                           $diff = $updated_at->diffInDays($now);
                           @endphp {{__('carsForSale.updated')}} {{$diff}} {{__('carsForSale.daysAgo')}}</p>
                     </div>
                     <div class="align-items-center col-8 col-lg-7 col-md-7 col-sm-8 d-flex justify-content-end text-right pl-md-3 pl-0">
                        @if(Auth::guard('customer')->user())
                        @php
                        $saved = \App\UserSavedAds::where('ad_id',$show_result->id)->where('customer_id',@Auth::guard('customer')->user()->id)->first();
                        @endphp
                        @if(@$saved != null)
                        @php $id = 'heart2'; @endphp
                        @else
                        @php $id = 'heart'; @endphp
                        @endif
                        <a href="javascript:void(0)" class="saveAd saveAdBtn mr-3" data-id="{{$show_result->id}}"><em id="{{$id}}{{$show_result->id}}" class="fa fa-heart {{$id}}"></em> <span class="save_heart">{{__('carsForSale.save')}}</span></a>
                        @else
                        <a target="" href="{{url('user/login')}}" class="saveAd saveAdBtn mr-3" data-id="{{@$show_result->id}}"><em id="{{@$id}}{{$show_result->id}}" class="fa fa-heart {{@$id}}"></em> <span class="save_heart">{{__('carsForSale.save')}}</span></a>
                        @endif
                        <a target="" href="{{url('user/login')}}" class="mr-3" data-id="{{@$show_result->id}}"><em class="fa fa-share" style="color: gray"></em> <span class="share_heart">{{__('carsForSale.share')}}</span></a>
                        <a href="javascript:void(0)" title="{{$show_result->poster_phone}}" class="btn contactbtn themebtn3" style="font-size: 12px;font-weight: 200;padding: 5px 5px;"><em class="fa fa-phone"></em> {{__('carsForSale.showPhoneNo')}}</a>
                     </div>


                  </div>
               </div>
            </div>
         </div>
         @endforeach
         @else
         <div class="bg-white mt-4 p-4" style="width: 100%">
            <h2>{{__('carsForSale.noRecordFound')}}</h2>
         </div>
         @endif
      </div>

      <!-- listing view ends here -->
      @if($search_result->hasPages())
      <div class="row mt-3">
         <div class="col-12 carList-pager">
            <nav class="bg-white border p-3" aria-label="Page navigation example">
               {{$search_result->appends(request()->query())->links("pagination::bootstrap-4")}}
            </nav>
         </div>
      </div>
      @endif

      <div class="align-items-center d-sm-flex justify-content-around mt-md-5 mt-4 pt-2 pt-sm-3 postAdRow">
         <div class="sellCarCol d-none d-md-block">
            <img src="{{url('public/assets/img/sell-car.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
         </div>
         <div class="pl-md-3 pr-md-3 sellCartext text-center">
            <img src="{{url('public/assets/img/sell-arrow-left.png')}}" class="d-md-block d-none img-fluid mr-auto  sell-arrow-left" alt="carish used cars for sale in estonia">
            <h4 class="mb-0">{{__('carsForSale.wantToSellYourCarDetailedText')}} <span class="themecolor2">{{__('carsForSale.free')}}</span></h4>
            <p class="mb-0">{{__('carsForSale.sellItFasterToThousands')}}</p>
            <img src="{{url('public/assets/img/sell-arrow-right.png')}}" class="d-sm-block d-none img-fluid ml-auto sell-arrow-right" alt="carish used cars for sale in estonia">
         </div>
         <div class="sellCarBtn">
            <a target="" href="{{ route('sellcar') }}" class="btn themebtn1">{{__('carsForSale.wantToSellYourCarButtonText')}}</a>
         </div>
      </div>
   </div>
   <!-- right content section ends here -->
</div>
</div>
</div>
@endsection
