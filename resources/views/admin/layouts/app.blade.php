<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="_token" content="{{csrf_token()}}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name') }} | Dashboard</title>
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
        <span class="username text-center">{{\Illuminate\Support\Facades\Auth::user()->name}}<small class="d-block">{{\Illuminate\Support\Facades\Auth::user()->roles->name}}</small></span>
        <img src="{{url('public/admin/assets/img/user-img.jpg')}}" alt="user image" class="img-fluid rounded-circle img-fluid profileimg">
      </a>
      <div class="dropdown-menu">
          <a class="dropdown-item" href="{{url('admin/profile')}}"><span class="dropdown-icon oi oi-person"></span>Profile</a>
           @if(Auth::user()->role_id == 1)
          <a href="{{ route('subadmin') }}" class="dropdown-item"><span class="dropdown-icon oi oi-person"></span>Add SubAdmin</a>
          @endif

          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
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
    @if(in_array('dashboard',$user_role_menus))  
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/dashboard')}}" title="Dashboard">
        <i class="fa fa-home"></i> <span>Dashboard</span></a>
    </li>
    @endif
    @if(in_array('car_ads',$user_role_menus)) 
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop2" data-toggle="dropdown"  title="Car Ads">
        <i class="fa"> <img src="{{url('public/admin/assets/img/Group 538.png')}}" style="height: 30px;position: absolute;top: -5px;left: -6px;" alt="carish used cars for sale in estonia" class="  sm-logo"></i> <span>Car Ads</span></a>
        <div class="dropdown-menu">
