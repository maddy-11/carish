@extends('admin.layouts.app')
<?php use Carbon\Carbon; ?>
@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Car Ads / <a target="" href="{{url('admin/pending-ads')}}">{{$page_title}}</a></h3>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">{{$page_title}}</h5>
      </div>
      <div class="table-responsive">
        <table id="pending-ads" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <!-- <th>Action</th>-->
                <th>Title</th>
                <th>Detail</th>
                <th>Updated Date</th>
                <th>Created Date</th>
                <th>Price</th>
                <th>Customer</th>
                @if($status == 'active-ads')
                <th>Featured</th>
                @endif
                <th>Bought From</th>
                <th>Color</th>
                
              </tr>
          </thead>
          <tbody>
            @foreach($ads as $ad)
                <tr>
                    <!--<td><i title="View Add"></i></a><a class="fa fa-trash text-danger"><i title="Delete Add"></i></a></td>-->
                    <td><a href="{{url('admin/ad-details/'.$ad->id)}}" target="_blank"><b>{{@$ad->maker->title}} {{@$ad->model->name}} {{@$ad->year}}</b></a></td>
                    <td style="white-space: nowrap;"> CC {{@$ad->versions->cc}} \ KW {{@$ad->versions->kilowatt}} \{{@$ad->versions->extra_details}} </td>
                    <td>{{ Carbon::parse(@$ad->updated_at)->format('d/m/Y') }}</td>
                    <td>{{ Carbon::parse(@$ad->created_at)->format('d/m/Y') }}</td>
                    <td>€{{ $ad->price }}</td>
                    <td>{{ @$ad->customer->customer_company !== null ? @$ad->customer->customer_company : '--' }}</td>
                    @if($status == 'active-ads')
                      @if($ad->is_featured == 'true')
                        <td><label class="label label-info">Featured</label></td>
                       @elseif($ad->is_featured == 'false')
                        <td><label class="label label-warning">Un Featured</label></td>
                      @endif
                    @endif
                    <td>@if(!empty(@$ad->bought_from_id))
                  @php
          if(@$ad->countryRegistered->boughtFromDescription){ 
                  $boughtFromCollection = @$ad->countryRegistered->boughtFromDescription->where('language_id',$ad->customer->language_id)->first();
            }
            else{
              $boughtFromCollection = '';
            }
                  @endphp
                  {{@$boughtFromCollection->title}}
                  @endif</td>
                    <td>{{@$ad->color->color_description !== null ? @$ad->color->color_description->where('language_id',2)->pluck('name')->first() : '--'}}</td>
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
      $('#pending-ads').DataTable({
         ordering: false,
         lengthMenu: [25, 50, 100, 200],
      });
  </script>
  @endpush
@endsection