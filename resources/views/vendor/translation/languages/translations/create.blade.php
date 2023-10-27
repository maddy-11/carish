@extends('translation::layout')

@section('body')

            

        <div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize"> {{ __('translation::translation.languages') }}</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right"> 

       <a href="{{ route('languages.create') }}" class="button" class="btn btn-info">
                        {{ __('translation::translation.add') }}
                    </a>

  </div>

</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1"> {{ __('translation::translation.add_translation') }}</h5>
      </div>
      <div class="table-responsive">

        <form action="{{ route('languages.translations.store', $language) }}" method="POST">

            <fieldset>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="panel-body p-4">

                    @include('translation::forms.text', ['field' => 'group', 'label' => __('translation::translation.group_label'), 'placeholder' => __('translation::translation.group_placeholder')])
                    
                    @include('translation::forms.text', ['field' => 'key', 'label' => __('translation::translation.key_label'), 'placeholder' => __('translation::translation.key_placeholder')])

                    @include('translation::forms.text', ['field' => 'value', 'label' => __('translation::translation.value_label'), 'placeholder' => __('translation::translation.value_placeholder')])
                    
                    <div class="input-group">

                        <button v-on:click="toggleAdvancedOptions" class="text-blue">{{ __('translation::translation.advanced_options') }}</button>

                    </div>

                    <div v-show="showAdvancedOptions">

                        @include('translation::forms.text', ['field' => 'namespace', 'label' => __('translation::translation.namespace_label'), 'placeholder' => __('translation::translation.namespace_placeholder')])
                    
                    </div>

  
                </div>

            </fieldset>

            <div class="panel-footer flex flex-row-reverse">

                <button class="button button-blue">
                    {{ __('translation::translation.save') }}
                </button>

            </div>

        </form>

    </div>
   </div>
  </div>

</div>


@endsection