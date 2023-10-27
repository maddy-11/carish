\@extends('admin.layouts.app')
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
    <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Invoices / 
      @if(@$status == 0)
      Pending
      @elseif(@$status == 1)
      Paid
      @elseif($status == 2)
      UnPaid
    @endif</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
   <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger">Delete Invoice</button>
  </div>

</div>

<div class="row">
  <div class="col-lg-12 col-12 appointment-col">
    <div class="bg-white custompadding customborder">
      <div class="section-header">
       <h5 class="mb-1">Pending Invoices</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered" id="myTable" style="width:100%">
          <thead>
              <tr>
                 <th><input type="checkbox" id="checkAll"></th>
                <th>Action</th>
               <th>Invoice No.</th>
               <th>Customer</th>
               <th>Amount</th> 
               <th>Details</th>
               <th>Type</th>
               <th>Created Date</th>
               <th>Status</th>
             
              </tr>
          </thead>
          <tbody>
             @foreach($customers_accounts as $invoice)
              <tr>
                <td><input type="checkbox" name="account_checkbox[]" class="  " value="{{$invoice->id}}" />
                    <input type="hidden" name="account_id" value="{{$invoice->id}}" id="account_id">  
                   </td>  
                <td class="text-center">
                 @if(@$invoice->status == 1)
                <span>--</span>
                 @else
                 <a href="{{url('admin/invoice-view/'.@$invoice->id)}}"><span style="border: 1px solid green;padding: 3px;cursor: pointer;" class="view" data-id="{{@$invoice->id}}"><i class="fa fa-eye" style="color: green;" title="View It"></i></span></a>
              
                  <span style="border: 1px solid green;padding: 3px;cursor: pointer;" class="approve" data-id="{{@$invoice->id}}"><i class="fa fa-check" style="color: green;" title="Approve It"></i></span>
                  
                  @endif
               </td>
                <td>
                 <a href="javascript:void(0)" class="themecolor download_invoice" data-id="{{@$invoice->id}}"><b>C{{@$invoice->id}}</b></a>
                </td>
                <td>
                   <a target="" href="{{url('admin/active/user-detail/'.@$invoice->customer_id)}}" class="themecolor"><b>{{@$invoice->get_customer->customer_company !== null ? @$invoice->get_customer->customer_company : '--'}}</b></a>
                </td>
                <td>
                 <span style="color: green;">+ €
                    {{@$invoice->paid_amount != 0.00 ? @$invoice->paid_amount : (@$invoice->credit != 0.00 ? @$invoice->credit : @$invoice->debit)}}
                    </span>
                </td>
                <td>
                   {!! @$invoice->get_detail($invoice->id) !!}
                </td>
                
                <td><span> {{ @$invoice->get_type($invoice->type) }}</span></td>
                <td>{{@$invoice->created_at->format('d/m/Y')}}</td>
                <td>{{@$invoice->status == 0 ? 'Pending' : 'Approved'}}</td>
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
$('#checkAll').on('click', function(e) {
if($(this).is(':checked',true))  
{
$(".account_checkbox").prop('checked', true);  
} else {  
$(".account_checkbox").prop('checked',false);  
}  
}); 
var table = $('#myTable').DataTable({
// searching: false
});
$('.approve').on('click',function(){
var id = $(this).data('id');
// alert(id);
swal({
title: "Are you sure!!!",
text: "You want to approve this request. The post will go to Pending status !!!",
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
});
$('#bulk_delete').on('click', function(){
var id = [];
swal({
title: "Alert!",
text: "Are you sure you want to Delete Pending Invoices?",
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
$('.account_checkbox:checked').each(function(){
id.push($(this).val());
});
if(id.length > 0)
{
$.ajax({
url:"{{url('admin/delete-invoice')}}",
method:"get",
data:{id:id},
success:function(data)
{
if(data.success == true){

toastr.success('Success!', data.message ,{"positionClass": "toast-bottom-right"});
location.reload();

}
}
});
}
else
{
alert("Please select atleast one checkbox");
// $('#myTable').api().ajax.reload();
// table.api().ajax.reload();


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