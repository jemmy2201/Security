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
{{--        <img class="hidden-xs" src="{{URL::asset('/img/img_step_proses/3.png')}}" style="width: 100%; margin-bottom: 20px;">--}}
{{--        <center class="visible-xs hidden-md">--}}
{{--            <img  src="{{URL::asset('/img/img_step_proses/design_phone/3.png')}}" style="width: 80%;">--}}

{{--        <a href="javascript:history.go(-1)" style="text-decoration:none;">--}}
{{--        <button class="btn btn-light" style="border-style: groove; background: #E5E5E5; color: #E31D1A">--}}
{{--         <img src="{{URL::asset('/img/back.png')}}" style="width: 20%;"> Back--}}
{{--        </button>--}}
{{--        </a>--}}

        {{--        </center>--}}
        <h2 style="color: #E31E1A;">ID Card Application Details
        </h2>
        <br>
        {{-- Desktop --}}
        <h4><b>Details</b></h4>

        <div class="container">
            <div class="row hidden-xs">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">NRIC/FIN&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        @php
                            $cutnric = substr($courses->nric, -4);
                            $nric = "XXXXX$cutnric";
                        @endphp
                        <div class="col-4 ColoumndataPersonal">{{$nric}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        @if (strlen($courses->name) > 40)
                            <div class="col-4 ColoumndataPersonal hidden-xs">
                                <textarea rows="4" cols="30" id="TextAreaName" style="resize: none;" readonly>
                                {{$courses->name}}
                                </textarea>
                            </div>
                        @else
                            <div class="col-4 ColoumndataPersonal">{{$courses->name}}</div>
                        @endif
{{--                        <div class="col-4 ColoumndataPersonal">{{$courses->name}}</div>--}}
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal"> Mobile No&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$courses->mobileno}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal"> Home No&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$courses->homeno}}</div>

                    </div>
                </div>
                <div class="col-sm-0">
                </div>
                <br class="visible-xs hidden-md">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">Pass ID No &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$courses->passid}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Card Type &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">
                            @if($courses->card_id == so_app)
                                SO
                            @elseif($courses->card_id == avso_app)
                                AVSO
                            @elseif($courses->card_id == pi_app)
                                PI
                            @endif
                        </div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;&nbsp;&nbsp;:</div>
                        @if ($request->card == so_app)
                            @foreach($t_grade as $index =>$f)
                                @if(!empty($courses) && $courses->grade_id== $f->id)
                                    <div class="col-4 ColoumndataPersonal">{{$f->name}}</div>
{{--                            @if(!empty($course) && $course->grade_id== so)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SO</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id == sso)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SSO</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== ss)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SS</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== sss)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SSS</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== cso)--}}
{{--                                <div class="col-4 ColoumndataPersonal">CSO</div>--}}
{{--                            @else--}}
{{--                                <div class="col-4 ColoumndataPersonal">SO</div>--}}
                                @endif
                            @endforeach
                        @elseif($request->card == avso_app)
                            <div class="col-4 ColoumndataPersonal">NA</div>
                        @else
                            <div class="col-4 ColoumndataPersonal">NA</div>
                        @endif
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Card Expiry Date&ensp;&nbsp;:</div>
                        @if(!empty( $courses->passexpirydate))
                        <div class="col-4 ColoumndataPersonal">{{$courses->passexpirydate}}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="container">
            <div class="row hidden-xs">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">Status &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">
                            @if($courses->Status_app == draft)
                                <td>Draft</td>
                            @elseif($courses->Status_app == submitted)
                                <td>Submitted (Payment Done)</td>
                            @elseif($courses->Status_app == processing)
                                <td>Processing</td>
                            @elseif($courses->Status_app == id_card_ready_for_collection)
                                <td>ID Card Ready for Collection</td>
                            @elseif($courses->Status_app == resubmission)
                                <td>Resubmission</td>
                            @elseif($courses->Status_app == completed)
                                <td>Completed</td>
                            @endif
                        </div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Receipt &nbsp;No&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$courses->receiptNo}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Payment Amount&ensp;&ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">${{$courses->grand_total}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Appointment Date &nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{Carbon\Carbon::parse($courses->appointment)->format('d-m-Y')}}</div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Payment &ensp;&ensp;&nbsp;:</div>--}}
{{--                        <div class="col-4 ColoumndataPersonal">--}}
{{--                            @if($courses->status_payment == paid)--}}
{{--                                Paid--}}
{{--                            @else--}}
{{--                                UnPaid--}}
{{--                            @endif--}}
{{--                        </div>--}}
                        <div class="w-100"></div>
                        @if ($request->card == so_app)
                            <br>
                        <div class="col-0 HeaderdataPersonal">Courses &ensp;&ensp;&ensp;:</div>
                        <div class="col-8 ColoumndataPersonal">
                            @foreach (json_decode($courses->array_grade) as $f)
                                @php $data = DB::table('grades')->where(['id'=>$f])->get();@endphp
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <img src="{{URL::asset('/img/rounded .png')}}" style="width:5px;">
                                        {{$data[0]->name}}
                                    </li>
                                </u>
                            @endforeach

                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-0">
                </div>
                <br class="visible-xs hidden-md">
            </div>
        </div>
        {{-- End Desktop --}}

        {{-- Phone --}}
        <div class="row visible-xs hidden-md">
            <div class="col-sm">
                <div class="container">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">NRIC/FIN&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->nric}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Name&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                        @if (strlen($courses->name) > 40)
                            <div class="col-6 ColoumndataPersonal ">
                                 <textarea rows="4" cols="18" id="TextAreaNamePhone" style="resize: none;" readonly>
                                {{$courses->name}}
                                </textarea>
{{--                                {{substr($courses->name,0,20)}}<br>{{substr($courses->name,20,20)}}<br>{{substr($courses->name,40,20)}}<br>{{substr($courses->name,60,20)}}<br>--}}
                            </div>
                        @else
                            <div class="col-6 ColoumndataPersonal">{{$courses->name}}</div>
                        @endif
{{--                        <div class="col-6 ColoumndataPersonal">{{$courses->name}}</div>--}}
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Mobile No &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->mobileno}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Home No&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->homeno}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Status &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        <div class="col-6 ColoumndataPersonal">
                            @if($courses->Status_app == draft)
                                Draft
                            @elseif($courses->Status_app == submitted)
                                Submitted (Payment Done)
                            @elseif($courses->Status_app == processing)
                                Processing
                            @elseif($courses->Status_app == id_card_ready_for_collection)
                                ID Card Ready for Collection
                            @elseif($courses->Status_app == resubmission)
                                Resubmission
                            @elseif($courses->Status_app == completed)
                                Completed
                            @endif
                        </div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Card Type &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-6 ColoumndataPersonal">
                            @if($courses->card_id == so_app)
                                SO
                            @elseif($courses->card_id == avso_app)
                                AVSO
                            @elseif($courses->card_id == pi_app)
                                PI
                            @endif</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        @if ($request->card == so_app)
                            @foreach($t_grade as $index =>$f)
                            @if(!empty($courses) && $courses->grade_id== $f->id)
                                    <div class="col-4 ColoumndataPersonal">{{$f->name}}</div>
{{--                            @if(!empty($course) && $course->grade_id== so)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SO</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== sso)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SSO</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== ss)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SS</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== sss)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SSS</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== cso)--}}
{{--                                <div class="col-4 ColoumndataPersonal">CSO</div>--}}
{{--                            @else--}}
{{--                                <div class="col-4 ColoumndataPersonal">SO</div>--}}
                                @endif
                            @endforeach
                        @elseif($request->card == avso_app)
                            <div class="col-6 ColoumndataPersonal">NA</div>
                        @else
                            <div class="col-6 ColoumndataPersonal">NA</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm">
            </div>
            <br class="visible-xs hidden-md">
            <div class="col-sm">
                <div class="container">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">Pass ID No &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->passid}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Card Expiry Date&ensp;&nbsp;:</div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->passexpirydate}}</div>
                    </div>
                </div>
            </div>
            <br class="visible-xs hidden-md">
            <div class="col-sm">
                <div class="container">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">Receipt No&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->receiptNo}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Payment Amount&ensp;&ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">${{$courses->grand_total}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Appointment Date &nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{Carbon\Carbon::parse($courses->appointment)->format('d-m-Y')}}</div>
                        <div class="w-100"></div>
                    </div>
                </div>
            </div>
            <br class="visible-xs hidden-md">
            @if ($request->card == so_app)
            <div class="col-sm">
                <div class="container">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">Courses &ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-12 ColoumndataPersonal">
                            @foreach (json_decode($courses->array_grade) as $f)
                                @php $data = DB::table('grades')->where(['id'=>$f])->get();@endphp
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <img src="{{URL::asset('/img/rounded .png')}}" style="width:5px;">
                                        {{$data[0]->name}}
                                    </li>
                                    </u>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            @endif
        </div>
        {{-- End Phone --}}
        <br>
        <div class="row">
            <div class="col-2 back">
                <button type="submit" class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: #E5E5E5; color: #E31D1A"> <a href="{{url("/home")}}" style="text-decoration:none;"><img src="{{URL::asset('/img/back.png')}}" style="width: 10%;"> Back</a> </button>
            </div>
            <div class="col-8 medium hidden-xs">
            </div>
            <div class="col-6 medium visible-xs hidden-md">
            </div>
            <div class="col-2 next">
                <a href="{{ url('invoice/print/pdf/'.$request->card) }}" target="_blank" style="text-decoration: none;"><button type="button" id="click_personal_particular" class=" btn btn-danger btn-lg btn-block">Print PDF</button></a>
            </div>
        </div>

    <script type="application/javascript">
        $(window).bind('resize', function(e)
        {
            this.location.reload(false); /* false to get page from cache */
            /* true to fetch page from server */
        });
        if($(window).width() < 767)
        {
            RemoveColNextBack();
            $(".back").addClass("col-4");
            $(".medium").addClass("col-4");
            $(".next").addClass("col-4");

            $(".email").css("font-size", "20px");
            $(".phone").css("font-size", "20px");
        }
        function RemoveColNextBack() {
            $(".back").removeClass("col-2");
            $(".medium").removeClass("col-6");
            $(".next").removeClass("col-2");
        }
    </script>
@endsection
