@extends('admin.layouts.app')
@section('content')

    <form action="{{ route('languages.translations.index', ['language' => $language]) }}" method="get">

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">    {{ __('translation::translation.translations') }}
</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right"> 
  </div>

</div>

           <div class="table-responsive">

              @include('translation::forms.search', ['name' => 'filter', 'value' => Request::get('filter')])

                    @include('translation::forms.select', ['name' => 'language', 'items' => $languages, 'submit' => true, 'selected' => $language])

        @include('translation::forms.select', ['name' => 'group', 'items' => $groups, 'submit' => true, 'selected' => Request::get('group'), 'optional' => true])
                    <button type="submit" class="button"> Search </button>
                   <!--  <a href="{{ route('languages.translations.create', $language) }}" class="button">
                        {{ __('translation::translation.add') }}
                    </a> -->

                @if(count($translations))

                  <table id="example" class="table table-bordered" style="width:100%">

                        <thead>
                            <tr>
                                <th class="w-1/5 uppercase font-thin">{{ __('translation::translation.group_single') }}</th>
                                <th class="w-1/5 uppercase font-thin">{{ __('translation::translation.key') }}</th>
                                <th class="uppercase font-thin">{{ config('app.locale') }}</th>
                                <th class="uppercase font-thin">{{ $language }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($translations as $type => $items)
                                
                                @foreach($items as $group => $translations)

                                    @foreach($translations as $key => $value)

                                        @if(!is_array($value[config('app.locale')]))
                                            <tr>
                                                <td>{{ $group }}</td>
                                                <td>{{ $key }}</td>
                                                <td>{{ $value[config('app.locale')] }}</td>
                                                <td>
                                                    <translation-input 
                                                        initial-translation="{{ $value[$language] }}" 
                                                        language="{{ $language }}" 
                                                        group="{{ $group }}" 
                                                        translation-key="{{ $key }}" 
                                                        route="{{ config('translation.ui_url') }}">
                                                    </translation-input>
                                                </td>
                                            </tr>
                                        @endif

                                    @endforeach

                                @endforeach
                                           
                            @endforeach
                        </tbody>

                    </table>

                @endif

            </div>

        </div>

    </form>

@endsection