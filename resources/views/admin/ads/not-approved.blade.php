@extends('admin.layouts.app')

@section('content')

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Car Ads / <a target="" href="{{url('admin/not-approved-ads')}}">Not Approved</a></h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Not Approved Ads</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <!-- <th>Action</th> -->
                <th>Title</th>
                <th>Detail</th>
                <th>Bought From</th>
                <th>Color</th>
                <th>Price</th>
                <th>Customer</th>
                
              </tr>
          </thead>
          <tbody>
            @foreach($ads as $ad)
                <tr>
                    <!--  <td>
                            <a  class="fa fa-eye" href="{{url('admin/ad-details/'.$ad->id)}}" ><i title="View Add"></i></a>
                            <a class="fa fa-trash text-danger"><i title="Delete Add"></i></a>
                        

                    </td> -->
                    <td><a href="{{url('admin/ad-details/'.$ad->id)}}" ><b>{{@$ad->maker->title}} {{@$ad->model->name}} {{@$ad->year}}</b></a></td>
                    <td style="white-space: nowrap;"> CC {{@$ad->versions->cc}} \ KW {{@$ad->versions->kilowatt}} \{{@$ad->versions->extra_details}} </td>
                    <td>{{@$ad->country->name}}</td>
                    <td>{{@$ad->color->name}}</td>
                    <td>{{$ad->price}}</td>
                   
                    <td>
                      {{ @$ad->customer->customer_company }}
                    </td>
                   
              </tr>
               @endforeach 
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div>
<!-- Appointment Start Here -->
<!-- <div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Pending Ads</h5>
      </div>
      <div class="table-responsive">
        <table id="UserAds" class="table table-bordered table-striped tabel-align-middle" style="width:100%">
        
          <thead>
              <tr>
                <th>Maker</th>
                <th>Model</th>
                <th>Detail</th>
                <th>Bought From</th>
                <th>Year</th>
                <th>Color</th>
                <th>Price</th>
                <th>Customer</th>
                <th>Status</th>
                <th style="width: 100%">Action</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                 @foreach($ads as $ad)
                <tr>
                    <td>{{@$ad->maker->title}}</td>
                    <td>{{@$ad->model->name}}</td>
                    <td style="white-space: nowrap;">{{@$ad->versions->name}}</td>
                    <td>{{@$ad->city->name}}</td>
                    <td>{{@$ad->year}}</td>
                    <td>{{@$ad->color->name}}</td>
                    <td>{{$ad->price}}</td>
                    <td>{{\App\Models\Customers\Customer::find($ad->customer_id)->customer_firstname}} {{\App\Models\Customers\Customer::find($ad->customer_id)->customer_lastname}}</td>
                    
                    @if($ad->status == 0)
                    <td><label class="label label-warning">Pending</label></td>
                    @elseif($ad->status == 1)
                    <td><label class="label label-info">Approved</label></td>
                    @elseif($ad->status == 2)
                    <td><label class="label label-primary">Removed</label></td>
                    @elseif($ad->status == 3)
                    <td><label class="label label-success">SoldOut</label></td>
                    @elseif($ad->status == 4)
                    <td><label class="label label-danger">Rejected</label></td>
                    @endif
                    <td>
                        @if($ad->status == 0)
                            <a class="fa fa-check-square"  href="{{url('admin/approve-ad/'.$ad->id)}}"><i title="Approve"></i></a>
                            <a  class="fa fa-eye" href="{{url('admin/ad-details/'.$ad->id)}}" ><i title="View Add"></i></a>
                            <a class="fa fa-trash text-danger"><i title="Delete Add"></i></a>
                        @elseif($ad->status == 1)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 2)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 3)
                        <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 4)
                        <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @endif

                    </td>
              </tr>
               @endforeach    
              
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div> -->


    @push('custom-scripts')
    <script>
        $('#UserAds').DataTable();
    </script>
    @endpush

@endsection