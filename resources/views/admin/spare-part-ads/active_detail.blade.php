@extends('admin.layouts.app')
@push('styles')
<link type="text/css" rel="stylesheet" href="{{asset('public/assets/css/lightslider.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('public/assets/css/lightgallery.min.css')}}" />
@endpush
<style type="text/css">
  .lSGallery img
  {
    height: 100px !important;
    width: 100%;
  }
</style>
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
     <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Spare Part Ads / <a target="" href="{{url('admin/active-part-ads')}}">Active</a> / <a target="" href="{{url('admin/active-part-ad-detail/'.@$ads->id)}}">{{@$ads->title}}</a></h3>
    
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    <a class="btn btn-primary" href="{{ url()->previous() }}">
      <i class="fa fa-arrow-left"></i> Back
    </a>
    <a class="btn btn-warning" id="pending_ad" data-id="{{@$ads->id}}" href="javascript:void(0)">Move To Pending</a>
     
  </div>
  <!-- <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    <a type="submit" class="btn btn-primary" href='javascript:void(0)'>Edit Profile</a>
  </div> -->
</div>

<div class="container-fluid">
<div class="row">
    <div class="col-6 col-md-5 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
            <!-- <div class="col-sm-4 col-3 personal-profile pr-0 pr-sm-3">
              <div class="featureslistitem d-flex align-items-baseline">
                @foreach(@$ads->spare_parts_images as $spare_parts_image)
                  <figure class="mb-0"><img src="{{asset('public/uploads/image/'.@$spare_parts_images->img)}}" ></figure>
                @endforeach
              </div>
            </div> -->
             <div class="section-header">
                <h5 class="mb-1 text-capitalize"> Spare Part Images</h5>
            </div>

          
            <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
        @foreach(@$spare_parts_imagee as $ad_image)
        @if(@$ad_image->img !== null && file_exists( public_path() . '/uploads/ad_pictures/spare-parts-ad/'.$ads->id.'/'.@$ad_image->img))
        <li class="position-relative overflow-hidden rounded" data-thumb="{{asset('public/uploads/ad_pictures/spare-parts-ad/'.@$ads->id.'/'.$ad_image->img)}}" data-src="{{asset('public/uploads/ad_pictures/spare-parts-ad/'.@$ads->id.'/'.$ad_image->img)}}">
          <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-end">
          <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url({{ asset('public/assets/img/imgZoom.png')}})">
          </span>
          </figcaption>
           @if(@$ad_image->img !== null && file_exists( public_path() . '/uploads/ad_pictures/spare-parts-ad/'.$ads->id.'/'.@$ad_image->img))
          <img src="{{asset('public/uploads/ad_pictures/spare-parts-ad/'.@$ads->id.'/'.$ad_image->img)}}" class="img-fluid" style="min-width:100%;min-height:400px;max-height: 400px;">
          @else
          <img src="{{ asset('public/assets/img/sparepartavatar.jpg')}}" class="img-fluid" style="width:100%;height: 370px;">
          @endif
        </li>
        @else
         <li class="position-relative overflow-hidden rounded" data-thumb="{{asset('public/assets/img/sparepartavatar.jpg')}}" data-src="{{asset('public/assets/img/sparepartavatar.jpg')}}">
          <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-end">
          <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url({{ asset('public/assets/img/imgZoom.png')}})">
          </span>
          </figcaption>
           @if(@$ad_image->img !== null && file_exists( public_path() . '/uploads/ad_pictures/spare-parts-ad/'.$ads->id.'/'.@$ad_image->img))
          <img src="{{asset('public/uploads/ad_pictures/spare-parts-ad/'.@$ads->id.'/'.$ad_image->img)}}" class="img-fluid" style="min-width:100%;min-height:400px;max-height: 400px;">
          @else
          <img src="{{ asset('public/assets/img/sparepartavatar.jpg')}}" class="img-fluid" style="width:100%;height: 370px;">
          @endif
        </li>
        @endif
        @endforeach
              
                </ul>
            </div> 
        </div>

    <div class="col-6 col-md-7 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
            <div class="section-header">
                <h5 class="mb-1 text-capitalize"> SparePart Ad Details</h5>
            </div>

            <div class="col-sm-8 col-9">
                    <h5 class="font-weight-bold mb-1"></h5>
                    <div class="dr-job text-capitalize"></div>
                    <div class="row mt-3 dr-detail-row">
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">
                            Title:</h6>
                            <p class="mb-0">{{ @$ads->title }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Price:</h6>
                            <p class="mb-0">{{ @$ads->price }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Category::</h6>
                            <p class="mb-0">{{ @$ads->parent_category->title }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Sub Category:</h6>
                            <p class="mb-0">{{ @$ads->sub_category->title }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">City:</h6>
                            <p class="mb-0">{{ @$ads->city->name }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Vat:</h6>
                            <p class="mb-0">{{ @$ads->vat }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Neg:</h6>
                            <p class="mb-0">{{ @$ads->neg }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Condition:</h6>
                            <p class="mb-0">{{ @$ads->condition }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Add By:</h6>
                            <p class="mb-0">{{ @$ads->get_customer !== null ? (@$ads->get_customer->customer_firstname !== '' ? @$ads->get_customer->customer_firstname : @$ads->get_customer->customer_company) : '--' }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Poster Phone:</h6>
                            <p class="mb-0">{{ @$ads->poster_phone }}</p>
                        </div>
               
            </div>
                    </div>
            </div> 
    </div>
</div>

<form id="sp_ad_languages" method="post" action="{{route('pending-sp-ad-detail')}}">
  {{ csrf_field() }}
  <input type="hidden" name="sp_ad_id" id="sp_ad_id" value="{{$ads->id}}">
<div class="row">
    @foreach(@$languages as $language)
      <div class="col-4 col-md-4 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
          <div class="section-header">
            
              <h5>Description ( {{@$language->language_title}} )</h5>    
          
          </div>

          <div class=" personal-profile pr-0 pr-sm-3">
            <textarea class="form-control" rows="5" id="lang_{{$language->id}}" name="lang_{{$language->id}}">{{ @$ads->get_sp_ad_description($ads->id , $language->id)->description }}</textarea>
          </div>
          </div> 
      </div>
    @endforeach

     @foreach(@$languages as $language)
      <div class="col-4 col-md-4 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
          <div class="section-header">
            
              <h5>Title ( {{@$language->language_title}} )</h5>    
          
          </div>

          <div class=" personal-profile pr-0 pr-sm-3">
            {{ @$ads->get_sp_ad_title($ads->id , $language->id) }}
          </div>
          </div> 
      </div>
    @endforeach
    
</div>
</form>

<div class="col-lg-12 col-md-12 col-sm-12 search-col text-right">
    <button class="btn btn-success" id="sp_ads_detail" >Save</button>
</div>


</div>
<!-- container end -->

<script type="text/javascript">
  $(document).ready(function(){
    $('#sp_ads_detail').click(function(){
      // e.preventDefault();
      $("#sp_ad_languages").submit();
    });
    
    $(document).on('click', '#pending_ad' , function(){
      // e.preventDefault();
      id = $(this).data('id');
      /*******************/
      swal({
          title: "Alert!",
          text: "Are you sure?",
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
                    url:"{{ route('admin-pending-sp-ad')}}",
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