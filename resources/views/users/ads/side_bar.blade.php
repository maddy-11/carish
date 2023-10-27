<div class="bg-white border p-3">
   <ul class="nav nav-tabs nav-pills d-block text-capitalize sidebar-pills my-ad-tabs">
    <li class="nav-item">
      <a class="nav-link {{ (request()->is('user/my-ads')) ? 'active' : '' }} d-flex"  href="{{route('my-ads')}}">
       <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
        <img src="{{url('public/assets/img/adtab-car.png')}}" class="img-fluid none-active-img" alt="icon image">
        <img src="{{url('public/assets/img/adtab-active-car.png')}}" class="img-fluid active-img" alt="icon image">
      </figure> 
      <span>{{__('dashboardMyAds.carAds')}}</span>
      </a>
    </li>
    <li class="nav-item">
    <a class="nav-link {{ (request()->is('user/my-spear-parts-ads')) ? 'active' : '' }} d-flex"  href="{{route('my-spear-parts-ads')}}">
      <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
      <img src="{{url('public/assets/img/adtab-parts.png')}}" class="img-fluid none-active-img" alt="icon image">
      <img src="{{url('public/assets/img/adtab-active-parts.png')}}" class="img-fluid active-img" alt="icon image">
    </figure> <span>{{__('dashboardMyAds.sparePartAds')}}</span></a>
  </li>
    @if(Auth::guard('customer')->user()->customer_role == 'business')
    <li class="nav-item">
      <a class="nav-link {{ (request()->is('user/my-services-ads')) ? 'active' : '' }} d-flex"  href="{{route('my-services-ads')}}">
        <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
        <img src="{{url('public/assets/img/adtab-offer-services.png')}}" class="img-fluid none-active-img" alt="icon image">
        <img src="{{url('public/assets/img/adtab-active-offer-services.png')}}" class="img-fluid active-img" alt="icon image">
      </figure> <span>{{__('dashboardMyAds.offerServiceAds')}}</span></a>
    </li>
    @endif
  </ul>
</div>