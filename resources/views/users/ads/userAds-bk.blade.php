@extends('layouts.app')

@section('content')
{{-- <div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-2">
            <img src="data:image/png;base64,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" style="width: 100%">
        </div>
        <div class="col-md-8">
            <h1>{{Auth::guard('customer')->user()->customer_company}}</h1>
            <p>Member Since {{date('M dS, Y', strtotime(Auth::guard('customer')->user()->created_at))}}</p>
            <a href="#">Edit profile</a> | <a href="#">Change Password</a>
        </div>
    </div>

    <div class="row" style="margin-top: 50px;">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">My Ads</a></li>
                <li><a data-toggle="tab" href="#home1">My Spare Parts Ads</a></li>
                <li><a data-toggle="tab" href="#menu1">My Saved Ads</a></li>

            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    @foreach($ads as $ad)
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-2 col-md-offset-2">
                            <img src="{{url('public/ads/cars/'.Auth::guard('customer')->user()->id.'/'.\App\AdImage::where('ad_id',$ad->id)->first()->img)}}" style="width: 100%">
                        </div>
                        <div class="col-md-8">
                            <h1>{{\App\Year::find($ad->year_id)->title}} {{\App\Car::find($ad->maker_id)->title}} {{\App\Car::find($ad->model_id)->title}}</h1>
                            <p>Posted : {{date('M dS, Y', strtotime($ad->created_at))}}</p>
                            <p><i class="fa fa-eye"></i> {{$ad->views}}</p>
                            @if($ad->status == 0)
                                <label class="label label-warning">Pending</label>
                            @elseif($ad->status == 1)
                                <label class="label label-info">Approved</label>
                                <a class="label label-success" href="{{url('publish-ad/'.$ad->id)}}">Publish</a>
                            @elseif($ad->status == 2)
                                <label class="label label-success">Published</label>
                                <a class="label label-danger" href="{{url('un-publish-ad/'.$ad->id)}}">Un-Publish</a>

                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <div id="home1" class="tab-pane fade in">
                    @foreach($PartsAds as $ad)
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-2 col-md-offset-2">
                            <img src="{{url('public/spare-parts-ads/'.Auth::guard('customer')->user()->id.'/'.\App\AdImage::where('ad_id',$ad->id)->first()->img)}}" style="width: 100%">
                        </div>
                        <div class="col-md-8">
                            <h1>{{$ad->title}}</h1>
                            <h4>{{$ad->category->title}}</h4>
                            <p>Posted : {{date('M dS, Y', strtotime($ad->created_at))}}</p>
                            <p><i class="fa fa-eye"></i> {{$ad->views}}</p>
                            @if($ad->status == 0)
                                <label class="label label-warning">Pending</label>
                            @elseif($ad->status == 1)
                                <label class="label label-info">Approved</label>
                                <a class="label label-success" href="{{url('publish-ad/'.$ad->id)}}">Publish</a>
                            @elseif($ad->status == 2)
                                <label class="label label-success">Published</label>
                                <a class="label label-danger" href="{{url('un-publish-ad/'.$ad->id)}}">Un-Publish</a>

                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <div id="menu1" class="tab-pane fade">
                    @foreach($saveAds as $ad)
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-2 col-md-offset-2">
                            <img src="{{url('public/ads/'.Auth::guard('customer')->user()->id.'/'.\App\AdImage::where('ad_id',$ad->ads->id)->first()->img)}}" style="width: 100%">
                        </div>
                        <div class="col-md-8">
                            <h1>{{\App\Year::find($ad->ads->year_id)->title}} {{\App\Car::find($ad->ads->maker_id)->title}} {{\App\Car::find($ad->ads->model_id)->title}}</h1>
                            <p>Posted : {{date('M dS, Y', strtotime($ad->ads->created_at))}}</p>
                            <p><i class="fa fa-eye"></i> {{$ad->ads->views}}</p>
                             @php
                            if(\Illuminate\Support\Facades\Auth::user())
                            {
                                $saved_ads = \App\UserSavedAds::where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->pluck('ad_id')->toArray();
                            }
                            else
                            {
                                $saved_ads = [];
                            }
                            @endphp
                            @if(!in_array($ad->ads->id,$saved_ads))
                            <p><a target="" href="{{url('save-ad/'.$ad->ads->id)}}"><i class="fa fa-heart"></i> Save Ad</a></p>
                            @else
                            <p><i class="fa fa-heart" style="color: red"></i> Saved</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div> 
 --}}

