@extends('layouts.app')
@push('styles')
<style type="text/css">
  .table-responsive {
    max-height: 400px !important;
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
      <div class="tab-pane active" id="profile-tab4">
        <div class="bg-white">
          <div class="table-responsive">
            <table class="table table-striped" style="margin-bottom:0px;">
              @if(!empty($left_chat_menu))
              <thead>                
                <tr>
                  <th class="border-bottom">{{ __('dashboardMessages.subject') }}</th>
                  <th>
                    <form action="{{route('search-messages')}}" method="GET" name="" class="pull-right">
                      <div class="input-group messages-search border mx-auto">
                        <input id="searchmsg" type="text" name="title" class="form-control border-0 search_chat" placeholder="{{ __('dashboardMessages.searchBarDefaultText') }}">
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
                  <td colspan="2" class="message-title" data-user_id='{{$result["user_id"]}}' data-chat_id='{{$result["chat_id"]}}'>
                    <a href="{{route('my.message.detail',['id'=>@$result['chat_id']])}}" class="themecolor">
                      @if($result['isbold'] == 1)
                      <b>{{$result['ad_title']}}</b>
                      @else
                      {{$result['ad_title']}}
                      @endif
                    </a>
                    @if($result['isbold'] == 1)
                    <b>({{$result['name']}})</b>
                    @else
                    ({{$result['name']}})
                    @endif
                  </td>
                  <td>
                    @if($result['isbold'] == 1)
                    <b>{{$result['created_at'] }}</b>
                    @else
                    {{$result['created_at'] }}
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody> 
              @else
              <thead>                
                <tr>
                  <th colspan="3" style="text-align: center;">
                    <h3>{{ __('dashboardMessages.noMessages') }}</h3>
                  </th>
                </tr>
              </thead>
            @endif
            </table>
          </div>
        </div>
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
      select: function(event, ui) {}
    });


  }); // END DOCUMENTREADY
</script>
@endpush
@endsection