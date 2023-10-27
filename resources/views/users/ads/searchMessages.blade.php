@extends('layouts.app')
@push('styles')
<style type="text/css">
.table-responsive {  
    height: 400px !important; 
}
</style>
@endpush
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
                  <table class="table table-striped">
                  <thead>
                    <tr>
                      <th class="border-bottom">{{ __('dashboardMessages.subject') }}</th>
                      <th class="border-bottom">
                      <form action="{{route('search-messages')}}" method="GET" name="" class="pull-right">
                          <div class="input-group messages-search border mx-auto">
                          <input id="searchmsg" type="text" name="title" class="form-control border-0 search_chat" placeholder="{{ __('dashboardMessages.searchBarDefaultText') }}"
                          value="{{@$term}}">
                            <div class="input-group-append">
                              <button class="fa fa-search pl-3 pr-3 border-0" type="submit"></button>
                            </div>
                          </div>   
                        </form>                           
                      </th>
                      <th class="border-bottom">{{ __('dashboardMessages.date') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach(@$left_chat_menu as $result)
                      <tr>
                        <td colspan="2" class="message-title" data-user_id='{{$result["user_id"]}}'  data-chat_id='{{$result["chat_id"]}}'>
                          <a href="{{route('my.message.detail',['id'=>@$result['chat_id']])}}"  class="themecolor" > {{$result['ad_title']}}</a>({{$result['name']}})</td>
                        <td>{{$result['created_at'] }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                  </table>
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
<script>
var message_filter = "{{route('message.filter')}}";
  $(document).ready(function() {
    $("#searchmsg").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: message_filter,
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) { }
    });

 
      $(document).on("keyup focusout",".search_chat",function(e) {
          if(e.keyCode == 13)
          {
            // alert('hi');
          }
      });
   });

   $('#send-message').on('submit',function(e){
    e.preventDefault();
    // alert('alert created');
     $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
  });
     $.ajax({
              url: "{{ route('send-message-to-customer-from-chat-box') }}",
      dataType: 'json',
              method:"post",
               data: new FormData(this), 
                contentType: false,       
      cache: false,             
      processData:false,
              success: function(response){
                if(response.success === true){
                  toastr.success('Success!', 'Message Send Successfully.',{"positionClass": "toast-bottom-right"});
                  $('#send-message')[0].reset();
                }
              }
            });
   });

</script>
@endpush
@endsection