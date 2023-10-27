</body>
</html>
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Carish | Admin Log in</title>
<!-- Bootstrap CSS -->
<link href="{{url('public/admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{url('public/admin/assets/css/login.css')}}" rel="stylesheet" type="text/css">
</head>
<body class="loginBody">
<div class="absolute d-flex h-100 loginwrapper ml-0 mr-0 row w-100">
  <div class="align-items-center d-md-flex login-left text-center text-white d-none">
    <div class="login-left-bg">
      <img src="{{url('public/admin/assets/img/logo-left.png')}}" class="d-block img-fluid ml-auto mr-auto login-bg-logo" alt="carish used cars for sale in estonia">
      <h4>lorem ipsum dolor sit amet</h4>
      <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h4>
      <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
  </div>
  <div class="login-right align-items-center d-flex ml-auto  ml-auto mr-auto">
    <div class="login-right-bg w-100">
      <div class="login-form">
        <h2 class="fontbold text-uppercase welcometitle">Welcome</h2>
        <img src="{{url('public/admin/assets/img/logo-right.png')}}" class="d-block img-fluid login-form-logo" alt="carish used cars for sale in estonia">
        <h4 class="fontbold text-uppercase">Login</h4>
        <p>Enter your details below.</p>
          <form method="POST" action="{{ route('admin.login') }}">
               @csrf
          <div class="form-group">
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
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="assets/js/jquery-3.3.1.slim.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{url('public/admin/assets/js/popper.min.js')}}"></script>
<script src="{{url('public/admin/assets/js/bootstrap.min.js')}}"></script>
<script src="{{url('public/admin/assets/js/menuscript.js')}}"></script>
</body>
</html>