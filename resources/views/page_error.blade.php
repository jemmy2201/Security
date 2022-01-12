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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body >
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light  shadow-sm" style="background: #333333;">
        <div class="container">
                    <img src="{{URL::asset('/img/logo.png')}}" style="width: 25%;">

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
                        <i class="fa fa-phone" style="color: white;font-size: 12px;" aria-hidden="true">&nbsp;&nbsp;+65 6381 9150 (General Office) &nbsp;&nbsp; +65 6291 5145 (CSC) </i><br>
                        <i class="fa fa-envelope" style="color: white;font-size: 12px;" aria-hidden="true">&nbsp;&nbsp;use-idcard@ntuc.org.sg</i>
                    </li>
                    <li class="nav-item" style="margin-right: 240px;">
                        {{--                                <a class="nav-link" href="{{ url('/home') }}"><h5 style="color: #E31E1A;">home</h5></a>--}}
                        <input type="hidden" name="logout_save_draft" id="logout_save_draft" >
{{--                        <a  class="nav-link "  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >--}}
{{--                            --}}{{--                <h5 style="cursor:pointer; color: #E31E1A;">Logout</h5>--}}
{{--                            <i class="fa fa-sign-out" aria-hidden="true" style="font-size:24px;color: red;cursor: pointer;"></i>--}}
{{--                        </a>--}}
{{--                        @if(Request::route()->getName() == default_alter_login)--}}
{{--                            <a class="nav-link"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><h5 style="cursor:pointer; color: #E31E1A;">Logout</h5></a>--}}
{{--                        @else--}}
{{--                            <a class="nav-link" href="#" ><h5 class="logout_save_draft" style="cursor:pointer; color: #E31E1A;">Logout</h5></a>--}}
{{--                        @endif--}}
                    </li>


                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        <?php if(config('adminlte.logout_method')): ?>
                <?php echo e(method_field(config('adminlte.logout_method'))); ?>

                 <?php endif; ?>
                        <?php echo e(csrf_field()); ?>

                    </form>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container" style="margin-top: 100px;">
{{--            <div class="row-12">--}}
            <center>
                <h4>
                    <i class="fa fa-info-circle fa-2x" aria-hidden="true"></i>&nbsp;
                    <B>{{$data}}</B>
                </h4>
                <a href="/">
                    <button type="button" class="btn btn-dark" style="color: white;">
                        OK
                    </button>
                </a>
            </center>
{{--            </div>--}}
        </div>
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
