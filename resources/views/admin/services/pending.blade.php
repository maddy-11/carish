@extends('admin.layouts.app')

@section('content')
<!-- <div class="row">
    <h2 class="text-info">Pending Services</h2>
</div> -->
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Offer Services / <a target="" href="{{url('admin/pending-services')}}">Pending </a></h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right">Add Suggestion</button> -->
  </div>

</div>



<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Pending Offer Services</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <!-- <th>Action</th> -->
                <th>Title</th>
                <th>Category</th>
                <th>Sub Category</th>
                <th>Detail</th>
                <th>Customer</th>
                <th>Created at</th>
              </tr>
          </thead>
          <tbody>
            
            @foreach($pending_services as $service)
                <tr>
                     <!-- <td>
                        <a  class="fa fa-eye" href="{{url('admin/pending-service-details/'.$service->id)}}" ><i title="View Add"></i></a>
                    </td> -->
                    <td><a href="{{url('admin/service-details/'.$service->id)}}" ><b>{{@$service->get_service_ad_title($service->id , 2)->title}}</b></a></td>
                    <td>{{@$service->primary_service->get_category_title()->where('language_id',2)->pluck('title')->first()}}</td>
                    <td>{{@$service->sub_service->get_category_title()->where('language_id',2)->pluck('title')->first()}}</td>
                    <td>{{@$service->sub_sub_service->get_category_title()->where('language_id',2)->pluck('title')->first()}}</td>
                    <td>{{@$service->get_customer->customer_company}}</td>
                    <td> {{$service->created_at}} </td>
                   
                </tr>
            @endforeach
            
            </td>
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div>


    <!-- <div style="overflow-x: auto; width: 100%;">
        <table id="Services"  class="table table-responsive">
            <thead>
            <tr>
                <th>Email</th>
                <th>Phone</th>
                <th>Website</th>
                <th>Address</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($pending_services as $service)
                <tr>
                    <td>{{$service->email_for_service}}</td>
                    <td>{{$service->phone_of_service}}</td>
                    <td>{{$service->service_website}}</td>
                    <td>{{$service->address_of_service}}</td>
                    @if($service->status == 0)
                    <td><label class="label label-warning">Pending</label></td>
                    @elseif($service->status == 1)
                    <td><label class="label label-info">Approved</label></td>
                    @elseif($service->status == 2)
                    <td><label class="label label-success">Published</label></td>
                    @endif
                    <td>
                        @if($service->status == 0)
                            <a class="btn btn-primary approve-service" data-id="{{$service->id}}" title="Approve" ><i class="fa fa-check-square"></i></a>
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($service->status == 1)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($service->status == 2)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @endif

                    </td>
                  
                </tr>
            @endforeach
            </tbody>
        </table>
    </div> -->

    @push('custom-scripts')
    <script>
        $('#Services').DataTable({
    "order": []
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