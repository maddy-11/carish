@extends('admin.layouts.app')
<?php use Carbon\Carbon; ?>
@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Offer Services / <a target="" href="{{url('admin/pending-services')}}">{{$page_title}} </a></h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right"></div>
</div>
<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">{{$page_title}} Offer Services</h5>
      </div>
      <div class="table-responsive">
        <table id="servies-ads" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <!-- <th>Action</th> -->
                <th>Title</th>
                <th>Updated Date</th>
                <th>Created at</th>
                <th>Category</th>
                <th>Sub Category</th>
                <th>Detail</th>
                <th>Customer</th>
                
              </tr>
          </thead>
          <tbody>            
            @foreach($ads as $ad)
                <tr>
                     <!-- <td>
                        <a  class="fa fa-eye" href="{{url('admin/pending-service-details/'.$ad->id)}}" ><i title="View Add"></i></a>
                    </td> -->
                    <td><a href="{{url('admin/service-details/'.$ad->id)}}" target="_blank" ><b>{{@$ad->get_service_ad_title($ad->id , 2)->title}}</b></a></td>
                    <td>{{ Carbon::parse(@$ad->updated_at)->format('d/m/Y') }}</td>
                    <td>{{ Carbon::parse(@$ad->created_at)->format('d/m/Y') }}</td>
                    <td>{{@$ad->category($ad->primary_service_id,2)->title}}</td>
                    <td>{{@$ad->sub_category($ad->sub_service_id,2)->title}}</td>
                    <td>{{@$ad->detials($ad->sub_sub_service_id,2)->title}}</td>
                    <td>{{@$ad->get_customer->customer_company}}</td>                   
                </tr>
            @endforeach            
            </td>
          </tbody>
      </table>
    </div>
   </div>
  </div>
</div>
@push('custom-scripts')
<script>
    $('#servies-ads').DataTable({
        ordering: true,
        lengthMenu: [25, 50, 100, 200],
    });
</script>
<script type="text/javascript">     
    $(document).on("click",".approve-service",function(){
        var service_id = $(this).data('id');
        //alert(ad_id);         
        swal({
        title: "Are you sure?",
        text: "You want to approve this Ad ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Approve it!",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                method:"get",
                data:{service_id:service_id},
                url:"{{url('admin/approve-services')}}",
                success: function(response){
                if(response.success === true){
                swal("Approved", "", "success");
                setTimeout(function(){ window.location.reload(); }, 3000);
                }
                }
                });
            }
            else {
            swal("Cancelled", "", "error");
            }
        });
    });
</script>
@endpush
@endsection