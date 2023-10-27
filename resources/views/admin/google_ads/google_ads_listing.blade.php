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
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Google Ads Listing</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Add Google Ad</button>
  </div>

</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Google Ads Listing</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Ad Page</th>
                <th>Position</th>
                <th>Description</th>
                <th>Title</th>
                <th>Image</th>
              </tr>
          </thead>
          <tbody>
            
            @foreach($google_ads as $page)
            <tr>
            <td>
              <a data-toggle="modal" href='#editModal' class="actionicon bg-info editaction text-center" data-target="#editmodal{{$page->id}}" data-id = "{{$page->id}}"><i class="fa fa-pencil"></i></a> 
              <a  class="actionicon bg-danger deleteaction delete-btn text-center"  href="{{route('delete-google-ad',['id'=>$page->id])}}" ><i class="fa fa-close" onclick="return confirm('Are you sure you want to delete the record {{ @$page->ad_title }} ?')"></i></a>
            </td>
            <td>{{$page->page_id !== null ? $page->ad_page->page_name : '--'}}</td>
            <td>{{$page->ad_position}}</td>
            <td>{{$page->ad_description !== null ? $page->ad_description : '--'}}</td>
            <td>{{$page->ad_title !== null ? $page->ad_title : '--'}}</td>
            <td width="20%">
              @if(@$page->img !== null)
               <img src="{{asset('public/uploads/ads/'.$page->img)}}" class="img-fluid" alt="carish used cars for sale in estonia" width="40%">
               @else
               --
              @endif
            </td>
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
    <form action="{{url('add/google_ad')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">         
          <h4 class="modal-title">Add Google Ad</h4>
        </div>
        <div class="modal-body">      

        <div class="col-md-">           
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">Select Page:</label>
                    <select name="page_name" class="form-control">
                      <option selected="true" disabled="true">--Select Page--</option>
                      @foreach(@$all_pages as $page)
                      <option value="{{@$page->slug}}">{{@$page->page_name}}</option>
                      @endforeach
                    </select>
                </div>

                 <div class="form-group">
                    <label for="name">Select Position:</label>
                    <select name="position" class="form-control">
                      <option selected="true" disabled="true">--Select Position--</option>
                      <option value="bottom">Bottom</option>
                      <option value="center">Center</option>
                      <option value="left">Left</option>
                      <option value="right">Right</option>
                      <option value="top">Top</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Ad Title:</label>
                    <input required type="text" name="title" class="form-control" required="true">
                </div>

                <div class="form-group">
                    <label for="name">Ad Link:</label>
                    <input required type="text" name="link" class="form-control" required="true">
                </div> 

                <div class="form-group">
                    <label for="name">Description:</label>
                    <!-- <input required type="text" name="description" class="form-control" required="true"> -->
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div> 
                <div class="form-group">
                  <p style="width: 100%;text-align: center;margin: 0;"><b>OR</b></p>
                </div>
                <div class="form-group">
                    <label for="name">Image:</label>
                    <input required type="file" name="logo" class="form-control">
                </div> 
          
        </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Google Ad</button>            
        </div>      
      </div>
    </form>
  </div>  
</div>

@foreach($google_ads as $page)
<div class="modal fade" id="editmodal{{$page->id}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">Edit Google Ad</h4>
        </div>
        <div class="modal-body">
        
        <form action="{{url('edit/google_ad')}}" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" value="{{$page->id}}">
           <input type="hidden" name="page_id" id="page_id">


                {{csrf_field()}}
        <div class="col-md-">

                <div class="form-group">
                    <label for="name">Select Page:</label>
                    <select name="page_name" class="form-control">
                      <option selected="true" disabled="true">--Select Page--</option>
                      @foreach(@$all_pages as $pagee)
                      <option value="{{@$pagee->slug}}" {{@$pagee->slug == @$page->page_id ? 'selected' : ''}}>{{@$pagee->page_name}}</option>
                      @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Select Position:</label>
                    <select name="position" class="form-control">
                      <option selected="true" disabled="true">--Select Position--</option>
                      <option value="bottom" {{@$page->ad_position == 'bottom' ? 'selected' : ''}}>Bottom</option>
                      <option value="center" {{@$page->ad_position == 'center' ? 'selected' : ''}}>Center</option>
                      <option value="left" {{@$page->ad_position == 'left' ? 'selected' : ''}}>Left</option>
                      <option value="right" {{@$page->ad_position == 'right' ? 'selected' : ''}}>Right</option>
                      <option value="top" {{@$page->ad_position == 'top' ? 'selected' : ''}}>Top</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Ad Title:</label>
                    <input required type="text" name="title" class="form-control" required="true" value="{{@$page->ad_title}}">
                </div>


              <div class="form-group">
                    <label for="name">Description:</label>
                    <input required type="text" name="description" class="form-control" required="true" value="{{@$page->ad_description}}">
                </div>

                <div class="form-group">
                    <label for="name">Ad Link:</label>
                    <input required type="text" name="link" class="form-control" required="true" value="{{@$page->ad_link}}">
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

     @if(Session::has('ad_added'))
        toastr.success('Success!',"{{Session::get('ad_added')}}" ,{"positionClass": "toast-bottom-right"});
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

