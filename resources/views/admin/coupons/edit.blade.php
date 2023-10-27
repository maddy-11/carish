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
.ck.ck-content.ck-editor__editable {
    height: 180px;
}

</style>

{{-- Content Start from here --}}
<div class="row mb-3">
  <div class="col-md-8 title-col">
    <h3 class="maintitle text-uppercase fontbold">Add New Template</h3>
  </div>
</div>


<div class="row entriestable-row mt-3">
  <div class="col-12">
      <div class="col-sm-8">
       <form action="{{url('admin/update-coupon',$coupon->id)}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="form-group">
          <label for="subject" class="font-weight-bold">Coupon Code <span class="text-danger">*</span></label>
          <input  type="text" name="code" class="form-control" value="{{$coupon->code}}" required placeholder="Enter Coupon Code">         
        </div>

        <div class="form-group">
          <label for="type" class="font-weight-bold">Select Type <span class="text-danger">*</span></label>
          <select name="discount_type"  class="form-control" disabled>           
            <option value="">{{$coupon->discount_type}}</option>
          </select>
        </div>

        <div class="form-group">
          <label for="subject" class="font-weight-bold">Discount Amount <span class="text-danger">*</span></label>
          <input  type="number" name="discount_amount" class="form-control" value="{{$coupon->discount_amount}}" placeholder="Enter Discount Amount">         
        </div>

        <div class="form-group">
          <label for="subject" class="font-weight-bold">Use Upto <span class="text-danger">*</span></label>
          <input  type="number" name="usage_limit" class="form-control" value="{{$coupon->usage_limit}}" required placeholder="Enter Number of Times to Be Used  ">         
        </div>

        <div class="form-group">
          <label for="subject" class="font-weight-bold">Date Of Expiry <span class="text-danger">*</span></label>
          <input  type="date" name="date_expired" class="form-control" value="{{$coupon->date_expired}}" required>         
        </div>

        <div class="form-group">
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Update Coupon</button>  
        </div>             
        
        </form>
      </div>
    </div>
    </div>
  </div>

<!--  Content End Here -->

@push('custom-scripts')

@endpush
@endsection


