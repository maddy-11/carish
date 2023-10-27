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
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Faqs</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <a type="button" class="btn btn-primary" href="{{url('admin/create-faq')}}" >Add New Faq</a>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Faqs</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>#</th>
                <th>Category</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Status</th>
              </tr>
          </thead>
          <tbody>
            @foreach($getfaqs as $faq_descp)
            <tr id="id_{{$faq_descp->faq_id}}">
            <td>
              <div class="d-flex text-center">
              <a target="" href="{{url('admin/edit-faq/'.$faq_descp->faq_id)}}" class="actionicon bg-info editaction text-center"><i class="fa fa-pencil"></i></a>
              <a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id = "{{$faq_descp->faq_id}}"><i class="fa fa-close"></i></a>
            </div>
            </td>
            <td>{{$loop->iteration }}</td>
            <td>{{$faq_descp->faqcategory($faq_descp->faq_category_id,$faq_descp->language_id)}}</td>
            <td>{{$faq_descp->question}}</td>
            <td>{{ str_limit(strip_tags($faq_descp->answer),100)}}</td>
            <td>{{$faq_descp->status}}</td>
            </tr>
            @endforeach
            </td>
          </tbody>
      </table>
    </div>
   </div>
  </div>
</div>
@push('custom-scripts')
<script type="text/javascript">
$(function(e){
  $('.table-pages').DataTable({});
  @if(Session::has('successmsg'))
    toastr.success('Success!', "{{ Session::get('successmsg') }}",{"positionClass": "toast-bottom-right"});        
  @endif
});
$(function(e){
  $(document).on('click', '.delete-btn', function(){
    var id = $(this).data('id');
    swal({
      title: "Alert!",
      text: "Are you sure you want to Delete this Faq?",
      type: "info",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes!",
      cancelButtonText: "No!",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm) {
      if (isConfirm){
        $.ajax({
          method:"get",
          dataType:"json",
          data:{id:id},
          url:"{{ route('delete-faq') }}",
          success:function(data){
              if(data.success == true){
               $("#id_"+id).remove();
                toastr.success('Success!', data.message ,{"positionClass": "toast-bottom-right"});
              }
          }
        });
      } 
      else{
        swal("Cancelled", "", "error");
      }
       
    });
  });
});

</script>
@endpush
@endsection