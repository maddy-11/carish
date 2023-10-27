@extends('layouts.app')

@push('scripts')
 <script>
 var max  = 995;
 $(document).ready(function(){
   
   $("#reset").click(function(){
     $('#description_count').html(max);
     $('#description').val('');
   });

   var text = $('#description').val().length;
   var remaining = max - text;
   $('#description_count').html(remaining);
 });   
          function getSentence(e) { 
            var sentence     = $(e).data('sentence');
            var id           = $(e).data('id');    
            var old_sentense = $('#description').val();
            var new_sentense = old_sentense +'.' + sentence;
            $('#description').val(new_sentense);
            var field        = '<input type="hidden" name="tags[]" value="'+id+'"><input type="hidden" name="suggessions[]" value="'+sentence+'">';
            $('.suggestions-tags').append(field);
            $(e).hide();
        }

      $("#description").keyup(function (e) {
      $("#description").prop('maxlength', '995');
      var text = $('#description').val().length;
      var remaining = max - text;
      $('#description_count').html(remaining);
      
      if(max == $('#description').val().length){
          $("#description_error").html("Maximun letter 995").show().fadeOut("slow");
                return false;
        }
    });

</script>
@endpush

@section('content')
<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
  <div class="container">
       @if(count($errors) > 0)
    <div class="alert alert-danger">
     Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif
   @if(session()->has('error'))
     <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif

   @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
    <div class="row ml-0 mr-0">
          @include('users.ads.adsTabes')
      </div>

      <div class="tab-content profile-tab-content">
        <!-- Tab 1 starts here -->
        <div class="tab-pane active" id="profile-tab1">
            <div class="row ad-tab-row">
              <div class="ad-tab-sidebar col-lg-3 col-md-4">
              @include('users.ads.side_bar')</div>
              <div class="col-lg-9 col-md-8 mt-md-0 mt-4 pl-md-0 pl-lg-3 ad-tab-desc">
               <div class="tab-content">
               <div class="tab-pane active" id="ad-tab1"> 
                <div class="align-items-center d-flex justify-content-between mb-md-3 mb-2"> 
                </div>
                <div class="bg-white border">
                  <div class="ads-listing-rows filtered_ads">
                    @php 
                    $language         = Session::get('language');
                    $activeLanguage   = $language['id'];
                    $suggessions_ads = $adsDetails->suggessions; 
                    @endphp  
                    
    <form action="{{route('description.update')}}" method="post" id="myForm" class="form-horizontal" enctype="multipart/form-data" >
      {{csrf_field()}}
    <div class="col-12 bg-white p-md-4 p-3 pb-sm-5 pb-4">
        <h2 class="border-bottom mx-md-n4 mx-n3 pb-3 px-md-4 px-3 mb-sm-5 mb-4 themecolor">{{__('ads.post_an_ad')}}</h2>
        <input type="hidden" name="language_id" value="{{$activeLanguage}}">
        <input type="hidden" name="id" value="{{$adsDetails->id}}">

  <!-- Vehicle Information section starts here -->
        <div class="post-an-ad-sects"> 
          <h4 class="mx-md-n4 mx-n3 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold"> {{__('ads.vehicle_information')}}</h4>
          <div class="vehicleInformation">
          <div class="mb-3 row">
             <div class="ml-auto mr-auto col-lg-4 col-md-6 col-12 mandatory-note font-weight-semibold">
              <span> ({{__('ads.all_fields_mandatory')}})</span>
            </div>
          </div> 
          <div class="form-group mb-4 row">
            <div class="col-md-4 mt-md-3 pt-md-2 text-md-right">
              <label class="mb-0 text-capitalize">{{__('ads.ad_description')}}<sup class="text-danger">*</sup></label>
            </div>
            <div class="col-lg-6 col-md-8 col-12">
              <div class="about-message-field text-right font-weight-semibold mb-1">
                <span id="description_count">{{__('ads.remaining_characters')}} 995</span>
                <a href="javascript:void(0)" id="reset" class="reset-message d-inline-block ml-2 themecolor">{{__('ads.reset')}}</a>
              </div>
               <p id="description_error" class="m-0"></p>
              <textarea id="description" class="form-control" rows="6" name="description"  placeholder="Describe your vehicle: Example: Alloy rim, first owner, genuine parts, maintained byauthorized workshop, excellent mileage, original paint etc.">{{@$descript->description}}</textarea>    

              <div class="add-suggestion border mt-2 p-3">
                <p> {{__('ads.you_can_also_use_suggestions')}}</p>
                <div class="suggestions-tags">
                  @foreach($suggestions as $suggestion)
                  <a href="JavaScript:Void(0);" class=""><span class="label label-info bgcolor1 badge badge-pill pl-sm-3 pr-sm-3 pr-2 pl-2 text-white mb-2" data-id="{{$suggestion->id}}" data-sentence="{{$suggestion->sentence}}" onclick="getSentence(this)">{{$suggestion->title}}</span></a>
                  @endforeach

                  @foreach($suggessions_ads as $suggestion)
                   <input type="hidden" name="tags[]" value="{{$suggestion->id}}">
                   <input type="hidden" name="suggessions[]" value="{{$suggestion->sentence}}"> 
                 @endforeach
                </div>
              </div>
              <div class="border border-top-0 pb-2 pl-3 pr-3 pt-2 show-more-suggestion text-center">
                <a href="#" class="font-weight-bold themecolor">{{__('ads.show_more')}}</a>
              </div>
            </div>
          </div>  
        </div>
        </div>
   <!-- Vehicle Information section ends here -->  

    <div class="border-top mx-n4 pt-4 pt-sm-5 px-4 mt-sm-5 mt-4 text-center">
      <input type="submit" class="btn pb-3 pl-4 post-ad-submit pr-4 pt-3  themebtn1" value="{{__('ads.submit_and_continue')}}">
    </div>
    </div>
   </form>

                  </div>{{-- END OF CONTAINER --}}
                </div>
              </div>
               </div> 
           </div>
         </div>
        </div>
        <!-- Tab 1 ends here -->        
      </div>
    </div>
@endsection