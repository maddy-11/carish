@extends('admin.layouts.app')

@section('content')
<style type="text/css">
.invalid-feedback {
     font-size: 100%; 
}
.disabled:disabled{
  opacity:0.5;
  cursor: not-allowed; 
}
.ck.ck-content.ck-editor__editable {
    height: 180px;
}

</style>

{{-- Content Start from here --}}

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Add New Template</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    <a class="btn btn-primary" href="{{ url()->previous() }}">
      <i class="fa fa-arrow-left"></i> Back
    </a>
  </div>

</div>


<div class="row entriestable-row mt-3">
      <div class="col-8">
       <form action="{{url('admin/store-template')}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="type" class="font-weight-bold">Type <span class="text-danger">*</span></label>

           <select name="type"  class="form-control" required>
            <option value="">{{'Select a Type'}}</option>
            @foreach($emailTypes as $type)
            <option value="{{@$type->id}}">{{@$type->type}}</option>
            @endforeach
          </select>
                
          @if ($errors->has('type'))
              <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('type') }}</strong>
              </span>
          @endif
        </div>
        <!-- aaa -->


            <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#{{$language->language_code }}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach

            </ul>

            <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="{{$language->language_code }}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Subject In {{$language->language_title}}:</label>
                       <input  type="text" name="{{$language->language_code}}_add_subject" class="form-control" >

                      <label for="name">Content In {{$language->language_title}}:</label>
                      
                      
                      <textarea id="content" name="{{$language->language_code}}_add_content" class="email-content form-control ckeditor" rows="10" cols="70" ></textarea>


                  </div> 
                </div> 
                @endforeach
            </div>

        
        <!-- aaa -->
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Add Template</button>  
        </div>
        </form>
      </div>
      <div class="col-4 mt-4 pt-2 bg-light-blue">
        <div class="border p-3 ">
          <strong>Note: </strong>Please copy and paste the following variables in the editor as they are.
          <p class="mb-1">[[name]]</p>
         <!--  <p class="mb-1">[[first_name]]</p>
          <p class="mb-1">[[last_name]]</p> -->
          <p class="mb-1">[[email]]</p>
          <p class="mb-1">[[password]]</p>
          <p class="mb-1">[[link]]</p>
          <p class="mb-1">[[body]]</p>
          <p class="mb-1">[[reason]]</p>
          <p class="mb-1">[[ads_title]]</p>
          <p class="mb-1">[[invoice_number]]</p>
          <p class="mb-1">[[invoice_link]]</p>
          <p class="mb-1">[[invoice_attachment]]</p>
        </div>
      </div>
</div>

<!--  Content End Here -->

@push('custom-scripts')
<script type="text/javascript">
  
</script>
@endpush
@endsection


