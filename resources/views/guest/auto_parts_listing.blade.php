@extends('layouts.app')
@section('title') {{ __('findAutoPartPage.sparePartSearch') }} @endsection
@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css" media="screen">
   ul.ui-autocomplete {
   z-index: 1100;
   } 
   .heart{
   color:gray;
   font-size: 20px;
   }
   .heart2{
   color:#007bff;
   font-size: 20px;
   }
   @media (min-width: 1200px)
   {
   .desktop_size
   {
   padding-top: 75%;
   }
   }
   @media (max-width: 1199px)
   {
   .mob_size
   {
   padding-top: 100%;
   }
   }
   @media (min-width: 501px)
   {
   .contact_row
   {
   position: absolute;
   bottom: 0;
   width: 100%
   }
   .gridingCol .contact_row
   {
   position: relative;
   width: auto;
   }
   }
   @media (max-width: 500px)
   {
   .save_heart
   {
   display: none;
   }
   .share_heart
   {
   display: none;
   }
   .fa-share
   {
   font-size: 18px;
   }
   }
   @media (max-width: 767px)
   {
   .featuredlabel {
   font-size: 9px;
   }
   }
   @media (max-width: 414px)
   {
   .featuredlabel {
   font-size: 8px;
   }
   }
</style>
@endpush
@php use App\Models\Customers\Customer;
use App\SparePartAd;
$scat = '';
if(!empty($subCategories))
{
$scat = $subCategories;
}
$activeLanguage = \Session::get('language');
$skips = ["[","]","\""];
if($category){
$p_caty = ($category->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first());
}
@endphp
@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('public/js/search.js')}}" ></script>
<script type="text/javascript" charset="utf-8">
var baseUrl = "{{url('/')}}";
var get_makers = "{{route('get.makers')}}/";
var get_models = "{{route('get.models')}}/";
var get_manufacturer_tyre = "{{route('get.manufacturer_tyre')}}/";
var get_manufacturer_rim = "{{route('get.manufacturer_rim')}}/";
$(document).ready(function () {
    $('input.search_check_submit_autoparts:radio:checked').parent().addClass('active_element');
    var parentcat = "{{@$category->slug}}/";
  /* AUTO COMPLETE FOR MAKES */
    $("#dealers").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "{{route('get.dealers')}}/",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            var selectedValue = ui.item.id;
            $("#dealer").val(selectedValue);
        }
    });
    var subCategoryId = "{{$scat}}";
    $("#title").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "{{route('get.spareparts')}}/",
                dataType: "json",
                data: {
                    term: request.term,
                    subCategoryId: subCategoryId
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            var selectedValue = ui.item.id;
            $("#part_id").val(selectedValue);
        }
    });
    $("#cities").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "{{route('get.city')}}/",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            var selectedValue = ui.item.id;
            $("#city").val(selectedValue);
        }
    });
    $('html, body').animate({
        scrollTop: $("#breadcrumb").offset().top
    }, 500);
    $('.show_more_cities').on('click', function () {
        $('.add-suggestion').toggleClass('suggestion-class');
        var check = $('.add-suggestion').hasClass('suggestion-class');
        if (check == true) {
            // alert(check);
            $('.show_more_cities').text('{{__("ads.show_less")}}');
        } else {
            $('.show_more_cities').text('{{__("ads.show_more")}}');

        }
    });
});
    $(document).on('click','.toggle_number',function(){ 
        var phone = $(this).data("id");
        $('#half_number'+phone).addClass('d-none');
        $('#full_number'+phone).removeClass('d-none');
        $('#toggle_number'+phone).addClass('add_pointer');
   });
    $('a').tooltip({  
    disabled: true,
    close: function( event, ui ) { $(this).tooltip('disable'); }
    });
    $('a').on('click', function () {
        $(this).tooltip('enable').tooltip('open');
    });
</script>
@endpush
<input type="hidden" id="sortBy" name="sortBy" value="{{$sortBy}}">
<input type="hidden" id="parentCat" name="parentCat" value="{{$category->slug}}">

