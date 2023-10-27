@extends('admin.layouts.app')
@section('content')

@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div> 
@endif

@if (count($errors) > 0)
<div class = "alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Request For Featuring Ads</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
  
  </div>

</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Requests</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered" id="myTable" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
               <th>Name</th>
               <th>User</th> 
               <th>Number of Days</th>
               <th>Amount To Be Paid</th>
               <th>Type</th>
               <th>Status</th>
             
              </tr>
          </thead>
          <tbody>
             @foreach($featured_requests as $feature)
              <tr>
               <td class="text-center">
                 @if(@$feature->status == 1)
                 <span style="border: 1px solid green;padding: 3px;cursor: pointer;"><i class="fa fa-check" style="color: green;" title="Approved"></i></span>
                 @else
                  <span style="border: 1px solid red;padding: 3px;cursor: pointer;" class="approve" data-id="{{@$feature->id}}"><i class="fa fa-times" style="color: red;" title="Approve"></i></span>
                  @endif
               </td>
                <td>
                  @if(@$feature->type == 'spare part')
                  {{@$feature->sparepart->title != null ? @$feature->sparepart->title : '--'}}
                  @elseif(@$feature->type == 'offer service')
                   {{@$feature->offerservice->primary_service->title != null ? @$feature->offerservice->primary_service->title : '--'}}
                  @else
                   {{@$feature->ad->maker->title}} {{@$feature->ad->model->name}} {{@$feature->ad->version->name}} {{@$feature->ad->year}}
                  @endif
                </td>

                <td>
                  {{@$feature->customer->customer_company != null ? @$feature->customer->customer_company : @$feature->customer->customer_firstname}}
                </td>
                <td>
                  {{@$feature->number_of_days}}
                </td>
                <td>
                  {{@$feature->paid_amount}}
                </td>
                <td>
                 <span style="text-transform: uppercase;"> {{@$feature->type}} </span>
                </td>
                <td>
                  {{@$feature->status == 0 ? 'Pending' : 'Approved'}}
                </td>
              </tr>
            @endforeach
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div>

</div>

@push('custom-scripts')
<script>
   $('#myTable').DataTable({
       // searching: false
   });

   $('.approve').on('click',function(){
    var id = $(this).data('id');
    // alert(id);
    swal({
              title: "Are you sure!!!",
              text: "You want to approve this request!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes!",
              cancelButtonText: "Cancel",
              closeOnConfirm: true,
              closeOnCancel: true
              },
            function (isConfirm) {
              if (isConfirm) {
                 $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
                });
                $.ajax({
                  method:"post",
                  url: "{{route('approve_feature_request')}}",
                  data:{id:id,"_token": "{{ csrf_token() }}",},
                  success: function(data){
                   if(data.success == true){
                    // $('#myTable').DataTable().ajax.reload();
                    location.reload();
                   }
                    
                  }
                });
              }
              else {
                  swal("Cancelled", "", "error");
              }
            });
   });

</script>
@endpush
@endsection