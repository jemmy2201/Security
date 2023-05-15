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
    @media (min-width :768px) {
        .modal-dialog {
             width: 968px !important;
         }
        .not_photo_selfie {
            width: 600px !important;
            margin: 30px auto !important;
        }
        .ExpiredCard {
            width: 600px !important;
            margin: 30px auto !important;
        }
        #view_terms {
            width: 900px;
        }
        #ViewFormUploadFile{
            margin-top: 225px;
        }
    }
    @media (min-width :576px) {
        .not_photo_selfie {
            width: 600px !important;
            margin: 30px auto !important;
        }
        .ExpiredCard {
            width: 400px !important;
            margin: 30px auto !important;
        }
        .modal-dialog {
            max-width: 930px !important;
        }
        #view_terms {
            width: 900px;
        }

    }

    @media only screen and (max-width: 600px) {
        #view_terms {
            width: 300px;
        }
    }
</style>
@section('content')
<div class="container submission">
    <img class="hidden-xs" src="{{URL::asset('/img/img_step_proses/3.png')}}" style="width: 100%; margin-bottom: 20px;">
    <center class="visible-xs hidden-md">
        <img  src="{{URL::asset('/img/img_step_proses/design_phone/3.png')}}" style="width: 80%;">
    </center>
    <h2 style="color: Black;"><b>Submission</b></h2>
    <br>
        {{-- Desktop --}}
    <h3 style="font-size: 20px;"><b>Details</b></h3>

    <div class="container">
            <div class="row hidden-xs">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                        @php
                            $cutnric = substr(secret_decode($personal->nric), -4);
                            $nric = "XXXXX$cutnric";
                        @endphp
                        <div class="col-4 ColoumndataPersonal">{{$nric}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        @if (strlen($personal->name) > 40)
                            <div class="col-8 ColoumndataPersonal">
                                <textarea rows="4" cols="30" id="TextAreaName" style="resize: none;border: none;" readonly>
                                {{$personal->name}}
                                </textarea>
                            </div>
                        @else
                            <div class="col-8 ColoumndataPersonal">{{$personal->name}}</div>
                        @endif


                    </div>
                </div>
                <div class="col-sm-0">
                </div>
                <br class="visible-xs hidden-md">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">Application Type &ensp;&nbsp;:</div>
                        <div class="col-6 ColoumndataPersonal">
                            @if($personal->app_type == news )
                                @if($personal->app_type == news && isset($take_sertifikat) && $take_sertifikat->app_type == news)
                                    Replacement
                                @else
                                    New
                                @endif
                            @endif
                            @if($personal->app_type == replacement )
                                    Replacement
                            @endif
                            @if($personal->app_type == renewal )
                                    Renewal
                            @endif
                            -
                            @if($request->card == so_app)
                                SO
                            @elseif($request->card == avso_app)
                                AVSO
                            @elseif($request->card == pi_app)
                                PI
                            @endif
                        </div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Pass ID No &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
{{--                        @if($personal->card_id == avso_app || $personal->card_id == pi_app)--}}
                        <div class="col-4 ColoumndataPersonal">{{substr($personal->passid, 0, -2)}}</div>
{{--                        @else--}}
{{--                        <div class="col-4 ColoumndataPersonal">{{$personal->passid}}</div>--}}
{{--                        @endif--}}
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;&nbsp;&nbsp;:</div>
                        @if ($request->card == so_app)
                            @foreach($t_grade as $index =>$f)
                            @if(!empty($cek_grade) && $cek_grade->grade_id== $f->id)
                                    <div class="col-4 ColoumndataPersonal">{{$f->name}}</div>
{{--                        @if(!empty($booking_schedule) && $booking_schedule->grade_id== so)--}}
{{--                               <div class="col-4 ColoumndataPersonal">SO</div>--}}
{{--                            @elseif(!empty($cek_grade) && $cek_grade->grade_id == $f->id)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SSO</div>--}}
{{--                            @elseif(!empty($cek_grade) && $cek_grade->grade_id== $f->id)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SS</div>--}}
{{--                            @elseif(!empty($cek_grade) && $cek_grade->grade_id== $f->id)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SSS</div>--}}
{{--                            @elseif(!empty($cek_grade) && $cek_grade->grade_id== $f->id)--}}
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
                        @php
                            if($personal->expired_date){
                                $myDateTime = DateTime::createFromFormat('d/m/Y',$personal->expired_date);
                                $expired_date = $myDateTime->format('d F Y');
                            }
                        @endphp
                        @if(!empty($personal->expired_date))
                        <div class="col-6 ColoumndataPersonal">{{ $expired_date}}</div>
                        @endif
                    </div>
                </div>
            </div>
    </div>
        {{-- End Desktop --}}

        {{-- Phone --}}
            <div class="row visible-xs hidden-md">
            <div class="col-sm">
                <div class="container">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">NRIC/FIN&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp; :</div>
                        <div class="col-6 ColoumndataPersonal">{{$nric}}</div>

                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                    @if (strlen($personal->name) > 40)
{{--                            <div class="col-6 ColoumndataPersonal hidden-xs">{{substr($personal->name,0,40)}}<br>{{substr($personal->name,40)}}</div>--}}
                            <div class="col-2 ColoumndataPersonal visible-xs hidden-md">
                                <textarea rows="4" cols="12" id="TextAreaNamePhone" style="resize: none;border: none;" readonly>
                                {{$personal->name}}
                                </textarea>
{{--                                {{substr($personal->name,0,15)}}<br>{{substr($personal->name,15,15)}}<br>{{substr($personal->name,30,15)}}<br>{{substr($personal->name,45,15)}}<br>{{substr($personal->name,60,15)}}--}}
                            </div>
                        @else
                        <div class="col-6 ColoumndataPersonal">{{$personal->name}}</div>
                    @endif
                    <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Application Type&ensp;&nbsp; :</div>
                        <div class="col-6 ColoumndataPersonal">@if($personal->app_type == news)
                                New
                            @elseif($personal->app_type == replacement)
                                Replacement
                            @elseif($personal->app_type == renewal)
                                Renewal
                            @endif
                            -
                            @if($request->card == so_app)
                                SO
                            @elseif($request->card == avso_app)
                                AVSO
                            @elseif($request->card == pi_app)
                                PI
                            @endif
                        </div>

                        <div class="w-100"></div>
                    <div class="col-0 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
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
                    <div class="col-0 HeaderdataPersonal">Pass ID No &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
{{--                    @if($personal->card_id == avso_app || $personal->card_id == pi_app)--}}
                    <div class="col-6 ColoumndataPersonal">{{substr($personal->passid, 0, -2)}}</div>
{{--                    @else--}}
{{--                    <div class="col-6 ColoumndataPersonal">{{$personal->passid}}</div>--}}
{{--                    @endif--}}
                    <div class="w-100"></div>
                    <div class="col-0 HeaderdataPersonal">Card Expiry
                        Date&ensp;&nbsp;:</div>
                    @if(!empty($personal->expired_date))
                    <div class="col-6 ColoumndataPersonal">{{ $expired_date}}</div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- End Phone --}}

