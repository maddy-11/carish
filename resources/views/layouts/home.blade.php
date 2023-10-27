<?php 
use App\Helpers\Helper; $helper = new Helper;
  $activeLanguage = \Session::get('language');
 ?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_token" content="{{csrf_token()}}" />
    <title>{{ config('app.name', 'Carish') }} {{ __('header.welcome') }} | @yield('title')</title>   
    <!-- Bootstrap CSS -->
    {{-- Sweet Alert --}}
    <link href="{{asset('public/css/sweetalert.min.css')}}" rel="stylesheet">
    <link rel="icon" href="{{ asset('public/assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/owl.theme.default.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('public/assets/css/select2.min.css')}}" rel="stylesheet" />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap-select.min.css')}}">
    <link href="{{ asset('public/assets/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/css/lightslider.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/css/lightgallery.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/css/select2-bootstrap4.css') }}" rel="stylesheet"> 
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/css/toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/responsive.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{url('public/admin/assets/css/datatables.min.css')}}"/>
    <!-- Parsley for validation -->
    <link href="{{ asset('public/assets/css/parsley.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/assets/css/jquery-ui.css')}}">
    @stack('styles') 
    <style type="text/css">
    </style>
  </head>
  
  
  <body>
    <!-- header Starts here -->
<header class="header">
<div class="container">
<input type="hidden" id="site_url"  value="{{ url('') }}">
<div class="topbar py-2 d-md-block d-none">
  <div class="row">
    <div class="col-12 text-right topbar-links">
          <ul class="d-inline-block list-unstyled mb-0">
                  <li class="dropdown list-inline-item lingdropdown">
                  @if(App::isLocale('en'))
                    <a class="dropdown-toggle" title="English" href="{{ url('locale/en') }}" id="linguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag-icon flag-icon-us"></span></a>
                    @elseif(App::isLocale('et'))
                     <a class="dropdown-toggle" title="Estonian"  href="{{ url('locale/et') }}" id="linguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag-icon flag-icon-ee"></span></a>
                   @else 
                    <a class="dropdown-toggle" title="Russian"  href="{{ url('locale/ru') }}" id="linguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag-icon flag-icon-ru"></span></a>
                   @endif
                  <div class="dropdown-menu  dropdown-menu-right mt-2 dropdown-top-border cstm-dropdown-menu" aria-labelledby="linguage" style="min-width: 2rem;">
                    @if(!App::isLocale('en'))
                    <a class="dropdown-item"  title="English"  href="{{ url('locale/en') }}"><span class="flag-icon flag-icon-us"></span></a>
                    @endif  
                     @if(!App::isLocale('et'))<a class="dropdown-item" title="Estonian"  href="{{ url('locale/et') }}"><span class="flag-icon flag-icon-ee"></span></a>
                     @endif
                      @if(!App::isLocale('ru'))
                      <a class="dropdown-item" title="Russian"  href="{{ url('locale/ru') }}"><span class="flag-icon flag-icon-ru"></span></a>
                     @endif
                    </div>

                  </li>
                @guest('customer')    
                  <li class="dropdown list-inline-item logOut-item">
                    <a href="{{ route('signin') }}">{{ __('auth.login_link') }}</a> <em class="fa fa-sign-in"></em></a>
                  </li>
                  <li class="dropdown list-inline-item logOut-item">
                    <a href="{{ route('signup') }}">{{__('auth.signup_link')}}</a> <em class="fa fa-sign-out"></em></a>
                  </li>  
                 @endguest

                 @auth('customer') 
                 @php 
                      $messages_count = App\CustomerMessages::where('to_id',Auth::guard('customer')->user()->id)->where('read_status',0)->count();
                 @endphp
                  <li class="dropdown list-inline-item logIn-item">{{__('header.welcome')}}
                  <a class="dropdown-toggle" href="#" id="loginDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="font-weight-semibold">{{ Auth::guard('customer')->user()->customer_firstname }}</span> </a> | <em class="fa fa-envelope" style="position: relative;"><span style="position: absolute;top: -3px;right: -3px;background: #0072BB;color: white;border-radius: 50%;font-size: 12px;padding: 0 2px;">{{@$messages_count}}</span></em>
                  <div class="dropdown-menu dropdown-menu-right dropdown-top-border cstm-dropdown-menu" aria-labelledby="loginDropdown">
                    @if(@Auth::guard('customer')->user()->customer_role == 'individual')
                    <a class="dropdown-item" href="{{route('change.profile')}}">{{__('header.my_profile')}}
                    </a>
                    @else
                    <a class="dropdown-item" href="{{route('my.business.profile')}}">{{__('header.my_profile')}}</a>
                    @endif
                    <a class="dropdown-item" href="{{route('my-ads')}}">{{__('header.my_ads')}}</a>
                    <a class="dropdown-item" href="{{route('my-saved-ads')}}">{{__('header.my_save_ads')}}</a>
                    <a class="dropdown-item" href="{{route('my-alerts')}}">{{__('header.alerts')}}</a>
                    <a class="dropdown-item" href="{{route('my-messages')}}">{{__('header.messages')}}</a>
                    <a class="dropdown-item" href="{{route('change-password')}}">{{__('header.change_password')}}</a>
                    <a class="dropdown-item" href="{{route('my-payment')}}">{{__('header.payment')}}</a>
                    <a class="dropdown-item" href="{{ route('logoff') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"> {{ __('auth.sign_out') }}</a>
                    <form id="logout-form" action="{{ route('logoff') }}" method="POST" style="display: none;">
                    @csrf
                    </form>
                    </div>
                  </li>
                @endauth

                </ul>


    </div>
  </div>
