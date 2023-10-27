@extends('admin.layouts.app')
@push('styles')
<link type="text/css" rel="stylesheet" href="{{asset('public/assets/css/lightslider.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('public/assets/css/lightgallery.min.css')}}" />
@endpush

@push('scripts')
<script src="{{asset('public/assets/js/lightslider.js')}}"></script>
<script src="{{asset('public/assets/js/lightgallery-all.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
@endpush
@section('content') 

<div class="bg-white main-titl-row  pb-3 pt-3 row align-items-center ">
  <div class="d-md-none h-search-col search-col col-12 collapse" id="searchsection">
    <div class="input-group custom-input-group mb-3" >
      <input type="text" class="form-control" placeholder="Search">
      <div class="align-items-center input-group-prepend">
        <span class="input-group-text fa fa-search"></span>
      </div>
    </div>
  </div>
  <div class="col-lg-8 col-md-7 col-sm-7  title-col">
       <h3 class="fontbold maintitle mb-2 mb-sm-0 text-capitalize">Invoice / C{{ @$invoice->id }}</h3>
  </div>
  <div class="col-lg-4 col-md-5 col-sm-5 search-col text-right">
    <a class="btn btn-primary" href="{{ url()->previous() }}">
      <i class="fa fa-arrow-left"></i> Back
    </a>
    @if($invoice->status == '0')
    <a class="btn btn-success approve"  data-id="{{@$invoice->id}}" href="javascript:void(0)">Approve</a>
    <a class="btn btn-success download_invoice" data-id="{{@$invoice->id}}" href="javascript:void(0)">Download</a>
    @endif
  </div>
</div>
<div class="container-fluid">
<div class="row">
    <div class="col-6 col-md-6 dr-personal-prof mb-6">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
            <div class="section-header">
                <h5 class="mb-1 text-capitalize"> Invoice Detail</h5>
            </div>
                    <h5 class="font-weight-bold mb-1"></h5>
                    <div class="dr-job text-capitalize"></div>
                    <div class="row mt-3 dr-detail-row">
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Invoice No:</h6>
                            <p class="mb-0">C{{ @$invoice->id }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Customer:</h6>
                            <p class="mb-0"> {{ @$invoice->get_customer->customer_company }}  </p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1" class="text-uppercase">Type:</h6>
                            <p class="mb-0">{{ @$invoice->get_type($invoice->type) }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Amount:</h6>
                            <p class="mb-0">+ €{{@$invoice->paid_amount != null ? @$invoice->paid_amount : (@$invoice->credit != null ? @$invoice->credit : @$invoice->debit)}}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Number of Days:</h6>
                            <p class="mb-0">{{ @$invoice->number_of_days }}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Details:</h6>
                            <p class="mb-0">
                                {!! @$invoice->get_detail($invoice->id) !!}
                        </p>
                        </div>
                        
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Created Date:</h6>
                            <p class="mb-0"> {{@$invoice->created_at->format('d/m/Y')}}</p>
                        </div>
                        <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Status:</h6>
                            <p class="mb-0">{{@$invoice->status == 0 ? 'Pending' : 'Approved'}}</p>
                        </div>
            </div>
            </div> 
        </div>
    <!-- <div class="col-6 col-md-6 dr-personal-prof mb-6">
        <div class="bg-white custompadding customborder h-100 d-flex flex-column">
            <div class="section-header">
                <h5 class="mb-1 text-capitalize"> Customer Info</h5>
            </div>
            
                    <h5 class="font-weight-bold mb-1"></h5>
                    <div class="dr-job text-capitalize"></div>
                    <div class="row mt-3 dr-detail-row">
                      <div class="col-md-6 col-6 mb-3 dr-detail-col">
                            <h6 class="text-capitalize font-weight-bold mb-1">Phone of Service:</h6>
                            <p class="mb-0">abc</p>
                        </div>
                    </div>
                    
            </div> 
    </div> -->
</div>
</div>
<!-- container end -->
<!-- export pdf form starts -->
      <form class="export-quot-form" method="post" action="{{route('admin-export-pdf')}}">
        @csrf
       <input type="hidden" name="invoice_number" class="invoice_number">
      </form>
    <!-- export pdf form ends -->
@push('custom-scripts')
<script>
    $('.approve').on('click',function(){
    var id = $(this).data('id');
    // alert(id);
    swal({
              title: "Are you sure!!!",
              text: "You want to approve this request. The post will directly go to active status !!!",
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
</script>
@endpush
@endsection