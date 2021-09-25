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
    <script src="{{ asset('js/sha256.js') }}" defer></script>
    <script src="{{ asset('js/qrcode.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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

        .navbar-toggler {
            background: #E31E1A;
        }

        /* remove arrows/spinners input type number    */
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        /* End remove arrows/spinners input type number    */
    </style>
    {{-- for $(document).ready --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    {{-- End for $(document).ready --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    {{--Popup Alert--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{--End Popup Alert--}}
    {{--End Popup Alert--}}

</head>
<body >
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light  shadow-sm" style="background: #333333;">
            <div class="container">
                @if(isset($request->Status_App) && $request->Status_App == resubmission ||Request::route()->getName() == default_alter_login || isset($request->router_name) || $request->router_name == view_course)
                    <a  href="{{ url('/home') }}">
                        <img src="{{URL::asset('/img/logo.png')}}" style="width: 60%;">
                    </a>
                @else
                    <a  href="{{ url("/cancel/payment")."/".$request->app_type."/".$request->card }}">
                        <img src="{{URL::asset('/img/logo.png')}}" style="width: 60%;">
                    </a>
                @endif
                <a  class="nav-link visible-xs hidden-md"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >
                    <h5 style="cursor:pointer; color: #E31E1A;">Logout</h5>
                </a>
{{--                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">--}}
{{--                    <span class="navbar-toggler-icon"></span>--}}
{{--                </button>--}}

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto pull-right">
{{--                        <!-- Authentication Links -->--}}
{{--                        @guest--}}
                            <li class="nav-item">
{{--                                <a class="nav-link" href="{{ url('/home') }}"><h5 style="color: #E31E1A;">home</h5></a>--}}
                                    <input type="hidden" name="logout_save_draft" id="logout_save_draft" >
                                    @if(Request::route()->getName() == default_alter_login)
                                        <a class="nav-link"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><h5 style="cursor:pointer; color: #E31E1A;">Logout</h5></a>
                                    @else
                                        <a class="nav-link" href="#" ><h5 class="logout_save_draft" style="cursor:pointer; color: #E31E1A;">Logout</h5></a>
                                    @endif
                            </li>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            <?php if(config('adminlte.logout_method')): ?>
                            <?php echo e(method_field(config('adminlte.logout_method'))); ?>

                             <?php endif; ?>
                             <?php echo e(csrf_field()); ?>

                        </form>
{{--                        @else--}}
{{--                            <li class="nav-item dropdown">--}}
{{--                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--                                    <p style="color: #E31E1A;">home</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endguest--}}
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script type="application/javascript">
        $( document ).ready(function() {

            var TextAreaName = document.getElementById('TextAreaName');
            TextAreaName.value = TextAreaName.value.replace(/^\s*|\s*$/g,'');

            var TextAreaNamePhone = document.getElementById('TextAreaNamePhone');
            TextAreaNamePhone.value = TextAreaNamePhone.value.replace(/^\s*|\s*$/g,'');

        });

    </script>
</body>
</html>
