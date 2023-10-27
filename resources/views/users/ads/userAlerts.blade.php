@extends('layouts.app')
@push('styles')
<style type="text/css">
  .table-responsive {
    max-height: 400px !important;
  }
</style>
@endpush
@section('content')
<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
  <div class="container">
    <div class="row ml-0 mr-0">
      @include('users.ads.profile_tabes')
    </div>
    <div class="tab-content profile-tab-content">
      <div class="tab-pane active" id="profile-tab4">
        <div class="bg-white">
          <div class="table-responsive">
            <table class="table table-striped" style="margin-bottom:0px;">
              <thead>                
                <tr>
                  <th colspan="3" style="text-align: center;">
                    <h3>{{__('dashboardAlerts.ComingSoon')}}</h3>
                  </th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!--  <div class="tab-content profile-tab-content">
        <div class="tab-pane active" id="profile-tab3">
            <div class="row alerts-tab-row">
              <div class="col-lg-3 col-md-4 alerts-tab-sidebar ad-tab-sidebar">
                <div class="bg-white border p-3">
                   <ul class="nav nav-tabs nav-pills d-block text-capitalize sidebar-pills my-ad-tabs">
                    <li class="nav-item">
                      <a class="nav-link active d-flex" data-toggle="tab" href="#alerts-tab1">
                       <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="{{url('public/assets/img/adtab-car.png')}}" class="img-fluid none-active-img" alt="icon image">
                        <img src="{{url('public/assets/img/adtab-active-car.png')}}" class="img-fluid active-img" alt="icon image">
                      </figure> <span>{{__('ads.car_alerts')}}</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link d-flex" data-toggle="tab" href="#alerts-tab2">
                        <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="{{url('public/assets/img/adtab-parts.png')}}" class="img-fluid none-active-img" alt="icon image">
                        <img src="{{url('public/assets/img/adtab-active-parts.png')}}" class="img-fluid active-img" alt="icon image">
                      </figure> <span>{{__('ads.spare_parts_alerts')}}</span></a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-9 col-md-8 mt-md-0 mt-4 pl-md-0 pl-lg-3 alerts-tab-desc">
               <div class="tab-content"> 
               <div class="tab-pane active" id="alerts-tab1"> 
                <div class="align-items-center d-flex justify-content-end mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal"> <a target="" href="{{route('car_alerts')}}">{{__('ads.add_car_alerts')}}</a></h6>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table bg-white table-bordered alertTable">
                    <thead>
                    
                      <tr>
                        <th class="border-bottom">{{__('common.model')}}</th>
                        <th class="border-bottom">{{__('common.year')}}</th>
                        <th class="border-bottom">{{__('common.city')}}</th>
                        <th class="border-bottom">{{__('common.price')}}($)</th>
                        <th class="border-bottom">{{__('ads.mileage')}}(km)</th>
                        <th class="border-bottom">{{__('common.action')}}</th>
                      </tr>
                     
                    </thead>
                    <tbody>
                        @if(@$alerts != null && $alerts->count() > 0)
                      @foreach($alerts as $alert)
                      <tr id="alert{{$alert->id}}">
                        <td>{{@$alert->get_model->name}}</td>
                        <td>{{@$alert->year_from != null ? @$alert->year_from : 'Any'}} - {{@$alert->year_to != null ? @$alert->year_to : 'Any'}}</td>
                        <td>{{@$alert->get_city->name != null ? @$alert->get_city->name:'Any'}}</td>
                        <td>$ {{@$alert->price_from != null ? @$alert->price_from :'Any'}} - {{@$alert->price_to != null ? @$alert->price_to : 'Any'}}</td>
                        <td>{{@$alert->mileage_from}} - {{@$alert->mileage_to}}</td>
                       
                        <td>
                          <a href="#" class="border px-sm-3 px-2 py-1 rounded actionbtn d-none">{{__('ads.view_ad')}} <em class="ml-1 fa fa-eye"></em></a>
                          <a href="javascript:void(0)" class="rounded-circle text-white fa fa-trash close-alerts deleteAlert ml-2" data-id="{{@$alert->id}}" title="Delete"></a>
                        </td>
                      </tr>
                       @endforeach
                       @else
                       <tr>
                        <td colspan="5" style="text-align: center;">
                         <h3>{{__('common.no_alerts')}} </h3>
                         </td>
                       </tr>
                      @endif
                     
                    </tbody>
                  </table>
                </div>
              </div>
                <div class="tab-pane" id="alerts-tab2"> 
                <div class="align-items-center d-flex justify-content-end mb-md-3 mb-2">
                  <div class="display-ad-title">
                    <h6 class="mb-0 font-weight-normal">  <a target="" href="{{route('accessory_alerts')}}">{{__('ads.add_spare_parts_alerts')}}</a></h6>
                  </div>
                </div>
                <div class="table-responsive">
                <table class="table bg-white table-bordered">
                    <thead>
                      <tr>
                        <th class="border-bottom">{{__('common.category')}}</th>
                        <th class="border-bottom">{{__('common.sub_category')}}</th>
                        <th class="border-bottom">{{__('common.city')}}</th>
                        <th class="border-bottom">{{__('common.price')}}($)</th>
                        <th class="border-bottom">{{__('common.frequency')}}</th>
                        <th class="border-bottom">{{__('common.action')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                       @if(@$sparePartAlerts != null && $sparePartAlerts->count() > 0)
                      @foreach($sparePartAlerts as $alert)
                      <tr id="alertt{{$alert->id}}">
                        <td>{{@$alert->get_category->title != null ? @$alert->get_category->title : "Any"}}</td>
                        <td>{{@$alert->get_sub_category->title != null ? @$alert->get_sub_category->title : "Any"}}</td>
                        <td>{{@$alert->get_city->name != null ? @$alert->get_city->name:'Any'}}</td>
                        <td>$ {{@$alert->price_from != null ? @$alert->price_from :'Any'}} - {{@$alert->price_to != null ? @$alert->price_to : 'Any'}}</td>
                        <td>{{@$alert->frequency != null ? @$alert->frequency: "Any"}}</td>
                        <td>
                          <a href="#" class="border px-sm-3 px-2 py-1 rounded actionbtn d-none">{{__('ads.view_ad')}} <em class="ml-1 fa fa-eye"></em></a>
                          <a href="javascript:void(0)" class="rounded-circle text-white fa fa-trash close-alerts deleteAccessoryAlert ml-2" data-id="{{@$alert->id}}" title="Delete"></a>
                        </td>
                      </tr>
                       @endforeach
                       @else
                       <tr>
                        <td colspan="5" style="text-align: center;">
                         <h3>{{__('common.no_alerts')}} </h3>
                         </td>
                       </tr>
                      @endif
                    </tbody>
                  </table></div>
              </div>
             </div> 
           </div>
         </div>
        </div>
      </div>  -->
  </div>
</div>         
@push('scripts')
<script type="text/javascript">
  // Delete alert
  $(document).on('click', '.deleteAlert', function(e){

    var id = $(this).data('id');
  
      swal({
        title: "Are you sure?",
        text: "You want to delete alert ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
        },
      function (isConfirm) {
          if (isConfirm) {
            $.ajax({
              method:"get",
              data:'id='+id,
              url: "{{ route('delete-car-alert') }}",
              success: function(response){
                if(response.success === true){
                  toastr.success('Success!', 'Alert Deleted Successfully.',{"positionClass": "toast-bottom-right"});
                  // $('.table-contacts').DataTable().ajax.reload();
                  // var row = $("#alert"+id);
                  var row = 'alert'+id;
                 $('#'+row).remove(); 
                 console.log('#'+row);
                }
              }
            });
          }
          else {
            swal("Cancelled", "", "error");
          }
      });
    });
   // Delete accessory alert
  $(document).on('click', '.deleteAccessoryAlert', function(e){

    var id = $(this).data('id');
  
      swal({
        title: "Are you sure?",
        text: "You want to delete alert ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
        },
      function (isConfirm) {
          if (isConfirm) {
            $.ajax({
              method:"get",
              data:'id='+id,
              url: "{{ route('delete-accessory-alert') }}",
              success: function(response){
                if(response.success === true){
                  toastr.success('Success!', 'Alert Deleted Successfully.',{"positionClass": "toast-bottom-right"});
                  // $('.table-contacts').DataTable().ajax.reload();
                  // var row = $("#alert"+id);
                  var row = 'alertt'+id;
                 $('#'+row).remove(); 
                 console.log('#'+row);
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