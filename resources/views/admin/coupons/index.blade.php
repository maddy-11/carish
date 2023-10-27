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
    <h3 class="maintitle text-uppercase fontbold">SYSTEM Coupons</h3>
  </div>
</div -->

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">System Coupons</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button class="btn btn-info" data-toggle="modal" data-target="#uploadExcel">Upload Excel</button>
      <a type="button" class="btn btn-info" href="{{url('admin/create-coupon')}}" style="float: right">Add New Coupon</a>
  </div>

</div>

<!-- <a type="button" class="btn btn-info" href="{{url('admin/create-coupon')}}" style="float: right">Add New Coupon</a>
<button class="btn btn-info" data-toggle="modal" data-target="#uploadExcel">Upload Excel</button> -->
 
<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">SYSTEM Coupons</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
                <th>Code</th>
                <th>Type</th>
                <th>Discount</th>
                <th>Can Be Use</th>
                <th>Used</th>
                <th>Status</th>
                <th>Expiry Date</th>
              </tr>
          </thead>
          <tbody>
            
            @foreach($coupons as $coupon)
            <tr>
            <td>{{$coupon->date_expired}}</td>
            <td><a target="" href="{{url('admin/edit-coupon',$coupon->id)}}"><i class="fa fa-pencil"></i></a></td>
            <td>{{$coupon->code}}</td>
            <td>{{$coupon->discount_type}}</td>
            <td>{{$coupon->discount_type}}</td>
            <td>{{$coupon->usage_limit}}</td>
            <td>{{$coupon->usage_count}}</td>
            <td>{{$coupon->usage_count == $coupon->usage_limit ? "Closed" : "Active"}}</td>
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
   <table id="myTable" class="table table-coupon" >
      <thead class="text-center">
          <tr>
              <th>Code</th>
              <th>Type</th>
              <th>Discount</th>
              <th>Can Be Use</th>
              <th>Used</th>
              <th>Status</th>
              <th>Expiry Date</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
        @foreach($coupons as $coupon)
        <tr>
        <td>{{$coupon->code}}</td>
        <td>{{$coupon->discount_type}}</td>
        <td>{{$coupon->discount_type}}</td>
        <td>{{$coupon->usage_limit}}</td>
        <td>{{$coupon->usage_count}}</td>
        <td>{{$coupon->usage_count == $coupon->usage_limit ? "Closed" : "Active"}}</td>
        <td>{{$coupon->date_expired}}</td>
        <td><a target="" href="{{url('admin/edit-coupon',$coupon->id)}}"><i class="fa fa-pencil"></i></a></td>
        </tr>
        @endforeach
      </tbody>
              
   </table>
 </div> -->
<!--  Content End Here -->

<!-- Upload excel file  -->
<div class="modal fade" id="uploadExcel"> 
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">   
        <div class="modal-body text-center">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h3 class="text-capitalize fontmed">Upload Excel</h3>
          <div class="mt-3">
          <form method="post" action="{{url('admin/upload-excel')}}" class="upload-excel-form" enctype="multipart/form-data">
            {{csrf_field()}}

            <div class="form-group">
              <a target="" href="{{asset('public/admin/excel/Example_file.xlsx')}}" download><span class="btn btn-success" id="examplefilebtn">Download Example File</span></a>
            </div>

            <div class="form-group">
              <input type="file" name="excel" class="font-weight-bold form-control-lg form-control" >
            </div>           
            
            <div class="form-submit">
              <input type="submit" value="upload" class="btn btn-primary btn-bg save-btn">
              <input type="reset" value="close" data-dismiss="modal" class="btn btn-danger close-btn">
            </div>
            </form>
         </div> 
        </div>
      </div>
    </div>  
  </div>



@push('custom-scripts')
<script type="text/javascript">
  $(function(e){
    $('.table-coupon').DataTable({});

    @if(Session::has('successmsg'))
        toastr.success('Success!', "{{ Session::get('successmsg') }}",{"positionClass": "toast-bottom-right"});        
    @endif
    
  });
</script>
@endpush
@endsection

