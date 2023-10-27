@extends('layouts.app')
@push('styles')
<link rel="stylesheet" media="all" href="{{url('public/admin/assets/css/datatables.min.css')}}" />
@endpush
@section('content')
<div class="internal-page-content mt-4 pt-md-5 pt-4 sects-bg">
  <div class="container">
    <div class="row ml-0 mr-0">
        @include('users.ads.profile_tabes')
      </div>
      <div class="tab-content profile-tab-content">
        <!-- Tab 6 starts here -->
        <div class="tab-pane active" id="profile-tab6">
          <div class="row ad-tab-row">
              <div class="col-lg-3 col-md-4 payment-tab-sidebar">
                <div class="bg-white border p-3">
                   <ul class="nav nav-tabs nav-pills d-block text-capitalize sidebar-pills payment-tabs">
                    <li class="nav-item">
                      <a class="nav-link active d-flex" data-toggle="tab" href="#payment-tab1">
                       <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="{{url('public/assets/img/payment-add-balance.png')}}" class="img-fluid none-active-img" alt="icon image">
                        <img src="{{url('public/assets/img/payment-active-add-balance.png')}}" class="img-fluid active-img" alt="icon image">
                      </figure> <span>{{__('dashboardPayment.addBalance')}}</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link d-flex" data-toggle="tab" href="#payment-tab2">
                        <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="{{url('public/assets/img/payment-balance-log.png')}}" class="img-fluid none-active-img" alt="icon image">
                        <img src="{{url('public/assets/img/payment-active-balance-log.png')}}" class="img-fluid active-img" alt="icon image">
                      </figure> <span>{{__('dashboardPayment.balalnceLog')}}</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link d-flex" data-toggle="tab" href="#payment-tab3">
                        <figure class="align-items-center d-flex justify-content-center mb-0 mr-2">
                        <img src="{{url('public/assets/img/payment-invoice-setting.png')}}" class="img-fluid none-active-img" alt="icon image">
                        <img src="{{url('public/assets/img/payment-active-invoice-setting.png')}}" class="img-fluid active-img" alt="icon image">
                      </figure> <span>{{__('dashboardPayment.InvoiceSetting')}}</span></a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-9 col-md-8 mt-md-0 mt-4 pl-md-0 pl-lg-3 payment-tab-desc">
               <div class="tab-content"> 
               <div class="tab-pane active" id="payment-tab1"> 
                <div class="bg-white border px-lg-4 px-3 pt-3 pb-4">
                  <h4 class="mb-3">{{__('dashboardPayment.addBalanceTabTitle')}}</h4>
                  <form class="add-balance-form mt-4 pt-md-2" method="post">
                    {{csrf_field()}}
                    <div class="row justify-content-between align-items-end">
                      <div class="col-lg-6 col-sm-7 col-12">
                        <label class="font-weight-semibold">{{__('dashboardPayment.currentBalance')}} <strong>
                          @php $credit = 0; $debit = 0; @endphp
                          @foreach(Auth::guard('customer')->user()->customer_account as $account)
                          @if($account->status == 1)
                            @php $credit = $credit + $account->credit - @$account->debit @endphp
                            @endif
                          @endforeach
                          {{@$credit}} €
                          </strong></label>
                        <input type="text" class="form-control" placeholder="{{__('dashboardPayment.addBalanceTextBoxEmptyError')}}" name="amount" required="true">
                      </div> 
                      <div class="col-lg-4 col-sm-5  col-12 mt-sm-0 mt-2 text-sm-right">
                        <input type="submit" name="Submit" value="{{__('dashboardPayment.addBalanceButtonText')}}" class="btn themebtn1 save-btn">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="tab-pane" id="payment-tab2"> 
                <div class="bg-white border px-lg-4 px-3 pt-3 pb-4">
                  <h4 class="mb-3">{{__('dashboardPayment.balalnceLogTabTitle')}}</h4>
                  <div class="border p-2">
                   <div class=" row form-row">
                    <div class="align-items-center bl-from-to col-lg-4 col-sm-6 mt-sm-0 mt-2 d-flex">
                      <label class="mr-2 mb-0">{{__('dashboardPayment.from')}}:</label>
                      <input id="datefrom" type="date" name="from_date">
                    </div>
                    <div class="align-items-center bl-from-to col-lg-4 col-sm-6 mt-sm-0 mt-2 d-flex">
                      <label class="mr-2 mb-0">{{__('dashboardPayment.to')}}:</label>
                      <input id="dateto" type="date" name="to_date">
                    </div>
                    <div class="align-items-center bl-from-to col-lg-4 mt-lg-0 mt-2 d-flex filterBtn text-md-left text-right">
                      <a href="#" class="applyfilter btn themebtn1 d-none">{{__('dashboardPayment.applyFilter')}}</a>
                      <a href="javascript:void(0)" class="resetfilter btn">{{__('dashboardPayment.resetFilter')}}</a>
                    </div>
                  </div>
                </div>
                <div class="bg-white custompadding customborder">
                <div class="table-responsive">
                   <table class="table entriestable table-bordered table-payments text-center">
                  <thead id="">
                    <tr>
                        <th>{{__('dashboardPayment.invoiceNumber')}}</th>
                        <th>{{__('dashboardPayment.date')}}</th>
                        <th>{{__('dashboardPayment.amount')}}</th>
                        <th>{{__('dashboardPayment.details')}}</th>
                        <th>{{__('dashboardPayment.type')}}</th>
                        <th>{{__('dashboardPayment.status')}}</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
                </div>
              </div>
              <div class="tab-pane" id="payment-tab3"> 
                <div class="bg-white border px-lg-4 px-3 pt-3 pb-4">
                  <div class="row">
                    <div class="col-6">
                      <h4>{{__('dashboardPayment.invoiceSettingTabTitle')}}</h4>                      
                    </div>   
                    <div class="col-6">
                       <!-- <input type="button" name="invoice_sample" value="Download Sample Invoice" class="btn themebtn1 download_invoice_sample"> -->
                        <div class="backto-dashboard text-right mb-md-3 mb-2">
                          <a href="javascript:void(0)" class="font-weight-semibold themecolor download_invoice_sample"><em class="fa fa-download"></em> {{__('dashboardPayment.sampleInvoice')}}</a>
                      </div>
                    </div>   
                  </div>
                  <form class="invoice-setting-form mt-md-4 mt-3">
                    {{csrf_field()}}
                    <div class="row form-group mb-md-4 align-items-center">
                      <div class="text-sm-right col-lg-3 col-md-4 col-sm-4 col-12">
                        <label class="mb-md-0 mb-1">{{__('dashboardPayment.invoiceName')}}</label>
                      </div>
                       <div class="col-lg-5 col-md-6 col-sm-7 col-12">
                        <input type="text" class="form-control" name="invoice_name" placeholder="{{__('dashboardPayment.invoice_name')}}" value="{{@$invoice_setting->invoice_name}}">
                      </div>
                    </div> 
                    <div class="row form-group mb-md-4 align-items-center">
                      <div class="text-sm-right col-lg-3 col-md-4 col-sm-4 col-12">
                        <label class="mb-md-0 mb-1">{{__('dashboardPayment.Address')}}</label>
                      </div>
                       <div class="col-lg-5 col-md-6 col-sm-7 col-12">
                        <input type="text" class="form-control" name="address" placeholder="{{__('dashboardPayment.Address')}}" value="{{@$invoice_setting->address}}">
                      </div>
                    </div> 
                    <div class="row form-group mb-md-4 align-items-center">
                      <div class="text-sm-right col-lg-3 col-md-4 col-sm-4 col-12">
                        <label class="mb-md-0 mb-1">{{__('dashboardPayment.contactPerson')}}</label>
                      </div>
                       <div class="col-lg-5 col-md-6 col-sm-7 col-12">
                        <input type="text" class="form-control" name="contact_person" placeholder="{{__('dashboardPayment.contactPerson')}}" value="{{@$invoice_setting->contact_person}}">
                      </div>
                    </div> 
                    <div class="row form-group mb-sm-4">
                       <div class="col-lg-2 offset-lg-3 offset-sm-4 col-md-8 col-sm-8 col-12">
                        <input type="submit" name="Submit" value="{{__('dashboardPayment.invoiceSettingButtonText')}}" class="btn themebtn1">
                      </div>
                    <!--   <div class="col-lg-2 offset-lg-0 offset-sm-4 col-md-8 col-sm-8 col-12">
                        <input type="button" name="invoice_sample" value="Download Sample Invoice" class="btn themebtn1 download_invoice_sample">
                      </div> -->
                    </div> 
                  </form>
                    </div>
                </div>
              </div>
             </div> 
           </div>
         </div>
        </div>
        <!-- Tab 6 starts here -->
      </div>          
    </div>
     <!-- export pdf form starts -->
      <form class="export-quot-form" method="post" action="{{route('export-pdf')}}" target="_blank">
        @csrf
       <input type="hidden" name="invoice_number" class="invoice_number">
      </form>
    <!-- export pdf form ends -->
    <!-- export pdf form starts -->
      <form class="export-invoice-sample" method="post" action="{{route('export-sample-pdf')}}" target="_blank">
        @csrf
      </form>
    <!-- export pdf form ends -->
