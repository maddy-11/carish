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
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Google Ads Pages</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Add Google Ad Page</button>
  </div>

</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Google Ads Pages</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>name</th>
                <th>slug</th>
              </tr>
          </thead>
          <tbody>
            
            @foreach($ads_pages as $page)
            <tr>
            <td>
              <a data-toggle="modal" href='#editModal' class="actionicon bg-info editaction text-center" data-target="#editmodal{{$page->id}}" data-id = "{{$page->id}}"><i class="fa fa-pencil"></i></a> 
              <a  class="actionicon bg-danger deleteaction delete-btn text-center"  href="{{route('delete-google-ad-page',['id'=>$page->id])}}" ><i class="fa fa-close" onclick="return confirm('Are you sure you want to delete the record {{ @$page->page_name }} ?')"></i></a>
            </td>
            <td>{{$page->page_name !== null ? $page->page_name : '--'}}</td>
            <td>{{$page->slug}}</td>
            </tr>
            @endforeach
            
            </td>
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">   
      <!-- Modal content-->
    <form action="{{url('add/google_ad_page')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">         
          <h4 class="modal-title">Add Google Ad Page</h4>
        </div>
        <div class="modal-body">      

        <div class="col-md-">           
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input required type="text" name="name" class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="name">Slug:</label>
                    <input required type="text" name="slug" class="form-control" required="true">
                </div>
          
        </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Google Ad Page</button>            
        </div>      
      </div>
    </form>
  </div>  
</div>

@foreach($ads_pages as $page)
<div class="modal fade" id="editmodal{{$page->id}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">Edit Google Ad Page</h4>
        </div>
        <div class="modal-body">
        
        <form action="{{url('edit/google_ad_page')}}" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" value="{{$page->id}}">
           <input type="hidden" name="page_id" id="page_id">


                {{csrf_field()}}
        <div class="col-md-">
             <div class="form-group">
                    <label for="name">Name:</label>
                    <input required type="text" name="name" class="form-control" value="{{$page->page_name}}" required="true">
                </div>

                <div class="form-group">
                    <label for="name">Slug:</label>
                    <input required type="text" name="slug" class="form-control" value="{{$page->slug}}" required="true">
                </div>
        </div>
   
        </div>
        <div class="modal-footer">
           <button type="submit" class="btn" style="color: white; background-color: #5a386b">Edit Google Ad Page</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
      
    </div>
  </div>
  
</div>
@endforeach

@push('custom-scripts')
<script type="text/javascript">
  $(function(e){
    $('.table-template').DataTable({});

     @if(Session::has('page_added'))
        toastr.success('Success!',"{{Session::get('page_added')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

     @if(Session::has('message'))
        toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

     @if(Session::has('deleted'))
        toastr.success('Success!',"{{Session::get('deleted')}}" ,{"positionClass": "toast-bottom-right"});
      @endif
    
  });
</script>
@endpush
@endsection

