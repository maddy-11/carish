@extends('layouts.master')
@section('title')Shipping Information @stop
@push('styles')
<link rel="stylesheet" href="{{ asset('public/plugins/bootstrap-select/css/bootstrap-select.min.css') }}">
<style type="text/css">
    .required{
        color: red;
    }

.bootstrap-select.btn-group .dropdown-menu {
    max-height: 250px !important;
}
</style>
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('public/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
<script type="text/javascript">
    $('#country').on('change', function(){
          $.ajax({
              type: "GET",
              dataType: "json",
              url: "{{ route('customers.state') }}",
              data : 'country='+$(this).val(),
              success:function(data){
                //console.log(data);
                $('#state').html('');
                  for (var i = 0; i < data.states.length; i++) { 
                        $('#state').append("<option value='"+data.states[i].id+"'>"+data.states[i].name+"</option>")
                      }
                  $('#state').selectpicker('refresh');   
              }
          });
     });
</script>
@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <h2>Shipping Information</h2>
       {{ Form::open(['class' => 'horizontal-form', 'method' => 'POST']) }}
            <div class="form-group">
                {!! Form::label('firstname', 'First Name <span class="required">*</span>', ['class' => 'form-label'], false) !!}    
                {!! Form::text('shipping_first_name', $value = @$customer->shippinginfo->shipping_first_name, ['class' => 'form-control', 'placeholder' => 'First Name', 'id' => 'firstname', 'maxlength' => 100, 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('lastname', 'Last Name <span class="required">*</span>', ['class' => 'form-label'], false) !!}    
                {!! Form::text('shipping_last_name', $value = @$customer->shippinginfo->shipping_last_name, ['class' => 'form-control', 'placeholder' => 'Last Name', 'id' => 'lastname', 'maxlength' => 100, 'required']) !!}        
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email <span class="required">*</span>', ['class' => 'form-label'], false) !!}    
                {!! Form::email('shipping_email', $value = @$customer->shippinginfo->shipping_email, ['class' => 'form-control', 'placeholder' => 'Email', 'id' => 'email', 'maxlength' => 100, 'required']) !!}    
            </div>
            <div class="form-group">    
                {!! Form::label('address', 'Address Line 1 <span class="required">*</span>', ['class' => 'form-label'], false) !!}    
                {!! Form::text('shipping_address_1', $value = @$customer->shippinginfo->shipping_address_1, ['class' => 'form-control', 'placeholder' => 'Address Line 1', 'id' => 'address', 'maxlength' => 100, 'required']) !!}
            </div>    
            <div class="form-group">    
                {!! Form::label('address', 'Address Line 2', ['class' => 'form-label'], false) !!}    
                {!! Form::text('shipping_address_2', $value = @$customer->shippinginfo->shipping_address_2, ['class' => 'form-control', 'placeholder' => 'Address Line 2', 'id' => 'address', 'maxlength' => 100]) !!}
            </div>    
            <div class="form-group">
                {!! Form::label('country', 'Country <span class="required">*</span>', ['class' => 'form-label'], false) !!}  

                {!! Form::select('country_id', $countries, @$customer->shippinginfo->country_id, ['id' => 'country', 'class' => 'selectpicker form-control col-md-7 col-xs-12 bootstrap-select', 'title' => 'Choose Country', 'data-live-search' => 'true', 'required']) !!}
            </div>
            <div class="form-group">
                {{ Form::label('state', 'State <span class="required">*</span>', $attributes = ['class' => 'control-label'], false) }}

                 {!! Form::select('state_id', ['0' => 'Please Select a Country'], @$customer->shippinginfo->state_id, ['id' => 'state', 'class' => 'selectpicker form-control col-md-7 col-xs-12', 'title' => 'Choose State', 'data-live-search' => 'true', 'required']) !!}
            </div>     
            <div class="form-group">
                 {!! Form::label('city', 'City <span class="required">*</span>', ['class' => 'form-label'], false) !!}    
                 
                 {!! Form::text('shipping_city', $value = @$customer->shippinginfo->shipping_city, ['class' => 'form-control', 'placeholder' => 'City', 'id' => 'city', 'required']) !!}
            </div>
            <div class="form-group">
                 {!! Form::label('post_code', 'Postal Code <span class="required">*</span>', ['class' => 'form-label'], false) !!}    
                 
                 {!! Form::text('shipping_postcode', $value = @$customer->shippinginfo->shipping_postcode, ['class' => 'form-control', 'placeholder' => 'City', 'id' => 'post_code', 'maxlength' => 6, 'required']) !!}
            </div>
            <div class="form-group">
                 {!! Form::label('company', 'Company', ['class' => 'form-label'], false) !!}    
                 
                 {!! Form::text('shipping_company', $value = @$customer->shippinginfo->shipping_company, ['class' => 'form-control', 'placeholder' => 'Company', 'id' => 'company']) !!}
            </div>
            {{ Form::submit('Save', ['class' => 'btn btn-success']) }}     
       {{ Form::close() }}

    </div>
</div>
<!-- end row -->
@stop