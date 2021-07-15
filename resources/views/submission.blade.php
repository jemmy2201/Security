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
    <img class="hidden-xs" src="{{URL::asset('/img/img_step_proses/3.png')}}" style="width: 100%; margin-bottom: 20px;">
    <center class="visible-xs hidden-md">
        <img  src="{{URL::asset('/img/img_step_proses/design_phone/3.png')}}" style="width: 80%;">
    </center>
    <h2 style="color: #E31E1A;">Submission -
    @if($request->card == so_app)
        SO
    @elseif($request->card == avso_app)
        AVSO
    @elseif($request->card == pi_app)
        PI
    @endif
    </h2>
    <br>
        {{-- Desktop --}}
    <h4><b>Details</b></h4>

    <div class="container">
            <div class="row hidden-xs">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        @if (strlen($personal->name) > 40)
                            <div class="col-4 ColoumndataPersonal">{{substr($personal->name,0,35)}}<br>{{substr($personal->name,40)}}</div>
                        @else
                            <div class="col-4 ColoumndataPersonal">{{$personal->name}}</div>
                        @endif
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$personal->nric}}</div>
                    </div>
                </div>
                <div class="col-sm-0">
                </div>
                <br class="visible-xs hidden-md">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">Pass ID No &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$personal->passid}}</div>
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
                        @if(!empty( $personal->passexpirydate))
                        <div class="col-4 ColoumndataPersonal">{{$personal->passexpirydate}}</div>
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
                        <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                    @if (strlen($personal->name) > 40)
                        <div class="col-6 ColoumndataPersonal hidden-xs">{{substr($personal->name,0,40)}}<br>{{substr($personal->name,40)}}</div>
                            <div class="col-2 ColoumndataPersonal visible-xs hidden-md">{{substr($personal->name,0,15)}}<br>{{substr($personal->name,15,15)}}<br>{{substr($personal->name,30,15)}}<br>{{substr($personal->name,45,15)}}<br>{{substr($personal->name,60,15)}}</div>
                        @else
                        <div class="col-6 ColoumndataPersonal">{{$personal->name}}</div>
                    @endif
                    <div class="w-100"></div>
                    <div class="col-0 HeaderdataPersonal">NRIC/FIN&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp; :</div>
                    <div class="col-6 ColoumndataPersonal">{{$personal->nric}}</div>

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
                    <div class="col-6 ColoumndataPersonal">{{$personal->passid}}</div>
                    <div class="w-100"></div>
                    <div class="col-0 HeaderdataPersonal">Card Expiry
                        Date&ensp;&nbsp;:</div>
                    <div class="col-6 ColoumndataPersonal">{{$personal->passexpirydate}}</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Phone --}}

    <br><br>
    <form method="post" id="book_appointment" action="{{ route('book.appointment') }}" enctype="multipart/form-data">
        @csrf
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
                    <div class="row">
                        <div class="col-4 col_declare1">
                            <h3 style="color: black;font-weight: bold;font-size: 23px;">Declaration of Training Records</h3>
                        </div>
                        <div class="col-2 col_declare2">
                            <button type="button" id="button_declare" class=" btn btn-danger btn-lg btn-block">Declare</button>
                        </div>
                        <div class="col-2 col_declare3">
{{--                            <button type="button" id="button_declare" class=" btn btn-danger btn-lg btn-block">Declare</button>--}}
                        </div>
                    </div>
                    <br>
                @if(!empty($cek_grade->array_grade))
                    @foreach (json_decode($cek_grade->array_grade) as $f)
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
                            <h3 style="color: black;font-weight: bold;font-size: 23px;">Declaration of Training Records</h3>
                        </div>
                        <div class="col-2 col_declare2">
                        </div>
                        <div class="col-2 col_declare3">
{{--                            <button type="button" id="button_declare" class=" btn btn-danger btn-lg btn-block">Declare</button>--}}
                        </div>
                    </div>
                    <div class="row" >
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
                    </div>
                @endif

                {{--         just view one delcare--}}
                <div class="row" id="view_declare">
                    <div class="col-10" >
                        <img src="{{URL::asset('/img/rounded .png')}}" style="width:15px;">
                        <a id="text_declare"></a>
                        <input type="hidden" name="grade" id="grade">
                    </div>
                </div>
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
    <br>
    <h3 style="color: black;font-weight: bold;">Submit Photo</h3>
    <div class="row">
        <div class="col-2 upload_profile" style="margin-top: 8px; border-style: groove; padding: 5px; margin-left: 10px;">
            <img class="file_upload_profile"  src="{{URL::asset('/img/upload.png')}}" style="width: 80%; margin-left: 20px; margin-top: 20px;">
            <input type="file" name="upload_profile" id="upload_profile" style="display: none;">
        </div>
        <div class="col-4 hidden-xs">
            <p>Guidelines for Digital Photo Image Submission</p>
            <p>- Photo must be taken within last 3 months</p>
            <p>- Photo must be taken within even brightness</p>
            <p>- Photo must be clear and in sharp focus</p>
            <p>- Photo must be taken without spectacles</p>
            <p>- Photo background must be white in color</p>
            <p>- Photo uploaded must be in JPG format (max size: 1MB only)</p>
        </div>
        <div class="col-6 visible-xs hidden-md">
            <p>Guidelines for Digital Photo Image Submission</p>
            <p>- Photo must be taken within last 3 months</p>
            <p>- Photo must be taken within even brightness</p>
            <p>- Photo must be clear and in sharp focus</p>
            <p>- Photo must be taken without spectacles</p>
            <p>- Photo background must be white in color</p>
            <p>- Photo uploaded must be in JPG format (max size: 1MB only)</p>
        </div>
        <div class="col-2 hidden-xs">
            <button type="button" class=" btn btn-danger btn-lg btn-block file_upload_profiles">Upload Photo</button>
        </div>
        <div class="col visible-xs hidden-md">
            <button type="button"  class=" btn btn-danger btn-lg btn-block">Upload Photo</button>
        </div>
    </div>
    <br>
    @if(!empty($grade) || !empty($replacement) && $request->card == so_app)
            @if(empty($resubmission))
            <div class="row" style="margin-left: 1px;">
                <div class="col-0">
                    <input type="checkbox" id="declare" name="declare">
                </div>
                <div class="col-8">
                    <b>I declare that I have been assessed and certified in the following training modules</b>
                </div>
            </div>
            @endif
        @endif
    <br><br class="hidden-xs"><br class="hidden-xs">
    <div class="row">
        <div class="col-2 back">
            <a href="{{ url('back/personal/particular/'.$request->card) }}" style="text-decoration:none;"><button type="button" class="btn btn-light btn-lg btn-block" style="border-style: groove; background: #E5E5E5; color: #E31D1A" > <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;"> Back </button></a>
        </div>
        <div class="col-8 medium hidden-xs">
        </div>
        <div class="col-6 medium visible-xs hidden-md">
        </div>
        <div class="col-2 next">
            @if(empty($resubmission))
                <button type="button" id="submit_book_appointment" class=" btn btn-danger btn-lg btn-block">Next <img src="{{URL::asset('/img/next.png')}}" style="width: 10%;"></button>
            @else
                <button type="button" id="submit_book_appointment" class=" btn btn-danger btn-lg btn-block">Resubmission <img src="{{URL::asset('/img/next.png')}}" style="width: 10%;"></button>
            @endif
        </div>
    </div>
        <input type="hidden" id="app_type" name="app_type" value="{{$request->app_type}}">
        <input type="hidden" id="card" name="card" value="{{$request->card}}">
        <input type="hidden" id="passexpirydate" name="passexpirydate" value="{{$request->passexpirydate}}">
    </form>
