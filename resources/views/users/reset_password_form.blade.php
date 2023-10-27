@extends('layouts.app')
@section('title') Register Signup @endsection
@push('styles')

@endpush
@push('scripts')
@endpush
@section('content')
<!-- Begin page -->

<div class="internal-page-content mt-4 pt-5 sects-bg">
<div class="container pt-2">
  <div class="row">
     <div class="col-lg-5 mx-auto col-12 sign-in-col">
      <div class="signInbg box-shadow bg-white p-md-5 p-sm-4 p-3 pt-4 rounded">
   <form method="post" id="reset_form">
    {{csrf_field()}}
  <input type="hidden" name="id" value="{{@$id}}">
  <input type="hidden" name="p_token" value="{{@$token}}">
  <div class="form-group">
    <label for="exampleInputPassword1">New Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
  </div>
   <div class="form-group">
    <label for="exampleInputPassword2">Confirm Password</label>
    <input type="password" class="form-control" id="exampleInputPassword2" name="confirm_password" placeholder="Password">
    <p class="text-danger d-none" id="alert_reset">Password Does Not Match</p>
  </div>
 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
  </div>
</div>
</div>
@push('scripts')
<script type="text/javascript">
  $('#reset_form').on('submit',function(e){
    e.preventDefault();

    var pass = $('#exampleInputPassword1').val();
    var confirm = $('#exampleInputPassword2').val();
   
    if(pass != confirm){
        $('#alert_reset').removeClass('d-none');
        return false;
    }else{
       $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
     $.ajax({
        url: "{{ route('password.reset.form.post') }}",
        method: 'post',
        data: new FormData(this), 
        contentType: false,       
        cache: false,             
        processData:false,
        beforeSend: function(){
          $('#loader_modal').modal('show');
        },
        success: function(result){
        
          if(result.error === true){
            
            toastr.success('warning!', 'Not eligible to change password',{"positionClass": "toast-bottom-right"});
            $('#reset_form')[0].reset();
            
          }

          if(result.done == true){

             toastr.success('Success!', 'Password Update Successfully!',{"positionClass": "toast-bottom-right"});
          
            setTimeout(function(){
            window.location.href = "{{route('signin')}}";
        
            }, 2000);

            // window.location.href="{{url('sales/')}}"; 
          }
          
          
        },
        error: function (request, status, error) {
             
          }
      });
    }
  });
</script>
@endpush
@stop