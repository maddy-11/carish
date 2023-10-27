@extends('admin.layouts.app')

@section('content')
<!-- <div class="row">
    <h2 class="text-info">Removed Ads</h2>
</div> -->
<!-- <div class="row" style="float: right; display: none;">
    <button type="button" class="btn btn-primary" id="pending">Pending</button>
    <button type="button" class="btn btn-success" id="remove">Remove</button>
    <button type="button" class="btn btn-warning" id="soldout">SoldOut</button>
    <button type="button" class="btn btn-danger" id="reject">Rejected</button>
</div> -->

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Car Ads / <a target="" href="{{url('admin/romove-ads')}}">Removed</a></h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
     <!--  <button type="button" class="btn btn-primary" id="pending">Pending</button>
    <button type="button" class="btn btn-success" id="remove">Remove</button>
    <button type="button" class="btn btn-warning" id="soldout">SoldOut</button>
    <button type="button" class="btn btn-danger" id="reject">Rejected</button> -->
    <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger">Delete Ads</button>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Removed Ads</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th width="50px">Check All&nbsp;<input type="checkbox" id="checkAll"></th>
                <!-- <th>Action</th> -->
                <th>Title</th>
                <!-- <th>Detail</th> -->
                <th>Bought From</th>
                <th>Color</th>
                <th>Price</th>
                <th>Customer</th>
                <th>Status</th>
                <!-- <th>Is Featured</th> -->
              </tr>
          </thead>
          <tbody>
            
             @foreach($ads as $ad)
            
                <tr>
                    <td><input type="checkbox" name="ad_checkbox[]" class="ad_checkbox" value="{{$ad->id}}" />
                    <input type="hidden" name="ad_id" value="{{$ad->id}}" id="ad_id">  
                   </td>  
                  <!--   <td> 

                        @if($ad->status == 0)
                            <a class="btn btn-primary" title="Approve" href="{{url('admin/approve-ad/'.$ad->id)}}"><i class="fa fa-check-square"></i></a>
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 1)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 2)
                            <div class="d-flex text-center">
                      
                             <a data-toggle="modal" href='#deleteModal' class="actionicon bg-danger deleteaction delete-btn" data-id = "{{$ad->id}}"><i class="fa fa-close"></i></a>
                            &nbsp;&nbsp;
                             
                      
                             </div>
                        @elseif($ad->status == 3)
                        <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 4)
                        <a class="btn btn-danger"><i class="fa fa-trash"></i></a>    
                        @endif

                    </td> -->
                    <td><a href="{{url('admin/ad-details/'.$ad->id)}}" ><b>{{@$ad->maker->title}} {{@$ad->model->name}} {{@$ad->year}}</b></a></td>
                    <td style="white-space: nowrap;"> CC {{@$ad->versions->cc}} \ KW {{@$ad->versions->kilowatt}} \{{@$ad->versions->extra_details}} </td>
                    <td>{{@$ad->country->name}}</td>
                    <td>{{@$ad->color->name}}</td>
                    <td>{{$ad->price}}</td>
                    <td>
                      {{ @$ad->customer->customer_company }}
                    </td>
                   
                    @if($ad->status == 0)
                    <td><label class="label label-warning">Pending</label></td>
                    @elseif($ad->status == 1)
                    <td><label class="label label-info">Approved</label></td>
                    @elseif($ad->status == 2)
                    <td><label class="label label-primary">Removed</label></td>
                    @elseif($ad->status == 3)
                    <td><label class="label label-success">SoldOut</label></td>
                    @elseif($ad->status == 4)
                    <td><label class="label label-danger">Rejected</label></td>
                    @endif
                    
                    <!-- <td>    
                       @if($ad->is_featured == 'false')
                        <button id="isFeatured" type="button" data-id="{{$ad->id}}"><i class="fa fa-check-square"></i></button>
                       @endif
                    </td> -->
                   
                </tr>
            @endforeach
            
            </td>
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div>


 <!--    <div style="overflow-x: auto; width: 100%;">
        <table id="UserAds"  class="table table-responsive">
            <thead>
            <tr>
                <th>Maker</th>
                <th>Model</th>
                <th>Detail</th>
                <th>Bought From</th>
                <th>Year</th>
                <th>Color</th>
                <th>Price</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Is Featured</th>
                <th style="width: 100%">Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($ads as $ad)
            
                <tr>-->
                   <!-- // <td><input type="checkbox" name="checkbox" id="check">
                   // <input type="hidden" name="ad_id" value="{{$ad->id}}" id="ad_id">  
                   // </td>  -->
                    <!-- <td>{{@$ad->maker->title}}</td>
                    <td>{{@$ad->model->name}}</td>
                    <td style="white-space: nowrap;">{{@$ad->versions->name}}</td>
                    <td>{{@$ad->city->name}}</td>
                    <td>{{@$ad->year}}</td>
                    <td>{{@$ad->color->name}}</td>
                    <td>{{$ad->price}}</td>
                    <td>{{\App\Models\Customers\Customer::find($ad->customer_id)->customer_firstname}} {{\App\Models\Customers\Customer::find($ad->customer_id)->customer_lastname}}</td>
                    

                    @if($ad->status == 0)
                    <td><label class="label label-warning">Pending</label></td>
                    @elseif($ad->status == 1)
                    <td><label class="label label-info">Approved</label></td>
                    @elseif($ad->status == 2)
                    <td><label class="label label-primary">Removed</label></td>
                    @elseif($ad->status == 3)
                    <td><label class="label label-success">SoldOut</label></td>
                    @elseif($ad->status == 4)
                    <td><label class="label label-danger">Rejected</label></td>
                    @endif
                    
                    <td>    
                       @if($ad->is_featured == 'false')
                        <button id="isFeatured" type="button" data-id="{{$ad->id}}"><i class="fa fa-check-square"></i></button>
                       @endif
                    </td>
                    <td> 

                        @if($ad->status == 0)
                            <a class="btn btn-primary" title="Approve" href="{{url('admin/approve-ad/'.$ad->id)}}"><i class="fa fa-check-square"></i></a>
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 1)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 2)
                            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 3)
                        <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @elseif($ad->status == 4)
                        <a class="btn btn-danger"><i class="fa fa-trash"></i></a>    
                        @endif

                    </td>
                   
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>  -->

    @push('custom-scripts')
    <script>
        $('#UserAds').DataTable();
        @if(Session::has('message'))
        toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
      @endif

      $(function(e){
      $('.delete-btn').on('click', function(){
        
      var id = $(this).data('id');
      swal({
          title: "Alert!",
          text: "Are you sure you want to Delete this Ad?",
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
                url:"{{ url('admin/delete-removedAd-model') }}",
                
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
          text: "Are you sure you want to Delete Ads?",
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
                    url:"{{url('admin/allDelete-removedAd-model')}}",
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