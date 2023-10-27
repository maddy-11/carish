@extends('layouts.app')
@section('title') {{ __('carComparisonPage.cars_comparison') }} @endsection
@push('styles')  
@endpush 
@push('scripts')
<script type="text/javascript" charset="utf-8" defer>
$(document).ready(function ()
  {   /*###########################################################*/ 
    //to clear the inputs
    $('.clear_inputs').on('click',function(){
      $('#ads_first_text').val('');
      $('#ads_second_text').val('');
    })
    $(document).on("click","#ads_first_text",function(){
      var ads_second = $("#ads_second").val();
       $.ajax({
          url: "{{route('get.ads.compared')}}/",
            method: "get",
            data : {excludedAd: ads_second},
              success: function (data) {
                var car1 = '';
                if(typeof(data) != 'string')
                { 
                 $.each(data, function(keys,values) {
                    car1 += '<div class="align-items-center media mb-3"><img class="mr-3 saved-adImg" src="'+values.image+'" alt="Generic placeholder image"><div class="media-body"><h5 class="mb-0"> <a href="JavaScript:void(0);" class="themecolor select-for-compare1" data-value="'+values.ads_id+'" data-text="'+values.make_name+' '+values.model_name+' '+values.from_date+'-'+values.to_date+' '+values.version_label+' CC '+values.engine_power+' KW">'+values.make_name+' '+values.model_name+' '+values.from_date+'-'+values.to_date+' '+values.version_label+' CC '+values.engine_power+' KW</a></h5></div></div>';
               });
               $('.saved-cars1').html(car1);
             }
             else
             {
              $('.saved-cars1').html(data);
             }
              },
              beforeSend: function(){
                $('.saved-cars1').html("loading data ...");
                $('#savedCarAd').modal('show');
              }
          });
    });

    $(document).on("click","#ads_second_text",function(){
      var ads_first = $("#ads_first").val();
        $.ajax({
          url: "{{route('get.ads.compared')}}/",
            method: "get",
            // dataType: "json",
            data : {excludedAd: ads_first},
              success: function (data) {
                var car2 = '';
                if(typeof(data) != 'string')
                {
                 $.each(data, function(keys,values) { 
                 car2 += '<div class="align-items-center media mb-3"><img class="mr-3 saved-adImg" src="'+values.image+'" alt="Generic placeholder image"><div class="media-body"><h5 class="mb-0"> <a href="JavaScript:void(0);" class="themecolor select-for-compare2" data-value="'+values.ads_id+'" data-text="'+values.make_name+' '+values.model_name+' '+values.from_date+'-'+values.to_date+' '+values.version_label+' CC '+values.engine_power+' KW">'+values.make_name+' '+values.model_name+' '+values.from_date+'-'+values.to_date+' '+values.version_label+' CC '+values.engine_power+' KW</a></h5></div></div>';

               }); 
                $('.saved-cars2').html(car2); 
              }
              else
              {
                $('.saved-cars2').html(data);
              }
              },
              beforeSend: function(){
                $('.saved-cars2').html("loading data ...");
                $('#savedCarAd2').modal('show');
              }
          });

    });

  $.ajax({
          url: "{{route('get.ads.compared')}}/",
            method: "get", 
              success: function (data) {
                var car1 = '';
                var car2 = '';
                console.log(data);
                if(typeof(data) != 'string')
                {
                 $.each(data, function(keys,values) {
                 car1 += '<div class="align-items-center media mb-3"><img class="mr-3 saved-adImg" src="'+values.image+'" alt="Generic placeholder image"><div class="media-body"><h5 class="mb-0"> <a href="JavaScript:void(0);" class="themecolor select-for-compare1" data-value="'+values.ads_id+'" data-text="'+values.make_name+' '+values.model_name+' '+values.from_date+'-'+values.to_date+' '+values.version_label+' CC '+values.engine_power+' KW">'+values.make_name+' '+values.model_name+' '+values.from_date+'-'+values.to_date+' '+values.version_label+' CC '+values.engine_power+' KW</a></h5></div></div>';

                 car2 += '<div class="align-items-center media mb-3"><img class="mr-3 saved-adImg" src="'+values.image+'" alt="Generic placeholder image"><div class="media-body"><h5 class="mb-0"> <a href="JavaScript:void(0);" class="themecolor select-for-compare2" data-value="'+values.ads_id+'" data-text="'+values.make_name+' '+values.model_name+' '+values.from_date+'-'+values.to_date+' '+values.version_label+' CC '+values.engine_power+' KW">'+values.make_name+' '+values.model_name+' '+values.from_date+'-'+values.to_date+' '+values.version_label+' CC '+values.engine_power+' KW</a></h5></div></div>';

               });
                  $('.saved-cars1').html(car1);
                  $('.saved-cars2').html(car2);
                }
                else
                {
                  $('.saved-cars1').html(data);
                  $('.saved-cars2').html(data);
                }

              }
          });

  $(document).on("click",".select-for-compare1",function(){
    var ads_first = $(this).data('value');
    var ads_first_text = $(this).data('text');
    $('#ads_first').val(ads_first);
    $('#ads_first_text').val(ads_first_text);
    $('#savedCarAd').modal('hide');

  });  
  $(document).on("click",".select-for-compare2",function(){
    var ads_second      = $(this).data('value');
    var ads_second_text = $(this).data('text');
    $('#ads_second').val(ads_second);
    $('#ads_second_text').val(ads_second_text);
    $('#savedCarAd2').modal('hide');
  });
$(document).on("click","#compare_btn",function(){
  $('.compare_form').submit();
  });
              });
              </script>
