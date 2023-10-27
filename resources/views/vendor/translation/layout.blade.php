<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('/public/vendor/translation/css/main.css') }}">
<script type="text/javascript" src="https://code.jquery.com/jquery.min.js" charset="utf-8"></script> 

<!-- Bootstrap CSS -->
<link href="{{url('public/admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('public/assets/css/lightslider.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/css/lightgallery.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/owl.theme.default.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{url('public/admin/assets/css/style.css')}}" rel="stylesheet" type="text/css">


<!-- Toastr -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<link rel="stylesheet" type="text/css" href="{{url('public/admin/assets/css/datatables.min.css')}}"/>
<style type="text/css">
  .dataTables_scrollHeadInner{
    width: 100% !important;
  }
  .dataTable {
    width: 100% !important;
  }
  table.dataTable,
table.dataTable th,
table.dataTable td {
  -webkit-box-sizing: content-box !important;
  -moz-box-sizing: content-box !important;
  box-sizing: content-box !important;
}
.sales-coordinator-thead th
  {
    border: 1px solid black;
    text-align: left;
    padding: 5px;
  }
</style>


<!-- SweetAlert -->
<link rel='stylesheet' href="{{url('public/assets/css/sweetalert.min.css')}}">
<link href="{{asset('assets/admin/css/jquery-te-1.4.0.css')}}" rel="stylesheet" type="text/css" />

</head>
<body>

<div class="wrapper">
  <input type="hidden" id="site_url"  value="{{ url('') }}">
<header class="header color-white fixed-top">

<div class="toprow">
 <figure class="align-items-center justify-content-center d-flex logo">
  <a href="{{url('admin/dashboard')}}">
    <img src="{{url('public/admin/assets/img/logo-left.png')}}" style="height: 50px;" alt="carish used cars for sale in estonia" class="img-fluid lg-logo">
    <img src="{{url('public/admin/assets/img/small_logo.png')}}" style="height: 50px;" alt="carish used cars for sale in estonia" class="img-fluid sm-logo">
    
  </a>
</figure>
<div class="top-bar align-items-center d-flex justify-content-between">
  <div class="align-items-center col-3 col-lg-5 col-md-6 col-sm-2 d-flex pl-0 header-icons">
  <div class="backlink">
    <a href="javascript:avoid(0)" class="menuarrow fa fa fa-bars"></a>
  </div>
  </div>


  <!-- Header User Info Start Here -->
  <div class="col-lg-4 col-sm-10 col-md-11 col-9 userlinks">
    <ul class="align-items-center justify-content-end d-flex list-unstyled mb-0 userlist">
   {{--  <li class="nav-item dropdown userdropdown settingdropdown">
      <a class="align-items-center d-flex nav-link dropdown-toggle fa fa-cog" href="javascript:void(0)" id="usermessages" data-toggle="dropdown">
      </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="javascript:void(0)"><span class="dropdown-icon oi oi-person"></span> Profile</a>
          <a class="dropdown-item" href="javascript:void(0)">
            <span class="dropdown-icon oi oi-account-logout"></span> Logout
          </a>
          <!-- <div class="dropdown-divider"></div> -->
          
        </div>
    </li> --}}
    <li class="nav-item dropdown userdropdown ntifction-dropdown d-none">
       <a class="align-items-center d-flex nav-link dropdown-toggle  fa fa-bell-o" href="javascript:void(0)" id="usernotification" data-toggle="dropdown" aria-expanded="true">
        <!-- <img src="assets/img/notification.png" alt="notification image" class="img-fluid"> -->
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="usercol notinfo">
          <a href="javascript:void(0)" class="notiflink">
            <div class="notifi-name fontbold">Jessica Caruso</div> 
            <div class="notifi-desc">accepted your invitation to join the team.</div>
            <span class="notifi-date fontmed">2 min ago</span>
          </a>  
         </div>
         <div class="usercol notinfo">
           <a href="javascript:void(0)" class="notiflink">
            <div class="notifi-name fontbold">Jessica Caruso</div> 
            <div class="notifi-desc">accepted your invitation to join the team.</div>
            <span class="notifi-date fontmed">2 min ago</span>
          </a>  
         </div>
      </div>
    </li>
    <li class="nav-item dropdown prof-dropdown">
      <a class="align-items-center d-flex dropdown-toggle nav-link profilelink" href="javascript:void(0)" id="profilelink" data-toggle="dropdown">
        <span class="username text-center">{{\Illuminate\Support\Facades\Auth::user()->name}}<small class="d-block">Admin</small></span>
        <img src="{{url('public/admin/assets/img/user-img.jpg')}}" alt="user image" class="img-fluid rounded-circle img-fluid profileimg">
      </a>
      <div class="dropdown-menu">
          <a class="dropdown-item" href="{{url('admin/profile')}}"><span class="dropdown-icon oi oi-person"></span>Profile</a>
          <a href="{{ route('subadmin') }}" class="dropdown-item"><span class="dropdown-icon oi oi-person"></span>Add SubAdmin</a>

          <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <span class="dropdown-icon oi oi-account-logout"></span>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
          <!-- <div class="dropdown-divider"></div> -->
        </div>
    </li>
  </ul>
</div>
<!-- Header User Info End Here -->
</div>
</div>
</header>

<div class="main-content">
<aside class="sidebar color-white sidebarin">
<div class="sidebarbg"></div>  


<nav class="navbar sidebarnav navbar-expand-sm pt-md-4 pt-3">

<!-- Links -->
<ul class="menu w-100 list-unstyled">
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/dashboard')}}" title="Dashboard">
        <i class="fa fa-home"></i> <span>Dashboard</span></a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop2" data-toggle="dropdown"  title="Emails">
        <i class="fa fa-envelope" style="font-size: 18px"></i> <span>Languages </span></a>
        <div class="dropdown-menu">
          <a href="{{ route('languages.index') }}" class="dropdown-item">Languages</a>
        
        </div>
    </li>






<!-- <li class="nav-item">
      <a class="nav-link" href="{{url('admin/featured_requests')}}">
        <i class="fa fa-paper-plane"></i> <span>Request For Feature</span></a>
    </li> -->
<!-- 
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/customers_account')}}">
        <i class="fa fa-id-card" style="font-size: 18px;"></i> <span>Customers Account</span></a>
    </li> -->

     

  </ul>
</nav>
</aside>

<!-- Right Content Start Here -->
<div class="right-content">

<div class="modal" id="loader_modal" role="dialog">
<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-body">
      <h3 style="text-align:center;">Please wait</h3>
      <p style="text-align:center;"><img src="{{ asset('assets/admin/img/waiting.gif') }}"></p>
    </div>
  </div>
</div>
</div>
    
    <div id="app">
         
        @include('translation::notifications')
        
        @yield('body')
        
    </div>

   </div> <!-- main content end here -->
</div><!-- main content end here -->



<footer class="main-footer">
        <div class="" align="Center">
           <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="https://carish.ee">Carish</a>.</strong> All rights
        reserved. 
        </div>
        
    </footer>
 
    <script src="{{ asset('/public/vendor/translation/js/app.js') }}"></script>

<script src="{{url('public/admin/assets/js/popper.min.js')}}"></script>
<script src="{{url('public/admin/assets/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/admin/assets/js/datatables.min.js')}}"></script>
<script src="{{url('public/admin/assets/ckeditor/ckeditor.js')}}"></script>
<script>
    // CKEDITOR.replace( '' );
</script>  
<script src="{{url('public/admin/assets/js/menuscript.js')}}"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha256-3blsJd4Hli/7wCQ+bmgXfOdK7p/ZUMtPXY08jmxSSgk=" crossorigin="anonymous"></script>
 <script src="{{asset('public/js/owl.carousel.min.js')}}"></script>
      <script src="{{asset('public/js/lightslider.js')}}"></script>
      <script src="{{asset('public/js/lightgallery-all.min.js')}}"></script>

<!-- Sweet alert -->
<script src="{{url('public/assets/js/sweetalert.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/jquery-te-1.4.0.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function() {
    var activeurl = window.location;
  $('a[href="'+activeurl+'"]').parents().parents('li').addClass('active');
    $('#example').DataTable({
      lengthMenu: [100, 200, 300, 400],
      scrollY : '70vh',
      scrollCollapse: true,
    });
    setTimeout(function() { 
    $('.tox-notifications-container').css('display' , 'none');
        
    }, 2000);

    // $('.menuarrow').addClass('actarrow');
    // $('.sidebar').animate({width: '70px'}, 500).addClass('sidebarin');
    // $('.sidebarbg').animate({width: '70px'}, 500);
    // $('.logo').animate({width: '70px'}, 500).addClass('logoin');
});


$(document).ready(function() {
$('#image-gallery').lightSlider({
gallery:true,
item:1,
loop:true,
thumbItem:4,
slideMargin:0,
enableDrag: false,
currentPagerPosition:'left',
onSliderLoad: function(el) {
el.lightGallery({
selector: '#image-gallery .lslide'
});
$('#image-gallery').removeClass('cS-hidden');
}
});
});
// Go to Bottom function Start here
jQuery(function() {
$('.gotosect').click(function() {
$(this).parent('li').addClass('active');
// alert("Hello Testing")
 $(this).parent('li').siblings('li').removeClass('active');


  if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
  var target = $(this.hash);
  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
    if (target.length) {
    $('html, body').animate({
    scrollTop: target.offset().top  -50}, 500);
    return false;
    }
  };

});
});

(function($) {
  'use strict';
  $(function() {
    var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    $('.nav-item').each(function() {
      var $this = $(this);
      if (current === "") {
        // for root url
        if ($this.find(".nav-link").attr('href').indexOf("index.html") !== -1) {
          $(this).find(".nav-link").parents('.nav-item').last().addClass('active');
          $(this).addClass("active");
        }
      } else {
        //for other url
        var ind = -1;
        if($this.find(".nav-link").attr('href') !== undefined)
        {
          ind = $this.find(".nav-link").attr('href').indexOf(current);
        }
        
        if (ind !== -1) {
          $(this).find(".nav-link").parents('.nav-item').last().addClass('active');
          $(this).addClass("active");
        }
      }
    })
  });


})
(jQuery);
</script>
@stack('custom-scripts')
</body>
</html>