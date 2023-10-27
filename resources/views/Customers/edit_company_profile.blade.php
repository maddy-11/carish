@extends('layouts.app')
@section('title') Update Company Profile @endsection
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content') 
 <div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">

  <div class="container">
    <div class="row ml-0 mr-0">
      <div class="col-9 mx-auto bg-white border p-sm-4 p-3 pb-md-5 mb-md-5 mb-4">
        <div class="backto-dashboard text-right mb-md-3 mb-2">
            <a href="javascript:void(0)" class="font-weight-semibold themecolor"><em class="fa fa-chevron-circle-left"></em> Back to Dashboard</a>
        </div>
        <h3 class="">My profile</h3>
        <div class="col-xl-5 col-lg-6 col-md-6 ml-auto mr-auto pl-0 pr-0 mt-md-4 mt-3">
              <div class="row align-items-end">
                 <div class="col-lg-4 col-sm-4 col-4 user-profile-img">
                   <img src="assets/img/user-profile-Img.jpg" class="img-fluid" alt="profile image">
                 </div>  
                 <div class="col-lg-8 col-sm-8 col-8 pl-0 pl-sm-3">
                    <input type="file" class="form-control-file" name="file">
                 </div>         
              </div>          
        </div>
      </div>

      <div class="col-9 mx-auto bg-white border p-sm-4 p-3 py-lg-5 py-4">
           <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">Company Name<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="text" class="form-control" placeholder="Company Name">
              </div>
           </div>
           <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">Address<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="text" class="form-control" placeholder="Address">
              </div>
           </div>
           <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">VAT</label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="text" class="form-control" placeholder="Value Added Tex Number">
              </div>
           </div>

           <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">Phone#<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="tel" class="form-control" placeholder="03075943188">
              </div>
           </div>
           <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">registration#<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="tel" class="form-control" placeholder="03075943188">
              </div>
           </div>


           <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">Website</label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <input type="text" class="form-control" placeholder="Website">
              </div>
           </div>
           <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">Working Hour<sup class="text-danger">*</sup></label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
               <div class="row form-row working-hours-fields">
                  <div class="col">
                    <select name="" class="form-control">
                      <option value="">Add days</option>
                      <option value="">Monday to Friday</option>
                      <option value="">Monday</option>
                      <option value="">Tuesday</option>
                      <option value="">Wednesday</option>
                      <option value="">Thursday</option>
                      <option value="">Friday</option>
                      <option value="">Saturday</option>
                      <option value="">Sunday</option>
                    </select>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" placeholder="Opening Time">
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" placeholder="Closing Time">
                  </div>
                  <div class="col ">
                    <a href="javascript:void(0)" class="fa fa-plus-square h-100 themecolor add-times-btn"></a>
                    <!-- <button type="button" class="btn themebtn1 fa fa-plus pr-sm-4 pl-sm-4 pr-3 pl-3 h-100"></button> -->
                  </div>
                </div>
              </div>
           </div>           
           <div class="justify-content-center align-items-center form-group mb-sm-4 mb-3 row">
              <div class="col-md-6 col-xl-5 col-lg-5 offset-lg-2 offset-sm-3 col-sm-7">
                <input type="submit" class="btn pl-4 post-ad-submit pr-4 pl-lg-5 pr-lg-5 pt-lg-3 pb-lg-3  themebtn1" value="SAVE CHANGES">
              </div>
           </div>

           <div class="justify-content-center align-items-center form-group mb-0 row mx-sm-n4 mt-lg-5 pt-lg-5 mt-4 pt-4 border-top">
              <div class="col-md-3 col-lg-2 col-sm-3 mb-1 mb-sm-0 text-sm-right">
                <label class="mb-0 text-capitalize">Linked Account</label>
              </div>
              <div class="col-md-6 col-xl-5 col-lg-5 col-sm-7">
                <a href="javascript:void(0)" class="border-0 btn btn-block facebook-btn pb-lg-3 pt-lg-3 text-white px-3 "><em class="fa fa-facebook align-middle mr-md-3 mr-sm-2 mr-1"></em> Connect with facebook</a>
              </div>
           </div>
      </div>
    </div>
</div>
</div>
@stop