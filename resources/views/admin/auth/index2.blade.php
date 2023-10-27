<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style type="text/css">
    body{
      background-size: cover;
      background-repeat: no-repeat;
      height: 100%;
      
    }
    html , body {
      height: 100%;
  margin: 0;
    }
    .centered {
  position: fixed;
  top: 50%;
  left: 50%;
  /* bring your own prefixes */
  transform: translate(-50%, -50%);
  background-color: #f5f5f5;
  min-width: 400px;
  padding: 20px;
  border-radius: 10px;
}
    .login_container{
      background-color: rgba(1,123,170,0.9);
      height: 100%;
    }
  </style>
</head>
<body background="{{asset('public/assets/img/admin_background.png')}}">
<div class="login_container">
  <div class="centered">
    <div style="text-align: center;">
      <img src="{{asset('public/admin/assets/img/logo-right.png')}}" width="25%">
      <p>Welcome back! Please login to continue.</p>
    </div>
    <div style="margin-top: 20px;">
       <form method="POST" action="{{ route('admin.login') }}">
               @csrf
       <!--    <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter Your Email Here" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}">
          </div>
          <div class="form-group mb-3">
            <label>Password</label>
            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required placeholder="Enter Your Password Here">

          </div>
          <div class="form-group justify-content-between mb-3 mb-md-5 pb-2 row">
            <div class="col-6 checkbox">
               <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                <label class="custom-control-label text-capitalize" for="customCheck">remember me</label>
              </div>
            </div>
             <div class="col-6 forgetpassrd text-right">
              <a href="javascript:void(0)">Forgot Password?</a>
            </div>
          </div>
           <div class="align-items-center d-flex form-group justify-content-between mb-0">
            <button type="submit" class="btn btn-custom login-btn text-uppercase fontbold">Log In</button>
          </div> -->

          <div class="input-group" style="width: 380px;margin: auto;height: 40px;margin-bottom: 15px;">
          <span class="input-group-addon" style="background-color: white;"><i class="glyphicon glyphicon-envelope"></i></span>
          <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" placeholder="Username or Email" value="{{ old('email') }}" style="height: 40px;">
        </div>
        <br>
        <div class="input-group" style="width: 380px;margin: auto;height: 40px;margin-bottom: 15px;">
          <span class="input-group-addon"  style="background-color: white;"><i class="glyphicon glyphicon-lock"></i></span>
          <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required="true" placeholder="Password" style="height: 40px;">
        </div>
        <div class="row">
          <div class="col-sm-6 checkbox">
             <label><input type="checkbox"> Remember me</label>
          </div>
          <div class="col-sm-6 forgetpassrd text-right" style="margin: 10px 0;">
               
              <a href="javascript:void(0)">Forgot Password?</a>
            
          </div>

        </div>
        <div class="align-items-center d-flex text-center form-group justify-content-between mb-0">
            <button type="submit" class="btn btn-custom login-btn text-uppercase fontbold" style="background:#017baa;color: white;">Sign In</button>
          </div>
        </form>
    </div>
  </div>
</div>
</body>
</html>