</div>
<div class="align-items-end mt-3 row">
  <div class="col-xl-auto col-lg-auto col-md-2 logo d-none d-md-block">
    <a href="{{ url('/') }}"><img src="{{ asset('public/assets/img/logo2.png')}}" class="img-fluid" alt="carish used cars for sale in estonia"></a>
  </div>
  
  <nav class="col-xl-auto col-lg-auto col-md-7 col-12 font-weight-semibold ml-auto navbar navbar-expand-md text-capitalize pb-0 pt-0">
    <!-- Brand -->
    <div class="align-items-center d-flex d-md-none navbar-header w-100">
      <a href="{{ url('/') }}" class="navbar-brand mr-auto">
        <img src="{{ asset('public/assets/img/logo2.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
      </a>
      <div class="header-btn text-right mr-3 d-md-none">
        <div class="dropdown">
          <a class="dropdown-toggle btn font-weight-semibold w-100 themebtn2" href="#" data-toggle="dropdown">{{ __('header.post_an_ad') }}</a>
          <div class="dropdown-menu dropdown-top-border cstm-dropdown-menu">
             <a href="{{ route('post.ad') }}" class="dropdown-item">{{ __('common.sell') }} {{ trans_choice('common.cars', 1) }}</a>
           <a href="{{ route('sparepartads') }}" class="dropdown-item">{{ __('common.sell') }} {{ __('header.autoparts') }}</a>
            @if(@Auth::guard('customer')->user()->customer_role == 'business')
            <a href="{{ route('offerservices') }}" class="dropdown-item">{{ __('header.offer_service') }}</a>
            @endif
            {{-- <a href="{{ route('post.ad') }}" class="dropdown-item">{{ __('common.sell') }} {{ trans_choice('common.cars', 1) }}</a>
            <a href="{{ route('sparepartads') }}" class="dropdown-item">{{ __('common.sell') }} {{ __('header.autoparts') }}</a>
            <a href="{{ route('offerservices') }}" class="dropdown-item">{{ __('header.offer_service') }}</a> --}}
           {{--  @if(@Auth::guard('customer')->user()->customer_role == 'business')
                @if(Auth::guard('customer')->user()->customer_company == null || Auth::guard('customer')->user()->customer_default_address == null || Auth::guard('customer')->user()->customers_telephone == null || Auth::guard('customer')->user()->customer_registeration == null || Auth::guard('customer')->user()->website == null || Auth::guard('customer')->user()->timings == null || Auth::guard('customer')->user()->citiy_id == null)
                 <a href="javascript:void(0)" class="dropdown-item offerservice">{{ __('common.sell') }} {{ trans_choice('common.cars', 1) }}</a>
                @else
                <a href="{{ route('post.ad') }}" class="dropdown-item">{{ __('common.sell') }} {{ trans_choice('common.cars', 1) }}</a>
                @endif
          @elseif(@Auth::guard('customer')->user()->customer_role == 'individual')
                @if(Auth::guard('customer')->user()->citiy_id == null)
                <a href="javascript:void(0)" class="dropdown-item offerservice">{{ __('common.sell') }} {{ trans_choice('common.cars', 1) }}</a>
                @else
                <a href="{{ route('post.ad') }}" class="dropdown-item">{{ __('common.sell') }} {{ trans_choice('common.cars', 1) }}</a>
                @endif
          @endif
          @if(@Auth::guard('customer')->user()->customer_role == 'business')
              @if(Auth::guard('customer')->user()->customer_company == null || Auth::guard('customer')->user()->customer_default_address == null || Auth::guard('customer')->user()->customers_telephone == null || Auth::guard('customer')->user()->customer_registeration == null || Auth::guard('customer')->user()->website == null || Auth::guard('customer')->user()->timings == null || Auth::guard('customer')->user()->citiy_id == null)
              <a href="javascript:void(0)" class="dropdown-item offerservice">{{ __('common.sell') }} {{ __('header.autoparts') }}</a>
              @else
              <a href="{{ route('sparepartads') }}" class="dropdown-item">{{ __('common.sell') }} {{ __('header.autoparts') }}</a>
              @endif
          @elseif(@Auth::guard('customer')->user()->customer_role == 'individual')
                @if(Auth::guard('customer')->user()->citiy_id == null)
                <a href="javascript:void(0)" class="dropdown-item offerservice">{{ __('common.sell') }} {{ __('header.autoparts') }}</a>
                @else
                 <a href="{{ route('sparepartads') }}" class="dropdown-item">{{ __('common.sell') }} {{ __('header.autoparts') }}</a>
                @endif
          @endif
            @if(@Auth::guard('customer')->user()->customer_role == 'business')
             @if(Auth::guard('customer')->user()->customer_company == null || Auth::guard('customer')->user()->customer_default_address == null || Auth::guard('customer')->user()->customers_telephone == null || Auth::guard('customer')->user()->customer_registeration == null || Auth::guard('customer')->user()->website == null || Auth::guard('customer')->user()->timings == null || Auth::guard('customer')->user()->citiy_id == null)
            <a href="javascript:void(0)" class="dropdown-item offerservice">{{ __('header.offer_service') }}</a>
             @else
            <a href="{{ route('offerservices') }}" class="dropdown-item">{{ __('header.offer_service') }}</a>
            @endif
            @endif --}}
          </div>
        </div>
      </div>
      
      <!-- Toggler/collapsibe Button -->
      <button class="navbar-toggler border-0 p-0" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"> <span class="fa fa-bars"></span> </button>
    </div>
    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{ trans_choice('common.cars', 2) }}</a>
          <div class="dropdown-menu">
            <a href="{{ route('findusedcars') }}" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/find-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                <h5 class="mb-0 font-weight-semibold">{{ __('header.find_used_cars') }} </h5>
                <p class="mb-0">{{ __('header.browse_over_options') }}</p>
              </div>
            </a>
            <a href="{{route('simple.search')}}/list/isf_featured" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/featured-car-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                <h5 class="mb-0 font-weight-semibold">{{ __('header.featured_used_cars') }}</h5>
                <p class="mb-0">{{ __('header.view_featured_cars_by_carish') }}</p>
              </div>
            </a>
            <a href="{{ route('post.ad') }}" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/sell-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                <h5 class="mb-0 font-weight-semibold">{{ __('header.sell_your_car') }}</h5>
                <p class="mb-0">{{ __('header.post_a_free_ad_sell_your_car_quickly') }}</p>
              </div>
            </a>
            <a href="{{ url('allservices/listing/ps_1/cat_1') }}" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/car-dealer-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                <h5 class="mb-0 font-weight-semibold">{{ __('header.usedcardealers') }}</h5>
                <p class="mb-0">{{ __('header.browse_over_options') }}</p>
              </div>
            </a>
            <a href="{{ route('compare') }}" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/car-comparison-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                <h5 class="mb-0 font-weight-semibold">{{ __('header.car_comparison') }}</h5>
                <p class="mb-0">{{ __('header.comparecarsandfindtheirdifference') }}</p>
              </div>
            </a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{ __('header.autoparts') }}</a>
          <div class="dropdown-menu">
            <a href="{{ route('findautoparts') }}" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/find-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                <h5 class="mb-0 font-weight-semibold">{{ __('common.find') }} {{ __('header.autoparts') }}</h5>
                <p class="mb-0">{{ __('common.browse_over') }} 130k {{ __('header.autoparts') }} </p>
              </div>
            </a>
            <a href="{{ route('sparepartads') }}" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/sell-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                <h5 class="mb-0 font-weight-semibold">{{ __('common.sell') }} {{ __('header.autoparts') }}</h5>
                <p class="mb-0">{{ __('header.postafreeadsellyourautopartsquickly') }} </p>
              </div>
            </a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{ __('common.find') }}</a>
          <div class="dropdown-menu">
            @php 
              $primaryServices = App\Models\Customers\PrimaryService::where('status',1)->limit(4)->get();
             
            @endphp
            @foreach($primaryServices as $ps)
            <a href="{{url('allservices/listing/ps_'.$ps->id)}}" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/vehicle-repair-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                @php
                  $p_caty = $ps->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first();
                @endphp
                <h5 class="mb-0 font-weight-semibold">{{$p_caty !== null ? $p_caty : 'null'}}</h5>
                {{-- <p class="mb-0">Lorem Ipsum is simply dummy text</p> --}}
              </div>
            </a>
            @endforeach
           <!--  <a href="#" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/car-wash.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                <h5 class="mb-0 font-weight-semibold">{{ __('header.car_wash') }}</h5>
                {{-- <p class="mb-0">Lorem Ipsum is simply dummy text</p> --}}
              </div>
            </a>
            <a href="#" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/parking-lot-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                <h5 class="mb-0 font-weight-semibold">{{ __('header.parking_lots') }}</h5>
               {{--  <p class="mb-0">Lorem Ipsum is simply dummy text</p> --}}
              </div>
            </a>
            <a href="#" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/driving-center.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                <h5 class="mb-0 font-weight-semibold">{{ __('header.driving_center') }}</h5>
                <p class="mb-0">Lorem Ipsum is simply dummy text</p>
              </div>
            </a> -->
            <a href="{{ route('allservices') }}" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/more-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                <h5 class="mb-0 font-weight-semibold">{{ __('common.more') }}</h5>
                {{-- <p class="mb-0">Lorem Ipsum is simply dummy text</p> --}}
              </div>
            </a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{ __('common.more') }}</a>
          <div class="dropdown-menu">
            <a href="{{ route('tags') }}" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/tag-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                <h5 class="mb-0 font-weight-semibold">{{ __('header.tags') }}</h5>
                {{-- <p class="mb-0">Lorem Ipsum is simply dummy text</p> --}}
              </div>
            </a>
            <a href="{{ route('pages') }}" class="d-flex dropdown-item">
              <span class="mb-0">
                <img src="{{ asset('public/assets/img/terms-condition-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
              </span>
              <div class="ml-2 pl-1">
                <h5 class="mb-0 font-weight-semibold">{{ __('header.terms_condition') }}</h5>
                {{-- <p class="mb-0">Lorem Ipsum is simply dummy text</p> --}}
              </div>
            </a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <div class="col-xl-auto col-lg-auto col-md-3 col-sm-2 header-btn text-right d-none d-md-block">
    <div class="dropdown"> 
      <a class="dropdown-toggle btn font-weight-semibold w-100 themebtn2" href="#" data-toggle="dropdown">
        {{ __('header.post_an_ad') }}
      </a> 
         <div class="dropdown-menu dropdown-top-border cstm-dropdown-menu" style="top: 37px;">
           <a href="{{ route('post.ad') }}" class="dropdown-item">{{ __('common.sell') }} {{ trans_choice('common.cars', 1) }}</a>
           <a href="{{ route('sparepartads') }}" class="dropdown-item">{{ __('common.sell') }} {{ __('header.autoparts') }}</a>
            @if(@Auth::guard('customer')->user()->customer_role == 'business')
            <a href="{{ route('offerservices') }}" class="dropdown-item">{{ __('header.offer_service') }}</a>
            @endif
         </div>
    </div>
  </div>
