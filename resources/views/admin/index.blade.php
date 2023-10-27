@extends('admin.layouts.app')
@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
  <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Carish Dashboard</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col">
     <div class="input-group custom-input-group">
          <input type="text" class="form-control" placeholder="Search">
          <div class="input-group-prepend">
            <span class="input-group-text fa fa-search"></span>
          </div>
     </div>
  </div>
</div>
<div class="row menulinkrow mb-3 mb-md-2 mb-xl-0">
    <!--Car Ads-->
    <a href="{{url('admin/car-ads-list/pending-ads')}}" class="col-lg-3 col-md-3 col-6 menulink">
    <div class="d-flex flex-row-reverse align-items-center justify-content-between p-xl-4 pt-4 pb-4 pl-3 pr-3 text-white" style="background-color:#6ab441">
    <i class="fa fa-clock-o"></i> <span class="text-capitalize"><strong class="fontbold d-block">{{$pending}}</strong>Pending Ads</span>
    </div>
    </a>
    <a href="{{url('admin/car-ads-list/active-ads')}}" class="col-lg-3 col-md-3 col-6 menulink">
    <div class="d-flex flex-row-reverse align-items-center justify-content-between p-xl-4 pt-4 pb-4 pl-3 pr-3 text-white" style="background-color:#017baa">
    <i class="fa fa-check-circle"></i> <span class="text-capitalize"><strong class="fontbold d-block">{{$active_adds_count}}</strong>Active Ads</span>
    </div>
    </a>
    <a href="{{url('admin/car-ads-list/not-approved-ads')}}" class="col-lg-3 col-md-3 col-6 menulink">
    <div class="d-flex flex-row-reverse align-items-center justify-content-between p-xl-4 pt-4 pb-4 pl-3 pr-3 text-white" style="background-color:#6ab441">
    <i class="fa fa-ban"></i> <span class="text-capitalize"><strong class="fontbold d-block">{{$not_approve_adds_count}}</strong>Not Approved Ads</span>
    </div>
    </a>
    <a href="{{url('admin/car-ads-list/remove-ads')}}" class="col-lg-3 col-md-3 col-6 menulink">
    <div class="d-flex flex-row-reverse align-items-center justify-content-between p-xl-4 pt-4 pb-4 pl-3 pr-3 text-white" style="background-color:#E81123">
    <i class="fa fa-times-circle-o"></i> <span class="text-capitalize"><strong class="fontbold d-block">{{$removed_adds_count}}</strong>Removed Ads</span>
    </div>
    </a>
</div>
<div class="row menulinkrow mb-3 mb-md-2 mb-xl-0">
<!--Spear Part Ads-->
    <a href="{{url('admin/parts-ads-list/pending-ads')}}" class="col-lg-3 col-md-3 col-6 menulink">
    <div class="d-flex flex-row-reverse align-items-center justify-content-between p-xl-4 pt-4 pb-4 pl-3 pr-3 text-white" style="background-color:#6ab441">
        <i class="fa fa-clock-o"></i> <span class="text-capitalize"><strong class="fontbold d-block">{{$pending_spareparts_count}}</strong>Pending Spareparts</span>
    </div>
</a>
    <a href="{{url('admin/parts-ads-list/active-ads')}}" class="col-lg-3 col-md-3 col-6 menulink">
    <div class="d-flex flex-row-reverse align-items-center justify-content-between p-xl-4 pt-4 pb-4 pl-3 pr-3 text-white" style="background-color:#017baa">
        <i class="fa fa-check-circle"></i> <span class="text-capitalize"><strong class="fontbold d-block">{{$active_spareparts_count}}</strong>Active Spareparts</span>
    </div>
</a>
    <a href="{{url('admin/parts-ads-list/not-approved-ads')}}" class="col-lg-3 col-md-3 col-6 menulink">
    <div class="d-flex flex-row-reverse align-items-center justify-content-between p-xl-4 pt-4 pb-4 pl-3 pr-3 text-white" style="background-color:#6ab441">
        <i class="fa fa-ban"></i> <span class="text-capitalize"><strong class="fontbold d-block">{{$not_approve_spareparts_count}}</strong>Not Approved Spareparts</span>
    </div>
</a>
    <a href="{{url('admin/parts-ads-list/remove-ads')}}" class="col-lg-3 col-md-3 col-6 menulink">
    <div class="d-flex flex-row-reverse align-items-center justify-content-between p-xl-4 pt-4 pb-4 pl-3 pr-3 text-white" style="background-color:#E81123">
        <i class="fa fa-times-circle-o"></i> <span class="text-capitalize"><strong class="fontbold d-block">{{$remove_spareparts_count}}</strong>Removed Spareparts</span>
    </div>
</a>
</div>
<div class="row menulinkrow mb-3 mb-md-2 mb-xl-0">
  <!--Service Ads-->
  <a href="{{url('admin/services-ads-list/pending-ads')}}" class="col-lg-3 col-md-3 col-6 menulink">
    <div class="d-flex flex-row-reverse align-items-center justify-content-between p-xl-4 pt-4 pb-4 pl-3 pr-3 text-white" style="background-color:#6ab441">
            <i class="fa fa-clock-o"></i> <span class="text-capitalize"><strong class="fontbold d-block">{{$pending_services_count}}</strong>Pending Services</span>
    </div>
  </a>
  <a href="{{url('admin/services-ads-list/active-ads')}}" class="col-lg-3 col-md-3 col-6 menulink">
    <div class="d-flex flex-row-reverse align-items-center justify-content-between p-xl-4 pt-4 pb-4 pl-3 pr-3 text-white" style="background-color:#017baa">
            <i class="fa fa-check-circle"></i> <span class="text-capitalize"><strong class="fontbold d-block">{{$active_services_count}}</strong>Active Services</span>
    </div>
  </a>
 <a href="{{url('admin/services-ads-list/not-approved-ads')}}" class="col-lg-3 col-md-3 col-6 menulink">
    <div class="d-flex flex-row-reverse align-items-center justify-content-between p-xl-4 pt-4 pb-4 pl-3 pr-3 text-white" style="background-color:#6ab441">
            <i class="fa fa-ban"></i> <span class="text-capitalize"><strong class="fontbold d-block">{{$not_approve_services_count}}</strong>Not Approved Services</span>
    </div>
  </a>
   <a href="{{url('admin/services-ads-list/remove-ads')}}" class="col-lg-3 col-md-3 col-6 menulink">
    <div class="d-flex flex-row-reverse align-items-center justify-content-between p-xl-4 pt-4 pb-4 pl-3 pr-3 text-white" style="background-color:#E81123">
            <i class="fa fa-times-circle-o"></i> <span class="text-capitalize"><strong class="fontbold d-block">{{$removed_services_count}}</strong>Removed Services</span>
    </div>
  </a>
</div>
@endsection