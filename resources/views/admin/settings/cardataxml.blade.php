@extends('admin.layouts.app')

@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Car Data In XML format</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right">Search Car</button>
  </div>

</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Car Data In XML format</h5>
      </div>
      <div class="table-responsive">
        <pre>
        @php print_r($carData); @endphp
    </div>
   </div>
  </div>

</div> 
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">   
      <!-- Modal content-->
    <form action="{{route('get.carxmldata')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">         
          <h4 class="modal-title">Enter Car Number To search Data</h4>
        </div>
        <div class="modal-body">      
        <div class="col-md-">           
                {{csrf_field()}}
                 <div class="form-group">
                    <label for="name">Enter Car Number:</label>
                    <input required type="text" name="car_number" class="form-control" >
                </div>              
        </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn" style="color: white; background-color: #5a386b">Search</button>            
        </div>      
      </div>
    </form>
  </div>  
</div>
 
@push('custom-scripts')
 
@endpush

@endsection