<a href="{{url('admin/car-ads-list/pending-ads')}}" class="dropdown-item">Pending ({{$pending_adds_count}})</a>
<a href="{{url('admin/car-ads-list/not-approved-ads')}}" class="dropdown-item">Not Approved ({{$not_approve_adds_count}})</a>
<a href="{{url('admin/car-ads-list/active-ads')}}" class="dropdown-item">Active/Published ({{$active_adds_count}})</a>
<a href="{{url('admin/car-ads-list/remove-ads')}}" class="dropdown-item">Removed ({{$removed_adds_count}})</a>
<!-- <a href="{{url('admin/car-ads-list/unpaid-ads')}}" class="dropdown-item">Unpaid ({{$unpaid_ads}})</a> -->
<a href="{{url('admin/make-model-versions')}}" class="dropdown-item">Make Model Version ({{$m_d_v_count}})</a>

        </div>
    </li>
    @endif
    @if(in_array('spear_part_ads',$user_role_menus)) 
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop2" data-toggle="dropdown"  title="Spare Parts Ads">
        <i class="fa"> <img src="{{url('public/admin/assets/img/Group 543.png')}}" style="height: 30px;position: absolute;top: -5px;left: -6px;" alt="carish used cars for sale in estonia" class="  sm-logo"></i> <span>Spare Parts Ads</span></a>
        <div class="dropdown-menu">
      <a href="{{url('admin/parts-ads-list/pending-ads')}}" class="dropdown-item">Pending ({{$pending_spareparts_count}})</a>
      <a href="{{url('admin/parts-ads-list/not-approved-ads')}}" class="dropdown-item">Not Approved ({{$not_approve_spareparts_count}})</a>
      <a href="{{url('admin/parts-ads-list/active-ads')}}" class="dropdown-item">Active/Published ({{$active_spareparts_count}})</a>
      <a href="{{url('admin/parts-ads-list/remove-ads')}}" class="dropdown-item">Removed ({{$remove_spareparts_count}})</a>
      <!-- <a href="{{url('admin/parts-ads-list/unpaid-ads')}}" class="dropdown-item">Unpaid ({{$unpaid_spareparts}})</a> -->
        </div>
    </li>
    @endif
    @if(in_array('services_ads',$user_role_menus)) 
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop2" data-toggle="dropdown"  title="Services Ads">
       <i class="fa"> <img src="{{url('public/admin/assets/img/Group 545.png')}}" style="height: 30px;position: absolute;top: -5px;left: -6px;" alt="carish used cars for sale in estonia" class="  sm-logo"></i> <span>Services Ads</span></a>
        <div class="dropdown-menu">
        <a href="{{url('admin/services-ads-list/pending-ads')}}" class="dropdown-item">Pending ({{$pending_services_count}})</a>
        <a href="{{url('admin/services-ads-list/not-approved-ads')}}" class="dropdown-item">Not Approved ({{$not_approve_services_count}})</a>
        <a href="{{url('admin/services-ads-list/active-ads')}}" class="dropdown-item">Active/Published ({{$active_services_count}})</a>
        <a href="{{url('admin/services-ads-list/remove-ads')}}" class="dropdown-item">Removed ({{$removed_services_count}})</a>
        <!-- <a href="{{url('admin/services-ads-list/unpaid-ads')}}" class="dropdown-item">Unpaid ({{$unpaid_spareparts}})</a> -->
        </div>
    </li>
    @endif
    @if(in_array('invoices',$user_role_menus)) 
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop2" data-toggle="dropdown"  title="Invoices">
        <i class="fa fa-id-card" style="font-size: 18px"></i> <span>Invoices</span></a>
        <div class="dropdown-menu">
          <a href="{{url('admin/pending-invoices')}}" class="dropdown-item">Pending ({{@$pending_invoices_count}})</a>
          <a href="{{url('admin/approved-invoices')}}" class="dropdown-item">Paid ({{@$approved_invoices_count}})</a>
          <a href="{{url('admin/uppaid-invoices')}}" class="dropdown-item">Un Paid ({{@$unpaid_invoices_count}})</a> 
        </div>
    </li>
    @endif
    @if(in_array('individual_company',$user_role_menus)) 
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop2" data-toggle="dropdown"  title="Customers Management">
        <i class="fa"> <img src="{{url('public/admin/assets/img/Group 548.png')}}" style="height: 30px;position: absolute;top: -5px;left: -6px;" alt="carish used cars for sale in estonia" class="  sm-logo"></i> <span>Individual/Company</span></a>
        <div class="dropdown-menu">
          <a href="{{url('admin/active/user')}}" class="dropdown-item">Active ({{$active_users_count}})</a>
          <a href="{{url('admin/pending-admin/user')}}" class="dropdown-item">Pending Admin ({{$pending_admin_count}})</a>
          <a href="{{url('admin/in-active/user')}}" class="dropdown-item">Inactive ({{$inactive_users_count}})</a>
        </div>
    </li>
    @endif
    @if(in_array('car_management',$user_role_menus)) 
    <li class="nav-item dropdown" >
      <a class="nav-link dropdown-toggle" id="navbardrop1" data-toggle="dropdown" title="Car Management">
      <i class="fa"> <img src="{{url('public/admin/assets/img/Group 535.png')}}" style="height: 30px;position: absolute;top: -5px;left: -6px;" alt="carish used cars for sale in estonia" class="  sm-logo"></i> <span>Car Management</span></a>
      <div class="dropdown-menu">
      <a href="{{url('admin/makers')}}" class="dropdown-item" >Makers ({{$makers_count}}) </a>
      <a href="{{url('admin/models')}}" class="dropdown-item">Models  ({{$model_count}})</a>
      <a href="{{url('admin/colors')}}" class="dropdown-item">Colors ({{$color_count}})</a>
      <a href="{{url('admin/features')}}" class="dropdown-item">Features ({{$features_count}})</a>
      <a href="{{url('admin/body-types')}}" class="dropdown-item">Body Types ({{$body_types_count}})</a>
      <a href="{{url('admin/suggestions')}}" class="dropdown-item">Suggestions ({{$suggestions_count}})</a>
      <a href="{{url('admin/vehicles-types')}}" class="dropdown-item">Vehicles Types ({{$vehicles_type_count}})</a>
      <a href="{{url('admin/tags')}}" class="dropdown-item">Tags ({{@$tags_count}})</a>      
      <a href="{{url('admin/engine_types')}}" class="dropdown-item">Fuel Types ({{@$engine_type_count}})</a>
      <a href="{{url('admin/transmissions')}}" class="dropdown-item">Transmissions ({{@$transmission_count}})</a>
    </div>
    </li>
    @endif
    @if(in_array('categories_services',$user_role_menus)) 
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop2" data-toggle="dropdown"  title="Categories / Services">
        <i class="fa fa-id-card" style="font-size: 18px"></i> <span>Spear Part Categories</span></a>
        <div class="dropdown-menu">
         <a href="{{url('admin/part-category')}}" class="dropdown-item">Categories ({{$categories_count}}) </a>
        </div>
    </li> 
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop2" data-toggle="dropdown"  title="Categories / Services">
        <i class="fa fa-id-card" style="font-size: 18px"></i> <span>Services Categories</span></a>
        <div class="dropdown-menu">
          <a href="{{url('admin/service-category')}}" class="dropdown-item">Categories ({{$primary_services_count}})</a>
        </div>
    </li> 
    @endif
    @if(in_array('staff_management',$user_role_menus)) 
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop2" data-toggle="dropdown"  title="Staff Management">
        <i class="fa fa-user-circle"></i> <span>Staff Management</span></a>
        <div class="dropdown-menu">
          <a href="{{url('admin/all-users')}}" class="dropdown-item">Active</a>
        </div>
    </li>
    @endif
    @if(in_array('pages_management',$user_role_menus)) 
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop2" data-toggle="dropdown" title="Pages Management">
        <i class="fa fa-file" style="font-size: 1.2rem;
    left: 13px;
    top: 15px;"></i> <span>Pages Management</span></a>
        <div class="dropdown-menu">
          <a href="{{url('admin/list-pages')}}" class="dropdown-item">Pages ({{$pages_count}})</a>
          <a href="{{url('admin/faq-category')}}" class="dropdown-item">Faq Category</a>
          <a href="{{url('admin/list-faqs')}}" class="dropdown-item">Faqs</a>
        </div>
    </li>
    @endif
    @if(in_array('emails',$user_role_menus)) 
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop2" data-toggle="dropdown"  title="Emails">
        <i class="fa fa-envelope" style="font-size: 18px"></i> <span>Emails </span></a>
        <div class="dropdown-menu">
          <a href="{{url('admin/list-template')}}" class="dropdown-item">Email Template ({{$email_templates_count}})</a> 
          <a href="{{url('admin/email_types')}}" class="dropdown-item">Email Types ({{$email_types_count}})</a>
          <a href="{{url('admin/reasons')}}" class="dropdown-item">Reasons ({{@$reasons_count}})</a>
        
        </div>
    </li>
    @endif
    @if(in_array('google_ads',$user_role_menus)) 
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop2" data-toggle="dropdown"  title="Google Ads">
        <i class="fa fa-envelope" style="font-size: 18px"></i> <span>Google Ads </span></a>
        <div class="dropdown-menu">
          <a href="{{url('admin/google-ads-listing')}}" class="dropdown-item">Google Ads ({{$google_ad_count}})</a>
          <a href="{{url('admin/list-ads-pages')}}" class="dropdown-item">Ads Pages ({{$google_ad_pages_count}})</a> 
        
        </div>
    </li>
    @endif
     @if(in_array('languages',$user_role_menus)) 
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop2" data-toggle="dropdown"  title="Languages">
        <i class="fa fa-envelope" style="font-size: 18px"></i> <span>Languages</span></a>
        <div class="dropdown-menu">
          <a href="{{ route('languages.index') }}" class="dropdown-item">Languages</a>        
        </div>
    </li>
    @endif
    
    @if(in_array('global_configuration',$user_role_menus)) 
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop2" data-toggle="dropdown"  title="Global Configuration">
        <i class="fa fa-cog"></i> <span>Global Configuration</span></a>
        <div class="dropdown-menu">
