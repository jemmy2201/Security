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
    <h2 style="color: #E31E1A;">Submission</h2>
    <br>
        {{-- Desktop --}}
    <h4><b>Details</b></h4>

    <div class="container">
            <div class="row hidden-xs">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$personal->nric}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$personal->name}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&nbsp;&nbsp;:</div>
                            @if ($request->card == so_app)
                                @if(!empty($cek_grade) && $cek_grade->grade_id== so)
                                        <div class="col-4 ColoumndataPersonal">SO</div>
                                @elseif(!empty($cek_grade) && $cek_grade->grade_id == sso)
                                        <div class="col-4 ColoumndataPersonal">SSO</div>
                                @elseif(!empty($cek_grade) && $cek_grade->grade_id== sss)
                                        <div class="col-4 ColoumndataPersonal">SSS</div>
                                @else
                                        <div class="col-4 ColoumndataPersonal">SO</div>
                                @endif
                            @elseif($request->card == avso_app)
                                <div class="col-4 ColoumndataPersonal">NA</div>
                            @else
                                <div class="col-4 ColoumndataPersonal">NA</div>
                            @endif
                    </div>
                </div>
                <div class="col-sm-0">
                </div>
                <br class="visible-xs hidden-md">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-0 HeaderdataPersonal">Pass ID No &ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$personal->passid}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal">Expiry Date&ensp;&nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$personal->passexpirydate}}</div>
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
                    <div class="col-0 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                    <div class="col-6 ColoumndataPersonal">{{$personal->nric}}</div>
                    <div class="w-100"></div>
                    <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                    <div class="col-6 ColoumndataPersonal">{{$personal->name}}</div>
                    <div class="w-100"></div>
                    <div class="col-0 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&nbsp;&nbsp;:</div>
                    @if ($request->card == so_app)
                            @if(!empty($cek_grade) && $cek_grade->grade_id== so)
                                <div class="col-4 ColoumndataPersonal">SO</div>
                            @elseif(!empty($cek_grade) && $cek_grade->grade_id== sso)
                                <div class="col-4 ColoumndataPersonal">SSO</div>
                            @elseif(!empty($cek_grade) && $cek_grade->grade_id== sss)
                                <div class="col-4 ColoumndataPersonal">SSS</div>
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
                    <div class="col-6 ColoumndataPersonal">{{$personal->passid}}</div>
                    <div class="w-100"></div>
                    <div class="col-0 HeaderdataPersonal">Expiry Date&ensp;&nbsp;:</div>
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
        @endif
    @if(!empty($grade))
        <div class="row">
            <div class="col-4 col_declare1">
                <h3 style="color: black;font-weight: bold;">Declaration of training records</h3>
            </div>
            <div class="col-4 col_declare2">
            </div>
            <div class="col-2 col_declare3">
                <button type="button" id="button_declare" class=" btn btn-danger btn-lg btn-block">Add Declare</button>
            </div>
        </div>
        <br>
{{--         just view one delcare--}}
                <div class="row" id="view_declare">
                    <div class="col-10" >
                        <img src="{{URL::asset('/img/rounded .png')}}" style="width:15px;">
                        <a id="text_declare"></a>
                        <input type="hidden" name="grade" id="grade">
                    </div>
                </div>
{{--         end just view one delcare--}}

    @elseif(!empty($replacement) && $request->card == so_app)
            <div class="row">
                <div class="col-4 col_declare1">
                    <h3 style="color: black;font-weight: bold;">Declaration of training records</h3>
                </div>
                <div class="col-4 col_declare2">
                </div>
            </div>
            <br>
            <div class="row" >
{{--                <div class="col-10" >--}}
{{--                    <img src="{{URL::asset('/img/rounded .png')}}" style="width:15px;">--}}
{{--                    <a>{{$replacement->name}}</a>--}}
{{--                    <input type="hidden" name="grade" id="grade">--}}
{{--                </div>--}}
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
    @elseif(!empty($view_declare))
            <div class="row">
                <div class="col-4 col_declare1">
                    <h3 style="color: black;font-weight: bold;">Declaration of training records</h3>
                </div>
                <div class="col-4 col_declare2">
                </div>
            </div>
            <br>
            <div class="row">
                @foreach ($view_declare as $f)
                    @php $data = DB::table('grades')->where(['id'=>$f])->get();@endphp
                    <div class="col-10">
                        <img src="{{URL::asset('/img/rounded .png')}}" style="width:15px;">
                        <a>{{$data[0]->name}}</a><br>
{{--                        <input type="hidden" name="grade" id="grade" value="{{$data[0]->id}}">--}}
                    </div>
                @endforeach
            </div>

        @endif
    <br>
    <h3 style="color: black;font-weight: bold;">Upload Photo</h3>
    <div class="row">
        <div class="col-2 upload_profile" style="margin-top: 8px; border-style: groove; padding: 5px; margin-left: 10px;">
            <img class="file_upload_profile"  src="{{URL::asset('/img/upload.png')}}" style="width: 80%; margin-left: 20px; margin-top: 20px;">
            <input type="file" name="upload_profile" id="upload_profile" style="display: none;">
        </div>
        <div class="col-6">
            <p>Guidelines for Digital Photo Image Submission</p>
            <p>- Photo must be taken within last 3 months</p>
            <p>- Photo must be taken within even brightness</p>
            <p>- Photo must be clear and in sharp focus</p>
            <p>- Photo must be taken without spectacles</p>
            <p>- Photo background must be white in color</p>
        </div>
    </div>
    <br>
    <div class="row" style="margin-left: 1px;">
        <div class="col-0">
            <input type="checkbox" id="declare" name="declare">
        </div>
        <div class="col-8">
            <b>I declare that I have been assessed and certified in the following training modules</b>
        </div>
    </div>
    <br><br class="hidden-xs"><br class="hidden-xs">
    <div class="row">
        <div class="col-2 back">
            <button class="btn btn-light btn-lg btn-block" style="border-style: groove; background: #E5E5E5; color: #E31D1A"><a href="javascript:history.go(-1)" style="text-decoration:none;"> <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;"> Back </a></button>
        </div>
        <div class="col-6 medium">
        </div>
        <div class="col-2 next">
            <button type="button" id="submit_book_appointment" class=" btn btn-danger btn-lg btn-block">Next <img src="{{URL::asset('/img/next.png')}}" style="width: 10%;"></button>
        </div>
    </div>
        <input type="hidden" id="app_type" name="app_type" value="{{$request->app_type}}">
        <input type="hidden" id="card" name="card" value="{{$request->card}}">
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
        <div class="col-2 next">
            <button type="button" id="submit_declare_trainig" class=" btn btn-danger btn-lg btn-block">Confirm</button>
        </div>
        </form>
    </div>
