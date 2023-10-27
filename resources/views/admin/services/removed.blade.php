@extends('admin.layouts.app')

@section('content')
<!-- <div class="row">
    <h2 class="text-info">Active Services</h2>
</div> -->

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Offer Services / <a target="" href="{{url('admin/removed-services')}}">Removed </a></h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right">Add Suggestion</button> -->
      <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger">Delete Services</button>
  </div>

</div>


<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Removed Offer Services</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                 <th width="50px">Check All&nbsp;<input type="checkbox" id="checkAll"></th>
                <!-- <th>Action</th> -->
                <th>Primary Service</th>
                <th>Customer</th>
                <th>Created at</th>
                <th>Status</th>
                
              </tr>
          </thead>
          <tbody>
            
            @foreach($removed_services as $service)
                <tr>
                    <td><input type="checkbox" name="ad_checkbox[]" class="ad_checkbox" value="{{$service->id}}" />
                    <input type="hidden" name="service_id" value="{{$service->id}}" id="service_id">  
                    </td>
                    <td> 

                        @if($service->status == 0)
                            <a class="btn btn-primary" title="Approve" href="{{url('admin/approve-ad/'.$service->id)}}"><i class="fa fa-check-square"></i></a>
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($service->status == 1)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($service->status == 2)
                            <div class="d-flex text-center">
                      
                             <a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id = "{{$service->id}}"><i class="fa fa-close"></i></a>
                            &nbsp;&nbsp;
                             <!-- <a  class="fa fa-eye" href="{{url('admin/removed-ad-details/'.$service->id)}}" ><i  title="View Add"></i></a> -->
                      
                             </div>
                        @elseif($service->status == 3)
                        <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($service->status == 4)
                        <a class="btn btn-danger"><i class="fa fa-trash"></i></a>    
                        @endif

                    </td>
                    <td><a href="{{url('admin/pending-service-details/'.$service->id)}}" ><b>{{@$service->primary_service->title}}</b></a></td>
                    @if(@$service->get_customer->customer_role == 'individual')
                        <td>{{@$service->get_customer->customer_firstname}} {{@$service->get_customer->customer_lastname}}</td>
                    @else
                        <td>{{@$service->get_customer->customer_company}}</td>
                    @endif
                    <td> {{$service->created_at}} </td>

                    @if($service->status == 0)
                    <td><label class="label label-warning">Pending</label></td>
                    @elseif($service->status == 1)
                    <td><label class="label label-info">Approved</label></td>
                    @elseif($service->status == 2)
                    <td><label class="label label-primary">Removed</label></td>
                    @elseif($service->status == 3)
                    <td><label class="label label-success">SoldOut</label></td>
                    @elseif($service->status == 4)
                    <td><label class="label label-danger">Rejected</label></td>
                    @endif
                    
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
    <script>
        $('#Services').DataTable();
        @if(Session::has('message'))
        toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

      $(function(e){
      $('.delete-btn').on('click', function(){
        
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Delete this Service?",
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
                url:"{{ url('admin/delete-removedService-model') }}",
                
                success:function(data){
                    if(data.success == true){
                     $("#model_id_"+id).remove();
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

 $('#checkAll').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".ad_checkbox").prop('checked', true);  
         } else {  
            $(".ad_checkbox").prop('checked',false);  
         }  
    });     

 $('#bulk_delete').on('click', function(){
        var id = [];
        swal({
          title: "Alert!",
          text: "Are you sure you want to Delete Services?",
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
            $('.ad_checkbox:checked').each(function(){
                id.push($(this).val());
            });
            if(id.length > 0)
            {
                $.ajax({
                    url:"{{url('admin/allDelete-removedService-model')}}",
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        if(data.success == true){
                         $("#model_id_"+id).remove();
                          toastr.success('Success!', data.message ,{"positionClass": "toast-bottom-right"});
                    }
                    }
                });
            }
             else
            {
                alert("Please select atleast one checkbox");
            }
              } 
          else{
              swal("Cancelled", "", "error");
          }
       
    });
        
    });   
    </script>
    
  
    @endpush

@endsection