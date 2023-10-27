<div class="col-12 bg-white border mb-md-5 mb-4 p-0">
<div class="row align-items-md-center p-md-4 p-3 pb-xl-5 mx-0">
<div class="col-lg-2 col-sm-3 col-3 pr-2 pl-0 user-profile-img">
  @php 
$loggedInUser = Auth::guard('customer')->user();
  @endphp
  @if($loggedInUser->logo != null)
<img src="{{asset('public/uploads/customers/logos/'.@$loggedInUser->logo)}}" style="width:100%;height: 170px;" alt="profile image">
@else
<img src="data:image/png;base64,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" style="width: 100%">
@endif
</div>  
<div class="col-lg-10 col-sm-9 col-9 pl-md-3 pl-2 pr-0 cprofile-desc">
  
<h3 class="mb-sm-2 mb-1">{{$loggedInUser->customer_company != null?$loggedInUser->customer_company:'Here is the company name'}}</h3>
<p class="mb-sm-2 mb-1 font-weight-semibold member-time">{{__('dashboardHeader.memberSince')}} {{date('M dS, Y', strtotime($loggedInUser->created_at))}}</p>
<ul class="list-unstyled themecolor font-weight-semibold mb-0">
   @if($loggedInUser->customer_role == 'individual')
 <li class="list-inline-item"><a target="" href="{{route('change.profile')}}">{{__('dashboardHeader.editProfile')}}</a></li>
 @else
 <li class="list-inline-item"><a target="" href="{{route('my.business.profile')}}">{{__('dashboardHeader.editProfile')}}</a></li>
 @endif
 <li class="list-inline-item"><a target="" href="{{route('change-password')}}">{{__('dashboardHeader.changePassword')}}</a></li>
</ul>
</div>         
</div> 
<ul class="nav nav-tabs nav-fill profile-nav-tab" id="m">
<li class="nav-item">
  <a class="nav-link {{ (request()->is('user/my-ads') || request()->is('user/my-spear-parts-ads') || request()->is('user/my-services-ads')) ? 'active' : '' }}" href="{{route('my-ads')}}">
    <em class="fa mr-lg-2 mr-1 fa-bullhorn"></em>{{__('dashboardHeader.tab1')}}</a>
</li>
<li class="nav-item">
  <a class="nav-link {{ (request()->is('user/my-saved-ads')) ? 'active' : '' }}" href="{{route('my-saved-ads')}}">
  <em class="fa mr-lg-2 mr-1 fa-heart"></em> {{__('dashboardHeader.tab2')}}</a>
</li>
<li class="nav-item">
  <a class="nav-link {{ (request()->is('user/my-alerts')) ? 'active' : '' }}"  href="{{route('my-alerts')}}">
  <em class="fa mr-lg-2 mr-1 fa-bell-o"></em> {{__('dashboardHeader.tab3')}}</a>
</li>
 <li class="nav-item">
  <a class="nav-link {{ (request()->is('user/my-messages')) ? 'active' : '' }}" href="{{route('my-messages')}}">
  <em class="fa mr-lg-2 mr-1 fa-envelope-o"></em> {{__('dashboardHeader.tab4')}} @if(@$unread_msgs > 0) ({{@$unread_msgs}}) @endif </a>
</li>
 <li class="nav-item">
  <a class="nav-link {{ (request()->is('user/change-password')) ? 'active' : '' }}"  href="{{route('change-password')}}">
  <em class="fa mr-lg-2 mr-1 fa-unlock-alt"></em> {{__('dashboardHeader.tab5')}}</a>
</li>
 <li class="nav-item">
  <a class="nav-link {{ (request()->is('user/my-payment')) ? 'active' : '' }}"  href="{{route('my-payment')}}">
    <em class="fa mr-lg-2 mr-1 fa-credit-card"></em> {{__('dashboardHeader.tab6')}}</a>
</li>
</ul>
</div>