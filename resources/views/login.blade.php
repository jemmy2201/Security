@extends('layouts.app_login')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="container">
{{--                <img src="{{URL::asset('/img/logo3.jpg')}}" class="hidden-xs" >--}}
{{--                <img src="{{URL::asset('/img/logo3.jpg')}}" class="visible-xs hidden-md" style="width: 100%;" >--}}
                <div class="row">
{{--                    <div class="col-sm-6 hidden-xs" style="margin-top: 150px;margin-left: 150px;">--}}
{{--                        <h1><b>Welcome to Union of </b></h1>--}}
{{--                        <h1><b>Security Employees</b></h1>--}}
{{--                        <img src="{{URL::asset('/img/logo3.png')}}" style="width: 60%;">--}}

{{--                    </div>--}}
{{--                    <div class="col-sm-6 visible-xs hidden-md">--}}
{{--                        <h1><b>Welcome to Union of </b></h1>--}}
{{--                        <h1><b>Security Employees</b></h1>--}}
{{--                        <br>--}}
{{--                        <center>--}}
{{--                        <img src="{{URL::asset('/img/logo3.png')}}" style="width: 60%;">--}}
{{--                        </center>--}}
{{--                        <br>--}}
{{--                    </div>--}}
{{--                    <div class="col-sm-2"></div>--}}
                    <div class="col-sm-4"  style="border-style: groove; background: white; margin-top: 40px;">

                        <ul class="nav nav-tabs">
                            @if(detect_url() == URLUat || detect_url() == LocalHost)
                                <li class="active"><a data-toggle="tab" href="#scan">Singpass app</a></li>
                                <li><a data-toggle="tab" href="#passlogin">Password login</a></li>
                            @endif
                        </ul>

                        <div class="tab-content">
                            <div id="passlogin" class="tab-pane fade ">
                                <h3>Log in</h3>
                                <form  method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <input type="hidden" id="type_login" name="type_login" value="@php echo non_barcode @endphp">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="singpass_id" id="singpass_id" aria-describedby="emailHelp" placeholder="Login">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="paLog inssword" name="password" placeholder="Password">
                                    </div>
                                    @if(!empty($type_dummy))
                                        <input type="hidden" class="form-control" name="dummy_login" id="dummy_login" value="@php echo dummy @endphp">
                                    @endif
                                    @if($errors->has('email'))
                                        <strong>Singpass ID and Password do not match</strong>
                                    @endif
                                    <button type="submit" class=" btn btn-danger btn-lg btn-block ">Log in</button>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            {{--                                            <a href="https://www.singpass.gov.sg/singpass/retrieveaccount/retrievesingpassid" target="_blank">Forgot Singpass ID</a>--}}
                                        </div>
                                        <div class="col" style="margin-left: 74px;">
                                            {{--                                            <a href="https://www.singpass.gov.sg/singpass/onlineresetpassword/userdetail"target="_blank">Reset Password</a>--}}
                                        </div>
                                    </div>
                                    <hr>
                                    <center>
                                        {{--                                    <h4 style="border-style: groove;padding: 10px"><a style="color: #808080;text-decoration: none;" href="https://www.singpass.gov.sg/singpass/register/instructions" target="_blank">Register for Singpass</a></h4>--}}
                                    </center>
                                    <br>
                                </form>
                            </div>
                            <div id="scan" class="tab-pane fade in active">
                                <center>
                                    {{--                                    <h3><b>Scan with Singpass app</b></h3>--}}
                                    {{--                                    <h4>to log in</h4>--}}
                                </center>
                                {{--                                <img src="{{URL::asset('/img/barcode_singpass.png')}}" style="width: 99%;">--}}
                                <div id="ndi-qr"></div>
                                <center>
                                    {{--                                    <p>Don't have Singapass app?<a href="https://app.singpass.gov.sg/" target="_blank">Download now</a></p>--}}
                                    @if(isset($type_dummy) && $type_dummy == dummy)
                                        {{--                                    <p><a href="{{url("/login/dummy")."/".dummy}}" >Login bypass singpass</a></p>--}}
                                    @else
                                        {{--                                        <p><a href="{{url("/login/dummy")."/".dummy}}" >Login without singpass</a></p>--}}
                                    @endif
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4"  >

                    </div>
                    <div class="col-sm-4"  >
                         <img src="{{URL::asset('/img/logo2.png')}}" class="hidden-xs" style="width: 60%;margin-top: 80px;" >
                    </div>

                </div>
            </div>
        </div>
    </div>
    @php
        if (detect_url() == URLUat){
               echo '<script src="https://stg-id.singpass.gov.sg/static/ndi_embedded_auth.js"></script>';
        }elseif (detect_url() == URLProd){
              echo '<script src="https://id.singpass.gov.sg/static/ndi_embedded_auth.js"></script>';
        }
    @endphp
    <script>
        // Barcode
        async function init() {
            const authParamsSupplier = async () => {
                // Replace the below with an `await`ed call to initiate an auth session on your backend
                // which will generate state+nonce values, e.g
                return { state: "dummySessionState", nonce: "dummySessionNonce" };
            };

            const onError = (errorId, message) => {
                console.log(`onError. errorId:${errorId} message:${message}`);
            };

            if ({!!  json_encode(detect_url()) !!} == {!!  json_encode(URLUat) !!}){
                var clientIdSinpass = {!!  json_encode(clientIdSinpassUat) !!}
                var redirectUrlSingpass = {!!  json_encode(redirectUrlSingpassUat) !!}
            }else if({!!  json_encode(detect_url()) !!} == {!!  json_encode(URLProd) !!}){
                var clientIdSinpass = {!!  json_encode(clientIdSinpassProd) !!}
                var redirectUrlSingpass = {!!  json_encode(redirectUrlSingpassProd) !!}

            }
            const initAuthSessionResponse = window.NDI.initAuthSession(
                'ndi-qr',
                {
                    clientId: clientIdSinpass, // Replace with your client ID
                    redirectUri: redirectUrlSingpass,        // Replace with a registered redirect URI
                    scope: 'openid',
                    responseType: 'code'
                },
                authParamsSupplier,
                onError,
                { renderDownloadLink: true }
            );

            console.log('initAuthSession: ', initAuthSessionResponse);
        }
        // End Barcode
    </script>
    <script type="application/javascript">
        $( document ).ready(function() {
            if (document.location.pathname.indexOf({!!  json_encode(login_dummy) !!}) == 0) {
                var imageUrl ="/img/login_background.jpg";
                $("#app").css("background-image", "url(" + imageUrl + ")");
            }else if(!document.location.pathname.indexOf({!!  json_encode(cek_pathname) !!}) == 0 ){
                window.location.href = '/qrcode';
            }
        });

    </script>

@endsection
