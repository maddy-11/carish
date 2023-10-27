@extends('admin.layouts.app')
@section('content')
<?php $model_id = Route::Input('model_id');?>

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Car Model Versions</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
      
      
  </div>

</div>
@if(session()->has('message'))
<div class="alert alert-success  alert-block">
   <button type="button" class="close" data-dismiss="alert">×</button>
   {{ session()->get('message') }}
</div>
@endif
<div> 
   
</div> 
<div >
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Car Model Versions</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{url('admin/versions/'.$model_id.'/showall')}}" method="post" role="form">
                        <div class="box-body">
                           {{csrf_field()}}
                           <input type="hidden" name="model_id" value="{{$model_id}}">
                           <div class="row">
                            <div class="col-md-6">
                             <div class="form-group">
                                  <label for="name">Name</label>
                                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                  <label>Engine Type*</label>
                                  <select class="form-control " name="engine_type" style="width: 100%;">
                                      <option selected="selected">Engine Type</option>
                                      <option>CNG</option>
                                      <option>Diesel</option>
                                      <option>Hybrid</option>
                                      <option>LPG</option>
                                      <option>Petrol</option>
                                  </select>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                  <label for="engine_capacity">Engine Capacity</label>
                                  <input type="text" class="form-control" id="engin_capacity" name="engin_capacity" placeholder="Enter Engine Capacity">
                              </div>
                            </div>  
                            <div class="col-md-6">
                              <div class="form-group">
                                  <label for="transmission_type">Transmission</label>
                                  <select class="form-control " name="transmission_type" style="width: 100%;">
                                      <option selected="selected">Transmission</option>
                                      <option>Manual</option>
                                      <option>Automatic</option>
                                  </select>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                             <div class="form-group">
                                <label for="assembly">Assembly*</label>
                                <select class="form-control " name="assembly" style="width: 100%;">
                                    <option selected="selected">Assembly</option>
                                    <option>Local</option>
                                    <option>Imported</option>
                                </select>
                              </div>
                             </div>  
                            <div class="col-md-6">
                            <div class="form-group">
                              <label for="features">Features*</label>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="ABS"> ABS
                                </label>
                                <label>
                                  <input type="checkbox" name="Air_Bags"> Air Bags
                                </label>
                                <label>
                                  <input type="checkbox" name="Air_Conditioning"> Air Conditioning
                                </label>
                                <label>
                                  <input type="checkbox" name="Alloy_Rims"> Alloy Rims
                                </label>
                              </div>
                            </div>

                        </div>
                      </div>
                        <!-- /.box-body -->

                        <div class="box-footer ">                            
                          <a  class="btn btn-danger pull-right" href="{{url('admin/versions/'.$model_id.'/showall')}}"  > Cancel </a> <button type="submit" class="btn btn-primary pull-right margin-r-5"> Submit </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>


@push('custom-scripts')
<script>
   $('#myTable').DataTable({
       searching: false
   });
   
   @if(Session::has('message'))
     toastr.success('Success!',"{{Session::get('message')}}" ,{"positionClass": "toast-bottom-right"});
   @endif
</script>
@endpush
@endsection