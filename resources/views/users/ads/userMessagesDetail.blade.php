@extends('layouts.app')

@section('content')

<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
  <div class="container">
    <div class="row ml-0 mr-0">
      @include('users.ads.profile_tabes')
    </div>

    <div class="tab-content profile-tab-content">
      <!-- Tab 4 starts here -->
      <div class="tab-pane active" id="profile-tab4">
        <div class="bg-white">
          <div class="table-responsive">

            @if(isset($left_chat_menu))


            @foreach(@$left_chat_menu as $result)
            <div class="messages-col_{{$result['chat_id']}}">
              <div class="border-bottom mx-auto px-2 py-3 row">
                <div class="col-md-8 col-sm-8 col-12 message-title-col">
                  <h4> <a href="{{url(@$result['ad_url'])}}" class="themecolor" target="_blank"> {{$result['ad_title']}}</a></h4>
                  <p class="messages-posted-time mb-0">{{$result['created_at'] }}</p>
                </div>
                <div class="col-md-4 col-sm-4 col-12 message-backto text-right">
                  <a target="" href="{{route('my-messages')}}" class="font-weight-semibold themecolor"><em class="fa fa-chevron-circle-left"></em> {{ __('dashboardMessages.backToDashboard') }}</a>
                </div>
              </div>
              <div class="p-4">
                <div id="show_chat_detail">
                  <div class="messages-content">
                    @foreach($result['chat_detail'] as $chat)
                    @if($chat['from_id'] == Auth::guard('customer')->user()->id)
                    @php
                    $msg_class = "sender-message ml-auto";
                    $msg_sub_class = "sender-mesg-bg";
                    @endphp
                    @else
                    @php
                    $msg_class = "reciever-message";
                    $msg_sub_class = "reciever-mesg-bg";
                    @endphp
                    @endif

                    <div class=" {{$msg_class}} focus-here">
                      <div class=" {{$msg_sub_class}} p-3 text-white">
                        <p class="mb-0"><b>{{$chat['from_message']}}:</b> {!!@$chat['message']!!} </p>
                        <p class="mb-0" p> {{$chat['created_at']}} </p>
                      </div>
                    </div>
                    @endforeach 
                  </div>
                  <div id="focus-here"></div>
                  @if($ads_status == '1')
                  <form method="post" id="send-message">
                    {{csrf_field()}}

                    <div class="message-area mt-5 pt-3">
                      <div class="form-group">
                        <textarea id="description" name="messageArea" rows="5" class="form-control mb-1" placeholder="{{ __('dashboardMessages.textBoxDefaultTextOnReplyMessagePage') }}" required></textarea>

                        <div class="about-message-field mt-1">
                          <span class="font-weight-semibold">{{__('dashboardMessages.remainingChar')}} <span id="description_count">250</span></span>
                        </div>

                      </div>
                      <div class="form-group">
                        <input type="hidden" value="" name="timezone" id="timezone">
                        <input type="hidden" name="chat_id" id="chat_id" value="{{$result['chat_id']}}">
                        <input type="hidden" name="user_id" id="user_id" value=" {{$result['user_id']}} ">
                        <input type="submit" name="Submit" value="Submit" class="btn themebtn1 pl-5 pr-5">
                      </div>
                    </div>
                  </form>
                  @endif
                </div>
              </div>
            </div>
            @endforeach
            @else
            <h3 class="p-2">{{ __('dashboardMessages.noMessages') }}</h3>
            @endif
          </div>
        </div>
        <!-- Tab 4 ends here -->
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script>
<script type="text/javascript">
  // to make that field on its orignal state
  $(document).ready(function() {

    $('html, body').animate({
        scrollTop: $('.messages-content').position().top
    }, 'slow', function() {
      $('.messages-content').animate({
        scrollTop: $('.messages-content .focus-here:last-child').position().top
    }, 'slow');
  }); 


    


    $(document).on("keyup focusout", ".search_chat", function(e) {
      if (e.keyCode == 13) {
        // alert('hi');
      }
    });
    $("#description").keyup(function(e) {
      // alert('hi');
      $("#description").prop('maxlength', '250');
      var max = 250;
      var text = $('#description').val().length;
      var remaining = max - text;
      $('#description_count').html(remaining);
      if (max < $('#description').val().length) {
        $("#description_error").html("Maximun letter 250").show().fadeOut("slow");
        return false;
      }
    });

  });

  $('#send-message').on('submit', function(e) {
    e.preventDefault();
    var timezone = moment.tz.guess();
    $('#timezone').val(timezone);
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    $.ajax({
      url: "{{ route('send-message-to-customer-from-chat-box') }}",
      dataType: 'json',
      method: "post",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function(response) {
        if (response.success === true) {
          toastr.success('Success!', 'Message Send Successfully.', {
            "positionClass": "toast-bottom-right"
          });
          $('#send-message')[0].reset();
          location.reload();
        }
      }
    });
  });
</script>
@endpush
@endsection