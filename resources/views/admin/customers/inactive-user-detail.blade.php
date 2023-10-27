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
       <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Business Users / <a target="" href="{{url('admin/in-active/user')}}">InActive</a> / <a target="" href="{{url('admin/in-active/user-detail/'.@$user->id)}}">
          {{ @$user->customer_company }}</a></h3>
        @else
          <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Individual Users / <a target="" href="{{url('admin/in-active/user')}}">InActive</a> / <a target="" href="{{url('admin/in-active/user-detail/'.@$user->id)}}">
          {{ @$user->customer_firstname }} {{ @$user->customer_lastname }}</a></h3>
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
                            Name:</h6>
                            <p class="mb-0">
                              @if($user->customer_role == 'business')
                                {{ @$user->customer_company }}
                              @else
                                {{ @$user->customer_company }}
                              @endif 
                            </p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">vat:</h6>
                            <p class="mb-0"> {{ @$user->customer_vat }}  </p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Registration:</h6>
                            <p class="mb-0">{{ @$user->customer_registeration }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Gender:</h6>
                            <p class="mb-0">{{ @$user->customer_gender }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">Email:</h6>
                            <p class="mb-0">{{ @$user->customer_email_address }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Address:</h6>
                            <p class="mb-0">{{ @$user->customer_default_address }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Tel:</h6>
                            <p class="mb-0">{{ @$user->customers_telephone }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Language:</h6>
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
</div>




</div>
<!-- container end -->

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

  });
</script>

@endsection