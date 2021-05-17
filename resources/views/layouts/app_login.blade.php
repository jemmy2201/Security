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
        {{--  Scroll  --}}
        /* width */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        {{--  End Scroll  --}}
        body, html {
            height: 100%;
            margin: 0;
        }

        #app {
            /* The image used */
            background-image: url("img/login_background.png");

            /* Full height */
            height: 100%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body >
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light" >
            <div>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{URL::asset('/img/logo.png')}}">
                </a>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>


    </div>
    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start" style="border-style: groove; background: white; ">
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
