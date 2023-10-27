@extends('layouts.app')
@section('title') {{ __('dashboardMyAds.pageTitle') }} @endsection
@push('styles')
{{-- Sweet Alert --}}
<link href="{{asset('public/css/sweetalert.min.css')}}" rel="stylesheet" media="all"> 
@endpush
@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
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
              <div class="tab-pane active" id="ad-tab2">
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">{{__('dashboardMyAds.adInDisplay')}} <span id="ads_count">{{@$PartsAdsCount->count()}}</span> {{__('dashboardMyAds.adsListing')}}</h6>
                  </div>
                  @php
                  $status = 1;
                  @endphp
                  @if(!empty(request()->get('status')) || request()->get('status') == '0')
                  @php
                  $status = request()->get('status');
                  @endphp
                  @endif 
                  <div class="display-ad-status">
                    <select name="" class="form-control form-control-sm parts_selector">
                      <option value="1" @if($status=='1' ) selected @endif>{{__('dashboardMyAds.statusActive')}} ({{@$PartsAds->count()}})</option>
                      <option value="0" @if($status=='0' ) selected @endif>{{__('dashboardMyAds.statusPending')}} ({{@$pending_ads->count()}})</option>
                      <option value="2" @if($status=='2' ) selected @endif>{{__('dashboardMyAds.statusRemoved')}} ({{@$removed_ads->count()}})</option>
                    </select>
                  </div>
                </div>
                <div class="bg-white border">
                  <div class="ads-listing-rows filtered_ads">
                    @if($PartsAdsCount->count() > 0)
                    @foreach($PartsAdsCount as $p_ad)
                    @php
                    $feature_status = App\Models\Customers\CustomerAccount::where('customer_id',$p_ad->customer_id)->where('ad_id',@$p_ad->id)->where('type','sparepart')->where('status','0')->where('detail','feature sparepart')->orderBy('id','DESC')->get();

                    @endphp
                    <div class="row p-3 mx-0">
                      <figure class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                        @if(@$p_ad->get_one_image->img != null && file_exists( public_path() . '/uploads/ad_pictures/spare-parts-ad/'.$p_ad->id.'/'.@$p_ad->get_one_image->img))
                        <img src="{{url('public/uploads/ad_pictures/spare-parts-ad/'.@$p_ad->id.'/'.@$p_ad->get_one_image->img)}}" alt="carish used cars for sale in estonia" class="img-fluid ads_image">
                        @else
                        <img src="{{url('public/assets/img/sparepartavatar.jpg')}}" alt="carish used cars for sale in estonia" class="img-fluid ads_image">
                        @endif
                      </figure>
                      <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                        <h4><a href="{{url('spare-parts-details/'.$p_ad->id)}}" target="">
                            @php
                            $activeLanguage = \Session::get('language');
                            @endphp
                            {{$p_ad->get_sp_ad_title($p_ad->id,$activeLanguage['id'])}}</a></h4>
                        <p class="ads-views mb-0"><em class="fa fa-eye"></em> {{@$p_ad->views}} {{__('dashboardMyAds.viewCount')}}</p>
                        @if($p_ad->status == 1)
                        <p class="ads-views mb-0" style="color:#005e9b;"><strong>{{__('dashboardMyAds.statusActiveActiveUntil')}}</strong> {{$p_ad->active_until != null ? $p_ad->active_until : 'N.A'}}</p>
                        @endif
                      </div>
                      <div class="col-12 px-0 mt-3">
                        <div class="row align-items-sm-center">
                          <div class="col-lg-7 col-md-8 col-sm-8 mb-0 editProfile actionbtn ">
                            <ul class="list-unstyled mb-0">
                              <li class="list-inline-item"><a target="" href="{{url('user/spare-part-ad/'.@$p_ad->id)}}" class="border d-inline-block px-sm-3 px-2 py-1 rounded">{{__('dashboardMyAds.statusActiveEdit')}} <em class=" ml-1 fa fa-pencil"></em></a></li>

                              <li class="list-inline-item"><a href="" class="border d-inline-block px-sm-3 px-2 py-1 rounded remove-ad" data-id="{{$p_ad->id}}">{{__('dashboardMyAds.statusActiveRemove')}} <em class="ml-1 fa fa-trash"></em></a></li>

                              <!--  <li class="list-inline-item"><a href="javascript:void(0)" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Inactive <em class="ml-1 fa fa-refresh"></em></a></li> -->
                            </ul>
                          </div>
                          <div class="col-lg-5 col-md-4 col-sm-4 pt-3 pt-sm-0 featuredAd text-sm-right">
                            @if(@$p_ad->is_featured == 'false' && @$feature_status->count() == 0 && $p_ad->status == 1)
                            <a href="javascript:void(0)" data-id="{{@$p_ad->id}}" class="make_it_featured" data-toggle="modal" data-target="#featureModal"><em class="fa fa-star"></em> {{__('dashboardMyAds.statusActiveFeatreAd')}}</a>
                            @elseif(@$p_ad->is_featured == 'true')
                            <a href="javascript:void(0)" style="color: #0072BB;"><em class="fa fa-star"></em>
                              <span>{{__('dashboardMyAds.statusActiveFeatred')}} {{@$p_ad->feature_expiry_date !== null ? Carbon::parse(@$p_ad->feature_expiry_date)->format('d/m/Y H:i:s') : '--'}}</span></a>
                            @elseif(@$feature_status[0]->status == 0 && @$feature_status[0]->detail == 'feature sparepart')
                            <a href="javascript:void(0)" style="color: #0072BB;"><em class="fa fa-star"></em>
                              <span>{{__('dashboardMyAds.waitingForPayment')}}</span></a>
                            @elseif($p_ad->status == 5)
                            <a href="{{route('download-pdf')}}?ad_id={{$p_ad->id}}&type=sparepart_ad" style="color: #0072BB;"><em class="fa fa-star"></em>
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
          <h2 class="modal-title" id="exampleModalLabel">{{__('dashboardMyAds.statusActiveFeatreAd')}}</h2>
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
            <div class="ad" style="border: 1px solid #ddd;">

            </div>

            <div style="display:block;padding-left: 20px;margin-top: 20px"></div>
            <div class="input-group" id="car_data" style="border: none;margin-top: 40px;margin-left: 30%;">
              <!-- <img src="{{asset('public/assets/img/est-number.jpg')}}" align="image"> -->
              <span style="background-color: white;width: 25%;border-top-left-radius: 5px;border-bottom-left-radius: 5px;border: 1px solid #aaa;border-right: none;padding-left: 5px;line-height: 2;font-weight: 600;">{{__('featureAdPopup.featureThisAdFor')}} </span>
              <select name="featured_days" id="featured_days" style="width: 20%;height: 33px;border-left: none;">
                <option value=''>***{{__('featureAdPopup.select')}} {{__('featureAdPopup.days')}}***</option>
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
  <!-- Loader Modal -->
  <div class="modal" id="loader_modal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <h3 style="text-align:center;">{{ __('dashboardMyAds.pleaseWait') }}</h3>
          <p style="text-align:center;"><img src="{{ asset('public/assets/img/gif/waiting.gif') }}"></p>
        </div>
      </div>
    </div>
  </div>
