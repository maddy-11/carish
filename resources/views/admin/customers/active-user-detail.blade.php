@extends('admin.layouts.app')
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

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

  <div class="d-md-none h-search-col search-col col-12 collapse" id="searchsection">
    <div class="input-group custom-input-group mb-3" >
      <input type="text" class="form-control" placeholder="Search">
      <div class="align-items-center input-group-prepend">
        <span class="input-group-text fa fa-search"></span>
      </div>
    </div>
  </div>

  <div class="col-lg-8 col-md-7 col-sm-7  title-col">
       @if($user->customer_role == 'business')
       <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Business Users / <a target="" href="{{url('admin/active/user')}}">Active</a> / <a target="" href="{{url('admin/active/user-detail/'.@$user->id)}}">
          {{ @$user->customer_company }}</a></h3>
        @else
          <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Individual Users / <a target="" href="{{url('admin/active/user')}}">Active</a> / <a target="" href="{{url('admin/active/user-detail/'.@$user->id)}}">
          {{ @$user->customer_company }}</a></h3>
        @endif
    
    
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    <a class="btn btn-primary" href="{{ url()->previous() }}">
      <i class="fa fa-arrow-left"></i> Back
    </a>
    <!-- <a class="btn btn-success" id="pending_service" data-id="{{@$user->id}}" href="javascript:void(0)">Pending</a> -->
  </div>
</div>

