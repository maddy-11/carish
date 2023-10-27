    <!DOCTYPE html>
    <html lang="{{ app()->getLocale() }}">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | @yield('title')</title>
     <!-- App favicon -->

    <link href="{{ asset('public/assets/images/favicon.ico') }}" rel="shortcut">
      
    <!-- Bootstrap 3.3.7 --> 
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome --> 
    <!-- NProgress -->
    <link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('public/assets/css/metismenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet">
    <!-- Google Font --> 
    <script src="{{ asset('public/assets/js/modernizr.min.js') }}"></script>
    <!--.......................-->
    @stack('styles')  
    <script>
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
    ]) !!};
    </script>
    </head>
     
  <body class="account-pages">
        <!-- Begin page -->
  

    @yield('content')

    <!-- jQuery 3.1.1 -->
    <script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('public/assets/js/popper.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('public/assets/js/metisMenu.min.js') }}"></script>
    <script src="{{asset('public/assets/js/waves.js') }}"></script> 
    <script src="{{ asset('public/assets/js/jquery.slimscroll.js') }}"></script> 
      <!-- App scripts -->
    @stack('scripts')
    <script src="{{ asset('public/assets/js/jquery.core.js') }}"></script> 
     <!-- Restfulizer.js - A tool for simulating put,patch and delete requests -->
    <script src="{{ asset('public/assets/js/jquery.app.js') }}"></script> 

    </body> 
    </html>
