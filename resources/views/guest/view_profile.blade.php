@extends('layouts.app')
@section('title') Update Profile @endsection
@push('styles')
@endpush
@push('scripts')
<script type="text/javascript">
    $('.gridIcon').on('click', function(){
        $('.listingtab').addClass('gridingCol');
        $('this').addClass('active');
        $('.listIcon').removeClass('active');
        $('.gridListprice').addClass('d-flex mb-2').removeClass('d-none mb-3');
        $('.listingCar-place .negotiable, .listingCar-title .lcPrice').hide();
    });
    $('.listIcon').on('click', function(){
        $('.listingtab').removeClass('gridingCol');
        $(this).addClass('active');
        $('.gridIcon').removeClass('active');
        $('.gridListprice').removeClass('d-flex mb-2').addClass('d-none mb-3');
        $('.listingCar-place .negotiable, .listingCar-title .lcPrice').show();
    });
    $('.filterDown em').on('click', function(){
        if ($('.filterDown em').hasClass('filter-active')){
        $('.filterDown em').removeClass('filter-active');
        $('.filterDown em').removeClass('fa-chevron-circle-up').addClass('fa-chevron-circle-down');
        }
        else {
        $('.filterDown em').removeClass('fa-chevron-circle-down').addClass('fa-chevron-circle-up')
        $('.filterDown em').addClass('filter-active');
        }
        $('#searchResultFilter').slideToggle();
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
                  <img src="assets/img/profile-img.jpg" class="img-fluid rounded-circle" alt="Profile">
                </div>
                <div class="col-xl-10 col-lg-10 col-md-10 mt-md-0 mt-4">
                  <div class="align-items-md-center row">
                    <div class="col-xl-8 col-lg-7 col-sm-6 pr-lg-3 pr-md-0 user-profile">
                      <div class="align-items-center d-flex mb-2">
                        <h4 class="mb-0 themecolor">H&amp;A MOTORS</h4>
                        <span class="badge badge-pill badge-success d-inline-block ml-3 p-1 pl-2 pr-2"><em class="fa fa-check-circle mr-2"></em> VERIFIED</span>
                      </div>
                      <p class="mb-0 mb-2 member-from">Member Since Aug 21, 2019</p>
                      <div class="mb-3 prof-review">
                        <img src="assets/img/review-stars.png" class="d-md-inline-block d-sm-block img-fluid mb-md-0 mb-sm-3">
                        <span class="d-inline-block mr-2 themecolor">1 reviews</span><a href="#" class="d-inline-block themecolor">Write Review</a>
                      </div>
                      <table>
                        <tbody>
                          <tr>
                            <td><em class="fa fa-clock-o themecolor"></em></td>
                            <td>Mon - Fri</td>
                            <td>09:00 - 16:00</td>
                          </tr>
                          <tr>
                            <td><em class="fa fa-calendar themecolor"></em></td>
                            <td>Sat - Sun</td>
                            <td>11:00 - 15:00</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-sm-6 mt-sm-0 mt-3 user-profile-detail">
                      <ul class="list-unstyled mb-0">
                        <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span> Lorem Ipsum is simply dummy text of the printing and typesetting.</li>
                        <li class="d-flex"><span class="mr-2"><em class="fa fa-phone"></em></span> +372 111 1111</li>
                        <li class="d-flex"><span class="mr-2"><em class="fa fa-globe"></em></span> <a href="#">www.abcd.com</a></li>
                        <li class="d-flex"><span class="mr-2"><em class="fa fa-tag"></em></span> Lorem Ipsum is simply dummy text of the printing and typesetting.</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-md-5 mt-4">
            <div class="col-12">
              <h4 class="mb-3">Recent Car Ads</h4>
            </div>
            <!-- right content section starts here -->
            <div class="col-12 right-content">
              <!-- sorting and listing/grid section start here  
              <div class="sortingsection bg-white border">
                <div class="align-items-center ml-0 mr-0 pb-3 pt-3 row">
                  <div class="col-md-6 col-md-6 col-sm-6 mb-sm-0 mb-3 sorting-col">
                    <div class="align-items-center d-flex">
                      <label class="mb-0 mr-3 text-nowrap">Sort By:</label>
                      <select name="sorting" class="form-control form-control-sm">
                        <option value="1">Honda latest Car</option>
                        <option value="2">Honda latest Car</option>
                        <option value="3">Honda latest Car</option>
                        <option value="4">Honda latest Car</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 d-flex list-grid-col">
                    <ul class="ml-auto mb-0">
                      <li class="list-inline-item">
                        <a class="active listIcon" data-toggle="tab" href="javscriptvoid:(0)">
                          <em class="fa fa-list"></em> List
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="javscriptvoid:(0)" class="gridIcon">
                          <em class="fa fa-table"></em> Grid
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
               sorting and listing/grid section ends here -->
              <!-- listing view starts here -->
              <div class="row listingtab">
                <div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
                  <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar">
                      <figure class="mb-0 position-relative">
                        <a href="#"><img src="assets/img/listing-car.jpg" class="img-fluid" alt="carish used cars for sale in estonia"></a>
                        <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                        <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block mt-2">FEATURED</span>
                        <span class="d-inline-block pb-1 pl-2 pr-2 pt-1 viewgallery"><em class="fa fa-camera"></em> 10</span>
                        </figcaption>
                      </figure>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-8 listingCar-descCar">
                      <div class="align-items-center d-flex justify-content-between listingCar-title mb-1">
                        <h5 class="font-weight-semibold mb-0"><a href="detail.html">Toyota Corolla  2018 Altis Grande</a></h5>
                        <span class="lcPrice d-inline-block ml-3 font-weight-semibold">$30,000</span>
                      </div>
                      <div class="align-items-center d-flex justify-content-between listingCar-place mb-3">
                        <p class="carplace mb-0">Estonia</p>
                        <p class="themecolor2 font-weight-semibold mb-0 negotiable">Negotiable</p>
                      </div>
                      <div class="align-items-center d-flex justify-content-between aboutcarlist mb-3">
                        <ul class="list-unstyled mb-0">
                          <li class="list-inline-item">2002</li>
                          <li class="list-inline-item">68,000 km</li>
                          <li class="list-inline-item">Petrol</li>
                          <li class="list-inline-item">1000 cc</li>
                          <li class="list-inline-item">Automatic</li>
                        </ul>
                      <figure class="mb-0"><img src="assets/img/small-company-logo.png" alt="carish used cars for sale in estonia" class="list-comp-logo"></figure>
                    </div>
                    <div class="align-items-center d-none justify-content-between gridListprice mb-3">
                      <span class="lcPrice d-inline-block mr-3 font-weight-semibold">$30,000</span>
                      <p class="themecolor2 font-weight-semibold mb-0 negotiable">Negotiable</p>
                    </div>
                    <div class="align-items-center row contactRow">
                      <div class="col-lg-7 col-md-7 col-sm-6 col-6 lc-published">
                        <p class="mb-0">Updated 2 days ago</p>
                      </div>
                      <div class="align-items-center col-6 col-lg-5 col-md-5 col-sm-6 d-flex justify-content-end lc-contact text-right pl-md-3 pl-0">
                        <a href="#" class="d-inline-block fa fa-heart fa-heart-o lc-favorite p-2 mr-2"></a>
                        <a href="#" class="btn contactbtn themebtn3"><em class="fa fa-phone"></em> 0343-9088607</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar">
                    <figure class="mb-0 position-relative">
                      <a href="#"><img src="assets/img/listing-car.jpg" class="img-fluid" alt="carish used cars for sale in estonia"></a>
                      <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                      <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block mt-2">FEATURED</span>
                      <span class="d-inline-block pb-1 pl-2 pr-2 pt-1 viewgallery"><em class="fa fa-camera"></em> 10</span>
                      </figcaption>
                    </figure>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9 col-8 listingCar-descCar">
                    <div class="align-items-center d-flex justify-content-between listingCar-title mb-1">
                      <h5 class="font-weight-semibold mb-0"><a href="detail.html">Toyota Corolla  2018 Altis Grande</a></h5>
                      <span class="lcPrice d-inline-block ml-3 font-weight-semibold">Call</span>
                    </div>
                    <div class="align-items-center d-flex justify-content-between listingCar-place mb-3">
                      <p class="carplace mb-0">Estonia</p>
                      <p class="themecolor2 font-weight-semibold mb-0 negotiable">Negotiable</p>
                    </div>
                    <div class="align-items-center d-flex justify-content-between aboutcarlist mb-3">
                      <ul class="list-unstyled mb-0">
                        <li class="list-inline-item">2002</li>
                        <li class="list-inline-item">68,000 km</li>
                        <li class="list-inline-item">Petrol</li>
                        <li class="list-inline-item">1000 cc</li>
                        <li class="list-inline-item">Automatic</li>
                      </ul>
                    <figure class="mb-0"><img src="assets/img/small-company-logo.png" alt="carish used cars for sale in estonia" class="list-comp-logo"></figure>
                  </div>
                  <div class="align-items-center d-none justify-content-between gridListprice mb-3">
                    <span class="lcPrice d-inline-block mr-3 font-weight-semibold">$30,000</span>
                    <p class="themecolor2 font-weight-semibold mb-0 negotiable">Negotiable</p>
                  </div>
                  <div class="align-items-center row contactRow">
                    <div class="col-lg-7 col-md-7 col-sm-6 col-6 lc-published">
                      <p class="mb-0">Updated 2 days ago</p>
                    </div>
                    <div class="align-items-center col-6 col-lg-5 col-md-5 col-sm-6 d-flex justify-content-end lc-contact text-right pl-md-3 pl-0">
                      <a href="#" class="d-inline-block fa fa-heart fa-heart-o lc-favorite p-2 mr-2"></a>
                      <a href="#" class="btn contactbtn themebtn3"><em class="fa fa-phone"></em> 0343-9088607</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar">
                  <figure class="mb-0 position-relative">
                    <a href="#"><img src="assets/img/listing-car.jpg" class="img-fluid" alt="carish used cars for sale in estonia"></a>
                    <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                    <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block mt-2">FEATURED</span>
                    <span class="d-inline-block pb-1 pl-2 pr-2 pt-1 viewgallery"><em class="fa fa-camera"></em> 10</span>
                    </figcaption>
                  </figure>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-8 listingCar-descCar">
                  <div class="align-items-center d-flex justify-content-between listingCar-title mb-1">
                    <h5 class="font-weight-semibold mb-0"><a href="detail.html">Toyota Corolla  2018 Altis Grande</a></h5>
                    <span class="lcPrice d-inline-block ml-3 font-weight-semibold">$30,000</span>
                  </div>
                  <div class="align-items-center d-flex justify-content-between listingCar-place mb-3">
                    <p class="carplace mb-0">Estonia</p>
                    <p class="themecolor2 font-weight-semibold mb-0 negotiable">Negotiable</p>
                  </div>
                  <div class="align-items-center d-flex justify-content-between aboutcarlist mb-3">
                    <ul class="list-unstyled mb-0">
                      <li class="list-inline-item">2002</li>
                      <li class="list-inline-item">68,000 km</li>
                      <li class="list-inline-item">Petrol</li>
                      <li class="list-inline-item">1000 cc</li>
                      <li class="list-inline-item">Automatic</li>
                    </ul>
                  <figure class="mb-0"><img src="assets/img/small-company-logo.png" alt="carish used cars for sale in estonia" class="list-comp-logo"></figure>
                </div>
                <div class="align-items-center d-none justify-content-between gridListprice mb-3">
                  <span class="lcPrice d-inline-block mr-3 font-weight-semibold">Call</span>
                  <p class="themecolor2 font-weight-semibold mb-0 negotiable">Negotiable</p>
                </div>
                <div class="align-items-center row contactRow">
                  <div class="col-lg-7 col-md-7 col-sm-6 col-6 lc-published">
                    <p class="mb-0">Updated 2 days ago</p>
                  </div>
                  <div class="align-items-center col-6 col-lg-5 col-md-5 col-sm-6 d-flex justify-content-end lc-contact text-right pl-md-3 pl-0">
                    <a href="#" class="d-inline-block fa fa-heart fa-heart-o lc-favorite p-2 mr-2"></a>
                    <a href="#" class="btn contactbtn themebtn3"><em class="fa fa-phone"></em> 0343-9088607</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar">
                <figure class="mb-0 position-relative">
                  <a href="#"><img src="assets/img/listing-car.jpg" class="img-fluid" alt="carish used cars for sale in estonia"></a>
                  <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                  <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block mt-2">FEATURED</span>
                  <span class="d-inline-block pb-1 pl-2 pr-2 pt-1 viewgallery"><em class="fa fa-camera"></em> 10</span>
                  </figcaption>
                </figure>
              </div>
              <div class="col-lg-9 col-md-9 col-sm-9 col-8 listingCar-descCar">
                <div class="align-items-center d-flex justify-content-between listingCar-title mb-1">
                  <h5 class="font-weight-semibold mb-0"><a href="detail.html">Toyota Corolla  2018 Altis Grande</a></h5>
                  <span class="lcPrice d-inline-block ml-3 font-weight-semibold">Call</span>
                </div>
                <div class="align-items-center d-flex justify-content-between listingCar-place mb-3">
                  <p class="carplace mb-0">Estonia</p>
                  <p class="themecolor2 font-weight-semibold mb-0 negotiable">Negotiable</p>
                </div>
                <div class="align-items-center d-flex justify-content-between aboutcarlist mb-3">
                  <ul class="list-unstyled mb-0">
                    <li class="list-inline-item">2002</li>
                    <li class="list-inline-item">68,000 km</li>
                    <li class="list-inline-item">Petrol</li>
                    <li class="list-inline-item">1000 cc</li>
                    <li class="list-inline-item">Automatic</li>
                  </ul>
                <figure class="mb-0"><img src="assets/img/small-company-logo.png" alt="carish used cars for sale in estonia" class="list-comp-logo"></figure>
              </div>
              <div class="align-items-center d-none justify-content-between gridListprice mb-3">
                <span class="lcPrice d-inline-block mr-3 font-weight-semibold">$30,000</span>
                <p class="themecolor2 font-weight-semibold mb-0 negotiable">Negotiable</p>
              </div>
              <div class="align-items-center row contactRow">
                <div class="col-lg-7 col-md-7 col-sm-6 col-6 lc-published">
                  <p class="mb-0">Updated 2 days ago</p>
                </div>
                <div class="align-items-center col-6 col-lg-5 col-md-5 col-sm-6 d-flex justify-content-end lc-contact text-right pl-md-3 pl-0">
                  <a href="#" class="d-inline-block fa fa-heart fa-heart-o lc-favorite p-2 mr-2"></a>
                  <a href="#" class="btn contactbtn themebtn3"><em class="fa fa-phone"></em> 0343-9088607</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-12 mt-lg-4 pl-0 pr-0">
          <div class="p-md-4 p-3 notifyForm detail-page-notifyform" style=" background: #E4E4E4;">
            <div class="row align-items-center">
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
                      <input type="submit" value="Submit" class="btn btn-block border-0 text-white notifySubBtn">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- listing view ends here -->
      <div class="view-car-by text-right mt-lg-5 mt-4">
        <a href="#" class="themecolor">View all cars by H&A Motors</a>
      </div>
      <div class="bg-white border mt-4 p-4 write-review">
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
          <figure class="mb-3"><img src="assets/img/review-stars.png" class="d-block img-fluid" alt="review stars"></figure>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
          
          <div class="mt-4"><a href="#" class="font-weight-semibold themecolor">Report</a></div>
        </div>
        <div class="posted-review">
          <h6 class="themecolor mb-0">About H&A Motors</h6>
          <p class="review-posted-time">Posted by H&A Motors Sep 02, 2019</p>
        <figure class="mb-3"><img src="assets/img/review-stars.png" class="d-block img-fluid" alt="review stars"></figure>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
        
        <div class="mt-4"><a href="#" class="font-weight-semibold themecolor">Report</a></div>
      </div>
    </div>
  </div>
  
  <div class="align-items-center d-sm-flex justify-content-around mt-md-5 mt-4 pt-2 pt-sm-3 postAdRow">
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
      <a href="#" class="btn themebtn1">SELL YOUR CAR</a>
    </div>
  </div>  
</div>
<!-- right content section ends here -->
</div>
</div>
</div>
@stop