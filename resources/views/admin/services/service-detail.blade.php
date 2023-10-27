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
$(document).ready(function (){
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
<?php Use Carbon\Carbon; ?>
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
  <div class="d-md-none h-search-col search-col col-12 collapse" id="searchsection">
    <div class="input-group custom-input-group mb-3" >
      <input type="text" class="form-control" placeholder="Search">
      <div class="align-items-center input-group-prepend">
        <span class="input-group-text fa fa-search"></span>
      </div>
    </div>
  </div>

   <div class="col-lg-6 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Offer Services / <a target="" href="{{url('admin/services-ads-list/'.$service->ads_url($service->status))}}">{{@$service->ads_status($service->status)}}</a> / <a target="" href="{{url('admin/service-details/'.@$service->id)}}">{{@$service->primary_service->title}}</a></h3>
  </div>
  <div class="col-lg-6 col-md-5 col-sm-5 search-col text-right">
    <a class="btn btn-primary" href="{{ url()->previous() }}">
      <i class="fa fa-arrow-left"></i> Back
    </a>

  @if($service->status == 0)
    <a class="btn btn-success" id="approve_service" data-id="{{@$service->id}}" href="javascript:void(0)">Approve</a>
    <a class="btn btn-danger" id="not_approve_modal" data-id="{{@$service->id}}" href="javascript:void(0)">Not Approve</a>
    <a class="btn btn-success" id="translate_lang" data-id="{{@$service->id}}" href="javascript:void(0)">Translate</a>
  @endif

  @if($service->status == 1)
    <a class="btn btn-success" id="pending_service" data-id="{{@$service->id}}" href="javascript:void(0)">Pending</a>
  @endif

  @if($service->status == 2)
    <a class="btn btn-success" id="pending_service" data-id="{{@$service->id}}" href="javascript:void(0)">Pending</a>
  @endif

  @if($service->status == 3)
    <a class="btn btn-success" id="pending_service" data-id="{{@$service->id}}" href="javascript:void(0)">Pending</a>
  @endif
</div>
</div>
<div class="container-fluid">
  <div class="row">
  <div class="col-6 col-md-6 dr-personal-prof mb-4 productImgCol">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
            <div class="section-header">
                <h5 class="mb-1 text-capitalize"> Car Image</h5>
            </div>
            <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
              @foreach(@$ads_images as $ad_image)
              @if(@$ad_image->image_name !== null && file_exists( public_path() . '/uploads/ad_pictures/services/'.$service->id.'/'.@$ad_image->image_name))
              <li class="position-relative overflow-hidden rounded car_gallery" data-thumb="{{asset('public/uploads/ad_pictures/services/'.$service->id.'/'.$ad_image->image_name)}}" data-src="{{asset('public/uploads/ad_pictures/services/'.$service->id.'/'.$ad_image->image_name)}}">
              <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
              @if(@$service->is_featured == 'true')
              <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-uppercase text-white d-inline-block">FEATURED</span>
              @endif
              <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
              </span>
              </figcaption>
              @if(@$ad_image->image_name !== null && file_exists( public_path() . '/uploads/ad_pictures/services/'.$service->id.'/'.@$ad_image->image_name))
              <img src="{{asset('public/uploads/ad_pictures/services/'.$service->id.'/'.$ad_image->image_name)}}" class="img-fluid" style="width:100%;height: 370px;">
              @else
              <img src="{{ asset('public/assets/img/serviceavatar.jpg')}}" class="img-fluid" style="width:100%;height: 370px;">
              @endif
            </li>
              @else
              <li class="position-relative overflow-hidden rounded car_gallery" data-thumb="{{ asset('public/assets/img/serviceavatar.jpg')}}" data-src="{{ asset('public/assets/img/serviceavatar.jpg')}}">
              <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
              @if(@$service->is_featured == 'true')
              <span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-uppercase text-white d-inline-block">FEATURED</span>
              @endif
              <span class="d-inline-block ml-3 mb-3 zoomDetailImg" style="background-image:url(assets/img/imgZoom.png)">
              </span>
              </figcaption>
              @if(@$ad_image->img !== null && file_exists( public_path() . '/uploads/ad_pictures/services/'.$service->id.'/'.@$ad_image->image_name))
              <img src="{{asset('public/uploads/ad_pictures/cars/'.$service->id.'/'.$ad_image->img)}}" class="img-fluid" style="width:100%;height: 370px;">
              @else
              <img src="{{ asset('public/assets/img/serviceavatar.jpg')}}" class="img-fluid" style="width:100%;height: 370px;">
              @endif
            </li>
              @endif
              @endforeach
            </ul>
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
            <h6 class="text-capitalize font-weight-bold mb-1">
            Title:</h6>
            <p class="mb-0">{{ @$service->get_service_ad_title(@$service->id,2)->title }}</p>
        </div>
        <div class="col-md-6 col-6 mb-3 dr-detail-col">
        <h6 class="text-capitalize font-weight-bold mb-1">Category:</h6>
        <p class="mb-0">{{ @$service->category(@$service->primary_service_id,2)->title }}</p>
        </div>
        <div class="col-md-6 col-6 mb-3 dr-detail-col">
        <h6 class="text-capitalize font-weight-bold mb-1">Sub Category:</h6>
        <p class="mb-0">{{ @$service->sub_category(@$service->sub_service_id,2)->title }}</p>
        </div>
        <div class="col-md-6 col-6 mb-3 dr-detail-col">
        <h6 class="text-capitalize font-weight-bold mb-1">Details:</h6>
        <p class="mb-0">{{ @$service->detials(@$service->sub_sub_service_id,2)->title }}</p>
        </div>
        
        
        <div class="col-md-6 col-6 mb-3 dr-detail-col">
        <h6 class="text-capitalize font-weight-bold mb-1">Add By:</h6>
        <p class="mb-0">{{ @$service->get_customer !== null ? @$service->get_customer->customer_company : '--' }}</p>
        </div>

        <div class="col-md-6 col-6 mb-3 dr-detail-col">
            <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">Created:</h6>
            <p class="mb-0">{{Carbon::parse(@$service->created_at)->format('d/m/Y')}}</p>
        </div>

        <div class="col-md-6 col-6 mb-3 dr-detail-col">
        <h6 class="text-capitalize font-weight-bold mb-1">Status:</h6>
        <p class="mb-0">{{ @$service->ads_status($ads->status) }}
          @if($service->status == '3')
          <br /><b>Reason</b>
          {!! $service->get_reasons($service->id) !!}
          @endif</p>
        </div>

        </div>
      </div>
    </div> 
  </div>
  </div>
  <form id="ad_languages" method="post" action="{{route('service-detail-form')}}">
  {{ csrf_field() }}
    <input type="hidden" name="service_id" id="service_id" value="{{$service->id}}">
    <div class="row">
      @foreach(@$languages as $language)
      <div class="col-4 col-md-4 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
          <div class="section-header">
              <h5>Service Description ( {{@$language->language_title}} )</h5>    
          </div>
          <div class="form-group green-border-focus">
            <textarea class="form-control" rows="5" id="lang_{{$language->id}}" name="lang_{{$language->id}}">{{ @$service->get_service_description(@$service->id , @$language->id)->description }}</textarea>
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
            <input type="text" class="form-control" rows="5" id="titlelang_{{$language->id}}" name="titlelang_{{$language->id}}" value="{{ @$service->get_service_ad_title($service->id , $language->id)->title }}">
          </div>
          </div> 
      </div>
      @endforeach
      @if(@$ads->status == 0)
      <div class="col-lg-12 col-md-6 col-sm-6 search-col text-right">
      <button class="btn btn-success" id="service_detail" >Save</button>
      </div>
      @endif
    </div>
  </form>
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 search-col p-0 ">
    <div class="purchase-order-detail pt-2 pb-3 pr-3 pl-3 h-100 ">
        <table class="my-tablee dot-dash customborder history_table" width="100%" >
         <thead class="sales-coordinator-thead section-header">
           <tr>
            <th>User</th>
            <th>User Type</th>
            <th>Date/time </th>
            <th>Status </th>
            <th>New Status</th>
           </tr>
         </thead>
         <tbody>
          @if($status_history->count() > 0)
            @foreach($status_history as $history)
            <tr>
              @if($history->usertype == 'customer')
              <td>{{$history->get_user->customer_company}}</td>
              <td>Customer</td>
              @else
              <td>{{ !empty($history->get_staff) ? $history->get_staff->name: ''}}</td>
              <td>Staff</td>
              @endif
              <td>{{Carbon::parse(@$history->created_at)->format('d/m/Y h:m A')}}</td>
              <td>{{$history->status}}</td>
              <td>{{$history->new_status}}</td>
            </tr>
            @endforeach
          @else
          <tr>
            <td colspan="4" style="padding: 5px;text-align: center;">
              {{__('search.no_record_found')}}
            </td>
          </tr>
          @endif
         </tbody>
        </table>
      </div>
  </div>
    <div class="col-lg-8 col-md-8 col-sm-8 search-col p-0 h-100">
    <div class="purchase-order-detail pt-2 pb-3 pr-3 pl-3 h-100 ">
        <table class="my-tablee dot-dash customborder" width="100%" >
         <thead class="sales-coordinator-thead section-header">
           <tr>
            <th>User</th>
            <th>User Type</th>
            <th>Date/time </th>
            <th>Column</th>
            <th>Old Value </th>
            <th>New Value</th>
           </tr>
         </thead>
         <tbody>
          @if($ad_history->count() == 0)
          <tr>
            <td colspan="5" class="text-center">No Data Found</td>
          </tr>
          @else
            @foreach($ad_history as $history)
            <tr>
              @if($history->usertype == 'customer')
              <td>{{$history->get_user->customer_company}}</td>
              <td>Customer</td>
              @else
              <td>{{ !empty($history->get_staff) ? $history->get_staff->name: ''}}</td>
              <td>Staff</td>
              @endif
              <td>{{Carbon::parse(@$history->created_at)->format('d/m/Y H:m A')}}</td>
              <td>{{$history->column_name}}</td>
              <td>{{$history->status}}</td>
              <td>{{$history->new_status}}</td>
            </tr>
            @endforeach
            @endif
         </tbody>
        </table>
      </div>
  </div> 
</div>
</div>
</div>
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
<div class="modal fade" id="serviceMessageModal" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!-- <h4 class="modal-title">Modal Header</h4> -->
        </div>
        <div class="modal-body">
          <form action="{{route('admin-not-approve-service')}}" id="not_approve_service_form" class="editSuggestion" method="post">
        @csrf
      <div class="modal-body">
        <input type="hidden" name="msg_service_id" id="msg_service_id" value="{{@$service->id}}">
        <div class="form-group">
          <p><span style="color: red;font-style: italic;">Note: </span><span style="font-style: italic;font-weight: 300;">Hold down the Ctrl (windows) or Command (Mac) button to select multiple options.</span></p>
            <hr>
            <label>Reasons</label>
            <select name="reason[]" class="form-control selectpicker" multiple data-live-search="true">
              <option>---Select Reason---</option>
              @foreach($reasons as $reason)
                <option value="{{@$reason->id}}">{{$reason->reason_description()->where('language_id',2)->pluck('title')->first()}}</option>
              @endforeach
            </select>

        </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" id="not_approve_service" class="btn btn-primary" >Submit</button>
      </div>
      </form>
        </div>
      </div>
      
    </div>
</div>
<style type="text/css">
  .green-border-focus .form-control:focus {
    border: 1px solid #8bc34a;
    box-shadow: 0 0 0 0.2rem rgba(139, 195, 74, .25);
}
</style>
<!-- container end -->
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click', '#approve_service' , function(){
      // e.preventDefault();
      id = $(this).data('id');
      /*******************/
      swal({
          title: "Alert!",
          text: "Are you sure you want to Approve this Service?",
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
            $('#loader_modal').modal('show');
             /*******************************/

            
                $.ajax({
                    url:"{{ route('admin-approve-service')}}",
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        if(data.success == true){
                          window.location = data.url;
                        }

                        if(data.des == false){
                           $('#loader_modal').modal('hide');
                           toastr.error('Error!', 'All Descriptions Must Be Filled', {
                          "positionClass": "toast-bottom-right"
                          });
                          
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

      $(document).on('click', '#translate_lang' , function(){
      // e.preventDefault();
      id = $(this).data('id');
      /*******************/
      swal({
          title: "Alert!",
          text: "Are you sure you want to Translate this Service?",
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
                    url:"{{ route('admin-translate-service')}}",
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        if(data.success == true){
                          $('#loader_modal').modal('hide');
                           toastr.success('Success!', 'All Descriptions Translate Successfully', {
                          "positionClass": "toast-bottom-right"
                          });

                          window.location = data.url;
                        }

                     /*   if(data.des == false){
                           $('#loader_modal').modal('hide');
                           toastr.error('Error!', 'All Descriptions Must Be Filled', {
                          "positionClass": "toast-bottom-right"
                          });
                          
                        }*/
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


    $('#service_detail').click(function(){
      // e.preventDefault();
      $("#ad_languages").submit();
    });

    $(document).on('click', '#not_approve_modal' , function(){
      $('#serviceMessageModal').modal('show');
    });

    $(document).on('click', '#not_approve_service' , function(){
      // e.preventDefault();
      id = $(this).data('id');
      /*******************/
      swal({
          title: "Alert!",
          text: "Are you sure you want to not Approve this Service?",
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
            $('#not_approve_service_form').submit();
          } 
          else{
            $('#serviceMessageModal').modal('hide');
              swal("Cancelled", "", "error");
          }
       
    });
      /*******************/

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