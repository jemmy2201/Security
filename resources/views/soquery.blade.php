@extends('layouts.app_so_query')
<style>
    .disabled{
        font-weight: normal;
    }
</style
@section('content')
{{--Dekstop--}}
<div class="hidden-xs" style="font-family: futura-lt-w01-book,sans-serif">
    <div class="col-8">
        <h1 style="color: white;"><b>SECURITY OFFICER'S INFO</b></h1>
        <div class="row">
            <div class="col-4"style="color: white; text-align: left"><h2><b>NAME<span style="margin-left: 165px;">:</span></b></h2></div>
            <div class="col-6" style="color: white;"><h2>{{$soquery->Name}}</h2></div>
            <div class="w-100"></div>
{{--            @php--}}
{{--                $cutnric = substr($soquery->Nric, -4);--}}
{{--                $nric = "XXXXX$cutnric";--}}
{{--            @endphp--}}
{{--            <div class="col-4"style="text-align: left"><h2><b>NRIC/FIN<span style="margin-left: 125px;">:</span></b></h2></div>--}}
{{--            <div class="col-6" style="color: white;"><h2>{{$nric}}</h2></div>--}}
            <div class="w-100"></div>
            <div class="col-4"style="color: white; text-align: left"><h2><b>PASS ID<span style="margin-left: 137px;">:</span></b></h2></div>
            <div class="col-6" style="color: white;"><h2>{{$soquery->PassID}}</h2></div>
            <div class="w-100"></div>
            <div class="col-4"style="color: white; text-align: left"><h2><b>NRIC / FIN<span style="margin-left: 109px;">:</span></b></h2></div>
            @php
                $cutnric = substr(secret_decode($soquery->nric), -4);
                $nric = "XXXXX$cutnric";
            @endphp
            <div class="col-6" style="color: white;"><h2>{{$nric}}</h2></div>
            <div class="w-100"></div>
            <div class="col-4"style="color: white; text-align: left"><h2><b>PWM GRADE<span style="margin-left: 65px;">:</span></b></h2></div>
            <div class="col-6" style="color: white;"><h2>{{$soquery->Grade}}</h2></div>
            <div class="w-100"></div>
            <div class="col-4"style="color: white;text-align: left"><h2><b>LICENSE EXPIRY<span style="margin-left: 7px;">:</span></b></h2></div>
            <div class="col-6" style="color: white;"><h2>{{date('m/d/Y ',strtotime($soquery->LicenseExpiryDate))}}</h2></div>
            <div class="w-100"></div>
        </div>
    </div>
    <div class="col-8">
        <div class="row" style="background-color: white; display: flex;
  justify-content: center; /* horizontal */
  align-items: center; ">
        <h1><b>TRAINING COMPETENCY</b></h1>
        </div>
        <br>
        <div class="row">
            @if($soquery->TR_CCTC == "YES")
            <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_1.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
            <div class="col-8" style="color: white;margin-left: -145px;">
                <h2>CCTC<br>
                    Conduct Crowd and Traffic Control</h2>
            </div>
            <div class="w-100"></div><br>
            @endif
            @if($soquery->TR_CSSPB == "YES")
            <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_2.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
            <div class="col-8" style="color: white;margin-left: -145px;margin-bottom: 25px;">
                <h2>CSS-P/B <br>
                    Conduct Security Screening of Person and Bag</h2>
            </div>
            <div class="w-100"></div>
            @endif

            @if($soquery->TR_X_RAY== "YES")
            <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_3.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
            <div class="col-8" style="color: white;margin-left: -145px;margin-bottom: 25px;">
                <h2>CSS-X<br>
                    Conduct Security Screening using X-ray Machine</h2>
            </div>
            <div class="w-100"></div>
            @endif

            @if($soquery->TR_HCTA == "YES")
            <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_4.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
            <div class="col-8" style="color: white;margin-left: -145px;margin-bottom: 25px;">
                <h2>HCTA<br>
                    Handle Counter Terrorism Activities</h2>
            </div>
            <div class="w-100"></div><br>
            @endif
            @if($soquery->TR_RTT == "YES")
            <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_5.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
            <div class="col-8" style="color: white;margin-left: -145px;margin-bottom: 25px;">
                <h2>RTT<br>
                    Recognise Terrorist Threats</h2>
            </div>
            @endif
        </div>
    </div>
    <br>
    <div class="col-8">
        <div class="col-8">
            <div class="row" style="background-color: white; display: flex;
  justify-content: center; /* horizontal */
  align-items: center; ">
        <h1><b>SKILL SETS ACQUIRED</b></h1>
            </div>
        <div class="row">
            @if($soquery->SKILL_BFM == "YES")
            <div class="col-12"style="text-align: left;color: white;" ><h2><b>Basic Facilities Management</b></h2></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_BSS == "YES")
            <div class="col-12"style="text-align: left;color: white;"><h2><b>Fundamentals of Building Services & Safety</b></h2></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_FSM == "YES")
            <div class="col-12"style="text-align: left;color: white;"><h2><b>Fire Safety Management</b></h2></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_CERT == "YES")
            <div class="col-12"style="text-align: left;color: white;"><h2><b>CERT</b></h2></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_COSEM == "YES")
            <div class="col-12"style="text-align: left;color: white;"><h2><b>COSEM</b></h2></div>
            <div class="w-100"></div>
            @endif
            <br>
            <div class="col-6"style="text-align: left;color: white;"><h4><b>Information Updated As Of<span style="margin-left: 20px;">:</span></b></h4></div>
            <div class="col-4" style="color: white;"><h4>{{date('d F Y ',strtotime($soquery->CreationDate))}}</h4></div>
            <div class="w-100"></div>
        </div>
    </div>
