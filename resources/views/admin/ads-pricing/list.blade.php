@extends('admin.layouts.app')
@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Ads Pricing</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right">Add Pricing</button>
  </div>
</div>
@if(session()->has('message'))
<div class="alert alert-success  alert-block">
   <button type="button" class="close" data-dismiss="alert">×</button>
   {{ session()->get('message') }}
</div>
@endif
<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Ads Pricing List</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>User Type</th>
                <th>Pricing For</th>
                <th>Number Of Days</th>
                <th>Amount</th>
              </tr>
          </thead>
          <tbody>
            @foreach($ads_pricing as $pricing)
             <tr id="pricing_id_{{$pricing->id}}">                
                <td>
                  <div class="d-flex text-center">
                    <a data-toggle="modal" href='#editModal' class="actionicon bg-info editaction" data-target="#editmodal{{$pricing->id}}" data-id="{{@$pricing->id}}"><i class="fa fa-pencil"></i></a> 
                    <a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id ="{{$pricing->id}}"><i class="fa fa-close"></i></a>
                  </div>
                </td>
                <td>{{$pricing->user_category}}</td>
                <td>{{$pricing->type}}</td>
                <td>{{$pricing->number_of_days}}</td>
                <td>{{$pricing->pricing}}</td>
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
    <form action="{{url('admin/add/pricing')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Pricing</h4>
         </div>
         <div class="modal-body">
            <div class="col-md-">
                  {{csrf_field()}}
                   <div class="form-group">
                     <label for="days">User Category:</label>
                     <select class="form-control" name="user_category" required>
                         <option value="">Select User Type</option>
                         <option value="Business">Business</option>
                         <option value="Individual">Individual</option>
                     </select>
                   </div>
                   <div class="form-group">
                     <label for="days">Pricing For:</label>
                     <select class="form-control" name="pricing_for" required>
                         <option value="">Select Pricing For</option>
                         <option value="Car Ad">Car Ad</option>
                         <option value="SparePart Ad">Spare Part Ad</option>
                         <option value="Offer Service Ad">Offer Service Ad</option>
                         <option value="Feature Car Ad">Feature Car Ad</option>
                         <option value="Feature SparePart Ad">Feature Spare Part Ad</option>
                         <option value="Feature Offer Service Ad">Feature Offer Service Ad</option>
                     </select>
                   </div>
                   <div class="form-group">
                     <label for="days">Number Of Days:</label>
                     <input  type="number" name="days" class="form-control" placeholder="Days" required>
                  </div>

                  <div class="form-group">
                     <label for="days">Amount:</label>
                     <input  type="text" name="pricing" class="form-control" placeholder="Pricing" required>
                  </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Pricing</button>
            </div>
      </div>
    </form>
   </div>
</div>
@foreach($ads_pricing as $pricing)
<div class="modal fade" id="editmodal{{$pricing->id}}" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <form action="{{url('admin/update/pricing')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit Ads Pricing</h4>
         </div>
         <div class="modal-body">
               <input type="hidden" name="id" value="{{$pricing->id}}">
           <input type="hidden" name="pricing_id" id="pricing_id" value="{{$pricing->id}}">

               {{csrf_field()}}

                <div class="col-md-">
                  <div class="form-group">
                     <label for="days">User Category:</label>
                     <select class="form-control" name="edit_user_category" required>
                         <option value="">Select User Type</option>
                         <option value="Business" {{@$pricing->user_category == 'Business' ? 'selected' : ''}}>Business</option>
                         <option value="Individual" {{@$pricing->user_category == 'Individual' ? 'selected' : ''}}>Individual</option>
                         
                     </select>
                   </div>
                   <div class="form-group">
                     <label for="days">Pricing For:</label>
                     <select class="form-control" name="edit_pricing_for" required>
                         <option value="">Select Pricing For</option>
                         <option value="Car Ad" {{@$pricing->type == 'Car Ad' ? 'selected' : ''}}>Car Ad</option>
                         <option value="SparePart Ad" {{@$pricing->type == 'SparePart Ad' ? 'selected' : ''}}>Spare Part Ad</option>
                         <option value="Offer Service Ad" {{@$pricing->type == 'Offer Service Ad' ? 'selected' : ''}}>Offer Service Ad</option>
                         <option value="Feature Car Ad" {{@$pricing->type == 'Feature Car Ad' ? 'selected' : ''}}>Feature Car Ad</option>
                         <option value="Feature SparePart Ad" {{@$pricing->type == 'Feature SparePart Ad' ? 'selected' : ''}}>Feature Spare Part Ad</option>
                         <option value="Feature Offer Service Ad" {{@$pricing->type == 'Feature Offer Service Ad' ? 'selected' : ''}}>Feature Offer Service Ad</option>
                     </select>
                   </div>  
                  <div class="form-group">
                     <label for="days">Number Of Days:</label>
                     <input  type="number" name="edit_days" class="form-control" value="{{$pricing->number_of_days}}" required>
                  </div>

                  <div class="form-group">
                     <label for="days">Amount:</label>
                     <input  type="text" name="edit_pricing" class="form-control" value="{{$pricing->pricing}}" required>
                  </div>
               </div>
         </div>
         <div class="modal-footer">
         <button type="submit" class="btn" style="color: white; background-color: #5a386b">Update Pricing</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
      </form>

   </div>
</div>
</div>
@endforeach
@push('custom-scripts')
<script>
   $('#myTable').DataTable({
       searching: false
   });
   
   @if(Session::has('message'))
     toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
   @endif

   @if(Session::has('updated'))
     toastr.success('Success!',"{{Session::get('updated')}}" ,{"positionClass": "toast-bottom-right"});
   @endif

   $(function(e){
      $(document).on('click', '.delete-btn', function(){
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Delete this Pricing?",
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
                url:"{{ route('pricing.delete') }}",
                
                success:function(data){
                    if(data.success == true){
                     $("#pricing_id_"+id).remove();
                      toastr.success('Success!', data.message ,{"positionClass": "toast-bottom-right"});
                      location.reload();
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