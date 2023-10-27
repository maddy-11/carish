Array<MOOTORI_MAHT>1399</MOOTORI_MAHT>     // cc
      <MOOTORI_VOIMSUS>71</MOOTORI_VOIMSUS>  // KW
(
    [SOIDUKID] => Array
        (
            [SOIDUK] => Array
                (
                    [MARK] => HYUNDAI
                    [NIMETUS] => I 20
                    [TYYBIKINNITUSE_NR] => e11*2007/46*0129
                    [TYYP] => PBT
                    [VARIANT] => F5P51
                    [VERSIOON] => A41AZ1
                    [KATEGOORIA] => Sõiduauto
                    [KAT_LYHEND] => M1
                    [KERENIMETUS] => LUUKPÄRA
                    [KERETYYP] => AF
                    [BAASTEHAS] => HYUNDAI MOTOR COMPANY
                    [VARV] => TUMESININE
                    [MITMEVARVILINE] => E
                    [ESMAREG_KP] => 2011-09-27
                    [EESTIS_ESMAREG_KP] => 2011-09-27
                    [JARGMISE_YLEVAATUSE_AEG] => 2020-10-31
                    [SOIDUKI_OLEK] => REGISTREERITUD
                    [TAISMASS] => 1565
                    [REG_MASS] => 1565
                    [TYHIMASS] => 1138
                    [KANDEVOIME] => 427
                    [AUTORONGI_MASS] => 2365
                    [HAAGIS_PIDURITEGA] => 800
                    [HAAGIS_PIDURITETA] => 450
                    [HAAKESEADME_KOORMUS] => 50
                    [PIKKUS] => 3940
                    [LAIUS] => 1710
                    [KORGUS] => 1490
                    [TELGEDE_VAHED] => 2525
                    [TELGI_KOKKU] => 2
                    [JUHTTELGI] => 1
                    [VEOTELGI] => 1
                    [MOOTORI_MUDEL] => G4FA
                    [MOOTORI_MAHT] => 1396
                    [MOOTORI_VOIMSUS] => 74
                    [MOOTORI_POORDED] => 5500
                    [MOOTORI_TYYP] => BENSIIN_KATALYSAATOR
                    [KAIGUKASTI_TYYP] => AUTOMAAT
                    [SUURIM_KIIRUS] => 172
                    [HEITMENORM] => EURO5
                    [SEISUMYRA] => 77
                    [SOIDUMYRA] => 71
                    [CO2] => 135
                    [KYTUSEKULU_KESK] => 5.8
                    [KYTUSEKULU_LINNAS] => 7.7
                    [KYTUSEKULU_TEEL] => 4.7
                    [UKSI] => 5
                    [ISTEKOHTI] => 5
                    [ISTEKOHTI_JUHT] => 1
                    [SOIDUKI_ANDMED_EBATAPSED] => E
                    [TELJED] => Array
                        (
                            [TELG] => Array
                                (
                                    [0] => Array
                                        (
                                            [TELJE_NR] => 1.
                                            [BAAS] => 2525
                                            [REG_TELJEKOORMUS] => 850
                                            [LUBATUD_TELJEKOORMUS] => 850
                                            [JUHTTELG] => J
                                            [VEOTELG] => J
                                            [A] => 175/70 R14 84T
                                            [B] => 185/60 R15 84H
                                        )

                                    [1] => Array
                                        (
                                            [TELJE_NR] => 2.
                                            [REG_TELJEKOORMUS] => 840
                                            [LUBATUD_TELJEKOORMUS] => 840
                                            [JUHTTELG] => E
                                            [VEOTELG] => E
                                            [A] => 175/70 R14 84T
                                            [B] => 185/60 R15 84H
                                        )

                                )

                        )

                )

        )

    [SISENDPARAMEETRID] => Array
        (
            [REGMARK] => 105BFL
        )

)
Array
(
    [category] => M1
    [model] => I 20
    [make] => HYUNDAI
    [variant] => F5P51
    [version] => A41AZ1
    [enginType] => BENSIIN_KATALYSAATOR
    [cc] => 1.4
    [enginPower] => 74
    [number_of_door] => 5
    [length] => 3940
    [width] => 1710
    [height] => 1490
    [weight] => 1565
    [curb_weight] => 1138
    [wheel_base] => 2525
    [seating_capacity] => 5
    [torque] => 5500
    [max_speed] => 172
    [transmission_type] => automaat
    [fuel_type] => bensiin_katalysaator
    [front_tyre_size] => 175/70 R14 84T
    [back_tyre_size] => 185/60 R15 84H
    [front_wheel_size] => 175/70 R14 84T
    [back_wheel_size] => 185/60 R15 84H
    [fuel_average] => 5.8
    [cost_in_city] => 7.7
    [cost_on_road] => 4.7
    [year] => 2011
    [color] => TUMESININE
)

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
{{--    <script src="{{ asset('public/js/app.js') }}" defer></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Parsley for validation -->
    <link href="https://parsleyjs.org/src/parsley.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.1/parsley.js" integrity="sha256-dO3UTzAcNQy98/PdAVM4VKpYVtxr/xIf4XRxjsm1BTQ=" crossorigin="anonymous"></script>
    @stack('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto" style="float: right">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown" >
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{url('my-profile')}}">
                                        My Profile
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
@stack('scripts')
</html>