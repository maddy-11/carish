@extends('layouts.app')
@section('title') {{ __('findUsedCars.pageTitle') }} @endsection
@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css" media="screen">
ul.ui-autocomplete {
    z-index: 1100;
} 
@media (max-width: 767px)
{
  .car-comparison-from
  {
    margin-top: 15px !important;
  }
}
</style>
@endpush
@push('scripts') 
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" charset="utf-8" async>
$('.selectpicker1').selectpicker();
/*###########################################################*/
/*###########################################################*/   
$(document).ready(function ()
  { 
    var searchUrl  = "{{route('simple.search')}}";
    var imagespath = "{{asset('public/uploads/image/')}}";

  var sorry_invalid_price_range = "{{ __('findUsedCars.invalidPriceRange') }}";

    $( "#car_make_model" ).autocomplete({
      source: function( request, response ) {
        $.ajax( {
          url: "{{route('getmakers.versions')}}",
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
    if(search_type_array[0] == 'mo'){
       $("#make_models").val('mo_'+search_type_array[1]);
       //$("#make_models_version").val('ver_'+nameArr[1]);
    }
    console.log(nameArr[1]); 
  }
    });
/*###########################################################*/

     $( "#car_make_model2").autocomplete({
      source: function( request, response ) {
        $.ajax( {
          url: "{{route('getmakers.versions')}}",
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
                url: "{{route('get.versions')}}",
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
$("#selectCity").select2({
  language: {
    searching: function() {
      return "{{__('findUsedCars.searching')}}";
    },
    noResults: function(){
      return "{{__('findUsedCars.noRecordFound')}}";
    }
  },
                ajax: {
                url: "{{route('get.cities', ['type' => 'ct'])}}",
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
    language: {
        searching: function() {
            return "{{__('findUsedCars.searching')}}";
        },
        noResults: function(){
           return "{{__('findUsedCars.noRecordFound')}}";
       }
    },
                ajax: {
                url: "{{route('get.colors')}}",
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
setTimeout(() => {
  $.ajax({
            url: "{{route('getcc.versions')}}",
            method: "get",
            success: function (data) {   
              $('#engineccFrom').append(data);
              $('#engineccTo').append(data);
              
            }
        });
/*###############################################*/
         $.ajax({
            url: "{{route('getkw.versions')}}",
            method: "get",
            success: function (data) {   
              $('#powerFrom').append(data);
              $('#powerTo').append(data);
            }
        });
/* ################################################## */
   $.ajax({
            url: "{{route('getbody.types')}}",
            method: "get",
            success: function (data) {   
              $('#body_type').append(data);               
            }
        });
/* #################################################### */        




}, 3000);

setTimeout(() => {
  
$.ajax({
            url: "{{route('fetch.cities')}}",
            method: "get",  
            success: function (response) { 
              $("#bcb-tab3").html(response);
            }
          });
/* ############################################################ */
$.ajax({ 
            url: "{{route('fetch.body.types')}}",
            method: "get",  
            success: function (response) {
               $('#bcb-tab4').html('<div class="owl-carousel owl-theme bucSlider btSlider text-center" id="body_types"></div>');
               var html = '<div class="item"><div class="row">';
               var j = 0;
            $.each(response.data, function( key, value ) {
              html += '<div class="col-lg-3 col-md-3 col-sm-3 col-4 bucSliderCol mb-4"><figure class="align-items-center d-flex justify-content-center"><img src="'+imagespath+'/'+value.image+'" class="img-fluid" alt="carish used cars for sale in estonia"></figure> <h5 class="font-weight-normal"><a target="" href="'+searchUrl+'/bt_'+value.name+'">'+value.name+'</a></h5></div>';
             j++;
                if(j == 8){
                 html += '</div></div><div class="item"><div class="row">';
                  j = 0;
              }// IF
           });
             html += '</div></div>';
 
           $("#body_types").append(html);
            var owl = $("#body_types");
                owl.owlCarousel({
                loop: false,
                margin: 15,
                nav: true,
                responsive: {
                    0: {
                        items: 1,
                    }
                }
});
            }
          });
/* ############################################### */ 
 $.ajax({
            url: "{{route('category.make.models')}}",
            method: "get", 
            dataType:'json', 
            success: function (response) {   
                $('#bcb-tab1').html('<div class="owl-carousel owl-theme text-center" id="browse-cb-categ">');
               var html = '<div class="item"><div class="row">';
               var i = 0;
               $.each( response.data, function( key, value ) {
                html += '<div class="col-lg-2 col-md-3 col-sm-3 col-4 bucSliderCol mb-4"><div class="makes-logos"><figure class="align-items-center d-flex justify-content-center"><img src="'+imagespath+'/'+value.make.image+'" class="img-fluid" alt="carish used cars for sale in estonia"></figure><h5><a target="" href="'+searchUrl+'/mk_'+value.make.title+'" >'+value.make.title+'</a></h5></div><div style="height:100px;overflow:auto;"><ul class="list-unstyled">';
                $.each(value.models, function( m, v ) { 
                  html += ' <li><a target="" href="'+searchUrl+'/mo_'+v+'">'+v+'</a></li>';
              });// END INNER FOREACH
                html  += '</ul></div></div>';
                i++;
                if(i==6){
                  i = 0;
                  html += '</div></div><div class="item"><div class="row">';
                }

               });// END FOR EACH
                html += '</div></div>';

              $("#browse-cb-categ").append(html);
              var owl = $("#browse-cb-categ");
                owl.owlCarousel({
                loop: false,
                margin: 15,
                nav: true,
                responsive: {
                    0: {
                        items: 1,
                    }
                } 
                });

        /*#############################################*/ 
          $('#bcb-tab2').html('<div class="owl-carousel owl-theme text-center" id="browse-cb-make">');
               var html = '<div class="item"><div class="row">';
               var i = 0;
               $.each( response.data, function( key, value ) {
                html += '<div class="col-lg-3 col-md-3 col-sm-3 col-4 bucSliderCol mb-4"><figure class="align-items-center d-flex justify-content-center"><img src="'+imagespath+'/'+value.make.image+'" class="img-fluid" alt="carish used cars for sale in estonia"></figure><h5 class="font-weight-normal"><a target="" href="'+searchUrl+'/mk_'+value.make.title+'" class="stretched-link">'+value.make.title+'</a></h5></div>';
                i++;
                if(i==8){
                  i = 0;
                  html += '</div></div><div class="item"><div class="row">';
                }

               });// END FOR EACH

                html += '</div></div>';
              $("#browse-cb-make").append(html);
              var owl = $("#browse-cb-make");
                owl.owlCarousel({
                loop: false,
                margin: 15,
                nav: true,
                responsive: {
                    0: {items: 1}
                    }
                    });

         /*####################################################################*/


            }
        }); 
}, 5000);
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
          if(minPrice != '' && maxPrice != ''){ 
          if(parseInt(minPrice) > parseInt(maxPrice))
          {
            alert(sorry_invalid_price_range);
            return false;
          }
        }

          if(minPrice != '' || maxPrice != ''){  
          var minPrice = parseInt(minPrice.replace(/\D/g,''));
          var maxPrice = parseInt(maxPrice.replace(/\D/g,''));   
              var price    = 'price_'+minPrice+'-'+maxPrice;
              datavars.push(price);
        }

          // var fromMillage = $("#fromMillage option:selected" ).val();
          var fromMillage = $("#fromMillage" ).val();
          // var toMillage = $("#toMillage option:selected" ).val();
          var toMillage = $("#toMillage" ).val();
          if(fromMillage > toMillage)
          {
            alert("{{ __('findUsedCars.invalidMileageRange') }}");
            return false;
          }
          if(fromMillage != '' || toMillage != ''){
            var millage = 'millage_'+fromMillage+'-'+toMillage;            
            datavars.push(millage);
          }
          var powerFrom = $("#powerFrom option:selected").val();
          var powerTo   = $("#powerTo option:selected").val(); 
          if(powerFrom != '' || powerTo != ''){
            var power   = 'power_'+powerFrom+'-'+powerTo;
            datavars.push(power);
          }             
           
          var engineccFrom = $("#engineccFrom option:selected").val();
          var engineccTo   = $("#engineccTo option:selected").val(); 
          if(engineccFrom != '' || engineccTo != ''){
            var enginecc   = 'enginecc_'+engineccFrom+'-'+engineccTo;            
            datavars.push(enginecc);
          }

          var yearFrom = $("#yearFrom option:selected" ).val();
          var yearTo    = $("#yearTo option:selected" ).val();
         /*  if(yearFrom > yearTo)
          {
            alert('Sorry! Invalid From and To Year');
            return false;
          } */
          if(yearFrom != '' || yearTo != ''){
            var year    = 'year_'+yearFrom+'-'+yearTo;            
            datavars.push(year);
          }
           /* var tags = $("#tags").val();
           if(Array.isArray(tags) && tags.length > 0 && tags[0] != null){
              tags = tags.filter(Boolean);
              tags = '/'+tags.join([separator = '/']);
           }else
           {
            tags = '';
           }
 */
             var tags = $("#tags").val();
        if (Array.isArray(tags) && tags.length > 0 && tags[0] != null) {
            for (var i = 0; i < tags.length; i++) {
                datavars.push(tags[i]);
            }
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
            var search_url = baseUrl+'/find-used-cars/'+datavars.join([separator = '/']);
            window.location.href = search_url; 
          }
        });
  });
</script>
@endpush
@section('content') 
 @php
    $activeLanguage = \Session::get('language');
 @endphp
   <div class="internal-page-content mt-4 sects-bg pb-0">
        <div class="bgcolcor bgcolor1 internal-banner text-white cc-page-banner">
          <div class="container">
            <h2 class="font-weight-semibold  mb-1">{{__('findUsedCars.pageTitle')}}</h2>
            <p class="mb-0">{{__('findUsedCars.pageTitleDetailedText')}}</p>
          </div>
        </div>
        <div class="container mt-n5 pt-2">
          <div class="comp-form-bg bg-white border p-4 car-comparison-from">
            <form action="{{url('search',['true'])}}" method="get" id="simple_search" class="pb-lg-1 pl-md-3 pr-lg-3 pt-lg-3">
              <div class="form-row">
                <div class="form-group col-md-4 col-sm-4 col-12"> 
                     
                  <input type="hidden" name="car_make_model" id="make_models" class="search_text_submit" data-value="mk_" value="">

                  <input type="text" name="car_make_model" id="car_make_model2"  class="form-control"  placeholder="{{__('findUsedCars.makeAndModel')}}" > 
                   
                  <input type="hidden" id="make_models_combine2" class="search_text_submit">

                  <input type="hidden" id="make_models2" class="search_text_submit">
                  <input type="hidden" class="search_text_submit"> 

                </div>
                <div class="form-group col-md-4 col-sm-4 col-12">
                   <select name="selectCity" id="selectCity" class="form-control search_text_submit selectCity"> 
                     <option value="">{{__('findUsedCars.city')}}</option> 
                    </select>
                </div>  
                <div class="form-group col-md-4 col-sm-4 col-12">
                    <select class="selectpicker1" multiple name="tags[]" id="tags">
                      <option value="">{{__('findUsedCars.selectTag')}}</option>
                       @if (!$tags->isEmpty()) {
                          @foreach($tags as $tag){ 
                                <option value="tg_{{$tag->id}}">{{$tag->name}}</option>
                                @endforeach
                        @endif
                    </select>
                </div>

              <div class="form-row mt-4 pt-sm-2 collapse" id="moreCollapsedFields">
                    {{-- SEARCH DROP DOWN --}}
              <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group selectFromCol" style="position: relative;">
                   <label class="font-weight-semibold">{{ __('popupAdvanceSearch.price') }}</label>
                  <span class="align-items-center border d-block d-flex pricerange px-3 py-1">
                    <i class="fa fa-angle-down" aria-hidden="true" style="position: absolute;right: 15px;font-weight: bold;"></i>
                    <div class="select-prng">{{ __('popupAdvanceSearch.all') }}</div>
                    <div class="pr-range-min" style="display: none"></div>
                    <div class="pr-range-dash px-1" style="display: none">-</div>
                    <div class="pr-range-max" style="display: none"></div>
                  </span>
                  <div class="pr-dropdown pr-dropdown-cls" style="display: none;position: absolute;top: 70px;width: 96%;">
                    <div class="d-flex pt-2 pr-2 pl-2" style="background-color: #EAF0FF">
                       <input type="text" name="minPrice" id="minPrice" placeholder="{{__('popupAdvanceSearch.from')}}" class="form-control form-control-sm mb-2">
                       <span style="line-height: 2.5;" class="pr-2 pl-2">-</span>
                       <input type="text" name="maxPrice" id="maxPrice" placeholder="{{__('popupAdvanceSearch.to')}}" class="form-control form-control-sm mb-2">
                    </div>
                    <div class="d-flex">

                    <div class="p-2 pr-min w-50">

                      <ul class="min-price-list list-unstyled mb-0" style="">
                        @for($i = 1000;$i<=5000;$i+=1000)
                           <li>{{$i}}</li>  
                        @endfor
                      </ul>
                    </div>
                    <div class="p-2 pr-max">
                     
                       <ul class="max-price-list list-unstyled mb-0" style="display: none;">
                         @for($i = 1000;$i<=5000;$i+=1000)
                           <li>{{$i}}</li>  
                        @endfor
                      </ul>
                    </div>
                  </div>
                  </div>
              
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                  <label class="font-weight-semibold">{{ __('popupAdvanceSearch.year') }}</label>
                    <div class="form-row">
                    <div class="col-lg-6 col-md-6 col-6 pr-0 form-group mb-0 selectFromCol">
                    <select id="yearFrom" class="form-control" >
                      <option value="">{{ __('popupAdvanceSearch.from') }}</option>
                        @foreach(range(1979, date('Y')) as $i)
                          <option value="{{$i}}">{{$i}}</option> 
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 col-md-6 col-6 pl-0 form-group mb-0 selectToCol">
                    <select name="selectYearTo" id="yearTo" class="form-control">
                      <option value="">{{ __('popupAdvanceSearch.to') }}</option>
                        @foreach(range(date('Y'), date('Y')-79) as $i)
                        <option value="{{$i}}">{{$i}}</option> 
                        @endforeach
                    </select>
                    </div>
                  </div>
                  
                </div> 
                            
                           
      <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group selectFromCol" style="position: relative;">
           <label class="font-weight-semibold">{{ __('popupAdvanceSearch.mileage') }}</label>
          <span class="align-items-center border d-block d-flex mileagerange px-3 py-1" style="height: 3rem;">
            <i class="fa fa-angle-down" aria-hidden="true" style="position: absolute;right: 15px;font-weight: bold;"></i>
            <div class="select-prng-mileage">{{__('popupAdvanceSearch.all')}}</div>
            <div class="pr-mileage-min" style="display: none"></div>
            <div class="pr-mileage-dash px-1" style="display: none">-</div>
            <div class="pr-mileage-max" style="display: none"></div>
          </span>
          <div class="pr-dropdown-mileage pr-dropdown-cls" style="display: none;position: absolute;top: 70px;width: 96%;">
            <div class="d-flex pt-2 pr-2 pl-2" style="background-color: #EAF0FF">
               <input type="text" name="fromMillage" id="fromMillage" placeholder="{{__('popupAdvanceSearch.from')}}" class="form-control form-control-sm mb-2">
               <span style="line-height: 2.5;" class="pr-2 pl-2">-</span>
               <input type="text" name="toMillage" id="toMillage" placeholder="{{__('popupAdvanceSearch.to')}}" class="form-control form-control-sm mb-2">
            </div>
            <div class="d-flex">

            <div class="p-2 pr-min w-50">

              <ul class="min-mileage-list list-unstyled mb-0" style="">
              <li data-id="10000">10,000 km</li>
              <li data-id="20000">20,000 km</li>
              <li data-id="30000">30,000 km</li>
              <li data-id="40000">40,000 km</li>
              <li data-id="50000">50,000 km</li>
              <li data-id="60000">60,000 km</li>
              <li data-id="70000">70,000 km</li>
              <li data-id="80000">80,000 km</li>
              <li data-id="90000">90,000 km</li>
              <li data-id="100000">100,000 km</li>
              <li data-id="125000">125,000 km</li>
              <li data-id="150000">150,000 km</li>
              <li data-id="175000">175,000 km</li>
              <li data-id="200000">200,000 km</li>
              </ul>
            </div>
            <div class="p-2 pr-max">
             
               <ul class="max-mileage-list list-unstyled mb-0" style="display: none;">
               <li data-id="10000">10,000 km</li>
              <li data-id="20000">20,000 km</li>
              <li data-id="30000">30,000 km</li>
              <li data-id="40000">40,000 km</li>
              <li data-id="50000">50,000 km</li>
              <li data-id="60000">60,000 km</li>
              <li data-id="70000">70,000 km</li>
              <li data-id="80000">80,000 km</li>
              <li data-id="90000">90,000 km</li>
              <li data-id="100000">100,000 km</li>
              <li data-id="125000">125,000 km</li>
              <li data-id="150000">150,000 km</li>
              <li data-id="175000">175,000 km</li>
              <li data-id="200000">200,000 km</li>
              </ul>
            </div>
          </div>
          </div>
      
        </div>

      <div class="col-12 form-group mb-0 pt-sm-2 mt-4"> 
        <div class="form-row"> 

        <div class="form-group col-md-4 col-sm-4 col-12"> 
          
         <label class="font-weight-semibold">{{ __('popupAdvanceSearch.versions') }}</label>
        <select name="selectVersion" id="selectVersion" class="form-control search_selectbox_submit">
         
        <option value="">{{ __('popupAdvanceSearch.all') }}</option> 
        </select>
        </div>

      <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group"> 
      <label class="font-weight-semibold">{{ __('popupAdvanceSearch.engineDetails') }}</label>
         <select id="engine_type" name="engine_type" class="form-control search_selectbox_submit">
          <option value="">{{ __('popupAdvanceSearch.all') }}</option>
           @if(!$engineTypes->isEmpty())
          @foreach($engineTypes as $eTypes)
            <option value="fuel_{{$eTypes->title}}">{{$eTypes->title}}</option> 
           @endforeach
          @endif 
        </select>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
        <label class="font-weight-semibold">{{ __('popupAdvanceSearch.enginePower') }}</label>
        <div class="form-row">
          <div class="col-lg-6 col-md-6 col-6 pr-0 form-group mb-0 selectFromCol">
            <select name="powerFrom" id="powerFrom" class="form-control">
              <option value="">{{ __('popupAdvanceSearch.from') }}</option>
            </select>
          </div>
          <div class="col-lg-6 col-md-6 col-6 pl-0 form-group mb-0 selectToCol">
            <select name="powerTo" id="powerTo" class="form-control">
              <option value="">{{ __('popupAdvanceSearch.to') }}</option>
              
            </select>
          </div>
        </div>
      </div>

       <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
        <label class="font-weight-semibold">{{ __('popupAdvanceSearch.engineCapacity') }}</label>
        <div class="form-row">
          <div class="col-lg-6 col-md-6 col-6 pr-0 form-group mb-0 selectFromCol">
            <select name="CapacityFrom" id="engineccFrom" class="form-control">
              <option value="">{{ __('popupAdvanceSearch.from') }}</option>
            </select>
          </div>
          <div class="col-lg-6 col-md-6 col-6 pl-0 form-group mb-0 selectToCol">
            <select name="CapacityTo" id="engineccTo" class="form-control">
              <option value="">{{ __('popupAdvanceSearch.to') }}</option>
              
            </select>
          </div>
        </div>
      </div> 

         
        </div>
      </div>


      <div class="col-12 form-group mb-0 pt-sm-2 mt-4">
        <label class="font-weight-semibold">{{ __('popupAdvanceSearch.otherDetails') }}</label>
        <div class="form-row"> 
          
           <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
            <label class="font-weight-semibold">{{ __('popupAdvanceSearch.transmission') }}</label>
        <select id="transmission" name="transmission" class="form-control search_selectbox_submit">
              <option value="" disabled="true" selected>{{ __('popupAdvanceSearch.all') }}</option>
                @if(!$transmissions->isEmpty())
                  @foreach($transmissions as $transmission)
                  <option  value="transmission_{{$transmission->title}}">{{$transmission->title}}</option>
                  @endforeach
            @endif 
            </select>
          </div>

          <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
             <label class="font-weight-semibold">{{ __('popupAdvanceSearch.bodyType') }}</label>
              <select id="body_type" name="body_type" class="form-control">
              <option value="" disabled="true" selected>{{ __('popupAdvanceSearch.all') }}</option> 
            </select>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
             <label class="font-weight-semibold">{{ __('popupAdvanceSearch.color') }}</label>
              <select name="color" id="color" class="form-control search_selectbox_submit"> 
              <option value="">{{ __('popupAdvanceSearch.all') }}</option>
            </select>
          </div> 
         
        </div>
      </div>



     <div class="col-12 form-group mb-0 pt-sm-2 mt-4">
        <label class="font-weight-semibold">{{ __('popupAdvanceSearch.allProperties') }}</label>
        <div class="form-row">
          <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
              <label class="font-weight-semibold">{{ __('popupAdvanceSearch.adPicture') }}</label>
           <select id="picture" name="have_picture" class="form-control search_selectbox_submit">
              <option value="" disabled="true" selected>{{ __('popupAdvanceSearch.all') }}</option> 
              <option value="">{{ __('popupAdvanceSearch.adWithOutPicture') }} </option>
              <option value="pic_Ads-With-Pictures">{{ __('popupAdvanceSearch.adWithPictureOnly') }} </option>
            </select>
          </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
           <label class="font-weight-semibold">{{ __('popupAdvanceSearch.sellerType') }}</label>
            <select id="ads_type" name="ads_type" class="form-control search_selectbox_submit">
              <option value="" disabled="true"  selected>{{ __('popupAdvanceSearch.all') }} </option>
              <option value="seller_business">{{ __('popupAdvanceSearch.sellerTypeDealer') }}</option>
              <option value="seller_individual">{{ __('popupAdvanceSearch.sellerTypeIndividual') }}</option>
            </select>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
            <label class="font-weight-semibold">{{ __('popupAdvanceSearch.adType') }}</label>
            <select id="featured" name="is_featured" class="form-control search_selectbox_submit">
              <option value="" disabled="true" selected>{{__('popupAdvanceSearch.all')}}</option>
              <option value="isf_featured">{{ __('popupAdvanceSearch.adTypeFeatureAds') }}</option>
            </select>
          </div>
         
        </div>
      </div>
    </div>


    <div class="align-items-center col-12 d-flex form-group justify-content-between mt-md-4 mt-2 mb-0">
      <div class="comp-clear">
        <a class="LessMoreOptions font-weight-semibold themecolor" data-toggle="collapse" href="#moreCollapsedFields" aria-expanded="false" aria-controls="moreCollapsedFields">
           <span class="moreFields">{{ __('popupAdvanceSearch.showMore') }}</span> <span class="lessFields">{{ __('popupAdvanceSearch.showLess') }}</span><em class="fa fa-angle-down"></em>
        </a>
        </div>
        <div class="comp-submit">
          <button type="submit" class="btn themebtn3 search_check_submit">{{ __('popupAdvanceSearch.buttonText') }}</button>
        </div>
    </div>
  </div>
  </form>
  </div>
  <div class="row servicesRow text-center mt-5 d-md-flex d-none">
<div class="col-sm-4 col-md-4 col-12 pl-xl-4 pr-xl-4 servicesCol mb-4 mb-sm-0">
  <img src="{{asset('public/assets/img/feature-1.png')}}" class="img-fluid mb-2 mb-md-4" alt="carish used cars for sale in estonia">
  
<h5 class="font-weight-bold themecolor">* {{ __('findUsedCars.freeAd') }}</h5>
<p>{{ __('findUsedCars.postAnAd') }} <a href="{{route('faqs')}}" class="themecolor"><u>{{ __('findUsedCars.forFree') }}</u></a> {{ __('findUsedCars.inFewSeconds') }} </p>

</div>
<div class="col-sm-4 col-md-4 col-12 pl-xl-4 pr-xl-4 servicesCol mb-4 mb-sm-0">
  <img src="{{asset('public/assets/img/feature-2.png')}}" class="img-fluid mb-2 mb-md-4" alt="carish used cars for sale in estonia">
   <h5 class="font-weight-bold themecolor">{{ __('findUsedCars.genuineBuyers') }}</h5>
<p>{{ __('findUsedCars.getAuthenticOffers') }}</p>
</div>
<div class="col-sm-4 col-md-4 col-12 pl-xl-4 pr-xl-4 servicesCol mb-4 mb-sm-0">
  <img src="{{asset('public/assets/img/feature-3.png')}}" class="img-fluid mb-2 mb-md-4" alt="carish used cars for sale in estonia">
<h5 class="font-weight-bold themecolor">{{ __('findUsedCars.sellFast') }}</h5>
<p>{{ __('findUsedCars.sellFastDetailedText') }}</p>
</div>
<div class="col-12 mt-4 pt-3">
  <a target="" href="{{url('user/post-car-ad')}}" class="btn  themebtn1">{{__('findUsedCars.sellFastButtonText')}}</a>
</div>
</div>
<div class="comparison-ad mt-md-5 mt-4 pt-2 pt-md-0">
<img src="{{asset('public/assets/img/comparison-ad.jpg')}}" class="img-fluid">
</div>
</div>
<!-- Featured Used Cars for Sale Starts Here -->
<div class="featured-used-cars-for-sale bg-white mt-md-5 mt-4 pb-md-5 pt-md-5 pb-4 pt-3 border-top border-bottom">
<div class="container pt-md-0 pt-3">
<div class="internal-sect-title-col align-items-end d-md-flex justify-content-between mb-4">
  <h3 class="internal-sect-title font-weight-semibold mb-0">{{__('findUsedCars.featuredUsed')}}</h3>
  <div class="ml-md-3 text-right view-all-link">
    <a target="" href="{{route('simple.search')}}/isf_featured" class="themecolor">{{__('findUsedCars.viewAll')}}</a>
  </div>
</div>
<div class="owl-carousel owl-theme featured-uc-slider text-center " id="feat-UsedCars">
  <div class="item item two-row-item">
    @if(sizeof($ads) > 0)


     @php $i = 2;
      @endphp
     @foreach($ads as $ad)
    
    <div class="box-shadow">
      <figure class="mb-0 position-relative text-left">
         @if(@$ad->ads_images[0]->img)
      <div class="bgImg row justify-content-center align-items-center" style="background-image: url({{asset('public/uploads/ad_pictures/cars/'.@$ad->id.'/'.@$ad->ads_images[0]->img)}});width: 100%;
      margin: 0;
      background-size: cover;
      background-repeat: no-repeat;
      background-position: 50% 50%;">
      </div>
      @else
      <div class="bgImg row justify-content-center align-items-center" style="background-image: url({{ asset('public/assets/img/caravatar.jpg')}});width: 100%;
      margin: 0;
      background-size: cover;
      background-repeat: no-repeat;
      background-position: 50% 50%;">
        
      </div>

      @endif
        <figcaption class="position-absolute">
        <span class="bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block">{{__('findUsedCars.featuredAds')}}</span>
        </figcaption>
      </figure>
      <div class="pb-3 pl-2 pr-2 pt-3">
         <h5 class="font-weight-semibold mb-1"><a target="" href="{{url('car-details/'.$ad->id)}}" class="stretched-link themecolor">{{$ad->maker->title}} {{$ad->model->name}} {{$ad->year_id}}</a></h5>
      <p class="car-price mb-1">${{$ad->price}}</p>
      <span class="car-country">{{$ad->bought_from}}</span>
      </div>
    </div>
    @php $i++;
     @endphp
    @if($i % 2 == 0)
  </div>
   <div class="item item two-row-item">
    @endif
    @endforeach
    @else
    <h5 class="text-center col-lg-12 mt-5">{{ __('findUsedCars.noRecordFound') }}</h5>
    @endif
            
    </div>
  </div>
</div>
        <!-- Featured Used Cars for Sale Ends Here -->
        <!-- Browse Cars By Make Starts Here -->
        <div class="featured-UsedCars mb-md-5 mt-md-5 mb-4 mt-4 sects-bg">
        <div class="container pt-3">
          <div class="browse-car-by-sect bg-white border mt-md-5 mt-4">
            <div class="bcb-title f-size1 p-md-4 m-md-2  p-3">
              <h3>{{__('findUsedCars.usedCarByCategoreis')}}</h3>
              <p class="mb-0"><!-- 444,337 -->{{__('findUsedCars.usedCarByCategoreisDetailedText')}}</p>
            </div>
            
            <ul class="nav nav-justified nav-tabs browse-car-tabs">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#bcb-tab1" role="tab" aria-controls="bcb-tab1" aria-selected="true">{{__('findUsedCars.category')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#bcb-tab2" role="tab" aria-controls="bcb-tab2" aria-selected="true">{{__('findUsedCars.make')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#bcb-tab3" role="tab" aria-controls="bcb-tab3" aria-selected="true">{{__('findUsedCars.city')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#bcb-tab4" role="tab" aria-controls="bcb-tab4" aria-selected="true">{{__('findUsedCars.bodyType')}}</a>
              </li>
            </ul>
            <!-- Tab panes MAKE MODELS CAROUSEL-->
            <div class="bbrowse-car-content pl-md-3 pr-md-3 pt-md-3 tab-content">
              <div class="tab-pane fade show active p-4 browse-cb" id="bcb-tab1"> 
          
              </div>

              <div class="tab-pane p-4 browse-cb" id="bcb-tab2">
               

              </div>

              <div class="tab-pane p-4 browse-cb" id="bcb-tab3">
                 
              </div>
              <div class="tab-pane p-4 browse-cb" id="bcb-tab4">
                
          </div>
           
          </div>
          </div>
          <!-- Featured Dealers section starts here -->
          <div class="row mt-5 featured-dealers-row">
            <div class="col-12">
              <div class="internal-sect-title-col align-items-end d-md-flex justify-content-between">
                <h3 class="internal-sect-title font-weight-semibold mb-0">{{__('findUsedCars.featuredDealers')}} </h3>
                <div class="ml-md-3 text-right view-all-link">
                  <a href="{{ url('allservices/listing/ps_1') }}" class="f-size1 themecolor">{{__('findUsedCars.viewAll')}}</a>
                </div>
              </div>
              <div class="align-items-center row text-center featured-dealers-col">
                @if(sizeof($featured_dealers) > 0)
                @foreach(@$featured_dealers as $dealer)
                <div class="col-lg-3 col-md-3 col-sm-4 col-6 mt-4 pt-md-3 pt-1">
                  <img src="{{asset('public/uploads/customers/logos/'.@$dealer->logo)}}" class="img-fluid">
                </div>
                @endforeach
                @else
                <h5 class="text-center col-lg-12 mt-5">{{ __('findUsedCars.noFeatureDealerFind') }}</h5>
                @endif
              </div>
            </div>
          </div>
          <!-- Featured Dealers section ends here -->
        </div>
      </div>
        <!-- Browse Cars By Make Ends Here -->
        <!-- post an ad post free start here -->
        <div class="bg-white mt-5 py-1 post-ad-free">
          <div class="container">
            <div class="align-items-center col-lg-9 d-sm-flex justify-content-around ml-auto mr-auto mb-4 mb-md-5 mt-4 mt-md-5 pl-0 postAdRow pr-0 mb-sm-0 mb-5">
              <div class="sellCarCol d-none d-md-block">
                <img src="{{asset('public/assets/img/sell-car.png')}}" class="img-fluid" alt="carish used cars for sale in estonia">
              </div>
              <div class="pl-md-3 pr-md-3 sellCartext text-center">
                <img src="{{asset('public/assets/img/sell-arrow-left.png')}}" class="d-md-block d-none img-fluid mr-auto  sell-arrow-left" alt="carish used cars for sale in estonia">
                <h4 class="mb-0">{{__('findUsedCars.postAnAd')}} <span class="themecolor2">{{__('findUsedCars.free')}}</span></h4>
                <p class="mb-0">{{__('findUsedCars.sellFastDetailedText')}}</p>
                <img src="{{asset('public/assets/img/sell-arrow-right.png')}}" class="d-sm-block d-none img-fluid ml-auto sell-arrow-right" alt="carish used cars for sale in estonia">
              </div>
              <div class="sellCarBtn">
                <a href="{{route('sellcar')}}" class="btn themebtn1">{{__('findUsedCars.sellFastButtonText')}}</a>
              </div>
            </div>
          </div>z
        </div>
        <!--  -->
      </div>
@stop