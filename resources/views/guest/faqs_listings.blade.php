@extends('layouts.app')
@section('title') {{ __('faqs.pageTitle') }} @endsection
@push('styles')
<style type="text/css">
  .expand_success{
    background: #ddd;
  }
  /*for loader*/
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 80px;
  height: 80px;
  -webkit-animation: spin 2s linear infinite;  
  animation: spin 2s linear infinite;
  margin: auto;
  margin-top: 100px;
}


/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
 
 .allow_scroll{
    max-height: 648px;
    min-height: 648px;
    overflow-y: scroll;
  }

  .allow_scroll::-webkit-scrollbar{
width:7px;
background-color:#eee;
} 
.allow_scroll::-webkit-scrollbar-thumb{
background-color:#ccc;
border-radius:0px;
}
.allow_scroll::-webkit-scrollbar-thumb:hover{
background-color:#aaa;
/*border:1px solid #333333;*/
}
.allow_scroll::-webkit-scrollbar-thumb:active{
background-color:#aaa;
/*border:1px solid #333333;*/
} 
.allow_scroll::-webkit-scrollbar-track{
/*border:1px gray solid;*/
/*border-radius:10px;*/
/*-webkit-box-shadow:0 0 6px gray inset;*/
}

@media (max-width: 991px)
{
 
  .auto_parts_list > div
  {
    width: 100%;
  }

  .auto_parts_list > div > li
  {
    margin-right: 0px;
  }

  .allow_scroll
  {
    min-height: auto !important;
    max-height: auto !important;
  }
  .offer-ctg-list .auto_parts_list_faq li a {
    padding: 4px 10px;
  }
}

/* .mainLoader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('{{asset("public/assets/img/loading1.gif")}}') 50% 50% no-repeat rgba(249,249,249,0.1);
    } */


      
      /***** carish-faq *****/
.carish-faq .card-header { margin: 0 0 10px 0; }
.carish-faq .card { border: none;  }
.carish-faq .card .card-header:first-child { border-radius: 0; }
.carish-faq .card-header { background-color: #ddd; border: none; }
.carish-faq .card button { padding: 0; background: inherit; color: #000000; text-decoration: none; font-size: 1.3rem; }
.carish-faq .card button i { padding-right:.5rem;}
.carish-faq .card .card-body-ques { padding:0px 0px 10px 40px; }
.carish-faq .card .card-body-ans { border:none; padding:7px 0 10px 25px; font-style: italic; }
.carish-faq .collapse .show { height: inherit !important; }

.carish-faq .card .card-body-ans p { display: inline; }

.carish-faq .card .card-body-ques .carish-q { border-bottom: 1px solid #ddd; padding: 6px; font-weight: bold; cursor: pointer; margin: 0; background: #ddd; }
.carish-faq .card .card-body span { padding-left: 30px; display: flex; }
.collapsing { height: auto !important; overflow: hidden; -moz-transition: height .20s ease !important;
  -webkit-transition: height .20s ease !important;
  -o-transition: height .20s ease !important;
  transition: height .20s ease !important; }
</style>
@endpush
@push('scripts') 
<script type="text/javascript">
/*    $(window).on('load',function() {
        $(".mainLoader").fadeOut("slow");
}); */
  $(document).ready(function() {
    $("#term").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('faqs.get')}}",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
        }
    });
    /*###########################################################*/ 
        $('.all_spares').toggle();
         $('.show_category').on('click',function(){
          var id = $(this).data('id');
          // alert(id);
          $(this).toggleClass('expand_success');
          $('#show_'+id).slideToggle("show");
        });
      });

  $('.load_offer_services').on('click',function(){
    $('.mob-view').removeClass('d-none');
    $('.mob-view').addClass('d-sm-block');
  // alert($(this).data('id'));
  var cats = $(this).data('id').split(' ');
  var primary_id = cats[0];
  var cat_id = cats[1];
  var sub_id = cats[2];

  $.ajax({

          method:"get",
          dataType:"json",
          data: {primary_id : primary_id, cat_id: cat_id, sub_id:sub_id},
          url:"{{ route('get-specific-offerservices') }}",
           beforeSend: function(){
            $('.specific_spares_list_'+primary_id).find('*').not('.loader_'+primary_id).remove();
                  $('.loader_'+primary_id).removeClass('d-none');
    },
          success:function(result){
            if(result.success == true)
            {
              $('.specific_spares_list_'+primary_id).empty();
              $('.specific_spares_list_'+primary_id).html(result.html);
               $('.loader_'+primary_id).addClass('d-none');

            }
          }
        });


})
</script>
@endpush
@section('content') 
@php 
  use App\ServiceDetail;
  use App\Models\Services;
  use App\Models\Customers\SubService;
  use App\Models\Cars\Make;
  use App\Models\Faq\Faq;
  use App\Models\Faq\FaqsDescription;
  $activeLanguage = \Session::get('language'); 
