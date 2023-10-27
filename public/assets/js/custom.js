// $('.navbar-toggler').on('click', function(){
//       $(this).parents('header').toggleClass('headerOnMobile','slow');
// })

$('.bucSlider').owlCarousel({
    loop:false,
    margin:0,
    nav:true,
    responsive:{
        0:{
            items:1
        }
    }
})
$('#services-slider-1, #services-slider-2, #services-slider-3, #services-slider-4, #services-slider-5, #services-slider-6, #services-slider-7').owlCarousel({
    loop:false,
    margin:0,
    nav:true,
    responsive:{
        0:{
            items:1
        }
    }
})
$('#mob-services-slider-1, #mob-services-slider-2, #mob-services-slider-3, #mob-services-slider-4, #mob-services-slider-5, #mob-services-slider-6, #mob-services-slider-7').owlCarousel({
    loop:false,
    margin:0,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        480:{
            items:2,
        }
    }
})
$('#feat-UsedCars, #pop-UsedCars').owlCarousel({
    loop:false,
    margin:20,
    nav:true,
    responsive:{
        0:{
            items:1,
        },
        768:{
            items:3,
        },
        992:{
            items:4,
        }
    }
})
$('#cars-parts').owlCarousel({
    loop:false,
    margin:30,
    nav:true,
    responsive:{
        0:{
            items:1,
        },
        768:{
            items:3,
        },
        992:{
            items:4,
        }
    }
})
$('#offered-services').owlCarousel({
    loop:false,
    margin:30,
    nav:true,
    responsive:{
        0:{
            items:1,
        },
        768:{
            items:3,
        },
        992:{
            items:4,
        }
    }
})
$('#browse-cb-categ').owlCarousel({
    loop:false,
    margin:15,
    nav:true,
    responsive:{
        0:{
            items:2,
        },
        570:{
            items:3,
        },
        768:{
            items:3,
        },
        992:{
            items:5,
        }
    }
})
$('#browse-cb-make').owlCarousel({
    loop:false,
    margin:15,
    nav:true,
    responsive:{
        0:{
            items:1,
        }
    }
})
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

  $('#searchResultFilter').slideToggle();
});

$('.searchcol, .searchsubmit').on('click', function(){
    $('.selectCol').removeClass('selectfieldcol');
    $('.advSearchCol').removeClass('adActive');
});

$('.show-more-cities').on('click', function(){
    $('#search-by-city-list').toggleClass('searchmorecity');
});
$('.message-title').on('click', function(){
    $('.messages-col').show();
    $(this).parents('.message-table').hide();
});

$('.version-listings li').on('click', function () {
    $('.addInformation').show();
    $('.postformmodal').modal('hide');
})

$('.custdropdown').parent('li').children('a').attr('href', 'javascript:void(0)').append('<em class="fa fa-angle-down"></em>').addClass("align-items-center d-flex justify-content-between");

$('.offer-ctg-list li').on('click', function () {
        $(".offer-ctg-list li").not(this).children('.custdropdown').hide("slow");
        $(this).children('.custdropdown').slideToggle();
        $(".offer-ctg-list li").not(this).removeClass('offerctgActive');
        $(this).toggleClass('offerctgActive')
});

$('.navbar-toggler').on('click', function () {
// $('.navbar-collapse').slideToggle('slow');

if ($('.navbar-collapse').hasClass('collapseShow')){
        $('.navbar-collapse').hide(300).removeClass('collapseShow');
        $(this).children('span').removeClass('fa-close').addClass('fa-bars');
        $('.mobile-collape-bg').hide();   
    } 
    else {
        $('.navbar-collapse').show(300).addClass('collapseShow');
        $(this).children('span').addClass('fa-close').removeClass('fa-bars');
        $('body').append('<div class="mobile-collape-bg"></div>');
    }

});

$(document).on('click', '.mobile-collape-bg', function () {
    $('.navbar-collapse').hide(300).removeClass('collapseShow');
    $('.navbar-toggler').children('span').removeClass('fa-close').addClass('fa-bars');
    $('.mobile-collape-bg').hide(); 
})


$('#minPrice').on('keyup', function () {
var minPrice = $('#minPrice').val();
if ($(this).val() == ""){ 
    $('.pr-range-min').html('0 lac') 
   }
 else {
    $('.pr-range-min').html(minPrice + " lacs").show() 
    $('.select-prng').hide();
 }

})
$('#maxPrice').on('keyup', function () {
    var maxPrice = $('#maxPrice').val();
if ($(this).val() == ""){ 
    $('.pr-range-max').html('0 lac');
   }
 else {
    $('.pr-range-max').html(maxPrice + " lacs").show();
    $('.select-prng').hide();
 }
})

// $('#maxPrice').on('focusout', function () {
//     if ($('#minPrice').val() == ""){ 
//         $('.pr-dropdown').show() 
//     }
//     else{
//         $('.pr-dropdown').hide()
//     }
// })
// $('#minPrice').on('focusout', function () {
//   if ($('#maxPrice').val() == ""){ 
//       $('.pr-dropdown').show() 
//    }
//    else {
//       $('.pr-dropdown').hide()
//    }
// })



$('#minPrice').on('click', function () {
    alert('hi');
 $('.min-price-list').show() 
  $('.max-price-list').hide() 
  //$('#minPrice').val('');
})
$('#maxPrice').on('click', function () {
 $('.min-price-list').hide() 
 $('.max-price-list').show() 
 //$('#maxPrice').val('');
})

$('.min-price-list li').on('click', function () {
    $(this).parents('.min-price-list').hide();
    $('.select-prng').hide();
    var minlistPrice = $(this).text();
    $('#minPrice').val(minlistPrice);
    $('.pr-range-min').html(minlistPrice).show(); 
})
$('.max-price-list li').on('click', function () {
    $('.select-prng, .pr-dropdown').hide();
    $(this).parents('.max-price-list').hide();
    var maxlistPrice = $(this).text();
    $('#maxPrice').val(maxlistPrice);
    $('.pr-range-dash').show(); 
    $('.pr-range-max').html(maxlistPrice).show();

 })


$('.pricerange').on('click', function () {
    $('.pr-dropdown').show(); 
    $('#minPrice, #maxPrice').val(''); 
})


$(function () {
    
   

  $('.select2-field').each(function () {
    $(this).select2({
      theme: 'bootstrap4',
      width: 'style',
      placeholder: $(this).attr('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
    });
  });
});

// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});