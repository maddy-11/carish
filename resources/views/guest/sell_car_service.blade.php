@extends('layouts.app')
@section('title') {{ __('header.sell_a_car') }} @endsection
@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endpush
@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush
@section('content')
<div class="internal-page-content mt-4 pt-4 sects-bg">
    <div class="container">

          <div class="bg-white border mt-4 mx-0 row">
            <div class="col-12 col-md-6 post-ad-auto-col py-3">
              <div class="px-xl-5 py-3 px-lg-4 px-sm-3 h-100 text-center">
                <h2 class="themecolor text-center">Sell Used Cars in Estonia</h2>
                <div class="col-12 bannerAd pt-2">
                  <p class="text-center">We provide the speedest car purchasing service,</p>
                  <p class="text-center">where you can sell used cars online with us.</p>
                  <div class="without-no" align="center">
                    <a href="{{route('signup')}}" class="border-0 btn py-0 mr-4 rounded-0 themebtn3">Sign up Now</a>
                    <a href="{{route('signin')}}" class="border-0 btn py-0 rounded-0 themebtn">Login Now</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 post-ad-auto-col py-3">
              <img src="{{asset('public/assets/img/placeholder.jpg')}}" class="img-fluid" style="max-width: 100%;height: 100%;" alt="Image">
            </div>
          </div>


          <div class="row">
            <div class="col-12 mt-4 mt-lg-5 pt-3 pt-lg-0">
              <div class="bg-white tags-sect border ourtags tag-page-col">
                <h2 class="border-bottom font-weight-bold mb-0 pt-lg-4 pb-lg-4 pt-md-3 pb-md-3 pl-md-4 pr-md-4 pl-xl-5 pr-xl-5 tagpagetitle themecolor p-3">Fast, Advantageous and Haggle-Free</h2>
                <div class="p-md-4 p-3 pl-xl-5 pr-xl-5 f-size">
                  <p>Find how to sell your car at Carish!</p>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-white border mt-4 mx-0 row">
            <div class="col-12 col-md-6 post-ad-auto-col py-3">
              <h3 class="themecolor text-center">Normal Account Features</h3>
              <ul>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit</li>
                <li>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</li>
                <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco</li>
                <li>dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat</li>
                <li>sunt in culpa qui officia deserunt mollit anim id est laborum</li>
              </ul>
              
            </div>
            <div class="col-12 col-md-6 post-ad-auto-col py-3">
                <h3 class="themecolor text-center">Buisness Account Features</h3>
                <ul>
                  <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit</li>
                  <li>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</li>
                  <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco</li>
                  <li>dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat</li>
                  <li>sunt in culpa qui officia deserunt mollit anim id est laborum</li>
                </ul>
                
              </div>
          </div>

          <div class="bg-white border mt-4 mx-0 row">
            <div class="col-12 col-md-6 post-ad-auto-col py-3">
              <img src="{{asset('public/assets/img/placeholder.jpg')}}" class="img-fluid" style="max-width: 100%;height: 100%;" alt="Image">
            </div>
            <div class="col-12 col-md-6 post-ad-auto-col py-3">
              <h2 class="themecolor">3 Stages to Sell Your Car at Carish</h2>
              <ol>
                <li>A moment online valuation</li>
                <li>Free drop-off or $99 pickup</li>
                <li>Quick installment on handover day</li>
              </ol>
              <h3 class="themecolor">We don't post vehicles that:</h3>
              <div class="bg-white border mt-4 mx-0 row">
                <div class="col-12 col-md-6 post-ad-auto-col py-3">
                  <ul>
                    <li>haven't got a legitimate MOT</li>
                    <li>have extraordinary money</li>
                    <li>have significant mishop harm</li>
                    <li>haven't got tries which are street lawful</li>
                    <li>have been classified as protection classification, A, B, N (previously C) or S (previously D)</li>
                    <li>have been discounted or taken</li>
                  </ul>
                </div>
                <div class="col-12 col-md-6 post-ad-auto-col py-3">
                  <ul>
                    <li>have been imported or sent out</li>
                    <li>have a mechanical or electrical shortcoming</li>
                    <li>have surpassed 25000 miles each year</li>
                    <li>haven't been enrolled/registered in the estonia</li>
                    <li>have been modified in any capicity</li>
                  </ul>
                </div>
                
              </div>
              
            </div>
          </div>

          <div class="bg-white border mt-4 mx-0 row">
            <div class="col-12 col-md-6 post-ad-auto-col py-3">
              <h2 class="themecolor">What you really Need to Sell Your Car With Us?</h2>
              <ul>
                <li>A legitimate red V5C that matches your name, address and the number plates</li>
                <li>A legitimate photo of driving permit or your visa</li>
                <li>Somewhere around one bunch of car keys</li>
                <li>Any spare parts of car that accompanied the vehicle</li>
                <li>Confirmation of address, like a service bill or bank articulation, in the event that you're dropping your vehicle off</li>
              </ul>
              <p>Assuming you're feeling the loss of any assistance history, let us know by contacting us. You like wise should be the proprietor (onlisted attendant) of the vehicle you need to sell.</p>

              <p>For more data, read over sell vehicle agreements.</p>
              
            </div>
            <div class="col-12 col-md-6 post-ad-auto-col py-3">
              <img src="{{asset('public/assets/img/placeholder.jpg')}}" class="img-fluid" style="max-width: 100%;height: 100%;" alt="Image">
            </div>
            
          </div>

          <div class="bg-white border mt-4 mx-0 row">
            <div class="col-12 col-md-12 post-ad-auto-col py-3">
              <h2 class="themecolor text-center">Complete Satisfaction</h2>
            </div>
            <div class="col-12 col-md-4 py-3" align="center">
              <i class="fa fa-star-o fa-3x" aria-hidden="true"></i>
              <p><b>Fast payment</b></p>
              <p>Payment within two hours when you hand your car over, any day of the week</p>
            </div>
            <div class="col-12 col-md-4 py-3" align="center">
              <i class="fa fa-star-o fa-3x" aria-hidden="true"></i>
              <p><b>Ensured for 7 days</b></p>
              <p>Get a free, moment offer with 7 days to choose</p>
            </div>
            <div class="col-12 col-md-4 py-3" align="center">
              <i class="fa fa-star-o fa-3x" aria-hidden="true"></i>
              <p><b>24/7 Support</b></p>
              <p>At carish, we provide 24/7 support to our customers</p>
            </div>
          </div>

          <div class="bg-white border mt-4 p-4 write-review">
              <div class="align-items-center d-flex justify-content-between mb-4">
                <div class="review-title">
                  <h5>Reviews</h5>
                </div>
                <!-- <div class="review-title">
                  <a href="#" class="btn themebtn2">Write review</a>
                </div> -->
              </div>
              <div class="posted-review-row">
                <div class="posted-review">
                  <h6 class="themecolor mb-0">About H&A Motors</h6>
                  <p class="review-posted-time">Posted by H&A Motors Sep 02, 2019</p>
                <figure class="mb-3"><img src="{{asset('public/assets/img/review-stars.png')}}" class="d-block img-fluid" alt="review stars"></figure>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                
                <div class="mt-4"><a href="#" class="font-weight-semibold themecolor">Report</a></div>
              </div>
              <div class="posted-review">
                <h6 class="themecolor mb-0">About H&A Motors</h6>
                <p class="review-posted-time">Posted by H&A Motors Sep 02, 2019</p>
              <figure class="mb-3"><img src="{{asset('public/assets/img/review-stars.png')}}" class="d-block img-fluid" alt="review stars"></figure>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
              
              <div class="mt-4"><a href="#" class="font-weight-semibold themecolor">Report</a></div>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection