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
   <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Offer Services / <a target="" href="{{url('admin/active-services')}}">Active</a> / <a target="" href="{{url('admin/active-service-details/'.@$service->id)}}">{{@$service->primary_service->title}}</a></h3>
    
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    <a class="btn btn-primary" href="{{ url()->previous() }}">
      <i class="fa fa-arrow-left"></i> Back
    </a>
    <a class="btn btn-success" id="pending_service" data-id="{{@$service->id}}" href="javascript:void(0)">Pending</a>
  </div>
</div>

<div class="container-fluid">
<div class="row">
    <div class="col-6 col-md-6 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
            <div class="section-header">
                <h5 class="mb-1 text-capitalize"> Company Detail</h5>
            </div>

            <div class="row">
              <div class="col-sm-4 col-2 personal-profile pr-0 pr-sm-3">
                    <img src="{{asset('public/uploads/customers/logos/'.@$service->get_customer->logo)}}" class="img-fluid" alt="carish used cars for sale in estonia" height="100%" width="100%">
            </div>

            <div class="col-sm-8 col-9">
                    <h5 class="font-weight-bold mb-1"></h5>
                    <div class="dr-job text-capitalize"></div>
                    <div class="row mt-3 dr-detail-row">
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">
                            Name:</h6>
                            <p class="mb-0">
                              @if($service->get_customer->customer_role == 'business')
                                {{ @$service->get_customer->customer_company }}
                              @else
                                {{ @$service->get_customer->customer_firstname }} {{ @$service->get_customer->customer_firstname }}
                              @endif 
                            </p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">vat:</h6>
                            <p class="mb-0"> {{ @$service->get_customer->customer_vat }}  </p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Registration:</h6>
                            <p class="mb-0">{{ @$service->get_customer->customer_registeration }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Gender:</h6>
                            <p class="mb-0">{{ @$service->get_customer->customer_gender }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">Email:</h6>
                            <p class="mb-0">{{ @$service->get_customer->customer_email_address }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Address:</h6>
                            <p class="mb-0">{{ @$service->get_customer->customer_default_address }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Tel:</h6>
                            <p class="mb-0">{{ @$service->get_customer->customers_telephone }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Language:</h6>
                            <p class="mb-0">{{ $service->get_customer->language->language_title }}</p>
                        </div>
            </div>
                    </div>
            </div>
            
            </div> 
        </div>

    <div class="col-6 col-md-6 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
            <div class="section-header">
                <h5 class="mb-1 text-capitalize"> Service Detail</h5>
            </div>

            <div class="col-sm-8 col-9">
                    <h5 class="font-weight-bold mb-1"></h5>
                    <div class="dr-job text-capitalize"></div>
                    <div class="row mt-3 dr-detail-row">
                        
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Phone of Service:</h6>
                            <p class="mb-0">{{ @$service->phone_of_service }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Service status:</h6>
                            <p class="mb-0">{{ @$service->service_status }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Add By:</h6>
                            <p class="mb-0">{{ @$service->get_customer !== null ? (@$service->get_customer->customer_firstname !== '' ? @$service->get_customer->customer_firstname : @$service->get_customer->customer_company) : '--' }}</p>
                        </div>
                       <!--  <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">Poster Email:</h6>
                            <p class="mb-0">{{ @$service->poster_email }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Poster Phone:</h6>
                            <p class="mb-0">{{ @$service->poster_phone }}</p>
                        </div> -->

                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Primary Service:</h6>
                            <p class="mb-0">{{ @$service->primary_service->title }}</p>
                        </div>
                        <h5>Parent and Sub Categories</h5>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                          @foreach($sub_services_data as $data)
                            <h6 class="text-capitalize font-weight-bold mb-1">{{$data['ps_title']}}:</h6>
                            @foreach($data['cs_titles'] as $cs_title)

                              <p class="mb-0">{{ $cs_title['cs_title'] }}</p>
                            @endforeach
                          @endforeach
                        </div>
           
            </div>
                    </div>
            </div> 
    </div>
</div>

<form id="ad_languages" method="post" action="{{route('pending-service-detail-form')}}">
  {{ csrf_field() }}
  <input type="hidden" name="service_id" id="service_id" value="{{$service->id}}">
<div class="row">
    @foreach(@$languages as $language)
      <div class="col-4 col-md-4 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
          <div class="section-header">
            
              <h5>Service Description ( {{@$language->language_title}} )</h5>    
          
          </div>

          <div class=" personal-profile pr-0 pr-sm-3">
            {{ @$service->get_service_description(@$service->id , @$language->id)->description }}
          </div>
          </div> 
      </div>
    @endforeach
    
</div>
</form>

<div class="col-lg-12 col-md-12 col-sm-12 search-col text-right">
    
    <button class="btn btn-success" id="service_detail" >Save</button>
</div>


</div>
<!-- container end -->

<script type="text/javascript">
  $(document).ready(function(){
    $('#service_detail').click(function(){
      // e.preventDefault();
      $("#ad_languages").submit();
    });


    $(document).on('click', '#pending_service' , function(){
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