@extends('admin.layouts.app')
@section('content')
<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Role Confiugration ({{$role_name}})</h3>
  </div>
</div>
@if(session()->has('message'))
<div class="alert alert-success  alert-block">
   <button type="button" class="close" data-dismiss="alert">×</button>
   {{ session()->get('message') }}
</div>
@endif

<div class="row">
  <div class="col-lg-6 col-6 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Menu Setting</h5>
      </div>
      <div class="table-responsive">
        <div class="card-body">
      <ul style="list-style-type:none; " id="sortable" >
          <li class="sorable_li parent-checkbox-list" data-id="dashboard">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('dashboard',$role_menus)) checked @endif value="dashboard" class="form-check-input parentcheckbox menus" data-id="dashboard" type="checkbox" id="dashboard">
                  <label class="form-check-label" for="dashboard">Dashboard</label>
                </div>
              </div>
            </div>
          </li>
          <li class="sorable_li parent-checkbox-list" data-id="car_ads">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('car_ads',$role_menus)) checked @endif value="car_ads" class="form-check-input parentcheckbox menus" data-id="car_ads" type="checkbox" id="car_ads">
                  <label class="form-check-label" for="car_ads">Car Ads</label>
                </div>
              </div>
            </div>
          </li>
          <li class="sorable_li parent-checkbox-list" data-id="spear_part_ads">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('spear_part_ads',$role_menus)) checked @endif value="spear_part_ads" class="form-check-input parentcheckbox menus" data-id="spear_part_ads" type="checkbox" id="spear_part_ads">
                  <label class="form-check-label" for="spear_part_ads">Spear Part Ads</label>
                </div>
              </div>
            </div>
          </li>
          <li class="sorable_li parent-checkbox-list" data-id="services_ads">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('services_ads',$role_menus)) checked @endif value="services_ads" class="form-check-input parentcheckbox menus" data-id="services_ads" type="checkbox" id="services_ads">
                  <label class="form-check-label" for="services_ads">Services Ads</label>
                </div>
              </div>
            </div>
          </li>
          <li class="sorable_li parent-checkbox-list" data-id="invoices">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('invoices',$role_menus)) checked @endif value="invoices" class="form-check-input parentcheckbox menus" data-id="invoices" type="checkbox" id="invoices">
                  <label class="form-check-label" for="invoices">Invoices</label>
                </div>
              </div>
            </div>
          </li>
          <li class="sorable_li parent-checkbox-list" data-id="individual_company">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('individual_company',$role_menus)) checked @endif value="individual_company" class="form-check-input parentcheckbox menus" data-id="individual_company" type="checkbox" id="individual_company">
                  <label class="form-check-label" for="individual_company">Individual/Company</label>
                </div>
              </div>
            </div>
          </li>
          <li class="sorable_li parent-checkbox-list" data-id="car_management">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('car_management',$role_menus)) checked @endif value="car_management" class="form-check-input parentcheckbox menus" data-id="car_management" type="checkbox" id="car_management">
                  <label class="form-check-label" for="car_management">Car Management</label>
                </div>
              </div>
            </div>
          </li>
          <li class="sorable_li parent-checkbox-list" data-id="staff_management">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('staff_management',$role_menus)) checked @endif value="staff_management" class="form-check-input parentcheckbox menus" data-id="staff_management" type="checkbox" id="staff_management">
                  <label class="form-check-label" for="staff_management">Staff Management</label>
                </div>
              </div>
            </div>
          </li>
          <li class="sorable_li parent-checkbox-list" data-id="categories_services">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('categories_services',$role_menus)) checked @endif value="categories_services" class="form-check-input parentcheckbox menus" data-id="categories_services" type="checkbox" id="categories_services">
                  <label class="form-check-label" for="categories_services">Categories/Services</label>
                </div>
              </div>
            </div>
          </li>
          <li class="sorable_li parent-checkbox-list" data-id="pages_management">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('pages_management',$role_menus)) checked @endif value="pages_management" class="form-check-input parentcheckbox menus" data-id="pages_management" type="checkbox" id="pages_management">
                  <label class="form-check-label" for="pages_management">Pages Management</label>
                </div>
              </div>
            </div>
          </li>
          <li class="sorable_li parent-checkbox-list" data-id="emails">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('emails',$role_menus)) checked @endif value="emails" class="form-check-input parentcheckbox menus" data-id="emails" type="checkbox" id="emails">
                  <label class="form-check-label" for="emails">Emails</label>
                </div>
              </div>
            </div>
          </li>
          <li class="sorable_li parent-checkbox-list" data-id="google_ads">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('google_ads',$role_menus)) checked @endif value="google_ads" class="form-check-input parentcheckbox menus" data-id="google_ads" type="checkbox" id="google_ads">
                  <label class="form-check-label" for="google_ads">Google Ads</label>
                </div>
              </div>
            </div>
          </li>
          <li class="sorable_li parent-checkbox-list" data-id="languages">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('languages',$role_menus)) checked @endif value="languages" class="form-check-input parentcheckbox menus" data-id="languages" type="checkbox" id="languages">
                  <label class="form-check-label" for="languages">Languages</label>
                </div>
              </div>
            </div>
          </li>
          <li class="sorable_li parent-checkbox-list" data-id="global_configuration">
            <div class="card card-primary pl-3  mt-1 col-12" >
              <div class="card-body py-1">
                <div class="form-check form-check-inline ">
                  <input @if(in_array('global_configuration',$role_menus)) checked @endif value="global_configuration" class="form-check-input parentcheckbox menus" data-id="global_configuration" type="checkbox" id="global_configuration">
                  <label class="form-check-label" for="global_configuration">Global Configuration</label>
                </div>
              </div>
            </div>
          </li>
    </ul>
  <div class=" mt-4 float-right">
        <button class="btn  btn-primary save-menus-btn">Save</button>
      </div>
      </div>
        

    </div>
   </div>
  </div>

</div>

<div class="modal fade" id="myModal" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
    <form action="{{url('add/role')}}" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Role</h4>
         </div>
         <div class="modal-body">
            <div class="col-md-">
                  {{csrf_field()}}
                   <div class="form-group">
                     <label for="name">Name:</label>
                     <input  type="text" name="name" class="form-control" >
                  </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn" style="color: white; background-color: #5a386b">Add Role</button>
            </div>
      </div>
    </form>
   </div>
</div>
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
    $(document).on('click', '.save-menus-btn', function(e) {
      var menus=[];
      $.each($('.menus:checked'), function(){
        menus.push($(this).val());
           });
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ route('add-role-menu',['role_id'=>$role_id]) }}",
        method: 'get',
        data: {menus:menus},
        beforeSend: function() {
            $('#loader_modal').modal({
            backdrop: 'static',
            keyboard: false
          });
          $("#loader_modal").modal('show');
          $('.save-menus-btn').text('Please wait...');
          $('.save-menus-btn').attr('disabled', true);
        },
        success: function(result) {
          $("#loader_modal").modal('hide');
          $('.save-menus-btn').text('Save');
          $('.save-menus-btn').removeAttr('disabled');
          if (result.success === true) {
            toastr.success('Success!', 'Menus updated successfully', {
              "positionClass": "toast-bottom-right"
            });
            setTimeout(() => {
              window.location.reload();
            }, 2000);
          }
        },
      });
    });
   });
</script>
@endpush
@endsection