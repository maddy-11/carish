@extends('admin.layouts.app')
@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
   <div class="col-lg-8 col-md-7 col-sm-7  title-col" >
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Car Ads / <a target="" href="{{url('admin/active-ads')}}">Active</a></h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right action-btns" >
  </div>
</div>
<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Active Ads</h5>
      </div>
      <div class="table-responsive">
        <table id="active-ads" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <!-- <th>Action</th> -->
                <th>Title</th>
                <th>Detail</th>
                <th>Bought From</th>
                <th>Color</th>
                <th>Price</th>
                <th>Customer</th>
                <th>Featured</th>                
              </tr>
          </thead>
          <tbody>
            @foreach($ads as $ad)
              <input type="hidden" name="ad_id[]" value="{{$ad->id}}" id="ad_id">
                <tr>
                    <!--<td>
                      <a  class="fa fa-eye" href="{{url('admin/active-ad-details/'.$ad->id)}}" ><i title="View Add"></i></a>
                      <a class="fa fa-trash text-danger"><i title="Delete Add"></i></a>
                    </td>-->
                    <td> <a href="{{url('admin/ad-details/'.$ad->id)}}" ><b>{{@$ad->maker->title}} {{@$ad->model->name}} {{@$ad->year}}</b></a></td>
                    <td style="white-space: nowrap;">CC {{@$ad->versions->cc}} \ KW {{@$ad->versions->kilowatt}} \{{@$ad->versions->extra_details}}</td>
                    <td>{{@$ad->country->name}}</td>
                    <td>{{@$ad->color->color_description !== null ? @$ad->color->color_description->where('language_id',2)->pluck('name')->first() : '--'}}</td>
                    <td>{{$ad->price}}</td>
                    <td>
                      {{ @$ad->customer->customer_company }}
                    </td>
                    @if($ad->is_featured == 'true')
                    <td><label class="label label-info">Featured</label></td>
                    @elseif($ad->is_featured == 'false')
                    <td><label class="label label-warning">Un Featured</label></td>
                    @endif 
                </tr>
            @endforeach
          </tbody>
      </table>
    </div>
   </div>
  </div>
</div>
  @push('custom-scripts')
  <script type="text/javascript">
    $('#active-ads').DataTable({
      ordering: false,
    });
    $('.checkbox').on('change',function(){
      $('.action-btns').css('display','block');
  });
    $('#featured').on('click',function(){
    var ad_id = $(".checkbox:checked").map(function(){
      return $(this).val();
    }).get();
    //alert(id);
   // var ad_id = $('#ad_id').val();
     swal({
          title: "Alert!",
          text: "Are you sure you want to make this Ad Featured?",
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
                type: "get",
                dataType: "json",
                url: "{{url('admin/make-ad-featured')}}/"+ad_id,
                
                success: function(data){

                    if(data.success==true)
                    {
                        $('#success_featured').css('display','block');
                    }
                    setTimeout(function(){ location.reload(); }, 1000);
                },
                    });

        }
        else{
              swal("Cancelled", "", "error");
          }

   });  
  });
    $('#unFeatured').on('click',function(){
    var ad_id = $(".checkbox:checked").map(function(){
      return $(this).val();
    }).get();
    //alert(id);
   // var ad_id = $('#ad_id').val();
     swal({
          title: "Alert!",
          text: "Are you sure you want to make this Ad UnFeatured?",
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
                type: "get",
                dataType: "json",
                url: "{{url('admin/make-ad-unFeatured')}}/"+ad_id,
                
                success: function(data){

                    if(data.success==true)
                    {
                        $('#success_un_featured').css('display','block');
                    }
                    setTimeout(function(){ location.reload(); }, 1000);    
                },
                    });
        }
        else{
              swal("Cancelled", "", "error");
          }
   });
  });
    $('#pending').on('click',function(){
    var ad_id = $(".checkbox:checked").map(function(){
      return $(this).val();
    }).get();
    //alert(id);
   // var ad_id = $('#ad_id').val();
     swal({
          title: "Alert!",
          text: "Are you sure you want to make this Ad pending?",
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
                type: "get",
                dataType: "json",
                url: "{{url('admin/make-ad-pending')}}/"+ad_id,
                
                success: function(data){

                    if(data.success==true)
                    {
                        $('#success').css('display','block');
                    }
                    setTimeout(function(){ location.reload(); }, 1000);
                },
                    });
        }
        else{
              swal("Cancelled", "", "error");
          }
   });
  });
    $('#remove').on('click',function(){
    var ad_id = $(".checkbox:checked").map(function(){
      return $(this).val();
    }).get();
     swal({
          title: "Alert!",
          text: "Are you sure you want to make this Ad removed?",
          type: "warning",
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
        type: "get",
        dataType: "json",
        url: "{{url('admin/make-ad-remove')}}/"+ad_id,
        success: function(data){
             if(data.success==true)
                    {
                        $('#success_w').css('display','block');
                    }
                    setTimeout(function(){ location.reload(); }, 1000);
        },
            });
     }
        else{
              swal("Cancelled", "", "error");
          }
   });
  });
    $('#soldout').on('click',function(){
    var ad_id = $(".checkbox:checked").map(function(){
      return $(this).val();
    }).get();
     swal({
          title: "Alert!",
          text: "Are you sure you want to make this Ad SoldOout?",
          type: "success",
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
        type: "get",
        dataType: "json",
        url: "{{url('admin/make-ad-soldout')}}/"+ad_id,
        success: function(data){
         if(data.success==true)
                    {
                        $('#success_s').css('display','block');
                    }
                    setTimeout(function(){ location.reload(); }, 1000);
        },
            });
     }
        else{
              swal("Cancelled", "", "error");
          }
   });
  }); 
    $('#rejected').on('click',function(){
    var ad_id = $(".checkbox:checked").map(function(){
      return $(this).val();
    }).get();
         swal({
          title: "Alert!",
          text: "Are you sure you want to make this Ad rejected?",
          type: "warning",
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
            type: "get",
            dataType: "json",
            url: "{{url('admin/make-ad-rejected')}}/"+ad_id,
            success: function(data){
                 if(data.success==true)
                    {
                        $('#success_d').css('display','block');
                    }
                    setTimeout(function(){ location.reload(); }, 1000);
            },
                });
         }
        else{
              swal("Cancelled", "", "error");
          }
   });
});  
  </script>
  @endpush
@endsection