@push('scripts')

<script type="text/javascript" src="{{url('public/admin/assets/js/datatables.min.js')}}" ></script>
<script type="text/javascript">
  $(document).on('click','.download_invoice_sample',function(e){
    e.preventDefault();
    // alert('hi');
    $('.export-invoice-sample')[0].submit();
  });
  $('#datefrom').change(function() {
      var date = $('#datefrom').val();
      $('.table-payments').DataTable().ajax.reload();
    });
  $('#dateto').change(function() {
      var date = $('#dateto').val();
      $('.table-payments').DataTable().ajax.reload();
    }); 
  $(document).on('submit', '.add-balance-form', function(e){
      e.preventDefault();
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
       $.ajax({
          url: "{{ route('add-user-balance') }}",
          method: 'post',
          data: $('.add-balance-form').serialize(),
          beforeSend: function(){
            $('.save-btn').val('{{ __('dashboardPayment.pleaseWait') }}');
            $('.save-btn').addClass('disabled');
            $('.save-btn').attr('disabled', true);
          },
          success: function(result){
          $('.export-quot-form')[0].submit();

            $('.save-btn').val('{{ __('dashboardPayment.addBalance') }}');
            // $('.save-btn').attr('disabled', true);
            $('.save-btn').removeAttr('disabled');
            $('.modal').modal('hide');
            toastr.success('Success!', 'Invoice created successfully',{"positionClass": "toast-bottom-right"});
            $('.add-balance-form')[0].reset();
            // $('.table-ordered-products').DataTable().ajax.reload();    
          },
          error: function (request, status, error) {
            $('.save-btn').val('add');
            $('.save-btn').removeClass('disabled');
            $('.save-btn').removeAttr('disabled');
            $('.form-control').removeClass('is-invalid');
            $('.form-control').next().remove();
            json = $.parseJSON(request.responseText);
            $.each(json.errors, function(key, value){
              $('input[name="'+key+'"]').after('<span class="invalid-feedback" role="alert"><strong>'+value+'</strong>');
              $('input[name="'+key+'"]').addClass('is-invalid');
            });
          }
        });
    });
  $(document).on('click','.download_invoice',function(){
    // alert($(this).data('id'));
    $('.invoice_number').val($(this).data('id'));
    $('.export-quot-form')[0].submit();
   });
  $(document).on('submit', '.invoice-setting-form', function(e){
    e.preventDefault();
    $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ route('add-customer-invoice-setting') }}",
       method:'post',
        data: $('.invoice-setting-form').serialize(),  
        beforeSend: function(){
      
          $('#loader_modal').modal('show');
        },
        success: function(result){
         
          $('#loader_modal').modal('hide');
          if(result.success == true){
            toastr.success('Success!', 'Setting added successfully',{"positionClass": "toast-bottom-right"});
 
          } 
          else if(result.update == true){
            toastr.success('Success!', 'Setting updated successfully',{"positionClass": "toast-bottom-right"});
 
          }
          else{
            toastr.error('Error!', result.errormsg,{"positionClass": "toast-bottom-right"});
          }
          
        }
      });
  });
  $(document).ready(function(){
  var table2 = $('.table-payments').DataTable({
   processing: true,
    "language":  {
        "decimal":        "",
        "emptyTable":     "{{__('dashboardPayment.emptyTable')}}",
        "info":           "{{__('dashboardPayment.showing')}} _START_ {{__('dashboardPayment.showing_to')}} _END_ {{__('dashboardPayment.showing_of')}} _TOTAL_ {{__('dashboardPayment.entries')}}",
        "infoEmpty":      "{{__('dashboardPayment.showing')}} 0 {{__('dashboardPayment.showing_to')}} 0 {{__('dashboardPayment.showing_of')}} 0 {{__('dashboardPayment.entries')}}",
        "infoFiltered":   "({{__('dashboardPayment.filtered')}} {{__('dashboardPayment.from')}} _MAX_ {{__('dashboardPayment.total')}} {{__('dashboardPayment.entries')}})",
        "infoPostFix":    "",
        "thousands":      ",",
        "lengthMenu":     "{{__('dashboardPayment.show')}} _MENU_ {{__('dashboardPayment.entries')}}",
        "loadingRecords": "{{__('dashboardPayment.loadingRecords')}}",
        "processing":     "<i class='fa fa-spinner fa-spin fa-3x fa-fw' style='color:#13436c;'></i><span class='sr-only'>{{__('dashboardPayment.loadingRecords')}}</span> ",
        "search":         "{{__('dashboardPayment.search')}}",
        "zeroRecords":    "{{__('dashboardPayment.zeroRecords')}}",
        "paginate": {
            "next":       "{{__('dashboardPayment.next')}}",
            "previous":   "{{__('dashboardPayment.previous')}}"
        }
    }
 /*{
        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw" style="color:#13436c;"></i><span class="sr-only">Loading...</span> ',
        lengthMenu: "Display _MENU_ records per page",
        zeroRecords: "{{__('dashboardPayment.noDataAvailable')}}",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "No records available",
        infoFiltered: "(filtered from _MAX_ total records)",
        paginate: {
            "next": "{{__('dashboardPayment.next')}}",
            "previous": "{{__('dashboardPayment.previous')}}"
          }
      }*/,
  ordering: false,
  lengthMenu:[5,100,150,200],
  serverSide: true,
  ajax: {
    url : "{!! route('get-my-payments') !!}",
    data: function(data) {
      //alert(data);
     data.from_date = $('#datefrom').val(),
     data.to_date = $('#dateto').val()
   } ,
  },
  // scrollX:true,
  // scrollY : '90vh',
  // scrollCollapse: true,
  fixedHeader: true,
  "lengthChange": false,
  searching: false,

  columns: [
    { data: 'invoice_no', name: 'invoice_no', width:'100px'},
    { data: 'date', name: 'date' },
    { data: 'amount', name: 'amount' },
    { data: 'details', name: 'details' },
    { data: 'type', name: 'type' },
    { data: 'status', name: 'status' },
  ],
  initComplete: function () {
  $('.dataTables_scrollHead').css('overflow', 'auto');

  $('.dataTables_scrollHead').on('scroll', function () {
          $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
      });
    }
  });
  $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  $(document).on('click','.resetfilter',function(){
    $('#datefrom').val('');
    $('#dateto').val('');

    $('.table-payments').DataTable().ajax.reload();
  });
});
</script>
@endpush
@endsection