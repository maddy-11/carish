$(document).ready(function ()
{
  $('.gridIcon').on('click', function(){
  $('.listingtab').addClass('gridingCol');
  $('this').addClass('active');
  $('.listIcon').removeClass('active');
  $('.gridListprice').addClass('d-flex mb-2').removeClass('d-none mb-3');
  $('.listingCar-place .negotiable, .listingCar-title .lcPrice').hide();
  });
  $('.listIcon').on('click', function(){
  $('.listingtab').removeClass('gridingCol');
  $(this).addClass('active');
  $('.gridIcon').removeClass('active');
  $('.gridListprice').removeClass('d-flex mb-2').addClass('d-none mb-3');
  $('.listingCar-place .negotiable, .listingCar-title .lcPrice').show();
  });
  $('.filterDown em').on('click', function(){
  if ($('.filterDown em').hasClass('filter-active')){
  $('.filterDown em').removeClass('filter-active');
  $('.filterDown em').removeClass('fa-chevron-circle-up').addClass('fa-chevron-circle-down');
  }
  else {
  $('.filterDown em').removeClass('fa-chevron-circle-down').addClass('fa-chevron-circle-up')
  $('.filterDown em').addClass('filter-active');
  }
  // $('#searchResultFilter').slideToggle();
  });
  $('a').tooltip({  
  disabled: true,
  close: function( event, ui ) { $(this).tooltip('disable'); }
  });
  $('a').on('click', function () {
  $(this).tooltip('enable').tooltip('open');
  });
  $('html, body').animate({
                    scrollTop: $("#breadcrumb").offset().top
                }, 200); 

  //#########################################

  $(".search_check_submit").click(function(event) {
            var sortBy = '';
            if($("#sortBy").val() != ''){
              sortBy = '?sortby='+$("#sortBy").val();
            }
            searchCars(sortBy);
          });
  $("#sorting").on('change', function() {
              var sortBy = 'sortby_'+this.value;
              searchCars(sortBy);
            });
  $(".sortBy").on('click', function(event) {
              event.preventDefault();
              sortBy = '';
              var url = $(this).attr('href');
              if($("#sortBy").val() != ''){
              sortBy = '?sortby='+$("#sortBy").val();
            } 
            console.log(url);
            $(this).remove();
            window.location.href = url+sortBy;
            });
  function searchCars(sortBy = ''){
            var datavars = []; 
            $('input.search_check_submit:checkbox:checked').each(function () { 
                var str = $(this).data("value"); 
                //var res = str.split("_"); // this returns an array
                //datavars[res[0]] = res[1];  
                datavars.push(str);
            });

           $(".search_text_submit").each(function () {
            if($(this).val() != ''){
              var search_text_submit  = $(this).data("value");
              str = search_text_submit+$(this).val()
              datavars.push(str);
            }
             }); 

             /* YEAR SCRIPT */
          var yearFrom = $("#yearFrom option:selected" ).val();
          var yearTo = $("#yearTo option:selected" ).val();
          if(yearFrom != '' || yearTo != '') {
          var year = 'year_'+yearFrom+'-'+yearTo;
          datavars.push(year);
        }
      
          var minPrice = $("#minPrice" ).val();
          var maxPrice = $("#maxPrice" ).val();

          if(minPrice != '' && maxPrice != ''){

          if(parseInt(minPrice) > parseInt(maxPrice))
          {
            alert(sorry_invalid_price_range+minPrice);
            return false;
          }

        }
          

          if(minPrice != '' || maxPrice != ''){   
            if(minPrice != ''){
           var minPrice = parseInt(minPrice.replace(/\D/g,''));
          } 
            if (maxPrice != ''){
            var maxPrice = parseInt(maxPrice.replace(/\D/g,''));
          }
          var price    = 'price_'+minPrice+'-'+maxPrice;
          datavars.push(price);
        }


          // var fromMillage = $("#fromMillage option:selected" ).val();
          var fromMillage = $("#fromMillage" ).val();
          // var toMillage = $("#toMillage option:selected" ).val();
          var toMillage = $("#toMillage " ).val();
          if(fromMillage != '' || toMillage != ''){
            var millage = 'millage_'+fromMillage+'-'+toMillage;            
          datavars.push(millage);
          }


          var powerFrom = $("#powerFrom").val();
          var powerTo   = $("#powerTo").val(); 
          if(powerFrom != '' || powerTo != ''){
            var power     = 'power_'+powerFrom+'-'+powerTo;            
            datavars.push(power);
          } 


          var engineccFrom = $("#engineccFrom").val();
          var engineccTo   = $("#engineccTo").val(); 
          if(engineccFrom != '' || engineccTo != ''){
            var enginecc     = 'enginecc_'+engineccFrom+'-'+engineccTo;            
            datavars.push(enginecc);
          } 

          var tags = $("#tags").val();
           if(Array.isArray(tags) && tags.length > 0 && tags[0] != null){
                for(var i=0;i<tags.length;i++){
               datavars.push(tags[i]);
               }
           }

          datavars = getUnique(datavars);
          var search_url = baseUrl+'/find-used-cars/'+datavars.join([separator = '/']);
          // console.log(search_url+sortBy);return;
          window.location.href = search_url+sortBy;
          }

//###########################___AUTO PARTS__#############################################
    $(".search_check_submit_autoparts").click(function(event) {
            var sortBy = '';
            if($("#sortBy").val() != ''){
              sortBy = 'sortby_'+$("#sortBy").val();
            }
            searchAutoParts(sortBy);
          });
  $("#sorting_autoparts").on('change', function() {
              var sortBy = 'sortby_'+this.value;
              searchAutoParts(sortBy);
            });

  $("#sorting_autoparts").on('change', function() {
                  var sortBy = 'sortby_'+this.value;
                  searchAutoParts(sortBy);
                });
  
  function searchAutoParts(sortBy = ''){

    var parentcat = $('#parentCat').val()+'/';
   
            var datavars = [];
        $('input.search_check_submit_autoparts:radio:checked').each(function () {
            var str = $(this).data("value");
            datavars.push(str);
        });

        $('input.search_check_submit_autoparts:checkbox:checked').each(function () {
            var str = $(this).data("value");
            datavars.push(str);
        });

        $(".search_text_submit").each(function () {
            if ($(this).val() != '') {
                var search_text_submit = $(this).data("value");
                str = search_text_submit + $(this).val();
                datavars.push(str);
            }
        });

         var minPrice = $("#minPrice" ).val();
          var maxPrice = $("#maxPrice" ).val();

          if(minPrice != '' && maxPrice != ''){

          if(parseInt(minPrice) > parseInt(maxPrice))
          {
            alert(sorry_invalid_price_range+minPrice);
            return false;
          }

        }
          

          if(minPrice != '' || maxPrice != ''){   
            if(minPrice != ''){
           var minPrice = parseInt(minPrice.replace(/\D/g,''));
          } 
            if (maxPrice != ''){
            var maxPrice = parseInt(maxPrice.replace(/\D/g,''));
          }
          var price    = 'price_'+minPrice+'-'+maxPrice;
          datavars.push(price);
        }

        var engineccFrom = $("#engineccFrom").val();
          var engineccTo   = $("#engineccTo").val(); 
          if(engineccFrom != '' || engineccTo != ''){
            var enginecc     = 'enginecc_'+engineccFrom+'-'+engineccTo;            
            datavars.push(enginecc);
          } 

          var powerFrom = $("#powerFrom").val();
          var powerTo   = $("#powerTo").val(); 
          if(powerFrom != '' || powerTo != ''){
            var power     = 'power_'+powerFrom+'-'+powerTo;            
            datavars.push(power);
          } 


          
        // console.log(datavars);return;
          datavars = getUnique(datavars);
        var search_url = baseUrl + '/find-autoparts/' + parentcat + datavars.join([separator = '/']);
          window.location.href = search_url+sortBy;
          }

//########################################################################

  /* AUTO COMPLETE FOR MAKES */
  $( "#car_makes").autocomplete({
      source: function( request, response ) {
        $.ajax( {
          url: get_makers,
          dataType: "json",
          data: {
            term: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      }, 
  select: function (event, ui) { 
    var selectedValue = ui.item.id;
    $("#car_make").val(selectedValue);
  } 
  });

  /*AUTO COMPLETE FOR MODELS*/
  $( "#car_models").autocomplete({
      source: function( request, response ) {
        $.ajax( {
          url: get_models,
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
    $("#car_model").val(selectedValue);

  }
    });

    /*AUTO COMPLETE FOR Tyre Manufacturer*/
    $( "#tyre_manufactures").autocomplete({
    source: function( request, response ) {
    $.ajax( {
    url: get_manufacturer_tyre,
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
    $("#tyre_manufacture").val(selectedValue);

    }
    });

    $( "#t_types").autocomplete({
    source: ["Summer",
    "Winter",
    "All Season",
    "Studded",
    "Offroad",
    "Racing"], 
    select: function (event, ui) { 
    var selectedValue = ui.item.label.replace(/\s+/g, '_').toLowerCase();
    $("#t_type").val(selectedValue);

    }
    });

    $( "#f3_quantities").autocomplete({
    source: ["1",
    "2",
    "3",
    "4",
    ">4"], 
    select: function (event, ui) { 
    var selectedValue = ui.item.label;
    $("#f3_quantity").val(selectedValue);

    }
    });


    /*AUTO COMPLETE FOR Rim Manufacturer*/
    $( "#rim_manufactures").autocomplete({
    source: function( request, response ) {
    $.ajax( {
    url: get_manufacturer_rim,
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
    $("#rim_manufacture").val(selectedValue);

    }
    });

    $( "#rim_style").autocomplete({
    source: ["Steel",
    "Alloy",
    "Chrome"], 
    select: function (event, ui) { 
    var selectedValue = ui.item.label.replace(/\s+/g, '_').toLowerCase();
    $("#r_style").val(selectedValue);

    }
    });

    $( "#f4_quantities").autocomplete({
    source: ["1",
    "2",
    "3",
    "4",
    ">4"], 
    select: function (event, ui) { 
    var selectedValue = ui.item.label;
    $("#f4_quantity").val(selectedValue);

    }
    });




});

$('.saveAd').on('click',function(){
        //alert('fd');
      var id = $(this).data('id');
     // alert(id);
    
             $.ajax({
                method:"get",
                dataType:"json",
                url:save_ad+id,
                
                success:function(data){
                  if(data.success==true)
                    {
                        // $('#save-success').css('display','block');
                        $('#heart'+id).css({'color':'#007bff','transition':'0.5s all'});
                         toastr.success('<a target="" href="{{url("user/my-saved-ads")}}" class="show_saved_ads">Show my saved ads </a>', 'Ad saved successfully.',{"positionClass": "toast-bottom-right"},{timeOut: 5000});
                         // location.reload();

                    }
                    if(data.success==false)
                    {
                           $('#heart'+id+',#heart2'+id).css({'color':'gray','transition':'0.5s all'});
                         toastr.error('<a target="" href="{{url("user/my-saved-ads")}}" class="show_saved_ads">Show my saved ads </a>', 'Ad removed successfully.',{"positionClass": "toast-bottom-right"},{timeOut: 5000});

                    }
                
                }
             });


});