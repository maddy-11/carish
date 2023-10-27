@extends('layouts.app')
@section('content')
@push('styles') 
<style>
  #overlay{	
	position: fixed;
	top: 0;
	z-index: 100;
	width: 100%;
	height:100%;
	display: none;
	background: rgba(0,0,0,0.6);
}
.cv-spinner {
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;  
}
.spinner {
	width: 100px;
	height: 100px;
	border: 4px #ddd solid;
	border-top: 4px #2e93e6 solid;
	border-radius: 50%;
	animation: sp-anime 0.8s infinite linear;
}
@keyframes sp-anime {
	100% { 
		transform: rotate(360deg); 
	}
}
.is-hide{
	display:none;
}
  </style>
@endpush
              <div id="overlay">
	<div class="cv-spinner">
		<span class="spinner"></span>
	</div>
</div>
     <!-- header Ends here -->
<div class="internal-page-content mt-4 pt-4 sects-bg">
    <div class="container">
        <div class="row">
            <div class="col-12 bannerAd pt-2">
              <img src="assets/img/placeholder.jpg" class="img-fluid" alt="carish used cars for sale in estonia">
            </div>
        </div>
          <div class="bg-white border mt-4 mx-0 row">
            <div class="col-12 col-md-6 post-ad-auto-col py-3">
              <div class="px-xl-5 py-sm-5 py-3 px-lg-4 px-sm-3 h-100 text-center">
                <h3 class="themecolor text-center">Have Estonian registration #?</h3>
                <p>Enter it below and make your life easy</p>
                <div class="post-ad-auto-bg mt-md-5 mt-4 mx-auto">
                <div class="form-group d-flex">

               <form action="{{route('post.ad')}}" method="post" id="car_number_form">
                {{csrf_field()}}
                <div class="input-group rounded" id="car_data">
                  <img src="{{asset('public/assets/img/est-number.jpg')}}" align="image">
                  <input required type="text" name="carnumber" id="carnumber" value="" class="border-0 form-control" placeholder="2345ADCB">
                  
                </div>                
                <input type="submit" class="btn rounded-0 themebtn1 px-4 ml-2 " id="themebtn1" value="{{__('ads.next')}}">
                
              </form>


            </div>
              </div>
              </div>
            </div>

            <div class="col-12 col-md-6 post-ad-auto-col py-3">
              <div class="px-xl-5 py-sm-5 py-3 px-lg-4 px-sm-3 h-100 text-center">
                <h3 class="themecolor3">Bought Vehicle Outside of Estonia?</h3>
                <p>Let’s enter data manually, it’s not gonna take long</p>
                <div class="mt-md-5 mt-4 without-no">
                <a target="" href="{{route('sellcar')}}" class="border-0 btn py-0 rounded-0 themebtn3">Without Number</a>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>


      <!-- Modal -->
              <div class="modal fade postformmodal" id="postedcarinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content overflow-hidden">
                    <div class="modal-body overflow-hidden pt-0">
                      <div class="row car-list-row"> 
                        <div class="col-md-12 col-sm-12 car-info-list-col make-list-col car-list-active" id="make_years">
                        </div>
                      </div>
                      <div class="mb-2 mt-4 post-modal-btn text-center">
                        <a href="#" class="btn  themebtn1" data-dismiss="modal">{{__('ads.next')}}</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

@endsection

   @push('scripts') 
<script> 
    /* MUTAHIR SCRIPT FOR MAKE MODEL VERSION */
      $(document).ready(function(){
        	$(document).ajaxSend(function() {
          $("#overlay").fadeIn(300);　
        });
        
      $(document).on( 'click','#form_submit', function(e) { 
        $("#car_number_form").submit();
      });
      $(document).on( 'click','#themebtn1', function(e) { 
        e.preventDefault();
      var carnumber     = $('#carnumber').val();

       if(carnumber == '') {
          html ='<h6 style="padding-top:50px" class="d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>Please select a number.</h6>';
            $(".post-modal-btn").html('<a href="#" class="btn  themebtn1" data-dismiss="modal">{{__("ads.close")}}</a>');
            $("#make_years").html(html);
            $('#postedcarinfo').modal('show');
            $("#overlay").fadeOut(300);
            return false;
            }

      $.ajax({
            url: "{{url('user/get-car-info')}}/"+carnumber,
            method: "get",
            dataType:"json",
            success: function (data) {
              var html = '';
              if(data['status'] == 'success'){
                html +='<h6 style="padding-top:50px" class="d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>'+data['message']+'</h6>';
                
                $.each(data['data'], function( index, value ) {
                  $("#car_data").append('<input type="hidden" name="car_data['+index+']" value="'+value+'">');});// END FOR EACH

                $(".post-modal-btn").html('<a href="#" class="btn  themebtn1" data-dismiss="modal" id="form_submit">{{__("ads.next")}}</a>');

              }
              if(data['status'] == 'error'){
                html +='<h6 style="padding-top:50px" class="d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>'+data['message']+'</h6>';
                $(".post-modal-btn").html('<a href="#" class="btn  themebtn1" data-dismiss="modal">{{__("ads.close")}}</a>');

              }
              $("#make_years").html(html);
              $('#postedcarinfo').modal('show'); 
            },
            error:function (xhr, ajaxOptions, thrownError){
                if(xhr.status == 404 || xhr.status == 500) {
                    html ='<h6 style="padding-top:50px" class="d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>No record found in our database.</h6>';
                $(".post-modal-btn").html('<a href="#" class="btn  themebtn1" data-dismiss="modal">{{__("ads.close")}}</a>');
                    $("#make_years").html(html);
                    $('#postedcarinfo').modal('show');
                    $("#overlay").fadeOut(300); 
                }
            }
            }).done(function() {
            setTimeout(function(){
              $("#overlay").fadeOut(300);
            },500);
		});
    
    });

    });
    </script>
    @endpush