</div>
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
                    {{--var grade = @json($grade);--}}
                    {{--$('#Cgrade:checked').each(function(){--}}
                    {{--    var Cgrade = $(this).val();--}}
                    {{--    $.each(grade, function(i, item) {--}}
                    {{--        if (Cgrade == grade[i].id){--}}
                    {{--            $("#text_declare" ).html('<a>'+grade[i].name+'</a><br><br>');--}}
                    {{--        }--}}
                    {{--    });--}}
                    {{--});--}}
                }else{
                    swal("Please!", " tick declare", "error")
                }
            }else{
                swal("Please!", " select training", "error")

            }

        });

        $( "#submit_book_appointment" ).click(function() {
            var declare = document.getElementById("declare");
                if ($('#upload_profile').val()){
                    if($("input[name='declare']:checked").val() != undefined){
                        var inputFile = document.getElementById('upload_profile');
                        var pathFile = inputFile.value;
                        var ekstensiOk = /(\.jpg|\.jpeg)$/i;
                        if(!ekstensiOk.exec(pathFile)){
                            swal("Please!", "upload files with the extension .jpeg & .jpg ", "error")
                        }else {
                            $("#book_appointment").submit();
                        }
                    }else{
                        swal("Please!", " tick declare", "error");
                    }
                }else{
                    swal("Please!", "Upload Photo", "error")
                }
        });

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
            readURL(this);
        });
    });

    $('.file_upload_profile').click(function(){ $('#upload_profile').trigger('click'); });
    //refresh page on browser resize
    $(window).bind('resize', function(e)
    {
        this.location.reload(false); /* false to get page from cache */
        /* true to fetch page from server */
    });
    if($(window).width() < 767)
    {
        RemoveColNextBack();
        $(".col_declare1").addClass("col-4");
        $(".col_declare2").addClass("col-2");
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
        $(".col_declare2").removeClass("col-4");
        $(".col_declare3").removeClass("col-2");
        $(".select_declare").removeClass("col-10");

        $(".upload_profile").removeClass("col-2");

        $(".back").removeClass("col-2");
        $(".medium").removeClass("col-6");
        $(".next").removeClass("col-2");
    }
</script>
@endsection