<div class="container-fluid">
<div class="row">
    <div class="col-6 col-md-6 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
            <div class="section-header">
                <h5 class="mb-1 text-capitalize"> User Detail</h5>
            </div>

            <div class="row">
              <div class="col-sm-4 col-2 personal-profile pr-0 pr-sm-3">
                 @if(@$user->logo != null && file_exists( public_path() . '/uploads/customers/logos/'.@$user->logo))
                    <img src="{{asset('public/uploads/customers/logos/'.@$user->logo)}}" class="img-fluid" alt="carish used cars for sale in estonia" height="100%" width="100%">
                @else
                    <img src="{{asset('public/admin/assets/img/student_avatar.jpeg')}}" class="img-fluid" alt="carish used cars for sale in estonia" height="100%" width="100%">
                @endif
            </div>

            <div class="col-sm-8 col-9">
                    <h5 class="font-weight-bold mb-1"></h5>
                    <div class="dr-job text-capitalize"></div>
                    <div class="row mt-3 dr-detail-row">
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">
                                @if($user->customer_role == 'business') 
                                Company Name: 
                                 @else
                                Full Name 
                                @endif
                                </h6>
                            <p class="mb-0">{{ @$user->customer_company }}</p>
                        </div>
                        @if($user->customer_role == 'business')
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Address:</h6>
                            <p class="mb-0">{{ @$user->customer_default_address }}</p>
                        </div>

                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">VAT #:</h6>
                            <p class="mb-0">{{ @$user->customer_vat }}</p>
                        </div>

                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Registration Number#:</h6>
                            <p class="mb-0">{{ @$user->customer_registeration }}</p>
                        </div>

                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Website:</h6>
                            <p class="mb-0">{{ @$user->website }}</p>
                        </div>

                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Working Hours:</h6>
                            <p class="mb-0">{{ @$user->website }}</p>
                        </div>
                        @endif

                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">City:</h6>
                            <p class="mb-0">{{ @$user->city->name }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">Email:</h6>
                            <p class="mb-0">{{ @$user->customer_email_address }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Phone:</h6>
                            <p class="mb-0">{{ @$user->customers_telephone }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Preferred Language:</h6>
                            <p class="mb-0">{{ @$user->language->language_title }}</p>
                        </div>
            </div>
                    </div>
            </div>
            
            </div> 
        </div>

    <div class="col-6 col-md-6 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
            <div class="section-header">
                <h5 class="mb-1 text-capitalize"> User Info</h5>
            </div>

            <div class="col-sm-8 col-9">
                    <h5 class="font-weight-bold mb-1"></h5>
                    <div class="dr-job text-capitalize"></div>
                    <div class="row mt-3 dr-detail-row">
                      <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Phone of Service:</h6>
                            <p class="mb-0">abc</p>
                        </div>
                    </div>
                    </div>
            </div> 
    </div>

    <div class="col-12 col-md-12 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
            <div class="section-header">
                <h5 class="mb-1 text-capitalize"> Customer Invoices</h5>
            </div>

            <div class="row">
               <div class="table-responsive">
        <table class="table table-bordered" id="myTable" style="width:100%">
          <thead>
              <tr>
               <th>Action</th>
               <th>Invoice No.</th>
               <th>Customer</th>
               <th>Amount</th> 
               <th>Details</th>
               <th>Type</th>
               <th>Status</th>
             
              </tr>
          </thead>
          <tbody>
             @foreach($customers_accounts as $account)
              <tr>
               <td class="text-center">
                 @if(@$account->status == 1)
                <span>--</span>
                 @else
              
                  <span style="border: 1px solid green;padding: 3px;cursor: pointer;" class="approve" data-id="{{@$account->id}}"><i class="fa fa-check" style="color: green;" title="Approve It"></i></span>
                  @endif
               </td>
                <td>
                 <a href="javascript:void(0)" class="themecolor download_invoice" data-id="{{@$account->id}}">C{{@$account->id}}</a>
                </td>
                <td>
                {{@$account->get_customer->customer_company !== null ? @$account->get_customer->customer_company : @$account->get_customer->firstname}}
                </td>
                <td>
                  {{@$account->paid_amount != null ? @$account->paid_amount : (@$account->credit != null ? @$account->credit : @$account->debit)}}
                </td>
                <td>
                  @if(@$account->type !== null)

                    @if(@$account->type == 'car' && @$account->credit !== null)
                      <span>Amount to be paid for featuring {{@$account->car_ad->maker->title}} {{@$account->car_ad->model->name}} {{@$account->car_ad->versions->name}} {{@$account->car_ad->year}} Car</span>
                    @elseif(@$account->type == 'car' && @$account->debit !== null)
                    <span>Amount paid for featuring {{@$account->car_ad->maker->title}} {{@$account->car_ad->model->name}} {{@$account->car_ad->versions->name}} {{@$account->car_ad->year}} Car</span>

                     @elseif(@$account->type == 'sparepart' && @$account->credit !== null)
                     <span>Amount to be paid for featuring {{@$account->sparepart_ad->title}} Spare Part</span>
                     @elseif(@$account->type == 'sparepart' && @$account->debit !== null)
                      <span>Amount paid for featuring {{@$account->sparepart_ad->title}} Spare Part</span>

                     @elseif(@$account->type == 'offerservice' && @$account->credit !== null)
                       <span>Amount to be paid for featuring {{@$account->offerservice->primary_service->title}} Offer Service</span>
                      @elseif(@$account->type == 'offerservice' && @$account->debit !== null)
                       <span>Amount paid for featuring {{@$account->offerservice->primary_service->title}} Offer Service</span>
                       @elseif(@$account->type == 'balance_added' && @$account->credit !== null)
                       <span>Balance Added</span>
                    @endif
                  @endif
                </td>
                
                <td>
                 <span style="text-transform: uppercase;"> {{@$account->type}} </span>
                </td>
                <td>
                  {{@$account->status == 0 ? 'Pending' : 'Approved'}}
                </td>
              </tr>
            @endforeach
          </tbody>
      </table>
    </div>
            </div>
            
            </div> 
        </div>
</div>




</div>
<!-- container end -->

<!-- export pdf form starts -->
      <form class="export-quot-form" method="post" action="{{route('admin-export-pdf')}}">
        @csrf
       <input type="hidden" name="invoice_number" class="invoice_number">
      </form>
    <!-- export pdf form ends -->

<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click', '#pending_serviceee' , function(){
      // e.preventDefault();
      id = $(this).data('id');
      /*******************/
      swal({
          title: "Alert!",
          text: "Are you sure ?",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          cancelButtonText: "No!",
          closeOnConfirm: true,
          closeOnCancel: true
       },
         function(isConfirm) {
           if (isConfirm){
             /*******************************/

            
                $.ajax({
                    url:"{{ route('admin-make-pending-service')}}",
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        if(data.success == true){
                          window.location = data.url;
                        }
                    }
                });
            
        
             /*******************************/
          } 
          else{
              swal("Cancelled", "", "error");
          }
       
    });
      /*******************/

    });

    $('.download_invoice').on('click',function(){
    // alert($(this).data('id'));
    $('.invoice_number').val($(this).data('id'));
    $('.export-quot-form')[0].submit();
   })

  });
</script>

@endsection