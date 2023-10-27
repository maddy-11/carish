@php
use App\Helpers\Helper;
use App\Models\Customers\SubService;
use App\Models\Customers\PrimaryService;
$helper = new Helper;
$activeLanguage = \Session::get('language');
$GeneralSetting = session('GeneralSetting');
$carDealer = PrimaryService::where('slug', 'car-dealer')->first();
$usedCarDealer = SubService::where('slug', 'used-car-dealer')->first();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="google-site-verification" content="N_KrhGF-2aT5FlQruBQDZ1tVkLWBwPUtjmjpqCzzQH0" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBE8JDB7X8"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-GBE8JDB7X8');
    </script>
    <!-- Carish Website is now on github and checking my second commit to this repo. -->
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
     
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_token" content="{{csrf_token()}}" />
    <title>{{ config('app.name', $GeneralSetting->title) }} | @yield('title')</title>

    <meta name="keywords" content="{{ __('header.keywords') }}">
    <meta name="description" content="{{ config('app.name', $GeneralSetting->title) }}  – {{ __('header.metaDescription') }}">
    <link rel="canonical" href="https://carish.ee/"/>


    <!-- Bootstrap CSS -->
     <link rel="icon" href="{{ asset('public/uploads') }}/{{$GeneralSetting->favicon}}" media="all">
    <link rel="stylesheet" media="all" href="{{ asset('public/assets/css/owl.carousel.css') }}" type="text/css">
    <link rel="stylesheet" media="all" href="{{ asset('public/assets/css/owl.theme.default.css')}}" type="text/css">
    <link rel="stylesheet" media="all" href="{{ asset('public/assets/css/bootstrap.min.css') }}" crossorigin="anonymous" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet" media="all" type="text/css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="all" type="text/css">
    <link href="{{ asset('public/assets/css/select2.min.css')}}" rel="stylesheet" media="all" />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" media="all" href="{{ asset('public/assets/css/bootstrap-select.min.css')}}" type="text/css">
    <link href="{{ asset('public/assets/css/select2.min.css') }}" rel="stylesheet" media="all" type="text/css" />
   
    <link href="{{ asset('public/assets/css/select2-bootstrap4.css') }}" rel="stylesheet" media="all" type="text/css">
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet" media="all" type="text/css">
    <link href="{{asset('public/css/toastr.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('public/css/responsive.min.css')}}" rel="stylesheet" media="all">
    <!-- Parsley for validation -->
    <link href="{{ asset('public/assets/css/parsley.css')}}" rel="stylesheet" media="all" type="text/css">
    <link rel="stylesheet" media="all" href="{{ asset('public/assets/css/jquery-ui.css')}}" type="text/css">
    @stack('styles')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-B66QWEMY1J"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-B66QWEMY1J');
    </script>    
    <meta property="og:url" content="https://carish.ee/" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="Carish – Used Cars For Sale" />
    <meta property="og:description"   content="Carish is one the best platform where you can easily buy the used cars. Used cars for sale, used cars for sale in Estonia, carish" />
    <meta property="og:image" content="https://carish.ee/public/assets/img/logo.png" />
    <meta name="twitter:card" content="Summary" />
    <meta name="twitter:site" content="@carish" />
    <meta name="twitter:creator" content="@carish" />
    <meta property="og:url" content="https://carish.ee/" />
    <meta property="og:title" content="Carish – Used Cars For Sale in Estonia" />
    <meta property="og:description" content="Carish is one of the best platform where you can easily buy the used cars. Used cars for sale, used cars for sale in Estonia." />
    <meta property="og:image" content="https://carish.ee/public/assets/img/logo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.26/sweetalert2.css" />
