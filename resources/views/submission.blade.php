@extends('layouts.app')

<style>
    .HeaderdataPersonal{
        color:#808080;
        font-size: 24px;
    }
    .ColoumndataPersonal{
        font-weight: bold;
        font-size: 24px;
    }
</style>
@section('content')
<div class="container">
    <h3 style="color: #E31E1A;">Submission</h3>
    <br>
        {{-- Desktop --}}
            <div class="row hidden-xs">
                <div class="col-sm">
                    <h4><b>Submitted Details</b></h4>
                    <div class="row">
                        <div class="col-4 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$personal->nric}}</div>
                        <div class="w-100"></div>
                        <div class="col-4 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$personal->name}}</div>
                        <div class="w-100"></div>
                        <div class="col-4 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&nbsp;&nbsp;:</div>
                            @if ($request->card == so_app)
                                <div class="col-4 ColoumndataPersonal">SO / SSO / SSS</div>
                            @elseif($request->card == avso_app)
                                <div class="col-4 ColoumndataPersonal">AVSO</div>
                            @else
                                <div class="col-4 ColoumndataPersonal">PI</div>
                            @endif
                    </div>
                </div>
                <div class="col-sm-0">
                </div>
                <br class="visible-xs hidden-md">
                <div class="col-sm">
                    <br><br>
                    <div class="row">
                        <div class="col-4 HeaderdataPersonal">Pass ID No &ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$personal->passid}}</div>
                        <div class="w-100"></div>
                        <div class="col-4 HeaderdataPersonal">Expiry Date&ensp;&nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">{{$personal->passexpirydate}}</div>
                    </div>
                </div>
            </div>
        {{-- End Desktop --}}

        {{-- Phone --}}
            <div class="row visible-xs hidden-md">
            <div class="col-sm">
                <h4><b>Submitted Details</b></h4>
                <div class="row">
                    <div class="col-6 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                    <div class="col-6 ColoumndataPersonal">{{$personal->nric}}</div>
                    <div class="w-100"></div>
                    <div class="col-6 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                    <div class="col-6 ColoumndataPersonal">{{$personal->name}}</div>
                    <div class="w-100"></div>
                    <div class="col-6 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&nbsp;&nbsp;:</div>
                    @if ($request->card == so_app)
                        <div class="col-6 ColoumndataPersonal">SO / SSO / SSS</div>
                    @elseif($request->card == avso_app)
                        <div class="col-6 ColoumndataPersonal">AVSO</div>
                    @else
                        <div class="col-6 ColoumndataPersonal">PI</div>
                    @endif
                </div>
            </div>
            <div class="col-sm">
            </div>
            <br class="visible-xs hidden-md">
            <div class="col-sm">
                <br><br>
                <div class="row">
                    <div class="col-6 HeaderdataPersonal">Pass ID No &ensp;:</div>
                    <div class="col-6 ColoumndataPersonal">{{$personal->passid}}</div>
                    <div class="w-100"></div>
                    <div class="col-6 HeaderdataPersonal">Expiry Date&ensp;&nbsp;:</div>
                    <div class="col-6 ColoumndataPersonal">{{$personal->passexpirydate}}</div>
                </div>
            </div>
        </div>
        {{-- End Phone --}}

    <br><br>
    <form method="post" id="book_appointment" action="{{ route('book.appointment') }}" >
        @csrf
    @if(!empty($grade))
        <h3 style="color: black;font-weight: bold;">Declaration of training records</h3>
        <br>
        <div class="row">
            <div class="col-10 HeaderdataPersonal">
                <select class="form-control" id="grade" name="grade">
                    <option value="0" selected>please choose</option>
                    @foreach ($grade as $f)
                        <option value="{{$f->id}}">{{$f->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    <br>
    <h3 style="color: black;font-weight: bold;">Add Photo</h3>
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
            <p>- Photo must be taken without spectacles in color</p>
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
            <button class="btn btn-light btn-lg btn-block" style="border-style: groove; background: #E5E5E5; color: #E31D1A"><a href="javascript:history.go(-1)" style="text-decoration:none;"> <- Back </a></button>
        </div>
        <div class="col-6 medium">
        </div>
        <div class="col-2 next">
            <button type="button" id="submit_book_appointment" class=" btn btn-danger btn-lg btn-block">Next -></button>
        </div>
    </div>
        <input type="hidden" id="app_type" name="app_type" value="{{$request->app_type}}">
        <input type="hidden" id="card" name="card" value="{{$request->card}}">
    </form>
</div>
<script type="application/javascript">
    $( document ).ready(function() {
        $( "#submit_book_appointment" ).click(function() {
            var declare = document.getElementById("declare");
            if (declare.checked == true){
                if({!! json_encode($grade) !!}){
                    if($("#grade").val()==false){
                        swal("Please!", " select training ", "error")
                    }else{
                        $( "#book_appointment" ).submit();
                    }
                }else{
                    $( "#book_appointment" ).submit();
                }
            }else{
                swal("Please!", " tick declare", "error")
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    console.log('jrg',e.target.result)
                    $('.file_upload_profile').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#upload_profile").change(function() {
            console.log('jrg 2')
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
        $(".upload_profile").addClass("col-4");
        $(".back").addClass("col-4");
        $(".medium").addClass("col-4");
        $(".next").addClass("col-4");

        $(".file_upload_profile").css("margin-top", "70px");
    }
    function RemoveColNextBack() {
        $(".upload_profile").removeClass("col-2");
        $(".back").removeClass("col-2");
        $(".medium").removeClass("col-6");
        $(".next").removeClass("col-2");
    }
</script>
@endsection
