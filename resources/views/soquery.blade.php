@extends('layouts.app_so_query')
<style>
    .disabled{
        font-weight: normal;
    }
</style
@section('content')
{{--Dekstop--}}
<div class="hidden-xs">
    <div class="col-8">
        <h1><b>SECURITY OFFICER'S INFO</b></h1>
        <div class="row">
            <div class="col-4"style="text-align: left"><h2><b>NAME<span style="margin-left: 165px;">:</span></b></h2></div>
            <div class="col-6" style="color: white;"><h2>{{$soquery->Name}}</h2></div>
            <div class="w-100"></div>
{{--            @php--}}
{{--                $cutnric = substr($soquery->Nric, -4);--}}
{{--                $nric = "XXXXX$cutnric";--}}
{{--            @endphp--}}
{{--            <div class="col-4"style="text-align: left"><h2><b>NRIC/FIN<span style="margin-left: 125px;">:</span></b></h2></div>--}}
{{--            <div class="col-6" style="color: white;"><h2>{{$nric}}</h2></div>--}}
            <div class="w-100"></div>
            <div class="col-4"style="text-align: left"><h2><b>PASS ID<span style="margin-left: 137px;">:</span></b></h2></div>
            <div class="col-6" style="color: white;"><h2>{{$soquery->PassID}}</h2></div>
            <div class="w-100"></div>
            <div class="col-4"style="text-align: left"><h2><b>PWM GRADE<span style="margin-left: 65px;">:</span></b></h2></div>
            <div class="col-6" style="color: white;"><h2>{{$soquery->Grade}}</h2></div>
            <div class="w-100"></div>
            <div class="col-4"style="text-align: left"><h2><b>LICENSE EXPIRY<span style="margin-left: 7px;">:</span></b></h2></div>
            <div class="col-6" style="color: white;"><h2>{{date('m/d/Y ',strtotime($soquery->LicenseExpiryDate))}}</h2></div>
            <div class="w-100"></div>
        </div>
    </div>
    <div class="col-8">
        <h1><b>TRAINING COMPETENCY</b></h1>
        <div class="row">
            @if($soquery->TR_CCTC == "YES")
            <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_1.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
            <div class="col-8" style="color: white;margin-left: -145px;margin-top: 32px;">
                <h2>CCTC<br>
                    Conduct Crowd and Traffic Control</h2>
            </div>
            <div class="w-100"></div><br>
            @endif
            @if($soquery->TR_CSSPB == "YES")
            <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_2.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
            <div class="col-8" style="color: white;margin-left: -145px;margin-top: 32px;">
                <h2>CSS-P/B <br>
                    Conduct Security Screening of Person and Bag</h2>
            </div>
            <div class="w-100"></div>
            @endif

            @if($soquery->TR_X_RAY== "YES")
            <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_3.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
            <div class="col-8" style="color: white;margin-left: -145px;margin-top: 32px;">
                <h2>CSS-X<br>
                    Conduct Security Screening using X-ray Machine</h2>
            </div>
            <div class="w-100"></div>
            @endif

            @if($soquery->TR_HCTA == "YES")
            <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_4.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
            <div class="col-8" style="color: white;margin-left: -145px;margin-top: 32px;">
                <h2>HCTA<br>
                    Handle Counter Terrorism Activities</h2>
            </div>
            <div class="w-100"></div><br>
            @endif
            @if($soquery->TR_RTT == "YES")
            <div class="col-4"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_5.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
            <div class="col-8" style="color: white;margin-left: -145px;margin-top: 32px;">
                <h2>RTT<br>
                    Recognise Terrorist Threats</h2>
            </div>
            @endif
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-4"style="text-align: left"><h3><b>Date Of Updated Courses<span style="margin-left: 20px;">:</span></b></h3></div>
            <div class="col-4" style="color: white;margin-left: -123px;"><h3>{{date('d F Y ',strtotime($soquery->CreationDate))}}</h3></div>

            <div class="w-100"></div><br>
        </div>
    </div>
    <div class="col-8">
        <h1><b>SKILL SETS ACQUIRED</b></h1>
        <div class="row">
            @if($soquery->SKILL_BFM == "YES")
            <div class="col-6"style="text-align: left;color: white;" ><h2><b>Basic Facilities Management</b></h2></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_BSS == "YES")
            <div class="col-10"style="text-align: left;color: white;"><h2><b>Fundamentals of Building Services & Safety</b></h2></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_FSM == "YES")
            <div class="col-6"style="text-align: left;color: white;"><h2><b>Fire Safety Management</b></h2></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_CERT == "YES")
            <div class="col-6"style="text-align: left;color: white;"><h2><b>CERT</b></h2></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_COSEM == "YES")
            <div class="col-6"style="text-align: left;color: white;"><h2><b>COSEM</b></h2></div>
            <div class="w-100"></div>
            @endif
        </div>
    </div>
</div>
{{--End Dekstop--}}

