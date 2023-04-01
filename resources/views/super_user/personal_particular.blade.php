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
    .modal-footer {
        display: flow-root !important;
    }
</style>
@section('content')
<div class="container">
    <img class="hidden-xs" src="{{URL::asset('/img/img_step_proses/2.png')}}" style="width: 100%; margin-bottom: 20px;">
    <center class="visible-xs hidden-md">
        <img  src="{{URL::asset('/img/img_step_proses/design_phone/2.png')}}" style="width: 80%;">
    </center>
    <h2 style="color: black;"><b>Personal Particulars</b></h2>
    <br>
{{--        <div class="row">--}}
            <div class="col-sm">
                <div class="row">
                    <div class="col-0 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                    @php
                        $cutnric = substr(secret_decode($personal->nric), -4);
                        $nric = "XXXXX$cutnric";
                    @endphp
                    <div class="col-6 ColoumndataPersonal">{{$nric}}</div>
                    <div class="w-100"></div>
                    <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                    @if (strlen($personal->name) > 40)
                        <div class="col-6 ColoumndataPersonal hidden-xs">
                            <textarea rows="4" cols="30" id="TextAreaName" style="resize: none;outline: none;border: none;" readonly>
                                {{$personal->name}}
                            </textarea>
                        </div>
                        <div class="col-2 ColoumndataPersonal visible-xs hidden-md">
                            <textarea rows="4" cols="20" id="TextAreaNamePhone" style="resize: none;outline: none;border: none;" readonly>
                                {{$personal->name}}
                            </textarea>
                        </div>
                    @else
                        <div class="col-6 ColoumndataPersonal">{{$personal->name}}</div>
                    @endif
                    <div class="w-100"></div>
                    <div class="col-0 HeaderdataPersonal" hidden>Pass ID No &nbsp;:</div>
                    <div class="col-6 ColoumndataPersonal" hidden>{{$personal->passid}}</div>
                </div>
            </div>
            <div class="col-sm">
            </div>
            <br class="visible-xs hidden-md">
            <div class="col-sm" hidden>
                <img src="{{URL::asset('/img/profile.png')}}" style="width: 30%;border-style: groove;">
            </div>
{{--        </div>--}}
    <br><br>

    <h3 style="color: black;font-weight: bold;">Update Details</h3>
    <br class="hidden-xs">
    <form method="post" id="submit_personal_particular" action="{{ route('super_user.submission') }}" >
        @csrf
    <input type="hidden" name="Status_App" id="Status_App" value="{{$request->Status_App}}">
    {{-- Desktop --}}
    <div class="row hidden-xs">
        <div class="col-4 " >
            <div style="font-size: 20px;color:#808080;"> My Mobile No : <b id="textNumber" class="ColoumndataPersonal " style="color:black;">{{substr($personal->mobileno, 2)}} </b></div>
            <input type="hidden" id="view_mobileno" name="view_mobileno" class="form-control hidden-xs"  placeholder="0000000" value="{{substr($personal->mobileno, 2)}}" maxlength="8" readonly>
        </div>
    </div><br class="hidden-xs">
        <div class="row hidden-xs">
            <div class="col-6 HeaderdataPersonal phone">
                Singapore mobile number <span style="color:red; vertical-align: super; font-size: small;">*Mandatory</span>
            </div>
        </div><br class="hidden-xs">
        <div class="row hidden-xs">
            <div class="col-2 HeaderdataPersonal" >
                <input type="number"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control hidden-xs" id="mobileno" name="mobileno"  placeholder="0000000"  maxlength="8" autofocus>
            </div>
{{--            <div class="col-2 HeaderdataPersonal" >--}}
                <i class="fa fa-arrow-left" aria-hidden="true" style="color: blue;font-size: 30px;"></i>
{{--            </div>--}}
            <div class="col-4 HeaderdataPersonal" >
                <button type="button" class=" btn btn-light " style="pointer-events: none;border-style: groove; background: black; color: blue">
{{--                    <button type="button" class=" btn btn-light update_number" style="border-style: groove; background: black; color: blue">--}}
                    <a href="#" style="text-decoration:none; color: white;">
                        {{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
                        @if(empty($personal->mobileno))
                            Add Number
                        @else
                            Update Number
                        @endif
                    </a>
                </button>
            </div>
        </div>

    <div class="row hidden-xs">
        @if($personal->web == true)
            <div class="col-4 HeaderdataPersonal expriydate">
                WP Expiry Date
            </div>
        @else
            <div class="col"></div>
        @endif
    </div>
    <div class="row hidden-xs">
        @if($personal->web == true)
            <div class="col-4 HeaderdataPersonal">
                <input type="date" class="form-control hidden-xs" id="wpexpirydate" name="wpexpirydate"  placeholder="dd-mm-yyyy" value="{{Carbon\Carbon::parse($personal->wpexpirydate)->format('Y-m-d')}}">
            </div>
        @else
            <div class="col-4">
            </div>
        @endif
    </div><br>
        <br class="hidden-xs">
    <div class="row hidden-xs">
        <div class="col HeaderdataPersonal email">
            Email address <span style="color:black; vertical-align: super; font-size: small;">*Optional</span>
        </div>
    </div>
    <div class="row hidden-xs">
        <div class="col-4 HeaderdataPersonal hidden-xs">
            @php
             if(substr($personal->email,0,5)  == default_email){
                $email = '';
             }else{
                $email = $personal->email;
             }
            @endphp
            <input type="text" class="form-control hidden-xs" id="email" name="email"  value="{{$email}}" >
        </div>
    </div>
   {{-- End Desktop --}}

   {{-- Phone --}}
        <div class="row visible-xs hidden-md">
            <div class="col HeaderdataPersonal phone">
                <div  style="font-size: 20px;color:#808080;"> My Mobile No : <b id="textNumberPhone" class="ColoumndataPersonal " style="color:black;">{{substr($personal->mobileno, 2)}} </b></div>
                <input type="hidden" id="Phoneview_mobileno" name="Phoneview_mobileno" class="form-control "  placeholder="0000000" value="{{substr($personal->mobileno, 2)}}" maxlength="8" readonly>
            </div>
        </div><br class="visible-xs hidden-md">
        <div class="row visible-xs hidden-md">
{{--            <div class="col-2 HeaderdataPersonal " >--}}
{{--            </div>--}}
            <div class="col HeaderdataPersonal">
                Singapore mobile number <span style="color:red; vertical-align: super; font-size: small;">*Mandatory</span>
                <br>
                <input type="number" class="form-control visible-xs hidden-md" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="Phonemobileno" name="Phonemobileno"  placeholder="0000000"  maxlength="8" autofocus>
                <br class="visible-xs hidden-md">
                <button type="button" class=" btn btn-light " style="pointer-events: none;border-style: groove; background: black; color: #E31D1A">
{{--                    <button type="button" class=" btn btn-light update_number" style="border-style: groove; background: black; color: #E31D1A">--}}
                    <a href="#" style="text-decoration:none; color: white;">
                        {{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
                        Update Number
                    </a>
                </button>
            </div>
        </div><br>
        <div class="row visible-xs hidden-md">
            @if($personal->web == true)
                <div class="col HeaderdataPersonal expriydate">
                    WP Expiry Date
                </div>
            @else
                <div class="col"></div>
            @endif
        </div>
        <div class="row visible-xs hidden-md">
            @if($personal->web == true)
                <div class="col HeaderdataPersonal">
                    <input type="date" class="form-control visible-xs hidden-md" id="Phonewpexpirydate" name="Phonewpexpirydate"  placeholder="dd-mm-yyyy" value="{{Carbon\Carbon::parse($personal->wpexpirydate)->format('Y-m-d')}}">
                </div>
            @else
                <div class="col">
                </div>
            @endif
        </div><br>
        <div class="row visible-xs hidden-md">
            <div class="col HeaderdataPersonal email">
                Email <span style="color:black; vertical-align: super; font-size: small;">*Optional</span>
            </div>
        </div>
        <div class="row visible-xs hidden-md">
            <div class="col HeaderdataPersonal">
                <input type="text" class="form-control visible-xs hidden-md" id="Phoneemail" name="Phoneemail" value="{{$personal->email}}" >
            </div>
        </div>
   {{-- End Phone --}}

        <br class="visible-xs hidden-md">
    <div class="row">
        <div class="col-2 back">
            <a href="{{url("/super/user/landing_page")}}" style="text-decoration:none; color: white;">
            <button type="button" class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: black; color: white">
{{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
                    Back
            </button>
            </a>
        </div>
{{--        <div class="col-4 medium hidden-xs">--}}
{{--        </div>--}}
{{--        <div class="col-2 next hidden-xs">--}}
{{--            <button class=" btn btn-light btn-lg btn-block update_number" style="border-style: groove; background: black; color: #E31D1A">--}}
{{--                <a href="#" style="text-decoration:none; color: white;">--}}
{{--                    --}}{{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
{{--                    Update Number--}}
{{--                </a>--}}
{{--            </button>--}}
{{--        </div>--}}
{{--        <div class="col-6 visible-xs hidden-md">--}}
{{--            <button class=" btn btn-light btn-lg btn-block update_number" style="border-style: groove; background: black; color: #E31D1A">--}}
{{--                <a href="#" style="text-decoration:none; color: white;">--}}
{{--                    --}}{{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
{{--                    Update Number--}}
{{--                </a>--}}
{{--            </button>--}}
{{--        </div>--}}
        <br class="visible-xs hidden-md">
        <br class="visible-xs hidden-md">
        <br class="visible-xs hidden-md">
{{--        <div class="col-2 next">--}}
{{--            <a href="{{url('/super/user/save_draft/'.$request->app_type.'/'.$request->card.'/'.draft.'/'.draft)}}" style="text-decoration:none; color: white;">--}}
{{--            <button class=" btn btn-light btn-lg btn-block hidden-xs" style="border-style: groove; background: black; color: white">--}}
{{--                    --}}{{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
{{--                    Save Draft--}}
{{--            </button>--}}
{{--            </a>--}}
{{--            <a href="{{url('/super/user/save_draft/'.$request->app_type.'/'.$request->card.'/'.draft.'/'.draft)}}" style="text-decoration:none; color: white;">--}}
{{--            <button class=" btn btn-light btn-lg visible-xs hidden-md" style="border-style: groove; background: black; color: white">--}}
{{--                    --}}{{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
{{--                    Save Draft--}}
{{--            </button>--}}
{{--            </a>--}}
{{--        </div>--}}
        <div class="col-2 next">
            <button type="button" class="click_personal_particular btn btn-primary btn-lg btn-block" style=" background: black; color: white;">Next
            </button>
            <button type="button" id="form_activation" data-toggle="modal" data-target="#code_activation_Modal" class=" btn btn-primary btn-lg btn-block" style=" background: black; color: white; display: none;">
            </button>
            <button type="button" id="form_confim_otp" data-toggle="modal" data-target="#confim_otp" class=" btn btn-primary btn-lg btn-block" style=" background: black; color: white; display: none;">
            </button>
        </div>

    </div>
        <input type="hidden" id="app_type" name="app_type" value="{{$request->app_type}}">
        <input type="hidden" id="card" name="card" value="{{$request->card}}">
    </form>

</div>


<!-- Modal code activation-->
<div class="modal fade" id="code_activation_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verification Code</h5>
                <button type="button" class="close" id="closes_code_activation_Modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                We have sent an SMS to your mobile number with a verification code. Please check your phone and enter the verification code below
                <input type="text" class="form-control" id="kode_activation" name="kode_activation" >
            </div>
            <div class="modal-footer">
{{--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                <center>
                <button type="button" class="btn btn-primary" id="check_activation">Submit</button>
                </center>
            </div>
        </div>
    </div>
</div>
<!-- End Modal code activation -->

<!-- Modal Confirm OTP-->
<div class="modal fade" id="confim_otp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
{{--                <h5 class="modal-title" id="exampleModalLabel">Verification Code</h5>--}}
                <button type="button" class="close" id="closes_code_activation_Modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirm your mobile entered is correct,select "Get OTP" else select Cancel to re-input your mobile number
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="get_otp" data-dismiss="modal">Get OTP</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- End ModalConfirm OTP -->

<script>
    $( document ).ready(function() {
        function getChromeVersion () {
            var raw = navigator.userAgent.match(/Chrom(e|ium)\/([0-9]+)\./);

            return raw ? parseInt(raw[2], 10) : false;
            // return 101;
        }
        {{--if(getChromeVersion() < {!!  json_encode(version_chrome) !!}){--}}
        {{--    swal("Attention!", "Please update your chrome", "error")--}}
        {{--    document.getElementById('click_personal_particular').style.visibility = 'hidden';--}}
        {{--}--}}
        // 15 minutes not action
        setTimeout(RefreshPage, 900000);
        function RefreshPage() {
            window.location.href = "{{URL::to('relogin')}}"
        }
        // End 15 minutes not action

        $(document).on('show.bs.modal','#code_activation_Modal',function () {
            $("#kode_activation").focus();
        });
        $( ".update_number" ).click(function() {
            // $(".update_number").attr("disabled", true);
            // $('#mobileno').removeAttr('readonly');
            // $('#Phonemobileno').removeAttr('readonly');
            create_activation();
        });
        $( "#get_otp" ).click(function() {
            // $(".update_number").attr("disabled", true);
            // $('#mobileno').removeAttr('readonly');
            // $('#Phonemobileno').removeAttr('readonly');
            create_activation();
        });

        function check_size_layout(){
            var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
            var data='';
            if (width < 640) {
                data = {!!  json_encode(phone) !!};
            }else{
                data = {!!  json_encode(desktop) !!};
            }
            return data;
        }
        if (check_size_layout() == {!!  json_encode(desktop) !!}){
            if ($('#mobileno').val() == "" || $('#mobileno').val() == '-' ){
                $('#mobileno').removeAttr('readonly');
            }
        }else{
            if ($('#Phonemobileno').val() == "" || $('#Phonemobileno').val() == '-' ) {
                $('#Phonemobileno').removeAttr('readonly');
            }
        }
        function send_personal_particular(){
            // var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
            if (check_size_layout() == {!!  json_encode(phone) !!}){
                if({!!  json_encode($personal->mobileno) !!} != "" || {!!  json_encode($personal->mobileno) !!} != "65"){
                    if($('#Phoneview_mobileno').val() != ""){
                        // if (check_number_singapore() == true){
                        if({!!  json_encode($personal->web) !!} == true ){
                            if (new Date($('#Phonewpexpirydate').val()) != "Invalid Date" ){
                                if ( new Date() >= new Date($('#Phonewpexpirydate').val())){
                                    swal("Attention!", "Pass Expiration Date is up", "error")
                                }else{
                                    // create_activation();
                                    $("#submit_personal_particular").submit();
                                }
                            }else{
                                swal("Error!", "Input file Pass Expiry Date", "error")
                            }
                        }else{
                            // create_activation();
                            $("#submit_personal_particular").submit();
                        }
                        // }else{
                        //     swal("Error!", "Only Singapore numbers are valid.", "error")
                        // }
                    }else{
                        swal("Error!", "Mobile number incomplete.", "error")
                    }
                }else{
                    swal("Error!", "Mobile number incomplete.", "error")
                }
            }else{
                if({!!  json_encode($personal->mobileno) !!} != "" || {!!  json_encode($personal->mobileno) !!} != "65"){
                    if($('#view_mobileno').val() != ""){
                        // if (check_number_singapore() == true){
                        if({!!  json_encode($personal->web) !!} == true ){
                            if (new Date($('#wpexpirydate').val()) != "Invalid Date" ){
                                if ( new Date() >= new Date($('#wpexpirydate').val())){
                                    swal("Attention!", "Pass Expiration Date is up", "error")
                                }else{
                                    // create_activation();
                                    $("#submit_personal_particular").submit();
                                }
                            }else{
                                swal("Error!", "Input file Pass Expiry Date", "error")
                            }
                        }else{
                            // create_activation();
                            $("#submit_personal_particular").submit();
                        }
                        // }else{
                        //     swal("Error!", "Only Singapore numbers are valid.", "error")
                        // }
                    }else{
                        swal("Error!", "Mobile number incomplete.", "error")
                    }
                }else{
                    swal("Error!", "Mobile number incomplete.", "error")

                }
            }
        }
        $( ".click_personal_particular" ).click(function() {
            if(getChromeVersion() < {!!  json_encode(version_chrome) !!}){
                // swal("Error!", "Please update your browser OS.", "error")
                //     .then((value) => {
                //         if (value){
                //             $( ".logout_save_draft" ).trigger( "click");
                //         }
                //     });
                    swal("Attention!", "Please update your browser OS.", "error")
                setTimeout(function(){
                    $( ".logout_save_draft" ).trigger( "click");
                }, 9000); //Time before execution
                // document.getElementById('click_personal_particular').style.visibility = 'hidden';
            }else{
                send_personal_particular();
            }
        });
        $('#code_activation_Modal').on('hidden.bs.modal', function () {
            {{--$('#mobileno').val({{$personal->mobileno}})--}}
            {{--$('#Phonemobileno').val({{$personal->mobileno}})--}}
            $('#mobileno').val(null)
            $('#Phonemobileno').val(null)
            if ({!!  json_encode($personal->mobileno) !!} == "" || {!!  json_encode($personal->mobileno) !!} == '-' ){
                $('#mobileno').removeAttr('readonly');
                $('#Phonemobileno').removeAttr('readonly');
            }else{
                // $('#mobileno').attr('readonly',true);
                // $('#Phonemobileno').attr('readonly',true);
            }
        })
        function check_number_singapore(){
            var check_number_singapore = false;
            if (check_size_layout() == {!!  json_encode(desktop) !!}) {
                if ($("#mobileno").val()[0] == '6' || $("#mobileno").val()[1] == '5') {
                    if ($("#mobileno").val()[2] == '9' || $("#mobileno").val()[2] == '8' && $("#mobileno").val().length == '10') {
                        var check_number_singapore = true;
                    }
                } else {
                    if ($("#mobileno").val()[0] == '9' || $("#mobileno").val()[0] == '8' && $("#mobileno").val().length == '8') {
                        var check_number_singapore = true;
                    }
                }
            }else{
                if ($("#Phonemobileno").val()[0] == '6' || $("#Phonemobileno").val()[1] == '5') {
                    if ($("#Phonemobileno").val()[2] == '9' || $("#Phonemobileno").val()[2] == '8' && $("#Phonemobileno").val().length == '10') {
                        var check_number_singapore = true;
                    }
                } else {
                    if ($("#Phonemobileno").val()[0] == '9' || $("#Phonemobileno").val()[0] == '8' && $("#Phonemobileno").val().length == '8') {
                        var check_number_singapore = true;
                    }
                }
            }
            return check_number_singapore;
        }

        $( "#closes_code_activation_Modal" ).click(function() {
                swal("Error!", "Your mobile number is not updated", "error")
        });


        $( "#check_activation" ).click(function() {
            $.ajax({
                url: "{{ url('/ajax/super/user/check/activation') }}",
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: $('meta[name="csrf-token"]').attr('content'), activation:$("#kode_activation").val(),phone:$("#mobileno").val()},
                success: function (data) {
                    if (data == {!! json_encode(succes) !!}){
                        swal("Success !", "Add Or Update Mobile Number", "success");
                        $('#textNumber').text($('#mobileno').val())
                        $('#textNumberPhone').text($('#Phonemobileno').val())

                        $('#view_mobileno').val($('#mobileno').val());
                        $('#Phoneview_mobileno').val($('#Phonemobileno').val());
                        // $( ".close" ).trigger( "click" );
                        $('#code_activation_Modal').modal('hide');
                        $('.modal-backdrop').css({'position':'inherit','height':'0'});
                        // $("#submit_personal_particular").submit();
                    }else if (data == {!! json_encode(already_used) !!}){
                        swal("Attention!", "Activation code already used", "error")
                    }else{
                        swal("Attention!", "Wrong activation code", "error")
                    }
                }
            });
        });
        $('#mobileno').keyup(function() {
            // Your code here
            if ($('#mobileno').val().length == 8){
                $( "#form_confim_otp" ).trigger( "click" );
            }
        });
        $('#Phonemobileno').keyup(function() {
            // Your code here
            if ($('#Phonemobileno').val().length == 8){
                $( "#form_confim_otp" ).trigger( "click" );
            }
        });
    });

</script>
<script type="application/javascript">
    window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName === 'INPUT' && e.target.type !== 'textarea'){e.preventDefault();return false;}}},true);
    //refresh page on browser resize
    // $(window).bind('resize', function(e)
    // {
    //     this.location.reload(false); /* false to get page from cache */
    //     /* true to fetch page from server */
    // });
    $(".logout_save_draft").click(function() {
        $("#logout_save_draft").val(true)
        window.location.href ='/super/user/save_draft/'+{!! json_encode($request->app_type) !!}+'/'+{!! json_encode($request->card) !!}+'/'+{!! json_encode(draft) !!}+'/'+$("#logout_save_draft").val();
    });

    function create_activation(eventDate){
        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        if (width < 640){
            var phone = $("#Phonemobileno").val();
        }else{
            var phone = $("#mobileno").val();
        }
        $.ajax({
            url: "{{ url('/ajax/super/user/sent/activation/phone') }}",
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: $('meta[name="csrf-token"]').attr('content'), phone:phone},
            success: function (data) {
                if (data == true){
                    $( "#form_activation" ).trigger( "click" );
                }else if(data == {!!  json_encode(not_number_singapore) !!}){
                    swal("Error!", "Only Singapore numbers are valid.", "error")
                }else if(data == {!!  json_encode(wrong_format_number) !!}){
                    swal("Error!", "Wrong number format", "error")
                }else if(data == {!!  json_encode(same_number_phone) !!}){
                    $("#submit_personal_particular").submit();
                }
            }
        });
    }

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
