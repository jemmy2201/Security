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
        <input type="text" name="PassID" value="{{$personal->PassID}}" style="display: none">
        <div class="container">
            <div class="row hidden-xs">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                        @php
                           // $cutnric = substr(secret_decode($personal->NRIC), -4);
                           // $nric = "XXXXX$cutnric";
                            $nric = $personal->NRIC;
                        @endphp
                        <div class="col-4 ColoumndataPersonal">{{$nric}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">update_so &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
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
                    <li class="list-group"><input class="form-check-input" name="New_Grade" type="checkbox" id="{{Senior_Security_Officer}}" value="{{Senior_Security_Officer}}" checked>&ensp;&ensp; Senior Security Officer</li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" id="{{Senior_Security_Officer}}" value="{{Senior_Security_Officer}}">&ensp;&ensp; Senior Security Officer</li>
                @endif
                @if($personal->New_Grade == Security_Supervisor)
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" id="{{Security_Supervisor}}" value="{{Security_Supervisor}}" checked>&ensp;&ensp; Security Supervisor</li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" id="{{Security_Supervisor}}" value="{{Security_Supervisor}}">&ensp;&ensp; Security Supervisor</li>
                @endif
                @if($personal->New_Grade == Senior_Security_Supervisor)
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" id="{{Senior_Security_Supervisor}}" value="{{Senior_Security_Supervisor}}" checked>&ensp;&ensp; Senior Security Supervisor</li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" id="{{Senior_Security_Supervisor}}" value="{{Senior_Security_Supervisor}}">&ensp;&ensp; Senior Security Supervisor</li>
                @endif
                @if($personal->New_Grade == Chief_Security_Officer)
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" id="{{Chief_Security_Officer}}" value="{{Chief_Security_Officer}}" checked>&ensp;&ensp; Chief Security Officer</li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="New_Grade" id="{{Chief_Security_Officer}}" value="{{Chief_Security_Officer}}">&ensp;&ensp; Chief Security Officer</li>
                @endif
            </ul>
        </div>
        <div class="row">
            <h3 style="font-size: 20px;"><b>New Training Records</b></h3>
        </div>
        <div class="row">
            <ul class="list-group">
                @if($personal->TR_RTT == "YES")
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_RTT" id="TR_RTT" checked>&ensp;&ensp; Recognise Terrorist Threat (RTT)</li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_RTT" id="TR_RTT">&ensp;&ensp; Recognise Terrorist Threat (RTT)</li>
                @endif
                @if($personal->TR_CSSPB == "YES")
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_CSSPB" id="TR_CSSPB" checked>&ensp;&ensp; Conduct Security Screening of Person and Bag (CSSPB) </li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_CSSPB" id="TR_CSSPB">&ensp;&ensp; Conduct Security Screening of Person and Bag (CSSPB) </li>
                @endif
                @if($personal->TR_CCTC == "YES")
                   <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_CCTC" id="TR_CCTC" checked>&ensp;&ensp; Conduct Crowd and Traffic Control (CCTC) </li>
                @else
                   <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_CCTC" id="TR_CCTC">&ensp;&ensp; Conduct Crowd and Traffic Control (CCTC) </li>
                @endif
                @if($personal->TR_HCTA == "YES")
                   <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_HCTA" id="TR_HCTA"  checked>&ensp;&ensp; Handle Counter Terrorist Activities (HCTA) </li>
                @else
                   <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_HCTA" id="TR_HCTA" >&ensp;&ensp; Handle Counter Terrorist Activities (HCTA) </li>
                @endif
                @if($personal->TR_X_RAY == "YES")
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_X_RAY" id="TR_X_RAY"  checked>&ensp;&ensp; Conduct Screening using X-ray Machine (X-RAY) </li>
                @else
                    <li class="list-group"><input class="form-check-input" type="checkbox" name="TR_X_RAY" id="TR_X_RAY"  >&ensp;&ensp; Conduct Screening using X-ray Machine (X-RAY) </li>
                @endif
            </ul>
        </div>
        <div class="row">
            <h3 style="font-size: 20px;"><b>Skill Sets Acquired</b></h3>
        </div>
        <div class="row">
            <ul class="list-group">
                @if($personal->SKILL_BFM == "YES")
                    <li class="list-group"><input class="form-check-input" name="SKILL_BFM" id="SKILL_BFM" type="checkbox" checked>&ensp;&ensp; Basic Facilities Management</li>
                @else
                    <li class="list-group"><input class="form-check-input" name="SKILL_BFM" id="SKILL_BFM" type="checkbox">&ensp;&ensp; Basic Facilities Management</li>
                @endif
                @if($personal->SKILL_BSS == "YES")
                    <li class="list-group"><input class="form-check-input" name="SKILL_BSS" id="SKILL_BSS" type="checkbox" checked>&ensp;&ensp; Fundamentals of Building Services & Safety</li>
                @else
                    <li class="list-group"><input class="form-check-input" name="SKILL_BSS" id="SKILL_BSS" type="checkbox">&ensp;&ensp; Fundamentals of Building Services & Safety</li>
                @endif
                @if($personal->SKILL_FSM == "YES")
                    <li class="list-group"><input class="form-check-input" name="SKILL_FSM" id="SKILL_FSM" type="checkbox" checked>&ensp;&ensp; Fire Safety Management</li>
                @else
                    <li class="list-group"><input class="form-check-input" name="SKILL_FSM" id="SKILL_FSM" type="checkbox">&ensp;&ensp; Fire Safety Management</li>
                @endif
                @if($personal->SKILL_CERT == "YES")
                    <li class="list-group"><input class="form-check-input" name="SKILL_CERT" id="SKILL_CERT" type="checkbox" checked>&ensp;&ensp; CERT</li>
                @else
                    <li class="list-group"><input class="form-check-input" name="SKILL_CERT" id="SKILL_CERT" type="checkbox">&ensp;&ensp; CERT</li>
                @endif
                @if($personal->SKILL_COSEM == "YES")
                    <li class="list-group"><input class="form-check-input" name="SKILL_COSEM" id="SKILL_COSEM" type="checkbox" checked>&ensp;&ensp; COSEM</li>
                @else
                    <li class="list-group"><input class="form-check-input" name="SKILL_COSEM" id="SKILL_COSEM" type="checkbox">&ensp;&ensp; COSEM</li>
                @endif
            </ul>
        </div>
        <div class="row">
            <ul class="list-group list-group-horizontal">
                <li style="list-style-type: none;"><input class="form-check-input" type="checkbox" name="declare"></li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <li style="list-style-type: none;text-align: justify;">I hereby declare that the information submitted is true and correct.<br>In case any of the above information is found to be false or untrue or misleading or misrepresenting.<br>I am aware that I may be held liable for it.</li>
            </ul>
        </div>
{{--        <div class="row">--}}
{{--            PassID &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;: {{$personal->PassID}}--}}
{{--        </div>--}}
        <div class="row">
            Date of submission&emsp;: {{DateTime::createFromFormat("Y-m-d H:i:s", $personal->Date_Submitted)->format('d-m-Y')}}
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
        function New_Grade_Attained() {
            if ($("input[name='New_Grade']:checked").val()){
                return true;
            }else{
                return false;
            }
        }
        function New_Training_Records() {
            if ($("input[name='TR_RTT']:checked").val() != undefined || $("input[name='TR_CSSPB']:checked").val() != undefined || $("input[name='TR_CCTC']:checked").val() != undefined
                || $("input[name='TR_HCTA']:checked").val() != undefined || $("input[name='TR_X_RAY']:checked").val() != undefined){
                return true;
            }else{
                return false;
            }
        }
        function Skill_Sets_Acquired() {
            if ($("input[name='SKILL_BFM']:checked").val() != undefined || $("input[name='SKILL_BSS']:checked").val() != undefined || $("input[name='SKILL_FSM']:checked").val() != undefined
                || $("input[name='SKILL_CERT']:checked").val() != undefined || $("input[name='SKILL_COSEM']:checked").val() != undefined){
                return true;
            }else{
                return false;
            }
        }
        $( "#update_so" ).click(function() {
            if ($("input[name='declare']:checked").val() != undefined) {
                // if (New_Grade_Attained()) {
                    // if (New_Training_Records()) {
                    //     if (Skill_Sets_Acquired()) {
                            $("#action_update_so").submit();
                        // } else {
                        //     swal("Error!", " please select skill sets acquired.", "error");
                        // }
                    // } else {
                    //     swal("Error!", " please select new training records.", "error");
                    // }
                // }else{
                //     swal("Error!", " please select new grade attained.", "error");
                // }
            }else{
                swal("Error!", " Please acknowledge declaration.", "error");
            }
        });
        // checkbox remove
        // New Grade Attained
        $("#"+{!! json_encode(Senior_Security_Officer) !!}).change(function() {
            if(this.checked) {
                $("#"+{!! json_encode(Security_Supervisor) !!}).prop('checked', false);
                $("#"+{!! json_encode(Senior_Security_Supervisor) !!}).prop('checked', false);
                $("#"+{!! json_encode(Chief_Security_Officer) !!}).prop('checked', false);
            }
        });
        $("#"+{!! json_encode(Security_Supervisor) !!}).change(function() {
            if(this.checked) {
                $("#"+{!! json_encode(Senior_Security_Officer) !!}).prop('checked', false);
                $("#"+{!! json_encode(Senior_Security_Supervisor) !!}).prop('checked', false);
                $("#"+{!! json_encode(Chief_Security_Officer) !!}).prop('checked', false);
            }
        });
        $("#"+{!! json_encode(Senior_Security_Supervisor) !!}).change(function() {
            if(this.checked) {
                $("#"+{!! json_encode(Senior_Security_Officer) !!}).prop('checked', false);
                $("#"+{!! json_encode(Security_Supervisor) !!}).prop('checked', false);
                $("#"+{!! json_encode(Chief_Security_Officer) !!}).prop('checked', false);
            }
        });
        $("#"+{!! json_encode(Chief_Security_Officer) !!}).change(function() {
            if(this.checked) {
                $("#"+{!! json_encode(Senior_Security_Officer) !!}).prop('checked', false);
                $("#"+{!! json_encode(Security_Supervisor) !!}).prop('checked', false);
                $("#"+{!! json_encode(Senior_Security_Supervisor) !!}).prop('checked', false);
            }
        });
        // End New Grade Attained

        // New Training Records
        // $("#TR_RTT").change(function() {
        //     if(this.checked) {
        //         $("#TR_CSSPB").prop('checked', false);
        //         $("#TR_CCTC").prop('checked', false);
        //         $("#TR_HCTA").prop('checked', false);
        //         $("#TR_X_RAY").prop('checked', false);
        //     }
        // });
        // $("#TR_CSSPB").change(function() {
        //     if(this.checked) {
        //         $("#TR_RTT").prop('checked', false);
        //         $("#TR_CCTC").prop('checked', false);
        //         $("#TR_HCTA").prop('checked', false);
        //         $("#TR_X_RAY").prop('checked', false);
        //     }
        // });
        // $("#TR_CCTC").change(function() {
        //     if(this.checked) {
        //         $("#TR_RTT").prop('checked', false);
        //         $("#TR_CSSPB").prop('checked', false);
        //         $("#TR_HCTA").prop('checked', false);
        //         $("#TR_X_RAY").prop('checked', false);
        //     }
        // });
        // $("#TR_HCTA").change(function() {
        //     if(this.checked) {
        //         $("#TR_RTT").prop('checked', false);
        //         $("#TR_CSSPB").prop('checked', false);
        //         $("#TR_CCTC").prop('checked', false);
        //         $("#TR_X_RAY").prop('checked', false);
        //     }
        // });
        // $("#TR_X_RAY").change(function() {
        //     if(this.checked) {
        //         $("#TR_RTT").prop('checked', false);
        //         $("#TR_CSSPB").prop('checked', false);
        //         $("#TR_CCTC").prop('checked', false);
        //         $("#TR_HCTA").prop('checked', false);
        //     }
        // });
        // End New Training Records

        // Skill Sets Acquired
        // $("#SKILL_BFM").change(function() {
        //     if(this.checked) {
        //         $("#SKILL_BSS").prop('checked', false);
        //         $("#SKILL_FSM").prop('checked', false);
        //         $("#SKILL_CERT").prop('checked', false);
        //         $("#SKILL_COSEM").prop('checked', false);
        //     }
        // });
        // $("#SKILL_BSS").change(function() {
        //     if(this.checked) {
        //         $("#SKILL_BFM").prop('checked', false);
        //         $("#SKILL_FSM").prop('checked', false);
        //         $("#SKILL_CERT").prop('checked', false);
        //         $("#SKILL_COSEM").prop('checked', false);
        //     }
        // });
        // $("#SKILL_FSM").change(function() {
        //     if(this.checked) {
        //         $("#SKILL_BFM").prop('checked', false);
        //         $("#SKILL_BSS").prop('checked', false);
        //         $("#SKILL_CERT").prop('checked', false);
        //         $("#SKILL_COSEM").prop('checked', false);
        //     }
        // });
        // $("#SKILL_CERT").change(function() {
        //     if(this.checked) {
        //         $("#SKILL_BFM").prop('checked', false);
        //         $("#SKILL_BSS").prop('checked', false);
        //         $("#SKILL_FSM").prop('checked', false);
        //         $("#SKILL_COSEM").prop('checked', false);
        //     }
        // });
        // $("#SKILL_COSEM").change(function() {
        //     if(this.checked) {
        //         $("#SKILL_BFM").prop('checked', false);
        //         $("#SKILL_BSS").prop('checked', false);
        //         $("#SKILL_FSM").prop('checked', false);
        //         $("#SKILL_CERT").prop('checked', false);
        //     }
        // });
        // End Skill Sets Acquired

        // End checkbox remove

    });
</script>
@endsection
