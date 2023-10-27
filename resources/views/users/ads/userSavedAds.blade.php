@extends('layouts.app')
@push('styles')
{{-- Sweet Alert --}}
<link href="{{asset('public/css/sweetalert.min.css')}}" rel="stylesheet" media="all">
@endpush
@section('content')
<div class="alert alert-success" id="success" style="display: none;">
  <p>Saved Ad removed successfully!</p>
</div>
<div class="alert alert-success" id="part-success" style="display: none;">
  <p>Saved SparePart-Ad removed successfully!</p>
</div>
<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
  <div class="container">
    <div class="row ml-0 mr-0">
      @include('users.ads.profile_tabes')
    </div>
    <div class="tab-content profile-tab-content">
      <!-- Tab 2 starts here -->
      <div class="tab-pane active" id="profile-tab2">
        <div class="row ad-tab-desc">
          <div class="ad-tab-sidebar save-ad-sidebar col-lg-3 col-md-4">
            <div class="bg-white border p-3">
              <ul class="nav nav-tabs nav-pills d-block text-capitalize sidebar-pills my-save-ad-tabs">
                <li class="nav-item">
                  <a class="nav-link active d-flex" data-toggle="tab" href="#save-ad-tab1">
                    <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                      <img src="{{url('public/assets/img/adtab-car.png')}}" class="img-fluid none-active-img" alt="icon image">
                      <img src="{{url('public/assets/img/adtab-active-car.png')}}" class="img-fluid active-img" alt="icon image">
                    </figure> <span>{{__('dashboardSavedAds.carAds')}}</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex" data-toggle="tab" href="#save-ad-tab2">
                    <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                      <img src="{{url('public/assets/img/adtab-parts.png')}}" class="img-fluid none-active-img" alt="icon image">
                      <img src="{{url('public/assets/img/adtab-active-parts.png')}}" class="img-fluid active-img" alt="icon image">
                    </figure> <span>{{__('dashboardSavedAds.sparePartAds')}}</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-9 col-md-8 mt-md-0 mt-4 pl-md-0 pl-lg-3 ad-tab-desc">
            <div class="tab-content">
              <div class="tab-pane active" id="save-ad-tab1">
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">{{__('dashboardSavedAds.adInDisplay')}} {{@$saveAds != null ? @$saveAds->count():'0'}} {{__('dashboardSavedAds.adListing')}}</h6>
                  </div>
                </div>
                @if($saveAds->isNotEmpty())
                @foreach($saveAds as $s_ads)
                @if($s_ads->ads != null)
                <div class="bg-white border">
                  <div class="ads-listing-rows">
                    <div class="row p-3 mx-0">
                    <div class="col-lg-3 col-sm-4 col-4 pl-0 mb-0">
                      <figure class="ads-listing-img">
                        @if(@$s_ads->ads->ads_images[0]->img != null && file_exists( public_path() . '/uploads/ad_pictures/cars/'.$s_ads->ads->id.'/'.@$s_ads->ads->ads_images[0]->img))
                        <img src="{{url('public/uploads/ad_pictures/cars/'.$s_ads->ads->id.'/'.@$s_ads->ads->ads_images[0]->img)}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        @else
                        <img src="{{url('public/assets/img/caravatar.jpg')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        @endif
                      </figure>
                    </div>
                      <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                        <h4><a target="" href="{{url('car-details/'.$s_ads->ads->id)}}" target="">{{@$s_ads->ads->maker->title}} {{@$s_ads->ads->model->name}} {{@$s_ads->ads->year}} {{@$s_ads->ads->versions->label}}</a></h4>
                        <p class="save-ad-price mb-0">&euro;{{@$s_ads->ads->price}}</p>
                      </div>
                      <div class="col-12 px-0 mt-3">
                        <div class="row align-items-sm-center">
                          <div class="col-lg-7 col-md-8 col-sm-8 mb-0 actionbtn ">
                            <ul class="list-unstyled mb-0">
                              <li class="list-inline-item"><a href="javascript:void(0)" class="border border-danger d-inline-block px-sm-3 px-2 py-1 rounded text-danger" data-id="{{$s_ads->id}}" id="remove-ad"> {{__('dashboardSavedAds.remove')}}<em class="ml-1 fa fa-trash"></em></a></li>

                            </ul>
                          </div>
                          <div class="col-lg-5 col-md-4 col-sm-4 pt-3 pt-sm-0 text-sm-right">
                            <a href="{{url('car-details/'.$s_ads->ad_id)}}" class="border d-inline-block px-sm-3 px-2 py-1 rounded">
                              <em class="fa fa-eye"></em>
                              {{__('dashboardSavedAds.view')}}
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
                @endforeach
                @else
                <div class="bg-white border">
                  <div class="ads-listing-rows">
                    <div class="row p-3 mx-0">
                      <div class="col-12 px-0 mt-3">
                        <div class="row align-items-sm-center">
                          <div class="col-lg-12 col-md-8 col-sm-8 mb-0 ">
                            <h5>{{__('dashboardSavedAds.noAdFound')}}</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                @endif
              </div>



              <div class="tab-pane" id="save-ad-tab2">
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">{{__('dashboardSavedAds.adInDisplay')}} {{@$saveParts != null ? @$saveParts->count():'0'}} {{__('dashboardSavedAds.adListing')}}</h6>
                  </div>
                </div>
                @if($saveParts->count()>0)
                @foreach($saveParts as $part_ads)
                <div class="bg-white border">
                  <div class="ads-listing-rows">
                    <div class="row p-3 mx-0">
                    <div class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ">
                      <figure class="ads-listing-img">
                        @if(@$part_ads->sparePartAds->get_one_image->img != null && file_exists( public_path() . '/uploads/ad_pictures/spare-parts-ad/'.$part_ads->spare_part_ad_id.'/'.@$part_ads->sparePartAds->get_one_image->img))
                        <img src="{{url('public/uploads/ad_pictures/spare-parts-ad/'.@$part_ads->spare_part_ad_id.'/'.@$part_ads->sparePartAds->get_one_image->img)}}" alt="carish used cars for sale in estonia" class="img-fluid" style="max-height: 140px;">
                        @else
                        <img src="{{url('public/assets/img/sparepartavatar.jpg')}}" alt="Spare Part Image" class="img-fluid" >
                        @endif
                      </figure>
                      </div>
                      <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                        <h4><a target="" href="{{url('spare-parts-details/'.$part_ads->spare_part_ad_id)}}" target="">{{$part_ads->sparePartAds->title}}</a></h4>
                        <p class="save-ad-price mb-0">&euro;{{$part_ads->sparePartAds->price}}</p>
                      </div>
                      <div class="col-12 px-0 mt-3">
                        <div class="row align-items-sm-center">
                          <div class="col-lg-7 col-md-8 col-sm-8 mb-0 actionbtn ">
                            <ul class="list-unstyled mb-0">
                              <li class="list-inline-item"><a href="javascript:void(0)" class="border border-danger d-inline-block px-sm-3 px-2 py-1 rounded text-danger" data-id="{{$part_ads->id}}" id="remove-partAd"> {{__('dashboardSavedAds.remove')}}<em class="ml-1 fa fa-trash"></em></a></li>

                            </ul>
                          </div>
                          <div class="col-lg-5 col-md-4 col-sm-4 pt-3 pt-sm-0 text-sm-right">
                            <a href="{{url('spare-parts-details/'.$part_ads->spare_part_ad_id)}}" class="border d-inline-block px-sm-3 px-2 py-1 rounded">
                              <em class="fa fa-eye"></em>
                              {{__('dashboardSavedAds.view')}}
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
                @else
                <div class="bg-white border">
                  <div class="ads-listing-rows">
                    <div class="row p-3 mx-0">
                      <div class="col-12 px-0 mt-3">
                        <div class="row align-items-sm-center">
                          <div class="col-lg-12 col-md-8 col-sm-8 mb-0 ">
                            <h5>{{__('dashboardSavedAds.noAdFound')}}</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Tab 2 ends here -->
    </div>
  </div>
  @push('scripts')
  {{-- Sweet Alert --}}
  <script src="{{asset('public/js/sweetalert.min.js')}}"></script>
  <script type="text/javascript">
    $('#remove-ad').on('click', function() {
      var ad_id = $(this).data('id');
      swal({
          title: "{{__('dashboardSavedAds.alert')}}",
          text: "{{__('dashboardSavedAds.youSure')}}",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "{{__('dashboardSavedAds.yesDo')}}",
          cancelButtonText: "{{__('dashboardSavedAds.cancel')}}",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm) {
          if (isConfirm) {
            $.ajax({
              type: "get",
              dataType: "json",
              url: "{{url('user/remove-save-ad')}}/" + ad_id,

              success: function(data) {

                if (data.success == true) {
                  $('#part-success').css('display', 'block');
                }
                setTimeout(function() {
                  location.reload();
                }, 1000);


              },

            });

          } else {
            swal("Cancelled", "", "error");

          }

        });



    });
    $('#remove-partAd').on('click', function() {
      //alert('fdf');
      var ad_id = $(this).data('id');


      swal({
          title: "Alert!",
          text: "{{__('dashboardSavedAds.youSure')}} {{__('dashboardSavedAds.youSureToremove')}}",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "{{__('dashboardSavedAds.yesDo')}}",
          cancelButtonText: "{{__('dashboardSavedAds.cancel')}}",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm) {
          if (isConfirm) {
            $.ajax({
              type: "get",
              dataType: "json",
              url: "{{url('user/remove-save-partAd')}}/" + ad_id,

              success: function(data) {

                if (data.success == true) {
                  $('#success').css('display', 'block');
                }
                setTimeout(function() {
                  location.reload();
                }, 1000);


              },

            });

          } else {
            swal("Cancelled", "", "error");

          }

        });



    });
  </script>
  @endpush
  @endsection