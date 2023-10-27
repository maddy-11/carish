@extends('layouts.app')
@section('title') {{ __('dashboardMyAds.pageTitle') }} @endsection
@push('styles')
<style type="text/css">
  .blink_me {
    -webkit-animation-name: blinker;
    -webkit-animation-duration: 1s;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;

    -moz-animation-name: blinker;
    -moz-animation-duration: 1s;
    -moz-animation-timing-function: linear;
    -moz-animation-iteration-count: infinite;

    animation-name: blinker;
    animation-duration: 1s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
  }

  @-moz-keyframes blinker {
    0% {
      opacity: 1.0;
    }

    50% {
      opacity: 0.0;
    }

    100% {
      opacity: 1.0;
    }
  }

  @-webkit-keyframes blinker {
    0% {
      opacity: 1.0;
    }

    50% {
      opacity: 0.0;
    }

    100% {
      opacity: 1.0;
    }
  }

  @keyframes blinker {
    0% {
      opacity: 1.0;
    }

    50% {
      opacity: 0.0;
    }

    100% {
      opacity: 1.0;
    }
  }

  @media (max-width: 991px) {
    #car_data {
      margin-left: 10% !important;
    }

    .feature_span {
      width: 38% !important;
    }

    .feature_select {
      width: 30% !important;
    }
  }
</style>

{{-- Sweet Alert --}}
    <link href="{{asset('public/css/sweetalert.min.css')}}" rel="stylesheet" media="all">
 
@endpush