@php 
  if(Request::has('status'))
    $ads_status = Request::get('status');
  else 
    $ads_status = 1;
@endphp
@push('scripts')
{{-- Sweet Alert --}}
    <script src="{{asset('public/js/sweetalert.min.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function() {

      @if(Request::has('status'))
          toastr.success('Success!', "Sparepart Posted Successfully!!!", {
              "positionClass": "toast-bottom-right"
            });
      var pending = "{{$pending_ads->count()}}";
      var removed = "{{$removed_ads->count()}}";
      var ads     = "{{$PartsAds->count()}}";
      var val     = "{{$ads_status}}";
          $.ajax({
            url: "{{route('filter-spare-parts')}}",
            method: "get",
            dataType: "json",
            data: {
              ads_status: val
            },
            beforeSend: function() {
              $('#loader_modal').modal('show');
            },
            success: function(data) {
              $('#loader_modal').modal('hide');
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

      @if(Session::has('spare_part'))
     toastr.success('Success!', "Sparepart Posted Successfully!!!", {
        "positionClass": "toast-bottom-right"
      });
      var pending = "{{$pending_ads->count()}}";
      var removed = "{{$removed_ads->count()}}";
      var ads     = "{{$PartsAds->count()}}";
      var val     = "{{$ads_status}}";
          $.ajax({
            url: "{{route('filter-spare-parts')}}",
            method: "get",
            dataType: "json",
            data: {
              ads_status: val
            },
            beforeSend: function() {
              $('#loader_modal').modal('show');
            },
            success: function(data) {
              $('#loader_modal').modal('hide');
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
      $(document).on('click', '.make_it_featured', function() {
        var s = $(this).data('id');
        $('.featured_ad_id').val($(this).data('id'));
        $.ajax({
          url: "{{ route('get_spare_part_to_feature') }}",
          method: 'get',
          data: {
            id: s
          },
          beforeSend: function() {
            $('#loader_modal').modal('show');
          },
          success: function(result) {
            $('.ad').html(result.html);
            $('#loader_modal').modal('hide');
          },
          error: function(request, status, error) {}
        });
      });
      $(".featured_request_form").on('submit', function(e) {
        e.preventDefault();
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });
        var featured_days = $('#featured_days').val();
        if (featured_days == '') {
          $("#carnumber-error").show();
          return false;
        } else {

          $("#carnumber-error").hide();
        }
        $.ajax({
          url: "{{ route('featured_spare_part') }}",
          method: 'post',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('#loader_modal').modal('show');
          },
          success: function(result) {

            if (result.success === true) {
              toastr.success('Success!', 'Spare Part is featured successfully!', {
                "positionClass": "toast-bottom-right"
              });
              $('#featureModal').modal('hide');

              if (result.payment_status == 'partial') {
                $('.invoice_number').val(result.invoice_id);
                $('.export-quot-form')[0].submit();
              }

            }

            if (result.already_featured == true) {
              toastr.warning('Alert!', 'Spare Part is already featured!', {
                "positionClass": "toast-bottom-right"
              });
              $('#featureModal').modal('hide');
            }


            if (result.request == true) {
              toastr.warning('Please!', 'Pay the required amount to featured your Spare Part!', {
                "positionClass": "toast-bottom-right"
              });
              $('.invoice_number').val(result.invoice_id2);
              $('.export-quot-form')[0].submit();
              $('#featureModal').modal('hide');
            }

            if (result.already_in_request == true) {
              toastr.warning('Alert!', 'Spare Part is already in request for featured!', {
                "positionClass": "toast-bottom-right"
              });
              $('#featureModal').modal('hide');
            }

            $('#loader_modal').modal('hide');
          },
          error: function(request, status, error) {

          }
        });
      });
      $(function() {
        $('.parts_selector').change(function() {
          var pending = "{{$pending_ads->count()}}";
          var removed = "{{$removed_ads->count()}}";
          var ads     = "{{$PartsAds->count()}}";
          var val     = $(this).val();
          $.ajax({
            url: "{{route('filter-spare-parts')}}",
            method: "get",
            dataType: "json",
            data: {
              ads_status: val
            },
            beforeSend: function() {
              $('#loader_modal').modal('show');
            },
            success: function(data) {
              $('#loader_modal').modal('hide');
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
        });

        @if(Session::has('spare_part'))
          $('.parts_selector').val('0').trigger('change');
          var payment = "{{Session::get('spare_part')}}";
          if (payment != '0') {
          $('.invoice_number').val("{{Session::get('spare_part')}}");
          $('.export-quot-form')[0].submit();
        }
        @endif
      });
      $(document).on('click', '.remove-ad', function(e) {
        e.preventDefault();
        var ad_id = $(this).data('id');
        swal({
            title: "Are You Sure?",
            text: "You want to Remove it!!!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, do it!",
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm) {
            if (isConfirm) {
              $.ajax({
                url: "{{route('remove-spare-part')}}",
                method: "get",
                dataType: "json",
                data: {
                  ad_id: ad_id
                },
                success: function(data) {
                  if (data.error == false) {
                    toastr.success('Success!', 'Ad Removed Successfully.', {
                      "positionClass": "toast-bottom-right"
                    });
                    location.reload();
                  }
                },
                error: function() {
                  alert('Error');
                }
              });
            } else {
              swal("Cancelled", "", "error");
            }
          });
      });
      $(document).on('click', '.resubmit-ad', function(e) {
        e.preventDefault();
        var ad_id = $(this).data('id');
        swal({
            title: "Are You Sure?",
            text: "You want to Re-submit it!!!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, do it!",
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm) {
            if (isConfirm) {

              $.ajax({
                url: "{{route('resubmit-spare-part')}}",
                method: "get",
                dataType: "json",
                data: {
                  ad_id: ad_id
                },
                success: function(data) {
                  if (data.error == false) {
                    toastr.success('Success!', 'Ad Goes For Verification Successfully.', {
                      "positionClass": "toast-bottom-right"
                    });
                    location.reload();
                  }
                },
                error: function() {
                  alert('Error');
                }
              });
            } else {
              swal("Cancelled", "", "error");
            }
          });
      });
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

                url: "{{route('delete-spare-part')}}",
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
      });
    });
  </script>
  @endpush
  @endsection