</div>
</header>
<!-- header Ends here -->
@yield('banner')
@yield('content') 
 
  <div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div> 

<div class = "alert alert-success " style="display: none"  id="successmsg"></div>
 <!-- Cars Parts & Accessories Ends here -->
</div>
      <footer class="footer pb-5 pt-5 text-white">
        <div class="container">
          <div class="justify-content-between row">
            <div class="col-lg-6 col-md-6 col-12 address-col">
              <h5 class="font-weight-semibold text-uppercase mb-3">{{ __('common.find') }} {{ __('footer.us') }}:</h5>
              <ul class="list-unstyled">
                <li class="d-flex"><em class="fa fa-phone-square"></em> <strong>{{ __('footer.call') }} {{ __('footer.us') }} (000) 111 11111</strong></li>
                <li class="d-flex"><em class="fa fa-envelope"></em> <a href="mailto:support@carish.com">support@carish.com</a></li>
                <li class="d-flex"><em class="fa fa-map-marker"></em> Lorem ipsum dolor sit amet, consectetur.</li>
              </ul>
            </div>
            
            <div class="col-lg-4 col-md-6 col-12 subscribe-col mt-4 mt-md-0">
              <h5 class="font-weight-semibold mb-3 text-capitalize">{{ __('footer.subscribetoournewsletter') }} </h5>
              <p class="d-none" id="greeting">{{ __('footer.thank_you_for_your_subscription') }}</p>
              <form id="subscribeForm" method="get">
                {{csrf_field()}}
                <div class="input-group">
                  <input type="email" class="form-control" placeholder="{{__('ads.email')}}" id="email">
                  <input type="button" class="border-0 btn pl-3 pr-3 rounded-0 text-uppercase themebtn3" value="{{ __('footer.subscribe')}}" id="subscribe">
                </div>
              </form>
              <div>
              <h5 class="font-weight-semibold mb-3 text-capitalize mt-4">{{ __('footer.to_unsubscribe') }} <a href="{{ route('unsubscribe') }}"><span style="color: #0072BB;">{{ __('footer.click_here') }}</span></a></h5>
              </div>
              <h5 class="font-weight-semibold mb-2 mt-4">{{ __('footer.follow') }}:</h5>
              <ul class="d-inline-block list-unstyled social-media-links mb-0">
                <li class="list-inline-item mr-0"><a href="#" class="fa fa-facebook text-center rounded-circle"></a></li>
                <li class="list-inline-item mr-0"><a href="#" class="fa fa-twitter text-center rounded-circle"></a></li>
                <li class="list-inline-item mr-0"><a href="#" class="fa fa-linkedin text-center rounded-circle"></a></li>
                <li class="list-inline-item mr-0"><a href="#" class="fa fa-instagram text-center rounded-circle"></a></li>
              </ul>
            </div>
          </div>
          <div class="footer-copyright text-center">
            <p>{{ __('footer.copyright') }} © {{date("Y")}} Carish - {{ __('footer.allrightsreserved') }}</p>
            <ul class="list-unstyled mb-0">
              <li class="list-inline-item"><a href="{{ route('pages') }}">{{ __('footer.termsofservice') }}</a></li>
              <li class="list-inline-item"><a href="{{ route('pages') }}">{{ __('footer.privacy') }}</a></li>
            </ul>
          </div>
        </div>
      </footer>