</div>
</div>
    {{--End Dekstop--}}

{{--Phone--}}
<div class="visible-xs hidden-md" style="font-family: futura-lt-w01-book,sans-serif">
    <div class="col-12">
        <h3 style="color: white;"><b>SECURITY OFFICER'S INFO</b></h3>
        <div class="row">
            <div class="col-6"style="color: white;text-align: left"><h5>NAME<span style="margin-left: 81px;">:</span></h5></div>
            <div class="col-6" style="color: white;margin-left: -60px;"><h5>{{$soquery->Name}}</h5></div>
            <div class="w-100"></div>
            <div class="col-6"style="color: white;text-align: left"><h5>NRIC / FIN<span style="margin-left: 61px;">:</span></h5></div>
            <div class="col-6" style="color: white;margin-left: -60px;"><h5>{{$nric}}</h5></div>
            <div class="w-100"></div>
            <div class="col-6"style="color: white;text-align: left"><h5>PASS ID<span style="margin-left: 68px;">:</span></h5></div>
            <div class="col-6" style="color: white;margin-left: -60px;"><h5>{{$soquery->PassID}}</h5></div>
            <div class="w-100"></div>
            <div class="col-6"style="color: white;text-align: left"><h5>PWM GRADE<span style="margin-left: 34px;">:</span></h5></div>
            <div class="col-4" style="color: white;margin-left: -60px;"><h5>{{$soquery->Grade}}</h5></div>
            <div class="w-100"></div>
            <div class="col-6"style="color: white;text-align: left"><h5>LICENSE EXPIRY<span style="margin-left: 7px;">:</span></h5></div>
            <div class="col-6" style="color: white;margin-left: -60px;"><h5>{{date('m/d/Y ',strtotime($soquery->LicenseExpiryDate))}}</h5></div>
            <div class="w-100"></div>
        </div>
    </div>
    <div class="col-12">
        <div class="row" style="background-color: #C7C7C7; display: flex;
  justify-content: center; /* horizontal */
  align-items: center; ">
        <h3><b>TRAINING COMPETENCY</b></h3>
        </div>
        <br>
        <div class="row">
            @if($soquery->TR_CCTC == "YES")
                <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_1.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
                <div class="col-10" style="color: white;margin-top: -6px;margin-left: -67px;">
                    <h6>CCTC<br>
                        Conduct Crowd and Traffic Control</h6>
                </div>
                <div class="w-100"></div><br>
            @endif
            @if($soquery->TR_CSSPB == "YES")
                <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_2.jpg')}}" style="margin-bottom: 18px;width: 50%;"><span style="margin-left: 5px;"></span></div>
                <div class="col-10" style="color: white;margin-top: -6px;margin-left: -67px;">
                    <h6>CSS-P/B <br>
                        Conduct Security Screening of Person and Bag</h6>
                </div>
                <div class="w-100"></div>
            @endif

            @if($soquery->TR_X_RAY == "YES")
                <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_3.jpg')}}" style="width: 50%;margin-bottom: 18px;"><span style="margin-left: 5px;"></span></div>
                <div class="col-10" style="color: white;margin-top: -6px;margin-left: -67px;">
                    <h6>CSS-X<br>
                        Conduct Security Screening using X-ray Machine</h6>
                </div>
                    <div class="w-100"></div>
            @endif

            @if($soquery->TR_HCTA == "YES")
                <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_4.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
                <div class="col-10" style="margin-top: -6px;margin-left: -67px;color: white;">
                    <h6>HCTA<br>
                        Handle Counter Terrorism Activities</h6>
                </div>
                <div class="w-100"></div><br>
            @endif
            @if($soquery->TR_RTT == "YES")
                <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_5.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
                <div class="col-10" style="margin-top: -6px;margin-left: -67px;color: white;">
                    <h6>RTT<br>
                        Recognise Terrorist Threats</h6>
                </div>
            @endif
        </div>
    </div>
{{--    <div class="col-12">--}}
{{--        <div class="row">--}}
{{--            <div class="col-6"style="text-align: left"><h6><b>Date Of Updated Courses<span style="margin-left: 20px;">:</span></b></h6></div>--}}
{{--            <div class="col-6" style="color: white;"><h6>{{date('d F Y ',strtotime($soquery->CreationDate))}}</h6></div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <br>
    <div class="col-12">
        <div class="row" style="background-color: #C7C7C7; display: flex;
  justify-content: center; /* horizontal */
  align-items: center; ">
                <h3>
                    <center>
                    <b>SKILL SETS ACQUIRED</b>
                    </center>
                </h3>
        </div>
        <div class="row">
            @if($soquery->SKILL_BFM = "YES")
            <div class="col-12"style="text-align: left;color: white;" ><h5><b>Basic Facilities Management</b></h5></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_BSS = "YES")
            <div class="col-12"style="text-align: left;color: white;"><h5><b>Fundamentals of Building Services & Safety</b></h5></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_FSM = "YES")
            <div class="col-12"style="text-align: left;color: white;"><h5><b>Fire Safety Management</b></h5></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_CERT = "YES")
            <div class="col-12"style="text-align: left;color: white;"><h5><b>CERT</b></h5></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_COSEM = "YES")
            <div class="col-12"style="text-align: left;color: white;"><h5><b>COSEM</b></h5></div>
            <div class="w-100"></div>
            @endif
            <div class="col-6"style="color: white;text-align: left"><h6><b>Date Of Updated Courses<span style="margin-left: 20px;">:</span></b></h6></div>
            <div class="col-6" style="color: white;margin-left: -22px;"><h6>{{date('d F Y ',strtotime($soquery->CreationDate))}}</h6></div>
            <div class="w-100"></div>
        </div>
    </div>
</div>
{{--End Phone--}}

@endsection
