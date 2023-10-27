@extends('layouts.app')
@push('scripts')

     <script type="text/javascript" charset="utf-8" defer>
            $(document).ready(function ()
              {
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
              });
              </script>
@endpush
@section('content')

@php
    $cities = Statichelper::getCities();
    $makers = Statichelper::getCars();
    $years  = Statichelper::getYears();
    $colors = Statichelper::getColors();
@endphp
    <div class="internal-page-content mt-4 pt-4 sects-bg">
        <div class="container">
          <div class="row">
            <div class="col-12 bannerAd pt-2">
              <a href="#" target=""><img src="assets/img/placeholder.jpg" class="img-fluid" alt="carish used cars for sale in estonia"></a>
            </div>
            <div class="col-12 pageTitle mt-md-5 mt-4">
              <div class="bg-white border p-md-4 p-3">
                <h2 class="font-weight-semibold">Used Cars For Sale In Estonia (6550)</h2>
                <nav aria-label="breadcrumb" class="breadcrumb-menu">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Used Cars</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cars For Sale In Estonia</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
          <div class="row mt-md-5 mt-4">
            <!-- left Sidebar start here -->
            <aside class="col-lg-3 col-12 mb-4 mb-lg-0 left-sidebar">
              <div class="leftsidebar-bg">
                <div class="sidebar-sect-title align-items-center d-flex justify-content-between filterDown pt-3 pb-3 pl-4 pr-4">
                  <h6 class="sidebar-title mb-0">{{__('search.show_results_by')}}:</h6>
                  <em class="fa fa-chevron-circle-down d-lg-none"></em>
                </div>
                <div id="searchResultFilter">
                  <div class="card">
                    <div class="card-header pl-4 pr-4" id="heading1">
                      <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby1" aria-expanded="true" aria-controls="searchby1">
                      <figure class="text-center mb-0"><img src="assets/img/rIcon-search-filter.png" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                      <span>{{__('search.search_filter')}} <small class="d-block">Any</small></span>
                    </a>
                  </div>
                  <div id="searchby1" class="collapse show" aria-labelledby="heading1" data-parent="#searchResultFilter">
                    <div class="card-body">
                      <ul class="list-unstyled">
                        <li class="align-items-center d-flex justify-content-between">
                          <a href="#">Honda</a> <span class="fa fa-close themecolor2"></span></li>
                          <li class="align-items-center d-flex justify-content-between">
                            <a href="#">Honda</a> <span class="fa fa-close themecolor2"></span></li>
                            <li class="align-items-center d-flex justify-content-between">
                              <a href="#">Honda</a> <span class="fa fa-close themecolor2"></span></li>
                              <li class="align-items-center d-flex justify-content-between">
                                <a href="#">Honda</a> <span class="fa fa-close themecolor2"></span></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header pl-4 pr-4" id="heading2">
                            <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby2" aria-expanded="false" aria-controls="searchby2">
                            <figure class="text-center mb-0"></figure>
                            <span>Make <small class="d-block">Any</small></span>
                          </a>
                        </div>

                        <div id="searchby2" class="collapse" aria-labelledby="heading2" data-parent="#searchResultFilter">
                          <div class="card-body">
                            <div class="input-group sidebar-input-group mb-3">
                                    <input type="text" class="form-control p-2 pr-2" placeholder="Search by Make" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                      <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2" type="button"></button>
                                    </div>
                             </div>
                            <ul class="list-unstyled carselectlist mb-0">
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
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-header pl-4 pr-4" id="heading3">
                          <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby3" aria-expanded="false" aria-controls="searchby3">
                          <figure class="text-center mb-0"><img src="assets/img/rIcon-bodystyle.png" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                          <span>Model <small class="d-block">Any</small></span>
                        </a>
                      </div>
                      <div id="searchby3" class="collapse" aria-labelledby="heading3" data-parent="#searchResultFilter">
                        <div class="card-body">
                          <div class="input-group sidebar-input-group mb-3">
                                    <input type="text" class="form-control p-2 pr-2" placeholder="Search by Modal" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                      <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2" type="button"></button>
                                    </div>
                             </div>
                          <ul class="list-unstyled carselectlist mb-0">
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
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header pl-4 pr-4" id="heading4">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby4" aria-expanded="false" aria-controls="searchby4">
                        <figure class="text-center mb-0"><img src="assets/img/rIcon-price.png" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                        <span>Price <small class="d-block">Any</small></span>
                      </a>
                    </div>
                    <div id="searchby4" class="collapse" aria-labelledby="heading6" data-parent="#searchResultFilter">
                      <div class="card-body">
                        <div class="form-group d-flex mb-0">
                          <select name="priceFrom" class="form-control p-1">
                            <option value="">From</option>
                            <option value="">0</option>
                            <option value="">10000</option>
                            <option value="">20000</option>
                            <option value="">30000</option>
                            <option value="">40000</option>
                            <option value="">50000</option>
                            <option value="">70000</option>
                            <option value="">80000</option>
                            <option value="">90000</option>
                            <option value="">100000</option>
                          </select>
                          <select name="priceTo" class="form-control p-1 ml-2 mr-2">
                            <option value="">To</option>
                            <option value="">0</option>
                            <option value="">10000</option>
                            <option value="">20000</option>
                            <option value="">30000</option>
                            <option value="">40000</option>
                            <option value="">50000</option>
                            <option value="">70000</option>
                            <option value="">80000</option>
                            <option value="">90000</option>
                            <option value="">100000</option>
                          </select>
                          <button type="button" class="fa fa-check themebtn3"></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header pl-4 pr-4" id="heading5">
                      <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby5" aria-expanded="false" aria-controls="searchby5">
                      <figure class="text-center mb-0"><img src="assets/img/rIcon-mileage.png" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                      <span>Mieage <small class="d-block">Any</small></span>
                    </a>
                  </div>
                  <div id="searchby5" class="collapse" aria-labelledby="heading6" data-parent="#searchResultFilter">
                    <div class="card-body">
                      <div class="form-group d-flex mb-0">
                        <select name="mileageFrom" class="form-control p-1">
                          <option value="">From</option>
                          <option value="">0</option>
                          <option value="">10000</option>
                          <option value="">20000</option>
                          <option value="">30000</option>
                          <option value="">40000</option>
                          <option value="">50000</option>
                          <option value="">70000</option>
                          <option value="">80000</option>
                          <option value="">90000</option>
                          <option value="">100000</option>
                        </select>
                        <select name="mileageTo" class="form-control p-1 ml-2 mr-2">
                          <option value="">To</option>
                          <option value="">0</option>
                          <option value="">10000</option>
                          <option value="">20000</option>
                          <option value="">30000</option>
                          <option value="">40000</option>
                          <option value="">50000</option>
                          <option value="">70000</option>
                          <option value="">80000</option>
                          <option value="">90000</option>
                          <option value="">100000</option>
                        </select>
                        <button type="button" class="fa fa-check themebtn3"></button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header pl-4 pr-4" id="heading6">
                    <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby6" aria-expanded="false" aria-controls="searchby6">
                    <figure class="text-center mb-0"><img src="assets/img/rIcon-location.png" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                    <span>Location <small class="d-block">Any</small></span>
                  </a>
                </div>
                <div id="searchby6" class="collapse" aria-labelledby="heading6" data-parent="#searchResultFilter">
                  <div class="card-body">
                    <div class="input-group sidebar-input-group mb-3">
                                    <input type="text" class="form-control p-2 pr-2" placeholder="Search by Locaion" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                      <button class="btn fa fa-search pl-2 pr-2 searchIconBtn text-white themebtn2" type="button"></button>
                                    </div>
                             </div>
                    <ul class="list-unstyled carselectlist mb-0">
                      <li class="d-flex justify-content-between">
                        <div class="custom-control mr-2 custom-checkbox ">
                          <input type="checkbox" class="custom-control-input" id="locationCheck1" name="example1">
                          <label class="custom-control-label" for="locationCheck1">Karachi</label>
                        </div>
                        <div><span class="badge badge-pill border pb-1 pt-1">895</span></div>
                      </li>
                      <li class="d-flex justify-content-between">
                        <div class="custom-control mr-2 custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="locationCheck2" name="example1">
                          <label class="custom-control-label" for="locationCheck2">Lahore</label>
                        </div>
                        <div><span class="badge badge-pill border pb-1 pt-1">677</span></div>
                      </li>
                      <li class="d-flex justify-content-between">
                        <div class="custom-control mr-2 custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="locationCheck3" name="example1">
                          <label class="custom-control-label" for="locationCheck3">Islamabad</label>
                        </div>
                        <div><span class="badge badge-pill border pb-1 pt-1">320</span></div>
                      </li>
                      <li class="d-flex justify-content-between">
                        <div class="custom-control mr-2 custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="locationCheck4" name="example1">
                          <label class="custom-control-label" for="locationCheck4">Rawalpindi</label>
                        </div>
                        <div><span class="badge badge-pill border pb-1 pt-1">217</span></div>
                      </li>
                      <li class="d-flex justify-content-between">
                        <div class="custom-control mr-2 custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="locationCheck5" name="example1">
                          <label class="custom-control-label" for="locationCheck5">Multan</label>
                        </div>
                        <div><span class="badge badge-pill border pb-1 pt-1">109</span></div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header pl-4 pr-4" id="heading7">
                  <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby7" aria-expanded="false" aria-controls="searchby7">
                  <figure class="text-center mb-0"><img src="assets/img/rIcon-bodystyle.png" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                  <span>Body Style <small class="d-block">Any</small></span>
                </a>
              </div>
              <div id="searchby7" class="collapse" aria-labelledby="heading7" data-parent="#searchResultFilter">
                <div class="card-body">
                  <ul class="list-unstyled">
                    <li class="align-items-center d-flex justify-content-between">
                      <a href="#">Honda</a> <span class="fa fa-close"></span></li>
                      <li class="align-items-center d-flex justify-content-between">
                        <a href="#">Honda</a> <span class="fa fa-close"></span></li>
                        <li class="align-items-center d-flex justify-content-between">
                          <a href="#">Honda</a> <span class="fa fa-close"></span></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header pl-4 pr-4" id="heading8">
                      <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby8" aria-expanded="false" aria-controls="searchby8">
                      <figure class="text-center mb-0"><img src="assets/img/rIcon-fuel.png" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                      <span>Fuel <small class="d-block">Any</small></span>
                    </a>
                  </div>
                  <div id="searchby8" class="collapse" aria-labelledby="heading8" data-parent="#searchResultFilter">
                    <div class="card-body">
                      <ul class="list-unstyled">
                        <li class="align-items-center d-flex justify-content-between">
                          <a href="#">Honda</a> <span class="fa fa-close"></span></li>
                          <li class="align-items-center d-flex justify-content-between">
                            <a href="#">Honda</a> <span class="fa fa-close"></span></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header pl-4 pr-4" id="heading9">
                        <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby9" aria-expanded="false" aria-controls="searchby9">
                        <figure class="text-center mb-0"><img src="assets/img/rIcon-gearbox.png" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                        <span>Gearbox <small class="d-block">Any</small></span>
                      </a>
                    </div>
                    <div id="searchby9" class="collapse" aria-labelledby="heading9" data-parent="#searchResultFilter">
                      <div class="card-body">
                        <ul class="list-unstyled carselectlist mb-0">
                          <li class="d-flex justify-content-between">
                            <div class="custom-control mr-2 custom-checkbox ">
                              <input type="checkbox" class="custom-control-input" id="gearboxCheck1" name="example1">
                              <label class="custom-control-label" for="gearboxCheck1">White</label>
                            </div>
                            <div><span class="badge badge-pill border pb-1 pt-1">895</span></div>
                          </li>
                          <li class="d-flex justify-content-between">
                            <div class="custom-control mr-2 custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="gearboxCheck2" name="example1">
                              <label class="custom-control-label" for="gearboxCheck2">Black</label>
                            </div>
                            <div><span class="badge badge-pill border pb-1 pt-1">677</span></div>
                          </li>
                          <li class="d-flex justify-content-between">
                            <div class="custom-control mr-2 custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="gearboxCheck3" name="example1">
                              <label class="custom-control-label" for="gearboxCheck3">Red</label>
                            </div>
                            <div><span class="badge badge-pill border pb-1 pt-1">320</span></div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header pl-4 pr-4" id="heading10">
                      <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby10" aria-expanded="false" aria-controls="searchby10">
                      <figure class="text-center mb-0"><img src="assets/img/rIcon-color.png" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                      <span>Colour <small class="d-block">Any</small></span>
                    </a>
                  </div>
                  <div id="searchby10" class="collapse" aria-labelledby="heading10" data-parent="#searchResultFilter">
                    <div class="card-body">
                      <ul class="list-unstyled carselectlist mb-0">
                        <li class="d-flex justify-content-between">
                          <div class="custom-control mr-2 custom-checkbox ">
                            <input type="checkbox" class="custom-control-input" id="colorCheck1" name="example1">
                            <label class="custom-control-label" for="colorCheck1">White</label>
                          </div>
                          <div><span class="badge badge-pill border pb-1 pt-1">895</span></div>
                        </li>
                        <li class="d-flex justify-content-between">
                          <div class="custom-control mr-2 custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="colorCheck2" name="example1">
                            <label class="custom-control-label" for="colorCheck2">Black</label>
                          </div>
                          <div><span class="badge badge-pill border pb-1 pt-1">677</span></div>
                        </li>
                        <li class="d-flex justify-content-between">
                          <div class="custom-control mr-2 custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="colorCheck3" name="example1">
                            <label class="custom-control-label" for="colorCheck3">Red</label>
                          </div>
                          <div><span class="badge badge-pill border pb-1 pt-1">320</span></div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header pl-4 pr-4" id="heading11">
                    <a href="#" class="collapsed align-items-center d-flex" data-toggle="collapse" data-target="#searchby11" aria-expanded="false" aria-controls="searchby11">
                    <figure class="text-center mb-0"><img src="assets/img/rIcon-enginesize.png" alt="carish used cars for sale in estonia" class="img-fluid"></figure>
                    <span>Engine Size <small class="d-block">Any</small></span>
                  </a>
                </div>
                <div id="searchby11" class="collapse" aria-labelledby="heading11" data-parent="#searchResultFilter">
                  <div class="card-body">
                    <div class="form-group d-flex mb-0">
                      <input type="text" name="engineccFrom" placeholder="From" class="form-control p-1">
                      <input type="text" name="engineccTo" placeholder="To" class="form-control p-1 ml-2 mr-2">
                      <button type="button" class="fa fa-check themebtn3"></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </aside>
        <!-- left Sidebar ends here -->
        <!-- right content section starts here -->
        <div class="col-lg-9 col-12 right-content">
          <!-- sorting and listing/grid section start here -->
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
          <!-- sorting and listing/grid section ends here -->
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
                    <span></span>
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
                    <span></span>
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
            </div><div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
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
                  <span></span>
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
          </div><div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
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
                <span></span>
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
        </div><div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
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
              <span></span>
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
              <span></span>
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
              <span></span>
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
              <span></span>
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
              <span></span>
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
              <span></span>
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
              <span></span>
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
              <span></span>
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
      <div class="col-12 p-md-4 p-3 mt-3 notifyForm">
        <div class="p-sm-2">
          <h5 class="themecolor"><em class="fa fa-bell"></em> Notify Me</h5>
          <p>Receive email notifications for the latest ads matching your search criteria</p>
          <form>
            <div class="row">
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
              <span></span>
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
              <span></span>
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
              <span></span>
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
              <span></span>
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
              <span></span>
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
              <span></span>
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
@endsection