<script >
window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="{{asset('public/js/jquery.min.js')}}"></script>
      <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>
<script src="https://www.google.com/recaptcha/api.js?hl=fr" async defer></script>
<script type="text/javascript">
  var onloadCallback = function() {
    //  var iframeGoogleCaptcha = $('.g-recaptcha').find('iframe');
    // // Get language code from iframe
    // var language = iframeGoogleCaptcha.attr("src").match(/hl=(.*?)&/).pop();
    // // Get selected language code from drop down
    // var selectedLanguage = "{{$activeLanguage['language_code']}}";
    // // Check if language code of element is not equal by selected language, we need to set new language code
    // if (language !== selectedLanguage) {
    //     // For setting new language 
    //     iframeGoogleCaptcha.attr("src", iframeGoogleCaptcha.attr("src").replace(/hl=(.*?)&/, 'hl=' + selectedLanguage + '&'));
    // }
  };
</script>
{{-- Sweet Alert --}}
<script  src="{{asset('public/js/sweetalert.min.js')}}"></script>
      <script type="text/javascript" src="{{url('public/admin/assets/js/datatables.min.js')}}"></script>
      <script src="{{asset('public/js/popper.min.js')}}"></script>
      <script src="{{ asset('public/js/select2.min.js')}}"></script>
      <script src="{{ asset('public/js/bootstrap-select.min.js')}}"></script>
     <script src="{{ asset('public/js/bootstrap.min.js')}}" ></script>
      <script src="{{asset('public/js/owl.carousel.min.js')}}"></script>
      <script src="{{asset('public/js/lightslider.js')}}"></script>
      <script src="{{asset('public/js/lightgallery-all.min.js')}}"></script>
      <script src="{{asset('public/js/toastr.min.js')}}"></script>
      <script src="{{asset('public/js/custom.js')}}"></script>
      <script src="{{asset('public/js/jquery.mousewheel.min.js')}}"></script>

      {{-- UploadHBR --}}
      <script src="{{ asset('public/js/uploadHBR.min.js') }}"></script>
      {{-- Modernizer --}}
      <script src="{{ asset('public/js/modernizr.min.js') }}"></script>

      {{-- jquery-ui --}}
      <script src="{{ asset('public/js/jquery-ui.js') }}"></script>
      
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-180079031-1"></script>

<script type="text/javascript">
  var subscriptionUrl = "{{url('customer/subscription')}}/"; 
          
      </script>
<script type="text/javascript" id="cookieinfo"
  src="//cookieinfoscript.com/js/cookieinfo.min.js"
  data-bg="#0072BB" data-fg="#FFFFFF" data-link="#FFFFFF" data-cookie="CarishTCforCookies" data-text-align="left" data-close-text="I Agree" data-divlinkbg="#67B500" data-linkmsg="PRIVACY POLICY" data-moreinfo="https://carish.ee/page" >
</script>



     <script src="{{ asset('public/js/app.js')}}"></script> 
@stack('scripts')
</body>
</html> 
