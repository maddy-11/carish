@extends('layouts.app')
@push('scripts')

     <script type="text/javascript" charset="utf-8" defer>
            $(document).ready(function ()
              {
                
              });
              </script>
@endpush
@section('content') 
@php use App\Models\Customers\Customer; @endphp
     <div class="internal-page-content mt-4 pt-4 sects-bg">
        <div class="container">
          <div class="row">
            <div class="col-12 bannerAd pt-2">
              <img src="{{url('public/assets/img/placeholder.jpg')}}" class="img-fluid" alt="carish used cars for sale in estonia">
            </div>
            <div class="col-12 pageTitle mt-md-5 mt-4">
              <div class="bg-white border p-md-4 p-3">
                <h2 class="font-weight-semibold themecolor">{{@$category->title}}</h2>
                <nav aria-label="breadcrumb" class="breadcrumb-menu">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a target="" href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a target="" href="{{url('find_used_cars')}}">Used Cars</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dealers</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
          <div class="row mt-md-5 mt-4">
            <!-- left Sidebar start here -->
            <aside class="col-lg-3 col-12 mb-4 mb-lg-0 left-sidebar">
              <div class="leftsidebar-bg">
            <div class="search-by-filter">
              <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title ">{{__('search.show_results_by')}}: <em class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse" data-target="#searchbyreasult" aria-expanded="false" aria-controls="searchbyreasult"></em></h6>

              <div class="search-filter collapse d-lg-block" id="searchbyreasult">
              <h6 class=" sidebar-title mb-0  pt-3 pb-3 pl-4 pr-4"><img src="{{url('public/assets/img/rIcon-search-filter.png')}}" alt="carish used cars for sale in estonia" class="img-fluid mr-2"> {{__('search.search_filter')}} </h6>
              <div class="bg-white p-4">
                <ul class="list-unstyled mb-0 font-weight-semibold">
                  <li class="alert align-items-center d-flex justify-content-between mb-2 p-0">
                    <a href="#">Honda</a> <span data-dismiss="alert" class="fa fa-close themecolor2"></span></li>
                  <li class="alert align-items-center d-flex justify-content-between mb-2 p-0">
                    <a href="#">Honda</a> <span data-dismiss="alert" class="fa fa-close themecolor2"></span></li>
                  <li class="alert align-items-center d-flex justify-content-between mb-2 p-0">
                    <a href="#">Honda</a> <span data-dismiss="alert" class="fa fa-close themecolor2"></span></li>
                  <li class="alert align-items-center d-flex justify-content-between mb-2 p-0">
                    <a href="#">Honda</a> <span data-dismiss="alert" class="fa fa-close themecolor2"></span></li>
                  <li class="alert align-items-center d-flex justify-content-between mb-2 p-0">
                    <a href="#">Honda</a> <span data-dismiss="alert" class="fa fa-close themecolor2"></span></li>
                  <li class="alert align-items-center d-flex justify-content-between mb-2 p-0">
                    <a href="#">Honda</a> <span data-dismiss="alert" class="fa fa-close themecolor2"></span></li>
                </ul>
              </div>
              </div>
            </div>
            <div class="search-by-name">
              <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title ">SEARCH BY NAME <em class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse" data-target="#searchbyname" aria-expanded="false" aria-controls="searchbyname"></em></h6>
              <div class="search-by-name-bg bg-white collapse d-lg-block" id="searchbyname">
                <div class="p-4">
                  <div class="input-group sidebar-input-group">
                    <input type="text" class="form-control p-2 pr-2" placeholder="e.g Pärnu" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2" type="button"></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="search-by-make">
            <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title ">SEARCH BY Make <em class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse" data-target="#searchbymake" aria-expanded="false" aria-controls="searchbymake"></em></h6>

            <div class="collapse d-lg-block bg-white" id="searchbymake">
              <div class="p-4">
                <div class="input-group sidebar-input-group">
                  <input type="text" class="form-control p-2 pr-2" placeholder="Search  By Make" aria-label="Search By Make">
                  <div class="input-group-append">
                    <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2" type="button"></button>
                  </div>
                </div>

                <ul class="list-unstyled carselectlist mb-0 mt-4 search-by-city-list search-by-make-list"  id="search-by-make">
                  <li>
                    <div class="custom-control mr-2 custom-checkbox ">
                      <input type="checkbox" class="custom-control-input" id="madebyCheck1" name="example1">
                      <label class="custom-control-label" for="madebyCheck1">Cuore</label>
                    </div>
                  </li>
                  <li>
                    <div class="custom-control mr-2 custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="madebyCheck2" name="example1">
                      <label class="custom-control-label" for="madebyCheck2">Mira</label>
                    </div>
                  </li>
                  <li>
                    <div class="custom-control mr-2 custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="madebyCheck3" name="example1">
                      <label class="custom-control-label" for="madebyCheck3">Hijet</label>
                    </div>
                  </li>
                  <li>
                    <div class="custom-control mr-2 custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="madebyCheck4" name="example1">
                      <label class="custom-control-label" for="madebyCheck4">Mira</label>
                    </div>
                  </li>
                  <li>
                    <div class="custom-control mr-2 custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="madebyCheck5" name="example1">
                      <label class="custom-control-label" for="madebyCheck5">Cuore</label>
                    </div>
                  </li>
                  <li>
                    <div class="custom-control mr-2 custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="madebyCheck6" name="example1">
                      <label class="custom-control-label" for="madebyCheck6">Hijet</label>
                    </div>
                  </li>
                </ul>

                <div class="mt-3 show-more text-right">
                  <a href="javascript:void(0)" class="themecolor font-weight-semibold show-more-makes">{{__('ads.show_more')}}</a>
                </div>
              </div>
            </div>
          </div>



          <div class="search-by-model">
            <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title ">SEARCH BY model <em class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse" data-target="#searchbymodel" aria-expanded="false" aria-controls="searchbymodel"></em></h6>

            <div class="collapse d-lg-block bg-white" id="searchbymodel">
              <div class="p-4">
                <div class="input-group sidebar-input-group">
                  <input type="text" class="form-control p-2 pr-2" placeholder="Search  By Model" aria-label="Search By Make">
                  <div class="input-group-append">
                    <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2" type="button"></button>
                  </div>
                </div>
                <ul class="list-unstyled carselectlist mb-0 mt-4 search-by-city-list search-by-make-list" id="search-by-model">
                  <li class="d-flex justify-content-between">
                    <div class="custom-control mr-2 custom-checkbox ">
                      <input type="checkbox" class="custom-control-input" id="modalCheck1" name="example1">
                      <label class="custom-control-label" for="modalCheck1">Cuore</label>
                    </div>
                    <div><span class="badge badge-pill border pb-1 pt-1">980</span></div>
                  </li>
                  <li class="d-flex justify-content-between">
                    <div class="custom-control mr-2 custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="modalCheck2" name="example1">
                      <label class="custom-control-label" for="modalCheck2">Mira</label>
                    </div>
                    <div><span class="badge badge-pill border pb-1 pt-1">711</span></div>
                  </li>
                  <li class="d-flex justify-content-between">
                    <div class="custom-control mr-2 custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="modalCheck3" name="example1">
                      <label class="custom-control-label" for="modalCheck3">Hijet</label>
                    </div>
                    <div><span class="badge badge-pill border pb-1 pt-1">3456</span></div>
                  </li>
                  <li class="d-flex justify-content-between">
                    <div class="custom-control mr-2 custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="modalCheck4" name="example1">
                      <label class="custom-control-label" for="modalCheck4">Mira</label>
                    </div>
                    <div><span class="badge badge-pill border pb-1 pt-1">34</span></div>
                  </li>
                  <li class="d-flex justify-content-between">
                    <div class="custom-control mr-2 custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="modalCheck5" name="example1">
                      <label class="custom-control-label" for="modalCheck5">Cuore</label>
                    </div>
                    <div><span class="badge badge-pill border pb-1 pt-1">36</span></div>
                  </li>
                  <li class="d-flex justify-content-between">
                    <div class="custom-control mr-2 custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="modalCheck6" name="example1">
                      <label class="custom-control-label" for="modalCheck6">Hijet</label>
                    </div>
                    <div><span class="badge badge-pill border pb-1 pt-1">46</span></div>
                  </li>
                </ul>

                <div class="mt-3 show-more text-right">
                  <a href="javascript:void(0)" class="themecolor font-weight-semibold show-more-models">{{__('ads.show_more')}}</a>
                </div>
              </div>
            </div>
          </div>


                      <div class="search-by-city">
                              <h6 class="sidebar-sect-title d-flex justify-content-between mb-0 pb-3 pl-4 pr-4 pt-3 sidebar-title ">{{__('common.search_by_city')}} <em class="fa fa-chevron-circle-right d-lg-none sidebar-collpse-icon" data-toggle="collapse" data-target="#searchbycity" aria-expanded="false" aria-controls="searchbycity"></em></h6>
                              <div class="collapse d-lg-block bg-white" id="searchbycity">
                                <div class="p-4">
                                  <div class="input-group sidebar-input-group">
                                    <input type="text" class="form-control p-2 pr-2" placeholder="e.g Pärnu" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                      <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2" type="button"></button>
                                    </div>
                                  </div>
                                  <ul class="list-unstyled carselectlist mb-0 mt-4 search-by-city-list" id="search-by-city-list">
                                    <li class="d-flex justify-content-between">
                                      <div class="custom-control mr-2 custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="modalCheck1" name="example1">
                                        <label class="custom-control-label" for="modalCheck1">Tallinn</label>
                                      </div>
                                      <div><span class="badge badge-pill border pb-1 pt-1 bgdarklight">980</span></div>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                      <div class="custom-control mr-2 custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="modalCheck2" name="example1">
                                        <label class="custom-control-label" for="modalCheck2">Tartu</label>
                                      </div>
                                      <div><span class="badge badge-pill border pb-1 pt-1 bgdarklight">711</span></div>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                      <div class="custom-control mr-2 custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="modalCheck3" name="example1">
                                        <label class="custom-control-label" for="modalCheck3">Narva</label>
                                      </div>
                                      <div><span class="badge badge-pill border pb-1 pt-1 bgdarklight">3456</span></div>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                      <div class="custom-control mr-2 custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="modalCheck4" name="example1">
                                        <label class="custom-control-label" for="modalCheck4">Pärnu</label>
                                      </div>
                                      <div><span class="badge badge-pill border pb-1 pt-1 bgdarklight">34</span></div>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                      <div class="custom-control mr-2 custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="modalCheck5" name="example1">
                                        <label class="custom-control-label" for="modalCheck5">Kohtla-Järve</label>
                                      </div>
                                      <div><span class="badge badge-pill border pb-1 pt-1 bgdarklight">36</span></div>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                      <div class="custom-control mr-2 custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="modalCheck6" name="example1">
                                        <label class="custom-control-label" for="modalCheck6">Viljandi</label>
                                      </div>
                                      <div><span class="badge badge-pill border pb-1 pt-1 bgdarklight">46</span></div>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                      <div class="custom-control mr-2 custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input" id="modalCheck7" name="example1">
                                        <label class="custom-control-label" for="modalCheck7">Tallinn</label>
                                      </div>
                                      <div><span class="badge badge-pill border pb-1 pt-1 bgdarklight">980</span></div>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                      <div class="custom-control mr-2 custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="modalCheck8" name="example1">
                                        <label class="custom-control-label" for="modalCheck8">Tartu</label>
                                      </div>
                                      <div><span class="badge badge-pill border pb-1 pt-1 bgdarklight">711</span></div>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                      <div class="custom-control mr-2 custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="modalCheck9" name="example1">
                                        <label class="custom-control-label" for="modalCheck9">Narva</label>
                                      </div>
                                      <div><span class="badge badge-pill border pb-1 pt-1 bgdarklight">3456</span></div>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                      <div class="custom-control mr-2 custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="modalCheck10" name="example1">
                                        <label class="custom-control-label" for="modalCheck10">Pärnu</label>
                                      </div>
                                      <div><span class="badge badge-pill border pb-1 pt-1 bgdarklight">34</span></div>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                      <div class="custom-control mr-2 custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="modalCheck11" name="example1">
                                        <label class="custom-control-label" for="modalCheck11">Kohtla-Järve</label>
                                      </div>
                                      <div><span class="badge badge-pill border pb-1 pt-1 bgdarklight">36</span></div>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                      <div class="custom-control mr-2 custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="modalCheck12" name="example1">
                                        <label class="custom-control-label" for="modalCheck12">Viljandi</label>
                                      </div>
                                      <div><span class="badge badge-pill border pb-1 pt-1 bgdarklight">46</span></div>
                                    </li>
                                  </ul>
                                  <div class="mt-3 show-more text-right">
                                    <a href="javascript:void(0)" class="themecolor font-weight-semibold show-more-cities">{{__('ads.show_more')}}</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="sidebar-banner mt-4 pt-1 d-lg-block d-none">
                            <img src="{{url('public/assets/img/sidebar-banner.jpg')}}" alt="carish used cars for sale in estonia" class="img-fluid d-block ml-auto mr-auto">
                          </div>
                        </aside>
                        <!-- left Sidebar ends here -->
                        <!-- right content section starts here -->
                        <div class="col-lg-9 col-12 right-content used-car-dealer">
                          <!-- listing view starts here -->
                          <div class="ml-0 mr-0 row used-car-dealer-row">
                            @if(@$customer_ids != null)
                            @foreach($customer_ids as $customer_id)
                            @php
                            
                              $customer = Customer::where('id',$customer_id->customer_id)->first();
                              
                             @endphp
                            <div class="bg-white border col-12 dealer-listing-Col mb-3 p-2 pr-3">
                              <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-4 col-4 pr-2 pl-md-3 car-dealer-img">
                                  <figure class="align-items-center d-flex justify-content-center mb-0 position-relative">
                                    <a href="#" class="d-block"><img src="{{url('public/uploads/customers/logos/'.@$customer->logo)}}" class="img-fluid w-100" alt="carish used cars for sale in estonia"></a>
                                    <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                                    <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-white d-inline-block mt-2">FEATURED</span>
                                    </figcaption>
                                  </figure>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-8 col-8 car-dealer-list-desc pt-2">
                                  <div class="align-items-center d-flex mb-2">
                                    <a target="" href="{{url('company_profile/'.@$customer->id)}}">
                                    <h4 class="mb-0">{{@$customer->customer_company}}</h4></a>
                                    <span class="badge badge-pill badge-success d-inline-block ml-2 p-1 pr-2"><em class="fa fa-check-circle mr-2"></em>VERIFIED</span>
                                  </div>
                                  <div class="dealer-place-cont align-items-center d-flex mb justify-content-between mb-md-3 mb-2">
                                    <span class="d-inline-block dealer-place">Dealers - Estonia</span>
                                    <img src="{{url('public/assets/img/review-stars.png')}}" class="d-md-inline-block d-sm-block img-fluid mb-md-0 mb-sm-3">
                                  </div>
                                  <ul class="list-unstyled mb-0 font-weight-semibold">
                                    <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span> {{@$customer->customer_default_address}}</li>
                                    <li class="d-flex"><span class="mr-2"><em class="fa fa-phone"></em></span> {{@$customer->customers_telephone}}</li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                            @endforeach
                            @endif
                         
                          </div>
                          <!-- listing view ends here -->
                          <div class="row mt-3">
                            <div class="col-12 carList-pager">
                              <nav class="bg-white border p-3" aria-label="Page navigation example">
                                <ul class="justify-content-center mb-0 pagination">
                                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                                  <li class="page-item">
                                    <a class="page-link" href="#">Next <em class="fa fa-angle-right"></em></a>
                                  </li>
                                  <li class="page-item">
                                    <a class="page-link" href="#">last <em class="fa fa-angle-double-right"></em></a>
                                  </li>
                                </ul>
                              </nav>
                            </div>
                          </div>
                        </div>
                        <!-- right content section ends here -->
                      </div>
                    </div>
                  </div>
@endsection