<!-- <a href="{{url('admin/list-coupons')}}" class="dropdown-item">Coupons</a> -->
<!-- <a href="{{url('admin/list-template')}}" class="dropdown-item">Email Template ({{$email_templates_count}})</a> -->
<a href="{{url('admin/countries')}}" class="dropdown-item">Countries</a>
<a href="{{url('admin/bought-from')}}" class="dropdown-item">Bought From</a>
<a href="{{url('admin/cities')}}" class="dropdown-item">Cities</a>
<a href="{{route('get.cardata')}}" class="dropdown-item">Get Car Data</a>
<a href="{{route('get.carxmldata')}}" class="dropdown-item">Get Car XML</a>
<a href="{{route('get.carxmldatatest')}}" class="dropdown-item">Get Testing XML</a>
<a href="{{url('admin/roles')}}" class="dropdown-item">Roles</a>
<a href="{{url('admin/ads-pricing')}}" class="dropdown-item">Pricing</a>
<a href="{{url('admin/general-settings')}}" class="dropdown-item">Settings</a>
</div>
</li>
    @endif

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
@yield("content")
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
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="assets/js/jquery-3.3.1.slim.min.js"></script> -->
<!-- <script src="{{url('public/admin/assets/js/jquery.min.js')}}"></script> -->
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

<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>

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