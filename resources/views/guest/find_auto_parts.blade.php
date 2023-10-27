@extends('layouts.app')
@section('title') {{ __('findAutoPartPage.pageTitle') }} @endsection
@push('styles')
<style type="text/css">
  .expand_success {
    background: #ddd;
  }

  .allow_scroll {
    max-height: 648px;
    overflow-y: scroll;
  }

  .allow_scroll::-webkit-scrollbar {
    width: 7px;
    background-color: #eee;
  }

  .allow_scroll::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 0px;
  }

  .allow_scroll::-webkit-scrollbar-thumb:hover {
    background-color: #aaa;
    /*border:1px solid #333333;*/
  }

  .allow_scroll::-webkit-scrollbar-thumb:active {
    background-color: #aaa;
    /*border:1px solid #333333;*/
  }

  .allow_scroll::-webkit-scrollbar-track {
    /*border:1px gray solid;*/
    /*border-radius:10px;*/
    /*-webkit-box-shadow:0 0 6px gray inset;*/
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

  .owl-carousel .owl-nav button.owl-prev,
  .owl-carousel .owl-nav button.owl-next {
    top: 46%;
  }

  @media (max-width: 991px) {
    .auto_parts_list {
      display: flex !important;
    }

    .auto_parts_list>div {
      width: 50%;
      padding-right: 20px;
    }

  }

  .find_autoparts_sidebar {
    min-height: 696px;
  }

  @media (max-width: 767px) {
    .find_autoparts_sidebar {
      min-height: auto !important;
    }
  }
</style>
@endpush
@section('content')
@php
use App\SparePartCategory;
use App\SparePartAd;
$activeLanguage = \Session::get('language');
@endphp
<!-- header Ends here -->
<div class="internal-page-content mt-4 sects-bg pb-0">
  <div class="bgcolcor bgcolor1 internal-banner text-white cc-page-banner">
    <div class="container">
      <h2 class="font-weight-semibold text-capitalize mb-1">{{__('findAutoPartPage.autoPartsAndCarForSale')}}</h2>
      <p class="mb-0">{{__('findAutoPartPage.yourOneStop')}}</p>
    </div>
  </div>
  <div class="container mt-n5">
    <div class="comp-form-bg bg-white border p-md-4 p-3">
      <div class="form-row row">
        <div class="col-7 col-md-9 col-sm-8 form-group mb-0">
          <input type="hidden" value="" id="keyword">
          <input type="text" id="autoPartSearch" value="" name="" placeholder="{{__('findAutoPartPage.searchBarText')}}" class="form-control" required="true">
          <input type="hidden" id="autopartSelected" class="search_text_submit">
        </div>
        <div class="col-5 col-md-3 col-sm-4 form-group mb-0">
          <input disabled="disabled" type="submit" value="{{__('findAutoPartPage.searchButton')}}" class="btn  themebtn3 w-100 pl-3 pr-3 search_check_submit">
        </div>
      </div>
    </div>
    <div class="bg-white border p-md-4 p-3 mt-4">
      <div class="row form-row">
        <div class="col-12 col-md-8 col-sm-7 form-group mb-0 d-flex align-items-center">
          <img src="{{url('public/assets/img/accessoriesImg.jpg')}}" class="img-fluid mr-4">
          <p class="f-size1 mb-0">{{__('findAutoPartPage.sellCarAccessoriesFreeText')}}</p>
        </div>
        <div class="col-12 col-md-4 col-sm-5 form-group mb-0 mt-3 mt-sm-0 text-sm-right text-center">
          <a class="btn  themebtn2 pl-3 pr-3" href="{{ route('sparepartads') }}">{{__('findAutoPartPage.sellCarAccessoriesFreeButton')}}</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Offered Services in Estonia Start Here -->
  <div class="offered-services-section spare-parts-section mt-md-5 mt-4">
  </div>
  <div class="offered-services-section mt-md-5 mt-4">
    @if(@$spareCategories->count() > 0)
    @foreach($spareCategories as $service)
    <div class="offered-services-rows">
      <div class="container">
        <div class="bg-white ml-0 mr-0 mb-2 row">
          <!-- from -->
          <div class="col-lg-12 p-0">
            <h4 id="show_category_{{$service->id}}" data-id="{{@$service->id}}" class="show_category align-items-center align-items-md-start d-flex justify-content-start offered-services-title mb-0 p-3 p-lg-4 themecolor expand_success">
              @if(!empty($service->image) && file_exists('public/uploads/image/'.$service->image))
              <img src="{{url('public/uploads/image/'.@$service->image)}}" class="img-fluid mr-2" style="width: 30px;height: 24px;">
              @else
              <img src="{{asset('public/uploads/image/car.png')}}" alt="carish used cars for sale in estonia" style="height:24px; width:30px;">
              @endif

              <a href="javascript:void(0)">
                @php $main_count = SparePartAd::select('id')->where('status',1)->where('parent_id',@$service->id)->count();
                $skips = ["[","]","\""];
                $p_caty = $service->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title');
                @endphp
                {{-- data-toggle="collapse" data-target="#service-bar-collape1" aria-expanded="true" --}}
                {{$p_caty[0]}} ({{@$main_count}})</a>
            </h4>
          </div>
          <!-- to -->
          <div class="all_spares ml-0 mr-0 col-lg-12" id="show_{{@$service->id}}">
            <div class="row find_autoparts_sidebar">
              <div class="border col-12 col-md-3 col-sm-4 f-size1 offered-services-sidebar p-0" data-id="{{@$service->id}}" style="height: 100%">
                <div class="collapse d-lg-block show" id="service-bar-collape1">
                  <div class="p-3 p-lg-4 allow_scroll ">
                    <ul class="list-unstyled offer-ctg-list">

                      @php

                      $uniqueCategories = SparePartCategory::select('id','title','parent_id')->where('parent_id',$service->id)->orderBy('title','ASC')->get();
                      $count = intval(ceil($uniqueCategories->count() / 2)) ;
                      $looop = $count;
                      @endphp
                      <div class="auto_parts_list">
                        <div>
                          @foreach(@$uniqueCategories as $category)
                          <li>
                            @php
                            $count = SparePartAd::select('id')->where('category_id',@$category->id)->where('status',1)->count();
                            $skips = ["[","]","\""];
                            $p_caty = ($category->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title'));
                            @endphp
                            <a href="javascript:void(0)" data-id="{{@$service->id}} {{@$category->id}}" class="load_spare_parts">{{$p_caty[0]}} ({{@$count}})</a>
                          </li>
                          @php $looop--; @endphp
                          @if($looop == 0)
                          @php $looop = $count; @endphp
                        </div>
                        <div>
                          @endif
                          @endforeach
                        </div>
                      </div>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="border border-left-0 col-12 col-md-9 col-sm-8 offered-services-product p-3 p-lg-4">
                <div class="text-right view-all-offers mb-2">
                  <a target="_blank" id="view_all_{{$service->slug}}" href="{{url('find-autoparts/'.$service->slug)}}" class="f-size font-weight-semibold themecolor view-all-offers-link">{{__('findAutoPartPage.viewAll')}}</a>
                </div>
                <div class="owl-carousel owl-theme services-slider d-md-block d-none mob-view specific_spares_list_{{@$service->id}}">
                  @php
                  $allSpareParts = SparePartAd::where('status',1)->where('parent_id',$service->id)->get();
                  $i = 0;
                  @endphp
                  <div class="item">
                    <div class="row ">
                      @if($allSpareParts->count() > 0)
                      @foreach($allSpareParts as $singleService)
                      <div class="col-md-4 col-sm-4 offered-services-col mt-0" style="margin-bottom: 58px;">
                        <figure class="align-items-center border d-flex justify-content-center mb-0 position-relative text-left">
                          <img src="{{url('public/uploads/ad_pictures/spare-parts-ad/'.@$singleService->id.'/'.@$singleService->get_one_image->img)}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </figure>
                        <div class="p-lg-3 p-2 border border-top-0">
                          <h5 class="font-weight-semibold mb-2 overflow-ellipsis"><a href="{{url('spare-parts-details/'.@$singleService->id)}}" class="stretched-link">{{@$singleService->title}}</a></h5>
                          <ul class="list-unstyled mb-0 font-weight-semibold">
                            <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span>
                              {{@$singleService->get_customer->city->name}}
                            </li>
                            <li class="d-flex themecolor3"><span class="mr-2"></span>€{{@$singleService->price}}</li>
                            {{-- <li class="align-items-baseline d-flex"><span class="mr-2"> Free Shipping</li> --}}
                          </ul>
                        </div>
                      </div>
                      @php $i++; @endphp
                      @if($i == 6)
                    </div>
                  </div>
                  <div class="item">
                    <div class="row">
                      @php $i = 0; @endphp
                      @endif
                      @endforeach
                      @else
                      <div class="col-lg-12 text-center">
                        <h5 class="" style="margin-top: 6%;">{{__('findAutoPartPage.noRecordFound')}}</h5>
                      </div>
                      @endif

                    </div>
                  </div>
                </div>

                <div class="owl-carousel owl-theme services-slider d-md-none d-block mob-view specific_spares_list_46 owl-loaded owl-drag" style="">

                  <div class="item">
                    <div class="row">
                      <div class="col-md-12 offered-services-col mt-0" style="margin-bottom: 58px;">
                        <figure class="align-items-center border d-flex justify-content-center mb-0 position-relative text-left">
                          <img src="http://localhost/CarishNew/public/uploads/ad_pictures/spare-parts-ad/59/578bce00b69a21bd6a5e62bd43b3bde6.jpeg" alt="carish used cars for sale in estonia" class="img-fluid">
                        </figure>
                        <div class="p-lg-3 p-2 border border-top-0">
                          <h5 class="font-weight-semibold mb-2 overflow-ellipsis"><a href="http://localhost/CarishNew/spare-parts-details/59" class="stretched-link">Royal Bloom All Purpose Cleaner 500ml</a></h5>
                          <ul class="list-unstyled mb-0 font-weight-semibold">
                            <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span>
                              Tallinn
                            </li>
                            <li class="d-flex themecolor3"><span class="mr-2"></span>€65</li>

                          </ul>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="item">
                    <div class="row">
                      <div class="col-md-12 offered-services-col mt-0" style="margin-bottom: 58px;">
                        <figure class="align-items-center border d-flex justify-content-center mb-0 position-relative text-left">
                          <img src="http://localhost/CarishNew/public/uploads/ad_pictures/spare-parts-ad/59/578bce00b69a21bd6a5e62bd43b3bde6.jpeg" alt="carish used cars for sale in estonia" class="img-fluid">
                        </figure>
                        <div class="p-lg-3 p-2 border border-top-0">
                          <h5 class="font-weight-semibold mb-2 overflow-ellipsis"><a href="http://localhost/CarishNew/spare-parts-details/59" class="stretched-link">Royal Bloom All Purpose Cleaner 500ml</a></h5>
                          <ul class="list-unstyled mb-0 font-weight-semibold">
                            <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span>
                              Tallinn
                            </li>
                            <li class="d-flex themecolor3"><span class="mr-2"></span>€65</li>

                          </ul>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="item">
                    <div class="row">
                      <div class="col-md-12 offered-services-col mt-0" style="margin-bottom: 58px;">
                        <figure class="align-items-center border d-flex justify-content-center mb-0 position-relative text-left">
                          <img src="http://localhost/CarishNew/public/uploads/ad_pictures/spare-parts-ad/59/578bce00b69a21bd6a5e62bd43b3bde6.jpeg" alt="carish used cars for sale in estonia" class="img-fluid">
                        </figure>
                        <div class="p-lg-3 p-2 border border-top-0">
                          <h5 class="font-weight-semibold mb-2 overflow-ellipsis"><a href="http://localhost/CarishNew/spare-parts-details/59" class="stretched-link">Royal Bloom All Purpose Cleaner 500ml</a></h5>
                          <ul class="list-unstyled mb-0 font-weight-semibold">
                            <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span>
                              Tallinn
                            </li>
                            <li class="d-flex themecolor3"><span class="mr-2"></span>€65</li>

                          </ul>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
    @endif
  </div>
  <!-- Offered Services in Estonia Ends Here -->
</div>
@push('scripts')
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
    $('.all_spares').toggle();
    $(".search_check_submit").click(function(event) {

      var value = $('.search_text_submit').val();
      if (value == undefined || value == '') {
        toastr.error('error!', 'Enter Something In The Search Field.', {
          "positionClass": "toast-bottom-right"
        });
        return false;
      } else {
        var baseUrl = "{{url('/')}}";
        var datavars = [];
        $(".search_text_submit").each(function() {
          if ($(this).val() != '') {
            //var search_text_submit  = $(this).data("value");
            str = $(this).val()
            datavars.push(str);
          }
        });
        datavars = getUnique(datavars);
        //var search_url = baseUrl+'/find_autoparts/listing/'+datavars.join([separator = '/']);
        var search_url = baseUrl + '/find_autoparts/listing/' + datavars.join([separator = '/']);

        window.location.href = search_url;
      }
    });

    $('.show_category').on('click', function() {
      var id = $(this).data('id');
      // alert(id);
      $(this).toggleClass('expand_success');
      $('.arrow_class_' + id).toggleClass('fa-chevron-circle-right');
      $('.arrow_class_' + id).toggleClass('fa-chevron-circle-down');
      $('#show_' + id).slideToggle("show");
    });

    $('.hide_category').on('click', function() {
      var id = $(this).data('id');
      $('#show_' + id).slideToggle("show");
      $('#show_category_' + id).toggleClass('expand_success');
    });

    $("#autoPartSearch").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: "{{route('get.sparepart.scats')}}/",
          dataType: "json",
          data: {
            term: request.term
          },
          success: function(data) {
            response(data);
          }
        });
      },
      select: function(event, ui) {
        $("input#keyword").val("");
        var selectedValue = ui.item.id;
        $("#autopartSelected").val(selectedValue);

        $(".search_check_submit").attr("disabled", false);
      }
    });

    $("input#autoPartSearch").keyup(function(a) {
      var e = $(this).val();
      $("input#keyword").val("keyword_" + e)
    });

    $('.load_spare_parts').on('click', function() {
      $('.mob-view').removeClass('d-none');
      $('.mob-view').addClass('d-sm-block');
      var cats = $(this).data('id').split(' ');
      var parent_id = cats[0];
      var secondary_id = cats[1];
      cat = '';
      if (parent_id != '') {
        var cat = 'cat_' + parent_id;
      }
      scat = '';
      if (secondary_id != '') {
        var scat = 'scat_' + secondary_id;
      }
      var services = "{{url('find_autoparts/listing/')}}/cat_" + parent_id + '/' + scat;
      $("#view_all_" + parent_id).attr("href", services);

      $.ajax({
        method: "get",
        dataType: "json",
        data: {
          parent_id: parent_id,
          secondary_id: secondary_id
        },
        cache: false,
        url: "{{ route('get-specific-spareparts') }}",
        beforeSend: function() {
          Swal.fire({
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 1500,
            width: 300,
            height: 300,
            didOpen: () => {
              Swal.showLoading()
            }
          });
        },
        success: function(result) {
          if (result.success == true) {
            $('.specific_spares_list_' + parent_id).html(result.html);
            $('.specific_spares_list_' + parent_id).trigger('destroy.owl.carousel');
            $('.specific_spares_list_' + parent_id).owlCarousel({
              loop: !1,
              margin: 0,
              nav: !0,
              responsive: {
                0: {
                  items: 1
                }
              }
            });
          }
          swal.close();
        }
      });
    });
  });
</script>
@endpush
@endsection