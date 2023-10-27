@extends('layouts.app')
@section('title') {{ __('header.tags') }} @endsection
@push('scripts') 
@endpush
@section('content')
   <!-- header Ends here -->
      <div class="internal-page-content mt-4 sects-bg">
        <div class="container pt-1">
          @if(session::has('tag_sent'))
          <div class="alert alert-success alert-dismissible mt-4">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Tag Suggestion Sent Successfully!!!
            </div>
          @endif
          @if(session::has('please_login'))
            <div class="alert alert-danger alert-dismissible mt-4">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Failed!</strong> Please Login First!!!
            </div>
          @endif
          <div class="row">
            <div class="col-12 mt-4 mt-lg-5 pt-3 pt-lg-0">
              <div class="bg-white tags-sect border ourtags tag-page-col">
                <h2 class="border-bottom font-weight-bold mb-0 pt-lg-4 pb-lg-4 pt-md-3 pb-md-3 pl-md-4 pr-md-4 pl-xl-5 pr-xl-5 tagpagetitle themecolor p-3">{{@$page_descp->title}}</h2>
                <div class="p-md-4 p-3 pl-xl-5 pr-xl-5 f-size">
                  <p>{!!@$page_descp->description!!}</p>
                </div>
              </div>
            </div>
            <div class="col-12 mt-4 mt-lg-5 pt-3 pt-lg-0">
              <div class="bg-white tags-sect border cartags tag-page-col">
                <h2 class="border-bottom font-weight-bold mb-0 pt-lg-4 pb-lg-4 pt-md-3 pb-md-3 pl-md-4 pr-md-4 pl-xl-5 pr-xl-5 tagpagetitle themecolor p-3">{{@$page_description->title}}</h2>
                <div class="p-md-4 p-3 pl-xl-5 pr-xl-5 f-size">
                  <p>{!!@$page_description->description!!}</p>
                </div>
              </div>
            </div>
            <div class="col-12 mt-4 mt-lg-5 pt-3 pt-lg-0">
              <div class="bg-white tags-sect border dealertags tag-page-col">
                <h2 class="border-bottom font-weight-bold mb-0 pt-lg-4 pb-lg-4 pt-md-3 pb-md-3 pl-md-4 pr-md-4 pl-xl-5 pr-xl-5 tagpagetitle themecolor p-3">{{@$page_description_dealer->title}}</h2>
                <div class="p-md-4 p-3 pl-xl-5 pr-xl-5 f-size">
                  <div class="mb-4">
                    <span>{!!@$page_description_dealer->description!!}</span>
                    {{-- <h6 class="f-size font-weight-bold mb-1">Certified Mechanic:</h6>
                    <p>This tag will help users to search for a certified mechanic for the car, like a certified honda mechanic, certified Kia mechanic. Mechanics can apply for this tag while providing enough material to show their claim.</p> --}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 mt-4 mt-lg-5 pt-3 pt-lg-0">
              <div class="bg-sect p-md-4 p-3 pl-xl-5 pr-xl-5 newtags-form border bgdarklight f-size">
                <h3 class="font-weight-bold tagpagetitle themecolor">{{__('tagPage.suggestNewForm')}}</h3>
                <p>{{__('tagPage.wantToSuggestNew..')}}</p>
                <form method="POST" action="{{route('tag-suggestion')}}">
                  {{csrf_field()}}
                  <div class="form-row mt-md-4">
                    <div class="col-12 col-lg-5 col-sm-6 form-group mb-md-4">
                      <label class="font-weight-semibold">{{__('tagPage.newTag')}}</label>
                      <input type="text" class="form-control" name="title" placeholder="{{__('tagPage.yourTagTitleRequired')}}" required="required">
                    </div>
                    <div class="col-lg-5 col-sm-6 col-12 form-group mb-md-4">
                      <label class="font-weight-semibold">{{__('tagPage.category')}}</label>
                      <select class="form-control" name="category" required="required">
                        <option value="">{{__('tagPage.selectCategory')}}</option>
                        <option value="{{__('tagPage.carTags')}}">{{__('tagPage.carTags')}}</option>
                        <option value="{{__('tagPage.dealerTags')}}">{{__('tagPage.dealerTags')}}</option>
                      </select>
                    </div>
                    <div class="col-lg-5 col-sm-6 col-12 form-group mb-md-4">
                      <label class="font-weight-semibold">{{__('tagPage.description')}}</label>
                      <input type="text" class="form-control" name="description" placeholder="{{__('tagPage.yourTagDescription')}}" required="required">
                    </div>
                    <div class="align-items-end col-12 col-lg-5 col-sm-6 d-flex form-group mb-md-4">
                      <input type="submit" class="bgcolor2 btn tagsubmit w-100" value="{{__('tagPage.submit')}}">
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-12">
              <div class="align-items-center col-lg-9 d-sm-flex justify-content-around ml-auto mr-auto mt-4 mt-md-5 pl-0 postAdRow pr-0 pt-2 pt-sm-3">
                <div class="sellCarCol d-none d-md-block">
                  <img src="{{url('public/assets/img/sell-car.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
                </div>
                <div class="pl-md-3 pr-md-3 sellCartext text-center">
                  <img src="{{url('public/assets/img/sell-arrow-left.png')}}" class="d-md-block d-none img-fluid mr-auto  sell-arrow-left" alt="carish used cars for sale in estonia">
                  <h4 class="mb-0">{{__('tagPage.postAnAdFor')}} <span class="themecolor2">{{__('tagPage.free')}}</span></h4>
                  <p class="mb-0">{{__('tagPage.sellItFasterToThousands')}}</p>
                  <img src="{{url('public/assets/img/sell-arrow-right.png')}}" class="d-sm-block d-none img-fluid ml-auto sell-arrow-right" alt="carish used cars for sale in estonia">
                </div>
                <div class="sellCarBtn">
                  <a href="{{url('user/post-ad')}}" class="btn themebtn1">{{__('tagPage.sellYourCar')}}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection