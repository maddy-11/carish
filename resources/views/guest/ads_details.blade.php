@extends('layouts.app')
@push('styles')
<link type="text/css" rel="stylesheet" href="{{asset('public/assets/css/lightslider.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('public/assets/css/lightgallery.min.css')}}" />
@endpush
@push('scripts')
<script src="{{asset('public/assets/js/lightslider.js')}}"></script>
<script src="{{asset('public/assets/js/lightgallery-all.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<script type="text/javascript" charset="utf-8" defer>
        $(document).ready(function ()
          {
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
              </script>
@endpush
@section('content') 

<div class="internal-page-content mt-4 pt2 pt2 sects-bg">
<div class="container">
<div class="row">
  <div class="col-12 bannerAd">
    <a href="javascript:void(0)" target=""><img src="{{asset('public/assets/img/placeholder.jpg')}}" class="img-fluid" alt="carish used cars for sale in estonia"></a>
  </div>
  <div class="col-12 pageTitle detailpageTitle mt-md-5 mt-4">
    <nav aria-label="breadcrumb" class="breadcrumb-menu">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Used Cars</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Toyota</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Corolla</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Altis</a></li>
        <li class="breadcrumb-item active" aria-current="page">Toyota Corolla Altis Grande CVT-i 1.8 2016 Cars for sale in Estonia</li>
      </ol>
    </nav>
  </div>
</div>
<div class="mb-4 mt-4 pt-md-2 row">
  <div class="col-md-6 col-12 productImgCol">
    <div class="bg-white p-2 border h-100">
      <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
        <li class="position-relative overflow-hidden rounded" data-thumb="assets/img/slider-sm-img-1.jpg" data-src="assets/img/detail-Img.jpg">
          <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
          <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block">FEATURED</span>
          <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
          </span>
          </figcaption>
          <img src="assets/img/detail-Img.jpg" class="img-fluid">
        </li>
        <li class="position-relative overflow-hidden rounded" data-thumb="assets/img/slider-sm-img-2.jpg" data-src="assets/img/detail-Img.jpg">
          <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
          <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block">FEATURED</span>
          <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
          </span>
          </figcaption>
          <img src="assets/img/detail-Img.jpg" class="img-fluid">
        </li>
        <li class="position-relative overflow-hidden rounded" data-thumb="assets/img/slider-sm-img-3.jpg" data-src="assets/img/detail-Img.jpg">
          <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
          <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block">FEATURED</span>
          <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
          </span>
          </figcaption>
          <img src="assets/img/detail-Img.jpg" class="img-fluid">
        </li>
        <li class="position-relative overflow-hidden rounded" data-thumb="assets/img/slider-sm-img-4.jpg" data-src="assets/img/detail-Img.jpg">
          <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
          <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block">FEATURED</span>
          <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
          </span>
          </figcaption>
          <img src="assets/img/detail-Img.jpg" class="img-fluid">
        </li>
        <li class="position-relative overflow-hidden rounded" data-thumb="assets/img/slider-sm-img-1.jpg" data-src="assets/img/detail-Img.jpg">
          <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
          <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block">FEATURED</span>
          <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
          </span>
          </figcaption>
          <img src="assets/img/detail-Img.jpg" class="img-fluid">
        </li>
        <li class="position-relative overflow-hidden rounded" data-thumb="assets/img/slider-sm-img-2.jpg" data-src="assets/img/detail-Img.jpg">
          <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
          <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block">FEATURED</span>
          <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
          </span>
          </figcaption>
          <img src="assets/img/detail-Img.jpg" class="img-fluid">
        </li>
        <li class="position-relative overflow-hidden rounded" data-thumb="assets/img/slider-sm-img-3.jpg" data-src="assets/img/detail-Img.jpg">
          <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
          <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block">FEATURED</span>
          <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
          </span>
          </figcaption>
          <img src="assets/img/detail-Img.jpg" class="img-fluid">
        </li>
        <li class="position-relative overflow-hidden rounded" data-thumb="assets/img/slider-sm-img-4.jpg" data-src="assets/img/detail-Img.jpg">
          <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
          <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block">FEATURED</span>
          <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
          </span>
          </figcaption>
          <img src="assets/img/detail-Img.jpg" class="img-fluid">
        </li>ss
      </ul>
    </div>
  </div>
  <div class="col-md-6 col-12 mt-4 mt-md-0 productDetialCol">
    <div class="bg-white border h-100 overflow-auto position-relative">
      <h6 class="bgcolor1 detail-page-title mb-0 pb-3 pl-md-4 pr-md-4 pl-3 pr-3 pt-3 text-white">Toyota Corolla Altis Grande CVT-i 1.8 2016</h6>
      <div class="seller-desc p-lg-4 p-3 mt-3">
        <div class="d-flex justify-content-between sellerinfo">
          <div class="sellerinfo-left">
            <h6 class="mb-4">Seller Info</h6>
            <p class="bestSeller font-weight-semibold mb-1">
              <em class="fa fa-star"></em>Trusted Seller<em class="fa fa-star"></em>
            </p>
            <ul class="list-unstyled">
              <li><strong>Dealer:</strong> <a href="javascript:void(0)">carish.com</a></li>
              <li><strong>Address:</strong> <a href="javascript:void(0)">Estonia</a></li>
            </ul>
          </div>
          <div class="sellerinfo-right pl-3 text-right">
            <span class="carPrice d-inline-block font-weight-bold font-weight-semibold ml-3">€30,000</span>
            <p class="incltext mb-0">Incl. VAT</p>
            <p class="themecolor2 font-weight-semibold mb-0 negotiable">Negotiable</p>
          </div>
        </div>
        <div class="align-items-center d-lg-flex d-md-block d-flex justify-content-between sellerContact">
          <div class="mb-md-3 m-lg-0 mb-0 sellerContact-left">
            <ul class="list-unstyled">
              <li class="list-inline-item"><a href="javascript:void(0)" class="position-relative"><em class="fa fa-mobile"></em>
                <img src="assets/img/check.jpg" class="position-absolute rounded-circle">
              </a></li>
              <li class="list-inline-item"><a href="javascript:void(0)" class="position-relative"><em class="fa fa-envelope"></em>
                <img src="assets/img/check.jpg" class="position-absolute rounded-circle">
              </a></li>
            </ul>
            <a href="javascript:void(0)" class="view-more-ad themecolor">View more ads by <strong>carish.com</strong></a>
          </div>
          <div class="pl-0 pl-lg-3 pl-md-0 pl-sm-3 sellerContact-right text-lg-right text-md-left text-right">
            <a href="javascript:void(0)" class="btn themebtn3"><em class="fa fa-phone"></em> 03439088607</a>
            <a href="javascript:void(0)" class="btn themebtn4 mt-lg-3 mt-md-0 mt-2 mt-0"><em class="fa fa-envelope"></em> Send Message</a>
          </div>
        </div>
        <div class="mb-4 ml-auto mr-auto mt-4 mt-lg-5 row sellercarInforow">
          <div class="col-6 col-md-4 col-sm-4 d-flex justify-content-center sellercarInfo pl-3 pr-3 pt-lg-4 pb-lg-4 pt-3 pb-3">
            <div class="text-center">
              <img src="assets/img/detail-car-info-1.png" class="img-fluid mb-1" alt="carish used cars for sale in estonia">
              <span class="d-block">Sedan</span>
            </div>
          </div>
          <div class="col-6 col-md-4 col-sm-4 d-flex justify-content-center sellercarInfo pl-3 pr-3 pt-lg-4 pb-lg-4 pt-3 pb-3">
            <div class="text-center">
              <img src="assets/img/detail-car-info-2.png" class="img-fluid mb-1" alt="carish used cars for sale in estonia">
              <span class="d-block">Manual</span>
            </div>
          </div>
          <div class="col-6 col-md-4 col-sm-4 d-flex justify-content-center sellercarInfo pl-3 pr-3 pt-lg-4 pb-lg-4 pt-3 pb-3">
            <div class="text-center">
              <img src="assets/img/detail-car-info-3.png" class="img-fluid mb-1" alt="carish used cars for sale in estonia">
              <span class="d-block">Petrol</span>
            </div>
          </div>
          <div class="col-6 col-md-4 col-sm-4 d-flex justify-content-center sellercarInfo pl-3 pr-3 pt-lg-4 pb-lg-4 pt-3 pb-3">
            <div class="text-center">
              <img src="assets/img/detail-car-info-4.png" class="img-fluid mb-1" alt="carish used cars for sale in estonia">
              <span class="d-block">2016</span>
            </div>
          </div>
          <div class="col-6 col-md-4 col-sm-4 d-flex justify-content-center sellercarInfo pl-3 pr-3 pt-lg-4 pb-lg-4 pt-3 pb-3">
            <div class="text-center">
              <img src="assets/img/detail-car-info-5.png" class="img-fluid mb-1" alt="carish used cars for sale in estonia">
              <span class="d-block">52,759 km</span>
            </div>
          </div>
          <div class="col-6 col-md-4 col-sm-4 d-flex justify-content-center sellercarInfo pl-3 pr-3 pt-lg-4 pb-lg-4 pt-3 pb-3">
            <div class="text-center">
              <img src="assets/img/detail-car-info-6.png" class="img-fluid mb-1" alt="carish used cars for sale in estonia">
              <span class="d-block">1.8</span>
            </div>
          </div>
        </div>
        <ul class="list-unstyled sharelist font-weight-semibold mb-0">
          <li class="list-inline-item"><a href="javascript:void(0)"><em class="fa fa-share-alt"></em> Share</a></li>
          <li class="list-inline-item"><a href="javascript:void(0)"><em class="fa fa-heart-o"></em> Save</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
</div>

<div class="container position-sticky" style="top: 0px; z-index: 100;">
<div class="row carinfoTabs">
  <div class="col-12 carinfoTabs-col text-center ">
    <ul class="bgcolor1 list-unstyled mb-0 nav nav-justified text-white">
      <li class="nav-item active"><a href="#carfeatures-sect" class="gotosect nav-link">Car Features</a></li>
      <li class="nav-item"><a href="#taxi-Compatibility-sect" class="gotosect nav-link">Taxi Compatibility</a></li>
      <li class="nav-item"><a href="#seller-comments-sect" class="gotosect nav-link">Seller Comments</a></li>
      <li class="nav-item"><a href="#similar-ads-sect" class="gotosect nav-link">Similar ads</a></li>
    </ul>
  </div>
</div>
</div>
<div class="carinfodetail-section bg-white mt-5 pt-5 pb-5">
<div class="container">
  <div class="carinfodetail-row card-columns">
    <div class="card carfeatureinfo" id="carfeatures-sect">
      <h5 class="text-capitalize carInfotitle font-weight-bold">
      <img src="assets/img/detail-Car-features.jpg" alt="icon">Car features</h5>
      <div class="form-row featureslist mb-0 row">
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline">
        <figure class="mb-0"><img src="assets/img/car-features-abs.jpg"></figure> ABS</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline">
        <figure class="mb-0"><img src="assets/img/car-features-radio.jpg"></figure>AM/FM Radio</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline">
        <figure class="mb-0"><img src="assets/img/car-features-air-bags.jpg">Air Bags</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline">
        <figure class="mb-0"><img src="assets/img/car-features-ac.jpg"></figure> AirConditioning</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline">
        <figure class="mb-0"><img src="assets/img/car-features-rims.jpg"></figure> Alloy Rims</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline">
        <figure class="mb-0"><img src="assets/img/car-features-cd-player.jpg"></figure> CD Player</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline">
        <figure class="mb-0"><img src="assets/img/car-features-cruise-control.jpg"></figure> Cruise Control</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline">
        <figure class="mb-0"><img src="assets/img/car-features-immbolizer-key.jpg">Immobilizer Key</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline">
        <figure class="mb-0"><img src="assets/img/car-features-keyless-entry.jpg"></figure> Keyless Entry</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline">
        <figure class="mb-0"><img src="assets/img/car-features-navigation-system.jpg"></figure> Navigation System</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline">
        <figure class="mb-0"><img src="assets/img/car-features-power-lock.jpg">Power Locks</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline">
        <figure class="mb-0"><img src="assets/img/car-features-power-mirrors.jpg"></figure> Power Mirrors</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline"><figure class="mb-0"><img src="assets/img/car-features-power-steering.jpg"></figure> Power Steering</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline"><figure class="mb-0"><img src="assets/img/car-features-power-windows.jpg"></figure> Power Windows</div>
        <div class="col-lg-4 col-sm-6 col-6 featureslistitem d-flex align-items-baseline"><figure class="mb-0"><img src="assets/img/car-features-sun-roof.jpg">Sun Roof</div>
      </div>
      <div class="text-right">
        <a href="javascript:void(0)" class="themecolor font-weight-semibold">Show All</a>
      </div>
    </div>
    <div class="card cardatainfo">
      <h5 class="carInfotitle text-capitalize">
      <img src="assets/img/detail-Car-data.jpg" alt="icon">Car Data</h5>
      <table class="mb-0 table">
        <tbody>
          <tr>
            <td>Registration number</td>
            <td>534345</td>
          </tr>
          <tr>
            <td>Vin number</td>
            <td>345678</td>
          </tr>
          <tr>
            <td>Register</td>
            <td>Estonia</td>
          </tr>
          <tr>
            <td>Color</td>
            <td>White</td>
          </tr>
          <tr>
            <td>Gears</td>
            <td>automatic</td>
          </tr>
          <tr>
            <td>Doors</td>
            <td>5</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card cardimensions">
      <h5 class="text-capitalize carInfotitle font-weight-bold">
      <img src="assets/img/detail-Car-dimensions.jpg" alt="icon">Dimensions</h5>
      <table class="mb-0 table table-borderless">
        <tbody>
          <tr>
            <td>Length</td>
            <td>1460m</td>
          </tr>
          <tr>
            <td>Width</td>
            <td>1460m</td>
          </tr>
          <tr>
            <td>height</td>
            <td>1460m</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card carperformanceinfo">
      <h5 class="text-capitalize carInfotitle font-weight-bold">
      <img src="assets/img/detail-Car-performance.jpg" alt="icon">Car Performance</h5>
      <table class="mb-0 table table-borderless">
        <tbody>
          <tr>
            <td>BHP</td>
            <td>197</td>
          </tr>
          <tr>
            <td>BHP</td>
            <td>197</td>
          </tr>
          <tr>
            <td>Engine Size</td>
            <td>1556</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card cartagsinfo">
      <h5 class="text-capitalize carInfotitle font-weight-bold">
      <img src="assets/img/detail-Car-tags.jpg" alt="icon">Car Tags</h5>
      <div class="car-tags">
        <ul class="list-unstyled mb-0">
          <li class="list-inline-item mb-3">
            <span class="badge badge-pill bgcolor1 font-weight-normal p-2 pl-3 pr-3 text-white">Great Milage</span></li>
            <li class="list-inline-item mb-3">
              <span class="badge badge-pill bgcolor1 font-weight-normal p-2 pl-3 pr-3 text-white">Taxi Compatible</span></li>
            </ul>
          </div>
        </div>
        <div class="card careconomyinfo">
          <h5 class="text-capitalize carInfotitle font-weight-bold">
          <img src="assets/img/detail-Car-economy.jpg" alt="icon">Car Economy</h5>
          <table class="mb-0 table table-borderless">
            <tbody>
              <tr>
                <td>City</td>
                <td>9 Ltr / 100 km</td>
              </tr>
              <tr>
                <td>Highway</td>
                <td>9 Ltr / 100 km</td>
              </tr>
              <tr>
                <td>Average</td>
                <td>9 Ltr / 100 km</td>
              </tr>
              <tr>
                <td>City</td>
                <td>9 Ltr / 100 km</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="container mb-5 mt-4 mt-5 mt-md-5 pb-md-3 pt-0 pt-md-3" id="taxi-Compatibility-sect">
    <div class="row taxi-comp-row ml-auto mr-auto">
      <div class="col-12 taxi-comp-col bg-white p-4">
        <h5 class="text-capitalize carInfotitle font-weight-bold">
        <img src="assets/img/detail-Car-taxi-compatiblity.jpg" alt="icon">taxi compatibility</h5>
        <table class="mb-0 table table-borderless table-responsive">
          <tbody>
            <tr>
              <td><img src="assets/img/uber.jpg" alt="icon" class="img-fluid"></td>
              <td class="text-success">Compatible with Uber X and Uber GO</td>
            </tr>
            <tr>
              <td><img src="assets/img/yandex.jpg" alt="icon" class="img-fluid"></td>
              <td class="text-success">Compatible with Uber X and Uber GO</td>
            </tr>
            <tr>
              <td><img src="assets/img/bolt.jpg" alt="icon" class="img-fluid"></td>
              <td class="text-danger">Compatible with Uber X and Uber GO</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="bg-white pb-3 pt-3 seller-comments-sections" id="seller-comments-sect">
    <div class="container  mt-4 mt-md-5 mb-4 mb-md-5">
      <div class="row seller-comments-row ml-auto mr-auto">
        <div class="col-12 seller-comments-col">
          <h5 class="text-capitalize carInfotitle font-weight-bold">
          <img src="assets/img/detail-Car-seller-coments.jpg" alt="icon">Seller comments</h5>
          <ul class="list-unstyled mb-4">
            <li class="mb-2">Certified by PakWheels (Inspection Report Attached)</li>
            <li class="mb-2">100% Original </li>
            <li class="mb-2">Family Used Car Mostly For Short Drives </li>
            <li class="mb-2">Lightweight Allow Rims </li>
            <li class="mb-2">Driven on Petrol Only </li>
            <li class="mb-2">Engine in Pristine Condition.</li>
            <li class="mb-2">Exchange option can be considered.</li>
          </ul>
          <p class="mb-0">Mention carish.com when calling Seller to get a good deal</p>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="align-items-center col-lg-9 d-sm-flex justify-content-around ml-auto mr-auto mb-4 mb-md-5 mt-4 mt-md-5 pl-0 postAdRow pr-0 pt-2 pt-sm-3  mb-sm-0 mb-5">
      <div class="sellCarCol d-none d-md-block">
        <img src="assets/img/sell-car.png" class="img-fluid" alt="carish used cars for sale in estonia">
      </div>
      <div class="pl-md-3 pr-md-3 sellCartext text-center">
        <img src="assets/img/sell-arrow-left.png" class="d-md-block d-none img-fluid mr-auto  sell-arrow-left" alt="carish used cars for sale in estonia">
        <h4 class="mb-0">Post an ad for <span class="themecolor2">FREE</span></h4>
        <p class="mb-0">Sell it faster to thousands of buyers</p>
        <img src="assets/img/sell-arrow-right.png" class="d-sm-block d-none img-fluid ml-auto sell-arrow-right" alt="carish used cars for sale in estonia">
      </div>
      <div class="sellCarBtn">
        <a href="javascript:void(0)" class="btn themebtn1">SELL YOUR CAR</a>
      </div>
    </div>
    <div class="ml-0 mr-0 row bg-white" id="similar-ads-sect">
      <div class="col-12 p-4 similar-Ads-col">
        <h5 class="text-capitalize carInfotitle font-weight-bold">
        <img src="assets/img/detail-Car-seller-coments.jpg" alt="icon">similar ads</h5>
        <div class="row">
          <div class="col-lg-3 col-md-6 col-6 mb-4 mb-lg-3 similar-post-col">
            <div class="box-shadow">
              <figure class="mb-0 position-relative text-left">
                <div class="bgImg" style="background-image: url(assets/img/featured-used-car-1.jpg)"></div>
                <figcaption class="position-absolute top right left bottom">
                <span class="bgcolor2 d-inline-block featuredlabel font-weight-semibold mt-3 pb-1 pl-2 pr-2 pt-1  text-white">FEATURED</span>
                </figcaption>
              </figure>
              <div class="m-1 p-2 pb-3">
                <h5 class="font-weight-semibold mb-2"><a href="javascript:void(0)" class="stretched-link themecolor">Toyota Corolla GLi Automat...</a></h5>
                <p class="car-price mb-1">€18,000</p>
                <span class="car-country">Estonia</span>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-6 mb-4 mb-lg-3 similar-post-col">
            <div class="box-shadow">
              <figure class="mb-0 position-relative text-left">
                <div class="bgImg" style="background-image: url(assets/img/featured-used-car-1.jpg)"></div>
                <figcaption class="position-absolute top right left bottom">
                <span class="bgcolor2 d-inline-block featuredlabel font-weight-semibold mt-3 pb-1 pl-2 pr-2 pt-1  text-white">FEATURED</span>
                </figcaption>
              </figure>
              <div class="m-1 p-2 pb-3">
                <h5 class="font-weight-semibold mb-2"><a href="javascript:void(0)" class="stretched-link themecolor">Toyota Corolla GLi Automat...</a></h5>
                <p class="car-price mb-1">€18,000</p>
                <span class="car-country">Estonia</span>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-6 mb-4 mb-lg-3 similar-post-col">
            <div class="box-shadow">
              <figure class="mb-0 position-relative text-left">
                <div class="bgImg" style="background-image: url(assets/img/featured-used-car-1.jpg)"></div>
                <figcaption class="position-absolute top right left bottom">
                <span class="bgcolor2 d-inline-block featuredlabel font-weight-semibold mt-3 pb-1 pl-2 pr-2 pt-1  text-white">FEATURED</span>
                </figcaption>
              </figure>
              <div class="m-1 p-2 pb-3">
                <h5 class="font-weight-semibold mb-2"><a href="javascript:void(0)" class="stretched-link themecolor">Toyota Corolla GLi Automat...</a></h5>
                <p class="car-price mb-1">€18,000</p>
                <span class="car-country">Estonia</span>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-6 mb-4 mb-lg-3 similar-post-col">
            <div class="box-shadow">
              <figure class="mb-0 position-relative text-left">
                <div class="bgImg" style="background-image: url(assets/img/featured-used-car-1.jpg)"></div>
                <figcaption class="position-absolute top right left bottom">
                <span class="bgcolor2 d-inline-block featuredlabel font-weight-semibold mt-3 pb-1 pl-2 pr-2 pt-1  text-white">FEATURED</span>
                </figcaption>
              </figure>
              <div class="m-1 p-2 pb-3">
                <h5 class="font-weight-semibold mb-2"><a href="javascript:void(0)" class="stretched-link themecolor">Toyota Corolla GLi Automat...</a></h5>
                <p class="car-price mb-1">€18,000</p>
                <span class="car-country">Estonia</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 mt-lg-4 p-md-4 p-3 notifyForm detail-page-notifyform" style=" background: #E4E4E4;">
        <div class="row p-sm-2 align-items-center">
          <div class="col-lg-5 col-12 mb-lg-0 mb-3">
            <h5 class="themecolor"><em class="fa fa-bell"></em> Notify Me</h5>
            <p class="mb-0">Set your Alerts for <strong>Toyota Corolla in Estonia</strong> and we will email you relevant ads.</p>
          </div>
          <div class="col-lg-7 col-12">
            <form>
              <div class="row form-row">
                <div class="col-sm-5 mb-md-0 mb-3 form-group">
                  <input type="text" name="" placeholder="Type Your Email Address" class="form-control">
                </div>
                <div class="col-sm-4 mb-md-0 mb-3 form-group">
                  <select name="selectCity" class="form-control">
                    <option value="">Daily</option>
                    <option value="">Weekly</option>
                    <option value="">Monthly</option>
                    <option value="">Hourly</option>
                  </select>
                </div>
                <div class="col-sm-3 mb-md-0 mb-3 form-group notifySubCol">
                  <input type="submit" value="Submit" class="btn btn-block border-0 text-white notifySubBtn ">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection