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

        Stripe.setPublishableKey("{{ config('services.stripe.key') }}");

       function stripeResponseHandler(status, response) {
                if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
          // show hidden div
          document.getElementById('a_x200').style.display = 'block';
                    // show the errors on the form
                    $(".payment-errors").html(response.error.message);
                } else {                
                    var form$ = $("#billingForm");
                      $('.card-number').remove();
                        $('.card-cvc').remove('');
                        $('.card-month').val('');
                        $('.card-year').val('');
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
                    form$.get(0).submit();
                }
            }
     

       $('#billingForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-spinner'
        },
    submitHandler: function(validator, form, submitButton) {

      Stripe.card.createToken({
          number: $('.card-number').val(),
          cvc: $('.card-cvc').val(),
          exp_month: $('.card-month').val(),
          exp_year: $('.card-year').val(),
        }, stripeResponseHandler);
                return false; // 3submit from callback
        },
        fields: {
    
      cardnumber: {
    selector: '#cardnumber',
                validators: {
                    notEmpty: {
                        message: 'The credit card number is required and can\'t be empty'
                    },
          creditCard: {
            message: 'The credit card number is invalid'
          },
                }
            },

      expMonth: {
                selector: '[data-stripe="exp-month"]',
                validators: {
                    notEmpty: {
                        message: 'The expiration month is required'
                    },
                    digits: {
                        message: 'The expiration month can contain digits only'
                    },
                    callback: {
                        message: 'Expired',
                        callback: function(value, validator) {
                            value = parseInt(value, 10);
                            var year         = validator.getFieldElements('expYear').val(),
                                currentMonth = new Date().getMonth() + 1,
                                currentYear  = new Date().getFullYear();
                            if (value < 0 || value > 12) {
                                return false;
                            }
                            if (year == '') {
                                return true;
                            }
                            year = parseInt(year, 10);
                            if (year > currentYear || (year == currentYear && value > currentMonth)) {
                                validator.updateStatus('expYear', 'VALID');
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            },
            expYear: {
                selector: '[data-stripe="exp-year"]',
                validators: {
                    notEmpty: {
                        message: 'The expiration year is required'
                    },
                    digits: {
                        message: 'The expiration year can contain digits only'
                    },
                    callback: {
                        message: 'Expired',
                        callback: function(value, validator) {
                            value = parseInt(value, 10);
                            var month        = validator.getFieldElements('expMonth').val(),
                                currentMonth = new Date().getMonth() + 1,
                                currentYear  = new Date().getFullYear();
                            if (value < currentYear || value > currentYear + 100) {
                                return false;
                            }
                            if (month == '') {
                                return false;
                            }
                            month = parseInt(month, 10);
                            if (value > currentYear || (value == currentYear && month > currentMonth)) {
                                validator.updateStatus('expMonth', 'VALID');
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            },
      cvv: {
    selector: '#cvv',
                validators: {
                    notEmpty: {
                        message: 'The cvv is required and can\'t be empty'
                    },
          cvv: {
                        message: 'The value is not a valid CVV',
                        creditCardField: 'cardnumber'
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
       {{ Form::open(['class' => 'horizontal-form', 'method' => 'POST', 'id' => 'billingForm', 'action' => "route('billing.postcupdate')"]) }}
        
            <div class="form-group">
                 {!! Form::label('cardnumber', 'Card Number <span class="required">*</span>', ['class' => 'form-label'], false) !!}<img src="{{ asset('public/img/visa-cart.png') }}" class="label-img">
                 
                 {!! Form::text('cardnumber', $value = null, ['class' => 'form-control card-number', 'placeholder' => 'Card Number', 'id' => 'cardnumber', 'maxlength' => 19]) !!} 
            </div>

            <div class="form-group">
                 {!! Form::label('exp_date', 'Expiration Month <span class="required">*</span>', ['class' => 'form-label'], false) !!} <br> 
                 
                 {!! Form::select('expMonth', $months, null, ['id' => 'exp_date', 'class' => 'form-control col-md-7 col-xs-12 card-month', 'title' => 'Choose Expiry Month', 'data-live-search' => 'true', 'data-stripe' => "exp-month"]) !!}

                 {!! Form::select('expYear', $years, null, ['id' => 'exp_year', 'class' => 'form-control col-md-7 col-xs-12 card-year', 'title' => 'Choose Expiry Year', 'data-live-search' => 'true', 'data-stripe' => "exp-year"]) !!}
            </div>

            <div class="form-group">
                 {!! Form::label('cvv', 'Card Security Number <span class="required">*</span> <small>
The last 3 numbers on the back of your card</small>', ['class' => 'form-label'], false) !!} <img src="{{ asset('public/img/security-code-img.png') }}" class="label-img" >   
                 
                 {!! Form::text('cvv', $value = null, ['class' => 'form-control card-cvc', 'placeholder' => 'Card Security Number', 'id' => 'cvv', 'maxlength' => 4]) !!}
            </div>

            <button type="submit" id="subBtn" class="btn btn-success submit">Save</button>
       {{ Form::close() }}

    </div>
</div>
<!-- end row -->
@stop