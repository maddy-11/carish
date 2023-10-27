@extends('admin.layouts.app')

@section('content')
<!-- <div class="row">
    <h2 class="text-info">Pending SpareParts</h2>
</div>
 -->
 <div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Spare Part Ads / <a target="" href="{{url('admin/not-approved-sp-ads')}}">Not Approved </a></h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right">Add Suggestion</button> -->
  </div>

</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Not Approved SparePart Ads</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <!-- <th>Action</th> -->
                <th>Title</th>
                <th>Product Code</th>
                <th>Category</th>
                <th>Sub Category</th>
                <th>Price</th>
                <th>Customer</th>
                <th>City</th>
                
              </tr>
          </thead>
          <tbody>
            
            @foreach($ads as $ad)
                <tr>
                     <!-- <td>
                        @if($ad->status == 0)
                            <a class="btn btn-primary approve-ad" data-id="{{$ad->id}}" title="Approve" ><i class="fa fa-check-square"></i></a>
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 1)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 2)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @endif

                        <a  class="fa fa-eye" href="{{url('admin/not-approved-part-ad-detail/'.$ad->id)}}" ><i title="View Add"></i></a>

                    </td> -->
                    <td><a href="{{url('admin/pending-part-ad-detail/'.$ad->id)}}" ><b>{{$ad->title}}</b></a></td>

                    <td>{{$ad->product_code}}</td>
                    <td>{{\App\SparePartCategory::find($ad->parent_id)->title}}</td>
                    <td>{{\App\SparePartCategory::find($ad->category_id)->title}}</td>
                    <td>{{$ad->price}}</td>
                    @if(@$ad->customer->customer_role != 'business')
                    <td>{{$ad->customer->customer_firstname}} {{$ad->customer->customer_lastname}}</td>
                    @else
                    <td>
                      {{ @$ad->customer->customer_company }}
                    </td>
                    @endif

                    <td>{{\App\City::find($ad->city_id)->name}}</td>
                    
                
                   
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
        <table id="UserAds"  class="table table-responsive">
            <thead>
            <tr>
                <th>User</th>
                <th>City</th>
                <th>Title</th>
                <th>Product Code</th>
                <th>Category</th>
                <th>Price</th>
                <th>Views</th>
                <th>VAT</th>
                <th>Negotiable</th>
                <th>Condition</th>
                <th>Status</th>
                <th style="width: 100%">Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($ads as $ad)
                <tr>
                    <td>{{\App\Models\Customers\Customer::find($ad->customer_id)->customer_firstname}} {{\App\Models\Customers\Customer::find($ad->customer_id)->customer_lastname}}</td>

                    <td>{{\App\City::find($ad->city_id)->name}}</td>
                    <td>{{$ad->title}}</td>
                    <td>{{$ad->product_code}}</td>
                    <td>{{\App\SparePartCategory::find($ad->category_id)->title}}</td>
                    <td>{{$ad->price}}</td>
                    <td>{{$ad->views}}</td>
                    <td>@if($ad->vat == 1) Yes @else No @endif</td>
                    <td>@if($ad->neg == 1) Yes @else No @endif</td>
                    <td>{{$ad->condition}}</td>
                    @if($ad->status == 0)
                    <td><label class="label label-warning">Pending</label></td>
                    @elseif($ad->status == 1)
                    <td><label class="label label-info">Approved</label></td>
                    @elseif($ad->status == 2)
                    <td><label class="label label-success">Published</label></td>
                    @endif
                    <td>
                        @if($ad->status == 0)
                            <a class="btn btn-primary approve-ad" data-id="{{$ad->id}}" title="Approve" ><i class="fa fa-check-square"></i></a>
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 1)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 2)
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
        $('#UserAds').DataTable();
    </script>

    <script type="text/javascript">
        

        $(document).on("click",".approve-ad",function(){

            var ad_id = $(this).data('id');
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
        data:{ad_id:ad_id},
        url:"{{url('admin/approve-part-ad')}}",
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