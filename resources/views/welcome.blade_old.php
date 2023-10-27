@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css" media="screen">
ul.ui-autocomplete {
    z-index: 1100;
}   
    .box-shadow{
        height: 260px !important;
    }

    .bootstrap-select > .dropdown-menu{
      height: 250px;
      max-height: 250px !important;
    }
    ul.ui-menu{
      height: 250px;
      max-height: 250px !important;
      /*overflow: scroll;*/
      overflow-y: scroll;
    }
  </style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"> 
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" charset="utf-8" defer>
/*###########################################################*/
 /* $.ajax({
            url: "{{route('get.tags')}}/",
            method: "get",
            success: function (data) {  
              $('#tags').html(data);
            }
        });*/
/*###########################################################*/   
$(document).ready(function ()
  { 
    $( "#car_make_model" ).autocomplete({
      source: function( request, response ) {
        $.ajax( {
          url: "{{route('getmakers.versions')}}/",
          dataType: "json",
          data: {
            term: request.term
          },
          success: function( data ) {
            response( data );
          }
        } );
      }, 
  select: function (event, ui) { 
    $("#make_models").val(ui.item.id);
    var selected_value = ui.item.id;
    var nameArr = selected_value.split('#');
    var search_type_array = nameArr[0].split('_');
    $("#make_models_combine").val('');
    if(search_type_array[0] == 'mo'){
      $("#make_models_combine").val(ui.item.make);
      $("#make_models").val('mo_'+search_type_array[1]); 
    }
    /* console.log(search_type_array); */ 
  }
    });
/*###########################################################*/

     $( "#car_make_model2").autocomplete({
      source: function( request, response ) {
        $.ajax( {
          url: "{{route('getmakers.versions')}}/",
          dataType: "json",
          data: {
            term: request.term
          },
          success: function( data ) {
            response( data );
          }
        } );
      }, 
  select: function (event, ui) { 
    var selectedValue = ui.item.id;
    $("#make_models2").val(selectedValue);

    var nameArr = selectedValue.split('#');
    var search_type_array = nameArr[0].split('_');
    $("#make_models_combine2").val('');
    if(search_type_array[0] == 'mo'){
      $("#make_models_combine2").val(ui.item.make);
      $("#make_models2").val('mo_'+search_type_array[1]); 
    }

      $.ajax({
            url: "{{url('get_versions')}}/"+selectedValue,
            method: "get",
            success: function (data) {  
              $("#selectVersion").html(data); 
            }
        });

  }
    });

/*###########################################################*/
            $('header.header').addClass('home-header');   
/*###########################################################*/
               
                $(".selectCity").select2({ 
                ajax: {
                url: "{{route('get.cities', ['type' => 'ct'])}}/",
                dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                      return {
                        results: data
                      };
                    },
                    cache: true
                  },
                theme: 'bootstrap4',
                width: 'style',
                placeholder:"{{ __('home.registeredinanycity') }}",
                allowClear: Boolean($(this).data('allow-clear')),
              });
/*###########################################################*/
                 $("#selectCityReg").select2({ 
                ajax: {
                url: "{{route('get.cities', ['type' => 'ctreg'])}}/",
                dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                      return {
                        results: data
                      };
                    },
                    cache: true
                  },
                theme: 'bootstrap4',
                width: 'style',
                placeholder: $(this).attr('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
              });
/*###########################################################*/

              $(document).on("click","#search_btn", function (){
                var make_models = $("#make_models").val(); 
                  if(make_models == ''){
                    $("#make_models").attr('name', '');
                  }else{
                    $("#car_make_model").attr('name', '');
                  }

                $("#simple_search").submit(); 
            });

/*###########################################################*/
      $("#selectVersion_old").select2({ 
                ajax: {
                url: "{{route('get.versions')}}/",
                dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                      return {
                        results: data
                      };
                    },
                    cache: true
                  },
                theme: 'bootstrap4',
                width: 'style',
                placeholder: $(this).attr('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
              });
/*###########################################################*/
  $("#color").select2({ 
                ajax: {
                url: "{{route('get.colors')}}/",
                dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                      return {
                        results: data
                      };
                    },
                    cache: true
                  },
                theme: 'bootstrap4',
                width: 'style',
                placeholder: $(this).attr('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
              });
/*###########################################################*/
  $.ajax({
            url: "{{route('getcc.versions')}}/",
            method: "get",
            success: function (data) {   
              $('#engineccFrom').append(data);
              $('#engineccTo').append(data);
              
            }
        });

   $.ajax({
            url: "{{route('getbody.types')}}/",
            method: "get",
            success: function (data) {   
              $('#body_type').append(data);               
            }
        });

   /* NEW SEARCH STRING */
    $(".search_check_submit").click(function(e) { 
        if(e.preventDefault){
            e.preventDefault();
        } 
            var baseUrl = "{{url('/')}}";
            var datavars = []; 
            $('input.search_check_submit:checkbox:checked').each(function () { 
                var str = $(this).data("value"); 
                //var res = str.split("_"); // this returns an array
                //datavars[res[0]] = res[1];  
                datavars.push(str);
            });

           $(".search_text_submit").each(function () {
            if($(this).val() != ''){
              //var search_text_submit  = $(this).data("value");
              str = $(this).val()
              datavars.push(str);
            }
             });

           $(".search_selectbox_submit option:selected").each(function () { 
            if($(this).val() != ''){ 
              str = $(this).val();
              datavars.push(str);
            }
             });

          var minPrice = $("#minPrice" ).val();
          var maxPrice = $("#maxPrice" ).val();
          if(minPrice != '' || maxPrice != ''){     
              var minPrice = parseInt(minPrice.replace(/\D/g,''))*100000;
              var maxPrice = parseInt(maxPrice.replace(/\D/g,''))*100000;
              var price    = 'price_'+minPrice+'-'+maxPrice;
              datavars.push(price);
        }

          var fromMillage = $("#fromMillage option:selected" ).val();
          var toMillage = $("#toMillage option:selected" ).val();
          if(fromMillage != '' || toMillage != ''){
            var millage = 'millage_'+fromMillage+'-'+toMillage;            
            datavars.push(millage);
          }

          var engineccFrom = $("#engineccFrom option:selected").val();
          var engineccTo   = $("#engineccTo option:selected").val(); 
          if(engineccFrom != '' || engineccTo != ''){
            var enginecc   = 'enginecc_'+engineccFrom+'-'+engineccTo;            
            datavars.push(enginecc);
          }

          var yearFrom = $("#yearFrom option:selected" ).val();
          var yearTo    = $("#yearTo option:selected" ).val();
          if(yearFrom != '' || yearTo != ''){
            var year    = 'year_'+yearFrom+'-'+yearTo;            
            datavars.push(year);
          }
           var tags = $("#tags").val();
           if(Array.isArray(tags) && tags.length > 0 && tags[0] != null){
              tags = tags.filter(Boolean);
              tags = '/'+tags.join([separator = '/']);
           }else
           {
            tags = '';
           }
          /*var bodyType   = $("#search_selectbox_submit option:selected").val(); 
          if(bodyType != '' || bodyType != '0'){          
            datavars.push(bodyType);
          }array = array.filter(Boolean);
          var filtered = datavars.filter(function (el) {
            return el != null;
          }); */
          datavars = datavars.filter(Boolean); 
          if(Array.isArray(datavars) && datavars.length > 0 && datavars[0] != null){
            var search_url = baseUrl+'/search/list/'+datavars.join([separator = '/'])+ tags;
            window.location.href = search_url; 
          }
        });


/*############################ CAR COMPARE SCRIPT .###############################*/ 
    $(document).on("click","#ads_first_text",function(){
      var ads_second = $("#ads_second").val();
       $.ajax({
          url: "{{route('get.ads.compared')}}/",
            method: "get",
            data : {excludedAd: ads_second},
              success: function (data) {
                var car1 = ''; 
                 $.each(data, function(keys,values) {
                    car1 += '<div class="align-items-center media mb-3"><img class="mr-3 saved-adImg" src="{{asset("public/assets/img/saved-ad.jpg")}}" alt="Generic placeholder image"><div class="media-body"><h5 class="mb-0"> <a href="JavaScript:void(0);" class="themecolor select-for-compare1" data-value="'+values.ads_id+'" data-text="'+values.make_name+' '+values.model_name+' '+values.version_label+'CC '+values.engine_power+'KW ' +values.from_date+'-'+values.to_date+'">'+values.make_name+' '+values.model_name+' '+values.version_label+'CC '+values.engine_power+'KW ' +values.from_date+'-'+values.to_date+'</a></h5></div></div>';
               });
               $('.saved-cars1').html(car1);
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
            dataType: "json",
            data : {excludedAd: ads_first},
              success: function (data) {
                var car2 = '';
                 $.each(data, function(keys,values) { 
                 car2 += '<div class="align-items-center media mb-3"><img class="mr-3 saved-adImg" src="{{asset("public/assets/img/saved-ad.jpg")}}" alt="Generic placeholder image"><div class="media-body"><h5 class="mb-0"> <a href="JavaScript:void(0);" class="themecolor select-for-compare2" data-value="'+values.ads_id+'" data-text="'+values.make_name+' '+values.model_name+' '+values.version_label+'CC '+values.engine_power+'KW ' +values.from_date+'-'+values.to_date+'">'+values.make_name+' '+values.model_name+' '+values.version_label+'CC '+values.engine_power+'KW ' +values.from_date+'-'+values.to_date+'</a></h5></div></div>';

               }); 
                $('.saved-cars2').html(car2); 
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
                 $.each(data, function(keys,values) {
                 car1 += '<div class="align-items-center media mb-3"><img class="mr-3 saved-adImg" src="{{asset("public/assets/img/saved-ad.jpg")}}" alt="Generic placeholder image"><div class="media-body"><h5 class="mb-0"> <a href="JavaScript:void(0);" class="themecolor select-for-compare1" data-value="'+values.ads_id+'" data-text="'+values.make_name+' '+values.model_name+' '+values.version_label+'CC '+values.engine_power+'KW ' +values.from_date+'-'+values.to_date+'">'+values.make_name+' '+values.model_name+' '+values.version_label+'CC '+values.engine_power+'KW ' +values.from_date+'-'+values.to_date+'</a></h5></div></div>';

                 car2 += '<div class="align-items-center media mb-3"><img class="mr-3 saved-adImg" src="{{asset("public/assets/img/saved-ad.jpg")}}" alt="Generic placeholder image"><div class="media-body"><h5 class="mb-0"> <a href="JavaScript:void(0);" class="themecolor select-for-compare2" data-value="'+values.ads_id+'" data-text="'+values.make_name+' '+values.model_name+' '+values.version_label+'CC '+values.engine_power+'KW ' +values.from_date+'-'+values.to_date+'">'+values.make_name+' '+values.model_name+' '+values.version_label+'CC '+values.engine_power+'KW ' +values.from_date+'-'+values.to_date+'</a></h5></div></div>';

               });
              $('.saved-cars1').html(car1);
              $('.saved-cars2').html(car2);

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
    var ads_second = $(this).data('value');
    var ads_second_text = $(this).data('text');
    $('#ads_second').val(ads_second);
     $('#ads_second_text').val(ads_second_text);
    $('#savedCarAd2').modal('hide');
  });


$(document).on("click",".compare_btn",function(){
  $('#compare_form').submit();
  });

  });
</script>
        
@endpush
@section('content') 
 <!-- header Ends here -->
        <div class="banner text-center text-white" style="background-image: url({{ asset('public/assets/img/banner.jpg')}});">
          <div class="container">
            <div class="row">
              <div class="col-12 search-form-col">
                <h1 class="font-weight-semibold">{{ __('home.nowfindyourdreamcarin') }} a Estonia</h1>
                {{-- <form action="{{url('search',['true'])}}" method="get" id="simple_search"> --}}
                  <div class="form-row form-search-row text-left justify-content-center mb-md-3">
                    <div class="col-12 col-lg-5 form-group pr-0 searchcol"> 
                       {{-- <select  name="car_make_model" id="car_make_model1"> 
                              </select> --}} 
                      <input type="text" id="car_make_model" name="q" data-value="q_" value="" placeholder="{{__('common.make')}}/{{__('common.model')}}" class="form-control">
                      <input type="hidden" id="make_models_combine" class="search_text_submit" data-value="m0_" value="">
                      <input type="hidden" name="car_make_model" id="make_models" class="search_text_submit" data-value="mk_" value="">
                      <input type="hidden" name="" id="make_models_version" value=""  class="search_text_submit" >
                            </div>
                    <div class="col-lg-3 col-12 form-group selectCol pl-0 pr-0 selectfieldcol farooq">
                        {{--  <select class="selectpicker search_selectbox_submit selectCity" data-live-search="true" name="selectCity1" id="selectCityGroup">
                          <option value="">{{__('home.all_cities')}}</option> 
                        </select> --}}
                         {{-- <select class="selectpicker " data-live-search="true"  name="selectCity"> --}}
                         {{--  <select name="selectCity" class="selectpicker form-control select2-field search_text_submit selectCity"> 
                            <option value="">{{__('home.all_cities')}}</option> 
                              </select> --}}

                        <select class="selectpicker search_text_submit" data-live-search="true">
                          <option value="" selected >{{__('home.all_cities')}}</option>
                          @foreach($cities as $city)
                        <option value="ct_{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 col-12 form-group selectCol
                     pl-0 pr-0 selectfieldcol" >
                    <select class="selectpicker" multiple name="tags[]" id="tags">
                      <option value="">Select Tags</option>
                       @if (!$tags->isEmpty()) {
                          @foreach($tags as $tag){ 
                                <option value="tg_{{$tag->code}}">{{$tag->name}}</option>
                                @endforeach
                        @endif
                    </select>

                    </div>
                    <div class="form-group pl-0 searchsubmit">
                      <button type="button" value="Search" class="btn fa fa-search searchBtn themebtn3 search_check_submit"></button>
                    </div>
                  </div>
                {{-- </form> --}}
                  <div class="form-row advanceSearch text-center justify-content-end">
                    <div class="col-12 advSearchCol pl-0 overflow-hidden text-center">
                      <a href="javascript:void(0)" class="btn font-weight-normal px-5 text-nowrap" data-toggle="modal" data-target="#advanceSearch">{{ __('home.advanced_search') }} <em class="fa fa-angle-right ml-1"></em></a>
                    </div>
                  </div>
                  <!-- Modal -->
                  <div class="modal text-left fade advSearch" id="advanceSearch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                         <form action="{{url('search',['true'])}}" method="get" id="simple_search">
                        <div class="modal-header pb-2 pt-2">
                          <h5 class="modal-title" id="exampleModalLongTitle">{{ __('home.advanced_search') }}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body  pl-md-4 pr-md-4 pt-4">
                          <div class="form-row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group"> 
                              <input type="text" name="car_make_model" id="car_make_model2"  class="form-control"  placeholder="{{__('common.make')}}/{{__('common.model')}}" > 
                              <input type="hidden" id="make_models_combine2" class="search_text_submit"> 
                              <input type="hidden" id="make_models2" class="search_text_submit"> 
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                              
                              <select name="selectVersion" id="selectVersion" class="form-control search_selectbox_submit">
                               <option value="">{{ __('home.versions') }}</option>
                              </select>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
     
                                <span class="align-items-center border d-block d-flex pricerange px-3 py-1">
                                  <div class="select-prng">{{ __('home.price_range') }}</div>
                                  <div class="pr-range-min" style="display: none"></div>
                                  <div class="pr-range-dash px-1" style="display: none">-</div>
                                  <div class="pr-range-max" style="display: none"></div>
                                </span>
                                <div class="pr-dropdown" style="display: none">
                                  <div class="d-flex">
                                  <div class="p-2 pr-min">
                                    <input type="text" name="minPrice" id="minPrice" placeholder="Min" class="form-control form-control-sm mb-2" autocomplete="off">
                                    <ul class="min-price-list list-unstyled mb-0" style="display: none;">
                                      @for($i = 5;$i<=30;$i+=5)
                                         <li>{{$i}} Lacs</li>  
                                      @endfor
                                      
                                    </ul>
                                  </div>
                                  <div class="p-2 pr-max">
                                    <input type="text" name="maxPrice" id="maxPrice" placeholder="Max" class="form-control form-control-sm mb-2" autocomplete="off" value="">
                                     <ul class="max-price-list list-unstyled mb-0" style="display: none;">
                                      @for($i = 5;$i<=30;$i+=5)
                                         <li>{{$i}} Lacs</li>  
                                      @endfor
                                    </ul>
                                  </div>
                                </div>
                                </div> 
                              </div> 


                              {{-- END DROP DOWN ENDS HERE--}}
                            </div>
  
                          <div class="form-row mt-4 pt-sm-2 collapse show" id="moreCollapsedFields"> 
                            
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                              <label class="font-weight-semibold">{{ __('home.year') }}</label>
                              <div class="form-row">
                                <div class="col-lg-6 col-md-6 col-6 pr-0 form-group mb-0 selectFromCol">
                                  <select id="yearFrom" class="form-control" >
                                    <option value="">{{ __('home.from') }}</option>
                                       @foreach(range(1979, date('Y')) as $i)
                                    <option value="{{$i}}">{{$i}}</option> 
                                    @endforeach
                                  </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-6 pl-0 form-group mb-0 selectToCol">
                                  <select name="selectYearTo" id="yearTo" class="form-control">
                                    <option value="">{{ __('home.to') }}</option>
                                      @foreach(range(date('Y'), date('Y')-79) as $i)
                                    <option value="{{$i}}">{{$i}}</option> 
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              
                            </div>
                         

                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                              <label class="font-weight-semibold">{{ __('home.engine_capacity') }}</label>
                              <div class="form-row">
                                <div class="col-lg-6 col-md-6 col-6 pr-0 form-group mb-0 selectFromCol">
                                  <select name="CapacityFrom" id="engineccFrom" class="form-control">
                                    <option value="">{{ __('home.from') }}</option>
                                  </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-6 pl-0 form-group mb-0 selectToCol">
                                  <select name="CapacityTo" id="engineccTo" class="form-control">
                                    <option value="">{{ __('home.to') }}</option>
                                    
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                              <label class="font-weight-semibold">{{ __('home.mileage') }}</label>
                              <div class="form-row">
                                <div class="col-lg-6 col-md-6 col-6 pr-0 form-group mb-0 selectFromCol">
                                  <select name="MileageFrom" id="fromMillage" class="form-control">
                                    <option value="">{{ __('home.from') }}</option>
                                    <option value="10000">10,000 km</option>
                                    <option value="20000">20,000 km</option>
                                    <option value="30000">30,000 km</option>
                                    <option value="40000">40,000 km</option>
                                    <option value="50000">50,000 km</option>
                                    <option value="60000">60,000 km</option>
                                    <option value="70000">70,000 km</option>
                                    <option value="80000">80,000 km</option>
                                    <option value="90000">90,000 km</option>
                                    <option value="100000">100,000 km</option>
                                    <option value="125000">125,000 km</option>
                                    <option value="150000">150,000 km</option>
                                    <option value="175000">175,000 km</option>
                                    <option value="200000">200,000 km</option>
                                  </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-6 pl-0 form-group mb-0 selectToCol">
                                  <select name="MileageTo" id="toMillage" class="form-control">
                                    <option value="">{{ __('home.to') }}</option>
                                    <option value="10000">10,000 km</option>
                                    <option value="20000">20,000 km</option>
                                    <option value="30000">30,000 km</option>
                                    <option value="40000">40,000 km</option>
                                    <option value="50000">50,000 km</option>
                                    <option value="60000">60,000 km</option>
                                    <option value="70000">70,000 km</option>
                                    <option value="80000">80,000 km</option>
                                    <option value="90000">90,000 km</option>
                                    <option value="100000">100,000 km</option>
                                    <option value="125000">125,000 km</option>
                                    <option value="150000">150,000 km</option>
                                    <option value="175000">175,000 km</option>
                                    <option value="200000">200,000 km</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 form-group mb-0">
                              <label class="font-weight-semibold">{{ __('home.other_details') }}</label>
                              <div class="form-row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                              <select name="selectCity" id="selectCity" class="form-control select2-field search_text_submit selectCity"> 
                              <option value="">{{ __('home.registeredinanycity') }}</option> 
                              </select>
                            </div>
                                   <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                              {{-- <label class="font-weight-semibold">{{ __('home.engine_details') }}</label> --}}

                              <select id="engine_type" name="engine_type" class="form-control search_selectbox_submit">
                                <option value="">{{ __('home.all_engine_types') }}</option>
                                <option value="fuel_CNG">CNG</option>
                                <option value="fuel_Diesel">Diesel</option>
                                <option value="fuel_Hybrid">Hybrid</option>
                                <option value="fuel_LPG">LPG</option>
                                <option value="fuel_Petrol">Petrol</option>
                              </select>
                            </div>

                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group search_selectbox_submit">
                                  <select id="body_type" name="body_type" class="form-control">
                                    <option value="">{{ __('home.all_body_types') }}</option> 
                                  </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                  <select name="color" id="color" class="form-control search_selectbox_submit"> 
                                    <option value="">{{ __('home.all_body_colors') }}</option>
                                  </select>
                                </div> 
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                  <select id="assembly" name="assembly" class="form-control search_selectbox_submit">
                                    <option value="">{{ __('home.allassemblytypes') }}</option>
                                    <option value="assembly_Local">{{ __('home.local') }}</option>
                                    <option value="assembly_Imported">{{ __('home.imported') }}</option>
                                  </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                  <select id="transmission" name="transmission" class="form-control search_selectbox_submit">
                                    <option value="">{{ __('home.alltransmissiontypes') }}</option>
                                    <option value="transmission_Automatic">{{ __('home.automatic') }}</option>
                                    <option value="transmission_Manual">{{ __('home.manual') }}</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 form-group mb-0">
                              <label class="font-weight-semibold">{{ __('home.all_properties') }}</label>
                              <div class="form-row">
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                  <select id="picture" name="have_picture" class="form-control search_selectbox_submit">
                                    <option value="">{{ __('home.without_picture') }} </option>
                                    <option value="pic_Having Pictures">{{ __('home.with_picture') }} </option>
                                  </select>
                                </div>
                        {{--<div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                  <select id="ads_type" name="ads_type" class="form-control">
                                    <option value="">{{ __('home.all_seller_types') }} </option>
                                    <option value="2">{{ __('home.dealers_only') }} </option>
                                    <option value="1">{{ __('home.private_sellers_only') }} </option>
                                  </select>
                                </div> --}}
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                  <select id="featured" name="is_featured" class="form-control search_selectbox_submit">
                                    <option value="">{{__('home.all_ad_types')}}</option>
                                    <option value="isf_featured">{{ __('home.featured_ads_only') }}</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="align-items-center border-top-0 d-flex justify-content-between modal-footer pb-4 pl-md-4 pr-md-4 pt-0">
                          <a class="LessMoreOptions font-weight-semibold themecolor" data-toggle="collapse" href="#moreCollapsedFields" aria-expanded="true" aria-controls="moreCollapsedFields">
                            <span class="moreFields">{{ __('common.more') }}</span> <span class="lessFields">{{ __('common.less') }}</span>{{ __('home.search_options') }}  <em class="fa fa-angle-down"></em>
                          </a>
                          <button type="submit" class="btn themebtn3 search_check_submit">{{ __('common.search') }}</button>
                        </div>
                      </form> {{-- END OF ADVANCE SEARCH FORM  --}}
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
      </div>
     <!-- features Starts here -->
      <div class="container mt-5 mb-sm-5 d-md-block d-none">
        <div class="row servicesRow text-center">
          <div class="col-sm-4 col-md-4 col-12 pl-xl-4 pr-xl-4 servicesCol mb-4 mb-sm-0">
            <img src="{{ asset('public/assets/img/feature-1.png')}}" class="img-fluid mb-2 mb-md-3" alt="carish used cars for sale in estonia">
            <h5 class="font-weight-bold themecolor">* {{ __('home.free_ad') }}</h5>
            <p>{{ __('home.post_your_car_ad') }} <a target="" href="{{route('post')}}" class="themecolor"><u>{{ __('home.for_free') }}</u></a> {{ __('home.in_few_seconds') }} </p>


<!-- Post you car ad for free( make for free text a link where after click we will revert user to more page with free post ad policy ) in few seconds -->
          </div>
          <div class="col-sm-4 col-md-4 col-12 pl-xl-4 pr-xl-4 servicesCol mb-4 mb-sm-0">
            <img src="{{ asset('public/assets/img/feature-2.png')}}" class="img-fluid mb-2 mb-md-3" alt="carish used cars for sale in estonia">
            <h5 class="font-weight-bold themecolor">{{ __('home.genuine_buyers') }}</h5>
            <p>{{ __('home.get_authentic_offers') }}</p>
          </div>
          <div class="col-sm-4 col-md-4 col-12 pl-xl-4 pr-xl-4 servicesCol mb-4 mb-sm-0">
            <img src="{{ asset('public/assets/img/feature-3.png')}}" class="img-fluid mb-2 mb-md-3" alt="carish used cars for sale in estonia">
            <h5 class="font-weight-bold themecolor">{{ __('home.sell_faster') }}</h5>
            <p>{{ __('home.sell_your_carfaster') }}</p>
          </div>
        </div>
      </div>
      <!-- features Ends here -->


        <!-- Browse Used Cars Starts here -->
      <div class="browse-used-cars pb-4 pt-md-5 pt-4 sects-bg">
        <div class="container">
          <div class="section-title mb-4">
            <h4 class="sectTitle font-weight-semibold mb-0">{{ __('home.browse_used') }} <span>{{trans_choice('common.cars', 1)}}</span></h4>
          </div>
          <div class="row b-UsedCars-row">
            <div class="col-12 buCars">
              <ul class="nav nav-tabs buCarTabs">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#buCars-tab1">{{ __('common.make') }}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#buCars-tab2">{{ __('common.model') }}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#buCars-tab3">{{ __('home.body_type') }}</a>
                </li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">

                <div class="tab-pane p-4 browse-cb active" id="buCars-tab1">
                <div class="owl-carousel owl-theme text-center" id="browse-cb-make">
                   <div class="item">
                      <div class="row">
                        @if($car_makes->count() > 0)
                        @php $i = 0; @endphp
                        @foreach($car_makes as $make)
                        <div class="col-lg-3 col-md-3 col-sm-3 col-4 bucSliderCol mb-4">
                          <figure class="align-items-center d-flex justify-content-center">
                            <img src="{{asset('public/uploads/image/'.@$make->image)}}" class="img-fluid" alt="carish used cars for sale in estonia">
                          </figure>
                          <h5 class="font-weight-normal"><a target="" href="{{route('simple.search')}}/list/mk_{{@$make->title}}" class="stretched-link">{{@$make->title}}</a></h5>
                        </div>
                        @php $i++; @endphp
                        @if($i == 8)
                      </div>
                    </div>
                     <div class="item">
                      <div class="row">
                        @php $i = 0; @endphp
                        @endif
                        @endforeach
                        @endif
                      </div>
                  </div>
                </div>
              </div>
                <!-- tab one ends here -->
                <!-- tab one starts here -->
                <div class="tab-pane p-4" id="buCars-tab2">
                  <div class="owl-carousel bucSlider btSlider text-center">
                   <div class="item">
                      <div class="row">
                        @if(@$car_models != null)
                        @php $i = 0; @endphp
                        @foreach($car_models as $model)
                        <div class="col-lg-2 col-md-2 col-sm-3 col-4 mb-md-4 mb-3 bucModalCol">
                      <a target="" href="{{route('simple.search')}}/list/mo_{{$model->name}}">{{$model->name}}</a>
                    </div>
                        @php $i++; @endphp
                        @if($i == 30)
                      </div>
                    </div>
                     <div class="item">
                      <div class="row">
                        @php $i = 0; @endphp
                        @endif
                        @endforeach
                        @endif
                      </div>
                  </div>
                </div>
              
                </div>
                <!-- tab one ends here -->
                <!-- tab one starts here -->
                <div class="tab-pane" id="buCars-tab3">
                    <div class="owl-carousel owl-theme bucSlider btSlider text-center">
                    <div class="item">
                      <div class="row">
                         @if($bodytypes->count() > 0)
                        @php $i = 0; @endphp
                        @foreach($bodytypes as $body)
                        <div class="col-lg-3 col-md-3 col-sm-3 col-4 bucSliderCol mb-4">
                          <figure class="align-items-center d-flex justify-content-center">
                            <img src="{{asset('public/uploads/image/'.@$body->image)}}" class="img-fluid" alt="carish used cars for sale in estonia">
                          </figure>
                          <h5 class="font-weight-normal"><a target="" href="{{route('simple.search')}}/list/bt_{{@$body->name}}" class="stretched-link">{{@$body->name}}</a></h5>
                        </div>
                        @php $i++; @endphp
                        @if($i == 8)
                      </div>
                    </div>
                     <div class="item">
                      <div class="row">
                        @php $i = 0; @endphp
                        @endif
                        @endforeach
                        @endif
                    
                  </div>
              </div>
                  </div>
                </div>
                <!-- tab one starts here -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Browse Used Cars Ends here -->

        <!-- features Starts here -->
      <div class="featured-UsedCars mb-md-5 mt-md-5 mb-4 mt-4">
        <div class="container">
          <div class="section-title d-flex justify-content-between align-items-end">
            <h4 class="sectTitle font-weight-semibold mb-0">{{__('home.featured_used')}} <span>{{trans_choice('cars',0)}}</span></h4>
            <a target="" href="{{route('simple.search')}}/list/isf_featured" class="viewall-post themecolor">{{__('home.viewallfeaturedusedcars')}}</a>
          </div>
          <div class="owl-carousel owl-theme featured-uc-slider text-center"  id="feat-UsedCars">
          @foreach($featured_ads as $featured_ad)
            <div class="item">
              <div class="box-shadow">
                <figure class="mb-0 position-relative text-left">
                @if(@$featured_ad->ads_images[0]->img)
                  <div class="bgImg" style="background-image: url({{asset('public/uploads/ad_pictures/cars/'.$featured_ad->id.'/'.$featured_ad->ads_images[0]->img)}})"></div>
                  @else
                  <div class="bgImg" style="background-image: url({{ asset('public/assets/img/car_avatar.png')}})"></div>
                  @endif
                  <figcaption class="position-absolute">
                  <span class="bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-uppercase text-white d-inline-block">{{__('home.featured')}}</span>
                  </figcaption>
                </figure>
                <div class="p-3">
                  <h5 class="font-weight-semibold mb-1"><a target="" href="{{url('car-details/'.$featured_ad->id)}}" class="stretched-link themecolor">{{$featured_ad->maker->title}} {{@$featured_ad->model->name}} {{$featured_ad->year}}</a></h5>
                  <p class="car-price mb-1">${{$featured_ad->price}}</p>
                  <span class="car-country">{{$featured_ad->bought_from}}</span>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
      <!-- features Ends here -->
      <!-- Cars Comparison Starts here -->
      <div class="cars-comparison pb-md-5 pt-md-5 pb-4 pt-4 sects-bg">
        <div class="container">
          <div class="section-title mb-md-4 pb-1">
            <h4 class="sectTitle font-weight-semibold mb-0"><span>{{trans_choice('cars',0)}}</span> {{__('home.comparison')}}</h4>
          </div>
          <div class="ml-0 mr-0 row">
            <div class="col-lg-8 col-md-8 col-12 pl-4 pr-4 comparison-col bg-white">
              <h4 class="mb-lg-4 mb-md-3 mb-4 pb-xl-3">{{__('home.confuseinselection')}} <span class="font-weight-normal">{{__('home.letsmake_comparision')}}</span></h4>
              <form  method="post" action="{{route('comparedetails')}}" id="compare_form">
                 {{csrf_field()}}
              <div class="d-sm-flex mx-0">
                <div class="form-group w-100">
                  <label class="font-weight-semibold">{{__('home.select_car')}}-1</label>
                  <input type="text" name="" placeholder="Car Make/Model/Version" class="border-dark form-control" id="ads_first_text"  autocomplete="off"  required>
                <input type="hidden" name="compared_cars[]" id="ads_first" value=""  required>
              
                </div>
                <div class="comparsn-logo mb-3 mt-auto px-3 text-center">
                  <span class="d-inline-block font-weight-bold rounded-circle themebtn1">VS</span>
                </div>
                <div class="form-group w-100">
                  <label class="font-weight-semibold">{{__('home.select_car')}}-2</label>
                  <input type="text" name="" placeholder="Car Make/Model/Version" class="border-dark form-control" id="ads_second_text" autocomplete="off" required>
                    <input type="hidden" name="compared_cars[]" id="ads_second" value=""  required>
                </div>
              </div>
              <div class="form-row">
                <div class="align-items-center col-12 d-flex form-group justify-content-between mt-lg-4 mt-2 mb-0">
                  <div class="comp-clear">
                    <a href="javascript:void(0)" class="font-weight-semibold themecolor">{{__('home.clear')}}</a>
                  </div>
                  <div class="comp-submit">
                    <input type="submit" value="Submit" class="btn text-uppercase themebtn3">
                  </div>
                </div>
              </div>
              <!-- Modal for car1 -->
              <div class="modal fade" id="savedCarAd" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content sects-bg">
                    <div class="modal-header border-bottom-0 pl-md-4 pr-md-4">
                      <h5 class="modal-title">{{__('home.my_saved_ads')}} </h5>
                      <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body comp-modal-body pl-md-4 pr-md-4 pb-4">
                      <div class="bg-white">
                        <div class="overflow-auto p-4 saved-cars saved-cars1">

                        </div>
                        
                      </div>
                      <div class="comp-url mt-4  mt-md-5">
                        <h5 class="mb-3">URL</h5>
                        <span class="bg-white p-3 d-block">https://www.carish.com/used-cars/compare/carname</span>
                      </div>
                      <div class="text-center mt-4  mt-md-5">
                        <button type="button" class="btn themebtn3 compare_btn">{{__('home.compare')}}</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              {{-- MODAL FOR CAR 2 --}}

                <div class="modal fade" id="savedCarAd2" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content sects-bg">
                    <div class="modal-header border-bottom-0 pl-md-4 pr-md-4">
                      <h5 class="modal-title">{{__('home.my_saved_ads')}} </h5>
                      <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body comp-modal-body pl-md-4 pr-md-4 pb-4">
                      <div class="bg-white">
                        <div class="overflow-auto p-4 saved-cars saved-cars2">

                        </div>
                        
                      </div>
                      <div class="comp-url mt-4  mt-md-5">
                        <h5 class="mb-3">URL</h5>
                        <span class="bg-white p-3 d-block">https://www.carish.com/used-cars/compare/carname</span>
                      </div>
                      <div class="text-center mt-4  mt-md-5">
                        <button type="button" class="btn themebtn3 compare_btn">{{__('home.compare')}}</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </form>
            </div>
            <div class="col-lg-4 col-md-4 col-12 mt-3 mt-md-0 carish-ad pl-md-3 pr-md-3 pl-0 pr-3 text-center">
              <img src="{{ asset('public/assets/img/carish-ad.jpg')}}" class="img-fluid" alt="carish used cars for sale in estonia">
            </div>
          </div>
        </div>
      </div>
      <!-- Cars Comparison Ends here -->
      <!-- LOOKING TO SELL YOUR CAR Starts here -->
      <div class="looking-sell-car pb-md-5 pt-md-5 pb-4 pt-4">
        <div class="container">
          <div class="align-items-center pl-xl-3 pr-xl-3 row sell-car-row">
            <div class="col-12 col-lg-6 col-md-6 pr-md-0 mb-3 mb-md-0 sell-car-col text-md-right text-center">
              <h4 class="font-weight-semibold mb-0 text-uppercase">{{__('home.looking_to_sell_your_car')}}</h4>
              <p class="mb-0">{{__('home.get_cash_offers_to_your')}}</p>
            </div>
            <div class="col-12 col-lg-6 col-md-6 pl-md-4 pl-lg-5 sell-car-btn">
              <a target="" href="{{ route('sellcar') }}" class="btn btn-block font-weight-normal text-uppercase themebtn1">{{__('home.submit_your_vehicle_now')}}</a>
            </div>
            <div class="arrowImg col-12 text-center d-md-block d-none">
              <img src="{{ asset('public/assets/img/postarrow.png')}}" class="img-fluid ml-5 pl-5" alt="carish used cars for sale in estonia">
            </div>
          </div>
        </div>
      </div>
      <!-- LOOKING TO SELL YOUR CAR? Ends here -->

      <!-- Popular Used Cars Starts here -->
      <div class="popular-UsedCars pb-md-5 pt-md-5 pb-4 pt-4 sects-bg">
        <div class="container">
          <div class="section-title d-flex justify-content-between align-items-end">
            <h4 class="sectTitle font-weight-semibold mb-0">{{__('home.used')}}  <span>{{trans_choice('common.cars',0)}}</span></h4>
            <a target="" href="{{route('simple.search')}}/list/isp_popular" class="viewall-post themecolor">
              {{__('home.view_all_used_cars')}}

            </a>
          </div>
          <div class="owl-carousel owl-theme popular-uc-slider text-center" id="pop-UsedCars">
          @foreach($ads as $ad)
            <div class="item">
              <div class="box-shadow bg-white p-3">
                <figure class="align-items-center d-flex justify-content-center">
                @if(@$ad->ads_images[0]->img)
                <img src="{{ asset('public/uploads/ad_pictures/cars/'.@$ad->id.'/'.$ad->ads_images[0]->img)}}" class="img-fluid" alt="carish used cars for sale in estonia">
                  @else
                  <img src="{{ asset('public/assets/img/car_avatar.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
                  @endif
                </figure>
                <h5 class="font-weight-semibold mb-1"><a target="" href="{{url('car-details/'.$ad->id)}}" class="stretched-link themecolor">{{$ad->maker->title}} {{@$ad->model->name}} {{$ad->year}}</a></h5>
              <p class="car-price mb-1">${{$ad->price}}</p>
                  <span class="car-country">{{$ad->bought_from}}</span>
                </div>
              </div>
            @endforeach
          
          </div>
        </div>
      </div>
      <!-- Popular Used Cars  Ends here -->
      <!-- Cars Parts & Accessories Starts here -->
      <div class="cars-parts-accessories my-md-5 my-4">
        <div class="container">
          <div class="section-title d-flex justify-content-between align-items-end">
            <h4 class="sectTitle font-weight-semibold mb-0"><span>{{trans_choice('common.cars',0)}}</span>
              {{__('home.parts_accessories')}}</h4>
          </div>
          <div class="owl-carousel owl-theme cars-parts text-center" id="cars-parts">
          @foreach($spare_parts_categories as $part_cat)
            <div class="item">
              <div class="box-shadow py-4 pl-3 pr-3">
                <figure class="align-items-center d-flex justify-content-center">
                  <img src="{{ asset('public/uploads/image/'.@$part_cat->image)}}" class="img-fluid" alt="carish used cars for sale in estonia">
                </figure>

                <h5 class="font-weight-semibold"><a target="" href="{{url('find_autoparts/listing/cat_'.$part_cat->id)}}" class="stretched-link">{{$part_cat->title}}</a></h5>

              </div>
            </div>
            @endforeach
          </div>
          
          <div class="text-center mt-4"><a target="" href="{{ route('findautoparts') }}" class="btn text-uppercase view-all-part">{{__('home.view_all')}}</a></div>
        </div>
      </div>
      <!-- Cars Parts & Accessories Ends here -->

      <!-- Services Starts here -->
      <div class="cars-parts-accessories pb-md-5 pt-md-5 sects-bg">
        <div class="container">
          <div class="section-title d-flex justify-content-between align-items-end">
            <h4 class="sectTitle font-weight-semibold mb-0"><span>{{__('home.offered')}}</span> {{__('home.services')}}</h4>
          </div>
          <div class="owl-carousel owl-theme offered-service text-center" id="offered-service">
          @foreach($offered_services as $offered_service)
            <div class="item">
              <div class="box-shadow py-4 pl-3 pr-3">
                <figure class="align-items-center d-flex justify-content-center">
                  <img src="{{ asset('public/uploads/image/'.@$offered_service->image)}}" class="img-fluid" alt="carish used cars for sale in estonia">
                </figure>
                <h5 class="font-weight-semibold"><a target="" href="{{url('allservices/listing/'.$offered_service->id)}}" class="stretched-link">{{$offered_service->title}}</a></h5>
              </div>
            </div>
            @endforeach
          </div>
          
          <div class="text-center mt-4"><a target="" href="{{ route('allservices') }}" class="btn text-uppercase view-all-part">{{__('home.view_all')}}</a></div>
        </div>
      </div>
      <!-- Services Ends here -->

        <!-- features Starts here -->
      <div class="pt-4 d-md-block pb-3" style="border: 3px solid #67b500;">
        <div class="container">
          <h3>Privacy Policy</h3>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
            <button class="themebtn3 btn btn-sm pull-right">Agree</button>
            </div>
          </div>
        </div>
      </div>
      <!-- features Ends here -->
@endsection
