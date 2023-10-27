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
  @if(@$ads->status == 0)
  <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Spare Part Ads / <a target="" href="{{url('admin/pending-part-ads')}}">Pending</a> / <a target="" href="{{url('admin/sp-part-ad-detail/'.@$ads->id)}}">{{@$ads->get_sp_ad_title($ads->id , 2)}}</a></h3>
</div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    <a class="btn btn-primary" href="{{ url()->previous() }}">
      <i class="fa fa-arrow-left"></i> Back
    </a>
    <a class="btn btn-success" id="approve_ad" data-id="{{@$ads->id}}" href="javascript:void(0)">Approve</a>
    <a class="btn btn-danger" id="not_approve_modal" data-id="{{@$ads->id}}" href="javascript:void(0)">Not Approve</a>
    <a class="btn btn-success" id="translate_lang" data-id="{{@$service->id}}" href="javascript:void(0)">Translate</a>
 
</div>
  @endif
  @if(@$ads->status == 1)
  <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Spare Part Ads / <a target="" href="{{url('admin/active-part-ads')}}">Active</a> / <a target="" href="{{url('admin/sp-part-ad-detail/'.@$ads->id)}}">{{@$ads->title}}</a></h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <a class="btn btn-primary" href="{{ url()->previous() }}">
        <i class="fa fa-arrow-left"></i> Back
      </a>
      <a class="btn btn-warning" id="pending_ad" data-id="{{@$ads->id}}" href="javascript:void(0)">Move To Pending</a>
  </div>
  @endif
  @if(@$ads->status == 2)
  <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Spare Part Ads / <a target="" href="{{url('admin/removed-part-ads')}}">Removed</a> / <a target="" href="{{url('admin/sp-part-ad-detail/'.@$ads->id)}}">{{@$ads->title}}</a></h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    <a class="btn btn-primary" href="{{ url()->previous() }}">
      <i class="fa fa-arrow-left"></i> Back
    </a>
    <a class="btn btn-warning" id="pending_ad" data-id="{{@$ads->id}}" href="javascript:void(0)">Pending</a>
     
  </div>
  @endif

  @if(@$ads->status == 3)
    <div class="col-lg-8 col-md-7 col-sm-7  title-col">
     <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Spare Part Ads / <a target="" href="{{url('admin/not-approved-sp-ads')}}">Not Approved</a> / <a target="" href="{{url('admin/sp-part-ad-detail/'.@$ads->id)}}">{{@$ads->title}}</a></h3>
    
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    
    <a class="btn btn-primary" id="pending_ad" data-id="{{@$ads->id}}" href="javascript:void(0)">Pending</a>
     
  </div>
  @endif
  <!-- <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    <a type="submit" class="btn btn-primary" href='javascript:void(0)'>Edit Profile</a>
  </div> -->
  @if(@$ads->status == 5)


  <div class="col-lg-8 col-md-7 col-sm-7  title-col">

    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Spare Part Ads / <a target="" href="{{url('admin/unpaid-spareparts')}}">Unpaid</a> / <a target="" href="{{url('admin/sp-part-ad-detail/'.@$ads->id)}}">{{@$ads->get_sp_ad_title($ads->id , 2)}}</a></h3>

    
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    <a class="btn btn-primary" href="{{ url()->previous() }}">
      <i class="fa fa-arrow-left"></i> Back
    </a>
   {{--  <a class="btn btn-success" id="add_to_pending" data-id="{{@$ads->id}}" href="javascript:void(0)">Add To Pending</a>
    <a class="btn btn-danger" id="not_approve_modal" data-id="{{@$ads->id}}" href="javascript:void(0)">Not Approve</a> --}}

    <!-- <a class="btn btn-success" id="approve_ad" href="{{url('admin/approve-ad/'.$ads->id)}}">Approve</a> -->
  </div>
  <!-- <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    <a type="submit" class="btn btn-primary" href='javascript:void(0)'>Edit Profile</a>
  </div> -->
@endif

</div>


<div class="container-fluid">
<div class="row">
  <div class="col-6 col-md-5 dr-personal-prof mb-4">
    <div class="bg-white custompadding customborder h-100 d-flex flex-column">
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
            <input type="text" class="form-control" rows="5" id="title_lang_{{$language->id}}" name="title_lang_{{$language->id}}" value="{{ @$ads->get_sp_ad_title($ads->id , $language->id)->title }}">
          </div>
          </div> 
      </div>
    @endforeach
    
</div>
</form>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 search-col p-0 ">
    <div class="purchase-order-detail pt-2 pb-3 pr-3 pl-3 h-100 ">
        <table class="my-tablee dot-dash customborder history_table" width="100%" >
         <thead class="sales-coordinator-thead section-header">
           <tr>
            <th>User  </th>
            <th>Date/time </th>
            <th>Status </th>
            <th>New Status</th>
           </tr>
         </thead>
         <tbody>
          @if($status_history->count() > 0)
            @foreach($status_history as $history)
            <tr>
              <td>{{$history->get_user->customer_company}}</td>
              <td>{{Carbon::parse(@$history->created_at)->format('d/m/Y H:i:s')}}</td>
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
  <div class="col-lg-6 col-md-6 col-sm-6 search-col p-0 h-100">
    <div class="purchase-order-detail pt-2 pb-3 pr-3 pl-3 h-100 ">
        <table class="my-tablee dot-dash customborder" width="100%" >
         <thead class="sales-coordinator-thead section-header">
           <tr>
            <th>User  </th>
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
              <td>{{$history->username}}</td>
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
  <div class="col-lg-6 col-md-6 col-sm-6 search-col text-right">
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 search-col text-right">
    
    <button class="btn btn-success" id="sp_ads_detail" >{{__('search.save')}}</button>
</div>
</div>
{{-- <div class="col-lg-12 col-md-12 col-sm-12 search-col text-right">
    
    <button class="btn btn-success" id="sp_ads_detail" >{{__('search.save')}}</button>
</div> --}}


</div>

<div class="modal fade" id="spAdMessageModal" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!-- <h4 class="modal-title">Modal Header</h4> -->
        </div>
        <div class="modal-body">
          <form action="{{route('admin-not-approve-sp-ad')}}" id="not_approve_sp_ad_form" class="editSuggestion" method="post">
        @csrf
      <div class="modal-body">
        <input type="hidden" name="msg_sp_ad_id" id="msg_sp_ad_id" value="{{@$ads->id}}">
        <div class="form-group">
            <!-- <label for="name">Subject</label>
             <input required type="text" name="subject" id="subject" class="form-control" >

            <label for="name">Content</label>
            <input required type="text-area" name="content" id="content" class="form-control" > -->

            <label>Reason</label>
            <select name="reason" class="form-control">
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
                    }
                }); 
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