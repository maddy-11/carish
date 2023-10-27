@extends('layouts.app')
@section('title') {{ __('header.offerServiceSearch') }} @endsection
@php
  $subCatId =0;
  if(!empty($sub)){ $subCatId = $sub->id; } 
@endphp
@push('styles')
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
@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" charset="utf-8" defer>
$(document).ready(function ()
{
  $('input.search_check_submit:radio:checked').parent().addClass('active_element');
  var subCatId = "{{$subCatId}}";
  if(subCatId != 0){
  $("#makesCheckcat_"+subCatId).prop("checked", true);
  }
  var getSubServices = "{{route('subservices')}}";
  $(document).on('click',".subCategory", function(){ 
  var parentCategory    = $(this).data('value');
  var isMake            = $(this).data('make');
  $("#makesCheckcat_"+parentCategory).prop("checked", true);
  });// END CLICK FUNCTION
  $(document).on("click",".subcat_check_submit",function(event) { 
  var subCatId = $(this).data("value");
  $("#makesCheck"+subCatId).prop("checked", true);
  });
  $(document).on("click",".search_check_submit",function(event) { 
    var p_slug = "{{$p_slug}}";
    // console.log(p_slug);return;
    $(this).parent().addClass('active');
    var baseUrl = "{{url('/')}}";
    var datavars = []; 
    $(".search_text_submit").each(function () {
      if($(this).val() != ''){
        var search_text_submit  = $(this).data("value");

        str = search_text_submit+$(this).val();
        datavars.push(str);
      }
    }); 

    $('input.search_check_submit:radio:checked').each(function () { 
    var str = $(this).data("value");   
    datavars.push(str);
    
  });
  // console.log(datavars);return; 
    $('input.search_check_submit:checkbox:checked').each(function () { 
      var str = $(this).data("value");   
      datavars.push(str); 
    });
    datavars       = getUnique(datavars);
    var search_url = baseUrl+'/find-car-services/'+p_slug+'/'+datavars.join([separator = '/']);
    // console.log(search_url);return;
    window.location.href = search_url;


  });
  /* AUTO COMPLETE FOR MAKES */ 

  var p_id = "{{$p_id}}";
  $( "#titles").autocomplete({
    source: function( request, response ) {
      $.ajax( {
        url: "{{route('get.services')}}?p_id="+p_id,
        dataType: "json",
        data: {
          term: request.term
        },
        success: function( data ) {
          response( data );
        }
      });
    }, 
    select: function (event, ui) { 
      var selectedValue = ui.item.id;
      $("#title").val(selectedValue);
    } 
  });

  $("#dealers").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "{{route('get.dealers')}}",
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
  $( "#cities").autocomplete({
    source: function( request, response ) {
      $.ajax( {
        url: "{{route('get.city')}}",
        dataType: "json",
        data: {
          term: request.term
        },
        success: function( data ) {
          response( data );
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
  }, 200);  
  });// END DOCUMENT READY


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
@section('content') 
@php 
use App\Models\Customers\Customer;
$activeLanguage = \Session::get('language');
$skips = ["[","]","\""];
if(!is_null($category)){
  $p_caty = str_replace($skips,' ',$category->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first());
}
@endphp
     <div class="internal-page-content mt-4 pt-4 sects-bg">
        <div class="container">
          <div class="row">
            <div class="col-12 bannerAd pt-2">
              <img src="{{url('public/assets/img/placeholder.jpg')}}" class="img-fluid" alt="carish used cars for sale in estonia">
            </div>
            <div class="col-12 pageTitle mt-md-5 mt-4">
              <div class="bg-white border p-md-4 p-3">
                <nav aria-label="breadcrumb" class="breadcrumb-menu" id="breadcrumb">
                  <ol class="breadcrumb"> 
                      <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a target="" href="{{url('/')}}">{{__('findService-CategoryPage.backLinkHome')}}</a></li>
                    <li class="breadcrumb-item"><a target="" href="{{route('allservices')}}">{{__('findService-CategoryPage.backLinkService')}}</a></li>
                    @if(empty($sub->title))
                       <li class="breadcrumb-item active ">{{@$p_caty}}</li>
                    @else 
                       <li class="breadcrumb-item"><a target="" href="{{route('service-sub-search',[$category->slug])}}">{{@$p_caty}}</a></li>
                    @endif
                    @if(!empty($sub->title))
                    @php
                      $pp_caty = str_replace($skips,' ',@$sub->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first());
                    @endphp
                       <li class="breadcrumb-item active" aria-current="page">{{@$pp_caty}}</li>
                    @endif
                  </ol>

                  </ol>
                </nav>

                   <div class="row">
               <div class="col-md-3"> 
                <h2 class="font-weight-semibold themecolor">{{@$p_caty}}</h2></div>
               {{-- <input type="hidden"  data-value="cat_" value=" " class="search_text_submit"> --}}  
               <!-- starts******** -->
               <div class="col-12 col-md-9 col-lg-9 col-sm-12 mb-4 mt-3">
                 <div class=" overflow-hidden pt-0" style="border: 1px solid #eee;">
                    <div class="row">
                    
                   <div class="col-6">
                      <h6 class="post-ad-modal-title d-flex align-items-center" class="post-ad-modal-title" style="height: 70px;font-size: 100%"><!-- <em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> --> {{__('findService-CategoryPage.subCategory')}}</h6>
                    </div>
                    <div class="col-6">
                      <h6 class="post-ad-modal-title d-flex align-items-center detail_class" class="post-ad-modal-title" style="height: 70px;font-size: 100%"><!-- <em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> --> {{__('findService-CategoryPage.Detail')}}</h6>
                    </div>
                   
                    </div>
                      <div class="row pl-3 pr-3">
                        <div class="col-6 p-0" style="border-right: 1px solid #eee;">
                          <table class="table" style="width: 100%;margin-bottom: 0px;">                 
                            <tbody>
                              @if(@$subCats)
                                @foreach ($subCats as $childCats)
                                  @php
                                    $pp_caty = str_replace($skips,' ',@$childCats->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first());
                                  @endphp
                                  <tr>  
                                    <td style="border: none;" class="search_li_hover"> 
                                      @if(@$category_id != null && $childCats->id == @$category_id)
                                        <input type="radio" value="{{$childCats->slug}}" id="makesCheckcat_{{$childCats->slug}}" data-value="{{$childCats->slug}}"  class="search_check_submit radio d-none"  name="category" checked="true">
                                        <a href="javascript:void(0)" data-make="{{$childCats->is_make}}" data-value="{{$childCats->slug}}" id="{{$childCats->slug}}" class="subCategory search_check_submit" style="display: block;background-color:#D3D3D3;">{{$pp_caty}}</a>
                                      @else
                                        <input type="radio" value="{{$childCats->slug}}" id="makesCheckcat_{{$childCats->slug}}" data-value="{{$childCats->slug}}" class="search_check_submit radio d-none" name="category" {{ (@$customer->country_id == '1')? "selected='true'":" " }} >
                                        <a href="javascript:void(0)" data-make="{{$childCats->is_make}}" data-value="{{$childCats->slug}}" id="{{$childCats->slug}}" class="subCategory search_check_submit" style="display: block;">{{$pp_caty}}</a> 
                                      @endif                           
                                    </td>
                                 </tr>                      
                                @endforeach 
                              @else
                                <tr>
                                  <td colspan="2" style="text-align: center;">No Data Founds</td>
                                </tr>
                              @endif  
                            </tbody>
                          </table>
                        </div>
                        <div class="col-6 p-0" style="max-height: 200px; overflow-y: scroll;" id="ex3"> 
                          <table class="table" style="width: 100%;">
                            <tbody> 
                              @if(@$subCatsChilds !== null)
                                @foreach ($subCatsChilds as $subChildCats)
                                  @php
                                    if(!empty($sub) && $sub->is_make == 1){
                                      $pp_caty = $subChildCats->title;
                                    }
                                    else {
                                      $pp_caty = str_replace($skips,' ',@$subChildCats->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first());
                                    }
                                  @endphp
                                  <tr>
                                    <td style="border: none;" class="search_li_hover">
                                      @if(@$subCategor != null && $subChildCats->id == @$subCategor)
                                        <input type="radio" name="ssub_category" class="search_check_submit radio d-none" value="{{$subChildCats->slug}}" id="makesCheck{{$subChildCats->slug}}" data-value="{{$subChildCats->slug}}" checked="true">
                                        <a href="javascript:void(0)" class="search_check_submit subcat_check_submit" data-value="{{$subChildCats->slug}}" style="display: block;background-color:#D3D3D3;">{{$pp_caty}}</a>
                                      @else
                                        <input type="radio" name="ssub_category" class="search_check_submit radio d-none" value="{{$subChildCats->slug}}" id="makesCheck{{$subChildCats->slug}}" data-value="{{$subChildCats->slug}}">
                                        <a href="javascript:void(0)" class="search_check_submit subcat_check_submit" data-value="{{$subChildCats->slug}}" style="display: block;">{{$pp_caty}}</a>
                                      @endif
                                    </td>
                                  </tr>
                                @endforeach 
                              @endif
                            </tbody>
                          </table>
                        </div>
                      </div>  
                  </div>
               </div>
               <!-- ************************************End ******************-->
               <div class="col-md-3"></div>
 
            </div>
              </div>
            </div>
          </div>
          <div class="row mt-md-5 mt-4">
            <!-- left Sidebar start here -->
            <aside class="col-lg-3 col-12 mb-4 mb-lg-0 left-sidebar">
              <div class="leftsidebar-bg">
            <div class="search-by-filter">
              <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title " data-toggle="collapse" data-target="#searchbyreasult" aria-expanded="false" aria-controls="searchbyreasult">{{__('findService-CategoryPage.showResultsBy')}}: <em class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse" data-target="#searchbyreasult" aria-expanded="false" aria-controls="searchbyreasult"></em></h6>

              <div class="search-filter collapse d-lg-block" id="searchbyreasult">
              <h6 class=" sidebar-title mb-0  pt-3 pb-3 pl-4 pr-4"><img src="{{url('public/assets/img/rIcon-search-filter.png')}}" alt="carish used cars for sale in estonia" class="img-fluid mr-2"> {{__('findService-CategoryPage.searchFilters')}} </h6>
              <div class="bg-white p-4">
                <ul class="list-unstyled mb-0 font-weight-semibold">
                   {!!@$searchedKeywords!!}
                  </ul>
              </div>
              </div>
            </div>

            {{-- SEARCH BY DEALER --}}
                    <div class="search-by-name">
                        <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title "
                            data-toggle="collapse" data-target="#searchbydealer" aria-expanded="false"
                            aria-controls="searchbyname">{{__('findService-CategoryPage.searchByDealer')}} <em
                                class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse"
                                data-target="#searchbydealer" aria-expanded="false" aria-controls="searchbyname"></em>
                        </h6>
                        <div class="search-by-name-bg bg-white collapse d-lg-block" id="searchbydealer">
                            <div class="p-4">
                                <div class="input-group sidebar-input-group">
                                    <input type="text" id="dealers" data-value="dealer_"
                                        value="{{@$queyStringArray['dealer'][0]}}" class="form-control p-2 pr-2 search_text_submit" placeholder=""
                                        aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button
                                            class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit"
                                            type="button"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

            <div class="search-by-name">
              <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title " data-toggle="collapse" data-target="#searchbyname" aria-expanded="false" aria-controls="searchbyname">{{__('findService-CategoryPage.searchByTitle')}}: <em class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse" data-target="#searchbyname" aria-expanded="false" aria-controls="searchbyname"></em></h6>
              <div class="search-by-name-bg bg-white collapse d-lg-block" id="searchbyname">
                <div class="p-4">
                  <div class="input-group sidebar-input-group">
                    <input type="text" id="titles" data-value="keyword_"  value="{{@$queyStringArray['keyword'][0]}}" class="form-control p-2 pr-2 search_text_submit" placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit" type="button"></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="search-by-city">
  <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title " data-toggle="collapse" data-target="#searchbycity" aria-expanded="false" aria-controls="searchbycity">{{__('findService-CategoryPage.searchByCity')}} <em class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse" data-target="#searchbycity" aria-expanded="false" aria-controls="searchbycity"></em></h6>
      <div class="collapse d-lg-block bg-white" id="searchbycity">
          <div class="p-4">
            <div class="input-group sidebar-input-group">
              <input type="text" id="cities" class="form-control p-2 pr-2" placeholder="{{__('findService-CategoryPage.city')}}" aria-label="Recipient's username" aria-describedby="basic-addon2" autocomplete="off">
              <input type="hidden" data-value="city_" value="{{@$queyStringArray['city'][0]}}" id="city" class="search_text_submit">
              <div class="input-group-append">
                <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2 search_check_submit" type="button"></button>
              </div>
            </div>
            @if(count($sideBarArray['foundInCity']) > 0) 
              <ul class="list-unstyled carselectlist mb-0">
                @foreach($sideBarArray['foundInCity'] as $locations)
                  <li class="d-flex justify-content-between">
                    <div class="custom-control mr-2 custom-checkbox ">
                      <input type="checkbox" class="custom-control-input search_check_submit" value="city_{{$locations->id}}" id="locationCheck{{$locations->id}}" data-value="city_{{$locations->id}}" @if(isset($quey_string_slug['city']) && in_array($locations->id,$quey_string_slug['city'])) checked="checked" @endif>
                      <label class="custom-control-label" for="locationCheck{{$locations->id}}">{{$locations->name}}</label>
                    </div>
                    <div><span class="badge badge-pill border pb-1 pt-1">{{$locations->totalAdsInCities}}</span></div>
                  </li> 
                @endforeach    
              </ul>
            {{-- <div class="mt-3 show-more text-right">
              <a href="javascript:void(0)" class="themecolor font-weight-semibold show-more-cities">{{__('ads.show_more')}}</a>
            </div> --}}
            @endif
          </div>
        </div>
      </div>


            <div class="search-by-name">
              <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title " data-toggle="collapse" data-target="#searchbytype" aria-expanded="false" aria-controls="searchbyname">{{__('findService-CategoryPage.adType')}}: <em class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse" data-target="#searchbytype" aria-expanded="false" aria-controls="searchbyname"></em></h6>
              <div class="search-by-name-bg bg-white collapse d-lg-block" id="searchbytype">
                <div class="p-4"> 
                   <ul class="list-unstyled carselectlist mb-0 mt-4 search-by-city-list" id="search-by-city-list">
                     @php 
                        $featured_checked     = "";
                        $featured             = true;
                        $unfeatured_checked = "";
                        $unfeatured         = true;
                        if(isset($queyStringArray['featured']) && in_array('false',$queyStringArray['featured']))
                        {
                          $featured     = false; 
                          $unfeatured_checked = "checked";
                        }
                        
                        if(isset($queyStringArray['featured']) && in_array('true',$queyStringArray['featured']))
                        {
                          $unfeatured     = false; 
                          $featured_checked = "checked";
                        }
                      @endphp  
                    
                    @if($featured)
                    <li class="d-flex justify-content-between">
                        <div class="custom-control mr-2 custom-checkbox ">
                          <input type="checkbox" value="featured_true" data-value="featured_true" class="custom-control-input search_check_submit" id="modalCheck1" name="example1"
                           {{$featured_checked}}>
                          <label class="custom-control-label" for="modalCheck1">{{__('findService-CategoryPage.featuredAds')}}</label>
                        </div> </li>
                      @endif
                      @if($unfeatured)
                      <li class="d-flex justify-content-between">
                        <div class="custom-control mr-2 custom-checkbox ">
                          <input type="checkbox"  value="featured_false" data-value="featured_false"  class="custom-control-input search_check_submit" id="modalCheck2" name="example2" 
                           {{$unfeatured_checked}}>
                          <label class="custom-control-label" for="modalCheck2">{{__('findService-CategoryPage.UnFeaturedAds')}}</label>
                        </div>  </li>
                      @endif

                   </ul>
                </div>
              </div>
            </div>




  </div>

  <div class="sidebar-banner mt-4 pt-1 d-lg-block d-none">
    <img src="{{url('public/assets/img/sidebar-banner.jpg')}}" alt="carish used cars for sale in estonia" class="img-fluid d-block ml-auto mr-auto">
  </div>
  </aside> 
                        <!-- left Sidebar ends here -->
                        <!-- right content section starts here -->
      <div class="col-lg-9 col-12 right-content used-car-dealer">
        <!-- listing view starts here -->
        <div class="ml-0 mr-0 row used-car-dealer-row">
          @if(@$service_ads != null && @$service_ads->count() > 0)
          @foreach($service_ads as $serviceAds)
          @php
            $customer     = Customer::where('id',$serviceAds->customer_id)->first(); 
            @$title       = $serviceAds->get_service_ad_title($serviceAds->service_id , $activeLanguage['id'])->title;
            $serviceimage = \App\Models\ServiceImage::where('service_id','=',$serviceAds->service_id)->get();  
           @endphp  
 
{{-- #################################### --}}
<div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
                  <div class="row">
                     <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar">
                        <figure class="mb-0 position-relative">
                           @if(!empty($serviceimage[0]->image_name) && file_exists( public_path() . '/uploads/ad_pictures/services/'.$serviceAds->service_id.'/'.$serviceimage[0]->image_name))
                           <a href="javascript:void(0)" style="display: block;background-image: url('{{url('public/uploads/ad_pictures/services/'.$serviceAds->service_id.'/'.$serviceimage[0]->image_name)}}');
                              background-size: cover;
                              background-position: center;" class="desktop_size mob_size">
                              <!-- <img src="{{url('public/uploads/ad_pictures/cars/'.$serviceAds->id.'/'.@$serviceAds->ads_images[0]->img)}}" class="img-fluid ads_image" alt="carish used cars for sale in estonia"> -->
                           </a>
                           @else
                           <a href="javascript:void(0)" style="display: block;background-image: url('{{url('public/assets/img/serviceavatar.jpg')}}');
                              background-size: cover;
                              background-position: center;" class="desktop_size mob_size">
                           </a>
                           <!-- <img src="{{url('public/assets/img/serviceavatar.jpg')}}" alt="carish used cars for sale in estonia" class="img-fluid ads_image"> -->
                           @endif
                           <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between"> 
                              @if(0)
                              <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-white d-inline-block mt-2">{{__('findService-CategoryPage.featuredAds')}}
                              </span>
                              @endif
                              <span class="d-inline-block pb-1 pl-2 pr-2 pt-1 viewgallery"><em class="fa fa-camera  mr-1"></em>{{!empty($serviceimage) ? $serviceimage->count() : '0'}}</span>
                           </figcaption>
                           </a>
                        </figure>
                     </div>
                     <div class="col-lg-9 col-md-9 col-sm-9 col-8 listingCar-descCar">
                        <div class="align-items-center d-flex justify-content-between listingCar-title mb-1">
                           <h5 class="font-weight-normal mb-0"><a title="{{@$title}}" href="{{url('service-details/'.$serviceAds->service_id )}}">{{@$title}}</a></h5>
                           
                        </div>
                        <div class="align-items-center d-flex justify-content-between listingCar-place mb-3">
                           <p class="carplace mb-0">{{$customer->city->name}}</p>
                           <p class="themecolor2 font-weight-semibold mb-0 negotiable">
                             
                           </p>
                        </div>
                        <div class="align-items-center d-flex justify-content-between aboutcarlist mb-3">
                           <ul class="list-unstyled mb-0" style="opacity: 0.5">
                              <li class="list-inline-item"> {{$serviceAds->primary_service_title}}</li>
                              <span>&#124;</span>
                              <li class="list-inline-item">{{$serviceAds->sub_service_title}} </li>
                              <span>&#124;</span> 
                           </ul>
                           <span></span>
                        </div>
                     
                        <div class="align-items-center row contactRow" style="">
                           <div class="col-lg-5 col-md-5 col-sm-4 col-4">
                              <p class="mb-0">
                                        @php  
                                    $updated_at = \Carbon\Carbon::parse($serviceAds->updated_at);
                                    $now        = \Carbon\Carbon::now();
                                    $diff       = $updated_at->diffInDays($now); 
                                @endphp 
                                    {{__('findService-CategoryPage.updated')}} {{$diff}} {{__('findService-CategoryPage.daysAgo')}}</p>
                           </div>
                           <div class="align-items-center col-8 col-lg-7 col-md-7 col-sm-8 d-flex justify-content-end text-right pl-md-3 pl-0">
                              @if(Auth::guard('customer')->user())
                              @php
                              $saved = \App\UserSavedAds::where('ad_id',$serviceAds->id)->where('customer_id',@Auth::guard('customer')->user()->id)->first();
                              @endphp
                              @if(@$saved != null)
                              @php $id = 'heart2'; @endphp
                              @else
                              @php $id = 'heart'; @endphp
                              @endif
                              <a href="javascript:void(0)" class="saveAd saveAdBtn mr-3" data-id="{{$serviceAds->id}}"><em id="{{$id}}{{$serviceAds->id}}" class="fa fa-heart {{$id}}"></em> <span class="save_heart">{{__('findService-CategoryPage.save')}}</span></a>
                              @else
                              <a target="" href="{{url('user/login')}}" class="saveAd saveAdBtn mr-3" data-id="{{@$serviceAds->id}}"><em id="{{@$id}}{{$serviceAds->id}}" class="fa fa-heart {{@$id}}"></em> <span class="save_heart">{{__('findService-CategoryPage.save')}}</span></a>
                              @endif
                              <a target="" href="{{url('user/login')}}" class="mr-3" data-id="{{@$serviceAds->id}}"><em class="fa fa-share" style="color: gray"></em> <span class="share_heart">{{__('findService-CategoryPage.share')}}</span></a>
                              <a href="javascript:void(0)" title="{{@$serviceAds->phone_of_service}}" class="btn contactbtn themebtn3" style="font-size: 12px;font-weight: 200;padding: 5px 5px;"><em class="fa fa-phone"></em> {{__('findService-CategoryPage.showPhoneNumber')}}</a>
                           </div>

                           
                        </div>
                     </div>
                  </div>
               </div>

          @endforeach
          @else
          <div class="bg-white col-lg-12 p-4">
            <h2>{{__('findService-CategoryPage.noRecordFound')}}</h2>
          </div>
          @endif
       
        </div>
         @if(@$service_ads != null && @$service_ads->count() > 0)
        <!-- listing view ends here -->
        @if($service_ads->hasPages()) 
        <div class="row mt-3">
          <div class="col-12 carList-pager">
            <nav class="bg-white border p-3" aria-label="Page navigation example">
                {{ $service_ads->appends(request()->query())->links("pagination::bootstrap-4") }} 
            </nav>
          </div>
        </div>
        @endif
        @endif
      </div>
      <!-- right content section ends here -->
    </div>
  </div>
</div>
@endsection 