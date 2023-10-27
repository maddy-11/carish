$(document).ready(function(){
$('.navbar .dropdown-toggle').append('<em class="fa fa-angle-down"></em>');


if ($(window).width() < 768){
  $('.sidebar').removeClass('sidebarin').removeClass('mobIn');
        $('.backlink a').removeClass('menuarrow').addClass('mobarrow'); 
        // $('.sidebar').addClass('sidebarin');

$(document).on('click', '.mobarrow', function(){
          if ($(this).hasClass('actarrow')){
            $(this).removeClass('actarrow');     
            $('.sidebar').animate({width: '60px'}, 500).removeClass('sidebarin').removeClass('mobIn');
            // setTimeout(function(){ $('.sidebar').addClass('sidebarin'); }, 100);
            $('.sidebarbg').animate({width: '60px'}, 500);
          } 
          else {
            $(this).addClass('actarrow');
            $('.sidebar').animate({width: '190px'}, 500);
            setTimeout(function(){ $('.sidebar').addClass('sidebarin').addClass('mobIn'); }, 200);
            $('.sidebarbg').animate({width: '190px'}, 500);
          }
    })    
}

if ($(window).width() > 767){

$('.menuarrow').on('click', function() {
   // if ($(this).hasClass('actarrow') && $(window).width() <  992){
   //      $(this).removeClass('actarrow');     
   //      $('.sidebar').animate({width: '190px'}, 500);
   //      // setTimeout(function(){ 
   //      //   $('.sidebar').removeClass('sidebarin');}, 400);
   //      $('.sidebarbg').animate({width: '190px'}, 500);
   //      $('.logo').animate({width: '190px'}, 500);
   //      $('.sideprotext').show();
   //  }

     if ($(this).hasClass('actarrow')){
        $(this).removeClass('actarrow');     
        $('.sidebar').animate({width: '70px'}, 500);
        setTimeout(function(){ 
          $('.sidebar').addClass('sidebarin');}, 400);
        $('.sidebarbg').animate({width: '70px'}, 500);
        $('.logo').animate({width: '70px'}, 500).removeClass('logoin');  
    }
     else {
        $(this).addClass('actarrow');
        $('.sidebar').animate({width: '230px'}, 500).removeClass('sidebarin');
        $('.sidebarbg').animate({width: '230px'}, 500);
        $('.logo').animate({width: '230px'}, 500).addClass('logoin');
        
     }
})  
   }
   })  