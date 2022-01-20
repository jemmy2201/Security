@extends('layouts.app')

<style>
    .HeaderdataPersonal{
        color:#808080;
        font-size: 20px;
    }
    .ColoumndataPersonal{
        font-weight: bold;
        font-size: 20px;
    }
</style>
@section('content')
<div class="container submission">
{{--    <img class="hidden-xs" src="{{URL::asset('/img/img_step_proses/3.png')}}" style="width: 100%; margin-bottom: 20px;">--}}
{{--    <center class="visible-xs hidden-md">--}}
{{--        <img  src="{{URL::asset('/img/img_step_proses/design_phone/3.png')}}" style="width: 80%;">--}}
{{--    </center>--}}
    <h2 style="color: Black;"><b>Submission</b></h2>
    <br>
        {{-- Desktop --}}
    <h3 style="font-size: 20px;"><b>Details</b></h3>
    <form method="post" id="action_update_so" action="{{ route('action.update_so') }}" enctype="multipart/form-data">
        @csrf
        <div class="container">
            <div class="row hidden-xs">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                        @php
                            $cutnric = substr(secret_decode($personal->NRIC), -4);
                            $nric = "XXXXX$cutnric";
                        @endphp
                        <div class="col-4 ColoumndataPersonal">{{$nric}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        @if (strlen($personal->Name) > 40)
                            <div class="col-8 ColoumndataPersonal">
                                <textarea rows="4" cols="30" id="TextAreaName" style="resize: none;border: none;" readonly>
                                {{$personal->Name}}
                                </textarea>
                            </div>
                        @else
                            <div class="col-8 ColoumndataPersonal">{{$personal->Name}}</div>
                        @endif


                    </div>
                </div>
                <div class="col-sm-0">
                </div>
                <br class="visible-xs hidden-md">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">Pass ID No &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{substr($personal->PassID, 0, -2)}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;&nbsp;&nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$personal->Grade}}</div>
                    </div>
                </div>

            </div>
        <br>
        <div class="row">
        <h3 style="font-size: 20px;"><b>New Grade Attained</b></h3>
        </div>
        <div class="row">
            <ul class="list-group">
                @if($personal->New_Grade == Senior_Security_Officer)
                    <li class="list-group"><input class="form-check-input" name="New_Grade" type="checkbox" value="{{Senior_Security_Officer}}" checked>&ensp;&ensp; Senior Security Officer</li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" value="{{Senior_Security_Officer}}">&ensp;&ensp; Senior Security Officer</li>
                @endif
                @if($personal->New_Grade == Security_Supervisor)
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" value="{{Security_Supervisor}}" checked>&ensp;&ensp; Security Supervisor</li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" value="{{Security_Supervisor}}">&ensp;&ensp; Security Supervisor</li>
                @endif
                @if($personal->New_Grade == Senior_Security_Supervisor)
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" value="{{Senior_Security_Supervisor}}" checked>&ensp;&ensp; Senior Security Supervisor</li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" value="{{Senior_Security_Supervisor}}">&ensp;&ensp; Senior Security Supervisor</li>
                @endif
                @if($personal->New_Grade == Chief_Security_Officer)
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" value="{{Chief_Security_Officer}}" checked>&ensp;&ensp; Chief Security Officer</li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" value="{{Chief_Security_Officer}}">&ensp;&ensp; Chief Security Officer</li>
                @endif
            </ul>
        </div>
        <div class="row">
            <h3 style="font-size: 20px;"><b>New Training Records</b></h3>
        </div>
        <div class="row">
            <ul class="list-group">
                @if($personal->TR_RTT == "YES")
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_RTT"  checked>&ensp;&ensp; Recognise Terrorist Threat (RTT)</li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_RTT" >&ensp;&ensp; Recognise Terrorist Threat (RTT)</li>
                @endif
                @if($personal->TR_CSSPB == "YES")
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_CSSPB" checked>&ensp;&ensp; Conduct Security Screening of Person and Bag (CSSPB) </li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_CSSPB">&ensp;&ensp; Conduct Security Screening of Person and Bag (CSSPB) </li>
                @endif
                @if($personal->TR_CCTC == "YES")
                   <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_CCTC" checked>&ensp;&ensp; Conduct Crowd and Traffic Control (CCTC) </li>
                @else
                   <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_CCTC">&ensp;&ensp; Conduct Crowd and Traffic Control (CCTC) </li>
                @endif
                @if($personal->TR_HCTA == "YES")
                   <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_HCTA"  checked>&ensp;&ensp; Handle Counter Terrorist Activities (HCTA) </li>
                @else
                   <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_HCTA" >&ensp;&ensp; Handle Counter Terrorist Activities (HCTA) </li>
                @endif
                @if($personal->TR_X_RAY == "YES")
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_X_RAY"  checked>&ensp;&ensp; Conduct Screening using X-ray Machine (X-RAY) </li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_X_RAY"  >&ensp;&ensp; Conduct Screening using X-ray Machine (X-RAY) </li>
                @endif
            </ul>
        </div>
        <div class="row">
            <h3 style="font-size: 20px;"><b>Skill Sets Acquired</b></h3>
        </div>
        <div class="row">
            <ul class="list-group">
                @if($personal->SKILL_BFM == "YES")
                    <li class="list-group"><input class="form-check-input" name="SKILL_BFM" type="checkbox" checked>&ensp;&ensp; Basic Facilities Management</li>
                @else
                    <li class="list-group"><input class="form-check-input" name="SKILL_BFM" type="checkbox">&ensp;&ensp; Basic Facilities Management</li>
                @endif
                @if($personal->SKILL_BSS == "YES")
                    <li class="list-group"><input class="form-check-input" name="SKILL_BFM" type="checkbox" checked>&ensp;&ensp; Fundamentals of Building Services & Safety</li>
                @else
                    <li class="list-group"><input class="form-check-input" name="SKILL_BFM" type="checkbox">&ensp;&ensp; Fundamentals of Building Services & Safety</li>
                @endif
                @if($personal->SKILL_FSM == "YES")
                    <li class="list-group"><input class="form-check-input" name="SKILL_FSM" type="checkbox" checked>&ensp;&ensp; Fire Safety Management</li>
                @else
                    <li class="list-group"><input class="form-check-input" name="SKILL_FSM" type="checkbox">&ensp;&ensp; Fire Safety Management</li>
                @endif
                @if($personal->SKILL_FSM == "YES")
                    <li class="list-group"><input class="form-check-input" name="SKILL_CERT" type="checkbox" checked>&ensp;&ensp; CERT</li>
                @else
                    <li class="list-group"><input class="form-check-input" name="SKILL_CERT" type="checkbox">&ensp;&ensp; CERT</li>
                @endif
                @if($personal->SKILL_FSM == "YES")
                    <li class="list-group"><input class="form-check-input" name="SKILL_COSEM" type="checkbox" checked>&ensp;&ensp; COSEM</li>
                @else
                    <li class="list-group"><input class="form-check-input" name="SKILL_COSEM" type="checkbox">&ensp;&ensp; COSEM</li>
                @endif
            </ul>
        </div>
        <div class="row">
            <ul class="list-group">
                <li class="list-group"><input class="form-check-input" type="checkbox" name="declare">&ensp;&ensp; I declare the information is true</li>
            </ul>
        </div>
        <div class="row">
            Date of submission : {{date("d-m-Y")}}
        </div>
        <br>
        <div class="row" style="margin-left: -35px;">
            <div class="col-2">
                <a href="{{ url('landing_page') }}" style="text-decoration:none;">
                    <button type="button" class="btn btn-light btn-lg btn-block hidden-xs" style="border-style: groove; background: black; color: white" >
                        {{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;"> --}}
                        Back
                    </button>
                    <button type="button" class="btn btn-light btn-lg visible-xs hidden-md" style="border-style: groove; background: black; color: white" >
                        {{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;"> --}}
                        Back
                    </button>
                </a>
            </div>
            <div class="col-2">
            </div>
            <div class="col-2" id="update_so">
                    <button type="button" class="btn btn-light btn-lg btn-block hidden-xs" style="border-style: groove; background: black; color: white" >
                        Update
                    </button>
                    <button type="button" class="btn btn-light btn-lg visible-xs hidden-md" id="update_so" style="border-style: groove; background: black; color: white" >
                        Update
                    </button>
            </div>

        </div>
    </div>
    </form>
        {{-- End Desktop --}}


</div>

<script type="application/javascript">
    $( document ).ready(function() {
        $( "#update_so" ).click(function() {
            if ($("input[name='declare']:checked").val() != undefined) {
                $("#action_update_so").submit();
            }else{
                swal("Error!", " Please acknowledge declaration.", "error");
            }
        });
    });
</script>
@endsection
