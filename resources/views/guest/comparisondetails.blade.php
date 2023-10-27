<?php
use App\Helpers\Helper;
$helper = new Helper;
?>
@extends('layouts.app')
@section('title') {{ __('header.car_comparison') }} @endsection
@push('scripts')
<script type="text/javascript" charset="utf-8" defer>
  $(document).ready(function() {});
</script>
@endpush
@section('content')
<div class="internal-page-content mt-4 sects-bg">
  <div class="container">
    <div class="comparison-ad">
      <img src="{{url('public/assets/img/comparison-ad.jpg')}}" class="img-fluid">
    </div>
    <div class="row mt-md-5 mt-4">
      <div class="col-12 carCompTitle pageTitle pb-2">
        <nav aria-label="breadcrumb" class="breadcrumb-menu mb-1">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a target="" href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a target="" href="{{url('/findusedcars')}}">Cars</a></li>
            <li class="breadcrumb-item active" aria-current="page">New Cars Comparison</li>
          </ol>
        </nav>
        <h2>
          {{$cars['car1']['data']['make_name']}} {{$cars['car1']['data']['model_name']}} {{$cars['car1']['data']['from_date']}}-{{$cars['car1']['data']['to_date']}} {{$cars['car1']['data']['engine_capacity']}}CC {{$cars['car1']['data']['engine_power']}}KW VS
          {{$cars['car2']['data']['make_name']}} {{$cars['car2']['data']['model_name']}} {{$cars['car2']['data']['from_date']}}-{{$cars['car2']['data']['to_date']}} {{$cars['car2']['data']['engine_capacity']}}CC {{$cars['car2']['data']['engine_power']}}KW
        </h2>
      </div>
    </div>
    <!-- comparison starts here -->
    <div class="comparison-car-row mt-4">
      <div class="row bg-white ml-0 mr-0 p-lg-5 p-4 justify-content-center text-center">
        <div class="col-lg-4 col-sm-6 col-12 comp-col d-flex flex-column pr-3">
          <figure class="align-items-center d-flex justify-content-center mb-auto mt-auto pb-3">
            <img src="{{$cars['car1']['image']}}" class="img-fluid" alt="carish used cars for sale in estonia">

          </figure>
          <div class="mt-auto w-100">
            <h6 class="font-weight-semibold mb-1"><a href="{{url('car-details/'.$cars['car1']['data']['ads_id'])}}" target="_blank" class="stretched-link themecolor">{{$cars['car1']['data']['make_name']}} {{$cars['car1']['data']['model_name']}} {{$cars['car1']['data']['from_date']}}-{{$cars['car1']['data']['to_date']}} {{$cars['car1']['data']['engine_capacity']}}CC {{$cars['car1']['data']['engine_power']}}KW</a></h6>
            <p class="font-weight-semibold mb-0">€{{$cars['car1']['data']['price']}}</p>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12 comp-col d-flex flex-column pl-3">
          <figure class="align-items-center d-flex justify-content-center mb-auto mt-auto pb-3">
            <img src="{{$cars['car2']['image']}}" class="img-fluid" alt="carish used cars for sale in estonia">
          </figure>
          <div class="mt-auto w-100">
            <h6 class="font-weight-semibold mb-1"><a href="{{url('car-details/'.$cars['car2']['data']['ads_id'])}}" target="_blank" class="stretched-link themecolor">{{$cars['car2']['data']['make_name']}} {{$cars['car2']['data']['model_name']}} {{$cars['car2']['data']['from_date']}}-{{$cars['car2']['data']['to_date']}} {{$cars['car2']['data']['engine_capacity']}}CC {{$cars['car2']['data']['engine_power']}}KW</a></h6>
            <p class="font-weight-semibold mb-0">€{{$cars['car2']['data']['price']}}</p>
          </div>
        </div>
      </div>
    </div>
    <!-- comparison ends here -->
    <!-- Compare Specifications starts here -->
    <div class="bg-white compare-specifications mt-md-5 mt-4 p-4">
      <h2 class="mb-4 pb-md-2">{{__('compare.compare_specifications')}}</h2>
      <table class="table table-bordered comp-table mb-4">
        <tbody>
          <tr>
            <td>{{__('compare.overall_length')}}</td>
            <td>@if($cars['car1']['data']['car_length'] != null) {{$cars['car1']['data']['car_length']}} @endif </td>
            <td>@if($cars['car2']['data']['car_length'] !=null) {{$cars['car2']['data']['car_length']}} @endif</td>
          </tr>
          <tr>
            <td>{{__('compare.overall_width')}}</td>
            <td>@if($cars['car1']['data']['car_width'] !=null) {{$cars['car1']['data']['car_width']}} @endif </td>
            <td>@if($cars['car2']['data']['car_width'] !=null) {{$cars['car2']['data']['car_width']}} @endif</td>
          </tr>
          <tr>
            <td>{{__('compare.overall_height')}}</td>
            <td>@if($cars['car1']['data']['car_height'] == null){{$cars['car1']['data']['car_height']}} @endif</td>
            <td>@if($cars['car2']['data']['car_height'] !=null){{$cars['car2']['data']['car_height']}} @endif </td>
          </tr>
          {{-- <tr>
                  <td>{{__('compare.assembly')}}</td>
          <td>@if($cars['car1']['data']['assembly'] !=null) {{$cars['car1']['data']['assembly']}} @endif </td>
          <td>{{$cars['car2']['data']['assembly']}}</td>
          </tr> --}}
          <td>{{__('compare.transmission_type')}}</td>
          <td>@if($cars['car1']['data']['transmissiontype']!=null && $cars['car1']['data']['transmissiontype']!=0)
            @php
            //$trans = $helper->getAdsTransmission($cars['car1']['data']['transmission_title']);
            @endphp
            {{$cars['car1']['data']['transmission_title']}} @endif
          </td>
          <td>@if($cars['car2']['data']['transmissiontype'] !=null && $cars['car2']['data']['transmissiontype'] !=0)

            @php
            //$trans = $helper->getAdsTransmission($cars['car2']['data']['transmissiontype']);

            @endphp
            {{$cars['car2']['data']['transmission_title']}}
            @endif
          </td>
          </tr>
          <tr>
            <td>{{__('compare.fuel_type')}}</td>
            <td>@if($cars['car1']['data']['engine_title'] !=null){{$cars['car1']['data']['engine_title']}} @endif</td>
            <td>@if($cars['car2']['data']['engine_title'] !=null){{$cars['car2']['data']['engine_title']}} @endif</td>
          </tr>
          <tr>
            <td>{{__('compare.fuel_average')}}</td>
            <td>@if($cars['car1']['data']['fuel_average'] !=null) {{$cars['car1']['data']['fuel_average']}} @endif</td>
            <td>@if($cars['car2']['data']['fuel_average'] !=null) {{$cars['car2']['data']['fuel_average']}} @endif</td>
          </tr>
          <tr>
            <td>{{__('compare.engine_capacity')}}</td>
            <td>@if($cars['car1']['data']['engine_capacity'] !=null) {{$cars['car1']['data']['engine_capacity']}} CC @endif </td>
            <td>@if($cars['car2']['data']['engine_capacity'] !=null){{$cars['car2']['data']['engine_capacity']}} CC @endif</td>
          </tr>
          <tr>
            <td>{{__('compare.engine_power')}}</td>
            <td>@if($cars['car1']['data']['engine_power'] !=null){{$cars['car1']['data']['engine_power']}} KW @endif </td>
            <td>@if($cars['car2']['data']['engine_power'] !=null) {{$cars['car2']['data']['engine_power']}} KW @endif</td>
          </tr>

          <tr>
            <td> {{__('ads.weight')}}</td>
            <td>@if($cars['car1']['data']['weight'] !=null) {{$cars['car1']['data']['weight']}} @endif</td>
            <td>@if($cars['car2']['data']['weight']) {{$cars['car2']['data']['weight']}} @endif</td>
          </tr>

          <tr>
            <td>{{__('ads.curb_weight')}}</td>
            <td>@if($cars['car1']['data']['curb_weight'] !=null) {{$cars['car1']['data']['curb_weight']}} @endif </td>
            <td>@if($cars['car2']['data']['curb_weight'] !=null){{$cars['car2']['data']['curb_weight']}} @endif</td>
          </tr>


          <tr>
            <td>{{__('ads.wheel_base')}}</td>
            <td>@if($cars['car1']['data']['wheel_base'] !=null) {{$cars['car1']['data']['wheel_base']}} @endif </td>
            <td>@if($cars['car2']['data']['wheel_base'] != null) {{$cars['car2']['data']['wheel_base']}} @endif</td>
          </tr>

          <tr>
            <td>{{__('ads.ground_clearance')}}</td>
            <td>@if($cars['car1']['data']['ground_clearance'] !=null) {{$cars['car1']['data']['ground_clearance']}} @endif</td>
            <td>@if($cars['car2']['data']['ground_clearance'] != null) {{$cars['car2']['data']['ground_clearance']}} @endif</td>
          </tr>

          <tr>
            <td> {{__('ads.seating_capacity')}}</td>
            <td>@if($cars['car1']['data']['seating_capacity'] !=null){{$cars['car1']['data']['seating_capacity']}} @endif </td>
            <td>@if($cars['car2']['data']['seating_capacity'] !=null){{$cars['car2']['data']['seating_capacity']}} @endif</td>
          </tr>

          <tr>
            <td>{{__('ads.fuel_tank_capacity')}}</td>
            <td> @if($cars['car1']['data']['fuel_tank_capacity']!=null) {{$cars['car1']['data']['fuel_tank_capacity']}} @endif</td>
            <td>@if($cars['car2']['data']['fuel_tank_capacity'] !=null) {{$cars['car2']['data']['fuel_tank_capacity']}} @endif </td>
          </tr>

          <tr>
            <td>{{__('ads.number_of_doors')}}</td>
            <td>@if($cars['car1']['data']['number_of_door'] !=null){{$cars['car1']['data']['number_of_door']}} @endif</td>
            <td>@if($cars['car2']['data']['number_of_door']!=null){{$cars['car2']['data']['number_of_door']}} @endif</td>
          </tr>
          <tr>
            <td>{{__('ads.displacement')}}</td>
            <td>@if($cars['car1']['data']['displacement']!=null){{$cars['car1']['data']['displacement']}} @endif</td>
            <td>@if($cars['car2']['data']['displacement']!=null){{$cars['car2']['data']['displacement']}} @endif</td>
          </tr>

          <tr>
            <td>{{__('ads.torque')}}</td>
            <td>@if($cars['car1']['data']['torque'] !=null)
              {{$cars['car1']['data']['torque']}} @endif
            </td>
            <td>@if($cars['car2']['data']['torque'] !=null){{$cars['car2']['data']['torque']}} @endif</td>
          </tr>

          <tr>
            <td>{{__('ads.gears')}}</td>
            <td>@if($cars['car1']['data']['gears']!=null){{$cars['car1']['data']['gears']}} @endif</td>
            <td>@if($cars['car2']['data']['gears'] !=null){{$cars['car2']['data']['gears']}} @endif</td>
          </tr>
          <tr>
            <td>{{__('ads.maximum_speed')}}</td>
            <td>@if($cars['car1']['data']['max_speed'] !=null){{$cars['car1']['data']['max_speed']}} @endif</td>
            <td>@if($cars['car2']['data']['max_speed']!=null){{$cars['car2']['data']['max_speed']}} @endif</td>
          </tr>
          <tr>
            <td>{{__('ads.acceleration')}}</td>
            <td>@if($cars['car1']['data']['acceleration']!=null){{$cars['car1']['data']['acceleration']}} @endif</td>
            <td>@if($cars['car2']['data']['acceleration']!=null){{$cars['car2']['data']['acceleration']}} @endif</td>
          </tr>
          <tr>
            <td>{{__('ads.number_of_cylinders')}}</td>
            <td>@if($cars['car1']['data']['number_of_cylinders'] !=null){{$cars['car1']['data']['number_of_cylinders']}} @endif</td>
            <td>@if($cars['car2']['data']['number_of_cylinders']!=null){{$cars['car2']['data']['number_of_cylinders']}} @endif</td>
          </tr>
          <tr>
            <td>{{__('ads.wheel_size')}}</td>
            <td>@if($cars['car1']['data']['front_wheel_size']!=null){{$cars['car1']['data']['front_wheel_size']}} @endif @if($cars['car1']['data']['back_wheel_size']!=null) * {{$cars['car1']['data']['back_wheel_size']}} @endif</td>
            <td>@if($cars['car2']['data']['front_wheel_size']!=null){{$cars['car2']['data']['front_wheel_size']}} @endif @if($cars['car2']['data']['back_wheel_size']!=null) * 
              {{$cars['car2']['data']['back_wheel_size']}} @endif</td>
          </tr>
          <!-- <tr>
            <td>{{__('ads.front_wheel_size')}}</td>
            <td>@if($cars['car1']['data']['front_wheel_size']!=null){{$cars['car1']['data']['front_wheel_size']}} @endif</td>
            <td>@if($cars['car2']['data']['front_wheel_size']!=null){{$cars['car2']['data']['front_wheel_size']}} @endif</td>
          </tr>
          <tr>
            <td>{{__('ads.back_wheel_size')}}</td>
            <td>@if($cars['car1']['data']['back_wheel_size']!=null){{$cars['car1']['data']['back_wheel_size']}} @endif</td>
            <td>@if($cars['car2']['data']['back_wheel_size']!=null)
              {{$cars['car2']['data']['back_wheel_size']}} @endif
            </td> -->
          </tr>

          <!-- <tr>
            <td>{{__('ads.front_tyre_size')}}</td>
            <td>@if($cars['car1']['data']['front_tyre_size']!=null)
              {{$cars['car1']['data']['front_tyre_size']}} mm @endif
            </td>
            <td>@if($cars['car2']['data']['front_tyre_size']!=null)
              {{$cars['car2']['data']['front_tyre_size']}} mm @endif
            </td>
          </tr>

          <tr>
            <td>{{__('ads.back_tyre_size')}}</td>
            <td>@if($cars['car1']['data']['back_tyre_size']!=null)
              {{$cars['car1']['data']['back_tyre_size']}} mm @endif
            </td>
            <td>@if($cars['car2']['data']['back_tyre_size']!=null)
              {{$cars['car2']['data']['back_tyre_size']}} mm @endif
            </td>
          </tr> -->
          <tr>
            <td>{{__('ads.drive_type')}}</td>
            <td>@if($cars['car1']['data']['drive_type'] !=null){{$cars['car1']['data']['drive_type']}} @endif</td>
            <td>@if($cars['car2']['data']['drive_type']!=null)
              {{$cars['car2']['data']['drive_type']}} @endif
            </td>
          </tr>


        </tbody>
      </table>
    </div>
    <div class="bg-white compare-features mt-md-5 mt-4 p-md-5 p-4">
      {{-- <h2 class="mb-4 pb-md-2">{{__('compare.compare_features')}}</h2> --}}
      <table class="table table-bordered comp-table mb-4">
        <tbody>
          <tr>
            <td style="vertical-align: middle;">
              <h2 class="pb-md-2">{{__('compare.compare_features')}}</h2>
            </td>
            <td style="vertical-align: middle;">
              <h4>{{$cars['car1']['data']['make_name']}} {{$cars['car1']['data']['model_name']}} {{$cars['car1']['data']['from_date']}}-{{$cars['car1']['data']['to_date']}} {{$cars['car1']['data']['engine_capacity']}}CC {{$cars['car1']['data']['engine_power']}}KW</h4>
            </td>
            <td style="vertical-align: middle;">
              <h4>{{$cars['car2']['data']['make_name']}} {{$cars['car2']['data']['model_name']}} {{$cars['car2']['data']['from_date']}}-{{$cars['car2']['data']['to_date']}} {{$cars['car2']['data']['engine_capacity']}}CC {{$cars['car2']['data']['engine_power']}}KW</h4>
            </td>
          </tr>
          @foreach($all_features as $feature)
          <tr>
            <td>{{$feature->name}}</td>
            <td>
              @if(isset($cars['car1']['features']) && in_array($feature->id, $cars['car1']['features']))
              <em class="fa fa-check text-success"></em>
              @else
              <em class="fa fa-close text-danger"></em>
              @endif
            </td>
            <td> @if (isset($cars['car2']['features']) && in_array($feature->id, $cars['car2']['features']))
              <em class="fa fa-check text-success"></em>
              @else
              <em class="fa fa-close text-danger"></em>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <!-- <div class="pt-md-2 text-right view-more">
              <a href="#" class="font-weight-semibold text-capitalize themecolor">{{__('compare.view_more')}}</a>
            </div> -->
    </div>
    <!-- Compare Specifications ends here -->
    <div class="align-items-center col-lg-9 d-sm-flex justify-content-around ml-auto mr-auto mt-4 mt-md-5 pl-0 postAdRow pr-0 pt-2 pt-sm-3">
      <div class="sellCarCol d-none d-md-block">
        <img src="{{url('public/assets/img/sell-car.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
      </div>
      <div class="pl-md-3 pr-md-3 sellCartext text-center">
        <img src="{{url('public/assets/img/sell-arrow-left.png')}}" class="d-md-block d-none img-fluid mr-auto  sell-arrow-left" alt="carish used cars for sale in estonia">
        <h4 class="mb-0">{{__('compare.postan_ad_for')}}<span class="themecolor2">{{__('compare.free')}}</span></h4>
        <p class="mb-0">{{__('compare.sell_it_faster_to')}}</p>
        <img src="{{url('public/assets/img/sell-arrow-right.png')}}" class="d-sm-block d-none img-fluid ml-auto sell-arrow-right" alt="carish used cars for sale in estonia">
      </div>
      <div class="sellCarBtn">
        <a target="" href="{{url('user/post-ad')}}" class="btn themebtn1">{{__('compare.sell_your_car')}}</a>
      </div>
    </div>
  </div>
</div>
@endsection