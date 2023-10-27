 @php
use App\Helpers\Helper;
use App\Helpers\StaticHelpers;
 $helper = new Helper;
$cities = StaticHelpers::getCities();
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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
    <title>{{ config('app.name') }} | @yield('title')</title>   
    <!-- Bootstrap CSS -->
    <link rel="icon" href="{{ asset('public/assets/img/favicon.png')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/owl.theme.default.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link href="{{ asset('public/assets/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/css/select2-bootstrap4.css') }}" rel="stylesheet"> 
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet" type="text/css">

    @stack('styles')
    <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};
    </script>
  </head>
  
  <body>
     <!-- header Starts here -->
      <header class="header">
        <div class="container">
          <div class="topbar py-2 d-md-block d-none">
            <div class="row">
              <div class="col-12 text-right topbar-links">

                  <ul class="d-inline-block list-unstyled mb-0">
                  <li class="dropdown list-inline-item lingdropdown">
                    <a class="dropdown-toggle" href="{{ url('locale/en') }}" id="linguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag-icon flag-icon-us"></span> English</a>
                    <div class="dropdown-menu  dropdown-menu-right mt-2 dropdown-top-border cstm-dropdown-menu" aria-labelledby="linguage">
                      <a class="dropdown-item" href="{{ url('locale/et') }}"><span class="flag-icon flag-icon-ee"></span> Estonian</a>
                      <a class="dropdown-item" href="{{ url('locale/ru') }}"><span class="flag-icon flag-icon-ru"></span> Russian</a>
                    </div>
                  </li>
                  
                @guest  
                @if (Route::has('register'))
                  <li class="dropdown list-inline-item logOut-item">
                    <a target="" href="{{ route('signin') }}">{{ __('signin_link') }}</a> <em class="fa fa-sign-in"></em></a>
                  </li>
                  <li class="dropdown list-inline-item logOut-item">
                    <a target="" href="{{ route('signup') }}">{{ __('signup_link') }}</a> <em class="fa fa-sign-out"></em></a>
                  </li> 
                 @endif

                 @else
                  <li class="dropdown list-inline-item logIn-item">Welcome
                  <a class="dropdown-toggle" href="#" id="loginDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="font-weight-semibold">{{ Auth::user()->name }}</span> </a> | <em class="fa fa-envelope"></em>
                  <div class="dropdown-menu dropdown-menu-right mt-3 dropdown-top-border cstm-dropdown-menu" aria-labelledby="loginDropdown">
                    <a class="dropdown-item" href="{{url('my-profile')}}">My Profile</a>
                    <a class="dropdown-item" href="#">My Ads</a>
                    <a class="dropdown-item" href="#">My Save Ads</a>
                    <a class="dropdown-item" href="#">Alerts</a>
                    <a class="dropdown-item" href="#">Messages</a>
                    <a class="dropdown-item" href="#">Change Password</a>
                    <a class="dropdown-item" href="#">Payment</a>
                    <a class="dropdown-item" href="{{ route('logoff') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"> {{ __('Sign Out') }}</a>
                    <form id="logout-form" action="{{ route('logoff') }}" method="POST" style="display: none;">
                    @csrf
                    </form>
                    </div>
                  </li>
                @endguest

                </ul>

              </div>
            </div>
          </div>
          <div class="align-items-end mt-3 row">
            <div class="col-xl-auto col-lg-auto col-md-2 logo d-none d-md-block">
              <a href="index.html"><img src="{{ asset('public/assets/img/logo.png')}}" class="img-fluid" alt="carish used cars for sale in estonia"></a>
            </div>
            
            <nav class="col-xl-auto col-lg-auto col-md-7 col-12 font-weight-semibold ml-auto navbar navbar-expand-md text-capitalize pb-0 pt-0">
              <!-- Brand -->
              <div class="align-items-center d-flex d-md-none navbar-header w-100">
                <!-- Toggler/collapsibe Button -->
                <button class="navbar-toggler border-0 p-0" type="button"> <span class="fa fa-bars"></span> </button>

                <a href="index.html" class="navbar-brand mx-auto">
                  <img src="{{ asset('public/assets/img/logo.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
                </a>
              </div>
              <!-- Navbar links -->
              <div class="collapse navbar-collapse" id="collapsibleNavbar">



                 <ul class="navbar-nav ml-auto d-md-none">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ url('locale/en') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag-icon flag-icon-us"></span> aaa English</a>
                    <div class="dropdown-menu" aria-labelledby="linguage">
                      <a class="dropdown-item" href="{{ url('locale/et') }}"><span class="flag-icon flag-icon-ee"></span> Estonian</a>
                      <a class="dropdown-item" href="{{ url('locale/ru') }}"><span class="flag-icon flag-icon-ru"></span> Russian</a>
                    </div>
                  </li>
              @guest  
                @if (Route::has('register'))
                  <li class="nav-item logOut-item">
                    <a class="nav-link"  href="{{ route('signin') }}">{{ __('signin_link') }}"  <em class="fa fa-sign-in"></em></a>
                  </li>
                  <li class="nav-item logOut-item">
                    <a class="nav-link" href="{{ route('signup') }}">{{ __('signup_link') }} <em class="fa fa-sign-out"></em></a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Post an Ad</a>
                    <div class="dropdown-menu">
                      <a target="" href="{{ url('locale/ru') }}" class="dropdown-item">Sell Car</a>
                      <a target="" href="{{ url('locale/ru') }}" class="dropdown-item">Sell Autoparts</a>
                      <a target="" href="{{ url('locale/ru') }}" class="dropdown-item">Offer Service</a>
                    </div>
                  </li>  
                @endif
              @endguest
                </ul>

                <ul class="navbar-nav ml-auto">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Cars</a>
                    <div class="dropdown-menu">
                      <a href="#" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/find-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">Find Used Cars</h5>
                          <p class="mb-0">Browse over 160k options</p>
                        </div>
                      </a>
                      <a href="#" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/featured-car-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">Featured Used Cars</h5>
                          <p class="mb-0">View Featured Cars by Carish</p>
                        </div>
                      </a>
                      <a href="#" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/sell-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">Sell Your Car</h5>
                          <p class="mb-0">Post a free ad sell your car quickly</p>
                        </div>
                      </a>
                      <a href="#" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/car-dealer-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">Used Car Dealers</h5>
                          <p class="mb-0">Browse over 160k options</p>
                        </div>
                      </a>
                      <a href="car-comparison.html" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/car-comparison-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">Car Comparison</h5>
                          <p class="mb-0">Compare cars and find their difference</p>
                        </div>
                      </a>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Autoparts</a>
                    <div class="dropdown-menu">
                      <a href="#" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/find-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">Find Autoparts</h5>
                          <p class="mb-0">Browse over 130k autoparts</p>
                        </div>
                      </a>
                      <a href="#" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/sell-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">Sell Autoparts</h5>
                          <p class="mb-0">Post a free ad sell your Autoparts Quickly</p>
                        </div>
                      </a>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Find</a>
                    <div class="dropdown-menu">
                      <a href="#" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/vehicle-repair-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">Car Mechanics</h5>
                          <p class="mb-0">Lorem Ipsum is simply dummy text</p>
                        </div>
                      </a>
                      <a href="#" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/car-wash.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">Car Wash</h5>
                          <p class="mb-0">Lorem Ipsum is simply dummy text</p>
                        </div>
                      </a>
                      <a href="#" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/parking-lot-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">Parking Lots</h5>
                          <p class="mb-0">Lorem Ipsum is simply dummy text</p>
                        </div>
                      </a>
                      <a href="#" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/driving-center.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">Driving Center</h5>
                          <p class="mb-0">Lorem Ipsum is simply dummy text</p>
                        </div>
                      </a>
                      <a href="#" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/more-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">More</h5>
                          <p class="mb-0">Lorem Ipsum is simply dummy text</p>
                        </div>
                      </a>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">More</a>
                    <div class="dropdown-menu">
                      <a href="tags.html" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/tag-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">tags</h5>
                          <p class="mb-0">Lorem Ipsum is simply dummy text</p>
                        </div>
                      </a>
                      <a href="term-condition.html" class="d-flex dropdown-item">
                        <span class="mb-0">
                          <img src="{{ asset('public/assets/img/terms-condition-icon.png')}}" alt="carish used cars for sale in estonia" class="img-fluid">
                        </span>
                        <div class="pl-1">
                          <h5 class="mb-0 font-weight-semibold">Terms & Condition</h5>
                          <p class="mb-0">Lorem Ipsum is simply dummy text</p>
                        </div>
                      </a>
                    </div>
                  </li>
                </ul>
              </div>
            </nav>
            <div class="col-xl-auto col-lg-auto col-md-3 col-sm-2 header-btn text-right d-none d-md-block">
              <div class="dropdown">
                <a class="dropdown-toggle btn font-weight-semibold w-100 themebtn2 " href="#" data-toggle="dropdown">
                  Post an Ad
                </a>
                <div class="dropdown-menu dropdown-top-border cstm-dropdown-menu">
                  <a target="" href="{{ route('logout') }}" class="dropdown-item">Sell Car</a>
                  <a target="" href="{{ route('logout') }}" class="dropdown-item">Sell Autoparts</a>
                  <a target="" href="{{ route('logout') }}" class="dropdown-item">Offer Service</a>
                </div>
              </div>
            </div>
          </div>
        </header>
        <!-- header Ends here -->

       {{-- <ul class="nav navbar-nav">
        @foreach($helper->getCategoryOf(0) as $menueTop)
          <li><a target="" href="{{ url('/categories?cPath='.$menueTop->id) }}" title="{{ $menueTop->categoryDescription->category_name }}">{{ $menueTop->categoryDescription->category_name }}</a></li> 
          @endforeach --}}
       
@yield('banner')
@yield('content') 
  <!-- Cars Parts & Accessories Ends here -->
      <footer class="footer pb-5 pt-5 text-white">
        <div class="container">
          <div class="justify-content-between row">
            <div class="col-lg-6 col-md-6 col-12 address-col">
              <h5 class="font-weight-semibold text-uppercase mb-3">Find us:</h5>
              <ul class="list-unstyled">
                <li class="d-flex"><em class="fa fa-phone-square"></em> <strong>Call us (000) 111 11111</strong></li>
                <li class="d-flex"><em class="fa fa-envelope"></em> <a href="mailto:support@carish.com">support@carish.com</a></li>
                <li class="d-flex"><em class="fa fa-map-marker"></em> Lorem ipsum dolor sit amet, consectetur.</li>
              </ul>
            </div>
            <div class="col-lg-4 col-md-6 col-12 subscribe-col mt-4 mt-md-0">
              <h5 class="font-weight-semibold mb-3 text-capitalize">Subscribe to our Newsletter</h5>
              <form class="subscribeForm">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search products">
                  <input type="submit" class="border-0 btn pl-3 pr-3 rounded-0 text-uppercase" value="SUBSCRIBE">
                </div>
              </form>
              <h5 class="font-weight-semibold mb-3">Follow Us On:</h5>
              <ul class="d-inline-block list-unstyled social-media-links mb-0">
                <li class="list-inline-item"><a href="#" class="fa fa-facebook text-center rounded-circle"></a></li>
                <li class="list-inline-item"><a href="#" class="fa fa-twitter text-center rounded-circle"></a></li>
                <li class="list-inline-item"><a href="#" class="fa fa-linkedin text-center rounded-circle"></a></li>
                <li class="list-inline-item"><a href="#" class="fa fa-instagram text-center rounded-circle"></a></li>
              </ul>
            </div>
          </div>
          <div class="footer-copyright text-center">
            <p>Copyright © 2003 - 2019 Carish - All Rights Reserved.</p>
            <ul class="list-unstyled mb-0">
              <li class="list-inline-item"><a href="#">Terms of Service</a></li>
              <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
            </ul>
          </div>
        </div>
      </footer>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
      <script src="{{asset('public/assets/js/owl.carousel.min.js')}}"></script>
      <script src="{{asset('public/assets/js/custom.js')}}"></script>
      <script type="text/javascript" charset="utf-8" defer>
            $(document).ready(function ()
              {
                $('header.header').addClass('home-header')
              });
              </script>
</body>

@stack('scripts')
</html> 
