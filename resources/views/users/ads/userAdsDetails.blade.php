@extends('layouts.app')

@section('content')
<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
  <div class="container">
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
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">{{__('ads.displaying')}} 1 {{__('ads.ad_listing')}}</h6>
                  </div>
                  <div class="display-ad-status">
                    <select name="ads_selector" class="form-control ads_selector form-control-sm">
                      <option value="1">{{__('ads.active')}} ()</option>
                      <option value="0">{{__('ads.Pending')}} (}})</option>
                      <option value="2">{{__('ads.removed')}} ({{}})</option>
                    </select>
                  </div>
                </div>
                <div class="bg-white border">
                  <div class="ads-listing-rows filtered_ads">
                    
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
   $('.ads_selector').change(function(){
    var val = $(this).val();
    $.ajax({
        url:"{{route('filter-ads')}}",
        method:"get",
        dataType:"json",
        data:{ads_status:val},
        success:function(data){
          $('.filtered_ads').html(data.html);
        },
        error:function(){
            alert('Error');
        }

    });
   });
   $(document).on('click','.remove-ad',function(e){
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

                          url:"{{route('remove-ad')}}",
                          method:"get",
                          dataType:"json",
                          data:{ad_id:ad_id},
                          success:function(data){
                            if(data.error == false){
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