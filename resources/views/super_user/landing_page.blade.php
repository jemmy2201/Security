@extends('layouts.app')
<style>
    .disabled{
        font-weight: normal;
    }
    .loadingPaynow {
        /*border: 16px solid #f3f3f3;*/
        /*border-radius: 50%;*/
        /*border-top: 16px solid #3498db;*/
        width: 60%;
        position: absolute;

        /*margin-top: 60px;*/
        left: 40%;
        height: 60%;
        background: url({{asset('img/loading.gif')}}) no-repeat;
        /*-webkit-animation: spin 2s linear infinite; !* Safari *!*/
        /*animation: spin 2s linear infinite;*/
    }
</style>
@section('content')
<div class="container">
    <input type="hidden" name="barcode_paynow" id="barcode_paynow">
    <img class="hidden-xs" src="{{URL::asset('/img/img_step_proses/1.png')}}" style="width: 100%;">
    <center class="visible-xs hidden-md">
    <img  src="{{URL::asset('/img/img_step_proses/design_phone/1.png')}}" style="width: 80%;">
    </center>
    <h3 style="color: black;"><b>ID Card Portal</b></h3><br>
    <div class="container">
        @if($passID != 'null')
            @php
                Session::put('passID', $passID->passid);
            @endphp
        @endif
            <p><b>Welcome {{ ($passID->passid != 'null')? substr($passID->passid, 0, -2):substr(Session::get('passID'), 0, -2)}}</b></p><br>
        {{--First design--}}
{{--    <p style="color: #808080;">My Application Type</p>--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col-sm">--}}
{{--                <button type="button" class="btn btn-secondary btn-lg btn-block" id="news" value="@php echo news @endphp"  >New</button>--}}
{{--            </div>--}}
{{--            <div class="col-sm">--}}
{{--                <button type="button" class="btn btn-secondary btn-lg btn-block" id="replacement" value="@php echo replacement @endphp" >Replacement</button>--}}
{{--            </div>--}}
{{--            <div class="col-sm">--}}
{{--                <button type="button" class="btn btn-secondary btn-lg btn-block" id="renewal" value="@php echo renewal @endphp" >Renewal</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--End First design--}}

{{--revisi 1 design--}}
{{--        <div class="row">--}}
{{--            <div class="col-sm">--}}
{{--                <b>New</b><br>--}}
{{--                <ul class="list-group list-group-flush" style="list-style-type: circle; margin-left: 15px;font-weight: bold;">--}}
{{--                    @foreach($new as $index => $f)--}}
{{--                        @php--}}
{{--                            $course_new []= "";--}}
{{--                            array_push($course_new,$f->card_id);--}}
{{--                        @endphp--}}
{{--                    @endforeach--}}
{{--                        @php--}}
{{--                            $course = array(so_app,avso_app,pi_app);--}}
{{--                            if(!empty($course_new)){--}}
{{--                                $result_course_new=array_diff($course,array_filter($course_new));--}}
{{--                            }else{--}}
{{--                                $result_course_new=$course;--}}
{{--                            }--}}
{{--                        @endphp--}}
{{--                    @foreach($new as $index => $f)--}}
{{--                            @php--}}
{{--                                $counts = count($new);--}}
{{--                                 if ($counts == 1){--}}
{{--                                     $count = 0;--}}
{{--                                 }else{--}}
{{--                                     $count = 1;--}}
{{--                                 }--}}
{{--                            @endphp--}}
{{--                        @if($index==0)--}}
{{--                            @foreach($result_course_new as $g)--}}
{{--                                @if($g == so_app )--}}
{{--                                    <li class="disabled">SO</li>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                        @if($f->card_id == so_app)--}}
{{--                            <li id="so_app" data-app_type={{news}} data-card={{so_app}} style='cursor: pointer;'>SO</li>--}}
{{--                        @endif--}}

{{--                        @if($index==0)--}}
{{--                        @foreach($result_course_new as $g)--}}
{{--                            @if($g == avso_app )--}}
{{--                                <li class="disabled">AVSO</li>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                        @endif--}}
{{--                        @if($f->card_id == avso_app)--}}
{{--                            <li id="avso_app" data-app_type={{news}} data-card={{avso_app}} style='cursor: pointer;'>AVSO</li>--}}
{{--                        @endif--}}

{{--                        @php--}}
{{--                        @endphp--}}

{{--                        @if($index == $count )--}}
{{--                            @foreach($result_course_new as $g)--}}
{{--                                @if($g == pi_app )--}}
{{--                                    <li class="disabled">PI</li>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}

{{--                        @if($f->card_id == pi_app)--}}
{{--                            <li id="pi_app" data-app_type={{news}} data-card={{pi_app}} style='cursor: pointer;'>PI</li>--}}
{{--                        @endif--}}

{{--                    @endforeach--}}
{{--                        @php--}}
{{--                            $courses = array(so_app,avso_app,pi_app);--}}
{{--                        @endphp--}}

{{--                        @if(count($new) ==0)--}}

{{--                            @foreach($courses as $f)--}}
{{--                                @if($f == so_app )--}}
{{--                                    <li class="disabled">SO</li>--}}
{{--                                @elseif($f == avso_app )--}}
{{--                                    <li class="disabled">AVSO</li>--}}
{{--                                @elseif($f == pi_app )--}}
{{--                                    <li class="disabled">PI</li>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                </ul>--}}
{{--        </div>--}}
{{--            <div class="col-sm">--}}
{{--                <b>Replacement</b><br>--}}
{{--                <ul class="list-group list-group-flush" style="list-style-type: circle; margin-left: 15px;font-weight: bold;">--}}
{{--                    @foreach($replacement as $index => $f)--}}
{{--                        @php--}}
{{--                            $course_replacement []= "";--}}
{{--                            array_push($course_replacement,$f->card_id);--}}
{{--                        @endphp--}}
{{--                    @endforeach--}}
{{--                    @php--}}
{{--                        $course_replacements = array(so_app,avso_app,pi_app);--}}
{{--                        if(!empty($course_replacement)){--}}
{{--                            $result_course_replacement=array_diff($course_replacements,array_filter($course_replacement));--}}
{{--                        }else{--}}
{{--                            $result_course_replacement=$course_replacements;--}}
{{--                        }--}}
{{--                    @endphp--}}
{{--                    @foreach($replacement as $index => $f)--}}
{{--                            @php--}}
{{--                                $counts = count($replacement);--}}
{{--                                 if ($counts == 1){--}}
{{--                                     $count = 0;--}}
{{--                                 }else{--}}
{{--                                     $count = 1;--}}
{{--                                 }--}}
{{--                            @endphp--}}
{{--                        @if($index==0)--}}
{{--                            @foreach($result_course_replacement as $g)--}}
{{--                                @if($g == so_app )--}}
{{--                                    <li class="disabled">SO</li>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}

{{--                        @if($f->card_id == so_app )--}}
{{--                            <li id="so_app" data-app_type={{replacement}} data-card={{so_app}} style='cursor: pointer;'>SO</li>--}}
{{--                        @endif--}}

{{--                        @if($index==0)--}}
{{--                            @foreach($result_course_replacement as $g)--}}
{{--                                @if($g == avso_app )--}}
{{--                                    <li class="disabled">AVSO</li>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}

{{--                        @if($f->card_id == avso_app)--}}
{{--                            <li id="avso_app" data-app_type={{replacement}} data-card={{avso_app}} style='cursor: pointer;'>AVSO</li>--}}
{{--                        @endif--}}

{{--                        @if($index==$count)--}}
{{--                            @foreach($result_course_replacement as $g)--}}
{{--                                @if($g == pi_app )--}}
{{--                                    <li class="disabled">PI</li>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                        @if($f->card_id == pi_app)--}}
{{--                            <li id="pi_app" data-app_type={{replacement}} data-card={{pi_app}} style='cursor: pointer;'>PI</li>--}}
{{--                        @endif--}}

{{--                    @endforeach--}}
{{--                    @php--}}
{{--                        $course_replacements = array(so_app,avso_app,pi_app);--}}
{{--                    @endphp--}}
{{--                        @if(count($replacement) ==0)--}}
{{--                            @foreach($course_replacements as $f)--}}
{{--                                @if($f == so_app )--}}
{{--                                    <li class="disabled">SO</li>--}}
{{--                                @elseif($f == avso_app )--}}
{{--                                    <li class="disabled">AVSO</li>--}}
{{--                                @elseif($f == pi_app )--}}
{{--                                    <li class="disabled">PI</li>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}

{{--                </ul>--}}
{{--            </div>--}}
{{--            <div class="col-sm">--}}
{{--                <b>Renewal</b><br>--}}
{{--                <ul class="list-group list-group-flush" style="list-style-type: circle; margin-left: 15px;font-weight: bold;">--}}
{{--                    @foreach($renewal as $index => $f)--}}
{{--                        @php--}}
{{--                            $course_renewal []= "";--}}
{{--                            array_push($course_renewal,$f->card_id);--}}
{{--                        @endphp--}}
{{--                    @endforeach--}}
{{--                    @php--}}
{{--                        $course_renewals = array(so_app,avso_app,pi_app);--}}
{{--                        if(!empty($course_renewal)){--}}
{{--                            $result_course_renewal=array_diff($course_renewals,array_filter($course_renewal));--}}
{{--                        }else{--}}
{{--                            $result_course_renewal=$course_renewals;--}}
{{--                        }--}}
{{--                    @endphp--}}
{{--                    @foreach($renewal as $index => $f)--}}
{{--                        @php--}}
{{--                        $counts = count($renewal);--}}
{{--                         if ($counts == 1){--}}
{{--                             $count = 0;--}}
{{--                         }else{--}}
{{--                             $count = 1;--}}
{{--                         }--}}
{{--                        @endphp--}}
{{--                        @if($index == 0)--}}
{{--                            @foreach($result_course_renewal as $g)--}}
{{--                                @if($g == so_app )--}}
{{--                                    <li class="disabled">SO</li>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                        @if($f->card_id == so_app)--}}
{{--                            <li id="so_app" data-app_type={{renewal}} data-card={{so_app}} style='cursor: pointer;'>SO</li>--}}
{{--                        @endif--}}

{{--                        @if($index == 0)--}}
{{--                            @foreach($result_course_renewal as $g)--}}
{{--                                @if($g == avso_app )--}}
{{--                                    <li class="disabled">AVSO</li>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}

{{--                        @if($f->card_id == avso_app)--}}
{{--                            <li id="avso_app" data-app_type={{renewal}} data-card={{avso_app}} style='cursor: pointer;'>AVSO</li>--}}
{{--                        @endif--}}

{{--                        @if($index == $count)--}}
{{--                            @foreach($result_course_renewal as $g)--}}
{{--                                @if($g == pi_app )--}}
{{--                                    <li class="disabled">PI</li>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}

{{--                        @if($f->card_id == pi_app )--}}
{{--                            <li id="pi_app" data-app_type={{renewal}} data-card={{pi_app}} style='cursor: pointer;'>PI</li>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                        @php--}}
{{--                            $course_renewals = array(so_app,avso_app,pi_app);--}}
{{--                        @endphp--}}
{{--                        @if(count($renewal) ==0)--}}
{{--                        @foreach($course_renewals as $f)--}}
{{--                                @if($f == so_app )--}}
{{--                                    <li class="disabled">SO</li>--}}
{{--                                @elseif($f == avso_app )--}}
{{--                                    <li class="disabled">AVSO</li>--}}
{{--                                @elseif($f == pi_app )--}}
{{--                                    <li class="disabled">PI</li>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                </ul>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--End revisi 1 design--}}

{{--revisi 2 design--}}

    <p><b>My Application Type</b></p>
    <div class="container">
        <div class="loadingPaynow"></div>
        <div id="qrcodePaynow" style="display: none"></div>
        <div class="row">
            <div class="col-sm">
            <div class="row">
    {{--            <div class="col-sm">--}}
    {{--                <button type="button" class="btn btn-secondary btn-lg btn-block" id="news" value="@php echo news @endphp"  >New</button>--}}
    {{--            </div>--}}
    {{--            <div class="col-sm">--}}
    {{--                <button type="button" class="btn btn-secondary btn-lg btn-block" id="replacement" value="@php echo replacement @endphp" >Replacement</button>--}}
    {{--            </div>--}}
    {{--            <div class="col-sm">--}}
    {{--                <button type="button" class="btn btn-secondary btn-lg btn-block" id="renewal" value="@php echo renewal @endphp" >Renewal</button>--}}
    {{--            </div>--}}
                <input class="form-check-input" type="checkbox" name="app_type" id="news" value="{{news}}" ><b>&ensp;&ensp;&ensp;New</b><br/>
            </div>
            <div class="row">
                <input class="form-check-input" type="checkbox" name="app_type" id="replacement" value="{{replacement}}" ><b>&ensp;&ensp;&ensp;Replacement</b>
            </div>
            <div class="row">
                <input class="form-check-input" type="checkbox" name="app_type" id="renewal" value="{{renewal}}" ><b>&ensp;&ensp;&ensp;Renewal</b>
            </div>
            </div>
            <div class="col-sm img_ntuc_co hidden-xs" style="display: none;">
                <div class="row">
                    <a href="https://www.ntuc.org.sg/uportal/memberships/become-a-member?CampaignCode=UNION-ONLINEUSE1" target="_blank">
                        <img src="{{URL::asset('/img/ntuc_co.png')}}" style="width: 90%; position: absolute;margin-left: -20px;margin-top: -60px;">
                    </a>
                </div>
            </div>
            <div class="col-sm visible-xs hidden-md" >
                <div class="row">
                    <a href="https://www.ntuc.org.sg/uportal/memberships/become-a-member?CampaignCode=UNION-ONLINEUSE1" target="_blank">
                        <img class="img_ntuc_co_phone" src="{{URL::asset('/img/ntuc_co.png')}}" style="display: none; width: 65%; position: absolute;margin-top: -65px; margin-left: 122px">
                    </a>
                </div>
            </div>
        </div>

    </div>
<br>
    <p><b>My Request</b></p>
    <div class="container">
        <div class="row view_checkbox_so">
{{--            <div class="col-sm">--}}
{{--                <button type="button" id="so_app" class="btn btn-secondary btn-lg btn-block" value="@php echo so_app @endphp" disabled>SO Application</button>--}}
{{--            </div>--}}
{{--            <div class="col-sm">--}}
{{--                <button type="button" id="avso_app" class="btn btn-secondary btn-lg btn-block" value="@php echo avso_app @endphp" disabled>AVSO Application</button>--}}
{{--            </div>--}}
{{--            <div class="col-sm">--}}
{{--                <button type="button" id="pi_app" class="btn btn-secondary btn-lg btn-block" value="@php echo pi_app @endphp" disabled>PI Application</button>--}}
{{--            </div>--}}
                <input class="form-check-input" type="checkbox" name="request" id="so_app" value="" data-card="{{so_app}}"><b>&ensp;&ensp;&ensp;Security Officer (SO) / Aviation Security Officer (AVSO)</b>
        </div>
        <div class="row view_checkbox_avso"  style="display: none">
                <input class="form-check-input" type="checkbox" name="request" id="avso_app" value="" data-card={{avso_app}}><b>&ensp;&ensp;&ensp;Security Officer (SO) / Aviation Security Officer (AVSO)</b>
{{--            <b>&ensp;&ensp;&ensp;Aviation Security Officer (AVSO)</b>--}}
        </div>
        <div class="row">
                <input class="form-check-input" type="checkbox" name="request" id="pi_app" value="" data-card={{pi_app}}><b>&ensp;&ensp;&ensp;Private Investigator (PI)</b>
        </div>
    </div>
<br>
    <p><b>My Updates</b></p>
    <div class="container">
        <div class="row">
            @php
                $passID = App\booking_schedule::where(['nric' => Session::get('nric_origin'), 'card_id' => so_app])->first();
                if (!empty($passID)){
                    $check_PWM = App\so_update_info::where(['PassID' => $passID->passid])->first();
                }
            @endphp
            @if(!empty($check_PWM))
                <input class="form-check-input" type="checkbox"  id="PWM" value="" ><b>&ensp;&ensp;&ensp;New PWM SO Grade/Courses Attended</b>
            @else
                <input class="form-check-input" type="checkbox"  id="PWM" value="" disabled><b>&ensp;&ensp;&ensp;New PWM SO Grade/Courses Attended</b>
            @endif
        </div>
{{--        <div class="row">--}}
{{--            <input class="form-check-input" type="checkbox" name="" id="" value="" ><b>&ensp;&ensp;&ensp;Notifications</b>--}}
{{--        </div>--}}
    </div>
{{--End revisi 2 design--}}

    <form method="post" id="personal_particular" action="{{ route('super_user.personal.particular') }}" style="display: none">
        @csrf
        <input type="text" id="app_type" name="app_type">
        <input type="text" id="card" name="card">
        <input type="submit">
    </form>

    <input type="hidden" id="new_click" name="new_click">
    <input type="hidden" id="replacement_click" name="replacement_click">
    <input type="hidden" id="renewal_click" name="renewal_click">

<br>
<p style="color: #808080;">My Applications</p>
    {{-- Desktop --}}
    <div class="row hidden-xs" >
        <div class="col-10" style="border-style: ridge;padding: 10px;">
        <table class="table" >
            <thead>
            <tr>
                <th scope="col">Application</th>
                <th scope="col" >Card Type</th>
                <th scope="col">Grade</th>
                <th scope="col">Card Collection</th>
                <th scope="col" >Status</th>
                <th scope="col" >Action/Remarks</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($schedule))
                @foreach($schedule as $index => $f)
                    @if($f->Status_app == processing)
{{--                    @php $url="/history/book/appointment/".$f->app_type."/".$f->card_id; @endphp--}}
                        @php $url=url("/super/user/history/book/appointment/")."/".$f->app_type."/".$f->card_id; @endphp
                    @elseif($f->Status_app == draft)
{{--                        @php $url="/history/book/payment/".$f->app_type."/".$f->card_id; @endphp--}}
                        @php $url=url("/super/user/history/book/payment/")."/".$f->app_type."/".$f->card_id; @endphp
                    @endif
                    <tr style="cursor: pointer;">
                        @if($f->app_type == news)
                            <td>New</td>
                        @elseif($f->app_type == replacement)
                            <td>Replacement</td>
                        @elseif($f->app_type == renewal)
                            <td>Renewal</td>
                        @endif

                        @if($f->card_id == so_app)
                            <td>SO</td>
                        @elseif($f->card_id == avso_app)
                            <td>AVSO</td>
                        @elseif($f->card_id == pi_app)
                            <td>PI</td>
                        @endif
                            @if($f->card_id == so_app)
                                @if(!empty($f->grade_id) && $f->grade_id== so)
                                    <td>SO</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== sso)
                                    <td>SSO</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== ss)
                                    <td>SS</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== sss)
                                    <td>SSS</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== cso)
                                    <td>CSO</td>
                                @else
                                    <td >SO</td>
                                @endif
                                {{--                            <td>--}}
                                {{--                                @foreach($grade as $g)--}}
                                {{--                                    @foreach (json_decode($f->grade_id) as $i)--}}
                                {{--                                        @if($g->id == $i)--}}
                                {{--                                            <pre>{{$g->name}}</pre>--}}
                                {{--                                        @endif--}}
                                {{--                                    @endforeach--}}
                                {{--                                @endforeach--}}
                                {{--                            </td>--}}
                                {{--                            @foreach($grade as $g)--}}
                                {{--                                @if($g->id == $f->grade_id)--}}
                                {{--                                    <td>{{$g->name}}</td>--}}
                                {{--                                @endif--}}
                                {{--                            @endforeach--}}
                            @else
                                <td>NA</td>
                            @endif
{{--                            <td>@php echo Carbon\Carbon::createFromFormat('Y-m-d', $f->declaration_date)->format('d-m-Y') @endphp</td>--}}
                            @if(!empty($f->trans_date))
{{--                                <td>@php echo Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $f->trans_date)->format('d-m-Y') @endphp</td>--}}
{{--                                <td>{{$f->trans_date}}</td>--}}
                                @php
                                    $date=date_create($f->appointment_date);
                                    $appointment_date = date_format($date,"d F Y");
                                @endphp
                                <td>{{$appointment_date}} {{$f->time_start_appointment}}-{{$f->time_end_appointment}}</td>
                            @else
                                <td></td>
                            @endif


{{--                       @if($f->Status_app == draft)--}}
{{--                            <td>{{txt_draft}}</td>--}}
{{--                        @elseif($f->Status_app == processing)--}}
{{--                            <td>{{txt_processing}}</td>--}}
{{--                        @elseif($f->Status_app == processing)--}}
{{--                            <td>{{txt_processing}}</td>--}}
{{--                        @elseif($f->Status_app == id_card_ready_for_collection)--}}
{{--                            <td>{{txt_id_card_ready_for_collection}}</td>--}}
{{--                        @elseif($f->Status_app == resubmission)--}}
{{--                            <td>{{txt_resubmission}}</td>--}}
{{--                        @elseif($f->Status_app == Resubmitted)--}}
{{--                            <td>{{txt_Resubmitted}}</td>--}}
{{--                        @endif--}}

                            @if($f->Status_app == draft)
                                <td>{{txt_draft}}</td>
                            @elseif($f->Status_app == processing)
                                <td>{{txt_processing}}</td>
                            @elseif($f->Status_app == ready_for_id_card_printing)
                                <td>{{txt_ready_for_id_card_printing}}</td>
                            @elseif($f->Status_app == id_card_ready_for_collection)
                                <td>{{txt_id_card_ready_for_collection}}</td>
                            @elseif($f->Status_app == resubmission)
                                <td>{{txt_resubmission}}</td>
                            @elseif($f->Status_app == Resubmitted)
                                <td>{{txt_Resubmitted}}</td>
                            @elseif($f->Status_app == completed)
                                <td>{{txt_completed}}</td>
                            @endif

                        @if($f->Status_app == processing)
{{--                             <td>@php echo Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $f->expired_date)->format('d-m-Y') @endphp</td>--}}
                        @else
{{--                            <td></td>--}}
                        @endif

                        @if($f->Status_app == draft)
{{--                                @if($f->Status_draft == draft_book_appointment)--}}
{{--                                    @php $url="/history/book/appointment/".$f->app_type."/".$f->card_id; @endphp--}}
{{--                                @elseif($f->Status_draft == draft_payment)--}}
{{--                                    @php $url=url("/history/book/payment/")."/".$f->app_type."/".$f->card_id; @endphp--}}
{{--                                @endif--}}
                                @php $url=url("/super/user/draft")."/".$f->app_type."/".$f->card_id; @endphp
                                <td><a href="{{$url}}"><button class="btn btn-primary">Continue</button></a></td>
                        @elseif($f->Status_app == resubmission)
                            @php $url=url("/super/user/personal/particular")."/".$f->app_type."/".$f->card_id."/".resubmission; @endphp
                                <td><a href="{{$url}}"><button class="btn btn-success">Resubmit</button></a></td>
                        @elseif($f->Status_app >= processing)
{{--                                @php $url=url("/view/course")."/".$f->card_id; @endphp--}}
                                @php $url= url("/super/user/invoice/print/pdf")."/".$f->card_id; @endphp
{{--                                <td><a href="{{$url}}"><button class="ntuc_hidden btn btn-success">View Receipt</button></a></td>--}}
                                <td><button class="ntuc_hidden btn btn-success" onclick="CheckFileInvoicePDF(@php echo $f->card_id @endphp)">View Receipt</button></td>
                        @endif
                    </tr>
                @endforeach
            @endif
            @if(!empty($sertifikat))
                    @foreach($sertifikat as $index => $f)
                        <tr>
                            @if($f->app_type == news)
                                <td>New</td>
                            @elseif($f->app_type == replacement)
                                <td>Replacement</td>
                            @elseif($f->app_type == renewal)
                                <td>Renewal</td>
                            @endif

                            @if($f->card_id == so_app)
                                <td>SO </td>
                            @elseif($f->card_id == avso_app)
                                <td>AVSO </td>
                            @elseif($f->card_id == pi_app)
                                <td>PI </td>
                            @endif
                                @if($f->card_id == so_app)
                                    @if(!empty($f->grade_id) && $f->grade_id== so)
                                        <td>SO</td>
                                    @elseif(!empty($f->grade_id) && $f->grade_id== sso)
                                        <td>SSO</td>
                                    @elseif(!empty($f->grade_id) && $f->grade_id== ss)
                                        <td>SS</td>
                                    @elseif(!empty($f->grade_id) && $f->grade_id== sss)
                                        <td>SSS</td>
                                    @elseif(!empty($f->grade_id) && $f->grade_id== cso)
                                        <td>CSO</td>
                                    @else
                                        <td >SO</td>
                                    @endif
                                    {{--                                <td>--}}
                                    {{--                                @foreach($grade as $g)--}}
                                    {{--                                        @foreach (json_decode($f->grade_id) as $i)--}}
                                    {{--                                            @if($g->id == $i)--}}
                                    {{--                                                    <pre>{{$g->name}}</pre>--}}
                                    {{--                                            @endif--}}
                                    {{--                                        @endforeach--}}
                                    {{--                                    @if($g->id == $f->grade_id)--}}
                                    {{--                                        <td>{{$g->name}}</td>--}}
                                    {{--                                    @endif--}}
                                    {{--                                @endforeach--}}
                                    {{--                                </td>--}}
                                @else
                                    <td>NA</td>
                                @endif
{{--                                <td>@php echo Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $f->declaration_date)->format('d-m-Y') @endphp</td>--}}
                                @if(!empty($f->trans_date))
{{--                                <td>@php echo Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $f->trans_date)->format('d-m-Y') @endphp</td>--}}
{{--                                    <td>{{$f->trans_date}}</td>--}}
                                    @php
                                        $date=date_create($f->appointment_date);
                                        $appointment_date = date_format($date,"d F Y");
                                    @endphp
                                    <td>{{$appointment_date}} {{$f->time_start_appointment}}-{{$f->time_end_appointment}}</td>
                                @else
                                    <td></td>
                                @endif

                            <td>Completed</td>
{{--                            <td>@php echo Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $f->expired_date)->format('d-m-Y') @endphp</td>--}}
                            <td></td>
                        </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        </div>
    </div>
    {{-- End Desktop --}}

        {{-- Phone --}}
        <div class="row visible-xs hidden-md" >
            <div class="col-10" style="border-style: ridge;padding: 10px;">
                <table class="table" >
                    <thead>
                    <tr>
                        <th scope="col">Application</th>
{{--                        <th scope="col" >Card Type</th>--}}
{{--                        <th scope="col">Grade</th>--}}
{{--                        <th scope="col">Card Collection</th>--}}
{{--                        <th scope="col" >Status</th>--}}
{{--                        <th scope="col" >Action/Remarks</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($schedule))
                        @foreach($schedule as $index => $f)
                            @if($f->Status_app == processing)
                                {{--                    @php $url="/history/book/appointment/".$f->app_type."/".$f->card_id; @endphp--}}
                                @php $url=url("/super/user/history/book/appointment/")."/".$f->app_type."/".$f->card_id; @endphp
                            @elseif($f->Status_app == draft)
                                {{--                        @php $url="/history/book/payment/".$f->app_type."/".$f->card_id; @endphp--}}
                                @php $url=url("/super/user/history/book/payment/")."/".$f->app_type."/".$f->card_id; @endphp
                            @endif
                            <tr style="cursor: pointer;">
                                @if($f->app_type == news)
                                    <td onclick="showHideRow({{$index}});">New</td>

                                @elseif($f->app_type == replacement)
                                    <td onclick="showHideRow({{$index}});">Replacement</td>
                                @elseif($f->app_type == renewal)
                                    <td onclick="showHideRow({{$index}});">Renewal</td>
                                @endif

                            </tr>
{{--                            <td style="cursor: pointer;" id="{{$index}}" class="hidden_row default_hidden">--}}
                            <td >
                                <ul class="list-group">
                                    <li class="list-group-item" aria-current="true"><b>Card Type:</b>
                                    @if($f->card_id == so_app)
                                        SO
                                    @elseif($f->card_id == avso_app)
                                        AVSO
                                    @elseif($f->card_id == pi_app)
                                        PI
                                    @endif
                                    </li>
                                    <li class="list-group-item" aria-current="true"><b>Grade:</b>
                                    @if($f->card_id == so_app)
                                        @if(!empty($f->grade_id) && $f->grade_id== so)
                                                SO
                                        @elseif(!empty($f->grade_id) && $f->grade_id== sso)
                                                SSO
                                        @elseif(!empty($f->grade_id) && $f->grade_id== ss)
                                                SS
                                        @elseif(!empty($f->grade_id) && $f->grade_id== sss)
                                                SSS
                                        @elseif(!empty($f->grade_id) && $f->grade_id== cso)
                                                CSO
                                        @else
                                                SO
                                        @endif
                                    @else
                                            NA
                                     @endif
                                    </li>
                                    <li class="list-group-item" aria-current="true"><b>Card Collection:</b>
                                        @if(!empty($f->trans_date))
{{--                                            {{$f->trans_date}}--}}
                                            @php
                                                $date=date_create($f->appointment_date);
                                                $appointment_date = date_format($date,"d F Y");
                                            @endphp
                                            {{$appointment_date}} {{$f->time_start_appointment}}-{{$f->time_end_appointment}}
                                        @else
                                        @endif
                                    </li>
                                    <li class="list-group-item" aria-current="true"><b>Status:</b>
                                        @if($f->Status_app == draft)
                                            {{txt_draft}}
                                        @elseif($f->Status_app == processing)
                                            {{txt_processing}}
                                        @elseif($f->Status_app == ready_for_id_card_printing)
                                            {{txt_ready_for_id_card_printing}}
                                        @elseif($f->Status_app == id_card_ready_for_collection)
                                            {{txt_id_card_ready_for_collection}}
                                        @elseif($f->Status_app == resubmission)
                                            {{txt_resubmission}}
                                        @elseif($f->Status_app == Resubmitted)
                                            {{txt_Resubmitted}}
                                        @elseif($f->Status_app == completed)
                                            {{txt_completed}}
                                        @endif
                                    </li>
                                    <li class="list-group-item" aria-current="true"><b>	Action/Remarks:</b>
                                        @if($f->Status_app == draft)

                                            @php $url=url("/super/user/draft")."/".$f->app_type."/".$f->card_id; @endphp
                                            <a href="{{$url}}"><button class="btn btn-primary">Continue</button></a>
                                        @elseif($f->Status_app == resubmission)
                                            @php $url=url("/super/user/personal/particular")."/".$f->app_type."/".$f->card_id."/".resubmission; @endphp
                                            <a href="{{$url}}"><button class="btn btn-success">Resubmit</button></a>
                                        @elseif($f->Status_app >= processing)
                                            {{--                                @php $url=url("/view/course")."/".$f->card_id; @endphp--}}
                                            @php $url= url("/super/user/invoice/print/pdf")."/".$f->card_id; @endphp
{{--                                           <a href="{{$url}}"><button class="ntuc_co_phone btn btn-success">View Receipt</button></a>--}}
                                               <button class="ntuc_hidden_phone btn btn-success" onclick="CheckFileInvoicePDF(@php echo $f->card_id @endphp)">View Receipt</button>
                                            @endif
                                    </li>
                                </ul>
                            </td>
                        @endforeach
                    @endif
                    @if(!empty($sertifikat))
                        @foreach($sertifikat as $index => $f)
                            @if($f->Status_app == processing)
                                {{--                    @php $url="/history/book/appointment/".$f->app_type."/".$f->card_id; @endphp--}}
                                @php $url=url("/super/user/history/book/appointment/")."/".$f->app_type."/".$f->card_id; @endphp
                            @elseif($f->Status_app == draft)
                                {{--                        @php $url="/history/book/payment/".$f->app_type."/".$f->card_id; @endphp--}}
                                @php $url=url("/super/user/history/book/payment/")."/".$f->app_type."/".$f->card_id; @endphp
                            @endif
                            <tr style="cursor: pointer;">
                                @if($f->app_type == news)
                                    <td onclick="showHideRow('seftifikat_'+{{$index}});">New</td>

                                @elseif($f->app_type == replacement)
                                    <td onclick="showHideRow('seftifikat_'+{{$index}});">Replacement</td>
                                @elseif($f->app_type == renewal)
                                    <td onclick="showHideRow('seftifikat_'+{{$index}});">Renewal</td>
                                @endif

                            </tr>
{{--                            <td style="cursor: pointer;" id="seftifikat_{{$index}}" class="hidden_row default_hidden">--}}
                            <td style="cursor: pointer;" >
                                <ul class="list-group">
                                    <li class="list-group-item" aria-current="true"><b>Card Type:</b>
                                        @if($f->card_id == so_app)
                                            SO
                                        @elseif($f->card_id == avso_app)
                                            AVSO
                                        @elseif($f->card_id == pi_app)
                                            PI
                                        @endif
                                    </li>
                                    <li class="list-group-item" aria-current="true"><b>Grade:</b>
                                        @if($f->card_id == so_app)
                                            @if(!empty($f->grade_id) && $f->grade_id== so)
                                                SO
                                            @elseif(!empty($f->grade_id) && $f->grade_id== sso)
                                                SSO
                                            @elseif(!empty($f->grade_id) && $f->grade_id== ss)
                                                SS
                                            @elseif(!empty($f->grade_id) && $f->grade_id== sss)
                                                SSS
                                            @elseif(!empty($f->grade_id) && $f->grade_id== cso)
                                                CSO
                                            @else
                                                SO
                                            @endif
                                        @else
                                            NA
                                        @endif
                                    </li>
                                    <li class="list-group-item" aria-current="true"><b>Card Collection:</b>
                                        @if(!empty($f->trans_date))
{{--                                            {{$f->trans_date}}--}}
                                            @php
                                                $date=date_create($f->appointment_date);
                                                $appointment_date = date_format($date,"d F Y");
                                            @endphp
                                            {{$appointment_date}} {{$f->time_start_appointment}}-{{$f->time_end_appointment}}
                                        @else
                                        @endif
                                    </li>
                                    <li class="list-group-item" aria-current="true"><b>Status:</b>
{{--                                        @if($f->Status_app == draft)--}}
{{--                                            {{txt_draft}}--}}
{{--                                        @elseif($f->Status_app == processing)--}}
{{--                                            {{txt_processing}}--}}
{{--                                        @elseif($f->Status_app == ready_for_id_card_printing)--}}
{{--                                            {{txt_ready_for_id_card_printing}}--}}
{{--                                        @elseif($f->Status_app == id_card_ready_for_collection)--}}
{{--                                            {{txt_id_card_ready_for_collection}}--}}
{{--                                        @elseif($f->Status_app == resubmission)--}}
{{--                                            {{txt_resubmission}}--}}
{{--                                        @elseif($f->Status_app == Resubmitted)--}}
{{--                                            {{txt_Resubmitted}}--}}
{{--                                        @elseif($f->Status_app == completed)--}}
                                            {{txt_completed}}
{{--                                        @endif--}}
                                    </li>
                                    <li class="list-group-item" aria-current="true"><b>	Action/Remarks:</b>
{{--                                        @if($f->Status_app == draft)--}}

{{--                                            @php $url=url("/super/user/draft")."/".$f->app_type."/".$f->card_id; @endphp--}}
{{--                                            <a href="{{$url}}"><button class="btn btn-primary">Continue</button></a>--}}
{{--                                        @elseif($f->Status_app == resubmission)--}}
{{--                                            @php $url=url("/super/user/personal/particular")."/".$f->app_type."/".$f->card_id."/".resubmission; @endphp--}}
{{--                                            <a href="{{$url}}"><button class="btn btn-success">Resubmit</button></a>--}}
{{--                                        @elseif($f->Status_app >= processing)--}}
{{--                                            --}}{{--                                @php $url=url("/view/course")."/".$f->card_id; @endphp--}}
{{--                                            @php $url= url("/super/user/invoice/print/pdf")."/".$f->card_id; @endphp--}}
{{--                                            <a href="{{$url}}"><button class="ntuc_hidden btn btn-success">View Receipt</button></a>--}}
{{--                                        @endif--}}
                                    </li>
                                </ul>
                            </td>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        {{-- End Phone --}}

   <div class="modal" tabindex="-1" role="dialog" id="Modalreplacement">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" >
                        <thead>
                        <tr>
                            <th scope="col">Application Type</th>
                            <th scope="col" >Request Application</th>
                            <th scope="col">Grade</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $expried_replacement =true; @endphp
                        @if(!empty($replacement))
                            @foreach($replacement as $index => $f)
{{--                                @php $url="/replacement/personal/particular/".$f->card_id; @endphp--}}
                                    @php $url=url("/super/user/replacement/personal/particular/")."/".$f->card_id; @endphp
                                    @php
                                      //$expried = Carbon\Carbon::today()->toDateString() >= Carbon\Carbon::parse($f->expired_date)->toDateString();
                                       if ($f->expired_date){
                                            $expried_replacement = Carbon\Carbon::today()->toDateString() >= Carbon\Carbon::createFromFormat('d/m/Y', $f->expired_date)->format('Y-m-d');
                                       }else{
                                           $expried_replacement =true;
                                       }
                                    @endphp
{{--                                @if($expried == false)--}}
                                @if($f->Status_app == completed && $expried_replacement == false)

                                <tr class='clickable-row' data-href='{{$url}}' style="cursor: pointer;">
                                    @if($f->app_type == news)
                                        <td>New</td>
                                    @elseif($f->app_type == replacement)
                                        <td>Replacement</td>
                                    @elseif($f->app_type == renewal)
                                        <td>Renewal</td>
                                    @endif

                                    @if($f->card_id == so_app)
                                        <td>SO Application</td>
                                    @elseif($f->card_id == avso_app)
                                        <td>AVSO Application</td>
                                    @elseif($f->card_id == pi_app)
                                        <td>PI Application</td>
                                    @endif
                                    @if($f->card_id == so_app)
                                        @if(!empty($f->grade_id) && $f->grade_id== so)
                                            <td>SO</td>
                                        @elseif(!empty($f->grade_id) && $f->grade_id== sso)
                                            <td>SSO</td>
                                        @elseif(!empty($f->grade_id) && $f->grade_id== ss)
                                            <td>SS</td>
                                        @elseif(!empty($f->grade_id) && $f->grade_id== sss)
                                            <td>SSS</td>
                                        @elseif(!empty($f->grade_id) && $f->grade_id== cso)
                                            <td>CSO</td>
                                        @else
                                            <td >SO</td>
                                        @endif
                                    @else
                                        <td>NA</td>
                                    @endif
                                </tr>
                                @endif
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

   <div class="modal" tabindex="-1" role="dialog" id="Modalrenewal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Application Type</th>
                            <th scope="col" >Request Application</th>
                            <th scope="col">Grade</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $expried_renewal =true; @endphp
                        @if(!empty($renewal))
                            @foreach($renewal as $index => $f)
                                @php
                                if (!empty($f->expired_date)){
                                        $expried_renewal = Carbon\Carbon::today()->toDateString() >= Carbon\Carbon::createFromFormat('d/m/Y', $f->expired_date)->format('Y-m-d');
                                }else{
                                        $expried_renewal = false;
                                }

                                @endphp
                                @if($f->Status_app == completed && $expried_renewal == true )
{{--                                @php $url="/renewal/personal/particular/".$f->card_id; @endphp--}}
                                @php $url=url("/super/user/renewal/personal/particular/")."/".$f->card_id; @endphp
                                <tr class='clickable-row' data-href='{{$url}}' style="cursor: pointer;">
                                    @if($f->app_type == news)
                                        <td>New</td>
                                    @elseif($f->app_type == replacement)
                                        <td>Replacement</td>
                                    @elseif($f->app_type == renewal)
                                        <td>Renewal</td>
                                    @endif

                                    @if($f->card_id == so_app)
                                        <td>SO Application</td>
                                    @elseif($f->card_id == avso_app)
                                        <td>AVSO Application</td>
                                    @elseif($f->card_id == pi_app)
                                        <td>PI Application</td>
                                    @endif
                                    @if($f->card_id == so_app)
                                        @if(!empty($f->grade_id) && $f->grade_id== so)
                                            <td>SO</td>
                                        @elseif(!empty($f->grade_id) && $f->grade_id== sso)
                                            <td>SSO</td>
                                        @elseif(!empty($f->grade_id) && $f->grade_id== ss)
                                            <td>SS</td>
                                        @elseif(!empty($f->grade_id) && $f->grade_id== sss)
                                            <td>SSS</td>
                                        @elseif(!empty($f->grade_id) && $f->grade_id== cso)
                                            <td>CSO</td>
                                        @else
                                            <td >SO</td>
                                        @endif
                                    @else
                                        <td>NA</td>
                                    @endif
                                </tr>
                                @endif
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/paynowqr@latest/dist/paynowqr.min.js"></script>
<script type="application/javascript">
    $("#BodyAll").css('background-image', 'none');
    function showHideRow(row) {
        $("#" + row).toggle();
    }
    // 15 minutes not action
    setTimeout(RefreshPage, 900000);
    function RefreshPage() {
        window.location.href = "{{URL::to('relogin')}}"
    }
    // End 15 minutes not action
    {{--  Check Status Prosesing  --}}
        {!!  json_encode($schedule) !!}.forEach((entry) => {
            if (entry['Status_payment'] == {!!  json_encode(paid) !!} || entry['union_member'] == {!!  json_encode(display) !!}){
                $(".img_ntuc_co").css("display", "block")
                $(".img_ntuc_co_phone").css("display", "block")
            }
        });
    {{--  Check Status Prosesing  --}}


    {{--  Card Issue  --}}
    if ({!!  json_encode($card_issue) !!} != false)
    {
        {!!  json_encode($card_issue) !!}.forEach((entry) => {
            {{--if (entry['card_id'] == {!!  json_encode(so_app) !!}){--}}
            {{--    var str1="Cannot apply SO ID Card.\n";--}}
            {{--    var str2="Kindly check your PLRD SO licence status with PLRD.";--}}
            {{--}else if(entry['card_id'] == {!!  json_encode(avso_app) !!}){--}}
            {{--    var str1="Cannot apply AVSO ID Card.\n";--}}
            {{--    var str2="Kindly check your PLRD AVSO licence status with PLRD.";--}}
            {{--}else if(entry['card_id'] == {!!  json_encode(pi_app) !!}){--}}
            {{--    var str1="Cannot apply PI ID Card.\n";--}}
            {{--    var str2="Kindly check your PLRD PI licence status with PLRD.";--}}
            {{--}else if(entry['card_id'] == {!!  json_encode(so_app) !!} && entry['card_id'] == {!!  json_encode(avso_app) !!}){--}}
            {{--    var str1="Cannot apply SO/AVSO ID Card.\n";--}}
            {{--    var str2="Kindly check your PLRD SO/AVSO licence status with PLRD.";--}}
            {{--}else if(entry['card_id'] == {!!  json_encode(so_app) !!} && entry['card_id'] == {!!  json_encode(avso_app) !!} && entry['card_id'] == {!!  json_encode(pi_app) !!}){--}}
            //     var str1="Cannot apply SO/AVSO/PI ID Card.\n";
            //     var str2="Kindly check your PLRD SO/AVSO/PI licence status with PLRD.";
            {{--}--}}

            // var str1="Cannot apply SO/AVSO/PI ID Card.\n";
            // var str2="Kindly check your PLRD SO/AVSO/PI licence status with PLRD.";
            // var str="Your licence's status is\xa0\xa0"+ entry['licence_status'] +".\n" +
            //     ""+str1+"" +
            //     ""+str2+"";
            // swal("Error!", str, "error")
        });

    }
    {{--  ENd Card Issue  --}}
    $(window).bind('resize', function(e)
    {
        this.location.reload(false); /* false to get page from cache */
        /* true to fetch page from server */
    });
    {{--if ({!!  json_encode($cekStatusUser) !!} == null ){--}}
    {{--    $("#news").prop('disabled', true);--}}
    {{--    $("#replacement").prop('disabled', true);--}}
    {{--    $("#renewal").prop('disabled', true);--}}
    {{--}--}}
    // delete process
    function delete_process(id,app_type,card_id){
        swal({
            title: 'Are you sure?',
            text: 'Delete!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{route('super.users.delete.process')}}",
                    data: {id: id,app_type:app_type,card_id:card_id},
                    success: function(data,textStatus, xhr)
                    {
                        location.reload();
                    }
                });
            }
        });
    }
    // end delete process

    jQuery(document).ready(function($) {
        $('.loadingPaynow').hide();
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
        $(".ntuc_hidden").click(function() {
            $(".img_ntuc_co").css("display", "none")
            $(".img_ntuc_co_phone").css("display", "none")
        });
        $(".ntuc_hidden_phone").click(function() {
            $(".img_ntuc_co").css("display", "none")
            $(".img_ntuc_co_phone").css("display", "none")
        });
    });
    function CheckFileInvoicePDF(card_id){
        $('.loadingPaynow').show();
        $.ajax({
            url: '/super/user/ViewReceipt/cek/file/invoice/pdf',
            type: 'POST',
            data: {
                card: card_id,
                _token: '{{ csrf_token() }}'  // Pastikan untuk mengirimkan CSRF token
            },
            success: function(data) {
                if (data.error == false){
                    DownloadInvoicePDF(card_id)
                }else{
                    CreateInvoice(data.data)
                }
            },
            error: function(xhr, status, error) {
                console.log("Error downloading PDF: ", status);
            }
        });
    }
    function DownloadInvoicePDF(card_id){
        $.ajax({
            url: '/super/user/ViewReceipt/download/invoice/pdf',
            type: 'POST',
            data: {
                card: card_id,
                _token: '{{ csrf_token() }}'  // Pastikan untuk mengirimkan CSRF token
            },
            xhrFields: {
                responseType: 'blob' // Important for downloading binary files
            },
            success: function(data) {
                $('.loadingPaynow').hide();
                var blob = new Blob([data], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "App_Slip.pdf";
                link.click();
            },
            error: function(xhr, status, error) {
                console.log("Error downloading PDF: ", status);
            }
        });
    }
    function CreateInvoice(booking_schedule){
        $.ajax({
            url: "{{ url('/super/user/create_receiptno') }}",
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                card_id:booking_schedule['card_id']
            },
            success: function (data) {
                generateBarcodePaynow(data['receiptNo'],booking_schedule)
            },
            error: function (request, status, error) {
                // handling_error_ajax();
            }
        });

    }
    function generateBarcodePaynow(receipt,booking_schedule){
        //Create a PaynowQR object
        let qrcode = new PaynowQR({
            uen: {!!  json_encode(uen) !!},           //Required: UEN of company
            amount : booking_schedule['grand_total'],               //Specify amount of money to pay.
            // amount :"1",               //Specify amount of money to pay.
            editable: false,             //Whether or not to allow editing of payment amount. Defaults to false if amount is specified
            expiry: {!!  json_encode( date('Ymd', strtotime( date("Ymd"). ' + 14 days')) ) !!},         //Set an expiry date for the Paynow QR code (YYYYMMDD). If omitted, defaults to 5 years from current time.
            {{--            refNumber: {!!  json_encode(refNumber) !!} + " " +{!!  json_encode( $booking_schedule->receiptNo) !!},   //Reference number for Paynow Transaction. Useful if you need to track payments for recouncilation.--}}
            refNumber: booking_schedule['passid'] +'-'+receipt.slice(-5),
            // refNumber: "Website Testing reference number",   //Reference number for Paynow Transaction. Useful if you need to track payments for recouncilation.
            company:{!!  json_encode(refNumber) !!}   //Company name to embed in the QR code. Optional.
        });

        //Outputs the qrcode to a UTF-8 string format, which can be passed to a QR code generation script to generate the paynow QR
        let QRstring = qrcode.output();
        new QRCode(document.getElementById("qrcodePaynow"), QRstring)
        var imageParent = document.getElementById('qrcodePaynow');
        var image = imageParent.querySelector('img')
        image.id = 'data_barcode';
        setTimeout(function(){ $("#barcode_paynow").val($('#data_barcode').attr('src')) }, 50);
        setTimeout(function(){SaveBarcodePaynow(QRstring,booking_schedule) }, 50);

        // hideLoader();
    }
    function SaveBarcodePaynow(QRstring,booking_schedule) {
        $.ajax({
            url: "{{ url('/super/user/save_barcode_paynow') }}",
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                data_barcode: $('#data_barcode').attr('src'),
                card_id:booking_schedule['card_id'],
                QRstring:QRstring
            },
            success: function (data) {
                GeneratePDF(booking_schedule['card_id'])
                // $("#form_paynow_verification").attr("disabled", false);
            },
            error: function (request, status, error) {
                // handling_error_ajax();
            }
        });
    }
    function GeneratePDF(card_id) {
        {{-- Generate PDF --}}
        $.ajax({
            url: "{{ url('/super/user/ViewReceipt/generate/Pdf') }}",
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                card:card_id,
            },
            success: function (data) {
                DownloadInvoicePDF(card_id)
            },
            error: function (request, status, error) {
                // handling_error_ajax();
            }
        });
        {{-- End Generate PDF --}}
    }

    if ((screen.width>=1024) && (screen.height>=768)) {
        $(".table").css({"display": "", "max-height": "100%","overflow":"auto"});
    } else {
        $(".table").css({"display": "inline-block", "max-height": "100%","overflow":"auto"});
    }
    // $.ajax({
    //     type:'get',
    //     url:'/ajax/cek/data/from',
    //     success:function(data) {
    //         if(data['new'] == true){
    //             $("#news").prop('disabled', false);
    //             $("#replacement").prop('disabled', true);
    //             $("#renewal").prop('disabled', true);
    //         }
    //         if(data['replacement'] == true){
    //             $("#news").prop('disabled', true);
    //             $("#replacement").prop('disabled', false);
    //             $("#renewal").prop('disabled', true);
    //         }
    //         if(data['renewal'] == true){
    //             $("#news").prop('disabled', true);
    //             $("#replacement").prop('disabled', true);
    //             $("#renewal").prop('disabled', false);
    //         }
    //         if(data['new'] == false && data['replacement'] == false && data['renewal'] == false){
    //             $("#news").prop('disabled', true);
    //             $("#replacement").prop('disabled', true);
    //             $("#renewal").prop('disabled', true);
    //         }
    //     }
    // });

    $(document).ready(function() {
        $(".default_hidden").hide();
        function CekUseBrowser () {
            let userAgent = navigator.userAgent;
            let browserName;

            if(userAgent.match(/chrome|chromium|crios/i)){
                browserName = "chrome";
            }else if(userAgent.match(/firefox|fxios/i)){
                browserName = "firefox";
            }  else if(userAgent.match(/safari/i)){
                browserName = "safari";
            }else if(userAgent.match(/opr\//i)){
                browserName = "opera";
            } else if(userAgent.match(/edg/i)){
                browserName = "edge";
            }else{
                browserName="No browser detection";
            }
            return browserName;
        }
        if (CekUseBrowser() =='chrome') {
            // Check Chorem
            function getChromeVersion() {
                var raw = navigator.userAgent.match(/Chrom(e|ium)\/([0-9]+)\./);

                return raw ? parseInt(raw[2], 10) : false;
                // return 101;
            }

            if (getChromeVersion() < {!!  json_encode(version_chrome) !!}) {
                // swal("Attention!", "Please update your browser OS. Please logout", "error")
                // setTimeout(function(){
                //     document.getElementById('logout-form').submit()
                // }, 2000); //Time before execution
                var str = "Please update your browser OS\n" +
                    "Click OK button to log out\n";
                swal("Attention!", str, "error")
                    .then((value) => {
                        if (value) {
                            document.getElementById('logout-form').submit()
                        }
                    });
            }
            // End Check Chorem
        }
        // Application type
        Remove_course();

        $("#news").click(function() {
            $("#replacement").prop('checked', false);
            $("#renewal").prop('checked', false);

            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#replacement").addClass('btn-secondary').removeClass('btn-danger ');
            $("#renewal").addClass('btn-secondary').removeClass('btn-danger ');
            Remove_course();
            // RemoveDissableRequest();
            check_card_new();
            // $("#app_type").val(document.getElementById("news").value);
            $("#app_type").val($('input[name="app_type"]:checked').val());
            $("#new_click").val(true);
            $("#replacement_click").val(false);
            $("#renewal_click").val(false);
        });
        $("#replacement").click(function() {
            $("#news").prop('checked', false);
            $("#renewal").prop('checked', false);

            // $('#Modalreplacement').modal('show');
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#news").addClass('btn-secondary').removeClass('btn-danger ');
            $("#renewal").addClass('btn-secondary').removeClass('btn-danger ');
            // RemoveDissableRequest();
            Remove_course();
            check_card_replacement();
            $("#replacement_click").val(true);
            $("#new_click").val(false);
            $("#renewal_click").val(false);
            // $("#app_type").val(document.getElementById("replacement").value);
            $("#app_type").val($('input[name="app_type"]:checked').val());

            // $( "#personal_particular" ).submit();
        });
        $("#renewal").click(function() {

            $("#news").prop('checked', false);
            $("#replacement").prop('checked', false);

            // $('#Modalrenewal').modal('show');
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#news").addClass('btn-secondary').removeClass('btn-danger ');
            $("#replacement").addClass('btn-secondary').removeClass('btn-danger ');
            // RemoveDissableRequest();
            Remove_course();
            check_card_renewal();
            $("#renewal_click").val(true);
            $("#new_click").val(false);
            $("#replacement_click").val(false);
            $("#app_type").val(document.getElementById("renewal").value);
            // $( "#personal_particular" ).submit();
        });
        // End Application type

        // card
        $("#so_app").click(function() {
            // $(this).addClass('btn-danger').removeClass('btn-secondary ');
            // $("#avso_app").addClass('btn-secondary').removeClass('btn-danger ');
            // $("#pi_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#card").val(document.getElementById("so_app").value);

            // $("#app_type").val($(this).attr("data-app_type"));

            $("#card").val($(this).attr("data-card"));
            $( "#personal_particular" ).submit();
        });
        $("#avso_app").click(function() {
            // $(this).addClass('btn-danger').removeClass('btn-secondary ');
            // $("#so_app").addClass('btn-secondary').removeClass('btn-danger ');
            // $("#pi_app").addClass('btn-secondary').removeClass('btn-danger ');
            // $("#app_type").val($(this).attr("data-app_type"));
            $("#card").val($(this).attr("data-card"));
            // if($("#new_click").val() == "true"){
            //     $( "#personal_particular" ).submit();
            // }
            // if($("#replacement_click").val() == "true"){

            if($(this).attr("data-app_type") == {!!  json_encode(news) !!}){
                document.getElementById('personal_particular').action = 'personal/particular';
            }else if($(this).attr("data-app_type") == {!!  json_encode(replacement) !!}){
                document.getElementById('personal_particular').action = 'replacement/personal/particular';
            }else if($(this).attr("data-app_type") == {!!  json_encode(renewal) !!}){
                document.getElementById('personal_particular').action = 'renewal/personal/particular';
            }
            $("#personal_particular" ).submit();
            // }
            // if($("#renewal_click").val() == "true"){
            //     document.getElementById('personal_particular').action = 'renewal/personal/particular';
            //     $("#personal_particular" ).submit();
            // }
        });
        $("#pi_app").click(function() {
            // $(this).addClass('btn-danger').removeClass('btn-secondary ');
            // $("#so_app").addClass('btn-secondary').removeClass('btn-danger ');
            // $("#avso_app").addClass('btn-secondary').removeClass('btn-danger ');
            // $("#app_type").val($(this).attr("data-app_type"));
            $("#card").val($(this).attr("data-card"));
            // if($("#new_click").val() == "true"){
            //     $( "#personal_particular" ).submit();
            // }
            // if($("#replacement_click").val() == "true"){
                if($(this).attr("data-app_type") == {!!  json_encode(news) !!}){
                    document.getElementById('personal_particular').action = 'personal/particular';
                }else if($(this).attr("data-app_type") == {!!  json_encode(replacement) !!}){
                    document.getElementById('personal_particular').action = 'replacement/personal/particular';
                }else if($(this).attr("data-app_type") == {!!  json_encode(renewal) !!}){
                    document.getElementById('personal_particular').action = 'renewal/personal/particular';
                }
                $("#personal_particular" ).submit();
            // }
            // if($("#renewal_click").val() == "true"){
            //     document.getElementById('personal_particular').action = 'renewal/personal/particular';
            //     $("#personal_particular" ).submit();
            // }
        });
        $("#PWM").click(function() {
            window.location.href = "{{URL::to('super/user/update_so')}}"
        });
            // End card
    });

    function Remove_course() {
        $("#so_app").prop("disabled", true).css('appearance', 'auto');
        $("#avso_app").prop( "disabled",true).css('appearance', 'auto');
        $("#pi_app").prop("disabled", true).css('appearance', 'auto');
    }

    function add_course() {
        $("#so_app").prop("disabled", false);
        $("#avso_app").prop( "disabled",false);
        $("#pi_app").prop("disabled", false);
    }
    function check_card_new() {
        {!!  json_encode($new) !!}.forEach((entry) => {
            if(entry['Status_app'] == null) {
                if (entry['card_id'] == {!!  json_encode(so_app) !!}) {
                    $("#so_app").prop("disabled", false).css({'-webkit-appearance': 'none',
                    '-moz-appearance': 'none',
                    'appearance': 'none',
                    /* Styling checkbox */
                    'width': '16px',
                    'height': '16px',
                    'background-color': 'green'});
                        $(".view_checkbox_so").css("display","block");
                        $(".view_checkbox_avso").css("display","none");
                } else if (entry['card_id'] == {!!  json_encode(avso_app) !!}) {
                    $("#avso_app").prop("disabled", false).css({'-webkit-appearance': 'none',
                        '-moz-appearance': 'none',
                        'appearance': 'none',
                        /* Styling checkbox */
                        'width': '16px',
                        'height': '16px',
                        'background-color': 'green'});
                        $(".view_checkbox_so").css("display","none");
                        $(".view_checkbox_avso").css("display","block");
                } else if (entry['card_id'] == {!!  json_encode(pi_app) !!}) {
                    $("#pi_app").prop("disabled", false).css({'-webkit-appearance': 'none',
                        '-moz-appearance': 'none',
                        'appearance': 'none',
                        /* Styling checkbox */
                        'width': '16px',
                        'height': '16px',
                        'background-color': 'green'});
                }
            }
        });
    }
    function check_card_replacement() {
        {!!  json_encode($replacement) !!}.forEach((entry) => {
            {{--if(entry['Status_app'] == {!!  json_encode(completed) !!} && {!!  json_encode($expried_replacement) !!} == false ) {--}}
                if (entry['card_id'] == {!!  json_encode(so_app) !!}) {
                    $("#so_app").prop("disabled", false);
                } else if (entry['card_id'] == {!!  json_encode(avso_app) !!}) {
                    $("#avso_app").prop("disabled", false);
                } else if (entry['card_id'] == {!!  json_encode(pi_app) !!}) {
                    $("#pi_app").prop("disabled", false);
                }
            // }
        });
    }
    function check_card_renewal() {
        {!!  json_encode($renewal) !!}.forEach((entry) => {
            {{--if(  entry['Status_app'] == {!!  json_encode(completed) !!} && {!!  json_encode($expried_renewal) !!} == true) {--}}
                if (entry['card_id'] == {!!  json_encode(so_app) !!}) {
                    $("#so_app").prop("disabled", false);
                } else if (entry['card_id'] == {!!  json_encode(avso_app) !!}) {
                    $("#avso_app").prop("disabled", false);
                } else if (entry['card_id'] == {!!  json_encode(pi_app) !!}) {
                    $("#pi_app").prop("disabled", false);
                }
            // }
        });
    }
    function RemoveDissableRequest() {
        //remove disable request
        $.ajax({
            type:'get',
            // url:'/ajax/cek/card/type',
            url:"{{ url('/ajax/super/user/cek/card/type') }}",
            success:function(data) {
              if(data['so_app'] == true){
                  if(data['so_app'] == true && data['avso_app'] == true && data['pi_app'] == true){

                  }else if(data['so_app'] == true && data['avso_app'] == true){
                      $("#pi_app").prop("disabled", false);
                  }else if(data['so_app'] == true && data['pi_app'] == true){
                      $("#avso_app").prop("disabled", false);
                  }else{
                      $("#avso_app").prop("disabled", false);
                     $("#pi_app").prop("disabled", false);
                  }
              }else if(data['avso_app'] == true){
                    if(data['avso_app'] == true && data['pi_app'] == true){
                        $("#so_app").prop("disabled", false);
                    }else{
                        $("#pi_app").prop("disabled", false);
                        $("#so_app").prop("disabled", false);
                    }
              }else if(data['pi_app'] == true){
                  $("#avso_app").prop("disabled", false);
                  $("#so_app").prop("disabled", false);
              }else{
                  $("#pi_app").prop("disabled", false);
                  $("#avso_app").prop("disabled", false);
                  $("#so_app").prop("disabled", false);
              }

            }
        });
        //end remove disable request


        //remove disable request
        // $("#avso_app").prop("disabled", false);
        // $("#pi_app").prop("disabled", false);
        // $("#so_app").prop("disabled", false);
        //end remove disable request
    }
</script>
@endsection
