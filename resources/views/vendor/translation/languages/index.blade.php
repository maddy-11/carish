@extends('admin.layouts.app')
@section('content')
 @if(count($languages)) 

  <div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize"> {{ __('translation::translation.languages') }}</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right"> 

    <!--    <a href="{{ route('languages.create') }}" class="button" class="btn btn-info">
                        {{ __('translation::translation.add') }}
                    </a> -->

  </div>

</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1"> {{ __('translation::translation.languages') }}</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
                        <tr>
                            <th>{{ __('translation::translation.language_name') }}</th>
                            <th>{{ __('translation::translation.locale') }}</th>
                        </tr>
                    </thead>
           <tbody>
                        @foreach($languages as $language => $name)
                            <tr>
                                <td>
                                    {{ $name }}
                                </td>
                                <td>
                                    <a href="{{ route('languages.translations.index', $language) }}">
                                        {{ $language }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
      </table>
    </div>
   </div>
  </div>

</div>

    @endif

@endsection