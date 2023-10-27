@extends('admin.layouts.app')

@section('content')

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Spare Part Ads / <a target="" href="{{url('admin/unpaid-spareparts')}}">Unpaid</a></h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Unpaid Sparepart Ads</h5>
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

                        <a  class="fa fa-eye" href="{{url('admin/pending-part-ad-detail/'.$ad->id)}}" ><i title="View Add"></i></a>

                    </td> -->
                    <td><a href="{{url('admin/pending-part-ad-detail/'.$ad->id)}}" ><b>{{$ad->title}}</b></a></td>

                    <td>{{$ad->product_code}}</td>
                    <td>{{\App\SparePartCategory::find($ad->parent_id)->title}}</td>
                    <td>{{\App\SparePartCategory::find($ad->category_id)->title}}</td>
                    <td>{{$ad->price}}</td>
                    @if(@$ad->customer->customer_role != 'business')
                    <td>{{ @$ad->get_customer->customer_company }}</td>
                    @else
                    <td>
                      {{ @$ad->get_customer->customer_company }}
                    </td>
                    @endif

                    <td>{{\App\City::find($ad->city_id)->name}}</td>
                    
                
                    
                </tr>
            @endforeach 
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div>

    @push('custom-scripts')
    <script>
        $('#UserAds').DataTable();
    </script>
    @endpush

@endsection