</div>
@if(!empty($grade))
<div class="container declare">
    <h2 style="color: #E31E1A;">Declare of Training</h2>
    <h3><b>Statement of Attainment for the following modules :</b></h3>
    <div class="row">
        <div class="col-10 select_declare">
            <ul class="list-group">
            @foreach ($grade as $f)
            <li class="list-group-item"><input class="form-check-input" type="radio" name="Cgrade" id="Cgrade" value="{{$f->id}}">&ensp;&ensp; {{$f->name}}</li>
            @endforeach
            </ul>
        </div>
    </div>
    <input type="checkbox" id="declare_trainig" name="declare_trainig">&ensp;&ensp;
    <b>I declare that I have been assessed and certified in the following training modules</b>
    <div class="row">
        <div class="col-2 back">
        </div>
        <div class="col-6 medium">
        </div>
        <form method="post" id="delcare_submission" action="{{ route('declare.submission') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="app_type" name="app_type" value="{{$request->app_type}}">
            <input type="hidden" id="card" name="card" value="{{$request->card}}">
            <input type="hidden" id="array_grade" name="array_grade" value="{{$cek_grade->array_grade}}">
        <div class="col-2 next">
            <button type="button" id="submit_declare_trainig" class=" btn btn-danger btn-lg btn-block">Confirm</button>
        </div>
        </form>
    </div>
