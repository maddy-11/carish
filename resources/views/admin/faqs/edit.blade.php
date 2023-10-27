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

</style>

{{-- Content Start from here --}}
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Edit Faq</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    <a class="btn btn-primary" href="{{ url()->previous() }}">
      <i class="fa fa-arrow-left"></i> Back
    </a>
  </div>

</div>

<div class="row entriestable-row mt-3">
  <div class="col-12">
      <div class="col-sm-8">
       <form action="{{url('admin/update-faq')}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}

            <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $language)
                <li class="nav-item">
                  <a class="nav-link @if($loop->iteration == 1) active @endif" data-toggle="tab" href="#{{$language->language_code }}" role="tab">{{$language->language_title}}</a>
                </li> 
                @endforeach

            </ul>

      

          <div class="form-group">
          <label for="subject" class="font-weight-bold">Select Category <span class="text-danger">*</span></label>
           <select name="faq_category_id" required="required" class="form-control" >
             <option value="">Select Category</option>
             @foreach($faq_category_decs as $faq_category_des)
             <option value="{{$faq_category_des->faq_category_id}}" @if(@$faq_category_des->faq_category_id == $faq->faq_category_id) {{ "selected" }} @endif>{{$faq_category_des->title}}</option>
            @endforeach
           </select>                 
        </div>


            <div class="tab-content"> 
                @foreach($languages as $language)
                <div class="tab-pane @if($loop->iteration == 1) active @endif" id="{{$language->language_code }}" role="tabpanel">
                  <div class="form-group">
                      <label for="name">Question In {{$language->language_title}}:</label>
                       <input  type="text" name="{{$language->language_code}}_question" class="form-control" value="{{$language->faq_description($faq->id , $language->id)->question}}" >

                      <label for="name">Answer In {{$language->language_title}}:</label>
                      
                      
                      <textarea id="content" name="{{$language->language_code}}_answer" class="form-control ckeditor" rows="10" cols="70" >{{$language->faq_description($faq->id , $language->id)->answer}}</textarea>


                  </div> 
                </div> 
                @endforeach
            </div>

        
        <!-- aaa -->

       

        <input type="hidden" name="faq_id" value="{{$faq->id}}">
        <div class="form-group">
          <button type="submit" class="btn btn-primary pull-right" >Edit Faq</button>  
        </div>
        </form>
      </div>
    </div>
    </div>




@push('custom-scripts')
<script type="text/javascript"></script>
@endpush
@endsection