{{--Phone--}}
<div class="visible-xs hidden-md">
    <div class="col-12">
        <h3><b>SECURITY OFFICER'S INFO</b></h3>
        <div class="row">
            <div class="col-6"style="text-align: left"><h4><b>NAME<span style="margin-left: 101px;">:</span></b></h4></div>
            <div class="col-6" style="color: white;"><h4>{{$soquery->Name}}</h4></div>
            <div class="w-100"></div>
{{--            @php--}}
{{--                $cutnric = substr($soquery->Nric, -4);--}}
{{--                $nric = "XXXXX$cutnric";--}}
{{--            @endphp--}}
{{--            <div class="col-12"style="text-align: left"><h2><b>NRIC/FIN<span style="margin-left: 125px;">:</span></b></h2></div>--}}
{{--            <div class="col-12" style="color: white;"><h2>{{$nric}}</h2></div>--}}
{{--            <div class="w-100"></div>--}}
            <div class="col-6"style="text-align: left"><h4><b>PASS ID<span style="margin-left: 84px;">:</span></b></h4></div>
            <div class="col-6" style="color: white;"><h4>{{$soquery->PassID}}</h4></div>
            <div class="w-100"></div>
            <div class="col-6"style="text-align: left"><h4><b>PWM GRADE<span style="margin-left: 41px;">:</span></b></h4></div>
            <div class="col-4" style="color: white;"><h4>{{$soquery->Grade}}</h4></div>
            <div class="w-100"></div>
            <div class="col-6"style="text-align: left"><h4><b>LICENSE EXPIRY<span style="margin-left: 7px;">:</span></b></h4></div>
            <div class="col-6" style="color: white;"><h4>{{date('m/d/Y ',strtotime($soquery->LicenseExpiryDate))}}</h4></div>
            <div class="w-100"></div>
        </div>
    </div>
    <div class="col-12">
        <h3><b>TRAINING COMPETENCY</b></h3>
        <div class="row">
            @if($soquery->TR_CCTC == "YES")
                <div class="col-6"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_1.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
                <div class="col-6" style="color: white;margin-left: -95px;">
                    <h4>CCTC<br>
                        Conduct Crowd and Traffic Control</h4>
                </div>
                <div class="w-100"></div><br>
            @endif
            @if($soquery->TR_CSSPB == "YES")
                <div class="col-6"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_2.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
                <div class="col-6" style="color: white;margin-left: -95px;">
                    <h4>CSS-P/B <br>
                        Conduct Security Screening of Person and Bag</h4>
                </div>
                <div class="w-100"></div>
            @endif

            @if($soquery->TR_X_RAY == "YES")
                <div class="col-6"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_3.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
                <div class="col-6" style="color: white;margin-left: -95px;">
                    <h4>CSS-X<br>
                        Conduct Security Screening using X-ray Machine</h4>
                </div>
                <div class="w-100"></div>
            @endif

            @if($soquery->TR_HCTA == "YESY")
                <div class="col-6"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_4.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
                <div class="col-6" style="margin-left: -95px;color: white;">
                    <h4>HCTA<br>
                        Handle Counter Terrorism Activities</h4>
                </div>
                <div class="w-100"></div><br>
            @endif
            @if($soquery->TR_RTT == "YES")
                <div class="col-6"style="text-align: left;"><img src="{{URL::asset('/img/logo/Logo_5.jpg')}}" style="width: 50%;"><span style="margin-left: 5px;"></span></div>
                <div class="col-6" style="margin-left: -95px;color: white;">
                    <h4>RTT<br>
                        Recognise Terrorist Threats</h4>
                </div>
            @endif
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-6"style="text-align: left"><h6><b>Date Of Updated Courses<span style="margin-left: 20px;">:</span></b></h6></div>
            <div class="col-6" style="color: white;"><h6>{{date('d F Y ',strtotime($soquery->CreationDate))}}</h6></div>
        </div>
    </div>
    <div class="col-12">
        <h3><b>SKILL SETS ACQUIRED</b></h3>
        <div class="row">
            @if($soquery->SKILL_BFM = "YES")
            <div class="col-12"style="text-align: left;color: white;" ><h4><b>Basic Facilities Management</b></h4></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_BSS = "YES")
            <div class="col-12"style="text-align: left;color: white;"><h4><b>Fundamentals of Building Services & Safety</b></h4></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_FSM = "YES")
            <div class="col-12"style="text-align: left;color: white;"><h4><b>Fire Safety Management</b></h4></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_CERT = "YES")
            <div class="col-12"style="text-align: left;color: white;"><h4><b>CERT</b></h4></div>
            <div class="w-100"></div>
            @endif
            @if($soquery->SKILL_COSEM = "YES")
            <div class="col-12"style="text-align: left;color: white;"><h4><b>COSEM</b></h4></div>
            <div class="w-100"></div>
            @endif
        </div>
    </div>
</div>
{{--End Phone--}}

@endsection
