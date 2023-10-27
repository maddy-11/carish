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
  .history_table tr td
  {
    border: 1px solid #aaa;
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
<?php  Use Carbon\Carbon; ?>
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
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Spare Part Ads / <a target="" href="{{url('admin/parts-ads-list/'.$ads->ads_url($ads->status))}}">{{@$ads->ads_status($ads->status)}}</a> / <a target="" href="{{url('admin/pending-part-ad-detail/'.@$ads->id)}}">{{@$ads->get_sp_ad_title($ads->id , 2)}}</a></h3>
  </div>
  <div class="col-lg-6 col-md-5 col-sm-5 search-col text-right">
    <a class="btn btn-primary" href="{{ url()->previous() }}">
      <i class="fa fa-arrow-left"></i> Back
    </a>

    <!-- <a class="btn btn-danger" id="delete-btn" data-id="{{$ads->id}}" href='javascript:void(0)'  >
      <i class="fa fa-close"></i>Delete</a> -->

  @if(@$ads->status == 0)
    <a class="btn btn-success" id="approve_ad" data-id="{{@$ads->id}}" href="javascript:void(0)">Approve</a>
    <a class="btn btn-danger" id="not_approve_modal" data-id="{{@$ads->id}}" href="javascript:void(0)">Not Approve</a>
    <a class="btn btn-success" id="translate_lang" data-id="{{@$ads->id}}" href="javascript:void(0)">Translate</a>
  @endif
  @if(@$ads->status == 1)
      <a class="btn btn-warning" id="pending_ad" data-id="{{@$ads->id}}" href="javascript:void(0)">Move To Pending</a>   
  @endif

  @if(@$ads->status == 2)
    <a class="btn btn-warning" id="pending_ad" data-id="{{@$ads->id}}" href="javascript:void(0)">Pending</a>    
  @endif

  @if(@$ads->status == 3)
    <a class="btn btn-primary" id="pending_ad" data-id="{{@$ads->id}}" href="javascript:void(0)">Pending</a>
  @endif
  @if(@$ads->status == 5)
  <a class="btn btn-success"  href="{{url('admin/invoice-view/'.$ads->get_invoice($ads->id))}}">Invoice</a>
  @endif
</div>
</div>


<div class="container-fluid">
<div class="row">
    <div class="col-6 col-md-5 dr-personal-prof mb-4">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
            <!-- <div class="section-header">
                <h5 class="mb-1 text-capitalize"> SparePart Ad Details</h5>
            </div> -->

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
                            <p class="mb-0">{{ @$ads->get_sp_ad_title(@$ads->id,2) }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Product Code:</h6>
                            <p class="mb-0">{{ @$ads->product_code }}</p>
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
                            <h6 class="text-capitalize font-weight-bold mb-1">Condition:</h6>
                            <p class="mb-0">{{ @$ads->condition }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Price (€):</h6>
                            <p class="mb-0">{{ @$ads->price }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Incl 20% VAT:</h6>
                            <p class="mb-0">{{ @$ads->vat == '1' ? 'Yes': 'No' }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Negotiable:</h6>
                            <p class="mb-0">{{ @$ads->neg == '1' ? 'Yes': 'No' }}</p>
                        </div>
                        
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Add By:</h6>
                            <p class="mb-0">{{ @$ads->get_customer !== null ? @$ads->get_customer->customer_company : '--' }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Poster Phone:</h6>
                            <p class="mb-0">{{ @$ads->poster_phone }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">City:</h6>
                            <p class="mb-0">{{ @$ads->city->name }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">Created:</h6>
                            <p class="mb-0">{{Carbon::parse(@$ads->created_at)->format('d/m/Y')}}</p>
                        </div>
                         <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">Status:</h6>
                            <p class="mb-0">
                              {{ @$ads->ads_status($ads->status) }}

                              @if($ads->status == '3')
                              <br /><b>Reason</b>
                              {!! $ads->get_reasons($ads->id) !!}
                              @endif
                              
                            </p>
                        </div>
                         <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">IsFeature:</h6>
                            <p class="mb-0">{{ @$ads->is_featured }}</p>
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
          <div class="form-group green-border-focus">
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
            <input type="text" class="form-control" rows="5" id="titlelang_{{$language->id}}" name="titlelang_{{$language->id}}" value="{{ @$ads->get_sp_ad_title($ads->id , $language->id) }}">
          </div>
          </div> 
      </div>
    @endforeach
    @if(@$ads->status == 0)
    <div class="col-lg-12 col-md-6 col-sm-6 search-col text-right">
      <button class="btn btn-success" id="sp_ads_detail" >Save</button>
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
            <th>Status </th>
            <th>New Status</th>
            <th>Date</th>
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
              <td>{{@$history->get_staff->name}}</td>
              <td>Staff</td>
              @endif
              <td>{{$history->status}}</td>
              <td>{{$history->new_status}}</td>
              <td>{{Carbon::parse(@$history->created_at)->format('d/m/Y h:i:s A')}}</td>
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
            <td colspan="5" class="text-center">No Changes Found</td>
          </tr>
          @else
            @foreach($ad_history as $history)
            <tr>
              @if($history->usertype == 'customer')
              <td>{{@$history->get_user->customer_company}}</td>
              <td>Customer</td>
              @else
              <td>{{@$history->get_staff->name}}</td>
              <td>Staff</td>
              @endif
              <td>{{Carbon::parse(@$history->created_at)->format('d/m/Y H:i:s')}}</td>
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
<div class="modal fade" id="spAdMessageModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="{{route('admin-not-approve-sp-ad')}}" id="not_approve_sp_ad_form" class="editSuggestion" method="post">
        @csrf
      <div class="modal-body">
        <input type="hidden" name="msg_sp_ad_id" id="msg_sp_ad_id" value="{{@$ads->id}}">
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
        <button type="button" id="not_approve_sp_ad" class="btn btn-primary" style="background-color: #017baa !important;border-color: #017baa !important">Submit</button>
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
    $(document).on('click', '#approve_ad' , function(){
    // e.preventDefault();
    id = $(this).data('id');
    /*******************/
    swal({
    title: "Alert!",
    text: "Are you sure you want to Approve this Spare Part Ad?",
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
    url:"{{ route('admin-approve-sp-ad')}}",
    method:"get",
    data:{id:id},
    success:function(data)
    {
    if(data.success == true){
    toastr.success('Success!', 'Sparepart Successfully Active !!!', {
    "positionClass": "toast-bottom-right"});
    window.location = data.url;
    }
    else { 
    toastr.warning('', 'The required amount has not paid for this Spare Part!', {
    "positionClass": "toast-bottom-right"
    });}
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
    text: "Are you sure you want to Translate this Spare Part Ad?",
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
    url:"{{ route('admin-translate-spareparts')}}",
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
    $('#sp_ads_detail').click(function(){
    // e.preventDefault();
    $("#sp_ad_languages").submit();
});
    $(document).on('click', '#not_approve_modal' , function(){
    $('#spAdMessageModal').modal('show');
});
    $(document).on('click', '#not_approve_sp_ad' , function(){
    // e.preventDefault();
    id = $(this).data('id');
    /*******************/
    swal({
    title: "Alert!",
    text: "Are you sure you want to not Approve this SparePart Ad?",
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
    $('#not_approve_sp_ad_form').submit();
    } 
    else{
    $('#spAdMessageModal').modal('hide');
    swal("Cancelled", "", "error");
    }

    });
    /*******************/

});
    $(document).on('click', '#add_to_pending' , function(){
    // e.preventDefault();
    id = $(this).data('id');
    /*******************/
    swal({
    title: "Alert!",
    text: "Are you sure you want to add this sparepart to pending?",
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
    url:"{{ route('admin-add-to-pending-sparepart')}}",
    method:"get",
    data:{id:id},
    success:function(data)
    {
    if(data.success == true){
    toastr.success('Success!', 'Sparepart Successfully Add To Pending !!!', {
    "positionClass": "toast-bottom-right"});
    window.location = data.url;
    }

    // if(data.des == false){
    //    $('#loader_modal').modal('hide');
    //    toastr.error('Error!', 'All Descriptions Must Be Filled', {
    //   "positionClass": "toast-bottom-right"
    //   });

    // }
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
    $(document).on('click', '#delete-btn' , function(){
        
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Delete this Spare Part?",
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
             $.ajax({
                method:"get",
                dataType:"json",
                data:{id:id},
                url:"{{ url('admin/delete-removedPartAd-model') }}",
                
                success:function(data){
                    if(data.success == true){
                      toastr.success('Success!', data.message ,{"positionClass": "toast-bottom-right"});
                    }
                }
             });
          } 
          else{
              swal("Cancelled", "", "error");
          }
       
    });
   });

  });
</script>
@endsection