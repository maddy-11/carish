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
    <h3 class="maintitle text-uppercase fontbold">SYSTEM EMAIL TEMPLATES</h3>
  </div>
</div> -->

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">SYSTEM EMAIL TEMPLATES</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <a type="button" class="btn btn-primary" href="{{url('admin/create-template')}}" style="float: right">Add New Template</a>
  </div>

</div>


<!-- <a type="button" class="btn btn-info" href="{{url('admin/create-template')}}" style="float: right">Add New Template</a> -->

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">SYSTEM EMAIL TEMPLATES</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Type</th>
                <th>Subject</th>
                <th>Last Updated By</th>
                <th>Status</th>
              </tr>
          </thead>
          <tbody>
            
            @foreach($templates as $tem)
            <tr>
            <td>
              <a target="" href="{{url('admin/edit-template',$tem->id)}}" class="bg-info actionicon bg-info editaction text-center"><i class="fa fa-pencil"></i></a>
               <a  class="actionicon bg-danger deleteaction delete-btn"  href="{{route('delete-email-template',['id'=>$tem->id])}}" style="padding-left: 6px;"><i class="fa fa-close" onclick="return confirm('Are you sure you want to delete the record {{ @$tem->emailTemplateDescription[0]->subject }} ?')"></i></a>
            </td>
            <td>{{$tem->emailType !== null ? $tem->emailType->type : '--'}}</td>
            <td>{{@$tem->emailTemplateDescription[0]->subject}}</td>
            <td>{{$tem->users->name}}</td>
            <td>{{$tem->status ? "Active" : "Non Active"}}</td>
            </tr>
            @endforeach
            
            </td>
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div>


 <!-- <div style="margin-top: 40px">
   <table id="myTable" class="table table-template" >
      <thead class="text-center">
          <tr>
              <th>Action</th>
              <th>Type</th>
              <th>Subject</th>
              <th>Last Updated By</th>
              <th>Status</th>
          </tr>
      </thead>
      <tbody>
        @foreach($templates as $tem)
        <tr>
        <td><a target="" href="{{url('admin/edit-template',$tem->id)}}"><i class="fa fa-pencil"></i></a></td>
        <td>{{$tem->type}}</td>
        <td>{{$tem->subject}}</td>
        <td>{{$tem->users->name}}</td>
        <td>{{$tem->status ? "Active" : "Non Active"}}</td>
        </tr>
        @endforeach
      </tbody>
              
   </table>
 </div> -->
<!--  Content End Here -->



@push('custom-scripts')
<script type="text/javascript">
  $(function(e){
    $('.table-template').DataTable({});

    @if(Session::has('successmsg'))
        toastr.success('Success!', "{{ Session::get('successmsg') }}",{"positionClass": "toast-bottom-right"});        
    @endif

     @if(Session::has('deleted'))
        toastr.error('Success!',"{{Session::get('deleted')}}" ,{"positionClass": "toast-bottom-right"});
      @endif
    
  });
</script>
@endpush
@endsection

