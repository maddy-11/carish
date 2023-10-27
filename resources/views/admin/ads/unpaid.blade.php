@extends('admin.layouts.app')

@section('content')

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Car Ads / <a target="" href="{{url('admin/unpaid-ads')}}">Unpaid</a></h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Unpaid Ads</h5>
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
                    <!-- <td>
                           <i title="View Add"></i></a>
                            <a class="fa fa-trash text-danger"><i title="Delete Add"></i></a>
                        

                    </td> -->
                    <td> <a href="{{url('admin/ad-details/'.$ad->id)}}" ><b>{{@$ad->maker->title}} {{@$ad->model->name}} {{@$ad->year}}</b></a></td>
                    <td style="white-space: nowrap;"> CC {{@$ad->versions->cc}} \ KW {{@$ad->versions->kilowatt}} \{{@$ad->versions->extra_details}} </td>
                    <td>{{@$ad->country->name}}</td>
                    <td>{{@$ad->color->name}}</td>
                    <td>{{$ad->price}}</td>
                    <td>
                      {{ @$ad->customer->customer_company !== null ? @$ad->customer->customer_company : '--' }}
                    </td>
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