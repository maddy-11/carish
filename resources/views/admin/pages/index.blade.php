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
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">System Pages</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <a type="button" class="btn btn-primary" href="{{url('admin/create-page')}}" >Add New Page</a>
  </div>

</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">System Pages</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>#</th>
                <th>Title</th>
                <th>Content</th>
                <th>slug</th>
                <th>Language</th>
                <th>Status</th>
              </tr>
          </thead>
          <tbody>
            
            @foreach($page_descriptions as $desc)
            <tr>
            <td><a target="" href="{{url('admin/edit-desc/'.$desc->page_id)}}" class="actionicon bg-info editaction text-center"><i class="fa fa-pencil"></i></a></td>
            <td>{{$desc->page_id}}</td>
            <td>{{$desc->title}}</td>
            <td>{{ str_limit(strip_tags($desc->description),100)}}</td>
            <td>{{$desc->page->slug}}</td>
            <td>{{$desc->language->language_title  }}</td>
            <td>{{$desc->page->status  }}</td>
            </tr>
            @endforeach
            
            </td>
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div>

<!-- <a type="button" class="btn btn-info" href="{{url('admin/create-page')}}" style="float: right">Add New Pages</a> -->
 <!-- <div style="margin-top: 40px">
   <table id="myTable" class="table table-pages" >
      <thead class="text-center">
          <tr>
              <th>#</th>
              <th>Title</th>
              <th>Content</th>
              <th>Language Code</th>
              <th>Status</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
        @foreach($page_descriptions as $desc)
        <tr>
        <td>{{$desc->page_id}}</td>
        <td>{{$desc->title}}</td>
        <td>{{ str_limit($desc->description,100)}}</td>
        <td>{{$desc->language_code  }}</td>
        <td>{{$desc->page->status  }}</td>
        <td><a target="" href="{{url('admin/edit-desc',$desc->id)}}"><i class="fa fa-pencil"></i></a></td>
        </tr>
        @endforeach
      </tbody>
              
   </table>
 </div> -->
<!--  Content End Here -->



@push('custom-scripts')
<script type="text/javascript">
  $(function(e){
    $('.table-pages').DataTable({});

    @if(Session::has('successmsg'))
        toastr.success('Success!', "{{ Session::get('successmsg') }}",{"positionClass": "toast-bottom-right"});        
    @endif
    
  });
</script>
@endpush
@endsection

