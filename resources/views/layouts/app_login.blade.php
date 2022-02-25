<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>

        body, html {
            height: 100%;
            margin: 0;
            background-color: #818286;
        }

        #app {
            /* The image used */
            /*background-image: url("img/login_background.jpg");*/

            /* Full height */

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .navbar{
            margin-bottom: 0px;
            border-radius: 0px;
        }
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link src="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

</head>
<body onload="init()">
{{--<nav class="navbar navbar-dark bg-dark">--}}
{{--    <div>--}}
{{--        <a class="navbar-brand hidden-xs" href="{{ url('/') }}">--}}
{{--            <img src="{{URL::asset('/img/logo.png')}}" style="width: 50%; margin-left: -100%; margin-top: -3%;">--}}
{{--        </a>--}}
{{--        <a class="navbar-brand visible-xs hidden-md" href="{{ url('/') }}">--}}
{{--            <img src="{{URL::asset('/img/logo.png')}}" style="width: 50%;margin-top: -3%;">--}}
{{--        </a>--}}
{{--    <ul class="navbar-nav ml-auto pull-right">--}}
{{--        <li class="nav-item">--}}
{{--            <i class="fa fa-email" style="color: white;font-size: 12px;" aria-hidden="true">+65 6381 9150 (General Office)</i><br>--}}
{{--            <i class="fa fa-email" style="color: white;font-size: 12px;" aria-hidden="true">use-idcard@ntNuc.org.sg</i>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--    </div>--}}

{{--</nav>--}}
<nav class="navbar navbar-expand-md navbar-light  shadow-sm" style="background: #333333;">
    <div class="container">
                <a class="navbar-brand hidden-xs" href="{{ url('/') }}">
                    <img src="{{URL::asset('/img/logo.png')}}" style="width: 80%;  margin-top: -6%;">
                </a>
                <a class="navbar-brand visible-xs hidden-md" href="{{ url('/') }}">
                    <img src="{{URL::asset('/img/logo.png')}}" style="width: 85%;margin-top: -6%;">
                </a>
{{--        <a  class="nav-link visible-xs hidden-md"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >--}}
{{--            <h5 style="cursor:pointer; color: #E31E1A;">Logout</h5>--}}
{{--        </a>--}}
        {{--                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">--}}
        {{--                    <span class="navbar-toggler-icon"></span>--}}
        {{--                </button>--}}

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto pull-right" style="margin-right: -94px;">
                <li class="nav-item">
                    <i class="fa fa-phone" style="color: white;font-size: 12px;" aria-hidden="true">&nbsp;&nbsp;+65 6381 9150 (General Office) &nbsp;&nbsp; +65 6291 5145 (CSC) </i><br>
                    <i class="fa fa-envelope" style="color: white;font-size: 12px;" aria-hidden="true">&nbsp;&nbsp;use-idcard@ntuc.org.sg</i>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div id="app">
{{--        <nav class="navbar navbar-expand-md navbar-light" >--}}
{{--            <div>--}}
{{--                <a class="navbar-brand" href="{{ url('/') }}">--}}
{{--                    <img src="{{URL::asset('/img/logo.png')}}">--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </nav>--}}
        <main class="py-4">
            @yield('content')

        </main>

    </div>
<!-- Footer -->
            <footer class="footer bg-light text-center text-lg-start" style="border-style: groove; background: white; ">
                <!-- Copyright -->
                <div class="text-center p-3" style="background-color: #FFFFFF">
                    Copyright © @php echo date("Y")@endphp
                    <a class="text-dark" href="https://mdbootstrap.com/">Union of Security Employees. All rights reserved.</a>
                </div>
                <!-- Copyright -->
            </footer>
<!-- Footer -->
</body>
</html>