{{--    <br><br>--}}
    <form method="post" id="book_appointment" action="{{ route('super_user.book.appointment') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="Status_App" id="Status_App" value="{{$request->Status_App}}">
        @if(!empty($request->Cgrade))
            <input type="hidden" name="Cgrade[]" id="Cgrade" value="{{json_encode($request->Cgrade)}}">
        @elseif(empty($request->Cgrade) && !empty($replacement) && $request->card == so_app)
            <input type="hidden" name="Cgrade[]" id="Cgrade" value="{{$replacement->array_grade}}">
        @elseif(empty($request->Cgrade) && $request->card == so_app)
            <input type="hidden" name="Cgrade[]" id="Cgrade" value="{{$cek_grade->array_grade}}">
        @endif
    @if(!empty($grade))
        @if(!empty($view_declare))
            <div class="row">
                <div class="col-4 col_declare1">
                    <h3 style="color: black;font-weight: bold;font-size: 23px;">Declaration of Training Records</h3>
                </div>
{{--                <div class="col-4 col_declare2">--}}
                <div class="col-2 col_declare2">
                    <button type="button" id="button_declare" class=" btn btn-danger btn-lg btn-block">Declare</button>
                </div>
                <div class="col-2 col_declare3">
{{--                    <button type="button" id="button_declare" class=" btn btn-danger btn-lg btn-block">Declare</button>--}}
                </div>
            </div>
            <br>
            <div class="row">
                @foreach ($view_declare as $f)
                    @php $data = DB::table('grades')->where(['id'=>$f])->get();@endphp
                    <div class="col-10">
                        <img src="{{URL::asset('/img/rounded .png')}}" style="width:15px;">
                        <a>{{$data[0]->name}}</a><br>
                        <input type="hidden" name="grade" id="grade" value="{{$data[0]->id}}">
                    </div>
                @endforeach
            </div>
        @else
                @if(empty($resubmission))
{{--                    <div class="row">--}}
{{--                        <div class="col-4 col_declare1">--}}
{{--                            <h3 style="color: black;font-weight: bold;font-size: 23px;">Declaration of Training Records</h3>--}}
{{--                        </div>--}}
{{--                        <div class="col-2 col_declare2">--}}
{{--                            <button type="button" id="button_declare" class=" btn btn-danger btn-lg btn-block">Declare</button>--}}
{{--                        </div>--}}
{{--                        <div class="col-2 col_declare3">--}}
{{--                            <button type="button" id="button_declare" class=" btn btn-danger btn-lg btn-block">Declare</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <button type="button"  class=" btn btn-danger" style="background: black;">Training Records</button>--}}
                    <h3 style="font-size: 20px;"><b>Training Records</b></h3>
{{--                    <br>--}}
{{--                @if(!empty($cek_grade->array_grade))--}}
{{--                    @foreach (json_decode($cek_grade->array_grade) as $f)--}}
                        @php $data = DB::table('grades')->where(['id'=>$f])->get();@endphp
{{--                        <br>--}}
{{--                        <div class="col-10">--}}
{{--                            <img src="{{URL::asset('/img/rounded .png')}}" style="width:15px;">--}}
{{--                            <a>{{$data[0]->name}}</a><br>--}}
{{--                            @if(!empty($cek_grade))--}}
{{--                                <input type="hidden" name="grade" id="grade" value="{{$cek_grade->grade_id}}">--}}
{{--                                <input type="hidden" name="grade" id="grade" value="{{$data[0]->id}}">--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                        <div class="col-10">--}}
                            <ul class="list-group">
{{--                                @foreach ($take_grades as $f)--}}
{{--                                    @if($f->take_grade)--}}
{{--                                        <li class="list-group"><input class="form-check-input" type="checkbox" checked disabled>&ensp;&ensp; {{$f->name}}</li>--}}
{{--                                        <input class="form-check-input" type="hidden" name="array_grade" id="array_grade" value="{{$request->array_grade}}" >--}}
{{--                                    @elseif($f->display)--}}
{{--                                        <li class="list-group"><input class="form-check-input" type="checkbox" name="Cgrades[]" id="Cgrades" value="{{$f->id}}" disabled>&ensp;&ensp; {{$f->name}}</li>--}}
{{--                                    @elseif($f->grade_not_payment)--}}
{{--                                        <li class="list-group"><input class="form-check-input" type="checkbox" name="Cgrades[]" id="Cgrades" value="{{$f->id}}" checked>&ensp;&ensp; {{$f->name}}</li>--}}
{{--                                    @else--}}
{{--                                        <li class="list-group"><input class="form-check-input" type="checkbox" name="Cgrades[]" id="Cgrades" value="{{$f->id}}" >&ensp;&ensp; {{$f->name}}</li>--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}

                                {{-- SO And AVSO join  --}}
                                @foreach ($take_grades as $f)
                                    @if($f->not_payment == true)
                                        <li class="list-group"><input class="form-check-input" type="checkbox" name="Cgrades[]" id="Cgrades" value="{{$f->short_value}}" checked>&ensp;&ensp; {{$f->name}}</li>
{{--                                        <li class="list-group"><input class="form-check-input" type="checkbox" checked disabled>&ensp;&ensp; {{$f->name}}</li>--}}
{{--                                        <input class="form-check-input" type="hidden" name="array_grade" id="array_grade" value="{{$request->array_grade}}" >--}}
                                    @elseif($f->payment == true)
                                        <li class="list-group"><input class="form-check-input" type="checkbox" checked disabled>&ensp;&ensp; {{$f->name}}</li>
{{--                                    @elseif($f->grade_not_payment)--}}
{{--                                        <li class="list-group"><input class="form-check-input" type="checkbox" name="Cgrades[]" id="Cgrades" value="{{$f->id}}" checked>&ensp;&ensp; {{$f->name}}</li>--}}
                                    @else
                                        <li class="list-group"><input class="form-check-input" type="checkbox" name="Cgrades[]" id="Cgrades" value="{{$f->short_value}}" >&ensp;&ensp; {{$f->name}}</li>
                                    @endif
                                @endforeach
                                {{-- SO And AVSO join  --}}

                                <li class="list-group"><input class="form-check-input" type="checkbox" name="Cgrades[]" id="Cgrades" value="false" >&ensp;&ensp; None of the above (SO)</li>
                            </ul>
{{--                            <input type="checkbox" id="declare" name="declare" style="margin-left: 15px;">&ensp;&ensp;--}}
{{--                                <b>I declare that I have been assessed and certified in the following training modules</b>--}}
                            {{--                        </div>--}}
{{--                    @endforeach--}}
{{--                    @endif--}}

{{--                    @if(!empty($replacement))--}}
{{--                        @foreach (json_decode($replacement->array_grade) as $f)--}}
{{--                            @php $data = DB::table('grades')->where(['id'=>$f])->get();@endphp--}}
{{--                            <div class="col-10">--}}
{{--                                <img src="{{URL::asset('/img/rounded .png')}}" style="width:15px;">--}}
{{--                                <a>{{$data[0]->name}}</a><br>--}}
{{--                                @if(!empty($cek_grade))--}}
{{--                                    <input type="hidden" name="grade" id="grade" value="{{$cek_grade->grade_id}}">--}}
{{--                                    <input type="hidden" name="grade" id="grade" value="{{$data[0]->id}}">--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    @endif--}}
                @else
                    <div class="row">
                        <div class="col-4 col_declare1">
{{--                            <h3 style="color: black;font-weight: bold;font-size: 23px;">Declaration of Training Records</h3>--}}
                        </div>
                        <div class="col-2 col_declare2">
                        </div>
                        <div class="col-2 col_declare3">
{{--                            <button type="button" id="button_declare" class=" btn btn-danger btn-lg btn-block">Declare</button>--}}
                        </div>
                    </div>
                    <div class="row" >
                        @if(!empty(json_decode($data_resubmission->array_grade)) )
                        @foreach (json_decode($data_resubmission->array_grade) as $f)
                            @php $data = DB::table('grades')->where(['id'=>$f])->get();@endphp
                            <div class="col-10">
                                <img src="{{URL::asset('/img/rounded .png')}}" style="width:15px;">
                                <a>{{$data[0]->name}}</a><br>
                                @if(!empty($cek_grade))
                                    <input type="hidden" name="grade" id="grade" value="{{$cek_grade->grade_id}}">
                                    <input type="hidden" name="grade" id="grade" value="{{$data[0]->id}}">
                                @endif
                            </div>
                        @endforeach
                        @endif
                    </div>
                @endif

                {{--         just view one delcare--}}
{{--                <div class="row" id="view_declare">--}}
{{--                    <div class="col-10" >--}}
{{--                        <img src="{{URL::asset('/img/rounded .png')}}" style="width:15px;">--}}
{{--                        <a id="text_declare"></a>--}}
{{--                        <input type="hidden" name="grade" id="grade">--}}
{{--                    </div>--}}
{{--                </div>--}}
                {{--         end just view one delcare--}}
        @endif
    @elseif(!empty($replacement) && $request->card == so_app)
            <div class="row">
                <div class="col-4 col_declare1">
                    <h3 style="color: black;font-weight: bold;font-size: 23px;">Declaration of Training Records</h3>
                </div>
{{--                <div class="col-4 col_declare2">--}}
                <div class="col-2 col_declare2">
                    <button type="button" id="button_declare" class=" btn btn-danger btn-lg btn-block">Declare</button>
                </div>
                <div class="col-2 col_declare3">
{{--                    <button type="button" id="button_declare" class=" btn btn-danger btn-lg btn-block">Declare</button>--}}
                </div>
            </div>
            <br>
            <div class="row" >
                @foreach (json_decode($replacement->array_grade) as $f)
                    @php $data = DB::table('grades')->where(['id'=>$f])->get();@endphp
                    <div class="col-10">
                        <img src="{{URL::asset('/img/rounded .png')}}" style="width:15px;">
                        <a>{{$data[0]->name}}</a><br>
                        @if(!empty($cek_grade))
                        <input type="hidden" name="grade" id="grade" value="{{$cek_grade->grade_id}}">
                        <input type="hidden" name="grade" id="grade" value="{{$data[0]->id}}">
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
{{--    <br>--}}
    <h3 style="color: black;font-weight: bold;">
{{--        <button type="button" class=" btn btn-danger" style="background: black;">Photo Submission</button>--}}
        <h3 style="font-size: 20px;"><b>Photo Submission</b></h3>
        <br>
    </h3>
        <button type="button" class="btn btn-secondary  file_upload_profiles hidden-xs" style=" border: 2px solid black;position: absolute;
    margin-left: 27px;">Upload Photo</button>
        <button type="button" class="btn btn-secondary  file_upload_profiles visible-xs hidden-md" style=" border: 2px solid black;position: absolute;">Upload Photo</button>
    <br><br>

    <div class="row">
        <div class="col-2 upload_profile" style="margin-top: 10px; border: 1px solid black; padding: 5px 0px 5px 10px; margin-left: 10px;">
            <img class="file_upload_profile"  src="{{URL::asset('/img/upload.png')}}" style="width: 95%; ">
            <center id="info_upload">
                <b>Please Upload Photo</b>
            </center>
            <input type="file" name="upload_profile" id="upload_profile" style="display: none;">
        </div>

{{--        <div class="col-2 hidden-xs" style="border-right: 1px solid black;">--}}
{{--            <ul class="list-group list-group-flush" >--}}
{{--                <li class="list-group-item" style=" border-bottom: 0 none;">--}}
{{--                </li>--}}
{{--                <li class="list-group-item" style="margin-top: 120px;">--}}
{{--                    @if(!empty($grade) || !empty($replacement) && $request->card == so_app)--}}
{{--                        @if(empty($resubmission))--}}
{{--                            <input type="checkbox" id="submit_submission " name="submit_submission">--}}
{{--                            <b>I declare that I have submitted my photo</b>--}}
{{--                        @endif--}}
{{--                    @endif--}}
{{--                </li>--}}
{{--            </ul>--}}

{{--        </div>--}}
        <div class="col-8 hidden-xs">
            <p>Guidelines for Digital Photo Image Submission <i class="fa fa-info-circle fa-lg" data-toggle="modal" data-target="#Photo_guideline" aria-hidden="true" style="color:#800000 !important;"></i></p>
            <p>- Photo must be taken within last 3 months</p>
            <p>- Photo must be taken within even brightness</p>
            <p>- Photo must be clear and in sharp focus</p>
            <p>- Photo must be taken without spectacles</p>
            <p>- Photo background must be white in color</p>
            <p>- Photo must be original form without any alterations</p>
            <p style="margin-left: 10px;">  using computer software(Photoshop) or mobile app</p>
            <p>- Photo uploaded must be in JPG or PNG formats</p>
            <p>- Photo image's size must not more than 5 MB</p>

        </div>
        <div class="col-6 visible-xs hidden-md">
            <p>Guidelines for Digital Photo Image Submission <i class="fa fa-info-circle fa-lg" data-toggle="modal" data-target="#Photo_guideline" aria-hidden="true" style="color:#800000 !important;"></i></p>
            <p>- Photo must be taken within last 3 months</p>
            <p>- Photo must be taken within even brightness</p>
            <p>- Photo must be clear and in sharp focus</p>
            <p>- Photo must be taken without spectacles</p>
            <p>- Photo background must be white in color</p>
            <p>- Photo must be original form without any alterations using computer software(Photoshop) or mobile app</p>
            <p>- Photo uploaded must be in JPG or PNG formats</p>
            <p>- Photo image's size must not more than 5 MB</p>
{{--            <button type="button" class=" btn btn-danger file_upload_profiles" style="background: black;">Upload Photo</button><br>--}}
{{--            @if(!empty($grade) || !empty($replacement) && $request->card == so_app)--}}
{{--                @if(empty($resubmission))--}}
{{--                    <input type="checkbox" id="submit_submission" name="submit_submission">--}}
{{--                    <b>I declare that I have submitted my photo</b>--}}
{{--                @endif--}}
{{--            @endif--}}
        </div>

        <div class="col-2 hidden-xs">
{{--            <button type="button" class=" btn btn-danger btn-lg btn-block file_upload_profiles">Upload Photo</button>--}}
        </div>
        <div class="col visible-xs hidden-md">
{{--            <button type="button"  class=" btn btn-danger btn-lg btn-block file_upload_profiles">Upload Photo</button>--}}
        </div>
    </div>
{{--    <br>--}}
{{--        @if(!empty($grade) || !empty($replacement) && $request->card == so_app)--}}
{{--            @if(empty($resubmission))--}}
{{--                <br class="hidden-xs">--}}
            <ul class="list-group list-group-horizontal " style="margin-top: 20px;">
                <li style="list-style-type: none;" > <input type="checkbox" id="submit_submission " name="submit_submission" ></li>&nbsp;
                <li style="list-style-type: none;text-align: justify;">I hereby declare that the information and photo submitted is true and correct.<br>In case any of the above information is found to be false or untrue or misleading or misrepresenting.<br>I am aware that I may be held liable for it.</li>
            </ul>



{{--            @endif--}}
{{--        @endif--}}
    <br><br class="hidden-xs"><br class="hidden-xs">
    <div class="row">
        <div class="col-2 back">
            <a href="{{ url('super/user/back/personal/particular/'.$request->app_type.'/'.$request->card.'/'.$request->Status_App) }}" style="text-decoration:none;">
                <button type="button" class="btn btn-light btn-lg btn-block" style="border-style: groove; background: black; color: white" >
{{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;"> --}}
                    Back
                </button>
            </a>
        </div>
{{--        <div class="col-6 medium hidden-xs">--}}
{{--        </div>--}}
{{--        <div class="col-6 medium visible-xs hidden-md">--}}
{{--        </div>--}}
        <div class="col-2  hidden-xs">
            <button type="button" class="btn btn-light btn-lg btn-block save_draft" style="border-style: groove; background: black; color: white;">
{{--                <a href="{{url('/super/user/save_draft/'.$request->app_type.'/'.$request->card.'/'.$request->card)}}" style="text-decoration:none; color: white;">--}}
                    {{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
                    Save Draft
{{--                </a>--}}
            </button>
        </div>
        <div class="col-4  visible-xs hidden-md">
            <button class=" btn btn-light btn-lg save_draft" type="button"  style="border-style: groove; background: black; color: white;">
{{--                <a href="{{url('/super/user/save_draft/'.$request->app_type.'/'.$request->card)}}" style="text-decoration:none; color: white;">--}}
                    {{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
                    Save Draft
{{--                </a>--}}
        </div>
        <div class="col-2 next">
{{--            @if(empty($resubmission))--}}
                <button type="button" id="submit_book_appointment" class=" btn btn-danger btn-lg btn-block" style=" background: black; color: white;">
                    Next
{{--                    <img src="{{URL::asset('/img/next.png')}}" style="width: 10%;">--}}
                </button>
{{--            @else--}}
{{--                <button type="button" id="submit_book_appointment" class=" btn btn-danger btn-lg btn-block">Resubmission <img src="{{URL::asset('/img/next.png')}}" style="width: 10%;"></button>--}}
{{--            @endif--}}
        </div>
    </div>
        <input type="hidden" id="app_type" name="app_type" value="{{$request->app_type}}">
        <input type="hidden" id="card" name="card" value="{{$request->card}}">
        <input type="hidden" id="passexpirydate" name="passexpirydate" value="{{$request->passexpirydate}}">
    </form>
</div>

<!-- Modal Photo guideline-->
<div class="modal fade" id="Photo_guideline" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered" role="document" >
        <div class="modal-content" >
            <div class="modal-header">
                {{--                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>--}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src ="{{ asset('/Photo guideline.pdf') }}#toolbar=0"   height="500px;" style="display: block;" id="view_terms"></iframe>
            </div>
            {{--                <div class="modal-footer">--}}
            {{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
            {{--                    <button type="button" class="btn btn-primary">Save changes</button>--}}
            {{--                </div>--}}
        </div>
    </div>
</div>
<!-- End Modal Photo guideline-->

{{-- Reminder photo not selfie--}}
<button data-toggle="modal" data-target="#Form_reminder_photo_not_selfie" style="display: none" id="reminder_photo_not_selfie"></button>
<div class="modal fade" id="Form_reminder_photo_not_selfie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog not_photo_selfie" role="document">
        <div class="modal-content">
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title" id="exampleModalLabel">Reminder !</h5>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                    <span aria-hidden="true">&times;</span>--}}
{{--                </button>--}}
{{--            </div>--}}
            <div class="modal-body">
                <center style="color:red;">
                    <img src="{{ asset("img/Selfies_No.png") }}" style="width: 15%">
                <h3>Reminder !</h3>
                <b>Non-compliance</b> with the photo guideline including<br>
                "selfies" will result in your application being rejected.<br>
                This will delay your ID card collection.
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closesPhotoNotSelfie">Cancel</button>
                <button type="button" class="btn btn-primary" id="next_book_appointment">Continue</button>
            </div>
        </div>
    </div>
</div>
{{-- End Reminder photo not selfie--}}

{{-- Expired Card --}}
<button data-toggle="modal" data-target="#Form_expired_card" style="display: none" id="ExpiredCard"></button>
<div class="modal fade" id="Form_expired_card" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ExpiredCard" role="document">
        <div class="modal-content">
            {{--            <div class="modal-header">--}}
            {{--                <h5 class="modal-title" id="exampleModalLabel">Reminder !</h5>--}}
            {{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
            {{--                    <span aria-hidden="true">&times;</span>--}}
            {{--                </button>--}}
            {{--            </div>--}}
            <div class="modal-body">
                <center >
                    <h4>
                        <i class="fa fa-info-circle fa-2x" aria-hidden="true"></i>&nbsp;
                        <B id="data1"></B><br><br>
                        {{--                                @if(isset($data3))--}}
                        <B>This is due to:</B><br><br>
                        {{--                                @endif--}}
                        <B id="data2"></B><br><br>
                        {{--                                @if(isset($data3))--}}
                        <B id="data3"></B><br><br>
                        {{--                                @endif--}}
                        {{--                                @if(isset($data4))--}}
                        <B id="data4"></B><br><br>
                        {{--                                @endif--}}
                        <B>Contact details as follows:</B>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">- <i class="fa fa-phone" style="font-size: 14px;" aria-hidden="true"><B>&nbsp;&nbsp;{{phone_general_office}} &nbsp;&nbsp; {{phone_CSC}} </i></B></li>
                            <li class="list-group-item" style="margin-top: -8px;">- <i class="fa fa-envelope" style="font-size: 14px;" aria-hidden="true"><B>&nbsp;&nbsp;{{email}}</B></i></li>
                        </ul>

                    </h4>
                    <a href="/">
                        <button type="button" class="btn btn-dark" style="color: white;" data-dismiss="modal">
                            OK
                        </button>
                    </a>
                </center>
            </div>
        </div>
    </div>
</div>
{{-- End Expired Card --}}

@if(!empty($grade))
{{--<div class="container declare">--}}
{{--    <h2 style="color: #E31E1A;">Declare of Training</h2>--}}
{{--    <h3><b>Statement of Attainment for the following modules :</b></h3>--}}
{{--    <div class="row">--}}
{{--        <div class="col-10 select_declare">--}}
{{--            <ul class="list-group">--}}
{{--            @foreach ($grade as $f)--}}
{{--            <li class="list-group-item"><input class="form-check-input" type="radio" name="Cgrade" id="Cgrade" value="{{$f->id}}">&ensp;&ensp; {{$f->name}}</li>--}}
{{--            @endforeach--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <input type="checkbox" id="declare_trainig" name="declare_trainig">&ensp;&ensp;--}}
{{--    <b>I declare that I have been assessed and certified in the following training modules</b>--}}
{{--    <div class="row">--}}
{{--        <div class="col-2 back">--}}
{{--        </div>--}}
{{--        <div class="col-6 medium">--}}
{{--        </div>--}}
{{--        <form method="post" id="delcare_submission" action="{{ route('declare.submission') }}" enctype="multipart/form-data">--}}
{{--            @csrf--}}
{{--            <input type="hidden" id="app_type" name="app_type" value="{{$request->app_type}}">--}}
{{--            <input type="hidden" id="card" name="card" value="{{$request->card}}">--}}
{{--            <input type="hidden" id="array_grade" name="array_grade" value="{{$cek_grade->array_grade}}">--}}
{{--        <div class="col-2 next">--}}
{{--            <button type="button" id="submit_declare_trainig" class=" btn btn-danger btn-lg btn-block">Confirm</button>--}}
{{--        </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--</div>--}}
@elseif(!empty($replacement) && $request->card == so_app)
        <form method="post" id="delcare_submission" action="{{ route('super_user.declare.submission') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="app_type" name="app_type" value="{{$request->app_type}}">
            <input type="hidden" id="card" name="card" value="{{$request->card}}">
        </form>
@endif

<script type="application/javascript">
    $( document ).ready(function() {
        $(".declare").hide();
        $("#view_declare").hide();

        // 15 minutes not action
        setTimeout(RefreshPage, 900000);
        function RefreshPage() {
            window.location.href = "{{URL::to('relogin')}}"
        }
        // End 15 minutes not action

        $("#button_declare" ).click(function() {
            // $(".submission").hide();
            // $(".declare").show();
            $( "#delcare_submission" ).submit();
        });

        $(".save_draft" ).click(function() {
                var val = [];
                $('input[name="Cgrades[]"]:checked').each(function(i){
                    val[i] = $(this).val();
                });
                var arrStr = encodeURIComponent(JSON.stringify(val));
                if ($("#logout_save_draft").val()){
                    window.location.href ='/super/user/save_draft/'+{!! json_encode($request->app_type) !!}+'/'+{!! json_encode($request->card) !!}+'/'+arrStr+'/'+$("#logout_save_draft").val();
                }else{
                    window.location.href ='/super/user/save_draft/'+{!! json_encode($request->app_type) !!}+'/'+{!! json_encode($request->card) !!}+'/'+arrStr+'/'+ {!! json_encode(draft) !!};
                }
        });

        $("#submit_declare_trainig" ).click(function() {
            if ($("input[name='Cgrade']:checked").val() != undefined) {
                if ($("input[name='declare_trainig']:checked").val()){
                    $(".submission").show();
                    $("#view_declare").show();
                    $(".declare").hide();
                    $("#grade").val($("input[name='Cgrade']:checked").val());
                    $("#text_declare" ).text($('input[name="Cgrade"]:checked').parent().text());
                }else{
                    swal("Error!", " tick declare", "error")
                }
            }else{
                swal("Error!", " select training", "error")

            }

        });
        $( "#next_book_appointment" ).click(function() {
            $.ajax({
                url: "{{ url('/ajax/super/user/check/expired/card') }}",
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: $('meta[name="csrf-token"]').attr('content'), card:{!! json_encode($request->card) !!}, passid:{!! json_encode($personal->passid) !!}},
                success: function (data) {
                    if (data.error == true){
                        $( "#closesPhotoNotSelfie" ).trigger( "click" );
                        $( "#ExpiredCard" ).trigger( "click" );
                        document.getElementById('data1').innerHTML = data.data1;
                        document.getElementById('data2').innerHTML = data.data2;
                        document.getElementById('data3').innerHTML = data.data3;
                        document.getElementById('data4').innerHTML = data.data4;
                    }else{
                        $("#book_appointment").submit();
                    }
                }
            });

            // $("#book_appointment").submit();
        });


        $( "#submit_book_appointment" ).click(function() {
            var declare = document.getElementById("declare");
            if({{$request->card}} == @php echo so_app @endphp && !{!! json_encode($resubmission) !!} ) {
                // if ($("input[name='declare']:checked").val() != undefined){

                    save_submission();
                // }else{
                //     swal("Error!", "tick declare", "error")
                // }
            }else{
                if ($('#upload_profile').val() || !{!! json_encode($personal->photo) !!} == "") {
                    save_submission();
                } else {
                    swal("Error!", "Upload Photo", "error")
                }
            }
        });
        function checkGrade(v) {
            return v == "false";
        }
        function save_submission() {
                if ($('#upload_profile').val() || !{!! json_encode($personal->photo) !!} == "") {
                    if (!{!! json_encode($resubmission) !!} ) {
                        {{--if (!{!! json_encode($resubmission) !!} && $("#card").val() == {{json_encode(so_app)}}) {--}}
                        if ($("input[name='submit_submission']:checked").val() != undefined) {
                            var inputFile = document.getElementById('upload_profile');
                            var pathFile = inputFile.value;
                            var ekstensiOk = /(\.jpg|\.jpeg)$/i;
                            // if (!ekstensiOk.exec(pathFile)) {
                            //     swal("Error!", "Photo uploaded must be in JPG format. ", "error")
                            // } else {
                            //     $("#book_appointment").submit();
                            // }

                            {{--if ($('#Cgrade').val() == "" && {!!  json_encode($request->array_grade) !!} == null){--}}
                            {{--        swal("Error!", "select a course", "error")--}}
                            {{--}else{--}}
                            {{--if ({!!  json_encode($request->array_grade) !!} == null )--}}

                                // console.log('ss',$('input[name="Cgrades[]"]:checked').val())

                            var val = [];
                            $('input[name="Cgrades[]"]:checked').each(function(i){
                                val[i] = $(this).val();
                            });
                            // var arrStr = encodeURIComponent(JSON.stringify(val));


                                if (typeof $('input[name="Cgrades[]"]:checked').val() === "undefined" && $("#card").val() == {{json_encode(so_app)}})
                                {
                                    swal("Error!", "Invalid selection(s) - Training Records.", "error");

                                // swal({
                                //         title: 'You have not selected any courses!',
                                //         text: 'Do you want to continue?',
                                //         icon: 'warning',
                                //         buttons: ["Cancel", "Yes!"],
                                //     }).then(function(value) {
                                //         if (value) {
                                //             $("#book_appointment").submit();
                                //         }
                                //     });
                                }else if(val.length > 1 && val.find(checkGrade) === "false"){
                                    swal("Error!", "Invalid selection(s) - Training Records.", "error");
                                }else{
                                    // $("#book_appointment").submit();
                                    $( "#reminder_photo_not_selfie" ).trigger( "click" );
                                }
                            // }

                        } else {
                            swal("Error!", " Please acknowledge declaration.", "error");
                        }
                    } else {
                        if ($("input[name='submit_submission']:checked").val() != undefined) {
                            // $("#book_appointment").submit();
                            $( "#reminder_photo_not_selfie" ).trigger( "click" );
                        } else {
                            swal("Error!", " Please acknowledge declaration.", "error");
                        }
                    }

                } else {
                    swal("Error!", "Upload Photo", "error")
                }

        }
        if (!{!! json_encode($personal->photo) !!} == ""){
            document.getElementById("info_upload").hidden = true;
            $('.file_upload_profile').attr('src', "/img/img_users/"+{!! json_encode($personal->photo) !!});
        }
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById("info_upload").hidden = true;
                    $('.file_upload_profile').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#upload_profile").change(function() {
            var control = document.getElementById("upload_profile");
            var files = control.files;
            for (var i = 0; i < files.length; i++) {
                if(files[i].type == "image/jpeg" || files[i].type == "image/jpg" || files[i].type == "image/png"){
                   if (files[i].size <= {!! json_encode(five_mb) !!}){
                       readURL(this);
                   }else{
                           control.value = null;
                       if (!{!! json_encode($personal->photo) !!} == ""){
                           $('.file_upload_profile').attr('src', "/img/img_users/"+{!! json_encode($personal->photo) !!});
                       }else{
                           $('.file_upload_profile').attr('src','/img/upload.png' );
                       }
                           swal("Error!", "Photo uploaded must be less than 5 MB size.", "error")
                   }
                }else{
                        control.value = null;
                        if (!{!! json_encode($personal->photo) !!} == ""){
                            $('.file_upload_profile').attr('src', "/img/img_users/"+{!! json_encode($personal->photo) !!});
                        }else{
                            $('.file_upload_profile').attr('src','/img/upload.png' );
                        }
                        swal("Error!", "Photo uploaded must be in JPG and PNG format. ", "error")
                }
            }
        });
    });
    $(".logout_save_draft").click(function() {
        $("#logout_save_draft").val(true)
        $( ".save_draft" ).trigger( "click" );

    });

    $('.file_upload_profiles').click(function(){ $('#upload_profile').trigger('click'); });
    //refresh page on browser resize
    // $(window).bind('resize', function(e)
    // {
    //     this.location.reload(false); /* false to get page from cache */
    //     /* true to fetch page from server */
    // });
    if($(window).width() < 767)
    {
        RemoveColNextBack();
        $(".col_declare1").addClass("col");
        $(".col_declare2").addClass("col");
        $(".col_declare3").addClass("col-6");
        $(".select_declare").addClass("col-12");

        $(".upload_profile").addClass("col-4");
        $(".upload_profile").addClass("col-4");

        $(".upload_profile").addClass("col-4");

        $(".back").addClass("col-4");
        $(".medium").addClass("col-4");
        $(".next").addClass("col-4");

        $(".file_upload_profile").css("margin-top", "70px");
        $(".upload_profile ").css("border-style", "none");
    }
    function RemoveColNextBack() {
        $(".col_declare1").removeClass("col-4");
        $(".col_declare2").removeClass("col-2");
        $(".col_declare3").removeClass("col-2");
        $(".select_declare").removeClass("col-10");

        $(".upload_profile").removeClass("col-2");

        $(".back").removeClass("col-2");
        $(".medium").removeClass("col-6");
        $(".next").removeClass("col-2");
    }
</script>
@endsection
