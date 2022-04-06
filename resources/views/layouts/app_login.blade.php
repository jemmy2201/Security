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
    {{--Popup Alert--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{--End Popup Alert--}}

    {{--Fa fa--}}
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    {{--End Fa fa--}}
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
                    <i class="fa fa-phone" style="color: white;font-size: 12px;" aria-hidden="true">&nbsp;&nbsp;{{phone_general_office}} &nbsp;&nbsp; {{phone_CSC}} </i><br>
                    <i class="fa fa-envelope" style="color: white;font-size: 12px;" aria-hidden="true">&nbsp;&nbsp;{{email}}</i>
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
        <div class="container" >
            <div class="row">
            <div class="col-4">
            </div>
            <div class="col-4">
            </div>
            <div class="col-4" >
{{--                            <div class="row">--}}
{{--                                <div class="col-sm-6">--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-6" style="--}}
{{--  justify-content: center;--}}
{{--  align-items: center;cursor: pointer;border: 1px solid grey ">--}}
{{--                @if($_SERVER['SERVER_NAME'] == "127.0.0.1")--}}
{{--                    <div style="margin-left:160px;cursor: pointer;border: 1px solid grey ">--}}
{{--                        @else--}}
{{--                            <div style="margin-left:142px;cursor: pointer;border: 1px solid grey ">--}}
{{--                                @endif--}}
                                <h4 style="font-weight: bold;margin-left: 145px;" class="hidden-xs">User Guide</h4>
                                <h4 style="font-weight: bold;margin-left: 145px;position: fixed;" class="hidden-xs">Frequently Asked Questions</h4>
                                <h4 style="font-weight: bold;" class="visible-xs hidden-md">User Guide</h4>
                                <h4 style="font-weight: bold;" class="visible-xs hidden-md">Frequently Asked Questions</h4>
{{--                                </div>--}}
{{--                            </div>--}}
            </div>
                    {{--                        <h2 style="text-align: center;width:85px;color: white;border: 1px solid white;font-family:neue;">FAQs</h2>--}}
                    {{--                        <img src="{{URL::asset('/img/faqs.png')}}" style="width: 75px;">--}}
            </div>

        </div>
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
