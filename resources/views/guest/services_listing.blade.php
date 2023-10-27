@extends('layouts.app')
@section('title') Update Profile @endsection
@push('styles')
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
 

  .hide_number {
    transition: all 5s;
    display: none !important;
  }
</style>
@endpush
@push('scripts')
<script type="text/javascript">
  $(document).ready(function() {

    CKEDITOR.replace( 'customer_message', {
              toolbar: ['/', 
                    { name: 'links', items: [ 'Link'] },
              ]
            });
            
      $(document).on('click', '.send-msg-btn', function () {
            // alert('hi');
            var id       = $(this).data('customer');
            var ads_id   = $(this).data('id');
            var ads_title =  $(this).data('ads_title');
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

                      $(".ads-title").html(ads_title);
                      $('#to_id').val(id);
                      $('#ad_id').val(ads_id);
                      $('#savedCarAd').modal('show');
                    }
                }
            });
        });
  });

  
  $('.saveAdCok').on('click', function() {
    //alert('fd');
    var id = $(this).data('id');
    window.location.href = "{{ url('user/login') }}";
  });

  $('.saveAd').on('click', function() {
    //alert('fd');
    var id = $(this).data('id');
    // alert(id);

    $.ajax({
      method: "get",
      dataType: "json",
      url: "{{url('user/save-ad')}}/" + id,

      success: function(data) {
        if (data.success == true) {
          // $('#save-success').css('display','block');
          $('#heart').css({
            'color': '#007bff',
            'transition': '0.5s all'
          });
          toastr.success('<a target="" href="{{url("user/my-saved-ads")}}" class="show_saved_ads">Show my saved ads </a>', 'Ad saved successfully.', {
            "positionClass": "toast-bottom-right"
          }, {
            timeOut: 5000
          });
          location.reload();

        }
        if (data.success == false) {
          $('#heart,#heart2').css({
            'color': 'gray',
            'transition': '0.5s all'
          });
          toastr.error('<a target="" href="{{url("user/my-saved-ads")}}" class="show_saved_ads">Show my saved ads </a>', 'Ad removed successfully.', {
            "positionClass": "toast-bottom-right"
          }, {
            timeOut: 5000
          });
          location.reload();


        }

      }
    });

  });
