@extends('layouts.app')
@section('title') {{ __('header.spare_part_search') }} @endsection
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
                            <li class="breadcrumb-item"><a target="" href="{{url('/')}}">{{__('common.home')}}</a></li>
                            <li class="breadcrumb-item"><a target=""
                                    href="{{route('findautoparts')}}">{{__('common.auto_parts')}}</a></li>
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
                                        <th colspan="">{{__('common.sub_categories')}}<em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em></th>
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
                    <div class="search-by-filter">
                        <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title "
                            data-toggle="collapse" data-target="#searchbyreasult" aria-expanded="false"
                            aria-controls="searchbyreasult">{{__('search.show_results_by')}}: <em
                                class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse"
                                data-target="#searchbyreasult" aria-expanded="false"
                                aria-controls="searchbyreasult"></em></h6>

                        <div class="search-filter collapse d-lg-block" id="searchbyreasult">
                            <h6 class=" sidebar-title mb-0  pt-3 pb-3 pl-4 pr-4"><img
                                    src="{{url('public/assets/img/rIcon-search-filter.png')}}" alt="carish used cars for sale in estonia"
                                    class="img-fluid mr-2"> {{__('search.search_filter')}} </h6>
                            {!!$searchedKeywords!!}
                        </div>
                    </div>
                    {{-- SEARCH BY DEALER --}}
                    <div class="search-by-name">
                        <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title "
                            data-toggle="collapse" data-target="#searchbydealer" aria-expanded="false"
                            aria-controls="searchbyname">{{__('search.search_by_dealer')}} <em
                                class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse"
                                data-target="#searchbydealer" aria-expanded="false" aria-controls="searchbyname"></em>
                        </h6>
                        <div class="search-by-name-bg bg-white collapse d-lg-block" id="searchbydealer">
                            <div class="p-4">
                                <div class="input-group sidebar-input-group">
                                    <input type="text" id="dealers" data-value="dealer_"
                                        value="{{@$queyStringArray['dealer'][0]}}"
                                        class="form-control p-2 pr-2 search_text_submit" placeholder=""
                                        aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button
                                            class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts"
                                            type="button"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEARCH BY NAME --}}
                    <div class="search-by-name">
                        <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title "
                            data-toggle="collapse" data-target="#searchbytitle" aria-expanded="false"
                            aria-controls="searchbyname">{{__('search.search_by_title')}} <em
                                class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse"
                                data-target="#searchbytitle" aria-expanded="false" aria-controls="searchbyname"></em>
                        </h6>
                        <div class="search-by-name-bg bg-white collapse d-lg-block" id="searchbytitle">
                            <div class="p-4">
                                <div class="input-group sidebar-input-group">
                                    <input type="text" id="title" value="" class="form-control p-2 pr-2"
                                        placeholder="{{__('search.search_by_title')}}" aria-label="Recipient's username"
                                        aria-describedby="basic-addon2">
                                    <input type="hidden" id="part_id" data-value="partid_"
                                        value="{{@$queyStringArray['partid'][0]}}"
                                        class="form-control p-2 pr-2 search_text_submit">
                                    <div class="input-group-append">
                                        <button
                                            class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts"
                                            type="button"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEARCH BY CITY --}}
                    <div class="search-by-city">
                        <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title "
                            data-toggle="collapse" data-target="#searchbycity" aria-expanded="false"
                            aria-controls="searchbycity">{{__('common.search_by_city')}} <em
                                class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse"
                                data-target="#searchbycity" aria-expanded="false" aria-controls="searchbycity"></em>
                        </h6>
                        <div class="collapse d-lg-block bg-white" id="searchbycity">
                            <div class="p-4">
                                <div class="input-group sidebar-input-group">
                                    <input type="text" class="form-control p-2 pr-2" id="cities" placeholder="e.g Pärnu"
                                        autocomplete="off">
                                    <input type="hidden" data-value="city_" id="city" class="search_text_submit">
                                    <div class="input-group-append">
                                        <button
                                            class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts"
                                            type="button"></button>
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

                    {{-- SEARCH BY Prodcut Code --}}
                    <div class="search-by-prod-code">
                        <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title "
                            data-toggle="collapse" data-target="#searchbyliter" aria-expanded="false"
                            aria-controls="searchbyname">{{__('common.liter')}} <em
                                class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse"
                                data-target="#searchbyliter" aria-expanded="false" aria-controls="searchbyname"></em>
                        </h6>
                        <div class="search-by-liter-bg bg-white collapse d-lg-block" id="searchbyliter">
                            <div class="p-4">
                                <div class="input-group sidebar-input-group">
                                    <input type="text" id="dealers" data-value="dealer_"
                                        value="{{@$queyStringArray['liter'][0]}}"
                                        class="form-control p-2 pr-2 search_text_submit" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button
                                            class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts"
                                            type="button"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEARCH BY Condition --}}
                    <div class="search-by-condition">
                        <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title "
                            data-toggle="collapse" data-target="#searchbyliter" aria-expanded="false"
                            aria-controls="searchbyname">{{__('common.liter')}} <em
                                class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse"
                                data-target="#searchbyliter" aria-expanded="false" aria-controls="searchbyname"></em>
                        </h6>
                        <div class="search-by-liter-bg bg-white collapse d-lg-block" id="searchbyliter">
                            <div class="p-4">
                                <div class="input-group sidebar-input-group">
                                    <input type="text" id="dealers" data-value="dealer_"
                                        value="{{@$queyStringArray['liter'][0]}}"
                                        class="form-control p-2 pr-2 search_text_submit" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button
                                            class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts"
                                            type="button"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEARCH BY Condition --}}
                    <div class="search-by-condition">
                        <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title "
                            data-toggle="collapse" data-target="#searchbyliter" aria-expanded="false"
                            aria-controls="searchbyname">{{__('common.liter')}} <em
                                class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse"
                                data-target="#searchbyliter" aria-expanded="false" aria-controls="searchbyname"></em>
                        </h6>
                        <div class="search-by-liter-bg bg-white collapse d-lg-block" id="searchbyliter">
                            <div class="p-4">
                                <div class="input-group sidebar-input-group">
                                    <input type="text" id="dealers" data-value="dealer_"
                                        value="{{@$queyStringArray['liter'][0]}}"
                                        class="form-control p-2 pr-2 search_text_submit" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button
                                            class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts"
                                            type="button"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEARCH BY MAKE --}}
                    <div class="search-by-make">
                            <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title "
                                data-toggle="collapse" data-target="#searchbymake" aria-expanded="false"
                                aria-controls="searchbymake">{{__('common.make')}} <em
                                    class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse"
                                    data-target="#searchbymake" aria-expanded="false" aria-controls="searchbymake"></em>
                            </h6>
                            <div class="collapse d-lg-block bg-white" id="searchbymake">
                                <div class="p-4">
                                    <div class="input-group sidebar-input-group">
                                        <input type="text" class="form-control p-2 pr-2" id="makes" 
                                            autocomplete="off">
                                        <input type="hidden" data-value="city_" id="city" class="search_text_submit">
                                        <div class="input-group-append">
                                            <button
                                                class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts"
                                                type="button"></button>
                                        </div>
                                    </div>
                                    <ul class="list-unstyled carselectlist mb-0" id="search-by-make-list">
                                        @if(isset($sideBarArray['foundInMake']) && !empty($sideBarArray['foundInMake']))
                                        @foreach($sideBarArray['foundInMake'] as $foundInMake)
                                        <li class="d-flex justify-content-between">
                                            <div class="custom-control mr-2 custom-checkbox">
                                                <input type="checkbox" data-value="city_{{$foundInMake->id}}"
                                                    class="custom-control-input search_check_submit_autoparts"
                                                    id="modalCheck{{$foundInMake->id}}" @if(isset($queyStringArray['make'])
                                                    && in_array($foundInMake->id,$queyStringArray['make']))
                                                checked="checked" @endif >
                                                <label class="custom-control-label"
                                                    for="modalCheck{{$foundInMake->id}}">{{$foundInMake->title}}</label>
                                            </div>
                                            <div><span
                                                    class="badge badge-pill border pb-1 pt-1 bgdarklight">{{@$foundInMake->totalAdsInMakes}}</span>
                                            </div>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                            </div>
                        </div>
                    </div>

                    {{-- SEARCH BY MODEL --}}
                    <div class="search-by-model">
                            <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title "
                                data-toggle="collapse" data-target="#searchbymodel" aria-expanded="false"
                                aria-controls="searchbymodel">{{__('common.model')}} <em
                                    class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse"
                                    data-target="#searchbymodel" aria-expanded="false" aria-controls="searchbymodel"></em>
                            </h6>
                            <div class="collapse d-lg-block bg-white" id="searchbymodel">
                                <div class="p-4">
                                    <div class="input-group sidebar-input-group">
                                        <input type="text" class="form-control p-2 pr-2" id="models" 
                                            autocomplete="off">
                                        <input type="hidden" data-value="model_" id="model" class="search_text_submit">
                                        <div class="input-group-append">
                                            <button
                                                class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts"
                                                type="button"></button>
                                        </div>
                                    </div>
                                    <ul class="list-unstyled carselectlist mb-0" id="search-by-model-list">
                                        @if(isset($sideBarArray['foundInModels']) && !empty($sideBarArray['foundInModels']))
                                        @foreach($sideBarArray['foundInModels'] as $foundInModels)
                                        <li class="d-flex justify-content-between">
                                            <div class="custom-control mr-2 custom-checkbox">
                                                <input type="checkbox" data-value="city_{{$foundInModels->id}}"
                                                    class="custom-control-input search_check_submit_autoparts"
                                                    id="modalCheck{{$foundInModels->id}}" @if(isset($queyStringArray['model'])
                                                    && in_array($foundInModels->id,$queyStringArray['model']))
                                                checked="checked" @endif >
                                                <label class="custom-control-label"
                                                    for="modalCheck{{$foundInModels->id}}">{{$foundInModels->title}}</label>
                                            </div>
                                            <div><span
                                                    class="badge badge-pill border pb-1 pt-1 bgdarklight">{{@$foundInModels->totalAdsInModles}}</span>
                                            </div>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                            </div>
                        </div>
                    </div>

                    {{-- SEARCH BY Liter --}}
                    <div class="search-by-liter">
                        <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title "
                            data-toggle="collapse" data-target="#searchbyliter" aria-expanded="false"
                            aria-controls="searchbyname">{{__('common.liter')}} <em
                                class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse"
                                data-target="#searchbyliter" aria-expanded="false" aria-controls="searchbyname"></em>
                        </h6>
                        <div class="search-by-liter-bg bg-white collapse d-lg-block" id="searchbyliter">
                            <div class="p-4">
                                <div class="input-group sidebar-input-group">
                                    <input type="text" id="dealers" data-value="dealer_"
                                        value="{{@$queyStringArray['liter'][0]}}"
                                        class="form-control p-2 pr-2 search_text_submit" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button
                                            class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts"
                                            type="button"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEARCH BY KW --}}
                    <div class="search-by-kw">
                        <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title "
                            data-toggle="collapse" data-target="#searchbykw" aria-expanded="false"
                            aria-controls="searchbyname">{{__('common.kw')}} <em
                                class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse"
                                data-target="#searchbykw" aria-expanded="false" aria-controls="searchbyname"></em>
                        </h6>
                        <div class="search-by-kw-bg bg-white collapse d-lg-block" id="searchbykw">
                            <div class="p-4">
                                <div class="input-group sidebar-input-group">
                                    <input type="text" id="dealers" data-value="dealer_"
                                        value="{{@$queyStringArray['kw'][0]}}"
                                        class="form-control p-2 pr-2 search_text_submit" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button
                                            class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit_autoparts"
                                            type="button"></button>
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
                            <label class="mb-0 mr-3 text-nowrap">{{__('search.sort_by')}}:</label>
                            <select name="sorting" id="sorting_autoparts" class="form-control form-control-sm">
                                <option value="updated_at desc" @if(isset($sortBy) && $sortBy=='updated_at desc' ) selected="selected" @endif>{{__('search.updated_date_recent_first')}}</option>
                                <option value="updated_at asc" @if(isset($sortBy) && $sortBy=='updated_at asc' ) selected="selected" @endif>{{__('search.updated_date_oldest_first')}}</option>
                                <option value="price asc" @if(isset($sortBy) && $sortBy=='price asc' ) selected="selected" @endif>{{__('search.price_low_to_high')}}</option>
                                <option value="price desc" @if(isset($sortBy) && $sortBy=='price desc' ) selected="selected" @endif>{{__('search.price_high_to_low')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 d-flex list-grid-col">
                        <!-- <ul class="ml-auto mb-0">
                            <li class="list-inline-item">
                                <a class="active listIcon" data-toggle="tab" href="javscriptvoid:(0)">
                                    <em class="fa fa-list"></em> {{__('search.list')}}
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javscriptvoid:(0)" class="gridIcon">
                                    <em class="fa fa-table"></em> {{__('search.grid')}}
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
                              <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-white d-inline-block mt-2">{{__('search.featured')}}
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
                              {{__('search.negotiable')}}
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
                              {{__('search.negotiable')}}
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
                                    {{__('search.updated')}} {{$diff}} {{__('search.days_ago')}}</p>
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
                              <a href="javascript:void(0)" class="saveAd saveAdBtn mr-3" data-id="{{$ad->id}}"><em id="{{@$id}}" class="fa fa-heart"></em>{{ __('search.save') }}</span></a>
                                    @else
                                    @if(@$checkSaved != null)
                                    @php $id = 'heart4'; @endphp
                                    @else
                                    @php $id = 'heart3'; @endphp
                                    @endif

                              <a target="" href="{{url('user/login')}}" class="saveAd saveAdBtn mr-3" data-id="{{$ad->id}}"><em id="{{@$id}}{{$ad->id}}" class="fa fa-heart {{@$id}}"></em> <span class="save_heart">{{__('search.save')}}</span></a>
                              @endif
                              <a target="" href="{{url('user/login')}}" class="mr-3" data-id="{{@$ad->id}}"><em class="fa fa-share" style="color: gray"></em> <span class="share_heart">{{__('search.share')}}</span></a>
                              <a href="javascript:void(0)" title="{{@$ad->poster_phone}}" class="btn contactbtn themebtn3" style="font-size: 12px;font-weight: 200;padding: 5px 5px;"><em class="fa fa-phone"></em> {{__('search.show_phone_no')}}</a>
                           </div>

                           
                        </div>
                     </div>
                  </div>
            </div> 
                @endforeach
                @else
                <div class="bg-white border col-12 dealer-listing-Col mb-3 p-2 pr-3">
                    <div class="col-lg-8 col-md-8 col-sm-4 col-4 pr-2 pl-md-3 car-dealer-img">
                        <h4 class="mb-0">{{__('search.no_record_found')}}</h4>
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
@endsection