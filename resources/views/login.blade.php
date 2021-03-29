@extends('layouts.app_login')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 hidden-xs" style="margin-top: 150px;margin-left: 150px;">
                        <h1><b>Welcome to Union of </b></h1>
                        <h1><b>Security Employees</b></h1>
                    </div>
                    <div class="col-sm-6 visible-xs hidden-md">
                        <h1><b>Welcome to Union of </b></h1>
                        <h1><b>Security Employees</b></h1>
                    </div>
                    <div class="col-sm-4" style="border-style: groove; background: white">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#scan">Singpass app</a></li>
                            <li><a data-toggle="tab" href="#passlogin">Password login</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="scan" class="tab-pane fade in active">
                                <center>
                                    <h3><b>Scan with Singpass app</b></h3>
                                <h4>to log in</h4>
                                </center>
                                <img src="{{URL::asset('/img/barcode_singpass.png')}}" style="width: 99%;">
                                <center>
                                <p>Don't have Singapass app?<a href="https://app.singpass.gov.sg/" target="_blank">Download now</a></p>
                                </center>
                            </div>
                            <div id="passlogin" class="tab-pane fade">
                                <h3>Log in</h3>
                                <form  method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <input type="hidden" id="type_login" name="type_login" value="@php echo non_barcode @endphp">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="singpass_id" id="singpass_id" aria-describedby="emailHelp" placeholder="SingPass ID">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="paLog inssword" name="password" placeholder="Password">
                                    </div>
                                    <button type="submit" class=" btn btn-danger btn-lg btn-block ">Log in</button>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <a href="https://www.singpass.gov.sg/singpass/retrieveaccount/retrievesingpassid" target="_blank">Forgot Singpass ID</a>
                                        </div>
                                        <div class="col" style="margin-left: 74px;">
                                            <a href="https://www.singpass.gov.sg/singpass/onlineresetpassword/userdetail"target="_blank">Reset Password</a>
                                        </div>
                                    </div>
                                    <hr>
                                    <center>
                                    <h4 style="border-style: groove;padding: 10px"><a style="color: #808080;text-decoration: none;" href="https://www.singpass.gov.sg/singpass/register/instructions" target="_blank">Register for Singpass</a></h4>
                                    </center>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