@endphp
<!-- <div class="mainLoader"></div>
header Ends here -->
      <div class="internal-page-content mt-4 pb-0 sects-bg">
        <div class="bgcolcor bgcolor1 internal-banner text-white cc-page-banner">
          <div class="container">
            <h3 class="font-weight-semibold text-capitalize mb-1">{{__('faqs.heading')}}</h3>
          </div>
        </div>
        <div class="container mt-n5">
          <div class="comp-form-bg bg-white border p-md-4 p-3">
          <form class="p-md-2" action="{{route('faqs.search')}}">
              <div class="form-row row">
                <div class="col-7 col-md-9 col-sm-8 form-group mb-0">
                <input type="text" name="term" id="term" value="{{@$term}}" placeholder="{{__('faqs.searchFaq')}}" class="form-control">
                </div>
                <div class="col-5 col-md-3 col-sm-4 form-group mb-0">
                  <input type="submit" value="{{__('faqs.buttonText')}}" class="btn  themebtn3 w-100 pl-3 pr-3">
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- Offered Services in Estonia Start Here -->
        <div class="offered-services-section mt-md-5 mt-4">
          <!--  Offered Services row 1 Start Here -->
         <div class="offered-services-rows pt-0 pb-3">
            <div class="container">
              <div class="p-md-4 p-3">
                
            @if(!$faq_category_decs->isEmpty())
              @foreach($faq_category_decs as $faq_category)
            <div class="offered-services-rows pt-0 pb-0">
            <div class="container">
             <div class="ml-0 mr-0 mb-2 row">
                 <div class="col-lg-12 p-0">
                     <h4 id="show_category_{{$faq_category->faq_category_id}}" data-id="{{@$faq_category->faq_category_id}}" class="show_category align-items-center align-items-md-start d-flex justify-content-start offered-services-title mb-0 p-2 p-lg-3 themecolor expand_success">
                       @if(@$faq_category->FaqCategory->image != null && file_exists('public/uploads/image/'.@$faq_category->FaqCategory->image))
                      <img src="{{url('public/uploads/image/'.@$faq_category->FaqCategory->image)}}" class="img-fluid mr-2" style="width: 30px;height: 24px;">
                      @else
                       <img src="{{url('public/uploads/image/car.png')}}" class="img-fluid mr-2" style="width: 30px;height: 24px;">
                      @endif
                      <a href="javascript:void(0)"> 
                        @php 
                        $main_count = Faq::select('id')->where('status',1)->where('faq_category_id',@$faq_category->faq_category_id)->count();
                        @endphp

                        {{$faq_category->title}} ({{@$main_count}})</a></h4>
                  </div>

                <div class="all_spares ml-0 mr-0 col-lg-12" id="show_{{@$faq_category->faq_category_id}}">
                  <div class="row">
                <div class="col-12 col-md-12 col-sm-12 f-size1 p-0" data-id="{{@$faq_category->faq_category_id}}"> 
                  <div class="collapse d-lg-block show" id="service-bar-collape1">
                    <div class="pt-2" >
                      <ul class="list-unstyled offer-ctg-list">
                          @php
                            $faq_cat = FaqsDescription::query()->select("question","answer","language_id","faq_category_id","faq.status");
                            $faq_cat->join('faqs AS faq', 'faqs_description.faq_id', '=', 'faq.id')->where('status', 1)->where('faq_category_id', $faq_category->faq_category_id);
                            $faqs_decs = $faq_cat->where('language_id', $activeLanguage['id'])->orderBy('faqs_description.updated_at','DESC')->get();
                          @endphp
                          <div class="auto_parts_list auto_parts_list_faq">
                           @foreach(@$faqs_decs as $faqs)
                            <div>
                            <li>
                            <a href="javascript:void(0)" class="align-items-center d-flex justify-content-between">{{$faqs->question}}</a>
                            <ul class="list-unstyled custdropdown" data-id="{{$faqs->id}}" style="display: none;">
                            <li><span href="javascript:void(0)" data-id="{{$faqs->id}}" class="load_offer_services load_offer_services_faq">{!!@$faqs->answer!!}</span></li>
                            </ul>
                            </li>
                            </div>
                           @endforeach
                       </div>
                      </ul>
                    </div>
                  </div>
                </div>
                  </div>
                  <!-- Mobile Slider 1 Ends here -->
                </div>

              </div>
               </div>
          </div>
              @endforeach
              @else 
<div class="bg-white border p-md-4 p-3">
  <h4>{{__('faqs.notFound')}}</h4>
</div>
              @endif
           
         
               
        
              </div></div></div>

        </div>
        <!-- Offered Services in Estonia Ends Here -->
      </div>
      <!-- // -->
          <!-- Loader Modal -->
<div class="modal" id="loader_modal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <h3 style="text-align:center;">{{__('faqs.pleaseWait')}}</h3>
        <p style="text-align:center;"><img src="{{ asset('public/assets/img/gif/waiting.gif') }}"></p>
      </div>
    </div>
  </div>
</div>
@stop