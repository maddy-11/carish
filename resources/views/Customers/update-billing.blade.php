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
@push('scripts')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="{{ asset('public/js/bootstrap-formhelpers-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/bootstrapValidator-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
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



       $('#billingForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-spinner'
        },
    submitHandler: function(validator, form, submitButton) {
                 var form$ = $("#billingForm");
                    // and submit
                    form$.get(0).submit();
    
                return false; // 3submit from callback
        },
        fields: {
            billing_address: {
                validators: {
                    notEmpty: {
                        message: 'The address is required and cannot be empty'
                    },
          stringLength: {
                        min: 6,
                        max: 100,
                        message: 'The address must be more than 6 and less than 100 characters long'
                    }
                }
            },
            billing_city: {
                validators: {
                    notEmpty: {
                        message: 'The city is required and cannot be empty'
                    }
                }
            },
      billing_zipcode: {
                validators: {
                    notEmpty: {
                        message: 'The zip is required and cannot be empty'
                    },
          stringLength: {
                        min: 3,
                        max: 9,
                        message: 'The zip must be more than 3 and less than 9 characters long'
                    }
                }
            },
            billing_email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and can\'t be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
      billing_first_name: {
                validators: {
                    notEmpty: {
                        message: 'The first name is required and can\'t be empty'
                    }
                }
            },
        billing_last_name: {
                validators: {
                    notEmpty: {
                        message: 'The last name is required and can\'t be empty'
                    }
                }
            },
        }
    });

    
  });
    
</script>
@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <h2>Billing Information</h2>
        <div class="alert alert-danger" id="a_x200" style="display: none;"> <strong>Error!</strong> <span class="payment-errors"></span> </div>
       {{ Form::open(['class' => 'horizontal-form', 'method' => 'POST', 'id' => 'billingForm']) }}
        
            <div class="form-group">
                {!! Form::label('firstname', 'First Name <span class="required">*</span>', ['class' => 'form-label'], false) !!}    
                {!! Form::text('billing_first_name', $value = @$customer->billinginfo->billing_first_name, ['class' => 'form-control', 'placeholder' => 'First Name', 'id' => 'firstname', 'maxlength' => 100]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('lastname', 'Last Name <span class="required">*</span>', ['class' => 'form-label'], false) !!}    
                {!! Form::text('billing_last_name', $value = @$customer->billinginfo->billing_last_name, ['class' => 'form-control', 'placeholder' => 'Last Name', 'id' => 'lastname', 'maxlength' => 100]) !!}        
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email <span class="required">*</span>', ['class' => 'form-label'], false) !!}    
                {!! Form::email('billing_email', $value = @$customer->billinginfo->billing_email, ['class' => 'form-control', 'placeholder' => 'Email', 'id' => 'email', 'maxlength' => 100]) !!}    
            </div>
            <div class="form-group">    
                {!! Form::label('address', 'Address Line 1<span class="required">*</span>', ['class' => 'form-label'], false) !!}    
                {!! Form::text('billing_address', $value = @$customer->billinginfo->billing_address, ['class' => 'form-control', 'placeholder' => 'Address Line 1', 'id' => 'address', 'maxlength' => 100, 'required']) !!}
            </div>  
            <div class="form-group">    
                {!! Form::label('address2', 'Address Line 2', ['class' => 'form-label'], false) !!}    
                {!! Form::text('billing_address_2', $value = @$customer->billinginfo->billing_address_2, ['class' => 'form-control', 'placeholder' => 'Address Line 2', 'id' => 'address2', 'maxlength' => 100]) !!}
            </div>  
            <div class="form-group">
                {!! Form::label('country', 'Country <span class="required">*</span>', ['class' => 'form-label'], false) !!}  

                {!! Form::select('country_id', $countries, @$customer->billinginfo->country_id, ['id' => 'country', 'class' => 'selectpicker form-control col-md-7 col-xs-12 bootstrap-select', 'title' => 'Choose Country', 'data-live-search' => 'true', 'required']) !!}
            </div>
            <div class="form-group">
                {{ Form::label('state', 'State <span class="required">*</span>', $attributes = ['class' => 'control-label'], false) }}

                 {!! Form::select('state_id', $states, @$customer->billinginfo->state_id, ['id' => 'state', 'class' => 'selectpicker form-control col-md-7 col-xs-12', 'title' => 'Choose State', 'data-live-search' => 'true', 'required']) !!}
            </div>     
            <div class="form-group">
                 {!! Form::label('city', 'City <span class="required">*</span>', ['class' => 'form-label'], false) !!}    
                 
                 {!! Form::text('billing_city', $value = @$customer->billinginfo->billing_city, ['class' => 'form-control', 'placeholder' => 'City', 'id' => 'city', 'maxlength' => 100]) !!}
            </div>

            <div class="form-group">
                 {!! Form::label('zipcode', 'Zip Code <span class="required">*</span>', ['class' => 'form-label'], false) !!}    
                 
                 {!! Form::text('billing_zipcode', $value = @$customer->billinginfo->billing_zipcode, ['class' => 'form-control', 'placeholder' => 'Zipcode', 'id' => 'city', 'maxlength' => 100]) !!}
            </div>

            <div class="form-group">
                 {!! Form::label('company', 'Company', ['class' => 'form-label'], false) !!}    
                 
                 {!! Form::text('billing_company', $value = @$customer->billinginfo->billing_company, ['class' => 'form-control', 'placeholder' => 'Company', 'id' => 'company', 'maxlength' => 100]) !!}
            </div>
          
            <button type="submit" id="subBtn" class="btn btn-success submit">Save</button>
       {{ Form::close() }}

    </div>
</div>
<!-- end row -->
@stop