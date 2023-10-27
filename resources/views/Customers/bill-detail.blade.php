@extends('layouts.master')
@section('title')Billing Information @stop
@push('styles')
<link rel="stylesheet" href="{{ asset('public/css/bootstrap-formhelpers-min.css') }}" media="screen">
<link rel="stylesheet" href="{{ asset('public/css/bootstrapValidator-min.css') }}"/>
<link rel="stylesheet" href="{{ asset('public/plugins/bootstrap-select/css/bootstrap-select.min.css') }}">
<style type="text/css">
    .required{
        color: red;
    }

.bootstrap-select.btn-group .dropdown-menu {
    max-height: 250px !important;
}
.card-month, .card-year{
  width: 49% !important; 
  display: inline-block;
}
.label-img{
  margin-left: 5px; 
}
.fa-check{
  color:green;
}

.fa-times{
  color:red;
}
.help-block{
  color:red;
  font-size:14px;
}


</style>
@endpush

@section('content')
<div class="row">
    <div class="col-6">
      <h3>Billing Information <span class="pull-right"><a target="" href="{{ route('customers.updatebilling') }}" title="Update Billing Info"><i class="fa fa-pencil"></i></a></span></h3>
        <table class="table table-hover" style="border: 0px;">
          <tbody>
          <tr>
              <th>Billing First Name</th>
              <td>{{ $customer->billingInfo->billing_first_name }}</td>
          </tr>    
          <tr>
              <th>Billing Last Name</th>
              <td>{{ $customer->billingInfo->billing_last_name }}</td>
          </tr>  
          <tr>
              <th>Billing Email</th>
              <td>{{ $customer->billingInfo->billing_email }}</td>  
          </tr>
          <tr>
              <th>Billing Address</th>
              <td>{{ $customer->billingInfo->billing_address.' '.$customer->billingInfo->billing_address_2 }}</td>  
          </tr>
          <tr>
              <th>Billing Country</th>
              <td>{{ $customer->billingInfo->country->name }}</td>  
          </tr>
          <tr>
              <th>Billing State</th>
              <td>{{ $customer->billingInfo->state->name }}</td>  
          </tr>
          <tr>
              <th>Billing City</th>
              <td>{{ $customer->billingInfo->billing_city }}</td>  
          </tr>
          <tr>
              <th>Billing ZipCode</th>
              <td>{{ $customer->billingInfo->billing_zipcode }}</td>  
          </tr>
          <tr>
              <th>Billing Company</th>
              <td>{{ (!empty($customer->billingInfo->billing_company))? $customer->billingInfo->billing_company : 'N.A' }}</td>  
          </tr>
          <tr>
              <th>Created at</th>
              <td>{{ $customer->billingInfo->created_at }}</td>  
          </tr>
          </tbody>
        </table>
    </div>
             
    <div class="col-6">
        <h3>Payment Information <span class="pull-right"> 
          <div class="dropdown">
            <a href="javascript:void(0)" data-toggle="dropdown" title="Update Payment Info" class=""><i class="fa fa-pencil"></i></a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
              <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('customers.cupdate') }}">Update Card</a></li>
              <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#expiryModal" tabindex="-1" style="cursor: pointer;">Update Expiry</a></li>
            </ul>
          </div></span></h3>
        <table class="table table-hover" style="border: 0px;">
          <tbody>
          <tr>
              <th>Credit Card</th>
              <td>{{ '**** **** **** '.$customer->billingInfo->billing_detail->card_last_4 }}</td>
          </tr>
          <tr>
              <th>Card Type</th>
              <td>{{ $customer->billingInfo->billing_detail->card_type }}</td>
          </tr>
          </tbody>
        </table>    

    </div>
</div>
<!-- end row -->
<div id="expiryModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Card Expiry</h4>
      </div>
      {!! Form::open(['class' => 'horizontal-form', 'method' => 'POST', 'id' => 'expiryForm', 'url' => 'customers/billing-info/update-expiry']) !!}
      <div class="modal-body">
        <p>
          {!! Form::select('exp_month', $months, null, ['id' => 'exp_date', 'class' => 'form-control col-md-7 col-xs-12 card-month', 'title' => 'Choose Expiry Month', 'data-live-search' => 'true', 'data-stripe' => "exp-month"]) !!}

          {!! Form::select('exp_year', $years, null, ['id' => 'exp_year', 'class' => 'form-control col-md-7 col-xs-12 card-year', 'title' => 'Choose Expiry Year', 'data-live-search' => 'true', 'data-stripe' => "exp-year"]) !!}
        </p>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      {{ Form::close() }}
    </div>

  </div>
</div>

@stop