</div>
@elseif(!empty($replacement) && $request->card == so_app)
        <form method="post" id="delcare_submission" action="{{ route('declare.submission') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="app_type" name="app_type" value="{{$request->app_type}}">
            <input type="hidden" id="card" name="card" value="{{$request->card}}">
        </form>
@endif

<script type="application/javascript">
    $( document ).ready(function() {
        $(".declare").hide();
        $("#view_declare").hide();

        $("#button_declare" ).click(function() {
            // $(".submission").hide();
            // $(".declare").show();
            $( "#delcare_submission" ).submit();
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
                    swal("Please!", " tick declare", "error")
                }
            }else{
                swal("Please!", " select training", "error")

            }

        });

        $( "#submit_book_appointment" ).click(function() {
            var declare = document.getElementById("declare");
            if({{$request->card}} == @php echo so_app @endphp && !{!! json_encode($resubmission) !!} ) {
                // if ($('#Cgrade').val() != true){
                    save_submission();
                // }else{
                //     swal("Please!", "select a course", "error")
                // }
            }else{
                if ($('#upload_profile').val()) {
                    save_submission();
                } else {
                    swal("Please!", "Upload Photo", "error")
                }
            }
        });

        function save_submission() {
            if ($('#upload_profile').val() || !{!! json_encode($personal->photo) !!} == "") {
                if (!{!! json_encode($resubmission) !!} && $("#card").val() == {{json_encode(so_app)}}) {
                    if ($("input[name='declare']:checked").val() != undefined) {
                        var inputFile = document.getElementById('upload_profile');
                        var pathFile = inputFile.value;
                        var ekstensiOk = /(\.jpg|\.jpeg)$/i;
                        // if (!ekstensiOk.exec(pathFile)) {
                        //     swal("Please!", "upload files with the extension .jpeg & .jpg ", "error")
                        // } else {
                        //     $("#book_appointment").submit();
                        // }

                        if ($('#Cgrade').val() == "" && {!!  json_encode($request->array_grade) !!} == null){
                                swal("Please!", "select a course", "error")
                        }else{
                            if ({!!  json_encode($request->array_grade) !!} == null )
                            {
                                swal({
                                    title: 'You have not selected any courses!',
                                    text: 'Do you want to continue?',
                                    icon: 'warning',
                                    buttons: ["Cancel", "Yes!"],
                                }).then(function(value) {
                                    if (value) {
                                        $("#book_appointment").submit();
                                    }
                                });
                            }else{
                                $("#book_appointment").submit();
                            }
                        }

                    } else {
                        swal("Please!", " tick declare", "error");
                    }
                } else {
                    $("#book_appointment").submit();
                }

            } else {
                swal("Please!", "Upload Photo", "error")
            }
        }
        if (!{!! json_encode($personal->photo) !!} == ""){
            $('.file_upload_profile').attr('src', "/img/img_users/"+{!! json_encode($personal->photo) !!});
        }
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.file_upload_profile').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#upload_profile").change(function() {
            var control = document.getElementById("upload_profile");
            var files = control.files;
            for (var i = 0; i < files.length; i++) {
                if(files[i].type == "image/jpeg" || files[i].type == "image/jpg"){
                   if (files[i].size <= 1000000){
                       readURL(this);
                   }else{
                           control.value = null;
                       if (!{!! json_encode($personal->photo) !!} == ""){
                           $('.file_upload_profile').attr('src', "/img/img_users/"+{!! json_encode($personal->photo) !!});
                       }else{
                           $('.file_upload_profile').attr('src','/img/upload.png' );
                       }
                           swal("Please!", "Max Size: 1MB Only ", "error")
                   }
                }else{
                        control.value = null;
                        if (!{!! json_encode($personal->photo) !!} == ""){
                            $('.file_upload_profile').attr('src', "/img/img_users/"+{!! json_encode($personal->photo) !!});
                        }else{
                            $('.file_upload_profile').attr('src','/img/upload.png' );
                        }
                        swal("Please!", "upload files with the extension .jpeg & .jpg ", "error")
                }
            }
        });
    });


    $('.file_upload_profiles').click(function(){ $('#upload_profile').trigger('click'); });
    //refresh page on browser resize
    $(window).bind('resize', function(e)
    {
        this.location.reload(false); /* false to get page from cache */
        /* true to fetch page from server */
    });
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
