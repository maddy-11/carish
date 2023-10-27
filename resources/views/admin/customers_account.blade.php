@extends('admin.layouts.app')
@section('content')

@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div> 
@endif

@if (count($errors) > 0)
<div class = "alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">

   <div class="col-lg-8 col-md-7 col-sm-7  title-col">
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Customers Accounts</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
  
  </div>

</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Requests</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered" id="myTable" style="width:100%">
          <thead>
              <tr>
                <th>Action</th>
               <th>Invoice No.</th>
               <th>Customer</th>
               <th>Amount</th> 
               <th>Details</th>
               <th>Type</th>
               <th>Status</th>
             
              </tr>
          </thead>
          <tbody>
             @foreach($customers_accounts as $account)
              <tr>
               <td class="text-center">
                 @if(@$account->status == 1)
                <span>--</span>
                 @else
              
                  <span style="border: 1px solid green;padding: 3px;cursor: pointer;" class="approve" data-id="{{@$account->id}}"><i class="fa fa-check" style="color: green;" title="Approve It"></i></span>
                  @endif
               </td>
                <td>
                 <a href="javascript:void(0)" class="themecolor download_invoice" data-id="{{@$account->id}}">C{{@$account->id}}</a>
                </td>
                <td>
                 <a target="" href="{{url(admin/active/user-detail/.@$account->customer_id)}}" class="themecolor"> {{@$account->get_customer->customer_company !== null ? @$account->get_customer->customer_company : @$account->get_customer->firstname}}</a>
                </td>
                <td>
                  {{@$account->paid_amount != null ? @$account->paid_amount : (@$account->credit != null ? @$account->credit : @$account->debit)}}
                </td>
                <td>
                  @if(@$account->type !== null)

                    @if(@$account->type == 'car' && @$account->credit !== null)
                      <span>Amount to be paid for featuring {{@$account->car_ad->maker->title}} {{@$account->car_ad->model->name}} {{@$account->car_ad->versions->name}} {{@$account->car_ad->year}} Car</span>
                    @elseif(@$account->type == 'car' && @$account->debit !== null)
                    <span>Amount paid for featuring {{@$account->car_ad->maker->title}} {{@$account->car_ad->model->name}} {{@$account->car_ad->versions->name}} {{@$account->car_ad->year}} Car</span>

                     @elseif(@$account->type == 'sparepart' && @$account->credit !== null)
                     <span>Amount to be paid for featuring {{@$account->sparepart_ad->title}} Spare Part</span>
                     @elseif(@$account->type == 'sparepart' && @$account->debit !== null)
                      <span>Amount paid for featuring {{@$account->sparepart_ad->title}} Spare Part</span>

                     @elseif(@$account->type == 'offerservice' && @$account->credit !== null)
                       <span>Amount to be paid for featuring {{@$account->offerservice->primary_service->title}} Offer Service</span>
                      @elseif(@$account->type == 'offerservice' && @$account->debit !== null)
                       <span>Amount paid for featuring {{@$account->offerservice->primary_service->title}} Offer Service</span>
                       @elseif(@$account->type == 'balance_added' && @$account->credit !== null)
                       <span>Balance Added</span>
                    @endif
                  @endif
                </td>
                
                <td>
                 <span style="text-transform: uppercase;"> {{@$account->type}} </span>
                </td>
                <td>
                  {{@$account->status == 0 ? 'Pending' : 'Approved'}}
                </td>
              </tr>
            @endforeach
          </tbody>
      </table>
    </div>
   </div>
  </div>

</div>

</div>
<!-- export pdf form starts -->
      <form class="export-quot-form" method="post" action="{{route('admin-export-pdf')}}">
        @csrf
       <input type="hidden" name="invoice_number" class="invoice_number">
      </form>
    <!-- export pdf form ends -->
@push('custom-scripts')
<script>
   $('#myTable').DataTable({
       // searching: false
   });

   $('.approve').on('click',function(){
    var id = $(this).data('id');
    // alert(id);
    swal({
              title: "Are you sure!!!",
              text: "You want to approve this request!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes!",
              cancelButtonText: "Cancel",
              closeOnConfirm: true,
              closeOnCancel: true
              },
            function (isConfirm) {
              if (isConfirm) {
                 $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
                });
                $.ajax({
                  method:"post",
                  url: "{{route('approve_account_request')}}",
                  data:{id:id,"_token": "{{ csrf_token() }}",},
                  success: function(data){
                   if(data.success == true){
                    // $('#myTable').DataTable().ajax.reload();
                    location.reload();
                   }
                    
                  }
                });
              }
              else {
                  swal("Cancelled", "", "error");
              }
            });
   });
$('.download_invoice').on('click',function(){
    // alert($(this).data('id'));
    $('.invoice_number').val($(this).data('id'));
    $('.export-quot-form')[0].submit();
   })
</script>
@endpush
@endsection