@section('content')
<div class="internal-page-content mt-4 pt-4 sects-bg">
    <div class="container">
        <div class="row">
            <div class="col-12 bannerAd pt-2">
                <img src="{{url('public/assets/img/placeholder.jpg')}}" class="img-fluid" alt="carish used cars for sale in estonia">
            </div>
            <div class="col-12 pageTitle mt-md-5 mt-4" id="breadcrumb">
                <div class="bg-white border p-md-4 p-3">
                    <nav aria-label="breadcrumb" class="breadcrumb-menu">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a target="" href="{{url('/')}}">{{__('findAutoPartPage.home')}}</a></li>
                            <li class="breadcrumb-item"><a target=""
                                    href="{{route('findautoparts')}}">{{__('findAutoPartPage.autoParts')}}</a></li>
                            @if(empty($category->title))
                               <li class="breadcrumb-item active ">{{@$p_caty}}</li>
                            @else 
                               <li class="breadcrumb-item"><a target="" href="{{url('find-autoparts/'.$category->slug)}}">{{@$p_caty}}</a></li>
                            @endif
                            @if(!empty($scat_title))
                               <li class="breadcrumb-item active" aria-current="page">{{@$scat_title}}</li>
                            @endif
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-md-3">
                            <h2 class="font-weight-semibold themecolor">{{@$p_caty}}({{$totalAdsInParents}})</h2>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-bordered" style="width: 102%;">
                                <thead>
                                    <tr style="border: 1px solid #eee;">
                                        <th colspan="">{{__('findAutoPartPage.subCategories')}}<em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em></th>
                                    </tr>
                                </thead>
                                <tbody style="height: 200px; overflow-y: scroll;display: block;" class="scrollbar"
                                    id="ex3">

                                    <tr style="display: table;width: 100%;">
                                        @php $i = 0; @endphp
                                        @if(!$childCategories->isEmpty())
                                        @foreach ($childCategories as $childCats)
                                        @php
                                        $skips = ["[","]","\""];
                                        $pp_caty =
                                        ($childCats->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first());
                                        @endphp
                                        <td class="p-0" style="width: 50%;cursor: pointer;border: none;">
                                            <li style="list-style: none;cursor: pointer;" class="p-2 search_li_hover">
                                                <input @if(!empty($subCategories) && $childCats->id == $subCategories)
                                                checked @endif type="radio" class="search_check_submit_autoparts radio d-none"
                                                value="scat_{{$childCats->id}}" id="makesCheckscat_{{$childCats->id}}"
                                                data-value="{{$childCats->slug}}" name="sub_category">
                                                <label for="makesCheckscat_{{$childCats->id}}" class="m-0" style="width: 95%;cursor: pointer;">{{$pp_caty}}
                                                    @if(!empty($childCategoriesCount[$childCats->id]))
                                                    ({{@$childCategoriesCount[$childCats->id]}}) @else @php echo '(0)'
                                                    @endphp @endif</label>
                                                
                                            </li>
                                        </td>
                                        @php $i++; @endphp
                                        @if($i == 2)
                                    </tr>
                                    <tr style="display: table;width: 100%;">
                                        @php $i = 0 ; @endphp
                                        @endif
                                        @endforeach
                                    </tr>
                                        @else
                                        @foreach ($parentChildCategories as $childCats)
                                        @php
                                        $skips = ["[","]","\""];
                                        $pp_caty =
                                        ($childCats->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first());
                                        @endphp
                                        <td class="p-0" style="width: 50%;cursor: pointer;border: none;">
                                            <li style="list-style: none;cursor: pointer;" class="p-2 search_li_hover">
                                                @if(!empty($subCategories) && $childCats->id == $subCategories)
                                                <input @if(!empty($subCategories) && $childCats->id == $subCategories)
                                                checked @endif type="radio" class="search_check_submit_autoparts radio d-none"
                                                value="scat_{{$childCats->id}}" id="makesCheckscat_{{$childCats->id}}"
                                                data-value="{{$childCats->slug}}" name="sub_category">
                                                <label for="makesCheckscat_{{$childCats->id}}" class="m-0" style="width: 95%;cursor: pointer;display: block;background-color:#D3D3D3;">{{$pp_caty}}
                                                    @if(!empty($childCategoriesCount[$childCats->id]))
                                                    ({{@$childCategoriesCount[$childCats->id]}}) @else @php echo '(0)'
                                                    @endphp @endif</label>
                                                @else
                                                <input type="radio" class="search_check_submit_autoparts radio d-none"
                                                value="scat_{{$childCats->id}}" id="makesCheckscat_{{$childCats->id}}"
                                                data-value="{{$childCats->slug}}" name="sub_category">
                                                <label for="makesCheckscat_{{$childCats->id}}" class="m-0" style="width: 95%;cursor: pointer;">{{$pp_caty}}
                                                    @if(!empty($childCategoriesCount[$childCats->id]))
                                                    ({{@$childCategoriesCount[$childCats->id]}}) @else @php echo '(0)'
                                                    @endphp @endif</label>
                                                @endif
                                                
                                            </li>
                                        </td>
                                        @php $i++; @endphp
                                        @if($i == 2)
                                    </tr>
                                    <tr style="display: table;width: 100%;">
                                        @php $i = 0 ; @endphp
                                        @endif
                                        @endforeach
                                        @endif

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-md-5 mt-4">
            <!-- left Sidebar start here -->
            <aside class="col-lg-3 col-12 mb-4 mb-lg-0 left-sidebar">
                <div class="leftsidebar-bg">
                    <div id="searchResultFilter">
                    <div class="search-by-filter">
                        <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title "
                            data-toggle="collapse" data-target="#searchbyreasult" aria-expanded="false"
                            aria-controls="searchbyreasult">{{__('findAutoPartPage.showResultsBy')}}: <em
                                class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse"
                                data-target="#searchbyreasult" aria-expanded="false"
                                aria-controls="searchbyreasult"></em></h6>

                        <div class="search-filter collapse d-lg-block" id="searchbyreasult">
                            <h6 class=" sidebar-title mb-0  pt-3 pb-3 pl-4 pr-4"><img
                                    src="{{url('public/assets/img/rIcon-search-filter.png')}}" alt="carish used cars for sale in estonia"
                                    class="img-fluid mr-2"> {{__('findAutoPartPage.searchFilter')}} </h6>
                            {!!$searchedKeywords!!}
                        </div>
                    </div>

                    {{-- SEARCH BY Dealer --}}        
                    <div class="card">
                     <div class="card-header pl-4 pr-4" id="heading_make">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_dealer" aria-expanded="false" aria-controls="searchby_dealer">
                           <figure class="text-center mb-0"><img src="{{url('public/assets/img/seller.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.searchByDealer')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_dealer" class="collapse" aria-labelledby="heading_make" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" id="dealers" data-value="dealer_"
                                        value="{{@$queyStringArray['dealer'][0]}}"
                                        class="form-control p-2 pr-2 search_text_submit" placeholder=""
                                        aria-label="Recipient's username" aria-describedby="basic-addon2">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                    {{-- SEARCH BY NAME --}}        
                    <div class="card">
                     <div class="card-header pl-4 pr-4" id="heading_make">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_name" aria-expanded="false" aria-controls="searchby_name">
                           <figure class="text-center mb-0"><i class="fa fa-building"></i></figure>
                           <span>{{__('findAutoPartPage.searchByTitle')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_name" class="collapse" aria-labelledby="heading_make" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" id="title" value="" class="form-control p-2 pr-2"
                                        placeholder="{{__('findAutoPartPage.searchByTitle')}}" aria-label="Recipient's username"
                                        aria-describedby="basic-addon2">
                                    <input type="hidden" id="part_id" data-value="partid_"
                                        value="{{@$queyStringArray['partid'][0]}}"
                                        class="form-control p-2 pr-2 search_text_submit">
                              <input type="hidden" id="=" data-value="=" value="" class="search_text_submit">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                    {{-- SEARCH BY CITY --}}        
                    <div class="card">
                     <div class="card-header pl-4 pr-4" id="heading_make">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_city" aria-expanded="false" aria-controls="searchby_city">
                           <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-location.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.location')}} <small class="d-block"> </small></span>
                        </a>
                     </div>
                     <div id="searchby_city" class="collapse" aria-labelledby="heading_make" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" class="form-control p-2 pr-2" id="cities" placeholder="e.g Pärnu"
                                        autocomplete="off">
                                    <input type="hidden" data-value="city_" id="city" class="search_text_submit">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                           <ul class="list-unstyled carselectlist mb-0" id="search-by-city-list">
                                    @if(isset($sideBarArray['foundInCity']) && !empty($sideBarArray['foundInCity']))
                                    @foreach($sideBarArray['foundInCity'] as $foundInCity)
                                    <li class="d-flex justify-content-between">
                                        <div class="custom-control mr-2 custom-checkbox">
                                            <input type="checkbox" data-value="city_{{$foundInCity->id}}"
                                                class="custom-control-input search_check_submit_autoparts"
                                                id="modalCheck{{$foundInCity->id}}" @if(isset($queyStringArray['city'])
                                                && in_array($foundInCity->id,$queyStringArray['city']))
                                            checked="checked" @endif >
                                            <label class="custom-control-label"
                                                for="modalCheck{{$foundInCity->id}}">{{$foundInCity->name}}</label>
                                        </div>
                                        <div><span
                                                class="badge badge-pill border pb-1 pt-1 bgdarklight">{{$foundInCity->totalAdsInCities}}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                    @endif
                            </ul>
                        </div>
                     </div>
                  </div>

                    {{-- SEARCH BY Product Code --}}        
                    <div class="card">
                     <div class="card-header pl-4 pr-4" id="heading_make">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_product_code" aria-expanded="false" aria-controls="searchby_product_code">
                           <figure class="text-center mb-0"><i class="fa fa-building"></i></figure>
                           <span>{{__('findAutoPartPage.productCode')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_product_code" class="collapse" aria-labelledby="heading_make" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" id="product_code" data-value="productcode_"
                                        value="{{@$queyStringArray['productcode'][0]}}"
                                        class="form-control p-2 pr-2 search_text_submit" placeholder="{{__('findAutoPartPage.productCode')}}"
                                        aria-label="Recipient's username" aria-describedby="basic-addon2">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                    {{-- SEARCH BY Condition --}}        
                    <div class="card">
                     <div class="card-header pl-4 pr-4" id="heading_make">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_condition" aria-expanded="false" aria-controls="searchby_condition">
                            <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-mileage.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.condition')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_condition" class="collapse" aria-labelledby="heading_make" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" class="form-control p-2 pr-2" placeholder="{{__('findAutoPartPage.condition')}}" aria-label="Recipient's username" aria-describedby="basic-addon2" >
                              <input type="hidden" id="" data-value="" value="" class="search_text_submit">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                           <ul class="list-unstyled carselectlist mb-0">

                                    @if(isset($sideBarArray['foundInCondition']) && !empty($sideBarArray['foundInCondition']))
                                    @foreach($sideBarArray['foundInCondition'] as $foundInCondition)
                                    <li class="d-flex justify-content-between">
                                        <div class="custom-control mr-2 custom-checkbox">
                                            <input type="checkbox" data-value="condition_{{$foundInCondition->condition}}"
                                                class="custom-control-input search_check_submit_autoparts"
                                                id="modalCheck{{$foundInCondition->condition}}" 
                                                @if(isset($queyStringArray['condition'])
                                                && in_array($foundInCondition->condition,$queyStringArray['condition']))
                                            checked="checked" @endif >
                                            <label class="custom-control-label"
                                                for="modalCheck{{$foundInCondition->condition}}">{{$foundInCondition->condition}}</label>
                                        </div>
                                        <div><span
                                                class="badge badge-pill border pb-1 pt-1 bgdarklight">{{$foundInCondition->totalAdsInCondition}}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                    @endif 
                           </ul>
                        </div>
                     </div>
                  </div>

                    {{-- PRICE STARTS HERE --}}
                  <div class="card">
                     <div class="card-header pl-4 pr-4" id="heading40">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby40" aria-expanded="false" aria-controls="searchby40">
                           <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-price.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.price')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     @php
                     $maximumPrice = '';
                     $minimumPrice = '';
                     if(Arr::has(@$queyStringArray, 'price'))
                     {
                     $price = explode('-',$queyStringArray['price'][0]);
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
                              <span class="align-items-center border d-block d-flex pricerange px-3 py-1" style="width: 100%;">
                                 @if(@$minPrice !== null)
                                 <div class="pr-range-min" style="">{{@$minPrice}}</div>
                                 @php
                                 $minimumPrice = $minPrice;
                                 @endphp
                                 @else
                                 <div class="select-prng">{{__('findAutoPartPage.price')}} </div>
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
                                    <input type="text" name="minPrice" id="minPrice" placeholder="Min" class="form-control form-control-sm mb-2" value="{{$minimumPrice}}">
                                    <span style="line-height: 2.5;" class="pr-2 pl-2">-</span>
                                    <input type="text" name="maxPrice" id="maxPrice" placeholder="Max" class="form-control form-control-sm mb-2" value="{{$maximumPrice}}">
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
                              <button type="button" class="fa fa-check themebtn3 search_check_submit_autoparts"></button>
                           </div>
                        </div>
                     </div>
                  </div>

                    {{-- PICTURE STARTS HERE --}}
                  <div class="card">
               <div class="card-header pl-4 pr-4" id="heading10">
                  <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby12" aria-expanded="false" aria-controls="searchby12">
                     <figure class="text-center mb-0"><img src="{{url('public/assets/img/pic.jpg')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                     <span>{{__('findAutoPartPage.adPicture')}} <small class="d-block"></small></span>
                  </a>
               </div>
               <div id="searchby12" class="collapse" aria-labelledby="heading12" data-parent="#searchResultFilter">
                  <div class="card-body">
                     <ul class="list-unstyled carselectlist mb-0">
                        <li class="d-flex justify-content-between">
                           <div class="custom-control mr-2 custom-checkbox ">
                              <input type="checkbox" class="custom-control-input search_check_submit_autoparts" id="pictureCheck" value="pic_Ads-With-Pictures" data-value="pic_Ads-With-Pictures" @isset($queyStringArray['pic']) @if(in_array('Ads-With-Pictures',$queyStringArray['pic'])) checked="checked" @endif @endisset>
                              <label class="custom-control-label" for="pictureCheck">{{__('findAutoPartPage.withPicture')}}</label>
                           </div>
                           <div><span class="badge badge-pill border pb-1 pt-1"></span></div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>

                    {{-- SEARCH BY MAKE --}}        
                    <div class="card f1 f2">
                     <div class="card-header pl-4 pr-4" id="heading_make">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_make" aria-expanded="false" aria-controls="searchby_make">
                            <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-mileage.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.make')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_make" class="collapse" aria-labelledby="heading_make" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" class="form-control p-2 pr-2" placeholder="{{__('findAutoPartPage.searchByMake')}}" aria-label="Recipient's username" aria-describedby="basic-addon2" id="car_makes">
                              <input type="hidden" id="car_make" data-value="mk_" value="" class="search_text_submit">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                           <ul class="list-unstyled carselectlist mb-0">
                                 @if(isset($sideBarArray['foundInMake']) && !empty($sideBarArray['foundInMake']))
                                    @foreach($sideBarArray['foundInMake'] as $foundInMake)
                                    <li class="d-flex justify-content-between">
                                        <div class="custom-control mr-2 custom-checkbox">
                                            <input type="checkbox" data-value="mk_{{$foundInMake->id}}"
                                                class="custom-control-input search_check_submit_autoparts"
                                                id="modalCheck{{$foundInMake->id}}" @if(isset($queyStringArray['make'])
                                                && in_array($foundInMake->id,$queyStringArray['make']))
                                            checked="checked" @endif >
                                            <label class="custom-control-label"
                                                for="modalCheck{{$foundInMake->id}}">{{$foundInMake->title}}</label>
                                        </div>
                                        <div><span
                                                class="badge badge-pill border pb-1 pt-1 bgdarklight">{{$foundInMake->total_ads_in_makes}}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                    @endif
                           </ul>
                         
                        </div>
                     </div>
                  </div>

                    {{-- SEARCH BY MODEL --}} 
                    <div class="card f1 f2">
                     <div class="card-header pl-4 pr-4" id="heading_model">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_model" aria-expanded="false" aria-controls="searchby_model">
                          <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-bodystyle.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.model')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_model" class="collapse" aria-labelledby="heading_model" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" class="form-control p-2 pr-2" placeholder="{{__('findAutoPartPage.searchByModel')}}" aria-label="Recipient's username" aria-describedby="basic-addon2" id="car_models">
                              <input type="hidden" id="car_model" data-value="mo_" value="" class="search_text_submit">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                           @if(count($sideBarArray['foundInModel']) > 0)
                           <ul class="list-unstyled carselectlist mb-0">
                              @foreach($sideBarArray['foundInModel'] as $foundInModel)
                              <li class="d-flex justify-content-between">
                                 <div class="custom-control mr-2 custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input search_check_submit_autoparts" value="mo_{{$foundInModel->name}}" id="modelsCheck{{$foundInModel->id}}" data-value="mo_{{$foundInModel->name}}" @if(isset($quey_string_slug['mo']) && in_array($foundInModel->name,$quey_string_slug['mo'])) checked="checked" @endif>
                                    <label class="custom-control-label" for="modelsCheck{{$foundInModel->id}}">{{$foundInModel->name}}</label>
                                 </div>
                                 <div><span class="badge badge-pill border pb-1 pt-1">{{$foundInModel->total_ads_in_models}}</span></div>
                              </li>
                              @endforeach
                           </ul>
                           @endif
                         
                        </div>
                     </div>
                  </div>

                    {{-- SEARCH BY Engine Power --}} 
                    <div class="card f2">
               <div class="card-header pl-4 pr-4" id="heading11">
                  <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby11" aria-expanded="false" aria-controls="searchby11">
                     <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-enginesize.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                     <span>{{__('findAutoPartPage.engineSize')}}<small class="d-block"></small></span>
                  </a>
               </div>
               <div id="searchby11" class="collapse" aria-labelledby="heading11" data-parent="#searchResultFilter">
                  @php
                  if(Arr::has(@$queyStringArray, 'power'))
                  {
                  $power = explode('-',$queyStringArray['power'][0]);
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
                  if(Arr::has(@$queyStringArray, 'enginecc'))
                  {
                  $enginecc = explode('-',$queyStringArray['enginecc'][0]);
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
                        <span class="mr-2" style="font-size: 14px;color: #aaa;">{{__('findAutoPartPage.liter')}}</span>
                        <input type="text" name="engineccFrom" id="engineccFrom" placeholder="{{__('findAutoPartPage.from')}}" class="form-control p-1" value="{{@$engineccFrom}}" style="border-radius: 0px;">
                        <input type="text" name="engineccTo" id="engineccTo" placeholder="{{__('findAutoPartPage.to')}}" class="form-control p-1 ml-2 mr-2" value="{{@$engineccTo}}" style="border-radius: 0px;">
                        <button type="button" class="fa fa-search themebtn3 search_check_submit_autoparts" style="font-size: 14px;background-color: white;color: #aaa;border: none;"></button>
                     </div>

                     <div class="form-group d-flex mb-0" style="align-items: center;text-align: center;">
                        <span style="width: 100%;font-size: 14px;color: #aaa;" class="mt-3 mb-3">{{__('findAutoPartPage.or')}}</span>
                     </div>


                     <div class="form-group d-flex mb-0" style="align-items: center;">
                        <span class="mr-2" style="font-size: 14px;color: #aaa;">{{__('findAutoPartPage.kw')}}</span>
                        <input type="text" name="powerFrom" id="powerFrom" placeholder="{{__('findAutoPartPage.from')}}" class="form-control p-1" value="{{@$powerFrom}}" style="border-radius: 0px;">
                        <input type="text" name="powerTo" id="powerTo" placeholder="{{__('findAutoPartPage.to')}}" class="form-control p-1 ml-2 mr-2" value="{{@$powerTo}}" style="border-radius: 0px;">
                        <button type="button" class="fa fa-search themebtn3 search_check_submit_autoparts" style="font-size: 14px;background-color: white;color: #aaa;border: none;"></button>
                     </div>
                     
                     
                  </div>
               </div>
            </div>

                    {{-- SEARCH BY Manufacturer Tyre --}}        
                    <div class="card f3">
                     <div class="card-header pl-4 pr-4" id="heading_manufacturer_tyre">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_manufacturer_tyre" aria-expanded="false" aria-controls="searchby_manufacturer_tyre">
                            <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-gearbox.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.manufacturerTyre')}}<small class="d-block"></small></span>
                        </a>
                     </div>
                     
                     <div id="searchby_manufacturer_tyre" class="collapse" aria-labelledby="heading_manufacturer_tyre" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" class="form-control p-2 pr-2" placeholder="{{__('findAutoPartPage.manufacturerTyre')}}" aria-label="Recipient's username" aria-describedby="basic-addon2" id="tyre_manufactures">
                              <input type="hidden" id="tyre_manufacture" data-value="mt_" value="" class="search_text_submit">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                           @if(count($sideBarArray['foundInMTyers']) > 0)
                           <ul class="list-unstyled carselectlist mb-0">
                              @foreach($sideBarArray['foundInMTyers'] as $foundInMTyers)
                              <li class="d-flex justify-content-between">
                                 <div class="custom-control mr-2 custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input search_check_submit_autoparts" value="mo_{{$foundInMTyers->title}}" id="tyreCheck{{$foundInMTyers->id}}" data-value="mt_{{$foundInMTyers->title}}" @if(isset($quey_string_slug['mt']) && in_array($foundInMTyers->title,$quey_string_slug['mt'])) checked="checked" @endif>
                                    <label class="custom-control-label" for="tyreCheck{{$foundInMTyers->id}}">{{$foundInMTyers->title}}</label>
                                 </div>
                                 <div><span class="badge badge-pill border pb-1 pt-1">{{$foundInMTyers->total_ads_in_mtyers}}</span></div>
                              </li>
                              @endforeach
                           </ul>
                           @endif
                         
                        </div>
                     </div>
                  </div>

                    {{-- SEARCH BY Size --}}        
                    <div class="card f3">
                     <div class="card-header pl-4 pr-4" id="heading_size">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_size" aria-expanded="false" aria-controls="searchby_size">
                            <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-search-filter.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.size')}}<small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_size" class="collapse" aria-labelledby="heading_size" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" id="size" data-value="size_" value="{{@$queyStringArray['size'][0]}}"
                              class="form-control p-2 pr-2 search_text_submit" placeholder="175/65/R14" aria-label="Recipient's username" aria-describedby="basic-addon2" >
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>

                         
                        </div>
                     </div>
                  </div>

                    {{-- SEARCH BY Type --}}        
                    <div class="card f3">
                     <div class="card-header pl-4 pr-4" id="heading_type">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_type" aria-expanded="false" aria-controls="searchby_type">
                            <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-mileage.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.type')}}<small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_type" class="collapse" aria-labelledby="heading_type" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" class="form-control p-2 pr-2" placeholder="{{__('findAutoPartPage.type')}}" aria-label="Recipient's username" aria-describedby="basic-addon2" id="t_types">
                              <input type="hidden" id="t_type" data-value="tt_" value="" class="search_text_submit">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  {{-- SEARCH BY Quantity --}}        
                    <div class="card f3">
                     <div class="card-header pl-4 pr-4" id="heading_quantity">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_quantity" aria-expanded="false" aria-controls="searchby_quantity">
                            <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-price.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.quantity')}}<small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_quantity" class="collapse" aria-labelledby="heading_quantity" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" class="form-control p-2 pr-2" placeholder="{{__('findAutoPartPage.quantity')}}" aria-label="Recipient's username" aria-describedby="basic-addon2" id="f3_quantities">
                              <input type="hidden" id="f3_quantity" data-value="tq_" value="{{@$queyStringArray['tq'][0]}}" class="search_text_submit">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  {{-- SEARCH BY Manufacturer Rim --}}        
                    <div class="card f4">
                     <div class="card-header pl-4 pr-4" id="heading_manufacturer_rim">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_manufacturer_rim" aria-expanded="false" aria-controls="searchby_manufacturer_rim">
                            <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-gearbox.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.manufacturerRim')}}<small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_manufacturer_rim" class="collapse" aria-labelledby="heading_manufacturer_rim" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" class="form-control p-2 pr-2" placeholder="{{__('findAutoPartPage.manufacturerRim')}}" aria-label="Recipient's username" aria-describedby="basic-addon2" id="rim_manufactures">
                              <input type="hidden" id="rim_manufacture" data-value="mr_" value="" class="search_text_submit">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                           @if(count($sideBarArray['foundInMRims']) > 0)
                           <ul class="list-unstyled carselectlist mb-0">
                              @foreach($sideBarArray['foundInMRims'] as $foundInMRims)
                              <li class="d-flex justify-content-between">
                                 <div class="custom-control mr-2 custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input search_check_submit_autoparts" value="mr_{{$foundInMRims->title}}" id="rimCheck{{$foundInMRims->id}}" data-value="mr_{{$foundInMRims->title}}" @if(isset($quey_string_slug['mr']) && in_array($foundInMRims->title,$quey_string_slug['mr'])) checked="checked" @endif>
                                    <label class="custom-control-label" for="rimCheck{{$foundInMRims->id}}">{{$foundInMRims->title}}</label>
                                 </div>
                                 <div><span class="badge badge-pill border pb-1 pt-1">{{$foundInMRims->total_ads_in_mrims}}</span></div>
                              </li>
                              @endforeach
                           </ul>
                           @endif

                         
                        </div>
                     </div>
                  </div>

                  {{-- SEARCH BY Size Inch --}}        
                    <div class="card f4">
                     <div class="card-header pl-4 pr-4" id="heading_size_inch">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_size_inch" aria-expanded="false" aria-controls="searchby_size_inch">
                            <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-search-filter.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.sizeInch')}}<small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_size_inch" class="collapse" aria-labelledby="heading_size_inch" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text"  id="size_inch" data-value="sizeinch_" value="{{@$queyStringArray['sizeinch'][0]}}"  class="form-control p-2 pr-2 search_text_submit" placeholder="14*6.5" aria-label="Recipient's username" aria-describedby="basic-addon2">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>

                         
                        </div>
                     </div>
                  </div>

                  {{-- SEARCH BY Offset (mm) --}}        
                    <div class="card f4">
                     <div class="card-header pl-4 pr-4" id="heading_offset_mm">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_offset_mm" aria-expanded="false" aria-controls="searchby_offset_mm">
                            <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-color.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.offsetMm')}}<small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_offset_mm" class="collapse" aria-labelledby="heading_offset_mm" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" id="offset_mm" data-value="offset_" value="{{@$queyStringArray['offset'][0]}}"   class="form-control p-2 pr-2 search_text_submit" placeholder="39" aria-label="Recipient's username" aria-describedby="basic-addon2">
                           
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>

                         
                        </div>
                     </div>
                  </div>

                  {{-- SEARCH BY Style --}}        
                    <div class="card f4">
                     <div class="card-header pl-4 pr-4" id="heading_style">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_style" aria-expanded="false" aria-controls="searchby_style">
                            <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-bodystyle.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.style')}} <small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_style" class="collapse" aria-labelledby="heading_style" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" class="form-control p-2 pr-2" placeholder="{{__('findAutoPartPage.style')}}" aria-label="Recipient's username" aria-describedby="basic-addon2" id="rim_style">
                              <input type="hidden" id="r_style" data-value="style_" value="" class="search_text_submit">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                            @if(count($sideBarArray['foundInStyle']) > 0)
                           <ul class="list-unstyled carselectlist mb-0">
                              @foreach($sideBarArray['foundInStyle'] as $foundInStyle)
                              <li class="d-flex justify-content-between">
                                 <div class="custom-control mr-2 custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input search_check_submit_autoparts" value="style_{{$foundInStyle->f4_style}}" id="styleCheck{{$foundInStyle->f4_style}}" data-value="style_{{$foundInStyle->f4_style}}" @if(isset($quey_string_slug['style']) && in_array($foundInStyle->title,$quey_string_slug['style'])) checked="checked" @endif>
                                    <label class="custom-control-label" for="styleCheck{{$foundInStyle->f4_style}}">{{ucfirst($foundInStyle->f4_style)}}</label>
                                 </div>
                                 <div><span class="badge badge-pill border pb-1 pt-1">{{$foundInStyle->totalAdsInStyle}}</span></div>
                              </li>
                              @endforeach
                           </ul>
                           @endif
                        </div>
                     </div>
                  </div>

                  {{-- SEARCH BY Num Of Holes --}}        
                    <div class="card f4">
                     <div class="card-header pl-4 pr-4" id="heading_num_of_holes">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_num_of_holes" aria-expanded="false" aria-controls="searchby_num_of_holes">
                            <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-mileage.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.numOfHoles')}}<small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_num_of_holes" class="collapse" aria-labelledby="heading_num_of_holes" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" id="holes" data-value="holes_" value="{{@$queyStringArray['holes'][0]}}" class="form-control p-2 pr-2 search_text_submit" placeholder="4" aria-label="Recipient's username" aria-describedby="basic-addon2">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  {{-- SEARCH BY Num Of Distance Between Holes --}}        
                    <div class="card f4">
                     <div class="card-header pl-4 pr-4" id="heading_distance_between_holes">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_distance_between_holes" aria-expanded="false" aria-controls="searchby_distance_between_holes">
                            <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-fuel.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.distanceBetweenHoles')}}<small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_distance_between_holes" class="collapse" aria-labelledby="heading_distance_between_holes" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" id="dholes"  data-value="dholes_" value="{{@$queyStringArray['dholes'][0]}}"  class="form-control p-2 pr-2 search_text_submit" placeholder="100" aria-label="Recipient's username" aria-describedby="basic-addon2" id="f4_distance_between_holes">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>

                         
                        </div>
                     </div>
                  </div>

                   {{-- SEARCH BY Quantity --}}        
                    <div class="card f4">
                     <div class="card-header pl-4 pr-4" id="heading_f4_quantity">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby_f4_quantity" aria-expanded="false" aria-controls="searchby_f4_quantity">
                            <figure class="text-center mb-0"><img src="{{url('public/assets/img/rIcon-price.png')}}" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                           <span>{{__('findAutoPartPage.quantity')}}<small class="d-block"></small></span>
                        </a>
                     </div>
                     <div id="searchby_f4_quantity" class="collapse" aria-labelledby="heading_f4_quantity" data-parent="#searchResultFilter">
                        <div class="card-body">
                           <div class="input-group sidebar-input-group mb-3">
                              <input type="text" class="form-control p-2 pr-2" placeholder="{{__('findAutoPartPage.quantity')}}" aria-label="Recipient's username" aria-describedby="basic-addon2" id="f4_quantities">
                              <input type="hidden" id="f4_quantity" data-value="rq_" value="{{@$queyStringArray['rq'][0]}}" class="search_text_submit">
                              <div class="input-group-append">
                                 <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts" type="button"></button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

            </div>


        </div>
        <div class="sidebar-banner mt-4 pt-1 d-lg-block d-none">
            <img src="{{url('public/assets/img/sidebar-banner.jpg')}}" alt="carish used cars for sale in estonia"
                class="img-fluid d-block ml-auto mr-auto">
        </div>
        </aside>
        <!-- left Sidebar ends here -->
        <!-- right content section starts here -->
        <div class="col-lg-9 col-12 right-content used-car-dealer">
            <div class="sortingsection bg-white border">
                <div class="align-items-center ml-0 mr-0 pb-3 pt-3 row">
                    <div class="col-md-6 col-md-6 col-sm-6 mb-sm-0 mb-3 sorting-col">
                        <div class="align-items-center d-flex">
                            <label class="mb-0 mr-3 text-nowrap">{{__('findAutoPartPage.sortBy')}}:</label>
                            <select name="sorting" id="sorting_autoparts" class="form-control form-control-sm">
                                <option value="updated_at desc" @if(isset($sortBy) && $sortBy=='updated_at desc' ) selected="selected" @endif>{{__('findAutoPartPage.updatedDateRecentFirst')}}</option>
                                <option value="updated_at asc" @if(isset($sortBy) && $sortBy=='updated_at asc' ) selected="selected" @endif>{{__('findAutoPartPage.updatedDateOldestFirst')}}</option>
                                <option value="price asc" @if(isset($sortBy) && $sortBy=='price asc' ) selected="selected" @endif>{{__('findAutoPartPage.priceLowToHigh')}}</option>
                                <option value="price desc" @if(isset($sortBy) && $sortBy=='price desc' ) selected="selected" @endif>{{__('findAutoPartPage.priceHighToLow')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 d-flex list-grid-col">
                        <!-- <ul class="ml-auto mb-0">
                            <li class="list-inline-item">
                                <a class="active listIcon" data-toggle="tab" href="javscriptvoid:(0)">
                                    <em class="fa fa-list"></em> {{__('findAutoPartPage.list')}}
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javscriptvoid:(0)" class="gridIcon">
                                    <em class="fa fa-table"></em> {{__('findAutoPartPage.grid')}}
                                </a>
                            </li>
                        </ul> -->
                    </div>
                </div>
            </div>
            <!-- listing view starts here -->
            <div class="ml-0 mr-0 row used-car-dealer-row">
                @if(@$customer_ids != null && !$allAds->isEmpty())
                @foreach($allAds as $ad)
          <div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
                  <div class="row">
                     <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar">
                        <figure class="mb-0 position-relative">
                            @if(!empty($ad->get_one_image->img)  && file_exists('public/uploads/ad_pictures/spare-parts-ad/'.@$ad->id.'/'.@$ad->get_one_image->img))
                          <a href="javascript:void(0)" style="display: block;background-image: url('{{url('public/uploads/ad_pictures/spare-parts-ad/'.@$ad->id.'/'.@$ad->get_one_image->img)}}');
                              background-size: cover;
                              background-position: center;" class="desktop_size mob_size">
                               </a>
                           @else
                           <a href="javascript:void(0)" style="display: block;background-image: url('{{url('public/assets/img/sparepartavatar.jpg')}}');
                              background-size: cover;
                              background-position: center;" class="desktop_size mob_size">
                           </a> 
                           @endif
                           <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between"> 
                            @if(!$ad->is_featured == 'true')
                              <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-white d-inline-block mt-2">{{__('findAutoPartPage.featured')}}
                              </span>
                              @endif
                              <span class="d-inline-block pb-1 pl-2 pr-2 pt-1 viewgallery"><em class="fa fa-camera  mr-1"></em>{{$ad->spare_parts_images()->count()}}</span>
                           </figcaption>
                           </a>
                        </figure>
                     </div>
                     <div class="col-lg-9 col-md-9 col-sm-9 col-8 listingCar-descCar">
                        <div class="align-items-center d-flex justify-content-between listingCar-title mb-1">
                           <h5 class="font-weight-normal mb-0"><a href="{{url('spare-parts-details/'.@$ad->id)}}" target="">{{@$ad->spare_part_title}}</a></h5>
                           <span class="lcPrice d-inline-block ml-3 font-weight-semibold">€{{$ad->price}}</span>
                        </div>
                        <div class="align-items-center d-flex justify-content-between listingCar-place mb-3">
                           <p class="carplace mb-0">@php $cityName =
                                    $ad->city()->where('id',$ad->city_id)->first(); @endphp {{$cityName->name}}</p>
                           <p class="themecolor2 font-weight-semibold mb-0 negotiable">
                              @if($ad->neg)
                              {{__('findAutoPartPage.negotiable')}}
                              @endif
                           </p>
                        </div>
                        <div class="align-items-center d-flex justify-content-between aboutcarlist mb-3">
                           <ul class="list-unstyled mb-0" style="opacity: 0.5">
                              <li class="list-inline-item">{{@$p_caty}}</li>
                              <span>&#124;</span>  <li class="list-inline-item"> 
                                    @php $caty =
                                    ($ad->category->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title'));@endphp
                                    {{@$caty[0]}}</li>
                           </ul>
                           <span></span>
                        </div>
                        <div class="align-items-center d-none justify-content-between gridListprice mb-3">
                           <span class="lcPrice d-inline-block mr-3 font-weight-semibold"> €{{$ad->price}}</span>
                           @if($ad->neg)
                           <p class="themecolor2 font-weight-semibold mb-0 negotiable">
                              {{__('findAutoPartPage.negotiable')}}
                           </p>
                           @endif
                        </div>
                        <div class="align-items-center row contactRow contact_row" style="">
                           <div class="col-lg-5 col-md-5 col-sm-4 col-4 lc-published">
                              <p class="mb-0"> @php 
                                    $updated_at = \Carbon\Carbon::parse($ad->updated_at);
                                    $now  = \Carbon\Carbon::now();
                                    $diff = $updated_at->diffInDays($now); 
                                    @endphp 
                                    {{__('findAutoPartPage.updated')}} {{$diff}} {{__('findAutoPartPage.daysAgo')}}</p>
                           </div>
                           <div class="align-items-center col-8 col-lg-7 col-md-7 col-sm-8 d-flex justify-content-end text-right pl-md-3 pl-0">
                            
                                    @if(Auth::guard('customer')->user())
                                    @php
                                    $checkSaved = Cookie::get('sparepartad'.$ad->id);
                                    $saved =
                                    \App\UserSavedSpareParts::where('spare_part_ad_id',$ad->id)->where('customer_id',@Auth::guard('customer')->user()->id)->first();
                                    @endphp
                                    @if(@$saved != null)
                                    @php $id = 'heart2'; @endphp
                                    @else
                                    @php $id = 'heart'; @endphp
                                    @endif
                              <a href="javascript:void(0)" class="saveAd saveAdBtn mr-3" data-id="{{$ad->id}}"><em id="{{@$id}}" class="fa fa-heart"></em>{{ __('findAutoPartPage.save') }}</span></a>
                                    @else
                                    @if(@$checkSaved != null)
                                    @php $id = 'heart4'; @endphp
                                    @else
                                    @php $id = 'heart3'; @endphp
                                    @endif

                              <a target="" href="{{url('user/login')}}" class="saveAd saveAdBtn mr-3" data-id="{{$ad->id}}"><em id="{{@$id}}{{$ad->id}}" class="fa fa-heart {{@$id}}"></em> <span class="save_heart">{{__('findAutoPartPage.save')}}</span></a>
                              @endif
                              <a target="" href="{{url('user/login')}}" class="mr-3" data-id="{{@$ad->id}}"><em class="fa fa-share" style="color: gray"></em> <span class="share_heart">{{__('findAutoPartPage.share')}}</span></a>
                              <a href="javascript:void(0)" title="{{@$ad->poster_phone}}" class="btn contactbtn themebtn3" style="font-size: 12px;font-weight: 200;padding: 5px 5px;"><em class="fa fa-phone"></em> {{__('findAutoPartPage.showPhoneNo')}}</a>
                           </div>

                           
                        </div>
                     </div>
                  </div>
            </div> 
                @endforeach
                @else
                <div class="bg-white border col-12 dealer-listing-Col mb-3 p-2 pr-3">
                    <div class="col-lg-8 col-md-8 col-sm-4 col-4 pr-2 pl-md-3 car-dealer-img">
                        <h4 class="mb-0">{{__('findAutoPartPage.noRecordFound')}}</h4>
                    </div>
                </div>
                @endif
            </div>
            <!-- listing view ends here -->
            @if($allAds->hasPages())
            <div class="row mt-3">
                <div class="col-12 carList-pager">
                    <nav class="bg-white border p-3" aria-label="Page navigation example">
                        {{ $allAds->appends(request()->query())->links("pagination::bootstrap-4") }}
                    </nav>
                </div>
            </div>
            @endif 
        </div>
        <!-- right content section ends here -->
    </div>
</div>
</div>
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      function selectCategory(filter) {
      $('.f2').hide();
      $('.f3').hide();
      $('.f4').hide();
      $('.f1').hide();
      $('.brand').hide();
      $('.num_of_channel').hide();
      $('.size').hide();
      $('.screen_size').hide();
      $('.size_inch').hide();


      var sub_category_filter = filter;
      var result = sub_category_filter.split('_');

      if(result[0] == 'f1')
      {
        $('.f2').hide();
        $('.f3').hide();
        $('.f4').hide();
        $('.f1').show();
      }
      if(result[0] == 'f2')
      {
        $('.f1').hide();
        $('.f3').hide();
        $('.f4').hide();
        $('.f2').show();
      }
      if(result[0] == 'f3')
      {
        $('.f1').hide();
        $('.f2').hide();
        $('.f4').hide();
        $('.f3').show();
      }
      if(result[0] == 'f4')
      {
        $('.f1').hide();
        $('.f2').hide();
        $('.f3').hide();
        $('.f4').show();
      }

      if(result[1] == 'Brand')
      {
        $('.brand').show();
      }
      if(result[1] == 'Size')
      {
        $('.size').show();
      }
      if(result[1] == 'SizeInch')
      {
        $('.size_inch').show();
      }
      if(result[1] == 'f4')
      {
        $('.f4').show();
      }
      

      if(result[2] == 'NumOfChannel')
      {
        $('.num_of_channel').show();
      }
      if(result[2] == 'Size')
      {
        $('.size').show();
      }
      if(result[2] == 'ScreenSize')
      {
        $('.screen_size').show();
      }
    }
        selectCategory("{{$filter}}");
    });
    </script>
@endpush
@endsection