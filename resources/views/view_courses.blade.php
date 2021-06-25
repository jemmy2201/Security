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
        <a href="javascript:history.go(-1)" style="text-decoration:none;">
        <button class="btn btn-light" style="border-style: groove; background: #E5E5E5; color: #E31D1A">
         <img src="{{URL::asset('/img/back.png')}}" style="width: 20%;"> Back
        </button>
        </a>
        {{--        </center>--}}
        <h2 style="color: #E31E1A;">View Course
        </h2>
        <br>
        {{-- Desktop --}}
        <h4><b>Details</b></h4>

        <div class="container">
            <div class="row hidden-xs">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$courses->nric}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$courses->name}}</div>

                    </div>
                </div>
                <div class="col-sm-0">
                </div>
                <br class="visible-xs hidden-md">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">Pass ID No &ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$courses->passid}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&nbsp;&nbsp;&nbsp;:</div>
                        @if ($request->card == so_app)
                            @if(!empty($cek_grade) && $cek_grade->grade_id== so)
                                <div class="col-4 ColoumndataPersonal">SO</div>
                            @elseif(!empty($cek_grade) && $cek_grade->grade_id == sso)
                                <div class="col-4 ColoumndataPersonal">SSO</div>
                            @elseif(!empty($cek_grade) && $cek_grade->grade_id== ss)
                                <div class="col-4 ColoumndataPersonal">SS</div>
                            @elseif(!empty($cek_grade) && $cek_grade->grade_id== sss)
                                <div class="col-4 ColoumndataPersonal">SSS</div>
                            @elseif(!empty($cek_grade) && $cek_grade->grade_id== cso)
                                <div class="col-4 ColoumndataPersonal">CSO</div>
                            @else
                                <div class="col-4 ColoumndataPersonal">SO</div>
                            @endif
                        @elseif($request->card == avso_app)
                            <div class="col-4 ColoumndataPersonal">NA</div>
                        @else
                            <div class="col-4 ColoumndataPersonal">NA</div>
                        @endif
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Expiry Date&ensp;&nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">@php echo Carbon\Carbon::createFromFormat('Y-m-d', $courses->passexpirydate)->format('d-m-Y') @endphp</div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="container">
            <div class="row hidden-xs">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">Status &ensp;&ensp;&ensp;&ensp;&nbsp:</div>
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
                        <div class="col-0 HeaderdataPersonal">Invoice &ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$courses->receiptNo}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Payment &ensp;&ensp;&nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">
                            @if($courses->status_payment == paid)
                                Paid
                            @else
                                UnPaid
                            @endif
                        </div>
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
                        <div class="col-0 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->nric}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->name}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&nbsp;&nbsp;:</div>
                        @if ($request->card == so_app)
                            @if(!empty($cek_grade) && $cek_grade->grade_id== so)
                                <div class="col-4 ColoumndataPersonal">SO</div>
                            @elseif(!empty($cek_grade) && $cek_grade->grade_id== sso)
                                <div class="col-4 ColoumndataPersonal">SSO</div>
                            @elseif(!empty($cek_grade) && $cek_grade->grade_id== ss)
                                <div class="col-4 ColoumndataPersonal">SS</div>
                            @elseif(!empty($cek_grade) && $cek_grade->grade_id== sss)
                                <div class="col-4 ColoumndataPersonal">SSS</div>
                            @elseif(!empty($cek_grade) && $cek_grade->grade_id== cso)
                                <div class="col-4 ColoumndataPersonal">CSO</div>
                            @else
                                <div class="col-4 ColoumndataPersonal">SO</div>
                            @endif
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
                        <div class="col-0 HeaderdataPersonal">Pass ID No &ensp;:</div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->passid}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Expiry Date&ensp;&nbsp;:</div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->passexpirydate}}</div>
                    </div>
                </div>
            </div>
            <br class="visible-xs hidden-md">
            <div class="col-sm">
                <div class="container">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">Invoice &ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->receiptNo}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Payment&ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-6 ColoumndataPersonal">
                            @if($courses->status_payment == paid)
                                Paid
                            @else
                                UnPaid
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <br class="visible-xs hidden-md">
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
        </div>
        {{-- End Phone --}}


    <script type="application/javascript">
        $(window).bind('resize', function(e)
        {
            this.location.reload(false); /* false to get page from cache */
            /* true to fetch page from server */
        });
    </script>
@endsection
