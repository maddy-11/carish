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
<!-- <div class="row mb-3">
  <div class="col-md-8 title-col">
    <h3 class="maintitle text-uppercase fontbold">SYSTEM Pages</h3>
  </div>
</div> -->

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Edit Page</h3>
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
       <form action="{{url('admin/update-page')}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}


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
                      <label for="name">Title In {{$language->language_title}}:</label>
                       <input  type="text" name="{{$language->language_code}}_add_title" class="form-control" value="{{$language->page_description($page->id , $language->id)->title}}" >

                      <label for="name">Content In {{$language->language_title}}:</label>
                      
                      
                      <textarea id="content" name="{{$language->language_code}}_add_content" class="form-control ckeditor" rows="10" cols="70" >{{$language->page_description($page->id , $language->id)->description}}</textarea>


                  </div> 
                </div> 
                @endforeach
            </div>

        
        <!-- aaa -->

         {{-- <div class="form-group">
          <label for="subject" class="font-weight-bold">Page Slug <span class="text-danger">*</span></label>
          <input  type="text" name="page_slug" class="form-control"  required placeholder="Enter Page Slug" value="{{$page->slug}}">         
        </div> --}}

        <div class="form-group">
          <label for="subject" class="font-weight-bold">Sort Order <span class="text-danger">*</span></label>
          <input  type="number" name="sort_order" class="form-control"  required placeholder="Enter Sort Order" value="{{$page->sort_order}}">         
        </div>

        <!-- <div class="form-group"> 
          <label for="subject" class="font-weight-bold">Default Language:<span class="text-danger">*</span></label>
          <select class="form-control text-capitalize" name="language_id">
            <option value="">--Select Language--</option>
            @foreach($languages as $language)
              <option value="{{$language->id}}">{{$language->language_title}}</option>
            @endforeach
          </select>
        </div> -->
        <input type="hidden" name="page_id" value="{{$page->id}}">
        <div class="form-group">
          <button type="submit" class="btn btn-primary pull-right" >Edit Page</button>  
        </div>
        </form>
      </div>
    </div>
    </div>




@push('custom-scripts')
<script type="text/javascript"></script>
@endpush
@endsection