<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
  <div class="container">
    <div class="row ml-0 mr-0">
      <div class="col-12 bg-white border mb-md-5 mb-4 p-0">
          <div class="row align-items-md-center p-md-4 p-3 pb-xl-5 mx-0">
             <div class="col-lg-2 col-sm-3 col-3 pr-2 pl-0 user-profile-img">
               <!-- <img src="assets/img/userprofile.jpg" class="img-fluid" alt="profile image"> -->
            <img src="data:image/png;base64,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" style="width: 100%">

             </div>  
             <div class="col-lg-10 col-sm-9 col-9 pl-md-3 pl-2 pr-0 cprofile-desc">
               <h3 class="mb-sm-2 mb-1">{{Auth::guard('customer')->user()->customer_company != null?Auth::guard('customer')->user()->customer_company:'Here is the company name'}}</h3>
               <p class="mb-sm-2 mb-1 font-weight-semibold member-time">Member Since {{date('M dS, Y', strtotime(Auth::guard('customer')->user()->created_at))}}</p>
               <ul class="list-unstyled themecolor font-weight-semibold mb-0">
                 <li class="list-inline-item"><a href="#">Edit Profile</a></li>
                 <li class="list-inline-item"><a href="#">Change Password</a></li>
               </ul>
             </div>         
          </div>  
         @include('users.ads.profile_tabes')
      </div>
      </div>

      <div class="tab-content profile-tab-content">
      <!-- Tab 1 starts here -->
        <div class="tab-pane" id="profile-tab1">
            <div class="row ad-tab-row">
              <div class="ad-tab-sidebar col-lg-3 col-md-4">
                <div class="bg-white border p-3">
                   <ul class="nav nav-tabs nav-pills d-block text-capitalize sidebar-pills my-ad-tabs">
                    <li class="nav-item">
                      <a class="nav-link active d-flex" data-toggle="tab" href="#ad-tab1">
                       <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="{{url('public/assets/img/adtab-car.png')}}" class="img-fluid none-active-img" alt="icon image">
                        <img src="{{url('public/assets/img/adtab-active-car.png')}}" class="img-fluid active-img" alt="icon image">
                      </figure> <span>Car</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link d-flex" data-toggle="tab" href="#ad-tab2">
                        <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="{{url('public/assets/img/adtab-parts.png')}}" class="img-fluid none-active-img" alt="icon image">
                        <img src="{{url('public/assets/img/adtab-active-parts.png')}}" class="img-fluid active-img" alt="icon image">
                      </figure> <span>parts</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link d-flex" data-toggle="tab" href="#ad-tab3">
                        <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="{{url('public/assets/img/adtab-offer-services.png')}}" class="img-fluid none-active-img" alt="icon image">
                        <img src="{{url('public/assets/img/adtab-active-offer-services.png')}}" class="img-fluid active-img" alt="icon image">
                      </figure> <span>offer services</span></a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-9 col-md-8 mt-md-0 mt-4 pl-md-0 pl-lg-3 ad-tab-desc">
               <div class="tab-content"> 
               <div class="tab-pane active" id="ad-tab1"> 
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">Displaying 1 ad listing</h6>
                  </div>
                  <div class="display-ad-status">
                    <select name="" class="form-control form-control-sm">
                      <option value="">Active (1)</option>
                      <option value="">Pending (1)</option>
                      <option value="">Removed (0)</option>
                    </select>
                  </div>
                </div>
                <div class="bg-white border">
                  <div class="ads-listing-rows">
                     @foreach($ads as $ad)
                    <div class="row p-3 mx-0">
                    <figure class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                      <img src="{{url('public/ads/cars/'.Auth::guard('customer')->user()->id.'/'.\App\AdImage::where('ad_id',$ad->id)->first()->img)}}" alt="carish used cars for sale in estonia" class="img-fluid">
                    </figure> 
                    <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                      <h4><a href="#">{{\App\Year::find($ad->year_id)->title}} {{\App\Car::find($ad->maker_id)->title}} {{\App\Car::find($ad->model_id)->title}}</a></h4>
                      <p class="ads-views mb-0"><em class="fa fa-eye"></em> 0 Views</p>
                    </div>
                    <div class="col-12 px-0 mt-3">
                      <div class="row align-items-sm-center">
                    <div class="col-lg-7 col-md-8 col-sm-8 mb-0 editProfile actionbtn ">
                      <ul class="list-unstyled mb-0">
                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Edit <em class=" ml-1 fa fa-pencil"></em></a></li>

                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Remove <em class="ml-1 fa fa-trash"></em></a></li>

                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Inactive <em class="ml-1 fa fa-refresh"></em></a></li>
                      </ul>
                    </div>
                    <div class="col-lg-5 col-md-4 col-sm-4 pt-3 pt-sm-0 featuredAd text-sm-right">
                      <a href="#"><em class="fa fa-star"></em> Feature this ad</a>
                    </div>
                  </div>
                    </div>
                  </div>
                    @endforeach


                  <div class="row p-3 mx-0">
                    <figure class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                      <img src="{{url('public/assets/img/featured-used-car-2.jpg')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                    </figure> 
                    <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                      <h4><a href="#">Toyota Corolla</a></h4>
                      <p class="ads-views mb-0"><em class="fa fa-eye"></em> 0 Views</p>
                    </div>
                    <div class="col-12 px-0 mt-3">
                      <div class="row align-items-sm-center">
                    <div class="col-lg-7 col-md-8 col-sm-8 mb-0 editProfile actionbtn ">
                      <ul class="list-unstyled mb-0">
                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Edit <em class=" ml-1 fa fa-pencil"></em></a></li>

                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Remove <em class="ml-1 fa fa-trash"></em></a></li>

                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Inactive <em class="ml-1 fa fa-refresh"></em></a></li>
                      </ul>
                    </div>
                    <div class="col-lg-5 col-md-4 col-sm-4 pt-3 pt-sm-0 featuredAd text-sm-right">
                      <a href="#"><em class="fa fa-star"></em> Feature this ad</a>
                    </div>
                  </div>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="ad-tab2"> 
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">Displaying 1 ad listing</h6>
                  </div>
                  <div class="display-ad-status">
                    <select name="" class="form-control form-control-sm">
                      <option value="">Active (1)</option>
                      <option value="">Pending (1)</option>
                      <option value="">Removed (0)</option>
                    </select>
                  </div>
                </div>
                <div class="bg-white border">
                  <div class="ads-listing-rows">
                  <div class="row p-3 mx-0">
                    <figure class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                      <img src="assets/img/spare-part-4.jpg" alt="carish used cars for sale in estonia" class="img-fluid">
                    </figure> 
                    <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                      <h4><a href="#">Carrera Wax</a></h4>
                      <p class="ads-views mb-0"><em class="fa fa-eye"></em> 0 Views</p>
                    </div>
                    <div class="col-12 px-0 mt-3">
                      <div class="row align-items-sm-center">
                    <div class="col-lg-7 col-md-8 col-sm-8 mb-0 editProfile actionbtn ">
                      <ul class="list-unstyled mb-0">
                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Edit <em class=" ml-1 fa fa-pencil"></em></a></li>

                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Remove <em class="ml-1 fa fa-trash"></em></a></li>

                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Inactive <em class="ml-1 fa fa-refresh"></em></a></li>
                      </ul>
                    </div>
                    <div class="col-lg-5 col-md-4 col-sm-4 pt-3 pt-sm-0 featuredAd text-sm-right">
                      <a href="#"><em class="fa fa-star"></em> Feature this ad</a>
                    </div>
                  </div>
                    </div>
                  </div>
                  <div class="row p-3 mx-0">
                    <figure class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                      <img src="assets/img/spare-part-4.jpg" alt="carish used cars for sale in estonia" class="img-fluid">
                    </figure> 
                    <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                      <h4><a href="#">Carrera Wax</a></h4>
                      <p class="ads-views mb-0"><em class="fa fa-eye"></em> 0 Views</p>
                    </div>
                    <div class="col-12 px-0 mt-3">
                      <div class="row align-items-sm-center">
                    <div class="col-lg-7 col-md-8 col-sm-8 mb-0 editProfile actionbtn ">
                      <ul class="list-unstyled mb-0">
                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Edit <em class=" ml-1 fa fa-pencil"></em></a></li>

                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Remove <em class="ml-1 fa fa-trash"></em></a></li>

                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Inactive <em class="ml-1 fa fa-refresh"></em></a></li>
                      </ul>
                    </div>
                    <div class="col-lg-5 col-md-4 col-sm-4 pt-3 pt-sm-0 featuredAd text-sm-right">
                      <a href="#"><em class="fa fa-star"></em> Feature this ad</a>
                    </div>
                  </div>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="ad-tab3"> 
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">Displaying 1 ad listing</h6>
                  </div>
                  <div class="display-ad-status">
                    <select name="" class="form-control form-control-sm">
                      <option value="">Active (1)</option>
                      <option value="">Pending (1)</option>
                      <option value="">Removed (0)</option>
                    </select>
                  </div>
                </div>
                <div class="bg-white border">
                  <div class="ads-listing-rows">
                  <div class="row p-3 mx-0">
                    <figure class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                      <img src="assets/img/featured-dealers-logo-auto.png" alt="carish used cars for sale in estonia" class="img-fluid">
                    </figure> 
                    <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                      <h4><a href="#">Auto 100</a></h4>
                      <p class="ads-views mb-0"><em class="fa fa-eye"></em> 0 Views</p>
                    </div>
                    <div class="col-12 px-0 mt-3">
                      <div class="row align-items-sm-center">
                    <div class="col-lg-7 col-md-8 col-sm-8 mb-0 editProfile actionbtn ">
                      <ul class="list-unstyled mb-0">
                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Edit <em class=" ml-1 fa fa-pencil"></em></a></li>

                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Remove <em class="ml-1 fa fa-trash"></em></a></li>

                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Inactive <em class="ml-1 fa fa-refresh"></em></a></li>
                      </ul>
                    </div>
                    <div class="col-lg-5 col-md-4 col-sm-4 pt-3 pt-sm-0 featuredAd text-sm-right">
                      <a href="#"><em class="fa fa-star"></em> Feature this ad</a>
                    </div>
                  </div>
                    </div>
                  </div>
                  <div class="row p-3 mx-0">
                    <figure class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                      <img src="assets/img/featured-dealers-logo-auto.png" alt="carish used cars for sale in estonia" class="img-fluid">
                    </figure> 
                    <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                      <h4><a href="#">Auto 100</a></h4>
                      <p class="ads-views mb-0"><em class="fa fa-eye"></em> 0 Views</p>
                    </div>
                    <div class="col-12 px-0 mt-3">
                      <div class="row align-items-sm-center">
                    <div class="col-lg-7 col-md-8 col-sm-8 mb-0 editProfile actionbtn ">
                      <ul class="list-unstyled mb-0">
                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Edit <em class=" ml-1 fa fa-pencil"></em></a></li>

                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Remove <em class="ml-1 fa fa-trash"></em></a></li>

                        <li class="list-inline-item"><a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Inactive <em class="ml-1 fa fa-refresh"></em></a></li>
                      </ul>
                    </div>
                    <div class="col-lg-5 col-md-4 col-sm-4 pt-3 pt-sm-0 featuredAd text-sm-right">
                      <a href="#"><em class="fa fa-star"></em> Feature this ad</a>
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
      <!-- Tab 1 ends here -->        

        <!-- Tab 2 starts here -->
        <div class="tab-pane" id="profile-tab2">      
         <div class="row ad-tab-desc">
          <div class="ad-tab-sidebar save-ad-sidebar col-lg-3 col-md-4">
                <div class="bg-white border p-3">
                   <ul class="nav nav-tabs nav-pills d-block text-capitalize sidebar-pills my-save-ad-tabs">
                    <li class="nav-item">
                      <a class="nav-link active d-flex" data-toggle="tab" href="#save-ad-tab1">
                       <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="assets/img/adtab-car.png" class="img-fluid none-active-img" alt="icon image">
                        <img src="assets/img/adtab-active-car.png" class="img-fluid active-img" alt="icon image">
                      </figure> <span>Car</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link d-flex" data-toggle="tab" href="#save-ad-tab2">
                        <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="assets/img/adtab-parts.png" class="img-fluid none-active-img" alt="icon image">
                        <img src="assets/img/adtab-active-parts.png" class="img-fluid active-img" alt="icon image">
                      </figure> <span>parts</span></a>
                    </li>
                  </ul>
                </div>
              </div>
          <div class="col-lg-9 col-md-8 mt-md-0 mt-4 pl-md-0 pl-lg-3 ad-tab-desc">
               <div class="tab-content"> 
               <div class="tab-pane active" id="save-ad-tab1"> 
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">Displaying 1 ad listing</h6>
                  </div>
                </div>
                <div class="bg-white border">
                  <div class="ads-listing-rows">
                          <div class="row p-3 mx-0">
                            <figure class="col-lg-3 col-md-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                              <img src="assets/img/featured-used-car-2.jpg" alt="carish used cars for sale in estonia" class="img-fluid">
                            </figure> 
                            <div class="col-lg-9 col-md-9 col-sm-8 col-8 pl-md-0 pl-0 pr-0 ads-listing-text d-md-flex justify-content-between">
                              <div class="save-ad-desc pr-md-3">
                              <h4><a href="#">Toyota Corolla Altis Grande CVT-i 1.8 2018</a></h4>
                              <p class="save-ad-price mb-2">$ 30000</p>
                              </div>
                              <div class="actionbtn d-flex flex-md-column justify-content-between save-ad-action">
                               <div class="save-ad-view text-right">
                                <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">View Ad <em class="ml-1 fa fa-eye"></em></a>
                                </div> 
                                <div class="save-ad-remove mt-auto text-right">
                                <a href="#" class="border border-danger d-inline-block px-sm-3 px-2 py-1 rounded text-danger">Remove Ad <em class="ml-1 fa fa-trash"></em></a>
                                </div> 
                              </div>
                            </div>
                          </div>
                          <div class="row p-3 mx-0">
                            <figure class="col-lg-3 col-md-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                              <img src="assets/img/featured-used-car-2.jpg" alt="carish used cars for sale in estonia" class="img-fluid">
                            </figure> 
                            <div class="col-lg-9 col-md-9 col-sm-8 col-8 pl-md-0 pl-0 pr-0 ads-listing-text d-md-flex justify-content-between">
                              <div class="save-ad-desc pr-md-3">
                              <h4><a href="#">Toyota Corolla Altis Grande CVT-i 1.8 2018</a></h4>
                              <p class="save-ad-price mb-2">$ 30000</p>
                              </div>
                              <div class="actionbtn d-flex flex-md-column justify-content-between save-ad-action">
                               <div class="save-ad-view text-right">
                                <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">View Ad <em class="ml-1 fa fa-eye"></em></a>
                                </div> 
                                <div class="save-ad-remove mt-auto text-right">
                                <a href="#" class="border border-danger d-inline-block px-sm-3 px-2 py-1 rounded text-danger">Remove Ad <em class="ml-1 fa fa-trash"></em></a>
                                </div> 
                              </div>
                            </div>
                          </div>
                      </div>
                </div>
              </div>
              <div class="tab-pane" id="save-ad-tab2"> 
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">Displaying 1 ad listing</h6>
                  </div>
                </div>
                <div class="bg-white border">
                  <div class="ads-listing-rows">
                          <div class="row p-3 mx-0">
                            <figure class="col-lg-3 col-md-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                              <img src="assets/img/spare-part-4.jpg" alt="carish used cars for sale in estonia" class="img-fluid">
                            </figure> 
                            <div class="col-lg-9 col-md-9 col-sm-8 col-8 pl-md-0 pl-0 pr-0 ads-listing-text d-md-flex justify-content-between">
                              <div class="save-ad-desc pr-md-3">
                              <h4><a href="#">Toyota Corolla Altis Grande CVT-i 1.8 2018</a></h4>
                              <p class="save-ad-price mb-2">$ 30000</p>
                              </div>
                              <div class="actionbtn d-flex flex-md-column justify-content-between save-ad-action">
                               <div class="save-ad-view text-right">
                                <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">View Ad <em class="ml-1 fa fa-eye"></em></a>
                                </div> 
                                <div class="save-ad-remove mt-auto text-right">
                                <a href="#" class="border border-danger d-inline-block px-sm-3 px-2 py-1 rounded text-danger">Remove Ad <em class="ml-1 fa fa-trash"></em></a>
                                </div> 
                              </div>
                            </div>
                          </div>
                          <div class="row p-3 mx-0">
                            <figure class="col-lg-3 col-md-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                              <img src="assets/img/spare-part-4.jpg" alt="carish used cars for sale in estonia" class="img-fluid">
                            </figure> 
                            <div class="col-lg-9 col-md-9 col-sm-8 col-8 pl-md-0 pl-0 pr-0 ads-listing-text d-md-flex justify-content-between">
                              <div class="save-ad-desc pr-md-3">
                              <h4><a href="#">Toyota Corolla Altis Grande CVT-i 1.8 2018</a></h4>
                              <p class="save-ad-price mb-2">$ 30000</p>
                              </div>
                              <div class="actionbtn d-flex flex-md-column justify-content-between save-ad-action">
                               <div class="save-ad-view text-right">
                                <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">View Ad <em class="ml-1 fa fa-eye"></em></a>
                                </div> 
                                <div class="save-ad-remove mt-auto text-right">
                                <a href="#" class="border border-danger d-inline-block px-sm-3 px-2 py-1 rounded text-danger">Remove Ad <em class="ml-1 fa fa-trash"></em></a>
                                </div> 
                              </div>
                            </div>
                          </div>
                      </div>
                </div>
              </div>
             </div> 
           </div>    
                  <!-- <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                      <div class="display-ad-title">
                            <h6 class="mb-0 font-weight-normal">Displaying 1 ad listing</h6>
                        </div>
                    </div>
                      <div class="bg-white border">
                          <div class="ads-listing-rows">
                          <div class="row p-3 mx-0">
                            <figure class="col-lg-3 col-md-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                              <img src="assets/img/featured-used-car-2.jpg" alt="carish used cars for sale in estonia" class="img-fluid">
                            </figure> 
                            <div class="col-lg-9 col-md-9 col-sm-8 col-8 pl-md-0 pl-0 pr-0 ads-listing-text d-md-flex justify-content-between">
                              <div class="save-ad-desc pr-md-3">
                              <h4><a href="#">Toyota Corolla Altis Grande CVT-i 1.8 2018</a></h4>
                              <p class="save-ad-price mb-2">$ 30000</p>
                              </div>
                              <div class="actionbtn d-flex flex-md-column justify-content-between save-ad-action">
                               <div class="save-ad-view text-right">
                                <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">View Ad <em class="ml-1 fa fa-eye"></em></a>
                                </div> 
                                <div class="save-ad-remove mt-auto text-right">
                                <a href="#" class="border border-danger d-inline-block px-sm-3 px-2 py-1 rounded text-danger">Remove Ad <em class="ml-1 fa fa-trash"></em></a>
                                </div> 
                              </div>
                            </div>
                          </div>
                          <div class="row p-3 mx-0">
                            <figure class="col-lg-3 col-md-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">
                              <img src="assets/img/featured-used-car-2.jpg" alt="carish used cars for sale in estonia" class="img-fluid">
                            </figure> 
                            <div class="col-lg-9 col-md-9 col-sm-8 col-8 pl-md-0 pl-0 pr-0 ads-listing-text d-md-flex justify-content-between">
                              <div class="save-ad-desc pr-md-3">
                              <h4><a href="#">Toyota Corolla Altis Grande CVT-i 1.8 2018</a></h4>
                              <p class="save-ad-price mb-2">$ 30000</p>
                              </div>
                              <div class="actionbtn d-flex flex-md-column justify-content-between save-ad-action">
                               <div class="save-ad-view text-right">
                                <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded">View Ad <em class="ml-1 fa fa-eye"></em></a>
                                </div> 
                                <div class="save-ad-remove mt-auto text-right">
                                <a href="#" class="border border-danger d-inline-block px-sm-3 px-2 py-1 rounded text-danger">Remove Ad <em class="ml-1 fa fa-trash"></em></a>
                                </div> 
                              </div>
                            </div>
                          </div>
                      </div>
                  </div>  -->
            </div>
        </div>
        <!-- Tab 2 ends here -->  


       <!-- Tab 3 starts here --> 
        <div class="tab-pane" id="profile-tab3">
            <div class="row alerts-tab-row">
              <div class="col-lg-3 col-md-4 alerts-tab-sidebar ad-tab-sidebar">
                <div class="bg-white border p-3">
                   <ul class="nav nav-tabs nav-pills d-block text-capitalize sidebar-pills my-ad-tabs">
                    <li class="nav-item">
                      <a class="nav-link active d-flex" data-toggle="tab" href="#alerts-tab1">
                       <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="assets/img/adtab-car.png" class="img-fluid none-active-img" alt="icon image">
                        <img src="assets/img/adtab-active-car.png" class="img-fluid active-img" alt="icon image">
                      </figure> <span>Cars Alerts</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link d-flex" data-toggle="tab" href="#alerts-tab2">
                        <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="assets/img/adtab-parts.png" class="img-fluid none-active-img" alt="icon image">
                        <img src="assets/img/adtab-active-parts.png" class="img-fluid active-img" alt="icon image">
                      </figure> <span>Spare Parts Alerts</span></a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-9 col-md-8 mt-md-0 mt-4 pl-md-0 pl-lg-3 alerts-tab-desc">
               <div class="tab-content"> 
               <div class="tab-pane active" id="alerts-tab1"> 
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">Add Car Alerts</h6>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table bg-white table-bordered ">
                    <thead>
                      <tr>
                        <th class="border-bottom">Modal</th>
                        <th class="border-bottom">Year</th>
                        <th class="border-bottom">City</th>
                        <th class="border-bottom">Price($)</th>
                        <th class="border-bottom">Milege(km)</th>
                        <th class="border-bottom"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Toyota Corolla</td>
                        <td>2000 - 2019</td>
                        <td>$ 3000 - 30000</td>
                        <td>Estonia</td>
                        <td>Any - Any</td>
                        <td>
                          <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded actionbtn">View Ads <em class="ml-1 fa fa-eye"></em></a>
                          <a href="#" class="rounded-circle text-white fa fa-close close-alerts ml-2"></a>
                        </td>
                      </tr>
                      <tr>
                        <td>Toyota Corolla</td>
                        <td>2000 - 2019</td>
                        <td>$ 3000 - 30000</td>
                        <td>Estonia</td>
                        <td>Any - Any</td>
                        <td>
                          <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded actionbtn">View Ads <em class="ml-1 fa fa-eye"></em></a>
                          <a href="#" class="rounded-circle text-white fa fa-close close-alerts ml-2"></a>
                        </td>
                      </tr>
                      <tr>
                        <td>Toyota Corolla</td>
                        <td>2000 - 2019</td>
                        <td>$ 3000 - 30000</td>
                        <td>Estonia</td>
                        <td>Any - Any</td>
                        <td>
                          <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded actionbtn">View Ads <em class="ml-1 fa fa-eye"></em></a>
                          <a href="#" class="rounded-circle text-white fa fa-close close-alerts ml-2"></a>
                        </td>
                      </tr>
                      <tr>
                        <td>Toyota Corolla</td>
                        <td>2000 - 2019</td>
                        <td>$ 3000 - 30000</td>
                        <td>Estonia</td>
                        <td>Any - Any</td>
                        <td>
                          <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded actionbtn">View Ads <em class="ml-1 fa fa-eye"></em></a>
                          <a href="#" class="rounded-circle text-white fa fa-close close-alerts ml-2"></a>
                        </td>
                      </tr>
                      <tr>
                        <td>Toyota Corolla</td>
                        <td>2000 - 2019</td>
                        <td>$ 3000 - 30000</td>
                        <td>Estonia</td>
                        <td>Any - Any</td>
                        <td>
                          <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded actionbtn">View Ads <em class="ml-1 fa fa-eye"></em></a>
                          <a href="#" class="rounded-circle text-white fa fa-close close-alerts ml-2"></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
                <div class="tab-pane" id="alerts-tab2"> 
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">Add Spart Parts Alerts</h6>
                  </div>
                </div>
                <div class="table-responsive">
                <table class="table bg-white table-bordered">
                    <thead>
                      <tr>
                        <th class="border-bottom">Modal</th>
                        <th class="border-bottom">Year</th>
                        <th class="border-bottom">City</th>
                        <th class="border-bottom">Price($)</th>
                        <th class="border-bottom">Milege(km)</th>
                        <th class="border-bottom"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Toyota Corolla</td>
                        <td>2000 - 2019</td>
                        <td>$ 3000 - 30000</td>
                        <td>Estonia</td>
                        <td>Any - Any</td>
                        <td>
                          <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded actionbtn">View Ads <em class="ml-1 fa fa-eye"></em></a>
                          <a href="#" class="rounded-circle text-white fa fa-close close-alerts ml-2"></a>
                        </td>
                      </tr>
                      <tr>
                        <td>Toyota Corolla</td>
                        <td>2000 - 2019</td>
                        <td>$ 3000 - 30000</td>
                        <td>Estonia</td>
                        <td>Any - Any</td>
                        <td>
                          <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded actionbtn">View Ads <em class="ml-1 fa fa-eye"></em></a>
                          <a href="#" class="rounded-circle text-white fa fa-close close-alerts ml-2"></a>
                        </td>
                      </tr>
                      <tr>
                        <td>Toyota Corolla</td>
                        <td>2000 - 2019</td>
                        <td>$ 3000 - 30000</td>
                        <td>Estonia</td>
                        <td>Any - Any</td>
                        <td>
                          <a href="#" class="border d-inline-block px-sm-3 px-2 py-1 rounded actionbtn">View Ads <em class="ml-1 fa fa-eye"></em></a>
                          <a href="#" class="rounded-circle text-white fa fa-close close-alerts ml-2"></a>
                        </td>
                      </tr>
                    </tbody>
                  </table></div>
              </div>
             </div> 
           </div>
         </div>
        </div>

        <!-- Tab 3 ends here -->  


        <!-- Tab 4 starts here -->
        <div class="tab-pane active" id="profile-tab4">
          <div class="bg-white">
            <div class="table-responsive">
              <table class="table table-bordered message-table">
                    <thead>
                      <tr>
                        <th class="border-bottom">Subject</th>
                        <th class="border-bottom">
                            <div class="input-group messages-search border mx-auto">
                              <input type="text" class="form-control border-0" placeholder="Search">
                              <div class="input-group-append">
                                <button class="fa fa-search pl-3 pr-3 border-0" type="submit"></button>
                              </div>
                            </div>                              
                        </th>
                        <th class="border-bottom">Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan="2" class="message-title"><a href="javascript:void(0)" class="themecolor">Toyota Vitz 2016 for sale in Estonia</a></td>
                        <td>Aug 23,2019</td>
                      </tr>
                      <tr>
                        <td colspan="2" class="message-title"><a href="javascript:void(0)" class="themecolor">Toyota Vitz 2016 for sale in Estonia</a></td>
                        <td>Aug 23,2019</td>
                      </tr>
                      <tr>
                        <td colspan="2" class="message-title"><a href="javascript:void(0)" class="themecolor">Toyota Vitz 2016 for sale in Estonia</a></td>
                        <td>Aug 23,2019</td>
                      </tr>
                      <tr>
                        <td colspan="2" class="message-title"><a href="javascript:void(0)" class="themecolor">Toyota Vitz 2016 for sale in Estonia</a></td>
                        <td>Aug 23,2019</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                  <div class="messages-col" style="display: none">
                    <div class="border-bottom mx-auto px-2 py-3 row">
                      <div class="col-md-8 col-sm-8 col-12 message-title-col">
                        <h4>Toyota Vitz 2016 for sale in Estonia</h4>
                        <p class="messages-posted-time mb-0">Aug 23,2019</p>
                      </div>
                      <div class="col-md-4 col-sm-4 col-12 message-backto text-right">
                        <a href="#" class="font-weight-semibold themecolor"><em class="fa fa-chevron-circle-left"></em> Back to Dashboard</a>
                      </div>
                    </div>
                    <div class="p-4">
                    <div class="messages-content">
                      <div class="reciever-message">
                        <h6 class="sendername">
                          Sajjad Ahmad 
                        </h6>
                        <div class="reciever-mesg-bg p-3 text-white">
                            <p class="mb-0">Hi,</p>
                            <p class="mb-0">I am interested in your car "Toyota Vitz F 1.0 2016" advertised on carish.com. Please let me know if it's still available.</p>
                            <p class="mb-0">Thanks.</p>
                            <p class="mb-0"p>Aug 23, 2019 05:04 AM</p>
                        </div>
                        <div class="reciever-mesg-bg p-3 text-white">
                            <p class="mb-0">I am interested in your car "Toyota Vitz F 1.0 2016" advertised on carish.com. Please let me know if it's still available.</p>
                            <p class="mb-0"p>Aug 23, 2019 05:04 AM</p>
                        </div>
                      </div>
                       <div class="sender-message ml-auto">
                          <div class="sender-mesg-bg p-3 text-white">  
                            <p class="mb-0">Hi,</p>
                            <p class="mb-0">I am interested in your car "Toyota Vitz F 1.0 2016" advertised on carish.com. Please let me know if it's still available.</p>
                            <p class="mb-0">Thanks.</p>
                            <p class="mb-0"p>Aug 23, 2019 05:04 AM</p>
                          </div>
                      </div>
                    </div>

                    <div class="message-area mt-5 pt-3">
                      <div class="form-group">
                      <textarea name="messageArea" rows="5" class="form-control mb-1" placeholder="Your Message"></textarea>
                      <span class="msg-characters font-weight-semibold">250 characters left</span>
                    </div>
                      <div class="form-group">
                        <input type="submit" name="Submit" value="Submit" class="btn themebtn1 pl-5 pr-5">
                      </div>
                    </div>
                  </div>


                  </div>
              </div>
        </div>
        <!-- Tab 4 ends here -->  


        <!-- Tab 5 starts here -->
        <div class="tab-pane" id="profile-tab5">
          <div class="bg-white p-lg-5 p-md-4 p-3 change-password-sect">
            <h2>Change Password</h2>
            <form class="mt-lg-5 mt-md-4 mt-3">
             <div class="row mx-md-0">
              <div class="col-lg-7 col-md-8 mb-sm-9 form-group">
                <label style="color:#707070" class="f-size1"><strong>Change your password below for</strong> abcd@xyz.com</label> 
              </div>  
               <div class="col-lg-7 col-md-8 mb-sm-9 form-group">
               <div class="input-group border rounded">
                  <div class="input-group-prepend">
                    <span class="input-group-text justify-content-center border-0 bg-white pr-0"><em class="fa fa-key"></em></span>
                  </div>
                  <input type="text" class="form-control form-control-lg border-0" placeholder="Current Password" required="">
                </div>
                </div>
                <div class="col-lg-7 col-md-8 mb-sm-9 form-group">
               <div class="input-group border rounded">
                  <div class="input-group-prepend">
                    <span class="input-group-text justify-content-center border-0 bg-white pr-0"><em class="fa fa-key"></em></span>
                  </div>
                  <input type="text" class="form-control form-control-lg border-0" placeholder="New Password" required="">
                </div>
                </div>
                <div class="col-lg-7 col-md-8 mb-sm-9 form-group">
               <div class="input-group border rounded">
                  <div class="input-group-prepend">
                    <span class="input-group-text justify-content-center border-0 bg-white pr-0"><em class="fa fa-key"></em></span>
                  </div>
                  <input type="text" class="form-control form-control-lg border-0" placeholder="Re-Type New Password" required="">
                </div>
                </div>
                <div class="col-md-7 mb-md-0 mt-lg-4 form-group">
                  <input type="submit" name="Submit" value="Submit" class="btn themebtn1 pt-3 pb-3 pl-5 pr-5">
                </div>
             </div>


            </form>
          </div>
        </div>
        <!-- Tab 5 ends here -->  


        <!-- Tab 6 starts here -->
        <div class="tab-pane" id="profile-tab6">
          <div class="row ad-tab-row">
              <div class="col-lg-3 col-md-4 payment-tab-sidebar">
                <div class="bg-white border p-3">
                   <ul class="nav nav-tabs nav-pills d-block text-capitalize sidebar-pills payment-tabs">
                    <li class="nav-item">
                      <a class="nav-link active d-flex" data-toggle="tab" href="#payment-tab1">
                       <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="assets/img/payment-add-balance.png" class="img-fluid none-active-img" alt="icon image">
                        <img src="assets/img/payment-active-add-balance.png" class="img-fluid active-img" alt="icon image">
                      </figure> <span>Add Balance</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link d-flex" data-toggle="tab" href="#payment-tab2">
                        <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="assets/img/payment-balance-log.png" class="img-fluid none-active-img" alt="icon image">
                        <img src="assets/img/payment-active-balance-log.png" class="img-fluid active-img" alt="icon image">
                      </figure> <span>Balance Log</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link d-flex" data-toggle="tab" href="#payment-tab3">
                        <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="assets/img/payment-invoice-setting.png" class="img-fluid none-active-img" alt="icon image">
                        <img src="assets/img/payment-active-invoice-setting.png" class="img-fluid active-img" alt="icon image">
                      </figure> <span>Invoice Settings</span></a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-9 col-md-8 mt-md-0 mt-4 pl-md-0 pl-lg-3 payment-tab-desc">
               <div class="tab-content"> 
               <div class="tab-pane active" id="payment-tab1"> 
                <div class="bg-white border px-lg-4 px-3 pt-3 pb-4">
                  <h4 class="mb-3">Add Balance</h4>

                  <form class="add-balance-form mt-4 pt-md-2">
                    <div class="row justify-content-between align-items-end">
                      <div class="col-lg-6 col-sm-7 col-12">
                        <label class="font-weight-semibold">Current balance <strong>$200.00</strong></label>
                        <input type="text" class="form-control" placeholder="Add Amount">
                      </div> 
                      <div class="col-lg-4 col-sm-5  col-12 mt-sm-0 mt-2 text-sm-right">
                        <input type="submit" name="Submit" value="Add Balance" class="btn themebtn1">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="tab-pane" id="payment-tab2"> 
                <div class="bg-white border px-lg-4 px-3 pt-3 pb-4">
                  <h4 class="mb-3">Balance Log</h4>
                  <div class="border p-2">
                   <div class=" row form-row">
                    <div class="align-items-center bl-from-to col-lg-4 col-sm-6 mt-sm-0 mt-2 d-flex">
                      <label class="mr-2 mb-0">From:</label>
                      <input id="datefrom">
                    </div>
                    <div class="align-items-center bl-from-to col-lg-4 col-sm-6 mt-sm-0 mt-2 d-flex">
                      <label class="mr-2 mb-0">To:</label>
                      <input id="dateto">
                    </div>
                    <div class="align-items-center bl-from-to col-lg-4 mt-lg-0 mt-2 d-flex filterBtn text-md-left text-right">
                      <a href="#" class="applyfilter btn themebtn1">Apply Filter</a>
                      <a href="#" class="resetfilter btn">Reset Filter</a>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="mt-4 table table-bordered">
                    <thead class="thead-light">
                      <tr>
                        <th>Date</th>
                        <th>Invoice Num</th>
                        <th>Amount</th>
                        <th>Details</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>01-08-2019</td>
                        <td><a href="#" class="themecolor">#000010</a></td>
                        <td><span class="themecolor3">+200.00</span></td>
                        <td>Balance added</td>
                      </tr>
                       <tr>
                        <td>01-08-2019</td>
                        <td><a href="#" class="themecolor">#000010</a></td>
                        <td><span class="themecolor2">-20.00</span></td>
                        <td>Balance added</td>
                      </tr>
                       <tr>
                        <td>01-08-2019</td>
                        <td><a href="#" class="themecolor">#000010</a></td>
                        <td><span class="themecolor3">+200.00</span></td>
                        <td>Monthly fee : June</td>
                      </tr>
                       <tr>
                        <td>01-08-2019</td>
                        <td><a href="#" class="themecolor">#000010</a></td>
                        <td><span class="themecolor3">+200.00</span></td>
                        <td>Balance added</td>
                      </tr>
                       <tr>
                        <td>01-08-2019</td>
                        <td><a href="#" class="themecolor">#000010</a></td>
                        <td><span class="themecolor3">+200.00</span></td>
                        <td>Featured Car : Honda Civic 105BFL</td>
                      </tr>

                    </tbody>
                  </table>
                </div>
                </div>
              </div>
              <div class="tab-pane" id="payment-tab3"> 
                <div class="bg-white border px-lg-4 px-3 pt-3 pb-4">
                  <h4>Invoice Setting</h4>

                  <form class="invoice-setting-form mt-md-4 mt-3">
                    <div class="row form-group mb-md-4 align-items-center">
                      <div class="text-sm-right col-lg-3 col-md-4 col-sm-4 col-12">
                        <label class="mb-md-0 mb-1">Invoice Name</label>
                      </div>
                       <div class="col-lg-5 col-md-6 col-sm-7 col-12">
                        <input type="text" class="form-control" placeholder="Invoice Name">
                      </div>
                    </div> 
                    <div class="row form-group mb-md-4 align-items-center">
                      <div class="text-sm-right col-lg-3 col-md-4 col-sm-4 col-12">
                        <label class="mb-md-0 mb-1">Address</label>
                      </div>
                       <div class="col-lg-5 col-md-6 col-sm-7 col-12">
                        <input type="text" class="form-control" placeholder="Address">
                      </div>
                    </div> 
                    <div class="row form-group mb-md-4 align-items-center">
                      <div class="text-sm-right col-lg-3 col-md-4 col-sm-4 col-12">
                        <label class="mb-md-0 mb-1">Contact person</label>
                      </div>
                       <div class="col-lg-5 col-md-6 col-sm-7 col-12">
                        <input type="text" class="form-control" placeholder="Contact person">
                      </div>
                    </div> 
                    <div class="row form-group mb-sm-4">
                       <div class="col-lg-5 offset-lg-3 offset-sm-4 col-md-8 col-sm-8 col-12">
                        <input type="submit" name="Submit" value="Save" class="btn themebtn1">
                      </div>
                    </div> 
                  </form>
                    </div>
                </div>
              </div>
             </div> 
           </div>
         </div>
        </div>
        <!-- Tab 6 starts here -->
      </div>          

    </div>

 function getSentence(e) {
            var sentence        = $(e).data('sentence');
            var old_sentense    = $('#description').val();
            var old_suggessions = $('#suggessions').val();
            var comma = '';
            if(old_suggessions != ''){
              comma = ',';
            }
            
            var new_sentense    = old_sentense + sentence;
            var new_suggessions = old_suggessions+comma+sentence;
            $('#description').val(new_sentense);
            $('#suggessions').val(new_suggessions);
            $(e).hide();
        }
        $(document).ready(function(){
    $("#description").keyup(function(){
        // Getting the current value of textarea
        var currentText = $(this).val();
        
        // Setting the Div content
        $("#suggessions").val(currentText);
    });
});
@endsection