</head>
<body>
    <!-- header Starts here -->
    <header class="header">
        <div class="container">
            <input type="hidden" id="site_url" value="{{ url('') }}">
            <div class="topbar py-2">
                <div class="row">
                    <div class="col-12 text-right  topbar-links">
                        <ul class="d-inline-block list-unstyled mb-0">
                            <li class="dropdown list-inline-item lingdropdown">
                                @if(App::isLocale('en'))
                                <a class="dropdown-toggle" title="" href="{{url('locale/en') }}" data-id="{{url('locale/en') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag-icon flag-icon-us"></span></a>
                                @elseif(App::isLocale('et'))
                                <a class="dropdown-toggle"  title="" href="{{url('locale/et') }}" data-id="{{url('locale/et') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag-icon flag-icon-ee"></span></a>
                                @else
                                <a class="dropdown-toggle" title="" href="{{url('locale/ru') }}" data-id="{{url('locale/ru') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag-icon flag-icon-ru"></span></a>
                                @endif
                                <div class="dropdown-menu  dropdown-menu-right mt-2 dropdown-top-border cstm-dropdown-menu" aria-labelledby="linguage" style="min-width: 2rem;">
                                    @if(!App::isLocale('en'))
                                    <a class="dropdown-item linguage" title="" href="{{ url('locale/en') }}" data-id="{{ url('locale/en') }}"><span class="flag-icon flag-icon-us"></span></a>
                                    @endif
                                    @if(!App::isLocale('et'))<a class="dropdown-item linguage" title="Estonian" href="{{ url('locale/et') }}" data-id="{{ url('locale/et') }}"><span class="flag-icon flag-icon-ee"></span></a>
                                    @endif
                                    @if(!App::isLocale('ru'))
                                    <a class="dropdown-item linguage" title="" href="{{ url('locale/ru') }}" data-id="{{ url('locale/ru') }}"><span class="flag-icon flag-icon-ru"></span></a>
                                    @endif
                                </div>
                            </li>
                            @guest('customer')
                            <li class="dropdown list-inline-item logOut-item">
                                <a href="{{ route('signin') }}">{{ __('header.signIn') }}<em class="fa fa-sign-in"></em></a>
                            </li>
                            <li class="dropdown list-inline-item logOut-item">
                                <a href="{{ route('signup') }}">{{__('header.signUp')}}<em class="fa fa-sign-out"></em></a>
                            </li>
                            @endguest
                            @auth('customer')
                            @php
                            $messages_count = $helper->countMessages();
                            $messagesNew = $helper->customerMessages();
                            @endphp
                            <li class="dropdown list-inline-item logIn-item">
                                <a class="dropdown-toggle" href="#" id="loginDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="font-weight-semibold">{{__('header.welcome')}}
                                        {{ Auth::guard('customer')->user()->customer_company }}</span> </a> |
                                {{-- <em class="fa fa-envelope" style="position: relative;"><span style="position: absolute;top: -3px;right: -3px;background: #0072BB;color: white;border-radius: 50%;font-size: 12px;padding: 0 2px;">{{@$messages_count}}</span></em>--}}
                                <div class="dropdown-menu dropdown-menu-right dropdown-top-border cstm-dropdown-menu" aria-labelledby="loginDropdown">
                                    @if(@Auth::guard('customer')->user()->customer_role == 'individual')
                                    <a class="dropdown-item" href="{{route('change.profile')}}">{{__('header.myProfile')}}
                                    </a>
                                    @else
                                    <a class="dropdown-item" href="{{route('my.business.profile')}}">{{__('header.myProfile')}}</a>
                                    @endif
                                    <a class="dropdown-item" href="{{route('my-ads')}}">{{__('header.myAds')}}</a>
                                    <a class="dropdown-item" href="{{route('my-saved-ads')}}">{{__('header.savedAds')}}</a>
                                    <a class="dropdown-item" href="{{route('my-alerts')}}">{{__('header.alerts')}}</a>
                                    <a class="dropdown-item" href="{{route('my-messages')}}">{{__('header.messages')}}</a>
                                    <a class="dropdown-item" href="{{route('change-password')}}">{{__('header.changePassword')}}</a>
                                    <a class="dropdown-item" href="{{route('my-payment')}}">{{__('header.payment')}}</a>
                                    <a class="dropdown-item" href="{{ route('logoff') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"> {{ __('header.signOut') }}</a>
                                    <form id="logout-form" action="{{ route('logoff') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                            <li class="dropdown list-inline-item logOut-item">
                                <div class="dropdown cstm-dropdown-menu">
                                    <i class="fa fa-envelope dropdown-toggle" data-toggle="dropdown" style="position: relative;"><span style="position: absolute;top: -3px;right: -3px;background: #0072BB;color: white;border-radius: 50%;font-size: 12px;padding: 0 2px;">{{@$messages_count}}</span></i>
                                    <div class="dropdown-menu dropdown-menu-right" style="padding: 0px;box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.25);max-width: 290px;">
                                        {{--@foreach($messagesNew as $showMessages)
                            <a class="dropdown-item" style="padding: 5px 5px" href="{{route('my.message.detail',['id'=>@$showMessages->chat_id])}}#m">
                                        <div class="d-flex">
                                            <div class="pull-left">
                                                @if($showMessages->sender->logo != null &&
                                                file_exists(public_path().'/uploads/customers/logos/'.$showMessages->sender->logo))
                                                <img src="{{asset('public/uploads/customers/logos/'.@$showMessages->sender->logo)}}" alt="profile image" width="30px" height="30px">
                                                @else
                                                <img src="data:image/png;base64,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" style="width: 30px">
                                                @endif
                                            </div>
                                            <div class="" style="padding: 0px 5px">
                                                <p class="m-0">
                                                    <b class="m-0">{{$showMessages->sender->customer_firstname}}
                                                        {{$showMessages->sender->customer_lastname}}</b>
                                                    <i class="fa fa-star pull-right messages-star"></i>
                                                </p>
                                                <p class="m-0">@php
                                                    echo substr($showMessages->message,0,25); @endphp ...</p>
                                                <!-- <p class="m-0"><i class="fa fa-clock-o"> </i></p> -->
                                            </div>
                                        </div>
                                        </a>
                                        <hr class="m-0">
                                        @endforeach --}}
                                        <a class="dropdown-item text-center" style="padding: 5px 5px" href="{{route('my-messages')}}#m">
                                            {{ __('header.seeAllMessages') }}
                                        </a>

                                    </div>
                                </div>
                            </li>

                            @endauth

                        </ul>


                    </div>
                </div>
            </div>
            <div class="align-items-end mt-3 row">
                <div class="col-xl-auto col-lg-auto col-md-2 logo d-none d-md-block">
                    <a href="{{ url('/') }}">
                        @if(Route::getCurrentRoute()->uri() == '/')
                        <img src="{{ asset('public/assets/img/logo.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
                        @else
                        <img src="{{ asset('public/assets/img/logo2.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
                        @endif
                    </a>
                </div>
                <nav class="col-xl-auto col-lg-auto col-md-7 col-12 font-weight-semibold ml-auto navbar navbar-expand-md text-capitalize pb-0 pt-0">
                    <!-- Brand -->
                    <div class="align-items-center d-flex d-md-none navbar-header w-100">
                        <a href="{{ url('/') }}" class="navbar-brand mr-auto">
                            @if(Route::getCurrentRoute()->uri() == '/')
                            <img src="{{ asset('public/assets/img/logo.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
                            @else
                            <img src="{{ asset('public/assets/img/logo2.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
                            @endif
                        </a>
                        <div class="header-btn text-right mr-3 d-md-none">
                            <div class="dropdown">
                                <a class="dropdown-toggle btn font-weight-semibold w-100 themebtn2" href="#" data-toggle="dropdown">{{ __('header.menuPostAnAd') }}</a>
                                <div class="dropdown-menu dropdown-top-border cstm-dropdown-menu">
                                    <a href="{{ url('user/post-car-ad') }}" class="dropdown-item">{{ __('header.sellCar') }}</a>
                                    <a href="{{ route('sparepartads') }}" class="dropdown-item">{{ __('header.sellAutoParts') }}</a>
                                    @if(@Auth::guard('customer')->user()->customer_role == 'business')
                                    <a href="{{ route('offerservices') }}" class="dropdown-item">{{ __('header.offerService') }}</a>
                                    @endif
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
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{ __('header.menuCar') }}</a>
                                <div class="dropdown-menu">
                                    <a href="{{ route('findusedcars') }}" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/find-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            <h5 class="mb-0 font-weight-semibold">{{ __('header.findUsedCars') }}
                                            </h5>
                                            <p class="mb-0">{{ __('header.usedCarDealerDetailText') }}</p>
                                        </div>
                                    </a>
                                    <a href="{{route('simple.search')}}/list/isf_featured" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/featured-car-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            <h5 class="mb-0 font-weight-semibold">{{ __('header.featuredUsedCars') }}
                                            </h5>
                                            <p class="mb-0">{{ __('header.featuredUsedCarsDetailText') }}</p>
                                        </div>
                                    </a>
                                    <a href="{{ route('car.sell') }}" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/sell-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            <h5 class="mb-0 font-weight-semibold">{{ __('header.sellYourCar') }}</h5>
                                            <p class="mb-0">{{ __('header.sellYourCarDetailText') }}</p>
                                        </div>
                                    </a>
                                    <a href="{{ url('find-car-services/'.$carDealer->slug.'/'.$usedCarDealer->slug) }}" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/car-dealer-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            <h5 class="mb-0 font-weight-semibold">{{ __('header.usedCarDealer') }}</h5>
                                            <p class="mb-0">{{ __('header.usedCarDealerDetailText') }}</p>
                                        </div>
                                    </a>
                                    <a href="{{ route('compare') }}" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/car-comparison-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            <h5 class="mb-0 font-weight-semibold">{{ __('header.carComparison') }}</h5>
                                            <p class="mb-0">{{ __('header.carComparisonDetailText') }}</p>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{ __('header.menuAutoParts') }}</a>
                                <div class="dropdown-menu">
                                    <a href="{{ route('findautoparts') }}" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/find-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            <h5 class="mb-0 font-weight-semibold">{{ __('header.findAutoParts') }}
                                            </h5>
                                            <p class="mb-0">{{ __('header.findAutoPartsDetail') }}</p>
                                        </div>
                                    </a>
                                    <a href="{{ route('autoparts.sell') }}" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/sell-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            <h5 class="mb-0 font-weight-semibold">{{ __('header.sellAutoParts') }}
                                            </h5>
                                            <p class="mb-0">{{ __('header.sellAutoPartsDetailText') }} </p>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{ __('header.menuFind') }}</a>
                                <div class="dropdown-menu">
                                    @php
                                    $primaryServices =
                                    App\Models\Customers\PrimaryService::where('status',1)->limit(4)->get();

                                    @endphp
                                    @foreach($primaryServices as $ps)
                                    <a href="{{url('find-car-services/'.$ps->slug)}}" id="ps_{{$ps->slug}}" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/vehicle-repair-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            @php
                                            $p_caty =
                                            $ps->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first();
                                            @endphp
                                            <h5 class="mb-0 font-weight-semibold">
                                                {{$p_caty !== null ? $p_caty : 'null'}}
                                            </h5>
                                        </div>
                                    </a>
                                    @endforeach
                                    <a href="{{ route('services.sell') }}" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/vehicle-repair-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            <h5 class="mb-0 font-weight-semibold">{{ __('header.sellCarServices') }}</h5>
                                        </div>
                                        
                                    </a>
                                    <a href="{{ route('allservices') }}" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/more-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            <h5 class="mb-0 font-weight-semibold">{{ __('header.more') }}</h5>
                                        </div>

                                    </a>
                                    
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{ __('header.menuMore') }}</a>
                                <div class="dropdown-menu">
                                    <a href="{{ route('tags') }}" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/tag-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            <h5 class="mb-0 font-weight-semibold">{{ __('header.tags') }}</h5>
                                        </div>
                                    </a>
                                    <a href="{{ route('terms-of-service') }}" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/terms-condition-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            <h5 class="mb-0 font-weight-semibold">{{ __('header.termsAndConditions') }}
                                            </h5>
                                        </div>
                                    </a>
                                    <a href="{{ route('useful-information') }}" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/terms-condition-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            <h5 class="mb-0 font-weight-semibold">{{ __('header.usefulInformation') }}
                                            </h5>
                                        </div>
                                    </a>
                                    <a href="{{ route('faqs') }}" class="d-flex dropdown-item">
                                        <span class="mb-0">
                                            <img src="{{ asset('public/assets/img/terms-condition-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                                        </span>
                                        <div class="ml-2 pl-1">
                                            <h5 class="mb-0 font-weight-semibold">{{ __('header.faq') }}</h5>
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
                            {{ __('header.menuPostAnAd') }}
                        </a>
                        <div class="dropdown-menu dropdown-top-border cstm-dropdown-menu" style="top: 37px;">
                            <a href="{{ url('user/post-car-ad') }}" class="dropdown-item">{{ __('header.sellCar') }}</a>
                            <a href="{{ route('sparepartads') }}" class="dropdown-item">{{ __('header.sellSparePart') }}</a>
                            @if(@Auth::guard('customer')->user()->customer_role == 'business')
                            <a href="{{ route('offerservices') }}" class="dropdown-item">{{ __('header.offerService') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--header Ends here -->
    @yield('banner')
    @yield('content')
    <div id="overlay-loader">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
    <div class="alert alert-success " style="display: none" id="successmsg"></div>
    <footer class="footer pb-5 pt-5 text-white">
        <div class="container">
            <div class="justify-content-between row">
                <div class="col-lg-6 col-md-6 col-12 address-col">
                    <h5 class="font-weight-semibold text-uppercase mb-3">{{ __('footer.findUs') }}:
                    </h5>
                    <ul class="list-unstyled">
                        <li class="d-flex"><em class="fa fa-phone-square"></em> <strong>{{ __('footer.callUs') }} {{$GeneralSetting->phone_number}}</strong></li>
                        <li class="d-flex"><em class="fa fa-envelope"></em> <a href="mailto:{{$GeneralSetting->business_email}}">{{$GeneralSetting->business_email}}</a>
                        </li>
                        <li class="d-flex"><em class="fa fa-map-marker"></em> {{$GeneralSetting->address}}</li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 col-12 subscribe-col mt-4 mt-md-0">
                    <h5 class="font-weight-semibold mb-3 text-capitalize">{{ __('footer.subscribeToOurNewsletter') }}
                    </h5>
                    <form id="subscribeForm" method="get">
                        {{csrf_field()}}
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="{{__('footer.Email')}}" id="email">
                            <input type="button" class="border-0 btn pl-3 pr-3 rounded-0 text-uppercase themebtn3" value="{{ __('footer.subscribeButton')}}" id="subscribe">
                        </div>
                    </form>
                     <p class="d-none" id="greeting"></p>
                    <div>
                        <h5 class="font-weight-semibold mb-3 text-capitalize mt-4">{{ __('footer.toUnsubscribe') }} <a href="{{ route('unsubscribe') }}"><span style="color: #0072BB;">{{ __('footer.clickHere') }}</span></a></h5>
                    </div>
                    <h5 class="font-weight-semibold mb-2 mt-4">{{ __('footer.FollowUs') }}:</h5>
                    <ul class="d-inline-block list-unstyled social-media-links mb-0">
                         <li class="list-inline-item mr-0"><a href="{{$GeneralSetting->facebook_link}}" class="fa fa-facebook text-center rounded-circle"></a></li>
                        <li class="list-inline-item mr-0"><a href="{{$GeneralSetting->twitter_link}}" class="fa fa-twitter text-center rounded-circle"></a></li>
                        <li class="list-inline-item mr-0"><a href="{{$GeneralSetting->linkedin_link}}" class="fa fa-linkedin text-center rounded-circle"></a></li>
                        <li class="list-inline-item mr-0"><a href="{{$GeneralSetting->instagram_link}}" class="fa fa-instagram text-center rounded-circle"></a></li>

                    </ul>
                </div>
            </div>
            <div class="footer-copyright text-center">
                <p>{{ __('footer.copyRightReserved') }}</p>
                <ul class="list-unstyled mb-0">
                    <li class="list-inline-item"><a href="{{ route('terms-of-service') }}">{{ __('footer.termsOfService') }}</a></li>
                    <li class="list-inline-item"><a href="{{ route('privacy-policy') }}">{{ __('cookies.privacyPolicy') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
    <script type="text/javascript">
        var subscriptionUrl = "{{url('customer/subscription')}}/";
        window.Laravel = {!!json_encode(['csrfToken' => csrf_token(), ]) !!};
        var selectedLanguage = "{{$activeLanguage['language_code']}}";
    </script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('public/js/jquery.min.js')}}"></script>
    <script src="{{asset('public/js/popper.min.js')}}"></script>
    <script src="{{ asset('public/js/select2.min.js')}}"></script>
    <script src="{{ asset('public/js/bootstrap-select.min.js')}}"></script>
    <script src="{{ asset('public/js/bootstrap.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{asset('public/js/toastr.min.js')}}"></script>
    <script src="{{asset('public/js/jquery.mousewheel.min.js')}}"></script>
    {{-- Modernizer --}}
    <script src="{{ asset('public/js/modernizr.min.js') }}"></script>
    {{--jquery-ui--}}
    <script src="{{ asset('public/js/jquery-ui.js') }}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script src="https://www.googletagmanager.com/gtag/js?id=UA-180079031-1" async defer></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LdSgtYdAAAAAAx4aR222-f77cIkJ0ZB4fWf5oKk"></script>
    <script>
      grecaptcha.ready(function() {
          grecaptcha.execute('6LdSgtYdAAAAAAx4aR222-f77cIkJ0ZB4fWf5oKk', {action: 'homepage'}).then(function(token) {
            $("#g-recaptcha-response").val(token);
          });
      });
    </script>      
    <script async defer type="text/javascript" id="cookieinfo" src="//cookieinfoscript.com/js/cookieinfo.min.js" data-bg="#0072BB" data-fg="#FFFFFF" data-link="#FFFFFF" data-cookie="CarishTCforCookies" data-text-align="left" data-close-text="{{ __('cookies.buttonText') }}" data-divlinkbg="#67B500" data-linkmsg="{{ __('cookies.privacyPolicy') }}" data-moreinfo="https://carish.ee/privacy-policy" data-message="{{ __('cookies.text') }}"></script>
    <script src="{{asset('public/js/custom.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.26/sweetalert2.all.js"></script>
    <script>

    $('#overlay-loader').fadeIn();
    $( window ).on( "load", function() {
        $('#overlay-loader').fadeOut();
    });

    /* MUTAHIR SCRIPT FOR MAKE MODEL VERSION */
      $(document).ready(function(){
        $(document).on( 'click','.linguage', function(e) { 
            e.preventDefault();
            var language = $(this).data('id');
            $.ajax({
                url:language,
                method:'get'
            }).done(function(data){
                location.reload();
            });
        });
        //     setTimeout(function(){
        // $('#overlay-loader').fadeOut();
        // },2000);
    });

    </script>
    @stack('scripts')
</body>
</html>