@section('content')
<?php use Carbon\Carbon;
$find = Session::get('ad_added');?>
<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
  @if(Auth::guard('customer')->user()->customer_role == 'business')
  @if(Auth::guard('customer')->user()->customer_company == null || Auth::guard('customer')->user()->customer_default_address == null || Auth::guard('customer')->user()->customers_telephone == null || Auth::guard('customer')->user()->customer_registeration == null || Auth::guard('customer')->user()->website == null || Auth::guard('customer')->user()->timings == null || Auth::guard('customer')->user()->citiy_id == null)
  <div class="blink_me text-danger text-center mb-2"><b>Please! Complete Your Profile</b></div>
  @endif
  @elseif(Auth::guard('customer')->user()->citiy_id == null)
  <div class="blink_me text-danger text-center mb-2"><b>Please! Complete Your Profile</b></div>
  @endif
  <div class="container">
    <div class="row ml-0 mr-0">
      @include('users.ads.profile_tabes')
    </div>

    <div class="tab-content profile-tab-content">
      <!-- Tab 1 starts here -->
      <div class="tab-pane active" id="profile-tab1">
        <div class="row ad-tab-row">
          <div class="ad-tab-sidebar col-lg-3 col-md-4">@include('users.ads.side_bar')</div>
          <div class="col-lg-9 col-md-8 mt-md-0 mt-4 pl-md-0 pl-lg-3 ad-tab-desc">
            <div class="tab-content">
              <div class="tab-pane active" id="ad-tab1">
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">{{__('dashboardMyAds.adInDisplay')}} <span id="ads_count">{{@$ads->count()}}</span> {{__('dashboardMyAds.adsListing')}}</h6>
                  </div>
                  <div class="display-ad-status">
                    <select name="ads_selector" id="ads_selector" class="form-control ads_selector form-control-sm">
                      <option value="1">{{__('dashboardMyAds.statusActive')}} ({{@$ads->count()}})</option>
                      <option value="0" {{@$find == 10 ? 'selected' : ''}}>{{__('dashboardMyAds.statusPending')}} ({{@$pending_ads->count()}})</option>
                      <option value="2">{{__('dashboardMyAds.statusRemoved')}} ({{@$removed_ads->count()}})</option>
                    </select>
                  </div>
                </div>
                <div class="bg-white border">
                  <div class="ads-listing-rows filtered_ads">
                    @if($ads->count() > 0)
                    @foreach($ads as $ad)
                    @php
                    $feature_status = App\Models\Customers\CustomerAccount::select('status')->where('customer_id',$ad->customer_id)->where('ad_id',@$ad->id)->where('type','car')->where('status',0)->orderBy('id','DESC')->get();
                    @endphp
                    <div class="row p-3 mx-0">
                      <figure class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                        @if(@$ad->ads_images[0]->img != null && file_exists( public_path() . '/uploads/ad_pictures/cars/'.$ad->id.'/'.@$ad->ads_images[0]->img))
                        <img src="{{url('public/uploads/ad_pictures/cars/'.$ad->id.'/'.@$ad->ads_images[0]->img)}}" alt="carish used cars for sale in estonia" class="img-fluid" style="max-height: 140px;">
                        @else
                        <img src="{{url('public/assets/img/caravatar.jpg')}}" alt="carish used cars for sale in estonia" class="img-fluid" style="max-height: 140px;">
                        @endif
                      </figure>
                      <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                        <h4><a target="" href="{{url('car-details/'.$ad->id)}}" target="">{{@$ad->maker->title}} {{@$ad->model->name}} {{@$ad->year}} {{@$ad->versions->label}}</a></h4>
                        <p class="ads-views mb-0"><em class="fa fa-eye"></em> {{$ad->views}} {{__('dashboardMyAds.viewCount')}}</p>
                        @if($ad->status == 1)
                        <p class="ads-views mb-0" style="color:#005e9b;"><strong>{{__('dashboardMyAds.statusActiveActiveUntil')}}</strong> {{$ad->active_until != null ? $ad->active_until : 'N.A'}}</p>
                        @endif
                      </div>
                      <div class="col-12 px-0 mt-3">
                        <div class="row align-items-sm-center">
                          <div class="col-lg-7 col-md-8 col-sm-8 mb-0 editProfile actionbtn ">
                            <ul class="list-unstyled mb-0">
                              @if($ad->status != 2)
                              <li class="list-inline-item"><a href="{{route('post.edit',['id'=>$ad->id])}}" class="border d-inline-block px-sm-3 px-2 py-1 rounded"> {{__('dashboardMyAds.statusActiveEdit')}} <em class=" ml-1 fa fa-pencil"></em></a></li>
                              @endif

                              <li class="list-inline-item"><a href="" class="border d-inline-block px-sm-3 px-2 py-1 rounded remove-ad" data-id="{{$ad->id}}"> {{__('dashboardMyAds.statusActiveRemove')}}<em class="ml-1 fa fa-trash"></em></a></li>

                              <li class="list-inline-item"><a href="#" class="d-none border px-sm-3 px-2 py-1 rounded">{{__('dashboardMyAds.inActive')}} <em class="ml-1 fa fa-refresh"></em></a></li>
                            </ul>
                          </div>
                          <div class="col-lg-5 col-md-4 col-sm-4 pt-3 pt-sm-0 featuredAd text-sm-right">
                            @if(@$ad->is_featured == 'false' && @$feature_status->count() == 0)
                            <a href="javascript:void(0)" data-id="{{@$ad->id}}" class="make_it_featured" data-toggle="modal" data-target="#featureModal">
                              <em class="fa fa-star"></em>
                              {{__('featureAdPopup.pageTitle')}}
                            </a>

                            @elseif(@$ad->is_featured == 'true')
                            <a href="javascript:void(0)" style="color: #0072BB;"><em class="fa fa-star"></em>
                              <span>{{__('dashboardMyAds.statusActiveFeatred')}}&nbsp &nbsp {{@$ad->feature_expiry_date !== null ? Carbon::parse(@$ad->feature_expiry_date)->format('d/m/Y H:i:s') : '--'}}</span></a>
                            @elseif(@$feature_status[0]->status == 0)
                            <a href="javascript:void(0)" style="color: #0072BB;"><em class="fa fa-star"></em>
                              <span>{{__('dashboardMyAds.waitingForPayment')}}</span></a>
                            @endif

                          </div>
                        </div>
                      </div>
                    </div>

                    @endforeach
                    @else
                    <div class="row p-3 mx-0">
                      <h5>{{__('dashboardMyAds.noAdFound')}}</h5>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Tab 1 ends here -->
    </div>
  </div>

  <!-- Feature Modal -->
  <div class="modal fade" id="featureModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="exampleModalLabel">{{__('featureAdPopup.pageTitle')}}</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="featured_request_form">
          {{csrf_field()}}
          <div class="modal-body">
            <div class="alert alert-danger alert-dismissable" id="carnumber-error" style="display:none">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <span class="carnumber-error" style="margin-left: 30px;"><strong>Error ! </strong>Please select number of days.</span>
            </div>
            <input type="hidden" name="ad_id" class="featured_ad_id">
            <div class="ad" style="padding: 0 20px;box-shadow: 0px 5px 0px 0px rgba('0,0,0,0.25');"></div>
            <div style="display:block;padding-left: 20px;margin-top: 20px">

            </div>
            <div class="input-group" id="car_data" style="border: none;margin-top: 40px;margin-left: 30%;">
              <span style="background-color: white;width: 17%;border-top-left-radius: 5px;border-bottom-left-radius: 5px;border: 1px solid #aaa;border-right: none;padding-left: 5px;line-height: 2;font-weight: 600;" class="feature_span">{{__('featureAdPopup.featureThisAdFor')}} </span>
              <select name="featured_days" id="featured_days" style="width: 20%;height: 33px;border-left: none;" class="feature_select">
                <option value="">***{{__('featureAdPopup.select')}} {{__('featureAdPopup.days')}}***</option>
                @foreach($ads_pricing as $pricing)
                    <option value="{{$pricing->number_of_days}}">{{$pricing->number_of_days}} {{__('featureAdPopup.days')}} {{$pricing->pricing}} €</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer" style="justify-content: center;border-top: none;">
            <button type="button" class="btn btn-danger" data-dismiss="modal" style="background-color: #eeefff;border: 1px solid #ccc;color: black;">{{__('featureAdPopup.exitButtonText')}}</button>
            <button type="submit" class="btn themebtn3">{{__('featureAdPopup.submitButtonText')}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- export pdf form starts -->
  <form class="export-quot-form" method="post" action="{{route('export-pdf')}}">
    @csrf
    <input type="hidden" name="invoice_number" class="invoice_number">
  </form>
  <!-- export pdf form ends -->

@php 
if(Request::has('status'))
  $ads_status = Request::get('status');
  else $ads_status =1;
@endphp
  @push('scripts')

  {{-- Sweet Alert --}}
    <script src="{{asset('public/js/sweetalert.min.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
    
      @if(Request::has('status'))
      var pending = "{{$pending_ads->count()}}";
      var removed = "{{$removed_ads->count()}}";
      var ads     = "{{$ads->count()}}";
      var val     = "{{$ads_status}}";

      $.ajax({
        url: "{{route('filter-ads')}}",
        method: "get",
        dataType: "json",
        data: {
          ads_status: val
        },
        beforeSend: function() {
          $("#overlay").fadeOut(300);
        },
        success: function(data) {
          $('.filtered_ads').html(data.html);
          if (val == 0) { 
            document.getElementById('ads_count').innerHTML = pending;
            $('#ads_selector [value=0]').attr('selected', 'true');
          }
          if (val == 2) {
            document.getElementById('ads_count').innerHTML = removed;
            $('#ads_selector [value=2]').attr('selected', 'true');
          }

          if (val == 1) {
            document.getElementById('ads_count').innerHTML = ads;
            $('#ads_selector [value=1]').attr('selected', 'true');
          }

        },
        error: function() {
          alert('Error');
        }

      });

      @endif

      @if(Session::has('ad_added'))
      toastr.success('Success!', "Ad Posted Successfully!!!", {
        "positionClass": "toast-bottom-right"
      });
      @endif
      @if(Session::has('ad_added'))
      var pending = "{{$pending_ads->count()}}";
      var removed = "{{$removed_ads->count()}}";
      var ads = "{{$ads->count()}}";
      var val = 0;
      $.ajax({
        url: "{{route('filter-ads')}}",
        method: "get",
        dataType: "json",
        data: {
          ads_status: val
        },
        beforeSend: function() {
          $("#overlay").fadeOut(300);
        },
        success: function(data) {

          $('.filtered_ads').html(data.html);
          if (val == 0) {
            document.getElementById('ads_count').innerHTML = pending;
            $('#ads_selector [value=0]').attr('selected', 'true');
          }
          if (val == 2) {
            document.getElementById('ads_count').innerHTML = removed;
            $('#ads_selector [value=2]').attr('selected', 'true');
          }

          if (val == 1) {
            document.getElementById('ads_count').innerHTML = ads;
            $('#ads_selector [value=1]').attr('selected', 'true');
          }

        },
        error: function() {
          alert('Error');
        }

      });
      @endif
      $('.ads_selector').change(function() {
        var pending = "{{$pending_ads->count()}}";
        var removed = "{{$removed_ads->count()}}";
        var ads = "{{$ads->count()}}";
        var val = $(this).val();
        $.ajax({
          url: "{{route('filter-ads')}}",
          method: "get",
          dataType: "json",
          data: {
            ads_status: val
          },
          beforeSend: function() {
            $("#overlay").fadeOut(300);
          },
          success: function(data) {

            $('.filtered_ads').html(data.html);
            if (val == 0) {
              document.getElementById('ads_count').innerHTML = pending;
            }
            if (val == 2) {
              document.getElementById('ads_count').innerHTML = removed;
            }

            if (val == 1) {
              document.getElementById('ads_count').innerHTML = ads;
            }

          },
          error: function() {
            alert('Error');
          }

        });
      });
      $(document).on('click', '.remove-ad', function(e) {
        e.preventDefault();
        var ad_id = $(this).data('id');
        swal({
            title: "{{__('dashboardMyAds.youSure')}}",
            text: "{{__('dashboardMyAds.youSureToRemove')}}",
            type: "error",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{__('dashboardMyAds.yesDo')}}",
            cancelButtonText: "{{__('dashboardMyAds.cancel')}}",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm) {
            if (isConfirm) {
              $.ajax({

                url: "{{route('remove-ad')}}",
                method: "get",
                dataType: "json",
                data: {
                  ad_id: ad_id
                },
                success: function(data) {
                  if (data.error == false) {
                    toastr.success('Success!', "{{__('dashboardMyAds.removedSuccess')}}", {
                      "positionClass": "toast-botom-right"
                    });
                    location.reload();
                  }
                },
                error: function() {
                  alert("{{__('dashboardMyAds.error')}}");
                }
              });
            } else {
              // swal("{{__('dashboardMyAds.cancelled')}}", "", "{{__('dashboardMyAds.error')}}");

            }
          });
      })
      $(document).on('click', '.resubmit-ad', function(e) {
        e.preventDefault();
        var ad_id = $(this).data('id');
        swal({
            title: "{{__('dashboardMyAds.youSure')}}",
            text: "{{__('dashboardMyAds.youSureToReactive')}}",
            type: "error",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{__('dashboardMyAds.yesDo')}}",
            cancelButtonText: "{{__('dashboardMyAds.cancel')}}",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm) {
            if (isConfirm) {
              $.ajax({
                url: "{{route('resubmit-ad')}}",
                method: "get",
                dataType: "json",
                data: {
                  ad_id: ad_id
                },
                success: function(data) {
                  if (data.error == false) {
                    toastr.success('Success!', "{{__('dashboardMyAds.reactiveSuccess')}}", {
                      "positionClass": "toast-botom-right"
                    });
                    location.reload();
                  }
                },
                error: function() {
                  alert("{{__('dashboardMyAds.error')}}");
                }
              });
            } 
          });
      })
      $(document).on('click', '.delete-ad', function(e) {
        e.preventDefault();
        var ad_id = $(this).data('id');
        swal({
            title: "{{__('dashboardMyAds.youSure')}}",
            text: "{{__('dashboardMyAds.youSureToRemove')}}",
            type: "error",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{__('dashboardMyAds.yesDo')}}",
            cancelButtonText: "{{__('dashboardMyAds.cancel')}}",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm) {
            if (isConfirm) {
              $.ajax({

                url: "{{route('delete-ad')}}",
                method: "get",
                dataType: "json",
                data: {
                  ad_id: ad_id
                },
                success: function(data) {
                  if (data.error == false) {
                    toastr.success('Success!', "{{__('dashboardMyAds.removedSuccess')}}", {
                      "positionClass": "toast-botom-right"
                    });
                    location.reload();
                  }
                },
                error: function() {
                  alert("{{__('dashboardMyAds.error')}}");
                }
              });
            } else {
              // swal("{{__('dashboardMyAds.cancelled')}}", "", "{{__('dashboardMyAds.error')}}");

            }
          });
      })
    });
    $('.make_it_featured').on('click', function() {
      var s = $(this).data('id'); 
      $('.featured_ad_id').val($(this).data('id'));

      $.ajax({
        url: "{{ route('get_ad_to_feature') }}",
        method: 'get',
        data: {
          id: s
        },
        beforeSend: function() {
          $("#overlay").fadeOut(300);
        },
        success: function(result) {
          $('.ad').html(result.html);
        },
        error: function(request, status, error) {

        }
      });
    });
    $(".featured_request_form").on('submit', function(e) {
      e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      // if($('input[name=use_balance]').is(':checked')){
      var featured_days = $('#featured_days').val();
      if (featured_days == '') {
        $("#carnumber-error").show();
        return false;
      } else {
        $("#carnumber-error").hide();
      }

      $.ajax({
        url: "{{ route('featured_ad') }}",
        method: 'post',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          $("#overlay").fadeOut(300);
        },
        success: function(result) {

          if (result.success === true) {
            toastr.success('Success!', 'Ad is featured successfully!', {
              "positionClass": "toast-bottom-right"
            });
            $('#featureModal').modal('hide');
            if (result.payment_status == 'partial') {
              $('.invoice_number').val(result.invoice_id);
              $('.export-quot-form')[0].submit();
            }
            //window.location.reload();
          }

          if (result.already_featured == true) {
            toastr.warning('Alert!', 'Ad is already featured!', {
              "positionClass": "toast-bottom-right"
            });
            $('#featureModal').modal('hide');
            window.location.reload();
          }


          if (result.request == true) {
            toastr.warning('Please!', 'Pay the required amount to featured your Ad!', {
              "positionClass": "toast-bottom-right"
            });
            $('.invoice_number').val(result.invoice_id2);
            $('.export-quot-form')[0].submit();
            $('#featureModal').modal('hide');
            // window.location.reload();

          }

          if (result.already_in_request == true) {
            toastr.warning('Alert!', 'Ad is already in request for featured!', {
              "positionClass": "toast-bottom-right"
            });
            $('#featureModal').modal('hide');
            window.location.reload();
          }
        },
        error: function(request, status, error) {

        }
      });
    });
  </script>
  @endpush
  @endsection