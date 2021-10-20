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
<div class="container">
    <img class="hidden-xs" src="{{URL::asset('/img/img_step_proses/2.png')}}" style="width: 100%; margin-bottom: 20px;">
    <center class="visible-xs hidden-md">
        <img  src="{{URL::asset('/img/img_step_proses/design_phone/2.png')}}" style="width: 80%;">
    </center>
    <h2 style="color: #E31E1A;">Personal Particulars</h2>
    <br>
{{--        <div class="row">--}}
            <div class="col-sm">
                <div class="row">
                    <div class="col-0 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                    @php
                        $cutnric = substr($personal->nric, -4);
                        $nric = "XXXXX$cutnric";
                    @endphp
                    <div class="col-6 ColoumndataPersonal">{{$nric}}</div>
                    <div class="w-100"></div>
                    <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                    @if (strlen($personal->name) > 40)
                        <div class="col-6 ColoumndataPersonal hidden-xs">
                            <textarea rows="4" cols="30" id="TextAreaName" style="resize: none;" readonly>
                                {{$personal->name}}
                            </textarea>
                        </div>
                        <div class="col-2 ColoumndataPersonal visible-xs hidden-md">
                            <textarea rows="4" cols="20" id="TextAreaNamePhone" style="resize: none;" readonly>
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
    <br>
    <form method="post" id="submit_personal_particular" action="{{ route('submission') }}" >
        @csrf
    <input type="hidden" name="Status_App" id="Status_App" value="{{$request->Status_App}}">
    {{-- Desktop --}}

    <div class="row hidden-xs">
        <div class="col-6 HeaderdataPersonal phone">
            Singapore mobile number <span style="color:red; vertical-align: super; font-size: small;">*Mandatory Field</span>
        </div>
    </div>
    <div class="row hidden-xs">
        <div class="col-4 HeaderdataPersonal">
            <input type="number" class="form-control hidden-xs" id="mobileno" name="mobileno"  placeholder="0000000" value="{{$personal->mobileno}}" maxlength="8" readonly>
        </div>
    </div><br>

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

    <div class="row hidden-xs">
        <div class="col HeaderdataPersonal email">
            Email address <span style="color:red; vertical-align: super; font-size: small;">*Optional field</span>
        </div>
    </div>
    <div class="row hidden-xs">
        <div class="col-4 HeaderdataPersonal hidden-xs">
            <input type="text" class="form-control hidden-xs" id="email" name="email"  value="{{$personal->email}}" >
        </div>
    </div>
   {{-- End Desktop --}}
   {{-- Phone --}}
        <div class="row visible-xs hidden-md">
            <div class="col HeaderdataPersonal phone">
                Singapore mobile number <span style="color:red; vertical-align: super; font-size: small;">*Mandatory Field</span>
            </div>
        </div>
        <div class="row visible-xs hidden-md">
            <div class="col HeaderdataPersonal">
                <input type="number" class="form-control visible-xs hidden-md" id="Phonemobileno" name="Phonemobileno"  placeholder="0000000" value="{{$personal->mobileno}}" maxlength="8" readonly>
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
                Email <span style="color:red; vertical-align: super; font-size: small;">*Optional field</span>
            </div>
        </div>
        <div class="row visible-xs hidden-md">
            <div class="col HeaderdataPersonal">
                <input type="text" class="form-control visible-xs hidden-md" id="Phoneemail" name="Phoneemail" value="{{$personal->email}}" >
            </div>
        </div>
   {{-- End Phone --}}

        <br ><br class="hidden-xs"><br class="hidden-xs">
    <div class="row">
        <div class="col-2 back">
            <button type="submit" class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: #1E90FF; color: #E31D1A">
                <a href="{{url("/home")}}" style="text-decoration:none; color: white;">
{{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
                    Back
                </a>
            </button>
        </div>
        <div class="col-4 medium hidden-xs">
        </div>
        <div class="col-2 next hidden-xs">
            <button class=" btn btn-light btn-lg btn-block update_number" style="border-style: groove; background: #1E90FF; color: #E31D1A">
                <a href="#" style="text-decoration:none; color: white;">
                    {{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
                    Update Number
                </a>
        </div>
        <div class="col-6 visible-xs hidden-md">
            <button class=" btn btn-light btn-lg btn-block update_number" style="border-style: groove; background: #1E90FF; color: #E31D1A">
                <a href="#" style="text-decoration:none; color: white;">
                    {{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
                    Update Number
                </a>
        </div>
        <div class="col-2 next">
            <button class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: #1E90FF; color: #E31D1A">
                <a href="{{url('/save_draft/'.$request->app_type.'/'.$request->card.'/'.draft.'/'.draft)}}" style="text-decoration:none; color: white;">
                    {{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
                    Save Draft
                </a>
        </div>
        <div class="col-2 next">
            <button type="button" id="click_personal_particular" class=" btn btn-primary btn-lg btn-block" style=" background: #1E90FF; color: white;">Next
            </button>
            <button type="button" id="form_activation" data-toggle="modal" data-target="#code_activation_Modal" class=" btn btn-primary btn-lg btn-block" style=" background: #1E90FF; color: white; display: none;">
            </button>
        </div>

    </div>
        <input type="hidden" id="app_type" name="app_type" value="{{$request->app_type}}">
        <input type="hidden" id="card" name="card" value="{{$request->card}}">
    </form>

</div>


<!-- Modal -->
<div class="modal fade" id="code_activation_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verification Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                We have sent an SMS to your mobile number with a verification code. Please check your phone and enter the verification code below
                <input type="number" class="form-control" id="kode_activation" name="kode_activation" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="check_activation">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<script>
    $( document ).ready(function() {
        $( ".update_number" ).click(function() {
            $('#mobileno').removeAttr('readonly');
            $('#Phonemobileno').removeAttr('readonly');
        });
        function check_dekstop(){
            var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
            var data='';
            if (width < 640) {
                data = {!!  json_encode(phone) !!};
            }else{
                data = {!!  json_encode(desktop) !!};
            }
            return data;
        }
        if (check_dekstop() == {!!  json_encode(desktop) !!}){
            if ($('#mobileno').val() == "" || $('#mobileno').val() == '-' ){
                $('#mobileno').removeAttr('readonly');
            }
        }else{
            if ($('#Phonemobileno').val() == "" || $('#Phonemobileno').val() == '-' ) {
                $('#Phonemobileno').removeAttr('readonly');
            }
        }

        $( "#click_personal_particular" ).click(function() {
            var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
            if (width < 640){
                if($("#Phonemobileno").val() != ""){
                    if({!!  json_encode($personal->web) !!} == true ){
                        if (new Date($('#Phonewpexpirydate').val()) != "Invalid Date" ){
                            if ( new Date() >= new Date($('#Phonewpexpirydate').val())){
                                swal("Attention!", "Pass Expiration Date is up", "error")
                            }else{
                                create_activation();
                                // $("#submit_personal_particular").submit();
                            }
                        }else{
                            swal("Please!", "Input file Pass Expiry Date", "error")
                        }
                    }else{
                        create_activation();
                        // $("#submit_personal_particular").submit();
                    }
                }else{
                    swal("Attention!", "Phone number cannot be empty", "error")
                }

            }else{
                if($("#mobileno").val() != ""){
                    if({!!  json_encode($personal->web) !!} == true ){
                        if (new Date($('#wpexpirydate').val()) != "Invalid Date" ){
                            if ( new Date() >= new Date($('#wpexpirydate').val())){
                                swal("Attention!", "Pass Expiration Date is up", "error")
                            }else{
                                // $( "#form_activation" ).trigger( "click" );
                                create_activation();
                                // $("#submit_personal_particular").submit();
                            }
                        }else{
                            swal("Please!", "Input file Pass Expiry Date", "error")
                        }
                    }else{
                        // console.log(12')
                        // $( "#form_activation" ).trigger( "click" );
                        create_activation();
                        // $("#submit_personal_particular").submit();
                    }
                }else{
                    swal("Attention!", "Phone number cannot be empty", "error")
                }
            }

        });
        $( "#check_activation" ).click(function() {
            $.ajax({
                url: "{{ url('/ajax/check/activation') }}",
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: $('meta[name="csrf-token"]').attr('content'), activation:$("#kode_activation").val()},
                success: function (data) {
                    if (data == {!! json_encode(succes) !!}){
                        $("#submit_personal_particular").submit();
                    }else if (data == {!! json_encode(already_used) !!}){
                        swal("Attention!", "Activation code already used", "error")
                    }else{
                        swal("Attention!", "Wrong activation code", "error")
                    }
                }
            });
        });

    });

</script>
<script type="application/javascript">
    //refresh page on browser resize
    $(window).bind('resize', function(e)
    {
        this.location.reload(false); /* false to get page from cache */
        /* true to fetch page from server */
    });
    $(".logout_save_draft").click(function() {
        $("#logout_save_draft").val(true)
        window.location.href ='/save_draft/'+{!! json_encode($request->app_type) !!}+'/'+{!! json_encode($request->card) !!}+'/'+{!! json_encode(draft) !!}+'/'+$("#logout_save_draft").val();
    });

    function create_activation(eventDate){
        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        if (width < 640){
            var phone = $("#Phonemobileno").val();
        }else{
            var phone = $("#mobileno").val();
        }
        $.ajax({
            url: "{{ url('/ajax/sent/activation/phone') }}",
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: $('meta[name="csrf-token"]').attr('content'), phone:phone},
            success: function (data) {
                if (data == true){
                    $( "#form_activation" ).trigger( "click" );
                }else if(data == {!!  json_encode(not_number_singapore) !!}){
                    swal("Please!", "Use Singapore Number", "error")
                }else if(data == {!!  json_encode(wrong_format_number) !!}){
                    swal("Please!", "Wrong number format", "error")
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