</script>
@endpush
@section('content')
<div class="internal-page-content mt-4 sects-bg">
  <div class="container">
    <div class="row ml-0 mr-0">
      <div class="col-12 mt-md-5 mt-4 bg-white border p-md-4 p-3">
        <div class="align-items-center row">
          <div class="col-xl-2 col-lg-2 col-md-2 pr-sm-3 pr-md-0 text-center">
            @if(@$customer->logo != null && file_exists( public_path() . '/uploads/customers/logos/'.$customer->logo))
            <img src="{{asset('public/uploads/customers/logos/'.@$customer->logo)}}" class="img-fluid rounded-circle" alt="Profile" style="width: 200px;height: 210px;">
            @else
            <img src="{{url('public/assets/img/avatar1_1599061055.png')}}" class="img-fluid w-100 rounded-circle" alt="Profile">
            @endif
          </div>
          <div class="col-xl-10 col-lg-10 col-md-10 mt-md-0 mt-4">
            <div class="align-items-md-center row">
              <div class="col-xl-8 col-lg-7 col-sm-6 pr-lg-3 pr-md-0 user-profile">
                <div class="align-items-center d-flex mb-2">
                  <h4 class="mb-0 themecolor">{{@$customer->customer_company}}</h4>
                  <span class="badge badge-pill badge-success d-inline-block ml-3 p-1 pl-2 pr-2"><em class="fa fa-check-circle mr-2"></em> {{__('common.verified')}} </span>
                </div>
                <p class="mb-0 mb-2 member-from">{{__('profile.member_since')}} {{$customer->created_at->format('M-Y-D')}}</p>
               
                <table>
                  <tbody>
                    @foreach(@$timings as $timing)
                    <tr>
                      <td><em class="fa fa-clock-o themecolor"></em></td>
                      <td>{{@$timing->day_name}}</td>
                      <td>{{@$timing->opening_time}} - {{@$timing->closing_time}}</td>
                    </tr>
                    @endforeach

                  </tbody>
                </table>
              </div>
              <div class="col-xl-4 col-lg-5 col-sm-6 mt-sm-0 mt-3 user-profile-detail">
                <ul class="list-unstyled mb-0">
                  <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span> {{@$customer->customer_default_address}}</li>
                  <li class="d-flex"><span class="mr-2"><em class="fa fa-phone"></em></span> {{@$customer->customers_telephone}}</li>
                  <li class="d-flex"><span class="mr-2"><em class="fa fa-globe"></em></span> <a href="#">{{@$customer->website}}</a></li>
                  {{-- <li class="d-flex"><span class="mr-2"><em class="fa fa-tag"></em></span> Lorem Ipsum is simply dummy text of the printing and typesetting.</li> --}}
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-md-2 mt-2">
      <div class="col-12">

      </div>
      <!-- right content section starts here -->
      <div class="col-12 right-content">
        <!-- sorting and listing/grid section start here -->
        <div class="sortingsection bg-white border">
          <div class="align-items-center ml-0 mr-0 pb-3 pt-3 row">
            <div class="col-md-6 col-md-6 col-sm-6 mb-sm-0 mb-3 sorting-col"> 
              <h4 class="mb-0">{{__('common.recent_car_ads')}}</h4>
            </div>
            <div class="col-md-6 col-sm-6 d-flex list-grid-col">
              <ul class="ml-auto mb-0">
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
              </ul>
            </div>
          </div>
        </div>
        <!-- sorting and listing/grid section ends here -->
        <div class="row">
          <div class="col-lg-3 col-md-4 col-md-4ad-tab-sidebar mt-3">
            <div class="bg-white border p-3">
                   
   <ul class="nav nav-tabs nav-pills d-block text-capitalize sidebar-pills my-ad-tabs">
    <li class="nav-item">
      <a class="nav-link d-flex "  href="{{route('company_profile',["id"=>$customer->id])}}">
       <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
        <img src="{{url('public/assets/img/adtab-car.png')}}" class="img-fluid none-active-img" alt="icon image">
        <img src="{{url('public/assets/img/adtab-active-car.png')}}" class="img-fluid active-img" alt="icon image">
      </figure> 
      <span>{{__('common.car')}} {{$ads->count()}}</span>
      </a>
    </li>
    <li class="nav-item">
    <a class="nav-link d-flex active"  href="{{route('company_spareparts',["id"=>$customer->id])}}">
      <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
      <img src="{{url('public/assets/img/adtab-parts.png')}}" class="img-fluid none-active-img" alt="icon image">
      <img src="{{url('public/assets/img/adtab-active-parts.png')}}" class="img-fluid active-img" alt="icon image">
    </figure> <span>{{__('common.parts')}} {{$PartsAds->count()}} </span></a>
  </li>
    @if($customer->customer_role == 'business')
    
    <li class="nav-item">
      <a class="nav-link d-flex"  href="{{route('company_services',["id"=>$customer->id])}}">
        <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
        <img src="{{url('public/assets/img/adtab-offer-services.png')}}" class="img-fluid none-active-img" alt="icon image">
        <img src="{{url('public/assets/img/adtab-active-offer-services.png')}}" class="img-fluid active-img" alt="icon image">
      </figure> <span>{{__('common.offer_services')}} {{$services->count()}} </span></a>
    </li>
    @endif
  </ul>
  
            </div>
          </div>
          @php 

