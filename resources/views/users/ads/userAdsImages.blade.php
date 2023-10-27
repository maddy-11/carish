@extends('layouts.app')
@section('content')
<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
  <div class="container">
    @if(count($errors) > 0)
    <div class="alert alert-danger">
     Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif
   @if(session()->has('error'))
     <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif

   @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
    <div class="row ml-0 mr-0">
          @include('users.ads.adsTabes')
      </div>

      <div class="tab-content profile-tab-content">
        <!-- Tab 1 starts here -->
        <div class="tab-pane active" id="profile-tab1">
            <div class="row ad-tab-row">
              <div class="ad-tab-sidebar col-lg-3 col-md-4">@include('users.ads.side_bar')</div>
              <div class="col-lg-9 col-md-8 mt-md-0 mt-4 pl-md-0 pl-lg-3 ad-tab-desc">
               <div class="tab-content">
               <div class="tab-pane active" id="ad-tab1"> 
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2">
                 
                </div>
                <div class="bg-white border">
    <div class="ads-listing-rows filtered_ads">
              <form action="{{route('images.update')}}" method="POST" name="images" enctype="multipart/form-data" >
              <input type="hidden" name="ad_id" value="{{$adsDetails->id}}">
              {{csrf_field()}}
                    <!-- Upload Photos section starts here -->
                <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2">
                  <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">{{__('ads.upload')}} {{__('ads.photos')}}</h4>
                  <div class="upload-photos">
                    <div class="row form-group mb-sm-4">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right pt-sm-2">
                          <label class="mb-0 text-capitalize">{{__('ads.photos')}}<sup class="text-danger">*</sup></label>
                      </div>
                      <div class="col-lg-4 col-md-6 col-sm-7">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="file[]" id="customFile" multiple value="SELECT FILES" data-parsley-error-message="Please select Photo" data-parsley-required="true" data-parsley-trigger="change">
                        <label class="custom-file-label" for="customFile">{{__('ads.choose')}} {{__('ads.photos')}}</label>
                      </div>
                      <div class="upload-note mt-3">
                        {{__('ads.photo_extentions')}}
                        <br>
                        {{__('ads.can_select_multiple')}}
                      </div>
                      </div>
                    </div>
                  </div>
                </div>  
          <!-- AUpload Photos section Ends here --> 
        <div class="border-top mx-n4 pt-4 pt-sm-5 px-4 mt-sm-5 mt-4 text-center">
              <input type="submit" class="btn pb-3 pl-4 post-ad-submit pr-4 pt-3  themebtn1" value="{{__('ads.submit_and_continue')}}">
            </div>
  </form>
 
              <div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
              <div class="row"> 
               @if($adImages)
               @foreach($adImages as $img)
                <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar">
                  <figure class="mb-0 position-relative">
                    <img src="{{url('public/uploads/ad_pictures/cars/'.$img->ad_id.'/'.$img->img)}}" class="img-fluid" alt="carish used cars for sale in estonia">
                    <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                    <span data-id="{{$img->id}}" class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block mt-2">REMOVE</span>
                    </figcaption>
                  </figure>
                </div>
                @endforeach
                @endif
              </div>
            </div>
                    
                   </div>
                </div>
              </div>
               </div> 
           </div>
         </div>
        </div>
        <!-- Tab 1 ends here -->        
      </div>
    </div>

@push('scripts')
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','.featuredlabel',function(e){
    e.preventDefault();
    var ad_id = $(this).data('id');
    swal({
           title: "{{__('ads.you_sure')}}",
          text: "{{__('ads.you_sure_toremove')}}",
          type: "error",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "{{__('ads.yes_do')}}",
          cancelButtonText: "{{__('ads.cancel')}}",
          closeOnConfirm: true,
          closeOnCancel: true
          },
          function (isConfirm) {
              if (isConfirm) {
                 $.ajax({
                    url:"{{route('images.remove')}}",
                        method:"get",
                        dataType:"json",
                        data:{img_id:ad_id},
                        success:function(data){ 
                            if(data.success == true){
                              toastr.success('Success!', "{{__('ads.removed_success')}}",{"positionClass": "toast-botom-right"});
                              location.reload();
                            }
                          },
                          error:function(){
                              alert("{{__('ads.error')}}");
                          }
                          });
              }
              else {
                  swal("{{__('ads.cancelled')}}", "", "{{__('ads.error')}}");
                  
              }
          });
   })
  });
</script>
@endpush
@endsection