@endpush
@section('content')
 <div class="internal-page-content mt-4 sects-bg bg-white">
        <div class="bgcolcor bgcolor1 internal-banner text-white cc-page-banner">
          <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumb-menu mb-2">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="javascript:void(0)">{{__('carComparisonPage.backLinkHome')}}</a></li>
                  <li class="breadcrumb-item"><a href="javascript:void(0)">{{__('carComparisonPage.cars')}}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{__('carComparisonPage.new_car_comparison')}}</li>
                </ol>
              </nav>
            <h1 class="font-weight-semibold  mb-2">{{__('carComparisonPage.cars_comparison')}}</h1>
            <p class="mb-0">{{__('carComparisonPage.confused')}}</p>
          </div>
        </div>
        <div class="container mt-n5">
          <div class="comp-form-bg bg-white border p-4 car-comparison-from">
          <form action="{{ route('comparedetails') }}" method="POST" id="compare_form">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-row">
                <div class="form-group col-md-4 col-sm-4 col-12">
                  <label class="font-weight-semibold f-size1">{{__('carComparisonPage.selectCar1')}}</label>
                  <input type="text" name="" placeholder="{{__('carComparisonPage.carMakeModel')}}" class="border-dark form-control" id="ads_first_text" autocomplete="off"  required>
                  <input type="hidden" name="compared_cars[]" id="ads_first" value="">
                </div>
                <div class="form-group col-md-4 col-sm-4 col-12">
                  <label class="font-weight-semibold f-size1">{{__('carComparisonPage.selectCar2')}}</label>
                  <input type="text" name="" placeholder="{{__('carComparisonPage.carMakeModel')}}" class="border-dark form-control" id="ads_second_text" autocomplete="off" required>
                <input type="hidden" name="compared_cars[]" id="ads_second" value="">
                </div> 
                <div class="align-items-center col-12 d-flex form-group justify-content-between mt-md-4 mt-2 mb-0">
                  <div class="comp-clear">
                    <a href="javascript:void(0)" class="font-weight-semibold themecolor clear_inputs">{{__('carComparisonPage.clear')}}</a>
                  </div>
                  <div class="comp-submit">
                    <input type="submit" value="{{__('carComparisonPage.submit')}}" class="btn  themebtn3">
                  </div>
                </div>
              </div>
              <!-- Modal -->
              <div class="modal fade" id="savedCarAd" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content sects-bg">
                    <div class="modal-header border-bottom-0 pl-md-4 pr-md-4">
                      <h5 class="modal-title">{{__('popupCarComparison.mySavedAds')}}</h5>
                      <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body comp-modal-body pl-md-4 pr-md-4 pb-4">
                      <div class="bg-white">
                         @if(Auth::guard('customer')->user() == null)
                         <div class="overflow-auto p-4 saved-cars">
                          <p><b>{{__('popupCarComparison.notLoggedIn')}} </b> <a href="{{url('user/login')}}" style="color: blue;text-decoration: underline;">{{__('popupCarComparison.clickHereToLogin')}}</a></p>
                        @else
                        <div class="overflow-auto p-4 saved-cars1">
                        @endif  
                        </div>
                        
                      </div>
                     {{--  <div class="comp-url mt-4  mt-md-5">
                        <h5 class="mb-3">URL</h5>
                        <span class="bg-white p-3 d-block">https://www.carish.com/used-cars/compare/carname</span>
                      </div> --}}
                      <div class="text-center mt-4  mt-md-5">
                        <button type="button" class="btn themebtn3 compare_btn">{{__('popupCarComparison.buttonText')}}</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

                <!-- Modal -->
              <div class="modal fade" id="savedCarAd2" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content sects-bg">
                    <div class="modal-header border-bottom-0 pl-md-4 pr-md-4">
                      <h5 class="modal-title">{{__('popupCarComparison.mySavedAds')}}</h5>
                      <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body comp-modal-body pl-md-4 pr-md-4 pb-4">
                      <div class="bg-white">
                        @if(Auth::guard('customer')->user() == null)
                         <div class="overflow-auto p-4 saved-cars">
                          <p><b>{{__('popupCarComparison.notLoggedIn')}} </b> <a href="{{url('user/login')}}" style="color: blue;text-decoration: underline;">{{__('popupCarComparison.clickHereToLogin')}}</a></p>
                          @else
                        <div class="overflow-auto p-4 saved-cars2">
                          @endif
                        </div>
                        
                      </div>
                   {{--    <div class="comp-url mt-4  mt-md-5">
                        <h5 class="mb-3">URL</h5>
                        <span class="bg-white p-3 d-block">https://www.carish.com/used-cars/compare/carname</span>
                      </div> --}}
                      <div class="text-center mt-4  mt-md-5">
                        <button type="button" class="btn themebtn3 compare_btn">{{__('popupCarComparison.buttonText')}}</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </form>
          </div>
          <div class="comparison-ad mt-md-5 mt-4">
            <img src="{{url('public/assets/img/comparison-ad.jpg')}}" class="img-fluid">
          </div>
          <div class="comp-about-bg bg-white border p-md-4 p-3 mt-md-5 mt-4 f-size1">
            <h2 class="mb-2">{{@$page_description->title}}</h2>
            <p>{!!@$page_description->description!!}</p>
          </div>
        </div>
      </div>    
@endsection