$activeLanguage = \Session::get('language');
          @endphp
          <!-- listing view starts here -->
          <div class="listingtab col-lg-9 col-md-8">  
          @if($PartsAds->count() > 0)
            @foreach($PartsAds as $p_ad)
             @php 
                $feature_status  = App\Models\Customers\CustomerAccount::select('status')->where('ad_id',@$p_ad->id)->where('type','sparepart')->where('status',0)->where('detail','feature sparepart')->get();
                $sub_category    = @$p_ad->category->parent_id;
                $parent_category = App\SparePartCategory::where('id', $sub_category)->first();  
                $p_caty          = ($parent_category->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first());
                $caty            = ($p_ad->category->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title'));
           
            @endphp

            <div class="bg-white border col-12 dealer-listing-Col mb-3 p-2 pr-3">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 pr-2 pl-md-3 car-dealer-img">
                          <figure class="mb-0 position-relative">
                    <a href="javscript:void()">
                      @if(@$p_ad->get_one_image->img != null && file_exists( public_path() . '/uploads/ad_pictures/spare-parts-ad/'.$p_ad->id.'/'.@$p_ad->get_one_image->img))
                      <img src="{{url('public/uploads/ad_pictures/spare-parts-ad/'.@$p_ad->id.'/'.@$p_ad->get_one_image->img)}}" class="img-fluid" alt="carish used cars for sale in estonia" width="170px" style="height: 150px;">
                      @else
                      <img src="{{url('public/assets/img/serviceavatar.jpg')}}" class="img-fluid" alt="carish used cars for sale in estonia" width="170px" style="height: 150px;">
                      @endif
                    </a>
                    <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                      @if(@$p_ad->is_featured == 'false' && @$feature_status->count() == 0)
                      <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block mt-2">{{__('search.featured')}}</span>
                      @endif
                      <span class="d-inline-block pb-1 pl-2 pr-2 pt-1 viewgallery"><em
                                            class="fa fa-camera mr-1"></em>{{@$p_ad->spare_parts_images !== null ? @$p_ad->spare_parts_images->count() : '0'}}</span>
                    </figcaption>
                  </figure>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-6 car-dealer-list-desc pt-2">
                            <div class="align-items-center d-flex">
                  <h5 class="font-weight-semibold mb-0">
                      <a target="" href="{{url('spare-parts-details/'.$p_ad->id)}}" target="">
                        {{$p_ad->title}}</a></h5>
                    <span class="lcPrice d-inline-block ml-3 font-weight-semibold">
                     €{{@$p_ad->price}}</span>
                     <span class="badge badge-pill badge-success d-inline-block ml-2 p-1 pr-2" style="display: none !important;"><em class="fa fa-check-circle mr-2"></em>VERIFIED</span>
                            </div>
                            <div class="dealer-place-cont align-items-center d-flex mb justify-content-between mb-md-3 mb-2">
                                <span class="cprice d-inline-block mr-2">{{$p_ad->city->name}}</span>

                            </div>
                            
                  <div class="align-items-center d-flex justify-content-between aboutcarlist mb-3">
                           <ul class="list-unstyled mb-0" style="opacity: 0.5">
                              <li class="list-inline-item">{{$p_caty}}</li>
                              <span>|</span>
                           <li class="list-inline-item">{{$caty[0]}}</li>
                           </ul>
                           <span></span>
                        </div>

                            <div class="dealer-place-cont align-items-center d-flex mb justify-content-between last-updated">
                                <span class="cprice d-inline-block mr-2">
                                   @php
                        $updated_at = \Carbon\Carbon::parse($p_ad->updated_at);
                        $now  = \Carbon\Carbon::now();
                        $diff = $updated_at->diffInDays($now); 
                        @endphp
                        {{__('search.updated')}} {{$diff}} {{__('search.days_ago')}}</span>

                            </div>
                        </div>


                        <div class="col-lg-4 col-md-4 col-sm-4 col-3 car-dealer-list-desc pt-2" style="text-align: right;">
                            <ul class="list-unstyled mb-0 font-weight-semibold">
                                <li class="align-items-baseline mb-0"><span class="mr-2">
                                        <h4 class="font-weight-semibold mr-2 cr-list-title">€{{@$p_ad->price}} 
                                        </h4>
                                </span></li>                                <li class="align-items-baseline mb-4"><span class="mr-2">
                                        <p class="font-weight-semibold mb-1">
                                        
                                          <span class="cprice d-inline-block mr-2 text-danger">   {{@$p_ad->neg != null ? __('common.negotiable') : ''}}

                                        </span>
                                      </p>
                                </span></li>
                                
                                <div class="ph-num-li-2">



                                 <li class="align-items-baseline">
                                   <span class="mr-2">
                                        <p class="font-weight-semibold mb-0 mt-4">
                                            <span class="cprice d-inline-block mr-2">
                                               @if(Auth::guard('customer')->user())
                      <a data-customer="{{$p_ad->customer_id}}" data-id="{{$p_ad->id}}"  data-ads_title="{{$p_ad->title}}" href="javascript:void(0)"  class="btn contactbtn themebtn3 show_phone_no send-msg-btn"><em
                                        class="fa fa-envelope"></em> {{ __('ads.send_message') }}</a>
                                @else
                                <a target="" href="{{url('user/login')}}"
                                    class="btn contactbtn themebtn3 show_phone_no"><em
                                        class="fa fa-envelope"></em> {{ __('ads.send_message') }}</a>
                                @endif</span>

                                        </p>
                                    </span></li>
                                    <li class="align-items-baseline pr-2">
 @if(Auth::guard('customer')->user())
                      @php
                      $saved = \App\UserSavedAds::where('ad_id',$p_ad->id)->where('customer_id',@Auth::guard('customer')->user()->id)->first();
                      @endphp
                      @if(@$saved != null)
                      @php $id = 'heart2'; @endphp
                      @else
                      @php $id = 'heart'; @endphp
                      @endif
                      <a href="javascript:void(0)" class="saveAd saveAdBtn d-inline-block mr-2" data-id="{{$p_ad->id}}"><em id="{{$id}}" class="fa fa-heart lc-favorite p-2" style="font-size: 16px;"></em> Save</a>
                      @else
                      @if(@$checkSaved != null)
                      @php $id = 'heart4'; @endphp
                      @else
                      @php $id = 'heart3'; @endphp
                      @endif
                      <a href="javascript:void(0)" class="saveAdCok saveAdBtn d-inline-block mr-2" data-id="{{$p_ad->id}}"><em id="heart3" class="fa fa-heart lc-favorite p-2" style="font-size: 16px;"></em> Save</a>
                      @endif </li>
                                </div>    
                                
                                

                            </ul> 
                        </div>



                    </div>
                </div>
 
            @endforeach

            @else
            <div class="bg-white col-lg-12 mt-2">
              <h2 class="p-4 text-center">{{__('ads.no_cars_found')}}</h2>
            </div>
            @endif
          </div>

        <!--   <div class="col-12 mt-lg-4 pl-0 pr-0">
            <div class="p-md-4 p-3 notifyForm detail-page-notifyform" style=" background: #E4E4E4;">
              <div class="row align-items-center">
                <div class="col-lg-5 col-12 mb-lg-0 mb-3">
                  <h5 class="themecolor"><em class="fa fa-bell"></em> {{__('ads.notify_me')}}</h5>
                  <p class="mb-0">{{__('ads.set_your_alerts_for')}} <strong>{{@$customer->customer_company}}</strong> {{__('ads.and_we_will_email_you_relevant_ads')}} </p>
                </div>
                <div class="col-lg-7 col-12">
                  <form>
                    <div class="row form-row">
                      <div class="col-sm-5 mb-md-0 mb-3 form-group">
                        <input type="text" name="" placeholder="{{__('common.type_our_email_address')}}" class="form-control">
                      </div>
                      <div class="col-sm-4 mb-md-0 mb-3 form-group">
                        <select name="selectCity" class="form-control">
                          <option value="">{{__('ads.daily')}}</option>
                          <option value="">{{__('ads.weekly')}}</option>
                          <option value="">{{__('ads.monthly')}}</option>
                          <option value="">{{__('ads.hourly')}}</option>
                        </select>
                      </div>
                      <div class="col-sm-3 mb-md-0 mb-3 form-group notifySubCol">
                        <input type="submit" value="{{__('home.submit')}}" class="btn btn-block border-0 text-white notifySubBtn ">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div> -->
        </div>
        <!-- listing view ends here -->
        <div class="view-car-by text-right mt-lg-5 mt-4 d-none">
          <a href="#" class="themecolor">View all cars by H&A Motors</a>
        </div>
        <div class="bg-white border mt-4 p-4 write-review d-none">
          <div class="align-items-center d-flex justify-content-between mb-4">
            <div class="review-title">
              <h5>Reviews</h5>
            </div>
            <div class="review-title">
              <a href="#" class="btn themebtn2">Write review</a>
            </div>
          </div>
          <div class="posted-review-row">
            <div class="posted-review">
              <h6 class="themecolor mb-0">About H&A Motors</h6>
              <p class="review-posted-time">Posted by H&A Motors Sep 02, 2019</p>
              <figure class="mb-3"><img src="{{url('public/assets/img/review-stars.png')}}" class="d-block img-fluid" alt="review stars"></figure>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>

              <div class="mt-4"><a href="#" class="font-weight-semibold themecolor">Report</a></div>
            </div>
            <div class="posted-review">
              <h6 class="themecolor mb-0">About H&A Motors</h6>
              <p class="review-posted-time">Posted by H&A Motors Sep 02, 2019</p>
              <figure class="mb-3"><img src="{{url('public/assets/img/review-stars.png')}}" class="d-block img-fluid" alt="review stars"></figure>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>

              <div class="mt-4"><a href="#" class="font-weight-semibold themecolor">Report</a></div>
            </div>
          </div>
        </div>

        <div class="align-items-center d-sm-flex justify-content-around mt-md-5 mt-4 pt-2 pt-sm-3 postAdRow" style="width: 100%">
          <div class="sellCarCol d-none d-md-block">
            <img src="{{url('public/assets/img/sell-car.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
          </div>
          <div class="pl-md-3 pr-md-3 sellCartext text-center">
            <img src="{{url('public/assets/img/sell-arrow-left.png')}}" class="d-md-block d-none img-fluid mr-auto  sell-arrow-left" alt="carish used cars for sale in estonia">
            <h4 class="mb-0">{{__('search.post_an_ad_for')}} <span class="themecolor2">{{__('compare.free')}}</span></h4>
            <p class="mb-0">{{__('search.sell_it_faster_to_thousands')}}</p>
            <img src="{{url('public/assets/img/sell-arrow-right.png')}}" class="d-sm-block d-none img-fluid ml-auto sell-arrow-right" alt="carish used cars for sale in estonia">
          </div>
          <div class="sellCarBtn">
            <a target="" href="{{url('user/post-ad')}}" class="btn themebtn1" target="">{{__('common.sell_your_car')}}</a>
          </div>
        </div>

      </div>
      <!-- right content section ends here -->
    </div>
  </div>
</div>


<!-- Modal for car1 -->
<div class="modal fade" id="savedCarAd" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg mobile-modal" role="document" style="border-radius: 10px;margin: auto;">
        <div class="modal-content bgwhite" style="border-radius: 10px;">
            <div class="modal-header pl-md-4 pr-md-4">
                <h5 class="modal-title" style="color: black;">{{ __('ads.send_message_to_seller') }}</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: red;">×</span>
                </button>
            </div>
            <form action="{{route('send-message-to-customer')}}" method="post" class="send_msg_form">
                <div class="modal-body comp-modal-body pl-md-4 pr-md-4 pb-4">
                    @csrf
                    <div class="row" style="font-weight: 600;color: #333;">
                        <div class="col-lg-3">{{ __('common.title') }}</div>
                        <div class="col-lg-8 ads-title" > {{@$title !== null ? @$title : @$spare_parts->title}} </div>
                    </div>
                    <br>

                    <div class="row" style="font-weight: 600;color: #333;">
                        <div class="col-lg-3">{{ __('ads.your_name') }}<span style="color: red;">*</span> </div>
                        <div class="col-lg-8">{{@$user->customer_company}}</div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-lg-3" style="font-weight: 600;color: #333;">{{ __('ads.your_message') }}<span
                                style="color: red;">*</span></div>
                        <div class="col-lg-7">
                            <textarea class="form-control customer_message" name="customer_message" id="customer_message" cols="8"
                                rows="7" required style="resize: none;box-shadow: 0 0 2px 0 rgba(51,51,51,0.1);"
                                id="ex3">{{ __('ads.hi_i_am_interested_in_your_car') }} <b>{{@$title !== null ? @$title : @$spare_parts->title}}</b> {{ __('ads.advertised_on') }} <a href="https://carish.ee/">Cairsh</a>. {{ __('ads.please_let_me_know_if_it_still_available') }}<br>
              Thanks.</textarea>
                        </div>
                    </div>

                </div>
    @php 
    $user   = Auth::guard('customer')->user();
    @endphp 
                <div class="modal-footer text-center justify-content-center">
                    <input type="hidden" name="to_id" id="to_id" value="">
                    <input type="hidden" name="from_id" value="{{@$user->id}}">
                    <input type="hidden" name="ad_id" id="ad_id" value="">
                    <input type="hidden" name="type" value="sparepart">
                    <input type="submit" class="btn themebtn1 send_btn" value="{{ __('common.send') }}">

                </div>
            </form>


        </div>
    </div>
</div>

@stop