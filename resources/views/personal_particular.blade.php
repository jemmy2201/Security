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
                    <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                    @if (strlen($personal->name) > 40)
                        <div class="col-6 ColoumndataPersonal">{{substr($personal->name,0,40)}}<br>{{substr($personal->name,40)}}</div>
                    @else
                        <div class="col-6 ColoumndataPersonal">{{$personal->name}}</div>
                    @endif
                    <div class="w-100"></div>
                    <div class="col-0 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                    <div class="col-6 ColoumndataPersonal">{{$personal->nric}}</div>
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
     <div class="row">
        <div class="col HeaderdataPersonal email">
            Home Phone (Singapore numbers only)
        </div>
    </div>
    <div class="row">
        <div class="col-4 HeaderdataPersonal">
            <input type="text" class="form-control" id="mobileno" name="mobileno"  placeholder="0000000" value="{{$personal->mobileno}}" maxlength="8">
        </div>
    </div><br>
    <div class="row">
        @if($personal->web == true)
            <div class="col-4 HeaderdataPersonal expriydate">
                WP Expiry Date
            </div>
        @else
            <div class="col"></div>
        @endif
    </div>
    <div class="row">
        @if($personal->web == true)
            <div class="col-4 HeaderdataPersonal">
                <input type="date" class="form-control" id="wpexpirydate" name="wpexpirydate"  placeholder="dd-mm-yyyy" value="{{Carbon\Carbon::parse($personal->wpexpirydate)->format('Y-m-d')}}">
            </div>
        @else
            <div class="col-4">
            </div>
        @endif
    </div><br>
    <div class="row">
        <div class="col-6 HeaderdataPersonal phone">
            Mobile Phone (Singapore local HP only)
        </div>
    </div>
    <div class="row">
        <div class="col-4 HeaderdataPersonal">
            <input type="text" class="form-control" id="homeno" name="homeno"  placeholder="0000000" value="{{$personal->homeno}}" maxlength="8">
        </div>
    </div>
    <br ><br class="hidden-xs"><br class="hidden-xs">
    <div class="row">
        <div class="col-2 back">
            <button type="submit" class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: #E5E5E5; color: #E31D1A"> <a href="{{url("/home")}}" style="text-decoration:none;"><img src="{{URL::asset('/img/back.png')}}" style="width: 10%;"> Back</a> </button>
        </div>
        <div class="col-8 medium hidden-xs">
        </div>
        <div class="col-6 medium visible-xs hidden-md">
        </div>
        <div class="col-2 next">
            <button type="button" id="click_personal_particular" class=" btn btn-danger btn-lg btn-block">Next <img src="{{URL::asset('/img/next.png')}}" style="width: 10%;"></button>
        </div>
    </div>
        <input type="hidden" id="app_type" name="app_type" value="{{$request->app_type}}">
        <input type="hidden" id="card" name="card" value="{{$request->card}}">
    </form>

</div>

<script type="application/javascript">
    //refresh page on browser resize
    $(window).bind('resize', function(e)
    {
        this.location.reload(false); /* false to get page from cache */
        /* true to fetch page from server */
    });
    $( document ).ready(function() {
        $( "#click_personal_particular" ).click(function() {
{{--            console.log('ww',{!!  json_encode($personal->web) !!})--}}
        if({!!  json_encode($personal->web) !!} == true ){
            if (new Date($('#wpexpirydate').val()) != "Invalid Date"){
                if ( new Date() >= new Date($('#wpexpirydate').val())){
                        swal("Attention!", "Pass Expiration Date is up", "error")
                }else{
                    $("#submit_personal_particular").submit();
                }
            }else{
                swal("Please!", "Input file Pass Expiry Date", "error")
            }
        }else{
            $("#submit_personal_particular").submit();
        }
    });
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
